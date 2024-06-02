<?php
session_start();
require 'config.php';

if (isset($_POST['receiver_id']) && isset($_POST['receiver_username'])) {
    $sender_id = $_SESSION['user_id']; // Utilisateur connecté
    $receiver_id = $_POST['receiver_id'];
    $receiver_username = $_POST['receiver_username'];

    // Check if the users are already friends
    $stmt = $pdo->prepare("SELECT * FROM Connections WHERE (user_id1 = ? AND user_id2 = ?) OR (user_id1 = ? AND user_id2 = ?)");
    $stmt->execute([$sender_id, $receiver_id, $receiver_id, $sender_id]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Vous êtes déjà amis.']);
    } else {
        // Insert the friend request
        $stmt = $pdo->prepare("INSERT INTO Connections (user_id1, user_id2, status) VALUES (?, ?, 'pending')");
        if ($stmt->execute([$sender_id, $receiver_id])) {
            // Add notification for the sender
            $stmt = $pdo->prepare("INSERT INTO Notifications (user_id, message) VALUES (?, ?)");
            $stmt->execute([$sender_id, "Vous avez envoyé une demande d'ami à $receiver_username."]);

            // Add notification for the receiver
            $stmt = $pdo->prepare("INSERT INTO Notifications (user_id, message) VALUES (?, ?)");
            $stmt->execute([$receiver_id, "Vous avez reçu une demande d'ami de " . $_SESSION['username']]);

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Données invalides.']);
}
?>
