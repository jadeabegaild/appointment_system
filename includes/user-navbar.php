<?php
// Check if the user is logged in as admin
session_start();
if ($_SESSION['role'] != 'user') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Navigation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<header class="bg-[#78A617] text-white py-4 shadow-md fixed top-0 left-0 w-full z-50">
    <div class="container mx-auto flex justify-between items-center px-4">
        <!-- Logo -->
        <h1 class="text-3xl md:text-5xl font-bold">MedPoint</h1>

        <!-- Hamburger Menu for Mobile -->
        <div class="md:hidden">
            <button id="menu-toggle" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav id="nav-menu" class="hidden md:flex flex-col md:flex-row md:space-x-6 bg-[#78A617] md:bg-transparent absolute md:static top-full left-0 w-full md:w-auto shadow-md md:shadow-none">
        <ul class="flex flex-col md:flex-row md:space-x-6">
            <li>
                <a href="../user/index.php" class="block px-4 py-2 rounded transition hover:bg-black hover:text-white">Home</a>
            </li>
            <li>
                <a href="../user/book-appointment.php" class="block px-4 py-2 rounded transition hover:bg-black hover:text-white">Book Appointment</a>
            </li>
            <li>
                <a href="../user/profile.php" class="block px-4 py-2 rounded transition hover:bg-black hover:text-white">Profile</a>
            </li>
            <li>
                <a href="../user/availableservices.php" class="block px-4 py-2 rounded transition hover:bg-black hover:text-white">Services</a>
            </li>
            <li>
                <a href="../user/team.php" class="block px-4 py-2 rounded transition hover:bg-black hover:text-white">Team</a>
            </li>
            <li>
                <a href="../logout.php" class="block px-4 py-2 rounded transition hover:bg-black hover:text-white">Logout</a>
            </li>
        </ul>
        </nav>
    </div>
</header>

Main Content
<main class="mt-20">
    <!-- Add your page content here -->
</main>

<script>
    // Toggle menu visibility on click
    document.getElementById('menu-toggle').addEventListener('click', () => {
        const navMenu = document.getElementById('nav-menu');
        navMenu.classList.toggle('hidden');
    });
</script>
</body>
</html>