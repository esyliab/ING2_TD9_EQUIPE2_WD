<?php
// login.php

// Start session
session_start();

// Database connection details
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "ECE_Social_Media";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = $_POST['email'];
$pseudo = $_POST['pseudo'];

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM Users WHERE email = ? AND username = ?");
$stmt->bind_param("ss", $email, $pseudo);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    // User exists
    $user = $result->fetch_assoc();
    
    // Set session variables
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['username'] = $user['username'];
    
    // Redirect to homepage or dashboard
    header("Location: accueil.html");
} else {
    // User does not exist, redirect to login with error
    header("Location: login.html?error=invalid_credentials");
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
