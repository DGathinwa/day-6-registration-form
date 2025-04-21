<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login if user is not logged in
    header("Location: login.html");
    exit();
}

echo "<h1>Welcome to your Dashboard, " . $_SESSION['email'] . "</h1>";
echo "<a href='logout.php'>Logout</a>";
?>
