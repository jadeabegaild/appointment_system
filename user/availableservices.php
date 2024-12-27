<?php
include('../includes/db.php');
include('../includes/user-navbar.php');
// session_start();

// Fetch services from the database
$stmt = $pdo->prepare("SELECT * FROM services"); // Replace 'services' with your table name
$stmt->execute();
$services = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Services</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 400px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="bg-gray-100">
    
    <!-- Services Section -->
    <main class="container mx-auto mt-10">
    <h2 class="text-3xl font-bold text-center text-green-700 mb-6">Our Available Services</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
        <?php foreach ($services as $service): ?>
            <div class="card bg-white rounded-lg shadow-md p-6 ">
                <h1 class="text-4xl font-semibold text-green-700 mb-2">
                    <?php echo htmlspecialchars($service['name']); // Replace 'name' with your column ?>
                </h1>
                <p class="text-black mb-2">
                    <?php echo htmlspecialchars($service['description']); // Replace 'description' with your column ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($services)): ?>
        <p class="text-center text-gray-600 mt-6">No services available at the moment. Please check back later!</p>
    <?php endif; ?>
</main>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
