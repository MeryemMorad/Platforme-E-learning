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
    <title>Modern Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .container {
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }
        .chart-container {
            width: 45%;
        }
     

        .container {
    text-align: center;
    margin-top: 100px; /* Increase margin at the top for more spacing */
}

h1 {
    color: #333;
}

.btn {
    display: inline-block;
    padding: 10px 20px; /* Padding for the button */
    font-size: 14px; /* Font size */
    color: #fff;
    background-color: #3498db;
    border: none;
    border-radius: 5px;
    text-decoration: none; /* Removes underline from the link */
    transition: background-color 0.3s;
    margin-top: 30px; /* Add margin at the top to lower the button */
}

.btn:hover {
    background-color: #2980b9; /* Darker blue on hover */
}
    </style>
</head>
<body>
<script src="script.js"></script>

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
                       <a href="enseignant.php" class="active">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    
                    <li>
    <a href="message.php">
        <span class="fas fa-envelope"></span>
        <small>Discussion</small>
    </a>
</li>
                   
                    <li>
                      <a href="courseEN.php">
                      <span class="fas fa-book-open"></span>
                            <small>Courses</small>
                        </a>
                    </li>
                    <li>
                      <a href="devoirEN.php">
                      <span class="fas fa-book-open"></span>
                            <small>Devoirs</small>
                        </a>
                    </li>
                  
                    <li>
    <a href="schedule/index.php">
        <span class="fas fa-calendar-alt"></span>
        <small>Schedule</small>
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
        
        <main>
<?php

include 'database/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) ) {
header('Location: login.php');
exit;
}
// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Retrieve the username from the session
$username = mysqli_real_escape_string($conn, $_SESSION['username']);

// Query to get the unique levels for the logged-in instructor
$sql = "SELECT DISTINCT n.titre 
        FROM enseignant_niveau en 
        INNER JOIN niveau n ON en.id_N = n.id_N 
        INNER JOIN enseignant e ON e.id_EN = en.id_EN 
        WHERE e.username='$username'";
$result = mysqli_query($conn, $sql);

$levels = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $levels[] = $row['titre'];
    }
} else {
    $levels[] = 'Aucun niveau trouvé'; // Default message if no levels are found
}

mysqli_close($conn);
?>

            <div class="page-header">
                <h1>Enseignant</h1>
                <small>Niveaux:</small>
       
                    <?php if (!empty($levels) && $levels[0] !== 'Aucun niveau trouvé') : ?>
                        <?php foreach ($levels as $level) : ?>
                           <?php echo htmlspecialchars($level); ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        Non définis
                    <?php endif; ?>
                
            </div>
      
            <?php

include 'database/config.php';

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Retrieve the details of the logged-in instructor
$username = $_SESSION['username'];
$sql = "SELECT e.username, m.title AS matiere_titre, m.description AS matiere_description, m.image AS matiere_image
        FROM enseignant e
        INNER JOIN matiere m ON e.id_M = m.id
        WHERE e.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check for SQL errors
if ($result === false) {
    die('SQL error: ' . $conn->error);
}

// Fetch instructor and subject details
if ($result->num_rows > 0) {
    $enseignant = $result->fetch_assoc();
} else {
    $enseignant = [];
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<a href="students_list.php" class="btn">Voir la liste des étudiants</a>
<!-- Display the instructor and subject details in a card -->
<div class="analytics">
    <div class="card">
        <div class="card-head">
            
        </div>
        <div class="card-body">
            <!-- Display the image -->
            <?php if (!empty($enseignant['matiere_image'])): ?>
    <a href="courseEN.php">
        <img src="images/<?php echo htmlspecialchars($enseignant['matiere_image']); ?>" alt="<?php echo htmlspecialchars($enseignant['matiere_titre']); ?>" style="width: 100%; height: auto;">
    </a>
<?php else: ?>
    <p>No image available</p>
<?php endif; ?>

            <h3><?php echo htmlspecialchars($enseignant['matiere_titre']); ?></h3>
            <p><?php echo htmlspecialchars($enseignant['matiere_description']); ?></p>
        </div>
    </div>
</div>
</body>
</html>

</body>
</html>
