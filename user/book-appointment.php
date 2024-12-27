<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // PHPMailer autoload
include('../includes/db.php'); 
include('../includes/user-navbar.php'); // Include the top navigation bar

// Assuming you have a session to check for logged-in user

// Fetch user data if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Fetch user data from the user table
    $stmt = $pdo->prepare("SELECT id, name, contact_number, email FROM user WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture the user's input
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $address = $_POST['address'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $service_name = $_POST['service_name'] ?? ''; // Default to an empty string if not set
    $appointment_date = $_POST['appointment_date'] ?? '';
    $history = $_POST['history'] ?? '';

    // Check if the required fields are provided
    if (!empty($first_name) && !empty($last_name) && !empty($address) && !empty($email) && !empty($contact_number) && !empty($service_name) && !empty($appointment_date)) {
        // Fetch the service_id based on the service_name
        $stmt = $pdo->prepare("SELECT service_id FROM services WHERE service_name = ?");
        $stmt->execute([$service_name]);
        $service = $stmt->fetch();

        if ($service) {
            // Insert appointment into the database with service_id instead of service_name
            $stmt = $pdo->prepare("INSERT INTO appointments (user_id, first_name, last_name, address, email, contact_number, service, appointment_date, history) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $first_name, $last_name, $address, $email, $contact_number, $service['service_id'], $appointment_date, $history]);

            echo "<div class='bg-green-100 text-green-700 border border-green-500 p-4 rounded mt-4'>Appointment successfully booked.</div>";
        } else {
            echo "<div class='bg-red-100 text-red-700 border border-red-500 p-4 rounded mt-4'>Selected service not found.</div>";
        }
    } else {
        echo "<div class='bg-red-100 text-red-700 border border-red-500 p-4 rounded mt-4'>Please fill all the required fields.</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    /* Enhance button hover effects */
    button:hover {
        background-color: #6b9115;
        transition: background-color 0.3s ease-in-out;
    }

    /* Input hover and focus effects */
    input:hover,
    textarea:hover,
    select:hover {
        border-color: #78A617;
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #78A617;
        box-shadow: 0 0 8px rgba(120, 166, 23, 0.5);
        outline: none;
    }

    /* Card shadow */
    .card-shadow {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Appointment Form -->
    <div class="container mx-auto mt-10 px-4">
        <div class="bg-white rounded-lg p-6 card-shadow">
            <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Book Your Appointment</h2>
            <form method="POST">
                <!-- User Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="first_name" class="block text-gray-700 font-medium mb-1">First Name</label>
                        <input type="text" name="first_name" id="first_name"
                            class="block w-full p-3 border border-gray-300 rounded-md" placeholder="First Name"
                            value="<?= isset($user) ? explode(' ', $user['name'])[0] : '' ?>" required>
                    </div>
                    <div>
                        <label for="last_name" class="block text-gray-700 font-medium mb-1">Last Name</label>
                        <input type="text" name="last_name" id="last_name"
                            class="block w-full p-3 border border-gray-300 rounded-md" placeholder="Last Name"
                            value="<?= isset($user) ? explode(' ', $user['name'])[1] : '' ?>" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="address" class="block text-gray-700 font-medium mb-1">Address</label>
                    <input type="text" name="address" id="address"
                        class="block w-full p-3 border border-gray-300 rounded-md" placeholder="Address" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="contact_number" class="block text-gray-700 font-medium mb-1">Contact Number</label>
                        <input type="text" name="contact_number" id="contact_number"
                            class="block w-full p-3 border border-gray-300 rounded-md" placeholder="Contact Number"
                            value="<?= isset($user) ? $user['contact_number'] : '' ?>" required>
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                        <input type="email" name="email" id="email"
                            class="block w-full p-3 border border-gray-300 rounded-md" placeholder="Email Address"
                            value="<?= isset($user) ? $user['email'] : '' ?>" required>
                    </div>
                </div>

                <!-- Service Dropdown -->
                <div class="mb-6">
                    <label for="service_name" class="block text-gray-700 font-medium mb-1">Select Service</label>
                    <select name="service_name" id="service_name" class="block w-full p-3 border border-gray-300 rounded-md" required>
                        <option value="">Select Service</option>
                        <?php
                        // Fetch available services from the database
                        $stmt = $pdo->query("SELECT * FROM services");
                        while ($service = $stmt->fetch()) {
                            echo "<option value='{$service['service_name']}'>{$service['service_name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- History -->
                <div class="mb-6">
                    <label for="history" class="block text-gray-700 font-medium mb-1">History of Checkups/Medications</label>
                    <textarea name="history" id="history" rows="4"
                        class="block w-full p-3 border border-gray-300 rounded-md"
                        placeholder="Describe any medical history"></textarea>
                </div>

                <!-- Appointment Date -->
                <div class="mb-6">
                    <label for="appointment_date" class="block text-gray-700 font-medium mb-1">Appointment Date</label>
                    <input type="datetime-local" name="appointment_date" id="appointment_date"
                        class="block w-full p-3 border border-gray-300 rounded-md" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 rounded-md text-white" style="background-color: #78A617;">Book Appointment</button>
            </form>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>

</html>
