<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "day6_registration";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            echo "✅ Login successful! Welcome, " . $user["fullname"];
        } else {
            echo "❌ Invalid password.";
        }
    } else {
        echo "❌ No user found with that email.";
    }
}

$conn->close();
?>
