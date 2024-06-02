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
<<<<<<< HEAD
    die(json_encode(['status' => 'Connection failed: ' . $e->getMessage()])); 
=======
    die(json_encode(['status' => 'Connection failed: ' . $e->getMessage()]));
>>>>>>> e60a5186ed6a6b48fce19b5201bed40bc0603186
}
?>