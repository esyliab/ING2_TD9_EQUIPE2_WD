<?php
require 'config.php';

if (isset($_POST['user_id']) && isset($_POST['message'])) {
    $user_id = $_POST['user_id'];
    $message = $_POST['message'];

    // Insérer la notification dans la base de données
    $stmt = $pdo->prepare("INSERT INTO Notifications (user_id, message) VALUES (?, ?)");
    $success = $stmt->execute([$user_id, $message]);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Données invalides.']);
}
?>
