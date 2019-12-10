<?php

include 'preloads/header.php';
include_once 'includes/dbh.inc.php';
include_once 'includes/userData.php';

if(isset($_POST['Fave']))
    {
      $FaveInsert = "INSERT INTO users_favourite_albums_table (user_favourite_id, album_favourite_id) VALUES ('$user_id', '$album_id')";
         $result = mysqli_query($conn, $FaveInsert);

         if ($result) {
          echo '<script> success </success>';
          
          } else {
            echo '<script> success </success>';
       }
     }


     if(isset($_POST['unFave']))
     {
       $FaveDelete = "DELETE FROM `users_favourite_albums_table` WHERE `user_favourite_id` = $user_id AND `album_favourite_id` = $album_id";
       $result = mysqli_query($conn, $FaveDelete);

       if ($result) {
        echo '<script> success </success>';

     } else {
        echo '<script> fail </success>';
      }
     }
    

?>