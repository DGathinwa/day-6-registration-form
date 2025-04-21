<?php
session_start(); // Start session first

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "day6_registration";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST["email"]);
    $password_input = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $fullname, $hashed_password);
        $stmt->fetch();

        if (password_verify($password_input, $hashed_password)) {
            // ✅ Set session variables
            $_SESSION["user_id"] = $user_id;
            $_SESSION["fullname"] = $fullname;

            // Redirect to a dashboard or welcome page
            header("Location: dashboard.php");
            exit();
        } else {
            echo "❌ Incorrect password.";
        }
    } else {
        echo "❌ Email not found.";
    }

    $stmt->close();
}
$conn->close();
?>
