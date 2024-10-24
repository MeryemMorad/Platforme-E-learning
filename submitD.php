<?php
session_start();
include 'database/config.php';

// Assurez-vous que l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Récupérer l'ID de l'étudiant depuis la session
$student_username = $_SESSION['username'];

// Récupérer l'ID de l'étudiant
$sql = "SELECT id_E FROM etudiant WHERE username = ?";
$stmt = $conn->prepare($sql);

// Check if the statement preparation was successful
if ($stmt === false) {
    die('Erreur de préparation de la requête: ' . $conn->error);
}

$stmt->bind_param("s", $student_username);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$student_id = $student['id_E'];

// Vérifier si un ID de devoir est passé en paramètre
if (isset($_GET['id'])) {
    $devoir_id = intval($_GET['id']);
} else {
    die('Aucun devoir spécifié.');
}

// Gérer la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES['devoir_fichier']) && $_FILES['devoir_fichier']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['devoir_fichier']['tmp_name'];
        $file_name = $_FILES['devoir_fichier']['name'];
        $file_dest = 'uploads/' . $file_name; // Assurez-vous que le répertoire "uploads" existe et est accessible en écriture

        // Déplacer le fichier téléchargé vers le dossier de destination
        if (move_uploaded_file($file_tmp, $file_dest)) {
            // Enregistrer les informations du fichier dans la base de données
            $sql = "INSERT INTO rendu_devoir (id_etudiant, id_devoir, fichier, date_rendu) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);

            // Check if the statement preparation was successful
            if ($stmt === false) {
                die('Erreur de préparation de la requête: ' . $conn->error);
            }

            // Bind the parameters and execute the statement
            $stmt->bind_param("iis", $student_id, $devoir_id, $file_name);
            if ($stmt->execute()) {
                echo "<script>alert('Devoir soumis avec succès!');</script>";
            } else {
                echo "<script>alert('Erreur lors de la soumission du devoir: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Erreur lors du téléchargement du fichier.');</script>";
        }
    } else {
        echo "<script>alert('Aucun fichier téléchargé ou une erreur est survenue.');</script>";
    }
}

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Soumettre un Devoir</title>
    <style>
        body {
            background-color: #f;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-4">Soumettre un Devoir</h2>
    <form action="submitD.php?id=<?php echo $devoir_id; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="devoir_fichier" class="form-label">Choisir le fichier à soumettre :</label>
            <input type="file" class="form-control" id="devoir_fichier" name="devoir_fichier" required>
        </div>
        <button type="submit" class="btn btn-primary">Soumettre</button>
        <a href="devoirs.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
