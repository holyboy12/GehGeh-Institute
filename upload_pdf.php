<?php
session_start();
$conn = new mysqli("localhost", "root", "", "student_portal");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define upload directory
$uploadDir = __DIR__ . "/uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // create uploads/ if not exists
}

$title = $_POST['title'];
$file = $_FILES['pdf_file']['name'];
$tmp = $_FILES['pdf_file']['tmp_name'];

// Sanitize filename
$safeName = preg_replace("/[^a-zA-Z0-9\.\-_]/", "_", $file);
$path = $uploadDir . $safeName;

if (move_uploaded_file($tmp, $path)) {
    $stmt = $conn->prepare("INSERT INTO pdf_files (title, filename, uploaded_by) VALUES (?, ?, ?)");
    $admin = "admin"; // Or use $_SESSION['admin'] if you stored login
    $stmt->bind_param("sss", $title, $safeName, $admin);
    if ($stmt->execute()) {
        echo "✅ PDF uploaded successfully. <a href='admin.php'>Go back</a>";
    } else {
        echo "❌ Database error: " . $stmt->error;
    }
} else {
    echo "❌ Error uploading PDF.";
}
?>
