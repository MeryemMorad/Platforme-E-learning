<?php
include 'database/config.php'; 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

$sql = "SELECT n.id_N, n.description
        FROM niveau n
        INNER JOIN facilitateur u ON u.idN = n.id_N
        WHERE u.username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$niveau = $result->fetch_assoc();

if (!$niveau) {
    die("Niveau non trouvé pour cet étudiant.");
}

$niveauId = $niveau['id_N'];

$coursParNiveau = [];

$sql = "SELECT c.id_c, m.title AS matiere_titre, Ttitre, c.file_path
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
$sql = "SELECT username FROM facilitateur WHERE username='$username' ";
$result = mysqli_query($conn, $sql);

if ($result) {
    $etudiant = mysqli_fetch_assoc($result);
} else {
    $etudiant = [];
}


?>
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


.side-menu ul {
    text-align: center;
}

.side-menu a {
    display: block;
    padding: 1.2rem 0rem;
}

/*.side-menu a.active {
    background: #2B384E;
}*/

.side-menu a.active span, .side-menu a.active small {
    color: #fff;
}

.side-menu a span {
    display: block;
    text-align: center;
    font-size: 1.7rem;
}

.side-menu a span, .side-menu a small {
    color: #899DC1;
}

#menu-toggle:checked ~ .sidebar {
    width: 60px;
}

#menu-toggle:checked ~ .sidebar .side-header span {
    display: none;
}

#menu-toggle:checked ~ .main-content {
    margin-left: 60px;
    width: calc(100% - 60px);
}

#menu-toggle:checked ~ .main-content header {
    left: 60px;
}

#menu-toggle:checked ~ .sidebar .profile,
#menu-toggle:checked ~ .sidebar .side-menu a small {
    display: none;
}

#menu-toggle:checked ~ .sidebar .side-menu a span {
    font-size: 1.3rem;
}


.main-content {
    margin-left: 165px;
    width: calc(100% - 165px);
    transition: margin-left 300ms;
}

header {
    position: fixed;
    right: 0;
    top: 0;
    left: 165px;
    z-index: 100;
    height: 60px;
    box-shadow: 0px 5px 5px -5px rgb(0 0 0 /10%);
    background: #fff;
    transition: left 300ms;
}

.header-content, .header-menu {
    display: flex;
    align-items: center;
}

.header-content {
    justify-content: space-between;
    padding: 0rem 1rem;
}

.header-content label:first-child span {
    font-size: 1.3rem;
}

.header-content label {
    cursor: pointer;
}

.header-menu {
    justify-content: flex-end;
    padding-top: .5rem;
}

.header-menu label,
.header-menu .notify-icon {
    margin-right: 2rem;
    position: relative;
}

.header-menu label span,
.notify-icon span:first-child {
    font-size: 1.3rem;
}

.notify-icon span:last-child {
    position: absolute;
    background: var(--main-color);
    height: 16px;
    width: 16px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    right: -5px;
    top: -5px;
    color: #fff;
    font-size: .8rem;
    font-weight: 500;
}

.user {
    display: flex;
    align-items: center;
}

.user div, .client-img {
    height: 40px;
    width: 40px;
    margin-right: 1rem;
}

.user span:last-child {
    display: inline-block;
    margin-left: .3rem;
    font-size: .8rem;
}
.header-menu .notify-icon {
    position: relative;
    cursor: pointer;
}

.header-menu .notify-icon span {
    font-size: 1.3rem;
    color: #333;
}

.header-menu .notify-icon .badge {
    position: absolute;
    background: var(--main-color);
    height: 16px;
    width: 16px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    right: -5px;
    top: -5px;
    color: #fff;
    font-size: .8rem;
    font-weight: 500;
}
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 

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
</head>
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
                      <a href="courseF.php" class="active">
                      <span class="fas fa-book-open"></span>
                            <small>Courses</small>
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
                       <a href="">
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
        
        <button class="back-button" onclick="window.history.back()">Retour</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Add Course
            </button>
             <!-- Modal -->
           <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" method="post" action="addC.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Subject Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Subject Description" required>
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
                        <label for="file" class="form-label">Add Document</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx" required>
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

    <div class="container">
        <div class="row dashboard">
            <?php foreach ($coursParNiveau as $index => $cours): ?>
                <div class="col-12 col-sm-6 col-md-4"> <!-- Responsive columns -->
                    <div class="card <?php echo $colors[$index % count($colors)]; ?>">
                        <div class="card-header">
                          
                        </div>
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($cours['matiere_titre']); ?></h3>
                            <p><?php echo htmlspecialchars($cours['Ttitre']); ?></p>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo htmlspecialchars($cours['file_path']); ?>">Voir le Cours <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
