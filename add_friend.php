<?php
require 'config.php';

$response = ['success' => false, 'message' => ''];

try {
    // Récupérer l'utilisateur actif
    $stmt = $pdo->prepare("SELECT user_id, username FROM users WHERE is_active = 1");
    $stmt->execute();
    $activeUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($activeUser) {
        $sender_id = $activeUser['user_id'];
        $sender_username = $activeUser['username'];

        if (isset($_POST['receiver_id']) && isset($_POST['receiver_username'])) {
            $receiver_id = $_POST['receiver_id'];
            $receiver_username = $_POST['receiver_username'];

            // Vérifier si les utilisateurs sont déjà amis ou s'il y a une demande en attente
            $stmt = $pdo->prepare("SELECT * FROM Connections WHERE (user_id1 = ? AND user_id2 = ?) OR (user_id1 = ? AND user_id2 = ?)");
            $stmt->execute([$sender_id, $receiver_id, $receiver_id, $sender_id]);
            if ($stmt->rowCount() > 0) {
                $response['message'] = 'Vous avez déjà une connexion ou une demande en attente.';
            } else {
                // Insérer la demande d'ami
                $stmt = $pdo->prepare("INSERT INTO Connections (user_id1, user_id2, status) VALUES (?, ?, 'pending')");
                if ($stmt->execute([$sender_id, $receiver_id])) {
                    // Ajouter une notification pour l'expéditeur
                    $stmt = $pdo->prepare("INSERT INTO Notifications (user_id, message) VALUES (?, ?)");
                    $stmt->execute([$sender_id, "Vous avez envoyé une demande d'ami à $receiver_username."]);

                    // Ajouter une notification pour le destinataire
                    $stmt = $pdo->prepare("INSERT INTO Notifications (user_id, message) VALUES (?, ?)");
                    $stmt->execute([$receiver_id, "Vous avez reçu une demande d'ami de $sender_username."]);

                    $response['success'] = true;
                    $response['message'] = 'Demande d\'ami envoyée avec succès.';
                } else {
                    $response['message'] = 'Erreur lors de l\'insertion de la demande d\'ami dans la base de données.';
                }
            }
        } else {
            $response['message'] = 'Données invalides.';
        }
    } else {
        $response['message'] = 'Utilisateur non trouvé ou non connecté.';
    }
} catch (Exception $e) {
    $response['message'] = 'Erreur : ' . $e->getMessage();
}

echo json_encode($response);
?>