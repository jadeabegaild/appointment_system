<?php
include('../includes/db.php');

// Handle form submission for adding a service
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_service'])) {
    $service_name = $_POST['name'];
    $description = $_POST['description'];

    try {
        // Insert service into the database
        $stmt = $pdo->prepare("INSERT INTO services (name, description) VALUES (?, ?)");
        $stmt->execute([$service_name, $description]);

        // Redirect to services page
        header('Location: services.php');
        exit();
    } catch (PDOException $e) {
        echo "<p class='text-red-500'>Database Error: " . $e->getMessage() . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <?php include('../includes/top-bar.php'); ?>

    <!-- Add Service Page -->
    <div class="max-w-4xl mx-auto mt-10">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Add New Service</h1>

        <div class="p-6 bg-white shadow-lg rounded-lg">
            <form method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Service Name</label>
                    <input type="text" name="name" id="name" class="block w-full mt-1 p-3 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500" placeholder="Enter Service Name" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4" class="block w-full mt-1 p-3 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500" placeholder="Enter Service Description" required></textarea>
                </div>
                <button type="submit" name="add_service" class="w-full bg-green-500 text-white py-3 rounded-md hover:bg-green-600 transition duration-300">Add Service</button>
            </form>
        </div>
    </div>
</body>
</html>
