<?php
require 'config.php';

session_start();
$user_id = $_SESSION['user_id']; // Remplacez par l'ID utilisateur actuel connecté

$query = $pdo->prepare("SELECT fr.id, u.username AS sender_username FROM friend_requests fr JOIN users u ON fr.sender_id = u.user_id WHERE fr.receiver_id = ? AND fr.status = 'pending'");
$query->execute([$user_id]);
$notifications = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($notifications);
?>
