<?php
session_start();
if (!isset($_SESSION['student'])) {
    header("Location: index.html");
    exit();
}

include "connect.php"; // Ensure this is your DB connection file

// Fetch all PDFs
$result = $conn->query("SELECT * FROM pdf_files ORDER BY uploaded_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available PDFs</title>
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
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background: #f9f9f9;
            margin-bottom: 12px;
            padding: 12px 15px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #ddd;
        }

        li a.view-link {
            text-decoration: none;
            color: #8B4513;
            font-weight: 600;
        }

        li a.view-link:hover {
            color: #A0522D;
        }

        .download-btn {
            padding: 6px 12px;
            border: none;
            background: #8B4513;
            color: white;
            font-size: 14px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
        }

        .download-btn:hover {
            background: #A0522D;
        }

        .pdf-info {
            font-size: 13px;
            color: #555;
        }

        .pdf-title {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Available PDFs</h2>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <div class="pdf-title">
                    <a class="view-link" href="download_pdf.php?id=<?php echo $row['pdf_id']; ?>">
                        <?php echo htmlspecialchars($row['title']); ?>
                    </a>
                    <div class="pdf-info">Uploaded: <?php echo $row['uploaded_at']; ?></div>
                </div>
                <a class="download-btn" href="download_pdf.php?id=<?php echo $row['pdf_id']; ?>&download=1">Download</a>
            </li>
        <?php endwhile; ?>
    </ul>
</div>
</body>
</html>
