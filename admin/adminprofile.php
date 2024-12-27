<?php
include('../includes/db.php');
include('../includes/top-bar.php');
// session_start();

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $contact_number = $_POST['contact_number'];
    $username = $_POST['username'];
    // $email = $_POST['password'];
    $email = $_POST['email'];

    // Update user info
    $stmt = $pdo->prepare("UPDATE user SET name = ?, contact_number = ?, username = ?, email = ? WHERE id = ?");
    $stmt->execute([$name, $contact_number, $username, $email, $user_id]);

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
            background-color: #78A617;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            color: white;
        }
        .form-container input:focus {
            border-color: #78A617;
            box-shadow: 0 0 0 3px rgba(120, 166, 23, 0.3);
        }
        .form-container button {
            background-color: black;
        }
        
        .success-message {
            color: #78A617;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body class="bg-white">

    <!-- Profile Section -->
    <div class="form-container mt-20 mx-auto px-4 py-6 max-w-lg w-full">
        <h2 class="text-2xl font-semibold text-center mb-6">Update Your Profile</h2>

        <?php if (!empty($message)): ?>
            <p class="success-message"><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST">
             <!-- Name Field -->
             <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-white">Name</label>
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
                <label for="username" class="block text-sm font-medium text-white">Contact Number</label>
                <input 
                    type="integer" 
                    name="contact_number" 
                    id="contact_number" 
                    value="<?php echo htmlspecialchars($user['contact_number']); ?>" 
                    class="block w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-green-300 transition-all"
                    required>
            </div>
            


            <!-- Username Field -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-white">Username</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    value="<?php echo htmlspecialchars($user['username']); ?>" 
                    class="block w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-green-300 transition-all"
                    required>
            </div>

             <!-- Email Field -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-white">Email Address</label>
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
                class="w-full py-3 text-white rounded-md hover:bg-gray-600 shadow hover:shadow-lg transition-shadow">
                Update Profile
            </button>
        </form>
    </div>

</body>
</html>
