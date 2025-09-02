<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "student_portal");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$studentName = $_POST['studentName'];
$studentID   = $_POST['studentID'];
$date        = $_POST['date'];
$status      = $_POST['status'];

// Insert into DB
$sql = "INSERT INTO attendance (studentName, studentID, date, status) 
        VALUES ('$studentName', '$studentID', '$date', '$status')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Attendance recorded successfully!'); window.location='dashboard.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
