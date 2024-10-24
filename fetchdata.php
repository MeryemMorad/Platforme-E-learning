<?php
include('database/config.php');

// Query to get the number of boys and girls per level
$sql = "SELECT 
            niveau.titre AS level,
            SUM(CASE WHEN etudiant.gender = 'male' THEN 1 ELSE 0 END) AS boys,
            SUM(CASE WHEN etudiant.gender = 'female' THEN 1 ELSE 0 END) AS girls,
            COUNT(etudiant.id_E) AS total_students
        FROM 
            niveau
        LEFT JOIN 
            etudiant ON etudiant.idN = niveau.id_N 
        GROUP BY 
            niveau.id_N, niveau.titre";

$result = mysqli_query($conn, $sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Return data as JSON
echo json_encode($data);
?>
