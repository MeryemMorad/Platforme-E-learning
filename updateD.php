<?php
include('database/config.php');

// Vérifiez que id_cours est défini et est un entier
$id_cours = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = isset($_POST['titre']) ? $_POST['titre'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $id_enseignant = isset($_POST['id_enseignant']) ? intval($_POST['id_enseignant']) : 0;
    $id_matiere = isset($_POST['id_matiere']) ? intval($_POST['id_matiere']) : 0;
    $id_niveau = isset($_POST['id_niveau']) ? intval($_POST['id_niveau']) : 0;
    $date_limite = isset($_POST['date_limite']) ? $_POST['date_limite'] : '';

    $document_path = '';

    // Handle file upload
    if (isset($_FILES['document']) && $_FILES['document']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['document']['tmp_name'];
        $file_name = basename($_FILES['document']['name']);
        $upload_dir = 'uploads/'; // Make sure this directory exists and is writable

        // Ensure the directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $document_path = $upload_dir . $file_name;
        move_uploaded_file($file_tmp, $document_path);
    }

    // Mettre à jour les informations du devoir
    $sql = "UPDATE devoir SET 
                titre='$titre', 
                date_soumission='$description', 
                id_prf='$id_enseignant', 
                id_subject='$id_matiere', 
                id_level='$id_niveau', 
                date_limite='$date_limite',
                document='$document_path'
            WHERE id='$id_cours'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: course.php?msg=Update successful");
        exit();
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}

// Récupérer les informations du cours
$sql = "SELECT * FROM devoir WHERE id = $id_cours LIMIT 1";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Erreur de requête : ' . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
} else {
    die('Cours non trouvé');
}

// Récupérer les enseignants
$sql_enseignant = "SELECT id_EN, username FROM enseignant";
$result_enseignant = mysqli_query($conn, $sql_enseignant);

// Récupérer les matières
$sql_matiere = "SELECT id, title FROM matiere";
$result_matiere = mysqli_query($conn, $sql_matiere);

// Récupérer les niveaux
$sql_niveau = "SELECT id_N, titre FROM niveau";
$result_niveau = mysqli_query($conn, $sql_niveau);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
    <link rel="stylesheet" href="style.css">
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
    <title>Edit Course</title>
</head>
<body>
<input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>C<span>orp</span></h3>
        </div>
        
        <div class="side-content">
            
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
                       <a href="niveau.php">
                            <span class="fas fa-book"></span>
                            <small>Classes</small>
                        </a>
                    </li>
                    <li>
                      <a href="course.php" class="active">
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
            <h3>Edit Course Information</h3>
            <p class="text-muted">Click update after changing any information</p>
        </div>

        <div class="container d-flex justify-content-center">
        <form action="" method="post" enctype="multipart/form-data" style="width: 50vw; min-width: 300px;">
    <div class="row">
        <div class="col">
            <label for="titre" class="form-label">Titre:</label>
            <input type="text" class="form-control" name="titre" id="titre" value="<?php echo htmlspecialchars(isset($row['titre']) ? $row['titre'] : ''); ?>">
        </div>
        <div class="col">
            <label for="description" class="form-label">Date_soumission:</label>
            <input type="text" class="form-control" name="description" id="description" value="<?php echo htmlspecialchars(isset($row['date_soumission']) ? $row['date_soumission'] : ''); ?>">
        </div>
        <div class="col">
            <label for="date_limite" class="form-label">Date_limite:</label>
            <input type="text" class="form-control" name="date_limite" id="date_limite" value="<?php echo htmlspecialchars(isset($row['date_limite']) ? $row['date_limite'] : ''); ?>">
        </div>
    </div>
    <br>
    <div class="mb-3">
        <label for="id_enseignant" class="form-label">Enseignant:</label>
        <select class="form-select" id="id_enseignant" name="id_enseignant" required>
            <?php while ($row_enseignant = mysqli_fetch_assoc($result_enseignant)) { ?>
                <option value="<?php echo $row_enseignant['id_EN']; ?>" <?php echo (isset($row['id_prf']) && $row_enseignant['id_EN'] == $row['id_prf']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($row_enseignant['username']); ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="id_matiere" class="form-label">Matière:</label>
        <select class="form-select" id="id_matiere" name="id_matiere" required>
            <?php while ($row_matiere = mysqli_fetch_assoc($result_matiere)) { ?>
                <option value="<?php echo $row_matiere['id']; ?>" <?php echo (isset($row['id_subject']) && $row_matiere['id'] == $row['id_subject']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($row_matiere['title']); ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="id_niveau" class="form-label">Niveau:</label>
        <select class="form-select" id="id_niveau" name="id_niveau" required>
            <?php while ($row_niveau = mysqli_fetch_assoc($result_niveau)) { ?>
                <option value="<?php echo $row_niveau['id_N']; ?>" <?php echo (isset($row['id_level']) && $row_niveau['id_N'] == $row['id_level']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($row_niveau['titre']); ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="document" class="form-label">Document:</label>
        <input type="file" class="form-control" name="document" id="document">
   
    </div>
    <div>
        <button type="submit" class="btn btn-success" name="submit-save">Update</button>
        <a href="course.php" class="btn btn-danger">Cancel</a>
    </div>
</form>
            </div>
            </div>
            </div>
</body>
</html>
