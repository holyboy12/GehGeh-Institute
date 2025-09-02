<?php
session_start();
$conn = new mysqli("localhost", "root", "", "student_portal");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['student'])) {
    header("Location: index.html");
    exit();
}

$studentName = $_SESSION['student'];

// Handle file upload
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = uniqid() . "_" . basename($_FILES["profile_image"]["name"]);
    $targetFile = $targetDir . $fileName;

    // Only allow image files
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowed = ["jpg", "jpeg", "png", "gif"];
    if (in_array($fileType, $allowed)) {
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
            // Save to database
            $sql = "UPDATE students SET profile_image='$fileName' WHERE fullname='$studentName'";
            $conn->query($sql);
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Only JPG, JPEG, PNG & GIF allowed.";
    }
} else {
    echo "No file uploaded.";
}
