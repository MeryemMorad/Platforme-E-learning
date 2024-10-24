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
  
    <style>
       #menu-toggle {
    display: none;
}

.sidebar {
    position: fixed;
    height: 100%;
    width: 165px;
    left: 0;
    bottom: 0;
    top: 0;
    z-index: 100;
    background: var(--color-dark);
    transition: left 300ms;
}

.side-header {
    box-shadow: 0px 5px 5px -5px rgb(0 0 0 /10%);
    background: var(--main-color);
    height: 60px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.side-header h3, side-head span {
    color: #fff;
    font-weight: 400;
}

.side-content {
    height: calc(100vh - 60px);
    overflow: auto;
}

/* width */
.side-content::-webkit-scrollbar {
  width: 5px;
}

/* Track */
.side-content::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
 
/* Handle */
.side-content::-webkit-scrollbar-thumb {
  background: #b0b0b0; 
  border-radius: 10px;
}

/* Handle on hover */
.side-content::-webkit-scrollbar-thumb:hover {
  background: #b30000; 
}

.profile {
    text-align: center;
    padding: 2rem 0rem;
}

.bg-img {
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 50%;
    background-size: cover;
}

.profile-img {
    height: 80px;
    width: 80px;
    display: inline-block;
    margin: 0 auto .5rem auto;
    border: 3px solid #899DC1;
}

.profile h4 {
    color: #fff;
    font-weight: 500;
}

.profile small {
    color: #899DC1;
    font-weight: 600;
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
    
</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>C<span>orp</span></h3>
        </div>
        
        <div class="side-content">
            <a href="profilee.php" class="profile-link">
                <div class="profile">
                    <div class="profile-img bg-img" style="background-image: url(images/admin1.png)"></div>
                    <h4>Meryem Morad</h4>
                    <small>Admin</small>
                </div>
            </a>
            <div class="side-menu">
                <ul>
                    <li>
                       <a href="admin.php" >
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                       <a href="ENtable.php" ">
                            <span class="las la-user-cog"></span>
                            <small>Enseignant</small>
                        </a>
                    </li>
                    <li>
                    <a href="tableE.php">
                            <span class="las la-user-cog"></span>
                            <small>Etudiant</small>
                        </a>
                    </li>
                    <li>
                    <a href="tableF.php">
                            <span class="las la-user-cog"></span>
                            <small>Facilitateur</small>
                        </a>
                    </li>
                    <li>
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
                       <a href="niveau.php">
                            <span class="fas fa-book"></span>
                            <small>Classes</small>
                        </a>
                    </li>
                    <li>
                      <a href="course.php">
                      <span class="fas fa-book-open"></span>
                            <small>Courses</small>
                        </a>
                    </li>
                    <li>
                       <a href="subject.php">
                            <span class="fas fa-clipboard-list"></span>
                            <small>Subjects</small>
                        </a>
                    </li>
                    </li>
                    <li>
    <a href="schedule/index.php">
        <span class="fas fa-calendar-alt"></span>
        <small>Schedule</small>
    </a>
</li>

                    <li>

            <a href="attendence_admin.php">
    <span class="fas fa-calendar-check"></span>
    <small>Attendance</small>
</a>
        </li>
                    <li>
                       <a href="noteA.php">
                            <span class="fas fa-chart-bar"></span>
                            <small>Results</small>
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
        <small> Home/Devoirs</small>
       
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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Soummettre un devoir
            </button>
            <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
            <th>Niveau</th>
            <th>Matiére</th>
            <th>Enseignant</th>
            <th>Date Soumission</th>
            <th>Date Limite</th>
            <th>Document</th>
            <th>Rendu</th>
            <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTable">
<?php
              include('database/config.php');

// Requête pour obtenir les informations de l'enseignant et les niveaux associés
$sql = "SELECT 
            devoir.id AS id,
            devoir.titre AS titre_de_devoir, 
            enseignant.username AS enseignant_nom, 
                        matiere.title AS matiere_nom, 
                        niveau.titre AS niveau_nom,
            devoir.date_soumission AS date_soumission, 
            devoir.date_limite AS date_limite, 
            devoir.document AS document,
           rendu_devoir.id_r AS rendu
        FROM devoir
        LEFT JOIN rendu_devoir ON devoir.id = rendu_devoir.id_devoir
        JOIN niveau ON devoir.id_level = niveau.id_N
        JOIN matiere ON devoir.id_subject = matiere.id
        JOIN enseignant ON devoir.id_prf=enseignant.id_EN";

// Execute the query and check for errors
$result = mysqli_query($conn, $sql);

if (!$result) {
    // Display error message if query fails
    die("Query failed: " . mysqli_error($conn));
} while ($row = mysqli_fetch_assoc($result)) {
?>
            <tr>
                <td><?php echo htmlspecialchars($row['titre_de_devoir']); ?></td>
                <td><?php echo htmlspecialchars($row['niveau_nom']); ?></td>
                <td><?php echo htmlspecialchars($row['matiere_nom']); ?></td>
                <td><?php echo htmlspecialchars($row['enseignant_nom']); ?></td>
                <td><?php echo htmlspecialchars($row['date_soumission']); ?></td>
                <td><?php echo htmlspecialchars($row['date_limite']); ?></td>
                <td>
                    <!-- Document Icon with Link to viewpdf.php -->
                    <a href="viewpdfD.php?id=<?php echo urlencode($row['id']); ?>"  target="_blank">
                        <i class="fa-solid fa-file"></i>
                    </a>
                </td>
                 <td>
    <!-- Button to show list of students who submitted -->
    <a href="submitted_students.php?id=<?php echo urlencode($row['id']); ?>" style="background-color: #007bff; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">
        <i class="fas fa-eye"></i>
    </a>
</td>

                <td>
                    <a href="updateD.php?id=<?php echo urlencode($row['id']); ?>" class="link-light btn btn-warning">
                        <i class="fa-solid fa-edit"></i>
                    </a>
                    <a href="removeD.php?id=<?php echo urlencode($row['id']); ?>" class="link-light btn btn-danger">
                        <i class="fa-solid fa-trash fs-5"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
            </tbody>
        </table>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="script.js"></script>
</body>
</html>