<?php
include('database/config.php');

$file = $_FILES["file"];
$filePath = "uploads/" . basename($file["name"]);

// Vérifier si le fichier a été correctement téléchargé
if (move_uploaded_file($file["tmp_name"], $filePath)) {
    $titre = $_POST["name"];
    $description = $_POST["description"];
    $matiere = $_POST["matiere"];
    $id_enseignant = $_POST["id_enseignant"];
    $niveau = $_POST["niveau"];

    // Utilisation de requêtes préparées pour éviter les injections SQL
    $sql = "INSERT INTO cours (Ttitre, description, id_enseignant, id, id_N, file_path) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Lier les paramètres à la requête
        $stmt->bind_param("ssiiis", $titre, $description, $id_enseignant, $matiere, $niveau, $filePath);
        
        // Exécuter la requête
        if ($stmt->execute()) {
            // Rediriger l'utilisateur vers la page précédente après le succès
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit();
        } else {
            echo "Erreur lors de l'insertion dans la base de données : " . $stmt->error;
        }
        
        // Fermer la déclaration
        $stmt->close();
    } else {
        echo "Erreur lors de la préparation de la requête : " . $conn->error;
    }
} else {
    echo "Erreur lors du téléchargement du fichier.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
