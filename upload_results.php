<?php
// session_start();

// // 1️⃣ Check if admin is logged in
// if (!isset($_SESSION['admin'])) {
//     header("Location: index.html");
//     exit();
// }

// 2️⃣ Database connection
$conn = new mysqli("localhost", "root", "", "student_portal");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// 3️⃣ Check if form submitted
if (isset($_POST['student_id'], $_FILES['result_file'])) {

    $student_id = intval($_POST['student_id']);
    $file = $_FILES['result_file'];

    // 4️⃣ Validate student exists
    $stmt = $conn->prepare("SELECT fullname FROM students WHERE id=?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
        die("<script>alert('Student not found!'); window.location='admin.php';</script>");
    }
    $student = $res->fetch_assoc()['fullname'];

    // 5️⃣ Validate file type
    $allowed_types = ['application/pdf'];
    if (!in_array($file['type'], $allowed_types)) {
        die("<script>alert('Only PDF files are allowed!'); window.location='admin.php';</script>");
    }

    if ($file['error'] !== 0) {
        die("<script>alert('Error uploading file.'); window.location='admin.php';</script>");
    }

    // 6️⃣ Move file to uploads/results folder
    $upload_dir = __DIR__ . "/uploads/results/";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    // Unique filename: studentID_timestamp_originalname.pdf
    $filename = $student_id . "_" . time() . "_" . basename($file['name']);
    $filepath = $upload_dir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        die("<script>alert('Failed to save file.'); window.location='admin.php';</script>");
    }

    // 7️⃣ Insert into results table (course, score, grade empty for PDF)
    $stmt = $conn->prepare("INSERT INTO results (student_id, course, score, grade, uploaded_at, pdf_filename) VALUES (?, ?, ?, ?, NOW(), ?)");
    $course = ""; $score = ""; $grade = "";
    $stmt->bind_param("issss", $student_id, $course, $score, $grade, $filename);
    $stmt->execute();

    echo "<script>alert('PDF result uploaded successfully!'); window.location='admin.php';</script>";
    exit();

} else {
    echo "<script>alert('Please select a student and PDF file!'); window.location='admin.php';</script>";
    exit();
}

$conn->close();
?>
