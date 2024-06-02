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

$event_id = $_GET['event_id'];

$sql = "SELECT * FROM Events WHERE event_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
} else {
    echo "Évènement non trouvé.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Évènement | ECE In</title>
    <link rel="stylesheet" href="accueil.css">
    <link rel="icon" type="image/vnd.icon" href="ECE_LOGO_2021_web.ico">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div>ECE In: Social Media Professionnel de l’ECE Paris</div>
            <img src="ECE_LOGO_2021_web.png" alt="ECE In Logo">
        </div>
        <div class="navigation">
            <a href="accueil.html">Accueil</a>
        </div>
        <div class="section">
            <h3>Modifier l'évènement</h3>
            <form id="editEventForm" action="update_event.php" method="post">
                <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['event_id']); ?>">
                <label for="title">Titre de l'évènement :</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required><br>

                <label for="description">Description :</label>
                <textarea id="description" name="description" rows="4" cols="50" required><?php echo htmlspecialchars($event['description']); ?></textarea><br>

                <label for="eventDate">Date de l'évènement :</label>
                <input type="date" id="eventDate" name="eventDate" value="<?php echo htmlspecialchars($event['event_date']); ?>" required><br>

                <label for="location">Lieu :</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required><br>

                <button type="submit">Modifier l'Évènement</button>
            </form>
        </div>
        <div class="footer">
            <p>Nous contacter :</p>
            <p>Email : <a href="mailto:admissions-paris@ece.fr">admissions-paris@ece.fr</a></p>
            <p>Téléphone : <a href="tel:0123456789">01.44.39.06.00</a></p>
        </div>
    </div>
</body>
</html>
