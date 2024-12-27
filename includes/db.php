<?php
$host = 'localhost';
$dbname = 'appointment_system';
$username = 'root';  // Change if using a different database username
$password = '';      // Change if using a different password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
