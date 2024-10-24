<?php
include('database/config.php');
$id = $_GET['id'];

// Delete related records from the `devoir` table where `id_subject` matches
$delete_from_devoir = "DELETE FROM devoir WHERE id_subject = '$id'";
mysqli_query($conn, $delete_from_devoir);

// Delete related records from the `cours` table where `id` matches
$delete_from_cours = "DELETE FROM cours WHERE id = '$id'";
mysqli_query($conn, $delete_from_cours);

// Delete related records from the `enseignant` table where `id_M` matches
$delete_from_enseignant = "DELETE FROM enseignant WHERE id_M = '$id'";
mysqli_query($conn, $delete_from_enseignant);

// Finally, delete the record from the `matiere` table
$sql_delete_matiere = "DELETE FROM matiere WHERE id = $id";
$result_user = mysqli_query($conn, $sql_delete_matiere);

if ($result_user) {
    header("Location: subject.php?msg=Record deleted successfully");
} else {
    echo "Failed to delete the record: " . mysqli_error($conn);
}
?>
