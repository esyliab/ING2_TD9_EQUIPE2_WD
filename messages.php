<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    if (!empty($sender_id) && !empty($receiver_id) && !empty($message)) {
        $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$sender_id, $receiver_id, $message]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'Message sent successfully']);
        } else {
            echo json_encode(['status' => 'Failed to send message']);
        }
    } else {
        echo json_encode(['status' => 'Invalid input']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sender_id = $_GET['sender_id'];
    $receiver_id = $_GET['receiver_id'];

    if (!empty($sender_id) && !empty($receiver_id)) {
        $sql = "SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY created_at";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$sender_id, $receiver_id, $receiver_id, $sender_id]);
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($messages);
    } else {
        echo json_encode([]);
    }
    exit;
}
?>
