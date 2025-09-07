<?php
$conn = new mysqli("localhost", "root", "", "student_portal");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fullname = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$matric = trim($_POST['matric'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm'] ?? '';

if (!$fullname || !$email || !$matric || !$password) {
    echo "<script>alert('All fields are required!'); window.history.back();</script>";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email format!'); window.history.back();</script>";
    exit;
}

if ($password !== $confirm) {
    echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO students (fullname, email, matric, password, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param("ssss", $fullname, $email, $matric, $hashed);

if ($stmt->execute()) {
    echo "<script>alert('Registration successful! You can now login.'); window.location='dashboard.php';</script>";
} else {
    echo "<script>alert('Error: Email or Matric already exists.'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
