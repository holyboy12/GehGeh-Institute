<?php
session_start();
if (!isset($_SESSION['student'])) {
    header("Location: index.html");
    exit();
}

include "connect.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$download = isset($_GET['download']);

if ($id <= 0) die("❌ Invalid file.");

// Fetch PDF info
$stmt = $conn->prepare("SELECT * FROM pdf_files WHERE pdf_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$pdf = $result->fetch_assoc();

if (!$pdf) die("❌ File not found.");

// Log view/download
$student = $_SESSION['student']; // full name
$stmt2 = $conn->prepare("INSERT INTO pdf_views (pdf_id, student, opened_at) VALUES (?, ?, NOW())");
$stmt2->bind_param("is", $id, $student);
$stmt2->execute();


// Serve file
$filePath = __DIR__ . "/uploads/" . $pdf['filename'];
if (!file_exists($filePath)) die("❌ File not found on server.");

if ($download) {
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . basename($filePath) . "\"");
} else {
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=\"" . basename($filePath) . "\"");
}

readfile($filePath);
exit();
?>
