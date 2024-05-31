<?php
include 'config.php'; // Inclusion de la configuration de la base de données

$request_id = $_POST['request_id'];
$response = $_POST['response']; // 'accepted' ou 'declined'

$query = $pdo->prepare("UPDATE Connections SET status = ? WHERE connection_id = ?");
$success = $query->execute([$response, $request_id]);

echo json_encode(['success' => $success]);
?>