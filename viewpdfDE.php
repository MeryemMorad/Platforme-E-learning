<?php
include('database/config.php');

$id_r = isset($_GET['id_r']) ? intval($_GET['id_r']) : null;

if ($id_r) {
    $sql = "SELECT fichier FROM rendu_devoir WHERE id_r = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param('i', $id_r);
        $stmt->execute();
        $stmt->bind_result($file_path);
        $stmt->fetch();
        $stmt->close();
        if ($file_path) {
            // Ajouter le dossier "uploads" au chemin du fichier
            $full_path = "uploads/" . $file_path;

            // Vérifier que le fichier existe
            if (file_exists($full_path)) {
                // Déterminer le type MIME du fichier
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $full_path);
                finfo_close($finfo);

                // Configurer les en-têtes pour afficher le fichier
                header('Content-Description: File Transfer');
                header('Content-Type: ' . $mime_type);
                header('Content-Disposition: inline; filename="' . basename($full_path) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($full_path));

                // Nettoyer le tampon de sortie
                ob_clean();
                flush();

                // Lire le fichier et l'afficher
                readfile($full_path);
                exit;
            } else {
                echo "Fichier introuvable au chemin : " . htmlspecialchars($full_path);
            }
        } else {
            echo "Le chemin du fichier est vide.";
        }
    } else {
        echo "Échec de la préparation de la requête SQL : " . $conn->error;
    }
} else {
    echo "Aucun ID de fichier spécifié.";
}
?>
