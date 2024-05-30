<?php
require 'config.php';

session_start();
$user_id = $_SESSION['user_id']; // Remplacez par l'ID utilisateur actuel connecté

// Sélectionner les notifications de l'utilisateur
$queryNotifications = $pdo->prepare("SELECT * FROM Notifications WHERE user_id = ? ORDER BY created_at DESC");
$queryNotifications->execute([$user_id]);
$notifications = $queryNotifications->fetchAll(PDO::FETCH_ASSOC);

// Sélectionner les demandes d'amis reçues par l'utilisateur
$queryReceived = $pdo->prepare("SELECT fr.id, u.username AS sender_username FROM friend_requests fr JOIN users u ON fr.sender_id = u.user_id WHERE fr.receiver_id = ? AND fr.status = 'pending'");
$queryReceived->execute([$user_id]);
$receivedRequests = $queryReceived->fetchAll(PDO::FETCH_ASSOC);

// Sélectionner les demandes d'amis en attente envoyées par l'utilisateur
$querySent = $pdo->prepare("SELECT fr.id, u.username AS receiver_username FROM friend_requests fr JOIN users u ON fr.receiver_id = u.user_id WHERE fr.sender_id = ? AND fr.status = 'pending'");
$querySent->execute([$user_id]);
$sentRequests = $querySent->fetchAll(PDO::FETCH_ASSOC);

// Fusionner les notifications et les demandes d'amis dans un seul tableau
$notifications = array_merge($notifications, $receivedRequests, $sentRequests);

echo json_encode($notifications);
?>
