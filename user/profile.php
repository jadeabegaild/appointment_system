<?php
include('../includes/db.php');
include('../includes/user-navbar.php');
// session_start();

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $contact_number = $_POST['contact_number'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Update user info
    $stmt = $pdo->prepare("UPDATE user SET name = ?, contact_number = ?, username = ?, password = ?, email = ? WHERE id = ?");
    $stmt->execute([$name, $contact_number, $username, $password, $email, $user_id]);

    $message = "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            color: #78A617;
        }
        .form-container input:focus {
            border-color: #78A617;
            box-shadow: 0 0 0 3px rgba(120, 166, 23, 0.3);
        }
        .form-container button {
            background-color: #78A617;
        }
        .form-container button:hover {
            background-color: #6b9115;
        }
        .success-message {
            color: #78A617;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Profile Section -->
    <div class="form-container mt-16">
        <h2 class="text-2xl font-semibold text-center mb-6">Update Your Profile</h2>

        <?php if (!empty($message)): ?>
            <p class="success-message"><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST">
             <!-- Name Field -->
             <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="<?php echo htmlspecialchars($user['name']); ?>" 
                    class="block w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-green-300 transition-all"
                    required>
            </div>

             <!-- Contact Number Field -->
             <div class="mb-4">
                <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                <input 
                    type="text" 
                    name="contact_number" 
                    id="contact_number" 
                    value="<?php echo htmlspecialchars($user['contact_number']); ?>" 
                    class="block w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-green-300 transition-all"
                    required>
            </div>
             <!-- Username Field -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    value="<?php echo htmlspecialchars($user['username']); ?>" 
                    class="block w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-green-300 transition-all"
                    required>
            </div>

             <!-- Password Field -->
             <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    value="<?php echo htmlspecialchars($user['password']); ?>" 
                    class="block w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-green-300 transition-all"
                    required>
            </div>

            <!-- Email Field -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="<?php echo htmlspecialchars($user['email']); ?>" 
                    class="block w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-green-300 transition-all"
                    required>
            </div>

            <!-- Update Button -->
            <button 
                type="submit" 
                class="w-full py-3 text-white rounded-md shadow hover:shadow-lg transition-shadow">
                Update Profile
            </button>
        </form>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
