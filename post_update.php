<?php
// Connect to DB
$conn = new mysqli("localhost", "root", "", "student_portal");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert update
$title = $_POST['title'];
$content = $_POST['content'];
$date = date("Y-m-d H:i:s");

$sql = "INSERT INTO updates (title, content, date) VALUES ('$title', '$content', '$date')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Update posted successfully!'); window.location='admin.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
