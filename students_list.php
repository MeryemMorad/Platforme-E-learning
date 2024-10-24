<?php
session_start();
include 'database/config.php';

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Retrieve the details of the logged-in enseignant
$username = $_SESSION['username'];

// Fetch the levels for the enseignant
$levels_sql = "SELECT n.id_N, n.titre 
               FROM enseignant_niveau en 
               INNER JOIN niveau n ON en.id_N = n.id_N 
               INNER JOIN enseignant e ON en.id_EN = e.id_EN 
               WHERE e.username='$username'";

$levels_result = mysqli_query($conn, $levels_sql);
$levels = mysqli_fetch_all($levels_result, MYSQLI_ASSOC);

// Set default selected level
$selected_level_id = isset($_POST['level']) ? $_POST['level'] : (isset($levels[0]) ? $levels[0]['id_N'] : null);

// Fetch students in the selected level
if ($selected_level_id) {
    $students_sql = "SELECT username, gender FROM etudiant WHERE idN='$selected_level_id'";
    $students_result = mysqli_query($conn, $students_sql);
} else {
    $students_result = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students in Your Level</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="styles.css">
    <style>
       
    </style>
</head>
<body>
    <div class="container">
        <h1>La liste des étudiants</h1>

        <form method="post">
            <div class="form-group">
                <label for="level">Sélectionnez un niveau:</label>
                <select name="level" id="level" class="form-control" onchange="this.form.submit()">
                    <?php foreach ($levels as $level): ?>
                        <option value="<?php echo htmlspecialchars($level['id_N']); ?>" 
                            <?php echo $level['id_N'] == $selected_level_id ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($level['titre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <?php if ($students_result && mysqli_num_rows($students_result) > 0): ?>
            <h4>Nombre d'étudiants: <?php echo mysqli_num_rows($students_result); ?></h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Gender</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student = mysqli_fetch_assoc($students_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['username']); ?></td>
                            <td class="<?php echo $student['gender'] == 'Male' ? 'gender-male' : 'gender-female'; ?>">
                                <?php echo htmlspecialchars($student['gender']); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-danger">Aucun étudiant trouvé dans ce niveau.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
