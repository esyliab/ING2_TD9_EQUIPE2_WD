<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "11bis@Djaze";
$dbname = "ECE_Social_Media";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $update_stmt = $conn->prepare("UPDATE Users SET is_active = FALSE WHERE user_id = ?");
    $update_stmt->bind_param("i", $user_id);
    $update_stmt->execute();
    $update_stmt->close();
}

session_destroy();

$conn->close();

header("Location: menu.html");
exit();
?>
