<?php
require 'config.php';

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $stmt = $pdo->prepare("SELECT user_id, username, email FROM users WHERE username LIKE ?");
    $stmt->execute(["%$keyword%"]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
} else {
    echo json_encode([]);
}
?>
