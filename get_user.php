<?php
require 'config.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $stmt = $pdo->prepare("SELECT user_id, username, email, first_name, last_name, profile_picture, background_image, bio FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($user);
} else {
    echo json_encode([]);
}
?>
