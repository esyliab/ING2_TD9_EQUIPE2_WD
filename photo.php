<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "11bis@Djaze";
$dbname = "ECE_Social_Media";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$lieu = $_POST['lieu'];
$image = $_POST['image'];
$post_date = $_POST['date']; 

$sql = "INSERT INTO Posts (user_id, title, lieu, image, created_at) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $user_id, $title, $lieu, $image, $post_date);

if ($stmt->execute()) {
    header("Location: accueil.html"); 
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
