<?php
// get_entries.php

// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ECE_Social_Media";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Prepare and execute the query to fetch entries
$stmt = $conn->prepare("SELECT type, description, date FROM Entries WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are entries
if ($result->num_rows > 0) {
    $entries = [];
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }
    echo json_encode(['entries' => $entries]);
} else {
    echo json_encode(['error' => 'No entries found']);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
