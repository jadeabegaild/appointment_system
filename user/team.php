<?php
include('../includes/user-navbar.php'); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 10px;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
    }

    .image-container {
        width: 400px;
        height: 400px;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Top Navigation -->


    <!-- Team Section -->
    <main class="container mx-auto mt-10">
        <h2 class="text-6xl font-bold text-center text-green-700 mb-6">Meet Our Team</h2>

        <!-- Flex Container for Team Members (3 Columns) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 justify-center">

            <!-- Team Member 2 -->
            <div class="card bg-white p-6 rounded-lg shadow-md hover:shadow-xl">
                <div class="flex flex-col items-center">
                    <div class="image-container mb-6">
                        <img src="../assets/img8.jpg" alt="Kenneth V. Inciong">
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-800">INCIONG, KENNETH V.</h3>
                        <p class="text-gray-600 mb-2"><strong>Contact Number:</strong> 09238647234</p>
                        <p class="text-gray-600 mb-2"><strong>Facebook:</strong> <a
                                href="https://www.facebook.com/KennethInciong" class="text-blue-500"
                                target="_blank">Kenneth Inciong</a></p>
                        <p class="text-gray-600 mb-2"><strong>LinkedIn:</strong> <a
                                href="https://www.linkedin.com/in/kenneth-inciong" class="text-blue-500"
                                target="_blank">Kenneth Inciong LinkedIn</a></p>
                        <p class="text-gray-600 mb-2"><strong>Email:</strong> inciongkennethv@gmail.com</p>
                    </div>
                </div>
            </div>
            <!-- Team Member 1 -->
            <div class="card bg-white p-6 rounded-lg shadow-md hover:shadow-xl">
                <div class="flex flex-col items-center">
                    <div class="image-container mb-6">
                        <img src="../assets/img6.png" alt="Jade Abegail Datinguinoo">
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-800">DATINGUINOO, JADE ABEGAIL A.</h3>
                        <p class="text-gray-600 mb-2"><strong>Contact Number:</strong> 091531281908</p>
                        <p class="text-gray-600 mb-2"><strong>Facebook:</strong> <a
                                href="https://www.facebook.com/JadeAbegailDatinguinoo" class="text-blue-500"
                                target="_blank">Jade Abegail Datinguinoo</a></p>
                        <p class="text-gray-600 mb-2"><strong>LinkedIn:</strong> <a
                                href="https://www.linkedin.com/in/jade-abegail-datinguinoo" class="text-blue-500"
                                target="_blank">Jade Abegail LinkedIn</a></p>
                        <p class="text-gray-600 mb-2"><strong>Email:</strong> datinguinoojadeabegail@gmail.com</p>
                    </div>
                </div>
            </div>



            <!-- Team Member 3 -->
            <div class="card bg-white p-6 rounded-lg shadow-md hover:shadow-xl">
                <div class="flex flex-col items-center">
                    <div class="image-container mb-6">
                        <img src="../assets/img7.jpg" alt="Manolo A. Alejo">
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-800">ALEJO, MANOLO A.</h3>
                        <p class="text-gray-600 mb-2"><strong>Contact Number:</strong> 09986427643</p>
                        <p class="text-gray-600 mb-2"><strong>Facebook:</strong> <a
                                href="https://www.facebook.com/ManoloAlejo" class="text-blue-500" target="_blank">Manolo
                                Alejo</a></p>
                        <p class="text-gray-600 mb-2"><strong>LinkedIn:</strong> <a
                                href="https://www.linkedin.com/in/manolo-alejo" class="text-blue-500"
                                target="_blank">Manolo Alejo LinkedIn</a></p>
                        <p class="text-gray-600 mb-2"><strong>Email:</strong> manoloalejo@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php include('../includes/footer.php'); ?>
</body>

</html>