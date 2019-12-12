<?php
include 'includes/dbh.inc.php';


function setComments($conn) {
    if (isset($_POST['commentSubmit'])) {
       $userId = $_POST['userId'];
       $date = $_POST['date'];
       $message = $_POST['message'];

       $sql = "INSERT INTO comments (userId, date, message) 
       VALUES ('$userId', '$date', ' $message')";

       $result = $conn->query($sql);
    }
    

}