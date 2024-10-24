<?php
include('database/config.php');

$id = $_GET['id_N'];
// Delete dependent rows first
$delete_from_user = "DELETE FROM facilitateur WHERE idN = '$id'";
mysqli_query($conn, $delete_from_user);
$delete_from_user = "DELETE FROM etudiant WHERE idN = '$id'";
mysqli_query($conn, $delete_from_user);



$sql = "DELETE FROM `niveau` where id_N = $id ";
$result = mysqli_query($conn,$sql);

if($result){
    header("Location: niveau.php?msg=Record deleted successfully");
}
else{
    echo "Failed: ". mysqli_error($conn);
}
?>