<?php
session_start();
include('database/config.php');

// Ensure the user is logged in and is a teacher
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch the facilitator's details using username
$facilitator_query = "SELECT u.username AS facilitator_name, u.idN AS niveau_id, u.id_F AS id_facilitator
                      FROM facilitateur u
                      WHERE u.username = ?";
$stmt = $conn->prepare($facilitator_query);
$stmt->bind_param('s', $username);
$stmt->execute();
$facilitator_result = $stmt->get_result();
$facilitator = $facilitator_result->fetch_assoc();

if (!$facilitator) {
    echo "Facilitator not found!";
    exit();
}

// Fetch available subjects
$matiere_query = "SELECT id, title FROM matiere";
$matiere_result = $conn->query($matiere_query);

// Fetch students of the facilitator's level
$niveau_id = $facilitator['niveau_id'];
$etudiants_query = "SELECT u.id_E, u.username 
                    FROM etudiant u 
                    WHERE u.idN = ?";
$stmt = $conn->prepare($etudiants_query);
$stmt->bind_param('i', $niveau_id);
$stmt->execute();
$etudiants_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Tracker</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
/* General container styling */
.container {
    width: 75%;
    margin: 0 auto;
    background-color: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    text-align: center;
}

/* Header styling */
.container .header {
    margin-bottom: 25px;
}

.container .header h1 {
    font-size: 28px;
    color: #333;
}

/* Subject section styling */
.container .subject {
    font-size: 18px;
    margin-bottom: 20px;
    color: #555;
}

/* Buttons styling for the form */
.container .buttons {
    

            font-size: 18px;
            color: #34495e;
            margin-right: 10px;
        }

/* Date input styling */
.container .date {
    margin-bottom: 30px;
}

/* Table styling */
.table-container {
    overflow-x: auto;
    margin-top: 30px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    font-size: 16px;
    color: #444;
}

thead {
    background-color: #4CAF50;
    color: white;
    text-transform: uppercase;
}

thead th {
    padding: 12px;
    text-align: center;
}

tbody tr {
    border-bottom: 1px solid #ddd;
}

tbody tr:hover {
    background-color: #f9f9f9;
}

td {
    padding: 12px;
    text-align: center;
}

/* Save Attendance button styling */
button[type="submit"], button[type="button"] {
    background-color: #4CAF50; /* Green */
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease, transform 0.2s;
    margin-top: 20px;
}

/* Save Attendance button hover effect */
button[type="submit"]:hover, button[type="button"]:hover {
    background-color: #45a049; /* Darker green on hover */
    transform: scale(1.05);
}

/* Report Attendance button styling */
button[type="button"] {
    background-color: #007bff; /* Blue */
    margin-left: 15px;
}

button[type="button"]:hover {
    background-color: #0056b3; /* Darker blue on hover */
}

/* Optional: Spacing between consecutive links */
a + a {
    margin-left: 15px;
}

/* General link styling */
a {
    text-decoration: none;
}
</style>

</head>
<body>
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
    <a href="schedule/index.php">
        <span class="fas fa-calendar-alt"></span>
        <small>Schedule</small>
    </a>
</li>

<li>
    <a href="message.php">
        <span class="fas fa-envelope"></span>
        <small>Discussion</small>
    </a>
</li>
                  
                    
                   
                    <li>
                      <a href="courseF.php">
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
            <a href="attendence.php" class="active">
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
        
    
    <div class="container">
        <div class="header">
            <h1>Attendance Tracker</h1>
        </div>

        <div class="subject">
            <p>Facilitateur: <?php echo htmlspecialchars($facilitator['facilitator_name']); ?></p>
        </div>

        <div class="buttons">
            <label for="matiere">Choisir la matière:</label>
            <select id="matiere" name="id_matiere" form="attendanceForm">
                <?php while ($matiere = $matiere_result->fetch_assoc()) { ?>
                    <option value="<?php echo htmlspecialchars($matiere['id']); ?>"><?php echo htmlspecialchars($matiere['title']); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="date">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" form="attendanceForm">
        </div>

        <form action="save_attendence.php" method="POST" id="attendanceForm">
            <input type="hidden" name="id_enseignant" value="<?php echo htmlspecialchars($facilitator['id_facilitator']); ?>">
            <input type="hidden" name="id_niveau" value="<?php echo htmlspecialchars($niveau_id); ?>">
            <div class="table-container">
<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Present</th>
                    </tr>
                </thead>
                <tbody id="user">

                    <?php 

while ($student = $etudiants_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['id_E']); ?></td>
                            <td><?php echo htmlspecialchars($student['id_E']); ?></td>
                            <td><?php echo htmlspecialchars($student['username']); ?></td>
                            <td><input type='checkbox' name='attendence[<?php echo htmlspecialchars($student['id_E']); ?>]' value='1'></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
</div>
            <button type="submit" name="save_attendence">Save Attendance</button>
            <a href="attendance_report.php">
    <button type="button">Report Attendance</button>
</a>


        </form>
    </div>
</body>
</html>
