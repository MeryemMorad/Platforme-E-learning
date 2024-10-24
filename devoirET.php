<?php
session_start();
include 'database/config.php';

// Assurez-vous que l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Récupérer l'ID de l'étudiant depuis la session
$student_username = $_SESSION['username'];

// Récupérer l'ID de l'étudiant
$sql = "SELECT id_E, idN FROM etudiant WHERE username = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Erreur de préparation de la requête : ' . $conn->error);
}
$stmt->bind_param("s", $student_username);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$student_id = $student['id_E'];
$student_level_id = $student['idN'];

// Préparer la requête pour obtenir les devoirs du niveau de l'étudiant
$sql = "SELECT d.id, d.titre AS devoir_titre, m.title AS matiere_title, d.date_soumission, d.date_limite, d.document,
        TIMESTAMPDIFF(HOUR, NOW(), d.date_limite) AS temps_restant
        FROM devoir d
        INNER JOIN matiere m ON d.id_subject = m.id
        WHERE d.id_level = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Erreur de préparation de la requête : ' . $conn->error);
}
$stmt->bind_param("i", $student_level_id);
$stmt->execute();
$cours_result = $stmt->get_result();
$cours = [];
while ($row = $cours_result->fetch_assoc()) {
    $cours[] = $row;
}

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>

<?php

include 'database/config.php';

// Ensure the user is logged in and is an instructor
if (!isset($_SESSION['username']) ) {
    header('Location: login.php');
    exit;
}

// Retrieve the details of the logged-in instructor
$username = $_SESSION['username'];
$sql = "SELECT username FROM etudiant WHERE username='$username' ";
$result = mysqli_query($conn, $sql);

if ($result) {
    $enseignant = mysqli_fetch_assoc($result);
} else {
    $enseignant = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
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

.remaining-time {
            color: #d9534f; /* Red for overdue assignments */
        }
        
        
        .document-icon {
            color: #007bff; /* Blue for document icons */
        }
</style>

    
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>C<span>orp</span></h3>
        </div>
        
        <div class="side-content">
        <?php if (!empty($enseignant)): ?>
            <a href="profilee.php" class="profile-link">
                <div class="profile">
                    <div class="profile-img bg-img" style="background-image: url(images/admin1.png)"></div>
                    <h4><?php echo htmlspecialchars($enseignant['username']); ?></h4>
                    <small>Etudiant</small>
                </div>
            </a>
        <?php else: ?>
            <p>Aucun enseignant trouvé.</p>
        <?php endif; ?>
            <div class="side-menu">
                <ul>
                    <li>
                       <a href="" >
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                    <a href="devoirs.php" class="active">
          <span class="las la-file-alt"></span>
          <small>Devoirs</small>
       </a>
                    </li>
                    <li>
                        <a href="message_form.php">
                            <span class="fas fa-users-cog"></span>
                            <small>discussion</small>
                        </a>
                    </li>
                   
                    <li>
                      <a href="course.php" >
                      <span class="fas fa-book-open"></span>
                            <small>Courses</small>
                        </a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>

    <div class="main-content">
        
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>
                
                <div class="header-menu">
    
    <div class="user">
        <div class="bg-img" style="background-image: url(images/admin1.png)"></div>
        <span class="las la-power-off"></span>
        <a href="login.php"><span>Logout</span></a>
    </div>
</div>

            </div>
        </header>
        
    <div class="page-header">
        <h1>Devoirs</h1>
        <small>home/ Devoirs</small>
    </div>
    

        
    <div class="table-controls">
        <div class="entries">
            <label for="entries">Show</label>
            <select id="entries" onchange="changeEntries()">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <label for="entries">entries</label>
        </div>
        <div class="search">
            <label for="search">Search:</label>
            <input type="text" id="search" onkeyup="searchTable()" placeholder="Search...">
        </div>
    </div>
        
<div class="container">
   

    <div class="courses-container">
        <?php if (!empty($cours)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Matière</th>
                        <th>Titre du Devoir</th>
                        <th>Date de Soumission</th>
                        <th>Date Limite</th>
                        <th>Temps Restant</th>
                        <th>Document</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cours as $cour): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cour['matiere_title']); ?></td>
                            <td><?php echo htmlspecialchars($cour['devoir_titre']); ?></td>
                            <td><?php echo htmlspecialchars($cour['date_soumission']); ?></td>
                            <td><?php echo htmlspecialchars($cour['date_limite']); ?></td>
                            <td class="remaining-time">
                                <?php echo htmlspecialchars($cour['temps_restant'] > 0 ? $cour['temps_restant'] . ' heures restantes' : 'Date limite passée'); ?>
                            </td>
                            <td>
                                <a href="viewpdfD.php?id=<?php echo urlencode($cour['id']); ?>" target="_blank" class="document-icon">
                                    <i class="fa fa-file"></i>
                                </a>
                            </td>
                            <td>
    <!-- Afficher l'icône de rendu avec un bouton "Plus" -->
    <a href="submitD.php?id=<?php echo urlencode($cour['id']); ?>" style="color: #007bff; text-decoration: none;">
        <i class="fas fa-plus-circle"></i> 
    </a>
</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun devoir trouvé pour votre niveau.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
