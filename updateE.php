<?php
include('database/config.php');

// Vérifiez que id_user est défini et est un entier
$id_user = isset($_GET['id_E']) ? intval($_GET['id_E']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $status = $_POST['status'];

    $gender = $_POST['gender'];
    $niveau = $_POST['niveau'];
    
    
    // Mettre à jour les informations de l'utilisateur
    $sql = "UPDATE `etudiant` SET `username`='$username', `password`='$password', `status`='$status', `gender`='$gender', `idN`='$niveau' WHERE `id_E`=$id_user";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: tableE.php?msg=Update successful");
        exit();
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}

// Récupérer les informations de l'utilisateur
$sql = "SELECT * FROM `etudiant` WHERE `id_E` = $id_user LIMIT 1";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Erreur de requête : ' . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
} else {
    die('Utilisateur non trouvé');
}




// Récupérer les niveaux
$sql_niveau = "SELECT * FROM `niveau`";
$result_niveau = mysqli_query($conn, $sql_niveau);

if (!$result_niveau) {
    die('Erreur de requête pour niveaux : ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css"> <!-- Custom CSS should be loaded after Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <title>Edit User</title>
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
                    <a href="tableE.php" class="active">
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
        

    <div class="container">
        <div class="text-center mb-4">
            <h3>Edit Etudiant Information</h3>
            <p class="text-muted">Click update after changing any information</p>
        </div>

        <div class="container d-flex justify-content-center">
            <form action="" method="post" style="width: 50vw; min-width: 300px;">
                <div class="row">
                    <div class="col">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?php echo htmlspecialchars($row['username']); ?>">
                    </div>
                    <div class="col">
                        <label for="password" class="form-label">Password:</label>
                        <input type="text" class="form-control" name="password" id="password" value="<?php echo htmlspecialchars($row['password']); ?>">
                    </div>
                </div>
                <br>
                <div class="mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <input type="text" class="form-control" name="status" id="status" value="<?php echo htmlspecialchars($row['status']); ?>">
                </div>
               
                
                <div class="mb-3">
                    <label for="niveau" class="form-label">Niveau:</label>
                    <select class="form-select" id="niveau" name="niveau" required>
                        <?php while ($row_niveau = mysqli_fetch_assoc($result_niveau)) { ?>
                            <option value="<?php echo $row_niveau['id_N']; ?>" <?php echo ($row_niveau['id_N'] == $row['idN']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($row_niveau['titre']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender:</label>
                    <select id="gender" name="gender" class="form-select" required>
                        <option value="female" <?php echo ($row['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                        <option value="male" <?php echo ($row['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success" name="submit-save">Update</button>
                <a href="tableE.php" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
