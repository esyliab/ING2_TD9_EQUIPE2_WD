<?php
session_start();
require 'config.php';

if (isset($_POST['request_id']) && isset($_POST['response'])) {
    $request_id = $_POST['request_id'];
    $response = $_POST['response']; // 'accepted' ou 'declined'

    // Get the details of the request
    $stmt = $pdo->prepare("SELECT * FROM Connections WHERE connection_id = ?");
    $stmt->execute([$request_id]);
    $request = $stmt->fetch();

    if ($request) {
        $sender_id = $request['user_id1'];
        $receiver_id = $request['user_id2'];

        // Update the status of the connection
        $stmt = $pdo->prepare("UPDATE Connections SET status = ? WHERE connection_id = ?");
        if ($stmt->execute([$response, $request_id])) {
            // Notify the sender
            $message = ($response == 'accepted') ? "Votre demande d'ami à " . $_SESSION['username'] . " a été acceptée." : "Votre demande d'ami à " . $_SESSION['username'] . " a été refusée.";
            $stmt = $pdo->prepare("INSERT INTO Notifications (user_id, message) VALUES (?, ?)");
            $stmt->execute([$sender_id, $message]);

            // Notify the receiver
            $message = ($response == 'accepted') ? "Vous avez accepté la demande d'ami de " . $_SESSION['username'] . "." : "Vous avez refusé la demande d'ami de " . $_SESSION['username'] . ".";
            $stmt = $pdo->prepare("INSERT INTO Notifications (user_id, message) VALUES (?, ?)");
            $stmt->execute([$receiver_id, $message]);

            // If accepted, update the connection to mark them as friends
            if ($response == 'accepted') {
                $stmt = $pdo->prepare("UPDATE Connections SET status = 'accepted' WHERE connection_id = ?");
                $stmt->execute([$request_id]);
            }

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
}
?>
