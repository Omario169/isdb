
<?php


    
include 'preloads/header.php';
include_once 'includes/dbh.inc.php';
include 'includes/comments.inc.php';
include 'preloads/javascript.php';

date_default_timezone_set("Europe/London");


?>

<body>



<div class=albumComments> Edit your comment here! 

<?php
 $commentid = $_POST['commentid'];
 $userId = $_POST['userId'];
 $date = $_POST['date'];
 $message = $_POST['message'];

echo "<form method='POST' action='".editComments($conn)."'> 
    <input type='hidden' name='commentid' value='". $commentid."'>
    <input type='hidden' name='userId' value='". $userId."'>
    <input type='hidden' name='date' value='".$date."'>
    <textarea name='message'> ".$message."</textarea> <br>
    <button id='commentButton' type='submit' name='commentSubmit'>Edit</button>
</form>";

 
?>

</div>



 </div>




     
   
    <!-- ##### Contact Area End ##### -->

    <?php
    include 'preloads/footer.php';
    ?>

    
    
</body>

</html>

