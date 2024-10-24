<?php
include('database/config.php');

// Vérifiez que id_user est défini et est un entier
$id = isset($_GET['id_N']) ? intval($_GET['id_N']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $students = $_POST['students'];

    // Start a transaction
    mysqli_begin_transaction($conn);

    // Check if any attendance records reference this niveau ID
    $checkAttendanceSql = "SELECT COUNT(*) as count FROM `attendance` WHERE `niveau_id` = $id";
    $checkResult = mysqli_query($conn, $checkAttendanceSql);
    $checkRow = mysqli_fetch_assoc($checkResult);

    if ($checkRow['count'] > 0) {
        // Handle the case where attendance records reference this niveau ID
        // For example, you might delete these records or reassign them
        $deleteAttendanceSql = "DELETE FROM `attendance` WHERE `niveau_id` = $id";
        if (!mysqli_query($conn, $deleteAttendanceSql)) {
            mysqli_rollback($conn);
            die('Failed to delete attendance records: ' . mysqli_error($conn));
        }
    }

    // Mettre à jour les informations de l'utilisateur
    $sql = "UPDATE `niveau` SET `titre`='$name', `description`='$description', `students`='$students' WHERE `id_N`=$id";
    if (mysqli_query($conn, $sql)) {
        mysqli_commit($conn);
        header("Location: niveau.php?msg=Update successful");
        exit();    
    } else {
        mysqli_rollback($conn);
        echo "Failed: " . mysqli_error($conn);
    }
}

// Récupérer les informations de l'utilisateur
$sql = "SELECT * FROM `niveau` WHERE `id_N` = $id LIMIT 1";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Erreur de requête : ' . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
} else {
    die('Class non trouvé');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Edit User</title>
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

.sidebar .side-menu ul li a.active {
    background-color: #495057;
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
                        <a href="create_discussion.php">
                            <span class="fas fa-users-cog"></span>
                            <small>discussion</small>
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
                       <a href="niveau.php" class="active">
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
    <div class="notify-icon" onclick="window.location.href='notifications.php'">
        <span class="las la-bell"></span>
        <!-- The badge can be dynamically updated with JavaScript or server-side PHP -->
        <span class="badge">0</span>
    </div>
    <label for="">
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
        
<div class="table-controls">
    <!-- Add User Button -->
</div>
<div class="container">
    <div class="text-center mb-4">
        <h3>Edit Class Information</h3>
        <p class="text-muted">Click update after changing any information</p>
    </div>
    <div class="container d-flex justify-content-center">
        <form action="" method="post" style="width: 50vw; min-width: 300px;">
            <div class="row">
                <div class="col">
                    <label for="name" class="form-label">Class Name:</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?php echo htmlspecialchars($row['titre']); ?>">
                </div>
                <div class="col">
                    <label for="description" class="form-label">Class Description:</label>
                    <input type="text" class="form-control" name="description" id="description" value="<?php echo htmlspecialchars($row['description']); ?>">
                </div>
            </div>
            <br>
            <div class="mb-3">
                <label for="students" class="form-label">Students:</label>
                <input type="text" class="form-control" name="students" id="students" value="<?php echo htmlspecialchars($row['students']); ?>">
            </div>
            <div>
                <button type="submit" class="btn btn-success" name="submit-save">Update</button>
                <a href="user_admin.php" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>