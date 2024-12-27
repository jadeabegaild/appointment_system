<?php
// Include necessary files
require '../vendor/autoload.php';
include('../includes/db.php');

$stmt = $pdo->query("SELECT appointments.appointment_id, appointments.appointment_date, services.service_name, 
                     user.name, user.contact_number, user.email, appointments.history, appointments.status
                     FROM appointments
                     JOIN services ON appointments.service = services.service_name  -- Correct join on service_id
                     JOIN user ON appointments.user_id = user.id");



$appointments = $stmt->fetchAll();


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $new_status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $appointment_id]);

    header("Location: appointments.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
    /* Custom container styles */
    .content-container {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .content-container h1 {
        color: #333;
    }

    .content-container table {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
    }
    </style>
    <script>
    // Function to print specific appointment sections
    function printSection(sectionId) {
        const printContents = document.getElementById(sectionId).innerHTML;
        const originalContents = document.body.innerHTML;

        // Print and restore original page content
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
    </script>
</head>

<body class="bg-gray-100">
    <!-- Top Navigation Bar -->
    <?php include('../includes/top-bar.php'); ?>

    <!-- Appointments Content -->
    <div class="max-w-7xl mx-auto mt-10 px-6">
        <div class="content-container">
            <div id="appointments-container">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-semibold">Accepted Appointments</h1>
                    <button onclick="printSection('accepted-appointments')"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Print
                    </button>
                </div>
                <div id="accepted-appointments">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border">
                            <thead>
                                <tr class="bg-gray-200 text-gray-700">
                                    <th class="border p-2 text-left">ID</th>
                                    <th class="border p-2 text-left">First Name</th>
                                    <th class="border p-2 text-left">Last Name</th>
                                    <th class="border p-2 text-left">Contact</th>
                                    <th class="border p-2 text-left">Email</th>
                                    <th class="border p-2 text-left">Appointment Date</th>
                                    <th class="border p-2 text-left">Service</th>
                                    <th class="border p-2 text-left">History</th>
                                    <th class="border p-2 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                        $sql = "SELECT * FROM appointments WHERE status = 'Accepted'";
                        $stmt = $pdo->query($sql);

                        if ($stmt) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "
                                <tr>
                                    <td>" . htmlspecialchars($row["appointment_id"]) . "</td>
                                    <td>" . htmlspecialchars($row["first_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["last_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["contact_number"]) . "</td>
                                    <td>" . htmlspecialchars($row["email"]) . "</td>
                                    <td>" . htmlspecialchars($row["appointment_date"]) . "</td>
                                    <td>" . htmlspecialchars($row["service_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["history"]) . "</td>
                                    <td>" . htmlspecialchars($row["status"]) . "</td>
                                </tr>
                                ";
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>No appointments found.</td></tr>";
                        }
                        ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto mt-10 px-6">
        <div class="content-container">
            <div id="appointments-container">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-semibold">Pending Appointments</h1>
                    <button onclick="printSection('pending-appointments')"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Print
                    </button>
                </div>
                <div id="pending-appointments">
                    <table class="min-w-full table-auto border">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="border p-2 text-left">ID</th>
                                <th class="border p-2 text-left">First Name</th>
                                <th class="border p-2 text-left">Last Name</th>
                                <th class="border p-2 text-left">Contact</th>
                                <th class="border p-2 text-left">Email</th>
                                <th class="border p-2 text-left">Appointment Date</th>
                                <th class="border p-2 text-left">Service</th>
                                <th class="border p-2 text-left">History</th>
                                <th class="border p-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        $sql = "SELECT * FROM appointments WHERE status = 'Pending'";
                        $stmt = $pdo->query($sql);

                        if ($stmt) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "
                                <tr>
                                    <td>" . htmlspecialchars($row["appointment_id"]) . "</td>
                                    <td>" . htmlspecialchars($row["first_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["last_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["contact_number"]) . "</td>
                                    <td>" . htmlspecialchars($row["email"]) . "</td>
                                    <td>" . htmlspecialchars($row["appointment_date"]) . "</td>
                                    <td>" . htmlspecialchars($row["service"]) . "</td>
                                    <td>" . htmlspecialchars($row["history"]) . "</td>
                                    <td>" . htmlspecialchars($row["status"]) . "</td>
                                </tr>
                                ";
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>No appointments found.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto mt-10 px-6">
        <div class="content-container">
            <div id="appointments-container">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-semibold">Rejected Appointments</h1>
                    <button onclick="printSection('rejected-appointments')"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Print
                    </button>
                </div>
                <div id="rejected-appointments">
                    <table class="min-w-full table-auto border">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="border p-2 text-left">ID</th>
                                <th class="border p-2 text-left">First Name</th>
                                <th class="border p-2 text-left">Last Name</th>
                                <th class="border p-2 text-left">Contact</th>
                                <th class="border p-2 text-left">Email</th>
                                <th class="border p-2 text-left">Appointment Date</th>
                                <th class="border p-2 text-left">Service</th>
                                <th class="border p-2 text-left">History</th>
                                <th class="border p-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        $sql = "SELECT * FROM appointments WHERE status = 'Rejected'";
                        $stmt = $pdo->query($sql);

                        if ($stmt) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "
                                <tr>
                                    <td>" . htmlspecialchars($row["appointment_id"]) . "</td>
                                    <td>" . htmlspecialchars($row["first_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["last_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["contact_number"]) . "</td>
                                    <td>" . htmlspecialchars($row["email"]) . "</td>
                                    <td>" . htmlspecialchars($row["appointment_date"]) . "</td>
                                    <td>" . htmlspecialchars($row["service"]) . "</td>
                                    <td>" . htmlspecialchars($row["history"]) . "</td>
                                    <td>" . htmlspecialchars($row["status"]) . "</td>
                                </tr>
                                ";
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>No appointments found.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto mt-10 px-6">
        <div class="content-container">
            <div id="appointments-container">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-semibold">Completed Appointments</h1>
                    <button onclick="printSection('completed-appointments')"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Print
                    </button>
                </div>
                <div id="completed-appointments">
                    <table class="min-w-full table-auto border">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="border p-2 text-left">ID</th>
                                <th class="border p-2 text-left">First Name</th>
                                <th class="border p-2 text-left">Last Name</th>
                                <th class="border p-2 text-left">Contact</th>
                                <th class="border p-2 text-left">Email</th>
                                <th class="border p-2 text-left">Appointment Date</th>
                                <th class="border p-2 text-left">Service</th>
                                <th class="border p-2 text-left">History</th>
                                <th class="border p-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        $sql = "SELECT * FROM appointments WHERE status = 'Completed'";
                        $stmt = $pdo->query($sql);

                        if ($stmt) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "
                                <tr>
                                    <td>" . htmlspecialchars($row["appointment_id"]) . "</td>
                                    <td>" . htmlspecialchars($row["first_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["last_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["contact_number"]) . "</td>
                                    <td>" . htmlspecialchars($row["email"]) . "</td>
                                    <td>" . htmlspecialchars($row["appointment_date"]) . "</td>
                                    <td>" . htmlspecialchars($row["service"]) . "</td>
                                    <td>" . htmlspecialchars($row["history"]) . "</td>
                                    <td>" . htmlspecialchars($row["status"]) . "</td>
                                </tr>
                                ";
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>No appointments found.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</body>

</html>