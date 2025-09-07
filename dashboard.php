<?php
session_start();
if (!isset($_SESSION['student'])) {
    header("Location: index.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "student_portal");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$studentName = $_SESSION['student'];
$sql = "SELECT profile_image FROM students WHERE fullname='$studentName'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
/* General page setup */
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  background: linear-gradient(135deg, #8B4513, #D2691E);
}

/* Dashboard container */
.dash {
  padding: 20px;
}

/* Top bar */
.upper {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 25px;
  background: #fff;
  border-bottom: 2px solid #eaeaea;
  box-shadow: 0 4px 10px rgba(0,0,0,0.08);
  margin-bottom: 25px;
}

.upper h1 {
  font-size: 24px;
  color: #333;
  margin: 0;
  font-weight: 600;
}

.upper button {
  background: #f8e00b;
  color: #fff;
  border: none;
  padding: 10px 18px;
  border-radius: 8px;
  font-size: 15px;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.3s ease;
}

.upper button:hover {
  background: #ebfc05;
  box-shadow: 0 3px 8px rgba(0,0,0,0.2);
}

/* Each section sits below the other */
.secside {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 30px;
}

/* Card style */
.secside div {
  background: #fff;
  padding: 15px;
  text-align: center;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.secside div:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* Card image */
.secside img {
  width: 100%;
  max-width: 120px;
  height: auto;
  border-radius: 10px;
  margin-bottom: 10px;
}

/* Card title */
.secside h3 {
  margin: 0;
  font-size: 16px;
  color: #333;
  font-weight: 600;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
  .secside {
    grid-template-columns: 1fr;
  }
}

/* Animations */
@keyframes slideInLeft {
  from { transform: translateX(-100%); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}

@keyframes slideInRight {
  from { transform: translateX(100%); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}

.animate-left { animation: slideInLeft 1s ease-out forwards; }
.animate-right { animation: slideInRight 1s ease-out forwards; }
    </style>
</head>
<body>
    <div class="dash">
        <div class="upper">
            <h1>Welcome Back, <?php echo htmlspecialchars($studentName); ?>!</h1>
            <a href="logout.php"><button>Logout</button></a>
        </div>

        <section class="secside animate-left">
            <div class="sec1">
              <a href="#">
                  <img src="<?php echo $row['profile_image'] ? 'uploads/'.$row['profile_image'] : 'default.png'; ?>" 
                      alt="student image" 
                      style="width:120px;height:120px;border-radius:50%;object-fit:cover;">
                  <h3><?php echo htmlspecialchars($studentName); ?></h3>
              </a>

              <!-- Upload form -->
              <form action="upload_image.php" method="post" enctype="multipart/form-data">
                  <input type="file" name="profile_image" accept="image/*" required>
                  <button type="submit">Upload</button>
              </form>
            </div>

            <div class="sec2">
                <a href="complaint.html">
                    <img src="compliant icon.png" alt="image">
                    <h3>Complaint Form</h3>
                </a>
            </div>
        </section>

        <section class="secside animate-right">
            <div class="sec2">
                <a href="attendance.html">
                    <img src="attendanceicon.png" alt="student image">
                    <h3>Mark Attendance</h3>
                </a>
            </div>
            <div class="sec2">
                <a href="update.php">
                    <img src="updated icon.png" alt="image">
                    <h3>Get Updated</h3>
                </a>
            </div>
        </section>
        <section class="secside animate-left">
          <div class="sec2">
              <a href="student_pdfs.php">
                  <img src="pdficon.png" alt="pdf">
                  <h3>Get PDF</h3>
              </a>
          </div>
          <div class="sec2">
              <a href="student_results.php">
                  <img src="Resulticon.png" alt="result">
                  <h3>Check Result</h3>
              </a>
          </div>
        </section>

    </div>
</body>
</html>
