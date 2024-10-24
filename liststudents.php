<?php
session_start();
include 'database/config.php';

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Retrieve the details of the logged-in facilitator
$username = $_SESSION['username'];
$sql = "SELECT u.idN, n.titre 
        FROM facilitateur u 
        INNER JOIN niveau n ON u.idN = n.id_N
        WHERE u.username='$username'";

$result = mysqli_query($conn, $sql);

if ($result) {
    $facilitator = mysqli_fetch_assoc($result);
    $niveau_id = $facilitator['idN'];
} else {
    $niveau_id = 0;
}

// Fetch students in the same level
$students_sql = "SELECT username, gender,n.titre FROM etudiant join niveau n on n.id_N=etudiant.idN WHERE idN='$niveau_id'";
$students_result = mysqli_query($conn, $students_sql);

if (!$students_result) {
    die('Error in SQL query: ' . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students in Your Level</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>La liste des etudiants</h1>
        <?php if (mysqli_num_rows($students_result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Gender</th>
                        <th>Niveau</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student = mysqli_fetch_assoc($students_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['username']); ?></td>
                            <td class="<?php echo $student['gender'] == 'Male' ? 'gender-male' : 'gender-female'; ?>">
                                <?php echo htmlspecialchars($student['gender']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($student['titre']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No students found in this level.</p>
        <?php endif; ?>
    </div>
</body>
</html>
