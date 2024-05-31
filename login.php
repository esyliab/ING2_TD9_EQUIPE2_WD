<?php
// login.php

// Start session
session_start();

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

// Get form data
$email = isset($_POST['email']) ? $_POST['email'] : '';
$pseudo = isset($_POST['username']) ? $_POST['username'] : '';

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
    
    // Redirect to homepage
    header("Location: accueil.html");
    exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection
} else {
    // User does not exist, redirect to login with error
    header("Location: login.html?error=invalid_credentials");
    exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
