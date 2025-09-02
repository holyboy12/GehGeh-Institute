<?php
$admin_password = "gehgeh124"; // your fixed admin password

if ($_POST['password'] === $admin_password) {
    echo "<script>alert('Admin login successful!'); window.location='admin.php';</script>";
} else {
    echo "<script>alert('Wrong admin password!'); window.history.back();</script>";
}
?>
