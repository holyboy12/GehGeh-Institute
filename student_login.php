<?php
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "student_portal");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form inputs safely
$email = $_POST['email'];
$password = $_POST['password'];

// Check if email exists
$sql = "SELECT * FROM students WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
        // ✅ Save both student name and student_id
        $_SESSION['student'] = $row['fullname'];
        $_SESSION['student_id'] = $row['id'];  

        echo "<script>alert('Login successful!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Invalid password!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('No account found with this email!'); window.history.back();</script>";
}

$conn->close();
?>
