<?php
// Database connection settings
$host = "localhost";
$user = "root";     // default XAMPP user
$pass = "";         // default XAMPP password (empty)
$dbname = "iot_virtual_network";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
