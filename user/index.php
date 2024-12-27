<?php
// index.php

include('../includes/db.php');
include('../includes/user-navbar.php'); // Include top bar
// session_start();

$user_id = $_SESSION['user_id'];

// Fetch the admin user data from the database
$stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Check if the user exists
if (!$user) {
    die("Admin profile not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Appointment System</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <style>
    /* Adjusting Swiper container to match the screen size of Aspire 3 (1366x768) */
    .swiper-container {
        width: 100%;
        /* Adjust width */
        height: 90vh;
        /* Adjust height to fit the screen */
    }

    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Ensures the image fills the container while maintaining aspect ratio */
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.5);
        /* White with 10% opacity */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        z-index: 10;
    }


    .overlay h1 {
        font-size: 7rem;
        font-weight: bold;
        margin-bottom: 1rem;
        color: black;
        font-style: italic;
    }

    .overlay p {
        font-size: 1.25rem;
        font-weight: normal;
        margin-top: 0.5rem;
        
        color: black;
        /* Italicize the phrase */
    }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Include User Navbar -->
   

    <!-- Swiper Carousel -->
    <div class="swiper-container relative">
        <!-- Overlay -->
        <div class="overlay">
            <h1>Welcome to MedPoint</h1>
            <p>Your seamless appointment booking experience starts here. Book with ease, anytime, anywhere.</p>
        </div>

        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <img src="../assets/img1.jpg" alt="Slide 1">
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide">
                <img src="../assets/img2.jpg" alt="Slide 2">
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide">
                <img src="../assets/img3.jpg" alt="Slide 3">
            </div>
            <!-- Slide 4 -->
            <div class="swiper-slide">
                <img src="../assets/img4.jpg" alt="Slide 4">
            </div>
            <!-- Slide 5 -->
            <div class="swiper-slide">
                <img src="../assets/img5.jpg" alt="Slide 5">
            </div>
        </div>

        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>

        <!-- Add Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <!-- Initialize Swiper JS -->
    <script>
    const swiper = new Swiper('.swiper-container', {
        loop: true, // Infinite loop
        autoplay: {
            delay: 3000, // 3 seconds for auto sliding
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
    </script>

    <!-- Include Footer -->
    <?php include('../includes/footer.php'); ?>
</body>

</html>