<?php
session_start();
include('database/config.php');

if (isset($_POST['login'])) {
    $user_password = $_POST['password'];
    $username = $_POST['username'];

    // Vérification dans la table admin
    $select_query = "SELECT * FROM `admin` WHERE username_A='$username' AND password_A='$user_password'";
    $result = mysqli_query($conn, $select_query);
    $num = mysqli_num_rows($result);

    if ($num > 0) {
        $_SESSION['username'] = $username;
        header("Location: admin.php");
        exit;
    } else {
        // Vérification dans la table etudiant
        $select_query = "SELECT * FROM `etudiant` WHERE username='$username' AND password='$user_password'";
        $result = mysqli_query($conn, $select_query);
        $num = mysqli_num_rows($result);

        if ($num > 0) {
            $_SESSION['username'] = $username;
            header('Location: etudiant.php');
            exit;
        } else {
            // Vérification dans la table enseignant
            $select_query = "SELECT * FROM `enseignant` WHERE username='$username' AND password='$user_password'";
            $result = mysqli_query($conn, $select_query);
            $num = mysqli_num_rows($result);

            if ($num > 0) {
                $_SESSION['username'] = $username;
                header('Location: enseignant.php');
                exit;
            } else {
                // Vérification dans la table facilitateur
                $select_query = "SELECT * FROM `facilitateur` WHERE username='$username' AND password='$user_password'";
                $result = mysqli_query($conn, $select_query);
                $num = mysqli_num_rows($result);

                if ($num > 0) {
                    $_SESSION['username'] = $username;
                    header('Location: facilitateur.php');
                    exit;
                } else {
                    echo "<script>alert('Identifiants Incorrects')</script>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <script
      src="https://kit.fontawesome.com/28d1bfd5f7.js"
      crossorigin="anonymous"
    ></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <style>
     body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: url(images/img5.jpeg) no-repeat;
    background-size: cover;
    background-position: center;
    padding-top: 80px; /* Ajout de l'espace pour le header fixe */
}

.wrapper button {
    border: none;
    outline: none;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    cursor: pointer;
    color:black;
    width: 150px;
    height: 50px;
    border-radius: 50px;
    margin-top: 40px;
    margin-bottom: 20px;
    background-color:rgb(237, 100, 230);
    text-transform: uppercase;
  
      }
        </style>
    <title>Document</title>
</head>
<body>


<div class="wrapper">
    <form action="" method="post">
        <h1> Bienvenue </h1>
        <div class="label"><p>Veuillez saisir vos données d'authentification</p></div>
        <div class="input-box">
            <input type="text" placeholder="username" name="username" required>
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="input-box">
            <input type="password" placeholder="password" name="password" required>
            <i class="fa-solid fa-lock"></i>
        </div>
        <div class="rester"><label><input type="checkbox">Rester connecté</label></div>
        <button class="button" type="submit" name="login">Connexion</button>
    </form>
</div>

</body>
</html>
