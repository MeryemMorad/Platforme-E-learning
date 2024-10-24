<?php
session_start();
include('database/config.php');

if (isset($_POST['view_report'])) {
    $niveau_id = $_POST['niveau_id'];
    $matiere_id = $_POST['matiere_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Fetch all dates in the specified range
    $dates_query = "
        SELECT DISTINCT a.date
        FROM attendence a
        WHERE a.id_matiere = ? AND a.date BETWEEN ? AND ?";

    $dates_stmt = $conn->prepare($dates_query);
    $dates_stmt->bind_param('iss', $matiere_id, $start_date, $end_date);
    $dates_stmt->execute();
    $dates_result = $dates_stmt->get_result();
    $dates = [];
    while ($date_row = $dates_result->fetch_assoc()) {
        $dates[] = $date_row['date'];
    }

    // Fetch all students for the selected level and subject
    $students_query = "
        SELECT e.id_E, e.username AS student_name
        FROM etudiant e
        WHERE e.idN = ?";

    $students_stmt = $conn->prepare($students_query);
    $students_stmt->bind_param('i', $niveau_id);
    $students_stmt->execute();
    $students_result = $students_stmt->get_result();
    $students = [];
    while ($student_row = $students_result->fetch_assoc()) {
        $students[$student_row['id_E']] = $student_row['student_name'];
    }

    // Prepare data for displaying
    $attendance_data = [];
    foreach ($students as $student_id => $student_name) {
        foreach ($dates as $date) {
            $attendance_query = "
                SELECT IFNULL(a.present, 0) AS present
                FROM attendence a
                WHERE a.id_E = ? AND a.id_matiere = ? AND a.date = ?";
            
            if ($stmt = $conn->prepare($attendance_query)) {
                $stmt->bind_param('iis', $student_id, $matiere_id, $date);
                $stmt->execute();
                $attendance_result = $stmt->get_result();
                $attendance_row = $attendance_result->fetch_assoc();
                $attendance_data[] = [
                    'student_name' => $student_name,
                    'date' => $date,
                    'present' => isset($attendance_row['present']) ? $attendance_row['present'] : 0
                ];
            } else {
                // Handle error
                echo "Error preparing statement: " . $conn->error;
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Attendance Report</title>
    <title>Attendance Tracker</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        
        </style>
</head>
<body>
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
                       <a href="" >
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                       <a href="ENtable.php">
                            <span class="las la-user-cog"></span>
                            <small>Enseignant</small>
                        </a>
                    </li>
                    <li>
    <a href="schedule/index.php">
        <span class="fas fa-calendar-alt"></span>
        <small>Schedule</small>
    </a>
</li>

                    <a href="tableE.php">
                            <span class="las la-user-cog"></span>
                            <small>Etudiant</small>
                        </a>
                    </li>
                    <a href="tableF.php">
                            <span class="las la-user-cog"></span>
                            <small>Facilitateur</small>
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
            <a href="attendence_admin.php" class="active">
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
                    <li>
                       <a href="">
                           <span class="fas fa-cog"></span> <!-- Settings icon -->
                           <small>Settings</small>
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

    <h1>Attendance Report from <?php echo htmlspecialchars($start_date); ?> to <?php echo htmlspecialchars($end_date); ?></h1>
    
    <table>
        <thead>
            <tr>
                <th>Le nom d'Etudiant</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($attendance_data)) {
                foreach ($attendance_data as $row) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['present'] ? 'Present' : 'Absent'); ?></td>
                    </tr>
                <?php }
            } else {
                echo "<tr><td colspan='3'>No records found</td></tr>";
            } ?>
        </tbody>
    </table>
</body>
</html>
