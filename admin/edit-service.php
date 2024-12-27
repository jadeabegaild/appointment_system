<?php
include('../includes/db.php');
session_start();

if (!isset($_GET['service_id'])) {
    header("Location: services.php");
    exit();
}

$service_id = $_GET['service_id'];

// Fetch service details
$stmt = $pdo->prepare("SELECT * FROM services WHERE service_id = ?");
$stmt->execute([$service_id]);
$service = $stmt->fetch();

if (!$service) {
    echo "Service not found!";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Update service details
    $update_stmt = $pdo->prepare("UPDATE services SET service_name = ?, description = ? WHERE service_id = ?");
    $update_stmt->execute([$name, $description, $service_id]);

    // Redirect back to the services page
    header("Location: services.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Edit Service Form -->
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Service</h1>
        <form method="POST">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Service Name</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($service['service_name']); ?>" 
                       class="block w-full mt-1 p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Service Description</label>
                <textarea name="description" id="description" rows="4" 
                          class="block w-full mt-1 p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required><?php echo htmlspecialchars($service['description']); ?></textarea>
            </div>

            <button type="submit" 
                    class="bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600 transition duration-300 shadow hover:shadow-lg">
                Save Changes
            </button>
            <a href="services.php" 
               class="ml-4 text-gray-500 hover:text-gray-800 hover:underline">
                Cancel
            </a>
        </form>
    </div>
</body>
</html>
