
<?php
session_start();
include 'database/config.php';

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Retrieve the details of the logged-in student
$username = $_SESSION['username'];
$sql = "SELECT u.username, u.idN, n.titre 
        FROM etudiant u 
        INNER JOIN niveau n ON u.idN = n.id_N
        WHERE u.username='$username'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $etudiant = mysqli_fetch_assoc($result);
} else {
    $etudiant = [];
}

// If we have the student's level, fetch the counts
if (!empty($etudiant)) {
    $niveau_id = $etudiant['idN'];

    // Fetch the number of students in the same level
    $student_count_sql = "SELECT COUNT(*) as student_count 
                          FROM etudiant  
                          WHERE idN='$niveau_id'";
    $student_count_result = mysqli_query($conn, $student_count_sql);
    $student_count = mysqli_fetch_assoc($student_count_result)['student_count'];

    // Fetch the number of unique teachers teaching that level
    $teacher_count_sql = "SELECT COUNT(DISTINCT en.id_EN) as teacher_count 
                          FROM enseignant_niveau en
                          INNER JOIN enseignant e ON en.id_EN = e.id_EN
                          WHERE en.id_N = '$niveau_id'";
    $teacher_count_result = mysqli_query($conn, $teacher_count_sql);
    $teacher_count = mysqli_fetch_assoc($teacher_count_result)['teacher_count'];

    // Fetch the number of subjects
    $subject_count_sql = "SELECT COUNT(*) as subject_count FROM matiere";
    $subject_count_result = mysqli_query($conn, $subject_count_sql);
    $subject_count = mysqli_fetch_assoc($subject_count_result)['subject_count'];
} else {
    $student_count = $teacher_count = $subject_count = 0;
}

// Query to get all subjects
$sql_subjects = "
SELECT 
    id, 
    title, 
    image, 
    description 
FROM 
    matiere
";
$result_subjects = mysqli_query($conn, $sql_subjects);

if (!$result_subjects) {
    die('Erreur de requête : ' . mysqli_error($conn));
}

$subjects = [];
while ($row = mysqli_fetch_assoc($result_subjects)) {
    $subjects[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <style>
        .subject-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
            margin-top: 20px;
        }

        .subject-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s;
            width: calc(33% - 20px);
            max-width: 300px;
            min-width: 200px;
        }

        .subject-card:hover {
            transform: translateY(-10px);
        }

        .subject-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .subject-card .card-body {
            padding: 15px;
        }

        .subject-card h5 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .subject-card p {
            font-size: 0.9rem;
            color: #6c757d;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .subject-card {
                width: calc(50% - 20px);
            }
        }

        @media (max-width: 576px) {
            .subject-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php';?>

    <div class="page-content">
        <div class="analytics">
            <!-- Cards displaying student, teacher, and subject counts -->
            <div class="card">
                <div class="card-head">
                    <h2><?php echo $student_count; ?></h2>
                    <i class="fa-solid fa-user-graduate"></i> <!-- Student icon -->
                </div>
                <div class="card-progress">
                    <small>Students</small>
                    <div class="card-indicator">
                        <div class="indicator one" style="width: 60%;"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <h2><?php echo $teacher_count; ?></h2>
                    <i class="fa-solid fa-chalkboard-teacher"></i> <!-- Teacher icon -->
                </div>
                <div class="card-progress">
                    <small>Teachers</small>
                    <div class="card-indicator">
                        <div class="indicator two" style="width: 80%;"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <h2><?php echo $subject_count; ?></h2>
                    <i class="fa-solid fa-book"></i> <!-- Subject icon -->
                </div>
                <div class="card-progress">
                    <small>Subjects</small>
                    <div class="card-indicator">
                        <div class="indicator three" style="width: 65%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
    <!-- Display Subjects -->
    <div class="subjects-container">
        <?php foreach ($subjects as $subject): ?>
        <div class="subject-card">
            <img src="images/<?php echo htmlspecialchars($subject['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($subject['title']); ?>">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($subject['title']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($subject['description']); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .subjects-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-around;
    }

    .subject-card {
        width: 200px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease-in-out;
        text-align: center;
    }

    .subject-card:hover {
        transform: scale(1.05);
    }

    .subject-card img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-bottom: 1px solid #ddd;
    }

    .subject-card .card-body {
        padding: 10px;
    }

    .subject-card .card-title {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .subject-card .card-text {
        font-size: 0.9rem;
        color: #555;
    }
</style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
