<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1000px;
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

    .section {
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    table, th, td {
      border: 1px solid #ddd;
    }

    th, td {
      padding: 10px;
      text-align: left;
    }

    th {
      background: #8B4513;
      color: white;
    }

    .form-box {
      background: #f9f9f9;
      padding: 15px;
      border-radius: 8px;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    button {
      padding: 10px 18px;
      border: none;
      background: #8B4513;
      color: white;
      font-size: 15px;
      font-weight: 600;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: #A0522D;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Admin Dashboard</h2>

    <!-- Complaints Section -->
    <div class="section">
      <h3>📌 Student Complaints</h3>
      <table>
        <tr>
          <th>FirstName</th>
          <th>LastName</th>
          <th>Department</th>
          <th>Faculty</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Nature of Complaint</th>
          <th>Message</th>
        </tr>
        <!-- Complaints will be fetched here -->
        <?php
          // Connect to DB
          $conn = new mysqli("localhost", "root", "", "student_portal");

          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          $result = $conn->query("SELECT * FROM complaints ORDER BY date DESC");

          while($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>".$row['firstname']."</td>
                      <td>".$row['lastname']."</td>
                      <td>".$row['department']."</td>
                      <td>".$row['faculty']."</td>
                      <td>".$row['email']."</td>
                      <td>".$row['phone']."</td>
                      <td>".$row['nature']."</td>
                      <td>".$row['message']."</td>
                    </tr>";
          }
          $conn->close();
        ?>
      </table>
    </div>

    <!-- Updates Section -->
    <div class="section">
      <h3>📝 Post Update</h3>
      <div class="form-box">
        <form action="post_update.php" method="POST">
          <label for="updateTitle">Update Title</label>
          <input type="text" id="updateTitle" name="title" required>

          <label for="updateContent">Update Content</label>
          <textarea id="updateContent" name="content" rows="4" required></textarea>

          <button type="submit">Publish Update</button>
        </form>
      </div>
    </div>

    <!-- Attendance Section -->
    <div class="section">
      <h3>📊 Attendance Records</h3>
  
      <!-- Download Button -->
      <form action="download_attendance.php" method="post">
        <button type="submit">⬇️ Download Attendance (CSV)</button>
      </form>

      <table>
        <tr>
          <th>Student Name</th>
          <th>Student ID</th>
          <th>Date</th>
          <th>Status</th>
          <th>Submitted At</th>
          <th>Action</th> <!-- New column for delete -->
        </tr>
        <?php
          $conn = new mysqli("localhost", "root", "", "student_portal");

          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }

          $result = $conn->query("SELECT * FROM attendance ORDER BY created_at DESC");

          while($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>".$row['studentName']."</td>
                      <td>".$row['studentID']."</td>
                      <td>".$row['date']."</td>
                      <td>".$row['status']."</td>
                      <td>".$row['created_at']."</td>
                      <td>
                        <form action='delete_attendance.php' method='POST' style='display:inline;'>
                          <input type='hidden' name='id' value='".$row['id']."'>
                          <button type='submit' onclick=\"return confirm('Are you sure you want to delete this record?');\"> Delete</button>
                        </form>
                      </td>
                    </tr>";
          }
          $conn->close();
        ?>
      </table>

    </div>
    <!-- PDF Upload Section -->
    <div class="section">
      <h3>📂 Upload PDF</h3>
      <form action="upload_pdf.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="PDF Title" required>
        <input type="file" name="pdf_file" accept="application/pdf" required>
        <button type="submit">Upload PDF</button>
      </form>

      <h4>PDF Access Logs</h4>
      <table>
          <tr>
              <th>Student</th>
              <th>PDF</th>
              <th>Opened At</th>
              <th>Action</th>
          </tr>
          <?php
          $conn = new mysqli("localhost", "root", "", "student_portal");
          if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

          $result = $conn->query("
              SELECT v.view_id, v.opened_at, v.student, p.title
              FROM pdf_views v
              JOIN pdf_files p ON p.pdf_id = v.pdf_id
              ORDER BY v.opened_at DESC
          ");

          while ($row = $result->fetch_assoc()): ?>
          <tr>
              <td><?php echo htmlspecialchars($row['student']); ?></td>
              <td><?php echo htmlspecialchars($row['title']); ?></td>
              <td><?php echo htmlspecialchars($row['opened_at']); ?></td>
              <td>
                  <form action="delete_pdf_log.php" method="POST" style="display:inline;">
                      <input type="hidden" name="view_id" value="<?php echo $row['view_id']; ?>">
                      <button type="submit" onclick="return confirm('Delete this log entry?');">🗑️ Delete</button>
                  </form>
              </td>
          </tr>
      <?php endwhile; ?>


          <!-- $conn->close();
          ?> -->
      </table>



    </div>

    <!-- Results Upload Section -->
    <div class="section">
      <h3>📊 Upload Results (CSV)</h3>
      <form action="upload_results.php" method="POST" enctype="multipart/form-data">
        <select name="student_id" required>
          <?php
          $students = $conn->query("SELECT id, fullname FROM students ORDER BY fullname");
          while($s = $students->fetch_assoc()) {
              echo "<option value='{$s['id']}'>{$s['fullname']}</option>";
          }
          ?>
        </select>
        <input type="file" name="result_file" accept="application/pdf" required>
        <button type="submit">Upload PDF Result</button>
      </form>

    </div>

   <a href="index.html"> <button>Logout</button></a> 

  </div>
</body>
</html>
