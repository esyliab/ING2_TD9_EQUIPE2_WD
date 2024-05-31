<?php
$host = 'localhost'; 
$db = 'ECE_Social_Media';
$user = 'root'; 
$pass = ''; 

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die(json_encode(['status' => 'Connection failed: ' . $e->getMessage()])); // Improved error handling
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $content = $_POST['content'];

    if (!empty($sender_id) && !empty($receiver_id) && !empty($content)) {
        $sql = "INSERT INTO Messages (sender_id, receiver_id, content) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$sender_id, $receiver_id, $content]);

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
        $sql = "SELECT * FROM Messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY created_at";
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
