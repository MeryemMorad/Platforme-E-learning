<?php
include 'database/config.php';
session_start(); // Démarrer la session

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirige vers la page de connexion si non connecté
    exit();
}

// Récupérer l'ID de l'enseignant à partir du nom d'utilisateur
$username = mysqli_real_escape_string($conn, $_SESSION['username']);
$sql_enseignant = "SELECT id_EN FROM enseignant WHERE username = '$username' LIMIT 1";
$result_enseignant = mysqli_query($conn, $sql_enseignant);

if ($result_enseignant && mysqli_num_rows($result_enseignant) > 0) {
    $row_enseignant = mysqli_fetch_assoc($result_enseignant);
    $enseignant_id = intval($row_enseignant['id_EN']);
} else {
    die('Impossible de récupérer l\'ID de l\'enseignant.');
}

// Récupérer le niveau enseigné par l'enseignant
$sql_niveau = "SELECT id_N FROM enseignant_niveau WHERE id_EN = $enseignant_id LIMIT 1";
$result_niveau = mysqli_query($conn, $sql_niveau);

if ($result_niveau && mysqli_num_rows($result_niveau) > 0) {
    $row_niveau = mysqli_fetch_assoc($result_niveau);
    $niveau_id = intval($row_niveau['id_N']);
} else {
    die('Impossible de récupérer le niveau enseigné par cet enseignant.');
}

// Requête pour récupérer les devoirs soumis
$sql = "
SELECT 
    e.username AS etudiant_nom, 
    rd.date_rendu, 
    rd.fichier,
    rd.id_r AS id_r 
FROM 
    rendu_devoir rd
JOIN 
    etudiant e ON rd.id_etudiant = e.id_E
JOIN 
    devoir d ON rd.id_devoir = d.id
JOIN 
    enseignant_niveau en ON en.id_N = e.idN
WHERE 
    en.id_EN = $enseignant_id
AND 
    e.idN = $niveau_id
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Erreur lors de l'exécution de la requête : " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    

<style>
           body {
    background-color: #f8f9fa;
}
.sidebar .profile-img {
    width: 60px;
    height: 60px;
    background-size: cover;
    background-position: center;
    border-radius: 50%;
}

.sidebar .profile h4 {
    color: #fff;
}

.sidebar .side-menu ul {
    list-style: none;
    padding: 0;
}

.sidebar .side-menu ul li {
    margin: 0.5rem 0;
}

.sidebar .side-menu ul li a {
    color: #fff;
    text-decoration: none;
}

.sidebar .side-menu ul li a.active {
    background-color: #495057;
}

    .page-header {
    padding: 4.3rem 1rem;
    background: #E9edf2;
    border-bottom: 1px solid #dee2e8;
}

.page-header h1, .page-header small {
    color: #74767d;
}
.back-button {
    background-color: #007bff; /* Bright blue background */
    color: #ffffff; /* White text */
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
    font-size: 16px;
    font-weight: bold;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.back-button:hover {
    background-color: #0056b3; /* Darker blue on hover */
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.back-button:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5); /* Blue outline on focus */
}
/* Style pour le champ de sélection */
.form-container select {
    width: 300px; /* Définir la largeur fixe en pixels */
    height: 40px; /* Définir la hauteur fixe en pixels */
    padding: 8px 12px; /* Ajuster le padding pour un meilleur rendu */
    border: 1px solid #ced4da;
    border-radius: 5px;
    font-size: 16px;
    color: #495057;
    background-color: #ffffff;
    box-sizing: border-box;
    cursor: pointer;
    transition: border-color 0.3s ease;
}

/* Style pour le champ de sélection au focus */
.form-container select:focus {
    border-color: #007bff;
    outline: none;
}


</style>

<table class="table">
    <thead>
        <tr>
            <th>Nom de l'étudiant</th>
            <th>Date de rendu</th>
            <th>Devoir</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['etudiant_nom']); ?></td>
            <td><?php echo htmlspecialchars($row['date_rendu']); ?></td>
            <td>
                <a href="viewpdfDE.php?id_r=<?php echo htmlspecialchars($row['id_r']); ?>" target="_blank">jik
                    <i class="fa-solid fa-file"></i>
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php
mysqli_close($conn); // Fermer la connexion à la base de données
?>
</body>
</html>