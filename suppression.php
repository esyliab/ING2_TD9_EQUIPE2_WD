<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.html?error=access_denied");
    exit();
}

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

// Get the username from the form
$user_to_delete = isset($_POST['username']) ? $_POST['username'] : '';

if (!empty($user_to_delete)) {
    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM Users WHERE username = ?");
    $stmt->bind_param("s", $user_to_delete);

    // Execute the statement
    if ($stmt->execute()) {
        $message = "L'utilisateur a été supprimé avec succès.";
    } else {
        $message = "Erreur lors de la suppression de l'utilisateur : " . $stmt->error;
    }

    $stmt->close();
} else {
    $message = "Le pseudo de l'utilisateur est requis.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat de la suppression</title>
    <link rel="stylesheet" href="accueil.css">
</head>
<body>
    <div class="container">
        <h1>Résultat de la suppression</h1>
        <p><?php echo htmlspecialchars($message); ?></p>
        <a href="suppression.html">Retour</a>
    </div>
</body>
</html>
