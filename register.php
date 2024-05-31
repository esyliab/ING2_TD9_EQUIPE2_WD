<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ECE_Social_Media";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password']; 
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$profile_picture = $_POST['profile_picture'];
$background_image = $_POST['background_image'];
$bio = $_POST['bio'];
$user_type = $_POST['user_type'];

// Hacher le mot de passe (vous devriez utiliser une méthode de hachage sécurisée comme bcrypt)
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Préparer la requête d'insertion
$stmt = $conn->prepare("INSERT INTO Users (email, username, password_hash, first_name, last_name, profile_picture, background_image, bio, user_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $email, $username, $password_hash, $first_name, $last_name, $profile_picture, $background_image, $bio, $user_type);

if ($stmt->execute() === TRUE) {
    // Redirection vers la page du menu
    header("Location: menu.html");
    exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection
} else {
    echo "Erreur lors de l'inscription : " . $conn->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
