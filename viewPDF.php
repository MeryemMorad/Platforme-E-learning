<?php
include('database/config.php');

// Récupérer l'ID du fichier à partir de l'URL
$id_c = isset($_GET['id_c']) ? $_GET['id_c'] : null;

if ($id_c) {
    // Préparer la requête pour récupérer le chemin du fichier
    $sql = "SELECT file_path FROM cours WHERE id_c = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_c);
    $stmt->execute();
    $stmt->bind_result($file_path);
    $stmt->fetch();
    $stmt->close();

    // Debugging: Output the file path
    echo "Chemin du fichier : " . htmlspecialchars($file_path) . "<br>";

    if ($file_path && file_exists($file_path)) {
        // Obtenir le type MIME du fichier
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file_path);
        finfo_close($finfo);

        // Définir les en-têtes pour afficher le fichier
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));

        // Vider le tampon de sortie
        ob_clean();
        flush();

        // Lire et afficher le fichier
        readfile($file_path);
        exit;
    } else {
        echo "Fichier introuvable à l'emplacement : " . htmlspecialchars($file_path);
    }
} else {
    echo "Aucun ID de fichier spécifié.";
}
?>
