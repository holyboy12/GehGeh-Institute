<?php
// Database connection
$servername = "localhost";  // usually "localhost"
$username = "root";         // your DB username
$password = "";             // your DB password
$dbname = "student_portal"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Collect form data
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$department = $_POST['Department'];
$faculty = $_POST['faculty'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$nature = $_POST['natureofcompliant'];
$message = $_POST['message'];

// Insert into database
$sql = "INSERT INTO complaints (firstname, lastname, department, faculty, email, phone, nature, message, date)
        VALUES ('$firstname', '$lastname', '$department', '$faculty', '$email', '$phone', '$nature', '$message', NOW())";

if ($conn->query($sql) === TRUE) {
    echo "✅ Complaint submitted successfully!";
} else {
    echo "❌ Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
