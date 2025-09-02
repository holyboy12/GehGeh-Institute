<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "student_portal");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #a0522d, #8b4513);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 1500px;
            height: 800px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.25);
            overflow: hidden;
        }
        .subcon {
            background: #8B4513;
            color: white;
            text-align: center;
            padding: 18px;
        }
        .subcon h2 {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .updateslide {
            width: 100%;
            overflow: hidden;
            position: relative;
        }
        .slides {
            display: flex;
            width: 200%; 
            transition: transform 0.6s ease-in-out;
        }
        .slides h3 {
            width: 100%;
            flex-shrink: 0;
            text-align: center;
            padding: 60px 25px;
            font-size: 18px;
            color: #333;
            background: #f5deb3;
        }
        .button {
            display: flex;
            justify-content: center;
            gap: 12px;
            padding: 15px;
            background: #f9f9f9;
        }
        .button button {
            padding: 10px 18px;
            border: none;
            background: #8B4513;
            color: white;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }
        .button button:hover {
            background: #A0522D;
            transform: translateY(-2px);
        }
        .button button:active {
            transform: translateY(1px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="subcon">
            <h2>UPDATE</h2>
        </div>
        <div class="updateslide">
            <div class="slides" id="updateSlides">
                <h3>Loading updates...</h3>
            </div>
        </div>
        <div class="button">
            <button onclick="showOlder()">New</button>
            <button onclick="showNew()">Old</button>
        </div>
    </div>

    <script>
    const slides = document.querySelector(".slides");

    function showOlder() {
        slides.style.transform = "translateX(50%)";
    }
    function showNew() {
        slides.style.transform = "translateX(-40%)";
    }

    // Fetch updates via AJAX every 5 seconds
    function loadUpdates() {
        fetch("fetch_updates.php")
            .then(response => response.text())
            .then(data => {
                document.getElementById("updateSlides").innerHTML = data;
            });
    }

    loadUpdates(); // first load
    setInterval(loadUpdates, 5000); // auto-refresh every 5s
    </script>
</body>
</html>
