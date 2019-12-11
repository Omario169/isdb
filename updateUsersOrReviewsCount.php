<?php
    header('Content-Type: text/html; charset=utf-8');

    include_once 'includes/dbh.inc.php';
    session_start();


    $valueToUpdateTo = "";

if (isset($_POST['userId'])) {
    $user_id = $_POST['userId'];
    echo $user_id;
}

if (isset($_POST['albumId'])) {
    $album_id = $_POST['albumId'];
    echo $album_id;
}



if (isset($_POST['value'])) {
    
    
    if ($valueToUpdateTo == "unFave") {
        $FaveDelete = "DELETE FROM `users_favourite_albums_table` WHERE `user_favourite_id` = $user_id AND `album_favourite_id` = $album_id";
        $result     = mysqli_query($conn, $FaveInsert);
        if ($result) {
            echo 'unFave susceeded';
        } else {
            echo 'unFave failed';
        }
        
    } else {
        $FaveInsert = "INSERT INTO users_favourite_albums_table (user_favourite_id, album_favourite_id) VALUES ('$user_id', '$album_id')";
        $result     = mysqli_query($conn, $FaveInsert);
        if ($result) {
            echo 'fav susceeded';
        } else {
            echo 'fav failed';
        }
    }
}
else {
  echo 'not set ';
}

?>