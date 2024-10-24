<?php
include('database/config.php');

if (isset($_POST['save-btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $status = $_POST['status'];
    $matiere = $_POST['matiere'];
    $gender = $_POST['gender'];
    $niveaux = isset($_POST['niveau']) ? $_POST['niveau'] : [];

    // Insertion de l'enseignant dans la table 'enseignant'
    $sql = "INSERT INTO enseignant (username, password, status, id_M, gender) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $password, $status, $matiere, $gender);

    if ($stmt->execute()) {
        // Récupérer l'identifiant de l'enseignant inséré
        $enseignant_id = $stmt->insert_id;

        // Insertion des niveaux dans la table 'enseignant_niveau'
        $niveau_sql = "INSERT INTO enseignant_niveau (id_EN, id_N) VALUES (?, ?)";
        $niveau_stmt = $conn->prepare($niveau_sql);

        foreach ($niveaux as $niveau) {
            $niveau_stmt->bind_param("ii", $enseignant_id, $niveau);
            $niveau_stmt->execute();
        }

        $niveau_stmt->close();

        echo "<script>alert('Enseignant ajouté avec succès');</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'ajout de l\'enseignant');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
