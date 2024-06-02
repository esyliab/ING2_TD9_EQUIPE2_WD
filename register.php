<?php

$servername = "localhost";
$username = "root";
$password = "11bis@Djaze";
$dbname = "ECE_Social_Media";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$email = $_POST['email'];
$username = $_POST['username'];


$stmt = $conn->prepare("INSERT INTO Users (email, username) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $username);

if ($stmt->execute() === TRUE) {
    header("Location: menu.html");
    exit(); 
} else {
    echo "Erreur lors de l'inscription : " . $conn->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
