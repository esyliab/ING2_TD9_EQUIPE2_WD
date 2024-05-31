<?php
include 'config.php'; // Inclusion de la configuration de la base de données

$user_id = $_GET['user_id'];
$query = $pdo->prepare("SELECT * FROM Notifications WHERE user_id = ? AND is_read = FALSE");
$query->execute([$user_id]);
$results = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
?>
