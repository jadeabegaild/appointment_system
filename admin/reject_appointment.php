<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Load PHPMailer
include('../includes/db.php'); // Database connection

session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate that appointment_id is provided
    if (!isset($_POST['appointment_id']) || empty($_POST['appointment_id'])) {
        echo "Invalid appointment ID.";
        exit();
    }

    $appointment_id = $_POST['appointment_id'];

    // Fetch appointment and user details
    $stmt = $pdo->prepare("
        SELECT a.appointment_id, a.appointment_date, a.service, a.status, a.first_name, a.last_name, a.email 
        FROM appointments a 
        WHERE a.appointment_id = ?
    ");
    $stmt->execute([$appointment_id]);
    $appointment = $stmt->fetch();

    if (!$appointment) {
        echo "Invalid appointment ID.";
        exit();
    }

    // Update appointment status to 'accepted'
    $stmt = $pdo->prepare("UPDATE appointments SET status = 'rejected' WHERE appointment_id = ?");
    $stmt->execute([$appointment_id]);

    // Send confirmation email
    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail's SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'jadeabegaild@gmail.com'; // Your Gmail address
        $mail->Password = 'vivb ydqu kkdn hydh'; // Gmail password or App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email content
        $mail->setFrom('jadeabegaild@gmail.com', 'Admin');
        $mail->addAddress($appointment['email']); // Recipient's email
        $mail->Subject = 'Appointment Rejected';
        $mail->Body = "Dear " . $appointment['first_name'] . " " . $appointment['last_name'] . ",\n\n"
            . "Your appointment on " . $appointment['appointment_date'] . " has been rejected.\n\n"
            . "Thank you!";

        $mail->send();
        echo "<script>
        document.getElementById('rejectModal').classList.remove('hidden');
      </script>";

} catch (Exception $e) {
echo "Failed to send email. Mailer Error: " . $mail->ErrorInfo;
}

header("Location: dashboard.php"); // Replace with your actual dashboard URL
    exit();
    
} else {
echo "Invalid request.";
}