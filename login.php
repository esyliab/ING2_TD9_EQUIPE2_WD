<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ECE_Social_Media";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = isset($_POST['email']) ? $_POST['email'] : '';
$pseudo = isset($_POST['username']) ? $_POST['username'] : '';

$stmt = $conn->prepare("SELECT * FROM Users WHERE email = ? AND username = ?");
$stmt->bind_param("ss", $email, $pseudo);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['user_type'] = $user['user_type'];

    $conn->begin_transaction();

    try {
        // Set is_active to FALSE for all users
        $conn->query("UPDATE Users SET is_active = FALSE");

        // Set is_active to TRUE for the current user
        $update_stmt = $conn->prepare("UPDATE Users SET is_active = TRUE WHERE user_id = ?");
        $update_stmt->bind_param("i", $user['user_id']);
        $update_stmt->execute();
        $update_stmt->close();

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();

        header("Location: login.html?error=update_failed");
        exit();
    }

    // Redirect based on user type
    if ($user['user_type'] === 'admin') {
        header("Location: admin.html");
    } else {
        header("Location: accueil.html");
    }
    exit(); 
} else {
    header("Location: login.html?error=invalid_credentials");
    exit(); 
}

$stmt->close();
$conn->close();
?>
