<?php
session_start();
require 'config.php';

$user_id = $_SESSION['user_id'];

$query = $pdo->prepare("SELECT user_id, username, email, profile_picture FROM users WHERE user_id != ? AND is_active = 0");
$query->execute([$user_id]);
$users = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
?>
