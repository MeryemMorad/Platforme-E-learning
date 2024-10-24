<?php
include('database/config.php');
$id = $_GET['id_EN'];
$delete_from_en = "DELETE FROM devoir WHERE id_prf = '$id'";
mysqli_query($conn, $delete_from_en);
$delete_from_e = "DELETE FROM rendu_devoir WHERE id_prf = '$id'";
mysqli_query($conn, $delete_from_e);
$delete_from_user = "DELETE FROM cours WHERE id_enseignant = '$id'";
mysqli_query($conn, $delete_from_user);
    $sql_delete_user = "DELETE FROM enseignant WHERE id_EN = $id";
    $result_user = mysqli_query($conn, $sql_delete_user);

    if ($result_user) {
        header("Location: ENtable.php?msg=Record deleted successfully");
    } else {
        echo "Failed to delete user: " . mysqli_error($conn);
    }

?>
