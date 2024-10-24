<?php
session_start();
include 'database/config.php';

// Assurez-vous que l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Récupérez le nom d'utilisateur de la session
$username = $_SESSION['username'];

// Préparer la requête pour obtenir les niveaux associés à l'enseignant
$sql = "SELECT n.id_N, n.titre 
        FROM enseignant_niveau en
        INNER JOIN niveau n ON en.id_N = n.id_N
        INNER JOIN enseignant e ON e.id_EN = en.id_EN
        WHERE e.username = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Erreur de préparation de la requête : ' . $conn->error);
}
$stmt->bind_param("s", $username);
$stmt->execute();
$niveaux_result = $stmt->get_result();

// Préparer la requête pour obtenir la matière de l'enseignant
$sql = "SELECT id_M FROM enseignant WHERE username = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Erreur de préparation de la requête : ' . $conn->error);
}
$stmt->bind_param("s", $username);
$stmt->execute();
$matiere_result = $stmt->get_result();
$matiere_id = $matiere_result->fetch_assoc()['id_M'];

// Préparer la requête pour obtenir les devoirs en fonction du niveau sélectionné et de la matière de l'enseignant
$selected_niveau_id = isset($_POST['niveau']) ? intval($_POST['niveau']) : 0;
$cours = [];
if ($selected_niveau_id > 0) {
    $sql = "SELECT d.id, d.titre AS devoir_titre, m.title AS matiere_title, d.date_soumission, d.date_limite, d.document
            FROM devoir d
            INNER JOIN matiere m ON d.id_subject = m.id
            WHERE d.id_level = ? AND d.id_subject = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Erreur de préparation de la requête : ' . $conn->error);
    }
    $stmt->bind_param("ii", $selected_niveau_id, $matiere_id);
    $stmt->execute();
    $cours_result = $stmt->get_result();
    while ($row = $cours_result->fetch_assoc()) {
        $cours[] = $row;
    }
}

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
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
$sql = "SELECT username FROM enseignant WHERE username='$username' ";
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
                    <small>Enseignant</small>
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
        <small>Dashboard / Devoirs</small>
    </div>
    

        <!-- Formulaire de sélection du niveau -->
        <div class="form-container">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Soummettre un devoir 
            </button>
            <form method="post" action="">
                <label for="niveau">Choisissez un niveau :</label>
                <select name="niveau" id="niveau" onchange="this.form.submit()">
                    <option value="">Sélectionner un niveau</option>
                    <?php while ($niveau = $niveaux_result->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($niveau['id_N']); ?>" <?php echo ($selected_niveau_id == $niveau['id_N']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($niveau['titre']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </form>
        </div>

        <!-- Affichage des devoirs pour le niveau sélectionné -->
        <?php if ($selected_niveau_id > 0): ?>
            <div class="courses-container">
                
                <?php if (!empty($cours)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Titre</th>
                                <th>Matière</th>
                                <th>Date de soumission</th>
                                <th>Date limite</th>
                                <th>Document</th>
                              <th>Rendu</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cours as $cour): ?>
                                <tr>
                                <td><?php echo htmlspecialchars($cour['id']); ?></td>
                                    <td><?php echo htmlspecialchars($cour['devoir_titre']); ?></td>
                                    <td><?php echo htmlspecialchars($cour['matiere_title']); ?></td>
                                    <td><?php echo htmlspecialchars($cour['date_soumission']); ?></td>
                                    <td><?php echo htmlspecialchars($cour['date_limite']); ?></td>
                                    <td>
                                    <a href="viewpdfD.php?id=<?php echo urlencode($cour['id']); ?>" target="_blank">
    <i class="fa-solid fa-file"></i>
</a>
                            </td>
                            <td>
    <!-- Button to show list of students who submitted -->
    <a href="submitted_students.php?id=<?php echo urlencode($cour['id']); ?>" style="background-color: #007bff; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">
        <i class="fas fa-eye"></i>
    </a>
</td>


                <td>
                    <a href="updateD.php?id=<?php echo urlencode($cour['id']); ?>" class="link-light btn btn-warning">
                        <i class="fa-solid fa-edit"></i>
                    </a>
                    <a href="removeD.php?id=<?php echo urlencode($cour['id']); ?>" class="link-light btn btn-danger">
                        <i class="fa-solid fa-trash fs-5"></i>
                    </a>
                </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucun devoir trouvé pour ce niveau.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
     <!-- Modal -->
     <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" method="post" action="addD.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="entrer le nom de devoir" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="matiere" class="form-label">Matiere</label>
                        <select class="form-select" id="matiere" name="matiere" required>
                            <?php
                            include('database/config.php');
                            $sql = "SELECT id, title FROM matiere";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id']}'>{$row['title']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="niveau" class="form-label">Niveau</label>
                        <select class="form-select" id="niveau" name="niveau" required>
                            <?php
                            $sql = "SELECT id_N, titre FROM niveau";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id_N']}'>{$row['titre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_enseignant" class="form-label">Enseignant</label>
                        <select class="form-select" id="id_enseignant" name="id_enseignant" required>
                            <?php
                            $sql = "SELECT  id_EN,username FROM enseignant";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id_EN']}'>{$row['username']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_soumission" class="form-label">Date  de Soumission</label>
                        <input type="datetime-local" class="form-control" id="date_soumission" name="date_soumission" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="date_limite" class="form-label">Date Limite</label>
                        <input type="datetime-local" class="form-control" id="date_limite" name="date_limite" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="file" class="form-label">Add Document</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="save-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <script src="script.js"></script>
</body>
</html>
