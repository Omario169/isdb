<?php

include_once 'includes/dbh.inc.php';
session_start();
// include 'preloads/header.php';




$user_id = $_SESSION['id'];

 $album_id =  $_GET['album_id'];

if(isset($_POST['Fave']))
    {
      $FaveInsert = "INSERT INTO users_favourite_albums_table (user_favourite_id, album_favourite_id) VALUES ('$user_id', '$album_id')";
         $result = mysqli_query($conn, $FaveInsert);

         if ($result) {
          exit;
          
          } else {
            echo 'fail ';
       }
     }


     if(isset($_POST['unFave']))
     {
       $FaveDelete = "DELETE FROM `users_favourite_albums_table` WHERE `user_favourite_id` = $user_id AND `album_favourite_id` = $album_id";
       $result = mysqli_query($conn, $FaveDelete);

       if ($result) {
        exit;

     } else {
        echo 'fail ';
      }
     }


     

    

?>