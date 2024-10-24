<?php
session_start();
include('database/config.php');

// Ensure the user is logged in and is a teacher
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch available subjects
$matiere_query = "SELECT id, title FROM matiere";
$matiere_result = $conn->query($matiere_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selected_date = $_POST['date'];
    $selected_matiere = $_POST['id_matiere'];

    // Fetch attendance records for the selected date and subject, showing both present and absent students
    $attendance_query = "
        SELECT et.id_E, et.username, IFNULL(at.present, 0) AS present
        FROM etudiant et
        LEFT JOIN attendence at ON at.id_E = et.id_E AND at.date = ? AND at.id_matiere = ?
        WHERE et.idN = (SELECT idN FROM facilitateur WHERE username = ?)"; // Filter by the teacher's level
        
    $stmt = $conn->prepare($attendance_query);
    $stmt->bind_param('sis', $selected_date, $selected_matiere, $_SESSION['username']);
    $stmt->execute();
    $attendance_result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
/* General container styling */
.container {
    width: 70%;
    margin: 40px auto;
    background-color: #ffffff;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    text-align: center;
}

/* Header styling */
.container .header {
    margin-bottom: 25px;
}

.container .header h1 {
    font-size: 26px;
    color: #333;
    font-weight: 600;
}

/* Form field styling */
.subject, .date {
    margin-bottom: 20px;
    font-size: 17px;
    color: #444;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #555;
}

select, input[type="date"] {
    width: 90%;
    max-width: 400px;
    padding: 12px;
    border: 2px solid #ccc;
    border-radius: 25px;
    font-size: 15px;
    transition: all 0.3s ease;
    outline: none;
    margin-top: 5px;
    background-color: #f9f9f9;
}

select:focus, input[type="date"]:focus {
    border-color: #66c2ff;
    background-color: #e8f0fe;
}

/* Button styling */
button[type="submit"] {
    background-color: #66b2ff;
    color: white;
    border: none;
    padding: 12px 28px;
    border-radius: 25px;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.3s ease;
    margin-top: 20px;
}

button[type="submit"]:hover {
    background-color: #5aa0e6;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
    font-size: 15px;
    color: #555;
    border-radius: 15px;
    overflow: hidden;
}

thead {
    background-color: #66b2ff;
    color: white;
}

thead th {
    padding: 15px;
}

tbody tr {
    border-bottom: 1px solid #eee;
    transition: background-color 0.3s;
}

tbody tr:hover {
    background-color: #f3f8ff;
}

tbody td {
    padding: 12px;
}

/* Add rounded corners to table cells */
tbody td:first-child {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}

tbody td:last-child {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}

/* Responsive table */
@media (max-width: 768px) {
    table, thead, tbody, th, td, tr {
        display: block;
        width: 100%;
    }

    thead tr {
        display: none;
    }

    tr {
        margin-bottom: 10px;
    }

    td {
        text-align: right;
        padding-left: 50%;
        position: relative;
    }

    td:before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        padding-left: 15px;
        font-weight: bold;
        text-align: left;
    }
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
            <h1>Attendance Report</h1>
        </div>

        <form method="POST" action="">
            <div class="subject">
                <label for="matiere">Choisir matiére:</label>
                <select id="matiere" name="id_matiere" required>
                    <?php while ($matiere = $matiere_result->fetch_assoc()) { ?>
                        <option value="<?php echo htmlspecialchars($matiere['id']); ?>"><?php echo htmlspecialchars($matiere['title']); ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="date">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>

            <button type="submit">View Report</button>
        </form>

        <?php if (isset($attendance_result)) { ?>
            <h2>Attendance for <?php echo htmlspecialchars($selected_date); ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($attendance = $attendance_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($attendance['id_E']); ?></td>
                            <td><?php echo htmlspecialchars($attendance['username']); ?></td>
                            <td><?php echo $attendance['present'] ? 'Present' : 'Absent'; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</body>
</html>
