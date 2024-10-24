<?php
include('database/config.php');
$id = $_GET['id'];

$sql = "DELETE FROM `note` where id= $id ";
$result = mysqli_query($conn,$sql);

if($result){
    header("Location: noteA.php?msg=Record deleted successfully");
}
else{
    echo "Failed: ". mysqli_error($conn);
}
?>