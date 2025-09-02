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
        <a href="index.html"> <button>Logout</button></a>
      </div>
    </div>
  </div>
</body>
</html>
