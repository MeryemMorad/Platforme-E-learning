<?php
include('database/config.php');
$id = $_GET['id_c'];

$sql = "DELETE FROM `cours` where id_c = $id ";
$result = mysqli_query($conn,$sql);

if($result){
    header("Location: course.php?msg=Record deleted successfully");
}
else{
    echo "Failed: ". mysqli_error($conn);
}
?>