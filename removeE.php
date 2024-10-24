<?php
include('database/config.php');
session_start();

$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
$translations = include("languages/$lang.php");

$id = $_GET['id_E'];
$delete_from_user = "DELETE FROM attendence WHERE id_E = '$id'";
mysqli_query($conn, $delete_from_user);


$sql = "DELETE FROM `etudiant` WHERE id_E = $id";
$result = mysqli_query($conn, $sql);

if($result) {
    header("Location: tableE.php?msg=" . $translations['record_deleted']);
} else {
    echo $translations['failed'] . ": " . mysqli_error($conn);
}
?>
