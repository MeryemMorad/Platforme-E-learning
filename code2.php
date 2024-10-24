<?php
include('database/config.php');

if (isset($_POST['save-btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];
    $status = $_POST['status'];
    $gender = $_POST['gender'];
    $niveau = $_POST['niveau'];

    // Vérifiez si l'étudiant existe déjà
    $email_query = "SELECT * FROM facilitateur WHERE username='$username' AND password='$password' AND status='$status' AND gender='$gender' AND idN='$niveau'";
    $email_query_run = mysqli_query($conn, $email_query);

    if (mysqli_num_rows($email_query_run) > 0) {
        echo "<script>alert('Etudiant Already Taken. Please Try Another one.');</script>";
    } else {
        // Prepare the query
        $query = "INSERT INTO facilitateur (username, password, status, gender, idN) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        // Define types for bind_param: 's' for string, 'i' for integer if needed
        // Assuming idN is an integer, if it's a string, change 'i' to 's'
        $stmt->bind_param('sssss', $username, $password, $status, $gender, $niveau);

        if ($stmt->execute()) {
            echo "<script>alert('facilitateur Profile Added');</script>";
            header('Location: tableE.php');
            exit();
        } else {
            echo "<script>alert('facilitateur Profile Not Added: " . $stmt->error . "');</script>";
        }
    }
} else {
    echo "<script>alert('Password and Confirm Password Does Not Match');</script>";
}
?>
