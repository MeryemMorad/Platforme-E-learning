<?php

include 'database/config.php';

// Ensure the user is logged in and is an instructor
if (!isset($_SESSION['username']) ) {
    header('Location: login.php');
    exit;
}

// Retrieve the details of the logged-in instructor
$username = $_SESSION['username'];
$sql = "SELECT username FROM etudiant WHERE username='$username' ";
$result = mysqli_query($conn, $sql);

if ($result) {
    $etudiant = mysqli_fetch_assoc($result);
} else {
    $etudiant = [];
}


?>
<style>
   
    </style>
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
                    <small>Etudiant</small>
                </div>
            </a>
        <?php else: ?>
            <p>Aucun etudiant trouvé.</p>
        <?php endif; ?>
   
            </a>
            <div class="side-menu">
                <ul>
                    <li>
                       <a href="" class="active">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                    <a href="devoirET.php">
          <span class="las la-file-alt"></span>
          <small>Devoirs</small>
       </a>
                    </li>
                    <li>
    <a href="message.php">
        <span class="fas fa-envelope"></span>
        <small>Discussion</small>
    </a>
</li>
                    
                    <li>
    <a href="schedule/index.php">
        <span class="fas fa-calendar-alt"></span>
        <small>Schedule</small>
    </a>
</li>

                    <li>
                      <a href="courseEt.php">
                      <span class="fas fa-book-open"></span>
                            <small>Courses</small>
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
        
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
if (!isset($_SESSION['username']) ) {
    header('Location: login.php');
    exit;
}

// Retrieve the details of the logged-in instructor
$username = $_SESSION['username'];
$sql = "SELECT u.username, n.titre FROM etudiant u 
        INNER JOIN niveau n ON u.idN = n.id_N
        WHERE u.username='$username' ";
$result = mysqli_query($conn, $sql);

if ($result) {
    $etudiant = mysqli_fetch_assoc($result);
} else {
    $etudiant = [];
}
if (!isset($_SESSION['username']) ) {
    header('Location: login.php');
    exit;
}
?>
        <main>
        <div class="page-header">
        <h1>Etudiant</h1>
        <?php if (!empty($etudiant)) : ?>
            <small>Niveau: <?php echo htmlspecialchars($etudiant['titre']); ?></small>
        <?php else : ?>
            <small>Niveau: Non défini</small>
        <?php endif; ?>
    </div>
        <script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('fetch_notifications_count.php')
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('.notify-icon .badge');
            badge.textContent = data.count;
            if (data.count === 0) {
                badge.style.display = 'none';
            } else {
                badge.style.display = 'flex';
            }
        })
        .catch(error => console.error('Error fetching notifications:', error));
});
</script>
