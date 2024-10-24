<?php
include('database/config.php');

$response = [
    'etudiant' => 0,
    'enseignant' => 0,
    'facilitateur' => 0
];

// Count users in the 'etudiant' table
$sql_etudiant = "SELECT COUNT(id_E) as count FROM etudiant";
$result_etudiant = mysqli_query($conn, $sql_etudiant);
if ($row_etudiant = mysqli_fetch_assoc($result_etudiant)) {
    $response['etudiant'] = $row_etudiant['count'];
}

// Count users in the 'enseignant' table
$sql_enseignant = "SELECT COUNT(id_EN) as count FROM enseignant";
$result_enseignant = mysqli_query($conn, $sql_enseignant);
if ($row_enseignant = mysqli_fetch_assoc($result_enseignant)) {
    $response['enseignant'] = $row_enseignant['count'];
}

// Count users in the 'facilitateur' table
$sql_facilitateur = "SELECT COUNT(id_F) as count FROM facilitateur";
$result_facilitateur = mysqli_query($conn, $sql_facilitateur);
if ($row_facilitateur = mysqli_fetch_assoc($result_facilitateur)) {
    $response['facilitateur'] = $row_facilitateur['count'];
}

echo json_encode($response);
?>
