<?php
$conn = new mysqli("localhost", "root", "", "student_portal");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT title, content FROM updates ORDER BY date DESC LIMIT 2");

$updates = [];
while ($row = $result->fetch_assoc()) {
    $updates[] = $row;
}

if (count($updates) < 2) {
    while (count($updates) < 2) {
        $updates[] = ["title" => "No Update Yet", "content" => ""];
    }
}

echo "<h3>" . htmlspecialchars($updates[1]['title']) . "<br><small>" . nl2br(htmlspecialchars($updates[1]['content'])) . "</small></h3>";
echo "<h3>" . htmlspecialchars($updates[0]['title']) . "<br><small>" . nl2br(htmlspecialchars($updates[0]['content'])) . "</small></h3>";
