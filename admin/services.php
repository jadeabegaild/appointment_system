<?php
include('../includes/db.php');
include('../includes/top-bar.php');

// Fetch all services to display
$stmt = $pdo->query("SELECT * FROM services");
$services = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
    <!-- Services Page -->
    <div class="max-w-7xl mx-auto py-10">
        <div class="p-6 bg-gray-100 rounded-lg shadow-lg relative">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-bold text-black">Available Services</h1>
                <!-- Add New Service Button -->
                <a href="add-service.php" class="bg-[#78A617] text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300 shadow hover:shadow-lg">
                    Add New Service
                </a>
            </div>

            <!-- Display Existing Services -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($services as $service) { ?>
                    <div class="bg-white border border-gray-200 rounded-lg shadow-md p-5 hover:shadow-lg transition duration-300 relative">
                        <h1 class="text-4xl font-semibold mb-2 text-gray-800"><?php echo htmlspecialchars($service['service_name']); ?></h1>
                        <p class="text-black mb-4"><?php echo htmlspecialchars($service['description']); ?></p>
                        <!-- Edit Button -->
                        <a href="edit-service.php?service_id=<?php echo $service['service_id']; ?>" 
                           class="absolute bottom-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300 shadow hover:shadow-lg">
                            Edit
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
