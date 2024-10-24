<?php
include('database/config.php');
$id = intval($_GET['id']); // Sanitize input

$sql = "DELETE FROM `devoir` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: devoirEN.php?msg=Record deleted successfully");
} else {
    echo "Failed: " . mysqli_error($conn);
}
?>
