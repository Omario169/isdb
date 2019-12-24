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


function getComments($conn) {
    $sql = "SELECT * FROM comments";
    $result = $conn->query($sql);
    while ($row = $result-> fetch_assoc()) {

        echo "<div class='comment-box'><p>";
            echo $row['userId']."<br>";
            echo $row['date']."<br>";
            echo nl2br($row['message']);
        echo "</p> 
            <form class='delete-form' method= 'POST' action= '".deleteComments($conn)."'>
                <input type='hidden' name='commentid' value='".$row['commentid']."'>
                <button type= 'submit' name='commentDelete'>Delete</button>
            </form>
            <form class='edit-form' method= 'POST' action= 'editcomment.php'>
                <input type='hidden' name='commentid' value='".$row['commentid']."'>
                <input type='hidden' name='userId' value='".$row['userId']."'>
                <input type='hidden' name='date' value='".$row['date']."'>
                <input type='hidden' name='message' value='".$row['message']."'>
                <button>Edit</button>
            </form>
        </div>";
    }
    $row = $result-> fetch_assoc();
    
}

//line 31 taking all information and passing it onto the next page
//update database with new fucntion. 

//This function will edit comment. The header does not redirect atm, need to fix. 

function editComments($conn) {
    if (isset($_POST['commentSubmit'])) {
       $commentid = $_POST['commentid'];
       $userId = $_POST['userId'];
       $date = $_POST['date'];
       $message = $_POST['message'];

       $sql = "UPDATE comments SET message='$message' WHERE commentid='$commentid'";
       $result = $conn->query($sql);
       header("Location: index.php");
    }
}

function deleteComments($conn) {
    if (isset($_POST['commentDelete'])) {
        $commentid = $_POST['commentid'];
 
        $sql = "DELETE FROM comments WHERE commentid= '$commentid'";
        $result = $conn->query($sql);
        header("Location: index.php");
     }
}
