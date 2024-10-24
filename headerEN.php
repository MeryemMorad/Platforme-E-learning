<?php
// Start the session at the very beginning
session_start();
include 'database/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Retrieve the details of the logged-in instructor
$username = $_SESSION['username'];
$sql = "SELECT username FROM enseignant WHERE username='$username'";
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
</head>
<body>
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
                <a href="#" class="active">
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
                <a href="devoirs.php">
                    <span class="fas fa-users-cog"></span>
                    <small>Devoirs</small>
                </a>
            </li>
            

            <li>
                <a href="select_student.php">
                    <span class="fas fa-users-cog"></span>
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
                <a href="attendence.php">
                    <span class="fas fa-calendar-check"></span>
                    <small>Attendance</small>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="fas fa-chart-bar"></span>
                    <small>Results</small>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="fas fa-cog"></span> <!-- Settings icon -->
                    <small>Settings</small>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="main-content">
    <header>
        <div class="header-content">
            <label for="menu-toggle">
                <span class="las la-bars"></span>
            </label>
            
            <div class="header-menu">
                <label for="search">
                    <span class="las la-search"></span>
                </label>
                
                <div class="user">
                    <div class="bg-img" style="background-image: url(images/admin1.png)"></div>
                    <span class="las la-power-off"></span>
                    <a href="login.php"><span>Logout</span></a>
                </div>
            </div>
        </div>
    </header>
</div>
</div>
</body>
</html>
