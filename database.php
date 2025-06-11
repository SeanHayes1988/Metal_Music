<?php
         $dbhost = 'localhost';
         $dbuser = 'sean';
         $dbpass = 'metalislife';
         $db     = "metal_music";
         $conn   = mysqli_connect($dbhost, $dbuser, $dbpass,$db);
      
         if(!$conn ) {
            die('Could not connect: ' . mysqli_error());
         }
         
         //echo 'Connected successfully';
      ?>