<?php
session_start();
include 'database/config.php';

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $titre = $_POST['titre'];
    $id_etudiant = $_POST['id_etudiant'];
    $id_matiere = $_POST['id_matiere'];
    $valeur = $_POST['note'];

    // Validate form data
    if (!empty($titre) && !empty($id_etudiant) && !empty($id_matiere) && !empty($valeur)) {
        // Insert note into database
        $sql = "INSERT INTO note (titre, idE, idM, valeur) VALUES ('$titre', '$id_etudiant', '$id_matiere', '$valeur')";

        if (mysqli_query($conn, $sql)) {
            header('Location: note.php');
            exit;
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    } else {
        echo 'Please fill in all fields.';
    }
} else {
    echo 'Invalid request method.';
}
?>
