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
$sql = "SELECT username FROM facilitateur WHERE username='$username'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $etudiant = mysqli_fetch_assoc($result);
} else {
    $etudiant = [];
}

// Retrieve the level of the logged-in instructor
$sql = "SELECT idN FROM facilitateur WHERE username='$username'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $facilitator = mysqli_fetch_assoc($result);
    $niveau_id = $facilitator['idN'];
} else {
    $niveau_id = 0;
}

// Fetch students in the same level
$students_sql = "SELECT id_E, username FROM etudiant WHERE idN='$niveau_id'";
$students_result = mysqli_query($conn, $students_sql);

if (!$students_result) {
    die('Error in SQL query: ' . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>

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
</style>


<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
              <small> Welcome,Facilitateur</small>
          </div>
      </a>
  <?php else: ?>
      <p>Aucun etudiant trouvé.</p>
  <?php endif; ?>
  </a>
        <div class="side-menu">
            <ul>
                <li>
                    <a href="dashboard.php">
                        <span class="fas fa-home"></span>
                        <small>Dashboard</small>
                    </a>
                </li>
                <li>
                        <a href="create_discussion.php">
                            <span class="fas fa-users-cog"></span>
                            <small>discussion</small>
                        </a>
                    </li>
                  
                    
                   
                    <li>
                      <a href="courseF.php">
                      <span class="fas fa-book-open"></span>
                            <small>Courses</small>
                        </a>
                    </li>
                    <li>
                       <a href="schedule/index.php">
                            <span class="fas fa-clipboard-list"></span>
                            <small>Schedule</small>
                        </a>
                    </li>
                    <li>
                       <a href="subjectF.php">
                            <span class="fas fa-clipboard-list"></span>
                            <small>Subjects</small>
                        </a>
                    </li>
                    <li>
            <a href="attendence.php">
    <span class="fas fa-calendar-check"></span>
    <small>Attendance</small>
</a>
        </li>
                    <li>
                       <a href="note.php" class="active">
                            <span class="fas fa-chart-bar"></span>
                            <small>Results</small>
                        </a>
                    </li>
                   
                </ul>
            </div>
        </div>
    </div>
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
                <div class="profile-img bg-img" style="background-image: url(images/admin1.png)"></div>
                    <span class="las la-power-off"></span>
                    <a href="login.php"><span>Logout</span></a>
                </div>
            </div>
        </div>
    </header>
    
    <div class="page-header">
        <h1>Courses</h1>
        <small>Home / Notes</small>
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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Ajouter note
        </button>
    </div>
    
    <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Etudiant</th>
                    <th>Titre</th>
                    <th>Matiere</th>
                    <th>Note</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <?php
                // Requête SQL pour obtenir les notes du niveau de l'instructeur
                $sql = "SELECT 
                            note.id, 
                            etudiant.username AS username,
                            note.titre, 
                            matiere.title AS matiere_nom, 
                            note.valeur
                        FROM note
                        JOIN etudiant ON etudiant.id_E = note.idE
                        JOIN matiere ON note.idM = matiere.id
                        WHERE etudiant.idN = '$niveau_id'";
                
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['titre']); ?></td>
                    <td><?php echo htmlspecialchars($row['matiere_nom']); ?></td>
                    <td><?php echo htmlspecialchars($row['valeur']); ?></td>
                    <td>
                        <a href="updateNote.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-warning">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                        <a href="removeNote.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger">
                            <i class="fa-solid fa-trash fs-5"></i>
                        </a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Ajouter une note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" method="post" action="addNote.php" enctype="multipart/form-data">
                        <!-- Champ Titre -->
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="titre" name="titre" placeholder="Entrer le titre" required>
                        </div>

                        <!-- Sélection de l'étudiant -->
                        <div class="mb-3">
                            <label for="id_etudiant" class="form-label">Étudiants</label>
                            <select class="form-select" id="id_etudiant" name="id_etudiant" required>
                                <option value="">Sélectionnez un étudiant</option>
                                <?php while ($student = mysqli_fetch_assoc($students_result)): ?>
                                    <option value="<?php echo htmlspecialchars($student['id_E']); ?>">
                                        <?php echo htmlspecialchars($student['username']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Sélection de la matière -->
                        <div class="mb-3">
                            <label for="id_matiere" class="form-label">Matière</label>
                            <select class="form-select" id="id_matiere" name="id_matiere" required>
                                <option value="">Sélectionnez une matière</option>
                                <?php
                                // Fetch matieres from database
                                $matiere_sql = "SELECT id, title FROM matiere";
                                $matiere_result = mysqli_query($conn, $matiere_sql);

                                while ($matiere = mysqli_fetch_assoc($matiere_result)) {
                                    echo '<option value="' . htmlspecialchars($matiere['id']) . '">' . htmlspecialchars($matiere['title']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <input type="number" class="form-control" id="note" name="note" placeholder="Enter note" min="0" max="20" step="0.1" required>
                    </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary">Ajouter Note</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>

</body>
</html>
