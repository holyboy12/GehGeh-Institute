<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: index.html");
    exit();
}

require('fpdf/fpdf.php'); // adjust path if needed

$conn = new mysqli("localhost", "root", "", "student_portal");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$result_id = intval($_GET['id']);
$student_id = $_SESSION['student_id'];

// Fetch the result for this student
$stmt = $conn->prepare("SELECT course, score, grade, uploaded_at FROM results WHERE result_id=? AND student_id=?");
$stmt->bind_param("ii", $result_id, $student_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 0) {
    die("Result not found.");
}

$row = $res->fetch_assoc();

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

// Title
$pdf->Cell(0,10,"Student Result",0,1,'C');
$pdf->Ln(10);

$pdf->SetFont('Arial','',12);
$pdf->Cell(50,10,"Student Name:",0,0);
$pdf->Cell(0,10,$_SESSION['student'],0,1);

$pdf->Cell(50,10,"Course:",0,0);
$pdf->Cell(0,10,$row['course'],0,1);

$pdf->Cell(50,10,"Score:",0,0);
$pdf->Cell(0,10,$row['score'],0,1);

$pdf->Cell(50,10,"Grade:",0,0);
$pdf->Cell(0,10,$row['grade'],0,1);

$pdf->Cell(50,10,"Uploaded At:",0,0);
$pdf->Cell(0,10,$row['uploaded_at'],0,1);

// Output PDF
$pdf->Output('D', 'Result_'.$row['course'].'.pdf');
$conn->close();
exit();
?>
