<?php
include('database/config.php');

// Get the file ID from the URL
$id_c = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_c) {
    // Prepare the SQL statement to fetch the file path
    $sql = "SELECT document FROM devoir WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_c);
    $stmt->execute();
    $stmt->bind_result($file_path);
    $stmt->fetch();
    $stmt->close();

    // Debugging: Output the file path
    echo "File path: " . htmlspecialchars($file_path) . "<br>";

    if ($file_path && file_exists($file_path)) {
        // Determine the file's MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file_path);
        finfo_close($finfo);

        // Set headers to display the file
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));

        // Clear output buffer
        ob_clean();
        flush();

        // Read the file and output it
        readfile($file_path);
        exit;
    } else {
        echo "File not found at path: " . htmlspecialchars($file_path);
    }
} else {
    echo "No file ID specified.";
}
?>
