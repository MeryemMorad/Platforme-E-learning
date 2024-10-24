<?php
session_start();
include('database/config.php');

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Récupérer l'ID et le rôle de l'utilisateur sélectionné
$selected_user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
$selected_user_role = isset($_GET['role']) ? $_GET['role'] : null;

// Récupérer le nom d'utilisateur du destinataire
$recipient_username = '';

// Déterminer la requête SQL en fonction du rôle de l'utilisateur
if ($selected_user_role === 'student') {
    $sql_recipient = "SELECT username FROM etudiant WHERE id_E = ?";
} else if ($selected_user_role === 'teacher') {
    $sql_recipient = "SELECT username FROM enseignant WHERE id_EN = ?";
}

// Préparer et exécuter la requête SQL
$stmt_recipient = $conn->prepare($sql_recipient);
$stmt_recipient->bind_param("i", $selected_user_id);
$stmt_recipient->execute();
$result_recipient = $stmt_recipient->get_result();

// Récupérer le nom d'utilisateur du destinataire
if ($row = $result_recipient->fetch_assoc()) {
    $recipient_username = $row['username'];
}

// Récupérer les étudiants
$sql_students = "SELECT id_E, username FROM etudiant";
$result_students = mysqli_query($conn, $sql_students);
while ($row = mysqli_fetch_assoc($result_students)) {
    $recipients[] = ['id' => $row['id_E'], 'username' => $row['username'], 'type' => 'student'];
}

// Récupérer les enseignants
$sql_enseignants = "SELECT id_EN, username FROM enseignant";
$result_enseignants = mysqli_query($conn, $sql_enseignants);
while ($row = mysqli_fetch_assoc($result_enseignants)) {
    $recipients[] = ['id' => $row['id_EN'], 'username' => $row['username'], 'type' => 'teacher'];
}

// Récupérer l'ID de l'utilisateur connecté
$logged_in_username = $_SESSION['username'];
$sql_user_id = "SELECT id_EN AS id FROM enseignant WHERE username = ? 
                UNION 
                SELECT id_E AS id FROM etudiant WHERE username = ?";
$stmt_user = $conn->prepare($sql_user_id);
$stmt_user->bind_param("ss", $logged_in_username, $logged_in_username);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$logged_in_user = $result_user->fetch_assoc();
$logged_in_user_id = $logged_in_user['id'];

// Initialiser le tableau de messages
$messages = [];

// Vérifier si le formulaire a été soumis pour envoyer un message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $recipient_id = $_POST['recipient_id'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Insérer le message dans la base de données
    $sql_insert = "INSERT INTO messages (sender_id, recipient_id, subject, message, date_sent) VALUES (?, ?, ?, ?, NOW())";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iiss", $logged_in_user_id, $recipient_id, $subject, $message);
    if ($stmt_insert->execute()) {
        echo "<p style='color:green;'>Message envoyé avec succès!</p>";
    } else {
        echo "<p style='color:red;'>Échec de l'envoi du message. Veuillez réessayer.</p>";
    }

    // Récupérer les messages après l'envoi
    $sql_messages = "SELECT m.subject, m.message, 
    DATE_FORMAT(m.date_sent, '%d/%m/%Y %H:%i') AS formatted_date_sent, 
    (SELECT username FROM enseignant WHERE id_EN = m.sender_id 
     UNION SELECT username FROM etudiant WHERE id_E = m.sender_id) AS sender_username,
    (SELECT username FROM enseignant WHERE id_EN = m.recipient_id 
     UNION SELECT username FROM etudiant WHERE id_E = m.recipient_id) AS recipient_username
FROM messages m
WHERE (m.sender_id = ? AND m.recipient_id = ?) OR (m.sender_id = ? AND m.recipient_id = ?)
ORDER BY m.date_sent ASC";

    $stmt_messages = $conn->prepare($sql_messages);
    $stmt_messages->bind_param("iiii", $logged_in_user_id, $recipient_id, $recipient_id, $logged_in_user_id);
    $stmt_messages->execute();
    $result_messages = $stmt_messages->get_result();

    while ($row = mysqli_fetch_assoc($result_messages)) {
        $messages[] = $row; // Stocker les messages récupérés
    }

} elseif ($selected_user_id) {
    // Récupérer les messages si le destinataire est sélectionné sans envoyer un nouveau message
    $sql_messages = "SELECT m.subject, m.message, 
    DATE_FORMAT(m.date_sent, '%d/%m/%Y %H:%i') AS formatted_date_sent, 
    (SELECT username FROM enseignant WHERE id_EN = m.sender_id 
     UNION SELECT username FROM etudiant WHERE id_E = m.sender_id) AS sender_username,
    (SELECT username FROM enseignant WHERE id_EN = m.recipient_id 
     UNION SELECT username FROM etudiant WHERE id_E = m.recipient_id) AS recipient_username
FROM messages m
WHERE (m.sender_id = ? AND m.recipient_id = ?) OR (m.sender_id = ? AND m.recipient_id = ?)
ORDER BY m.date_sent ASC";

    $stmt_messages = $conn->prepare($sql_messages);
    $stmt_messages->bind_param("iiii", $logged_in_user_id, $selected_user_id, $selected_user_id, $logged_in_user_id);
    $stmt_messages->execute();
    $result_messages = $stmt_messages->get_result();

    while ($row = mysqli_fetch_assoc($result_messages)) {
        $messages[] = $row; // Stocker les messages récupérés
    }
}

// Affichage du formulaire de message
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Message Form</title>
    <style>
    /* Styles généraux */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Styles de formulaire */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        select, input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            background-color: #20c997;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #17a589;
        }

        /* Styles des messages */
        .chat-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            overflow-y: auto;
            height: 400px; /* Hauteur fixe pour le défilement */
        }

        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 15px;
            max-width: 80%;
            position: relative;
        }

        .message.sender {
            background-color: #e1ffc7; /* Couleur de fond pour l'expéditeur */
            align-self: flex-end;
            margin-left: auto;
        }

        .message.recipient {
            background-color: #f0f0f0; /* Couleur de fond pour le destinataire */
            align-self: flex-start;
            margin-right: auto;
        }

        .message .username {
            font-weight: bold;
        }

        .message .timestamp {
            font-size: 0.8em;
            color: #777;
            position: absolute;
            bottom: -15px;
            right: 10px;
        }

        /* Styles du conteneur de chat */
        .chat-box {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>

 <?php echo "<h2>Envoyer un message à " . htmlspecialchars($recipient_username) . "</h2>"; ?>

<form method="POST">
    <input type="hidden" name="recipient_id" value="<?php echo htmlspecialchars($selected_user_id); ?>">
    <label for="subject">Sujet:</label>
    <input type="text" name="subject" required>
    <label for="message">Message:</label>
    <textarea name="message" required></textarea>
    <button type="submit" name="send_message">Envoyer</button>
</form>


<?php if (!empty($messages)): ?>
<div class="chat-container">
    <div class="chat-box">
        <?php foreach ($messages as $msg): ?>
            <div class="message <?php echo ($msg['sender_username'] == $logged_in_username) ? 'sender' : 'recipient'; ?>">
                <div class="username"><?php echo htmlspecialchars($msg['sender_username']); ?>:</div>
                <div><?php echo nl2br(htmlspecialchars($msg['message'])); ?></div>
               
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>


</body>
</html>
