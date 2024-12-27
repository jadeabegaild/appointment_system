<?php
include('includes/db.php');
session_start();

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Fetch the user from the database
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on user role
            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
                exit();
            } elseif ($user['role'] === 'user') {
                header("Location: user/index.php");
                exit();
            } else {
                echo "Access Denied.";
                exit();
            }
        } else {
            $error_message = "Invalid username or password.";
        }
    } catch (Exception $e) {
        $error_message = "An error occurred. Please try again later.";
        error_log("Login error: " . $e->getMessage()); // Log the error
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function closeModal() {
            document.getElementById('errorModal').classList.add('hidden');
        }
    </script>
    <style>
        .custom-btn {
            background-color: #78A617;
            color: white;
        }

        .custom-btn:hover {
            background-color: #6b9115;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php if (!empty($error_message)) : ?>
        <div id="errorModal" class="modal">
            <div class="modal-content">
                <p class="text-red-600 font-bold"><?php echo htmlspecialchars($error_message); ?></p>
                <button onclick="closeModal()" class="custom-btn mt-4 px-4 py-2 rounded">Close</button>
            </div>
        </div>
    <?php endif; ?>

    <header class="bg-[#78A617] text-white py-4 shadow-md">
        <div class="container flex justify-between items-center px-4 mx-auto">
            <h1 class="text-4xl font-bold">MedPoint</h1>
            <nav>
                <ul class="flex space-x-6">
                    <li>
                        <a href="login.php"
                            class="px-4 py-2 rounded text-white hover:bg-black focus:bg-white transition duration-300">
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="register.php"
                            class="px-4 py-2 rounded text-white hover:bg-black focus:bg-white transition duration-300">
                            Register
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mx-auto mt-16 px-4 flex flex-col lg:flex-row items-center justify-center bg-white shadow-md rounded-lg overflow-hidden">
        <div class="w-full lg:w-1/2 bg-gray-200 flex items-center justify-center p-4">
            <img src="./assets/logo.png" alt="Logo Placeholder" class="w-full h-full object-cover max-w-[800px] max-h-[400px]">
        </div>

        <div class="w-full lg:w-1/2 p-8">
            <h1 class="text-center text-black text-4xl font-bold mb-4">Login</h1>
            <form method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" id="username"
                        class="block w-full mt-1 p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Username" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password"
                        class="block w-full mt-1 p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Password" required>
                </div>

                <button type="submit"
                    class="w-full custom-btn py-3 rounded-md hover:bg-black transition duration-300">Login</button>
            </form>

            <p class="text-center mt-4 text-sm text-gray-600">
                Don't have an account? <a href="register.php" class="text-blue-500 hover:underline">Register here</a>
            </p>
        </div>
    </div>
</body>

</html>
