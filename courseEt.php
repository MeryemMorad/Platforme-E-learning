<?php
include 'database/config.php'; 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) ) {
    header('Location: login.php');
    exit;
}

// Assurez-vous que le nom d'utilisateur est correctement défini
$username = $_SESSION['username'];

// Récupérer le niveau de l'étudiant connecté
$sql = "SELECT n.id_N, n.description
        FROM niveau n
        INNER JOIN etudiant u ON u.idN = n.id_N
        WHERE u.username = ? ";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$niveau = $result->fetch_assoc();

if (!$niveau) {
    die("Niveau non trouvé pour cet étudiant.");
}

$niveauId = $niveau['id_N'];

// Préparer un tableau pour stocker les cours pour ce niveau
$coursParNiveau = [];

// Récupérer les cours pour ce niveau
$sql = "SELECT c.id_c,Ttitre, m.title AS matiere_titre, c.file_path
        FROM cours c
        JOIN matiere m ON c.id = m.id
        WHERE c.id_N = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $niveauId);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $coursParNiveau = $result->fetch_all(MYSQLI_ASSOC);
}

// Fermer la connexion
$conn->close();

// Define colors for the cards
$colors = ['blue', 'green', 'orange', 'red', 'purple', 'teal', 'yellow', 'pink'];
?>
<?php
session_start();
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
    $etudiant = mysqli_fetch_assoc($result);
} else {
    $etudiant = [];
}


?>
<style>
  
 .containere.button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }
       .containere .button:hover {
            background-color: #0056b3;
        }
       .containere .view-button {
    background: #fbc02d; /* Light mustard yellow */
    color: #333;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background 0.3s, box-shadow 0.3s;
    font-size: 16px;
}

.view-button:hover {
    background: #f9a825; /* Mustard yellow */
    color: #fff;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.back-button {
    background-color: #fbc02d; /* Light mustard yellow */
    color: #333;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s;
    margin-bottom: 20px;
    font-size: 16px;
}

.back-button:hover {
    background-color: #f9a825; /* Mustard yellow */
    color: #fff;
}


    </style>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Cours pour votre Niveau</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffff;
        }

        .dashboard {
    display: flex; /* Use flexbox for layout */
    flex-wrap: wrap; /* Allow cards to wrap to the next line */
    justify-content: center; /* Center the cards */
    margin-top: 50px;
}

.card {
    flex: 0 1 200px; /* Flex-grow 0, flex-shrink 1, base width 200px */
    margin: 10px; /* Add some margin around the cards */
    border-radius: 8px;
    overflow: hidden;
    text-align: center;
    color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s;
}

.card:hover {
    transform: translateY(-10px);
}
.card-footer {
            padding: 10px;
            background-color: #fff;
            color: #333;
        }

        .card-footer a {
            color: inherit;
            text-decoration: none;
            font-weight: bold;
        }
/* Define colors for the cards */
.card.blue {
    background-color: #3498db;
}

.card.green {
    background-color: #2ecc71;
}

.card.orange {
    background-color: #f39c12;
}

.card.red {
    background-color: #e74c3c;
}

.card.purple {
    background-color: #9b59b6;
}

.card.teal {
    background-color: #1abc9c;
}

.card.yellow {
    background-color: #f1c40f;
}

.card.pink {
    background-color: #e91e63;
}
.view-button, .back-button {
            background-color: #fbc02d; 
            color: #333;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 5px;
        }
        .view-button:hover, .back-button:hover {
            background-color: #f9a825; 
            color: #fff;
        }
    </style>
<input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>C<span>orp</span></h3>
        </div>
        
        <div class="side-content">
        <?php if (!empty($etudiant)): ?>
          
                <div class="profile">
                    <div class="profile-img bg-img" style="background-image: url(images/admin1.png)"></div>
                    <h4><?php echo htmlspecialchars($etudiant['username']); ?></h4>
                    <small>Etudiant</small>
                </div>
            </a>
        <?php else: ?>
            <p>Aucun etudiant trouvé.</p>
        <?php endif; ?>
   
            </a>
            <div class="side-menu">
                <ul>
                    <li>
                       <a href="" >
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                    <a href="devoirs.php">
          <span class="las la-file-alt"></span>
          <small>Devoirs</small>
       </a>
                    </li>
                    <li>
    <a href="message.php">
        <span class="fas fa-envelope"></span>
        <small>Discussion</small>
    </a>
</li>
                    
                    <li>
    <a href="schedule/index.php">
        <span class="fas fa-calendar-alt"></span>
        <small>Schedule</small>
    </a>
</li>

                    <li>
                      <a href="courseEt.php" class="active">
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
        <div class="container">
    <h1 class="mt-5">Mes Cours</h1>
    <div class="row dashboard">
        <?php if (!empty($coursParNiveau)): ?>
            <?php foreach ($coursParNiveau as $index => $cours): ?>
                <div class="col-12 col-sm-6 col-md-4"> <!-- Responsive columns -->
                    <div class="card <?php echo $colors[$index % count($colors)]; ?>">
                        <div class="card-header">
                            <h5 class="card-title"><?php echo htmlspecialchars($cours['matiere_titre']); ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?php echo htmlspecialchars($cours['Ttitre']); ?></p>
                            
                        </div>
                        <div class="card-footer">
                            <?php if (!empty($cours['file_path'])): ?>
                                <a href="<?php echo htmlspecialchars($cours['file_path']); ?>" class="btn btn-primary view-button">Voir le Cours <i class="fas fa-arrow-circle-right"></i></a>
                            <?php else: ?>
                                <span class="text-danger">Fichier non disponible</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning col-12">Aucun cours disponible pour votre niveau.</div>
        <?php endif; ?>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
 