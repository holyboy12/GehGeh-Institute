<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "student_portal");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get record ID from POST
$id = $_POST['id'];

// Delete record
$sql = "DELETE FROM attendance WHERE id='$id'";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Record deleted successfully!'); window.location='admin.php';</script>";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
