<?php
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "student_portal");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form inputs
$email = $_POST['email'];
$password = $_POST['password'];

// Check if email exists
$sql = "SELECT * FROM students WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['student'] = $row['fullname'];
        echo "<script>alert('Login successful!'); window.location='dashboard.html';</script>";
    } else {
        echo "<script>alert('Invalid password!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('No account found with this email!'); window.history.back();</script>";
}

$conn->close();
?>
