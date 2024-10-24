<?php
session_start();
include 'database/config.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Retrieve the details of the logged-in student
$username = $_SESSION['username'];
$sql = "SELECT u.username, u.idN, n.titre 
        FROM facilitateur u 
        INNER JOIN niveau n ON u.idN = n.id_N
        WHERE u.username='$username'";

// Error checking for SQL query
$result = mysqli_query($conn, $sql);
if (!$result) {
    die('Error in SQL query: ' . mysqli_error($conn));
}

if ($result) {
    $etudiant = mysqli_fetch_assoc($result);
} else {
    $etudiant = [];
}

// If we have the student's level, fetch the counts
if (!empty($etudiant)) {
    $niveau_id = $etudiant['idN'];

    // Fetch the number of students in the same level
    $student_count_sql = "SELECT COUNT(*) as student_count 
                          FROM etudiant 
                          WHERE idN='$niveau_id'";
    $student_count_result = mysqli_query($conn, $student_count_sql);
    if (!$student_count_result) {
        die('Error in SQL query: ' . mysqli_error($conn));
    }
    $student_count = mysqli_fetch_assoc($student_count_result)['student_count'];

    // Fetch the number of teachers teaching that level
    $teacher_count_sql = "SELECT COUNT(DISTINCT id_EN) as teacher_count 
                      FROM enseignant_niveau 
                      WHERE id_N = '$niveau_id'";

    $teacher_count_result = mysqli_query($conn, $teacher_count_sql);
    if (!$teacher_count_result) {
        die('Error in SQL query: ' . mysqli_error($conn));
    }
    $teacher_count = mysqli_fetch_assoc($teacher_count_result)['teacher_count'];

    // Fetch the number of subjects
    $subject_count_sql = "SELECT COUNT(*) as subject_count FROM matiere";
    $subject_count_result = mysqli_query($conn, $subject_count_sql);
    if (!$subject_count_result) {
        die('Error in SQL query: ' . mysqli_error($conn));
    }
    $subject_count = mysqli_fetch_assoc($subject_count_result)['subject_count'];
} else {
    $student_count = $teacher_count = $subject_count = 0;
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
<script src="script.js"></script>
<?php include 'headerF.php';?>

  
    <div class="page-content">
                 <!-- Button to view students in the same level -->
                 <a href="liststudents.php" class="button">Voir la liste des etudiants</a>
    <div class="analytics">
        <div class="card">
            <div class="card-head">
                <h2 ><?php echo $student_count; ?></h2>
                <i class="fa-solid fa-user-graduate"></i> <!-- Student icon -->
            </div>
            <div class="card-progress">
                <small>Students</small>
                <div class="card-indicator">
                    <div class="indicator one" style="width: 60%;"></div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <h2 ><?php echo $teacher_count; ?></h2>
                <i class="fa-solid fa-chalkboard-teacher"></i> <!-- Teacher icon -->
            </div>
            <div class="card-progress">
                <small>Teachers</small>
                <div class="card-indicator">
                    <div class="indicator two" style="width: 80%;"></div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <h2 ><?php echo $subject_count; ?></h2>
                <i class="fa-solid fa-book"></i>
                <!-- Facilitator icon -->
            </div>
            <div class="card-progress">
                <small>Subjects</small>
                <div class="card-indicator">
                    <div class="indicator three" style="width: 65%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
