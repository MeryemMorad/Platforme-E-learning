<?php
include('database/config.php');
$id = $_GET['id_F'];

$sql = "DELETE FROM `facilitateur` where id_F= $id ";
$result = mysqli_query($conn,$sql);

if($result){
    header("Location: tableF.php?msg=Record deleted successfully");
}
else{
    echo "Failed: ". mysqli_error($conn);
}
?>