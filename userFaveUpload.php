<?php

include_once 'includes/dbh.inc.php';
session_start();
// include 'preloads/header.php';

$user_id = $_SESSION['id'];

//store url values into variables 
$album_id =  $_GET['album_id'];
$faveUnfavValue =  $_GET['fave_unfav_value'];

//Depending on if the user faves or unfaves the corresponding sql query will be performed
if($faveUnfavValue == "Fave") {

  $FaveInsert = "INSERT INTO users_favourite_albums_table (user_favourite_id, album_favourite_id) VALUES ('$user_id', '$album_id')";
  echo $FaveInsert;

  $result = mysqli_query($conn, $FaveInsert);
}
else if($faveUnfavValue == "Unfave") {
  $FaveDelete = "DELETE FROM `users_favourite_albums_table` WHERE `user_favourite_id` = $user_id AND `album_favourite_id` = $album_id";
  $result = mysqli_query($conn, $FaveDelete);
}

?>