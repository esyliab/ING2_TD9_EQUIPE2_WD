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

$event_id = $_POST['event_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$event_date = $_POST['eventDate'];
$location = $_POST['location'];

$sql = "UPDATE Events SET title = ?, description = ?, event_date = ?, location = ? WHERE event_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $title, $description, $event_date, $location, $event_id);

if ($stmt->execute()) {
    header("Location: accueil.html");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
