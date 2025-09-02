<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "student_portal");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// File headers to force download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=attendance_records.csv');

// Open PHP output stream
$output = fopen("php://output", "w");

// Add column headers
fputcsv($output, array('Student Name', 'Student ID', 'Date', 'Status', 'Submitted At'));

// Fetch records
$result = $conn->query("SELECT * FROM attendance ORDER BY created_at DESC");

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$conn->close();
?>
