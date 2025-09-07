<?php
// session_start();
// if (!isset($_SESSION['admin'])) {
//     header("Location: login.php");
//     exit();
// }

include "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $view_id = isset($_POST['view_id']) ? intval($_POST['view_id']) : 0;

    if ($view_id <= 0) {
        die("Invalid request.");
    }

    $stmt = $conn->prepare("DELETE FROM pdf_views WHERE view_id = ?");
    $stmt->bind_param("i", $view_id);

    if ($stmt->execute()) {
        echo "<script>alert('Log deleted successfully.'); window.location='admin.php';</script>";
    } else {
        echo "❌ Error deleting log: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
