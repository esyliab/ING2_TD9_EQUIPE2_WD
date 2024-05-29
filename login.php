<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ece_in_user";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données du formulaire
$email = $conn->real_escape_string($_POST['email']);
$pseudo = $conn->real_escape_string($_POST['pseudo']);

// Préparer et exécuter la requête SQL
$sql = "SELECT * FROM users WHERE email='$email' AND pseudo='$pseudo'";
$result = $conn->query($sql);

if ($result === false) {
    // Afficher l'erreur SQL pour le débogage
    die("Error executing query: " . $conn->error);
}

if ($result->num_rows > 0) {
    // L'utilisateur existe, redirection vers la page d'accueil
    header("Location: accueil.html");
    exit();
} else {
    // L'utilisateur n'existe pas, affichage d'un message d'erreur
    echo "Email ou pseudo incorrect.";
}

$conn->close();
?>
