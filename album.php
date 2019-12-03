<?php
    
    include 'preloads/header.php';
    include_once 'includes/dbh.inc.php';
?>

<body>

<?php
    $album_id =  $_GET['album_id'];


//sql query to get album information from 
    $sql = "SELECT * FROM `albums_table` WHERE `album_id` = $album_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) 
      {
      $albumname  = $row['album_name'];
      $albumdate  = $row['album_date'];
      $albumdesc  = $row['album_description'];
      $albumimage = $row['album_image'];
      }
    }
    else {
      echo "There are no albums!";
    }



?>



 <div id="albumcontent"> 


<div class=albumtitle> <?php echo "<h2> $albumname  </h2>" ?> and Review</div>
<main>Description <?php echo "<h2> $albumdesc  </h2>" ?></main>
<section>Track Listing</section>

<aside class="albumArt">Album Art <?php echo '<img src="data:image;base64,'.base64_encode($albumimage).'                  "        >';                  ?></aside>


<aside class="moreInfo">More Info <?php echo "<h2> $albumdate  </h2>" ?></aside>
<div class=albumComments> Comment section



</div>



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