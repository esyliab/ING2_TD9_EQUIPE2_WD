<?php
require 'config.php';

$query = $pdo->query("SELECT user_id, username, email FROM users");
$users = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
?>
