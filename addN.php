<?php
include('database/config.php');

if(isset($_POST['save-btn']))
{
    $titre = $_POST['titre'];
    $desc = $_POST['desc'];
    $students = $_POST['students'];
  



    $email_query = "SELECT * FROM niveau WHERE titre='$titre' and description='$desc' and students='$students' ";
    $email_query_run = mysqli_query($conn, $email_query);

    if(mysqli_num_rows($email_query_run) > 0)
    {
        echo "<script>alert('Class Already Taken. Please Try Another one.');</script>";
    }
    else
    {
      
            $query = "INSERT INTO niveau (titre, description, students ) VALUES ('$titre', '$desc', '$students' )";
            $query_run = mysqli_query($conn, $query);

            if($query_run)
            {
              
                header('Location: niveau.php');
                echo "<script>alert('Class Added');</script>";
            }
            else 
            {
                echo "<script>alert('Class Not Added');</script>";
            }
        }
      
    }

?>
