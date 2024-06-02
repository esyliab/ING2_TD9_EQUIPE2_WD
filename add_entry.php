<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['error' => 'Invalid input']);
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ECE_Social_Media";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$type = $data['type'];
$description = $data['description'];
$date = $data['date'];

$stmt = $conn->prepare("INSERT INTO Entries (user_id, type, description, date) VALUES (?, ?, ?, ?)");
if ($stmt) {
    $stmt->bind_param("isss", $user_id, $type, $description, $date);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to insert entry']);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'Failed to prepare statement']);
}

$conn->close();
?>
