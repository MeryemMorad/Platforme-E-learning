<?php
include('database/config.php');

// Activer les erreurs pour débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['save-btn'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Gérer l'upload de l'image
    $image = $_FILES['image']['name'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($image);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifier si l'image est bien une image
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check === false) {
        echo "<script>alert('Le fichier n\'est pas une image.');</script>";
        $uploadOk = 0;
    }

    // Autoriser certains formats d'image
    $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "<script>alert('Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.');</script>";
        $uploadOk = 0;
    }

    // Vérifier si $uploadOk est à 0 en raison d'une erreur
    if ($uploadOk == 0) {
        echo "<script>alert('Désolé, votre fichier n\'a pas été téléchargé.');</script>";
    } else {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Préparer et exécuter la requête SQL pour insérer les données dans la base
            $stmt = $conn->prepare("INSERT INTO matiere (title, description, image) VALUES (?, ?, ?)");
            if ($stmt === false) {
                echo "<script>alert('Préparation de la requête échouée : " . $conn->error . "');</script>";
            } else {
                $stmt->bind_param("sss", $name, $description, $image);
                if ($stmt->execute()) {
                    echo "<script>alert('Le sujet a été ajouté avec succès.'); window.location.href = 'subject.php';</script>";
                } else {
                    echo "<script>alert('Échec de l\'ajout du sujet : " . $stmt->error . "');</script>";
                }
                $stmt->close();
            }
        } else {
            echo "<script>alert('Désolé, il y a eu une erreur lors du téléchargement de votre fichier.');</script>";
        }
    }
    $conn->close();
}
?>
