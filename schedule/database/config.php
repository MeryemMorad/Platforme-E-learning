<?php
 
   // database/config.php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "e_platforme";
   
   // Créer une connexion
   $conn = new mysqli($servername, $username, $password, $dbname);
   
   // Vérifier la connexion
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   ?>
   