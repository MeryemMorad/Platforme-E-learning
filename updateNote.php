<?php
include('database/config.php');

// Démarrer la session
session_start();

// Vérifiez si l'utilisateur est connecté et si la variable de session 'username' est définie
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: login.php");
    exit();
}

// Check if id_note is defined and is an integer
$id_note = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['titre'];
    $id_etudiant = $_POST['id_etudiant'];
    $id_matiere = $_POST['id_matiere'];
    $valeur = $_POST['note'];
    
    // Update the note information
    $sql = "UPDATE `note` SET `titre`='$titre', `idE`='$id_etudiant', `idM`='$id_matiere', `valeur`='$valeur' WHERE `id` = $id_note";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: note.php?msg=Update successful");
        exit();
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}

// Retrieve note information
$sql = "SELECT * FROM `note` WHERE `id` = $id_note LIMIT 1";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Error in query: ' . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
} else {
    die('Note not found');
}

// Retrieve subjects (matiere)
$sql_matiere = "SELECT * FROM `matiere`";
$result_matiere = mysqli_query($conn, $sql_matiere);

if (!$result_matiere) {
    die('Error in fetching subjects: ' . mysqli_error($conn));
}

// Retrieve the level of the logged-in instructor
$sql = "SELECT idN FROM facilitateur WHERE username='$username'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $facilitator = mysqli_fetch_assoc($result);
    $niveau_id = $facilitator['idN'];
} else {
    $niveau_id = 0;
}

// Fetch students in the same level
$students_sql = "SELECT id_E, username FROM etudiant WHERE idN='$niveau_id'";
$students_result = mysqli_query($conn, $students_sql);

if (!$students_result) {
    die('Error in SQL query: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Note</title>
</head>
<body>
    <div class="container">
        <div class="text-center mb-4">
            <h3>Edit Note Information</h3>
            <p class="text-muted">Click update after changing any information</p>
        </div>

        <div class="container d-flex justify-content-center">
            <form action="" method="post" style="width: 50vw; min-width: 300px;">
                <div class="mb-3">
                    <label for="titre" class="form-label">Note Title:</label>
                    <input type="text" class="form-control" name="titre" id="titre" value="<?php echo htmlspecialchars($row['titre']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="id_etudiant" class="form-label">Étudiants</label>
                    <select class="form-select" id="id_etudiant" name="id_etudiant" required>
                        <option value="">Sélectionnez un étudiant</option>
                        <?php while ($student = mysqli_fetch_assoc($students_result)): ?>
                            <option value="<?php echo htmlspecialchars($student['id_E']); ?>" <?php echo ($student['id_E'] == $row['idE']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($student['username']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_matiere" class="form-label">Subject (Matière):</label>
                    <select class="form-select" id="id_matiere" name="id_matiere" required>
                        <?php while ($row_matiere = mysqli_fetch_assoc($result_matiere)) { ?>
                            <option value="<?php echo $row_matiere['id']; ?>" <?php echo ($row_matiere['id'] == $row['idM']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($row_matiere['title']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">Note Value:</label>
                    <input type="number" step="0.01" class="form-control" name="note" id="note" value="<?php echo htmlspecialchars($row['valeur']); ?>" required>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="note.php" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
