<?php
// Configuration des paramètres de la base de données
$servername = "localhost";
$username = "root";
$password = "11bis@Djaze";
$dbname = "djaze_database"; // Remplacez par le nom de votre base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les informations d'un utilisateur spécifique (par exemple, avec l'ID de l'utilisateur)
$user_id = 1; // Remplacez par l'ID de l'utilisateur que vous souhaitez récupérer

$sql = "SELECT username, first_name, last_name FROM Users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $first_name, $last_name);

$response = array();

if ($stmt->fetch()) {
    $response['username'] = $username;
    $response['first_name'] = $first_name;
    $response['last_name'] = $last_name;
} else {
    $response['error'] = "Aucun utilisateur trouvé avec l'ID spécifié.";
}

// Fermeture de la déclaration et de la connexion
$stmt->close();
$conn->close();

// Envoyer les données sous forme de JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
