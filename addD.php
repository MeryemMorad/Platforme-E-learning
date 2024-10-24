<?php
include('database/config.php');

// Vérification si un fichier a été téléchargé et s'il n'y a pas d'erreur
if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
    $file = $_FILES["file"];
    
    // Définir le chemin de téléchargement et vérifier l'existence du répertoire
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $filePath = $uploadDir . basename($file["name"]);

    // Tentative de déplacement du fichier téléchargé vers le répertoire "uploads"
    if (move_uploaded_file($file["tmp_name"], $filePath)) {
        // Récupération des données du formulaire
        $titre = mysqli_real_escape_string($conn, $_POST["name"]);
        $matiere = (int) $_POST["matiere"]; // Assurez-vous que c'est un entier
        $niveau = (int) $_POST["niveau"]; // Assurez-vous que c'est un entier
        $date_limite = mysqli_real_escape_string($conn, $_POST["date_limite"]);
        $description = mysqli_real_escape_string($conn, $_POST["date_soumission"]);
        $id_enseignant = (int) $_POST["id_enseignant"]; // Assurez-vous que c'est un entier

        // Échappement du chemin du fichier
        $filePath = mysqli_real_escape_string($conn, $filePath);

        // Correction de l'ordre des colonnes dans la requête SQL
        $sql = "INSERT INTO devoir (titre, id_level, id_subject, date_soumission, date_limite, id_prf, document) 
                VALUES ('$titre', $niveau, $matiere, '$description', '$date_limite', $id_enseignant, '$filePath')";

        // Affichage de la requête pour débogage
        // echo $sql; 

        // Exécution de la requête SQL
        if (mysqli_query($conn, $sql)) {
            header("Location: " . $_SERVER["HTTP_REFERER"]); // Redirection après succès
            exit(); // Assurez-vous de sortir après une redirection
        } else {
            echo "Erreur SQL: " . mysqli_error($conn); // Affichage de l'erreur SQL
        }
    } else {
        echo "Erreur lors du déplacement du fichier."; // Erreur si le fichier ne peut pas être déplacé
    }
} else {
    echo "Aucun fichier n'a été téléchargé ou il y a eu une erreur lors du téléchargement."; // Message si aucun fichier n'a été téléchargé
}
?>
