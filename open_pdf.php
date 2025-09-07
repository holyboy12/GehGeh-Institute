<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: index.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "student_portal");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$pdf_id = intval($_GET['id']);
$student_id = $_SESSION['student_id'];

// Log open
$stmt = $conn->prepare("INSERT INTO pdf_logs (student_id, pdf_id) VALUES (?, ?)");
$stmt->bind_param("ii", $student_id, $pdf_id);
$stmt->execute();

// Get file
$stmt2 = $conn->prepare("SELECT filename FROM pdf_files WHERE pdf_id=?");
$stmt2->bind_param("i", $pdf_id);
$stmt2->execute();
$stmt2->bind_result($filename);
$stmt2->fetch();
$stmt2->close();

// Full server path + URL
$filePath = __DIR__ . "/uploads/" . $filename;   // C:\xampp\htdocs\GehGeh-Institute\uploads\filename.pdf
$fileUrl  = "uploads/" . $filename;              // relative URL

if (file_exists($filePath)) {
    header("Location: " . $fileUrl);
    exit();
} else {
    echo "❌ File not found on server: " . htmlspecialchars($filePath);
}
?>
