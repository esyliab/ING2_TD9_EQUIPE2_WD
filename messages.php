<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $content = $_POST['content'];

    // Enregistrer le message dans la base de données
    $sql = "INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$sender_id, $receiver_id, $content]);

    // Envoyer un email
    $to = 'lukas.levy@edu.ece.fr';
    $subject = 'Nouveau message de ' . $sender_id;
    $message = 'Vous avez reçu un nouveau message de l\'utilisateur ' . $sender_id . ":\n\n" . $content;
    $headers = 'From: no-reply@votresite.com' . "\r\n" .
               'Reply-To: no-reply@votresite.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    echo json_encode(['status' => 'Message sent successfully']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sender_id = $_GET['sender_id'];
    $receiver_id = $_GET['receiver_id'];

    $sql = "SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY timestamp";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$sender_id, $receiver_id, $receiver_id, $sender_id]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($messages);
    exit;
}
?>
