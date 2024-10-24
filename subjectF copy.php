<?php
include('database/config.php');

// Query to get all subjects
$sql = "
SELECT 
    id, 
    title, 
    image, 
    description 
FROM 
    matiere
";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Erreur de requête : ' . mysqli_error($conn));
}

$subjects = [];
while ($row = mysqli_fetch_assoc($result)) {
    $subjects[] = $row;
}

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        /* style.css */

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

.main-content {
    margin-left: 250px;
    padding: 2rem;
}

.card {
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-img-top {
    height: 200px;
    object-fit: cover;
}

.card-body {
    padding: 1.5rem;
}

.card-title {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.card-text {
    font-size: 1rem;
    color: #6c757d;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    border-radius: 0.3rem;
    font-size: 1rem;
    padding: 0.5rem 1.5rem;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

.modal-content {
    border-radius: 0.5rem;
}

.modal-header {
    border-bottom: 1px solid #dee2e8;
}

.modal-body {
    padding: 2rem;
}

.modal-footer {
    border-top: 1px solid #dee2e8;
}

@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
    }

    .sidebar {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: -250px;
        transition: left 0.3s;
    }

    .sidebar.show {
        left: 0;
    }

    .btn-primary {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }
}

.card-header {
    background-color: #f1f1f1;
    border-bottom: 1px solid #dee2e8;
    padding: 1.5rem;
    font-weight: bold;
    font-size: 1.5rem;
    color: #333;
}

/* Style for the heading within the card */
.card-header h3 {
    margin: 0;
    color: black; /* Change this color as needed */
}

        </style>
    <title>Subjects</title>
</head>
<body>
     <!-- Bootstrap JavaScript -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
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
                        <a href="create_discussion.php">
                            <span class="fas fa-users-cog"></span>
                            <small>discussion</small>
                        </a>
                    </li>
                  
                    
                   
                    <li>
                      <a href="courseEt.php">
                      <span class="fas fa-book-open"></span>
                            <small>Courses</small>
                        </a>
                    </li>
                    <li>
                       <a href="subjectF.php" class="active">
                            <span class="fas fa-clipboard-list"></span>
                            <small>Subjects</small>
                        </a>
                    </li>
                    <li>
            <a href="attendance_etudiant.php">
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
        
        <div class="row">
            <div class="col-12 mb-4">
                
                <div class="card">
                    
                    <div class="card-header">
                        <h3>My Subjects</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal" style="font-size: 1.2rem; padding: 0.5rem 1rem;">
    Add Subject
</button>

                    </div>
                   
           <!-- Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" method="post" action="addS.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Subject Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Subject Name" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Subject Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Subject Description" required>
                    </div>

                    <div class="mb-3">
                    
                        <label for="image" class="form-label">Subject Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
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
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($subjects as $subject): ?>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="card">
                                    <!-- Ensure the path is correct, adjust if necessary -->
                                    <img src="images/<?php echo htmlspecialchars($subject['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($subject['title']); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($subject['title']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($subject['description']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
