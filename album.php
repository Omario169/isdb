<?php
    
    include 'preloads/header.php';
    include_once 'includes/dbh.inc.php';
?>

<?php
    $album_id =  $_GET['album_id'];



    $sql = "SELECT * FROM `albums_table` WHERE `album_id` = $album_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) 
      {
      $albumname  = $row['album_name'];
      }
    }
    else {
      echo "There are no albums!";
    }

?>



 <div id="albumcontent"> 


<div class=albumtitle> <?php echo "<h2> $albumname </h2>" ?> and Review</div>
<main>Description</main>
<section>Track Listing</section>
<aside class="albumArt">Album Art</aside>
<aside class="moreInfo">More Info</aside>
<div class=albumComments> Comment section</div>



 </div>






     
   
    <!-- ##### Contact Area End ##### -->

    <?php
    include 'preloads/footer.php';
    ?>
   <?php
    include 'preloads/javascript.php';
    ?>

    
    
</body>

</html>