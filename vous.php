<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ece_in";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

$type = $_POST['type'];
$description = $_POST['description'];
$date = $_POST['date'];
$utilisateur_id = $_POST['utilisateur_id'];

$sql = "INSERT INTO formations_projets (utilisateur_id, type, description, date) VALUES ('$utilisateur_id', '$type', '$description', '$date')";

if ($conn->query($sql) === TRUE) {
    echo "Les données ont été insérées avec succès.";
} else {
    echo "Erreur lors de l'insertion des données : " . $conn->error;
}

$conn->close();
?>