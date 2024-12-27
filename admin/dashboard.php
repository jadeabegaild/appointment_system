<?php

include('../includes/top-bar.php');
// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Redirect to login if not logged in as admin
    exit();
}

// Include your database connection
include('../includes/db.php');

// Query to count appointments by status (Accepted, Pending, Rejected)
$stmt_accepted = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'Accepted'");
$accepted_count = $stmt_accepted->fetchColumn();

$stmt_pending = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'Pending'");
$pending_count = $stmt_pending->fetchColumn();

$stmt_rejected = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'Rejected'");
$rejected_count = $stmt_rejected->fetchColumn();

$stmt_completed = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'Completed'");
$completed_count = $stmt_completed->fetchColumn();

// Fetch all appointments (for listing)
$stmt_all_appointments = $pdo->query("SELECT * FROM appointments ORDER BY appointment_id DESC");
$appointments = $stmt_all_appointments->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    /* Custom Styles */
    .nav-item:hover {
        background-color: #f1f5f9;
    }

    .container-card {
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .container-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .status-card:hover {
        background-color: #f1f5f9;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-link:hover {
        color: #006400;
        text-decoration: underline;
    }

    /* Table Styling */
    .table {
        border-collapse: collapse;
        width: 100%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .table th,
    .table td {
        padding: 12px 20px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    .table th {
        background-color: #f9fafb;
        font-weight: 600;
        color: #333;
    }

    .table tr:hover {
        background-color: #f1f5f9;
    }

    .table .action-link {
        color: #006400;
        transition: color 0.2s ease;
    }

    .table .action-link:hover {
        color: #02863b;
        text-decoration: underline;
    }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Main Container -->
    <div class="min-h-screen">

        <!-- Modals -->
        <div id="rejectModal"
            class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
            <div class="bg-white rounded-lg p-8 max-w-md mx-auto">
                <h3 class="text-xl font-semibold text-red-600">Confirm Rejection</h3>
                <p class="text-gray-800">Are you sure you want to reject this appointment?</p>
                <div class="mt-4 flex justify-end gap-2">
                    <button id="cancelRejectModal"
                        class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">Cancel</button>
                    <button id="confirmReject"
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Confirm</button>
                </div>
            </div>
        </div>

        <div id="acceptModal"
            class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
            <div class="bg-white rounded-lg p-8 max-w-md mx-auto">
                <h3 class="text-xl font-semibold text-green-600">Confirm Acceptance</h3>
                <p class="text-gray-800">Are you sure you want to accept this appointment?</p>
                <div class="mt-4 flex justify-end gap-2">
                    <button id="cancelAcceptModal"
                        class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">Cancel</button>
                    <button id="confirmAccept"
                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Confirm</button>
                </div>
            </div>
        </div>

        <div id="completeModal"
            class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
            <div class="bg-white rounded-lg p-8 max-w-md mx-auto">
                <h3 class="text-xl font-semibold text-blue-600">Confirm Completion</h3>
                <p class="text-gray-800">Are you sure you want to mark this appointment as completed?</p>
                <div class="mt-4 flex justify-end gap-2">
                    <button id="cancelCompleteModal"
                        class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">Cancel</button>
                    <button id="confirmComplete"
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Confirm</button>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="container mx-auto p-10 bg-black rounded-[30px] mt-[70px] shadow-lg">
            <!-- Welcome Section -->
            <div class="text-center mb-6 ">
                <h2 class="text-3xl font-semibold text-white mb-4">Welcome to the Admin Dashboard</h2>
                <p class="text-lg text-white italic">Here you can manage appointments and services efficiently.</p>
            </div>

            <!-- Appointment Categories -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="status-card container-card">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Accepted Appointments</h3>
                    <p class="text-4xl font-bold text-gray-900"><?php echo $accepted_count; ?></p>
                </div>
                <div class="status-card container-card">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Pending Appointments</h3>
                    <p class="text-4xl font-bold text-gray-900"><?php echo $pending_count; ?></p>
                </div>
                <div class="status-card container-card">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Rejected Appointments</h3>
                    <p class="text-4xl font-bold text-gray-900"><?php echo $rejected_count; ?></p>
                </div>
                <div class="status-card container-card">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Completed Appointments</h3>
                    <p class="text-4xl font-bold text-gray-900"><?php echo $completed_count; ?></p>
                </div>
            </div>
        </div>



        <div class="overflow-x-auto mt-10">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-[#78A617]">
                        <th class="px-4 py-2 text-sm font-semibold text-white">Appointment ID</th>
                        <th class="px-4 py-2 text-sm font-semibold text-white">Name</th>
                        <th class="px-4 py-2 text-sm font-semibold text-white">Appointment Date</th>
                        <th class="px-4 py-2 text-sm font-semibold text-white">Email</th>
                        <th class="px-4 py-2 text-sm font-semibold text-white">Status</th>
                        <th class="px-4 py-2 text-sm font-semibold text-white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($appointments) > 0): ?>
                    <?php foreach ($appointments as $appointment): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-800">
                            <?php echo htmlspecialchars($appointment['appointment_id']); ?>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-800">
                            <?php echo htmlspecialchars($appointment['first_name'] . ' ' . $appointment['last_name']); ?>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-800">
                            <?php echo htmlspecialchars($appointment['appointment_date']); ?>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-800">
                            <?php echo htmlspecialchars($appointment['email']); ?>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-800">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full <?php
                        echo $appointment['status'] == 'Pending' ? 'bg-yellow-200 text-yellow-800' :
                            ($appointment['status'] == 'Rejected' ? 'bg-red-200 text-red-800' :
                            'bg-green-200 text-green-800');
                    ?>">
                                <?php echo htmlspecialchars($appointment['status']); ?>
                            </span>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-800">
                            <div class="flex gap-2">
                                <button type="button"
                                    onclick="showModal('acceptModal', '<?php echo $appointment['appointment_id']; ?>', 'accept_appointment.php', 'Accepted')"
                                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Accept</button>
                                <button type="button"
                                    onclick="showModal('rejectModal', '<?php echo $appointment['appointment_id']; ?>', 'reject_appointment.php', 'Rejected')"
                                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Reject</button>
                                <button type="button"
                                    onclick="showModal('completeModal', '<?php echo $appointment['appointment_id']; ?>', 'completed_appointment.php', 'Completed')"
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Completed</button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-sm text-gray-600 py-3">No appointments found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    </div>

    <script>
    let appointmentId = null;
    let actionUrl = '';
    let statusValue = '';

    function showModal(modalId, id, url, status) {
        appointmentId = id;
        actionUrl = url;
        statusValue = status;
        document.getElementById(modalId).classList.remove('hidden');
    }

    document.getElementById('confirmReject').addEventListener('click', function() {
        submitForm('rejectModal');
    });

    document.getElementById('confirmAccept').addEventListener('click', function() {
        submitForm('acceptModal');
    });

    document.getElementById('confirmComplete').addEventListener('click', function() {
        submitForm('completeModal');
    });

    document.getElementById('cancelRejectModal').addEventListener('click', function() {
        document.getElementById('rejectModal').classList.add('hidden');
    });

    document.getElementById('cancelAcceptModal').addEventListener('click', function() {
        document.getElementById('acceptModal').classList.add('hidden');
    });

    document.getElementById('cancelCompleteModal').addEventListener('click', function() {
        document.getElementById('completeModal').classList.add('hidden');
    });

    function submitForm(modalId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = actionUrl;

        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'appointment_id';
        idInput.value = appointmentId;
        form.appendChild(idInput);

        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = statusValue;
        form.appendChild(statusInput);

        document.body.appendChild(form);
        form.submit();
        document.getElementById(modalId).classList.add('hidden');
    }
    </script>

</body>

</html>