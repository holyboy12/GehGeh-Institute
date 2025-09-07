<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: index.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "student_portal");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$student_id = $_SESSION['student_id'];

$stmt = $conn->prepare("SELECT result_id, course, score, grade, uploaded_at FROM results WHERE student_id=? ORDER BY uploaded_at DESC");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Results</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f9;
    margin: 0;
    padding: 0;
}
.container {
    max-width: 800px;
    margin: 30px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}
h2 {
    text-align: center;
    color: #8B4513;
    margin-bottom: 25px;
}
.result-card {
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px 20px;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.result-info {
    font-size: 14px;
    color: #333;
}
.download-btn {
    padding: 6px 12px;
    border: none;
    background: #8B4513;
    color: white;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    transition: 0.3s;
}
.download-btn:hover {
    background: #A0522D;
}
</style>
</head>
<body>
<div class="container">
    <h2>My Results</h2>

    <?php if($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="result-card">
                <div class="result-info">
                    <strong>Course:</strong> <?php echo htmlspecialchars($row['course']); ?><br>
                    <strong>Score:</strong> <?php echo htmlspecialchars($row['score']); ?><br>
                    <strong>Grade:</strong> <?php echo htmlspecialchars($row['grade']); ?><br>
                    <small>Uploaded: <?php echo $row['uploaded_at']; ?></small>
                </div>
                <a class="download-btn" href="download_result.php?id=<?php echo $row['result_id']; ?>">Download PDF</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">No results found.</p>
    <?php endif; ?>
</div>
<?php $conn->close(); ?>
</body>
</html>
