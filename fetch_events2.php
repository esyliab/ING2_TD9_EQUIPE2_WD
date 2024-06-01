<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ECE_Social_Media";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Events WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='event'>";
        echo "<h5>" . htmlspecialchars($row['title']) . "</h5>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        echo "<p>Date: " . htmlspecialchars($row['event_date']) . "</p>";
        echo "<p>Lieu: " . htmlspecialchars($row['location']) . "</p>";
        echo "<form action='delete_event.php' method='post' style='display:inline-block;'>
                <input type='hidden' name='event_id' value='" . $row['event_id'] . "'>
                <button type='submit'>Supprimer</button>
              </form>";
        echo "<form action='edit_event.php' method='get' style='display:inline-block;'>
                <input type='hidden' name='event_id' value='" . $row['event_id'] . "'>
                <button type='submit'>Modifier</button>
              </form>";
        echo "</div>";
    }
} else {
    echo "<p>Aucun évènement trouvé.</p>";
}

$stmt->close();
$conn->close();
?>
