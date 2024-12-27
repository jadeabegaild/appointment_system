<?php 
include('includes/db.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO user (name, contact_number, email, username, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $contact_number, $email, $username, $password]);
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    /* Custom styles */
    .custom-btn {
        background-color: #78A617;
        color: white;
    }

    .custom-btn:hover {
        background-color: #6b9115;
    }

    .form-container {
        max-width: 500px;
        margin: auto;
        padding: 20px;
        border-radius: 8px;
        background-color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .heading {
        color: white;
    }

    /* Navigation link hover effects */
    .nav-link {
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-link:hover {
        background-color: #78A617;
        color: white;
    }
    .pic{
        background-color: rgba(255, 255, 255, 0.5);
    }
    </style>
</head>

<body  class="bg-cover bg-center bg-no-repeat pic" style="background-image: url('./assets/logo.png'); backdrop-filter: blur(5px);" >

    <!-- Header Navigation -->
    <header class="bg-[#78A617] text-white py-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-5xl font-bold heading">MedPoint</h1>
            <nav>
                <ul class="flex space-x-6">
                    <li>
                        <a href="login.php"
                            class="nav-link px-4 py-2 rounded text-white hover:bg-black hover:text-white focus:bg-white focus:text-white transition duration-300">
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="register.php"
                            class="nav-link px-4 py-2 rounded text-white hover:bg-black hover:text-white focus:bg-white focus:text-white transition duration-300">
                            Register
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Register Form -->
    <div class="form-container mt-10 shadow-md">
        <h2 class="text-center heading text-2xl font-semibold mb-6">Create Account</h2>
        <form method="POST">
            <!-- Full Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" name="name" id="name"
                    class="block w-full mt-1 p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="John Doe" required>
            </div>

            <!-- Contact Number -->
            <div class="mb-4">
                <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                <input type="text" name="contact_number" id="contact_number"
                    class="block w-full mt-1 p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="123-456-7890" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" id="email"
                    class="block w-full mt-1 p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="youremail@example.com" required>
            </div>

            <!-- Username -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username"
                    class="block w-full mt-1 p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Username" required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password"
                    class="block w-full mt-1 p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Password" required>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full custom-btn py-3 rounded-md text-white hover:bg-green-600 transition duration-300">Register</button>
        </form>

        <p class="text-center mt-4 text-sm text-gray-600">
            Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Login here</a>
        </p>
    </div>

</body>

</html>