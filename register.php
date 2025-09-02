<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "student_portal");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form values
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$matric = $_POST['matric'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];

// Check password match
if ($password !== $confirm) {
    echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
    exit;
}

// Hash password for security
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Insert into DB
$sql = "INSERT INTO students (fullname, email, matric, password, created_at) 
        VALUES ('$fullname', '$email', '$matric', '$hashed', NOW())";


if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Registration successful! You can now login.'); window.location='dashboard.php';</script>";
} else {
    echo "<script>alert('Error: Email or Matric already exists.'); window.history.back();</script>";
}

$conn->close();
?>
