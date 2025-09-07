<?php
// connect.php - Database connection only
$servername = "localhost";
$username = "root";
$password = ""; // MySQL password
$database = "student_portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
?>
