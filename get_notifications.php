<?php
require 'config.php';

// Récupérer l'utilisateur actif
$stmt = $pdo->prepare("SELECT user_id FROM users WHERE is_active = 1");
$stmt->execute();
$activeUser = $stmt->fetch(PDO::FETCH_ASSOC);

if ($activeUser) {
    $user_id = $activeUser['user_id'];

    // Récupérer les notifications non lues
    $stmt = $pdo->prepare("SELECT message FROM Notifications WHERE user_id = ? AND is_read = FALSE ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $notifications = $stmt->fetchAll();

    echo json_encode($notifications);
} else {
    echo json_encode([]);
}
?>