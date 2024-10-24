<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/28d1bfd5f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
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
                    <li>
                    <a href="tableE.php">
                            <span class="las la-user-cog"></span>
                            <small>Etudiant</small>
                        </a>
                    </li>
                    <li>
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
    
    <div class="user">
        <div class="bg-img" style="background-image: url(images/admin1.png)"></div>
        <span class="las la-power-off"></span>
        <a href="login.php"><span>Logout</span></a>
    </div>
</div>

            </div>
        </header>
        
    <div class="page-header">
        <h1>Cours</h1>
        <small>Home / Cours</small>
    </div>
 
       
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
                 <!-- Add User Button -->
          
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Ajouter cours
            </button>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th> Titre</th>
                        <th>description</th>
                        <th>prof</th>
                        <th>matiére</th>
                        <th>niveau</th>
                      
                        <th>action</th>
                    </tr>
                </thead>
                <tbody id="userTable">
                <?php
            include('database/config.php');
            $sql = "SELECT 
                        cours.id_c, 
                        cours.Ttitre, 
                        cours.description, 
                        enseignant.username AS enseignant_nom, 
                        matiere.title AS matiere_nom, 
                        niveau.titre AS niveau_nom 
                       
                    FROM cours 
                    JOIN enseignant ON cours.id_enseignant = enseignant.id_EN
                    JOIN matiere ON cours.id = matiere.id
                    JOIN niveau ON cours.id_N = niveau.id_N";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row['id_c']; ?></td>
            <td><?php echo $row['Ttitre']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['enseignant_nom']; ?></td>
            <td><?php echo $row['matiere_nom']; ?></td>
            <td><?php echo $row['niveau_nom']; ?></td>
            <td>
    <a href="viewPDF.php?id_c=<?php echo $row['id_c'] ?>" class="link-light btn btn-info">
        <i class="fa-solid fa-eye"></i>
    </a>
    <a href="updateC.php?id_c=<?php echo $row['id_c'] ?>" class="link-light btn btn-warning">
        <i class="fa-solid fa-edit"></i>
    </a>
    <a href="removeC.php?id_c=<?php echo $row['id_c'] ?>" class="link-light btn btn-danger">
        <i class="fa-solid fa-trash fs-5"></i>
    </a>
</td>
       
        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
   
           <!-- Modal -->
           <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" method="post" action="addC.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Subject Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Subject Description" required>
                    </div>
                    <div class="mb-3">
                        <label for="matiere" class="form-label">Matiere</label>
                        <select class="form-select" id="matiere" name="matiere" required>
                            <?php
                            include('database/config.php');
                            $sql = "SELECT id, title FROM matiere";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id']}'>{$row['title']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_enseignant" class="form-label">Enseignant</label>
                        <select class="form-select" id="id_enseignant" name="id_enseignant" required>
                            <?php
                            $sql = "SELECT  id_EN,username FROM enseignant";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id_EN']}'>{$row['username']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="niveau" class="form-label">Niveau</label>
                        <select class="form-select" id="niveau" name="niveau" required>
                            <?php
                            $sql = "SELECT id_N, titre FROM niveau";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id_N']}'>{$row['titre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                   <div class="mb-3">
    <label for="file" class="form-label">Add Document</label>
    <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov,.zip,.quiz" required>
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
    <script src="script.js"></script>
</body>
</html>