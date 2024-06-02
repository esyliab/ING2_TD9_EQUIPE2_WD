<?php
// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ECE_Social_Media";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$email = $_POST['email'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hachage du mot de passe
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$profile_picture = $_POST['profile_picture'];
$background_image = $_POST['background_image'];
$bio = $_POST['bio'];
$user_type = $_POST['user_type'];

// Préparer et exécuter la requête d'insertion
$sql = "INSERT INTO Users (email, username, password_hash, first_name, last_name, profile_picture, background_image, bio, user_type) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssss", $email, $username, $password, $first_name, $last_name, $profile_picture, $background_image, $bio, $user_type);

if ($stmt->execute()) {
    // Redirection vers la page menu en cas de succès
    header("Location: menu.html");
    exit();
} else {
    echo "Erreur lors de l'inscription : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
