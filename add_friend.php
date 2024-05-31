<?php
require 'config.php';

if (isset($_POST['sender_id']) && isset($_POST['receiver_id'])) {
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];

    // Check if the request already exists
    $stmt = $pdo->prepare("SELECT * FROM friend_requests WHERE sender_id = ? AND receiver_id = ?");
    $stmt->execute([$sender_id, $receiver_id]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Demande déjà envoyée.']);
    } else {
        // Insert the friend request
        $stmt = $pdo->prepare("INSERT INTO friend_requests (sender_id, receiver_id) VALUES (?, ?)");
        if ($stmt->execute([$sender_id, $receiver_id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Données invalides.']);
}
?>
