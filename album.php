<?php


    
    include 'preloads/header.php';
    include_once 'includes/dbh.inc.php';
    
    include 'preloads/javascript.php';

date_default_timezone_set("Europe/London");
   
    
?>

<body>

<?php
   
  $album_id =  $_GET['album_id'];

   if (!isset($_SESSION['id'])) {
      
  }
  else if (isset($_SESSION['id'])) {
   $user_id = $_SESSION['id'];
   $user_fave = "SELECT * FROM `users_favourite_albums_table` WHERE `user_favourite_id` = $user_id AND `album_favourite_id` = $album_id";
  $fave_result = mysqli_query($conn, $user_fave);
   }
                                            


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


<div class=albumtitle> <?php echo "<h1> $albumname  </h1>" ?> and Review</div>
<main><h2>Description</h2> <?php echo "<p> $albumdesc  </p>" ?></main>
<section>Track Listing</section>

<aside class="albumArt"><?php echo '<img src="data:image;base64,'.base64_encode($albumimage).' " alt="album Image" style="width: 200px; height: 190px;">'; ?></aside>


<aside class="moreInfo"><h2>More Info</h2>
<table>


<tr>
 <th>Artist: <th>
 <th>Artist Name<th>

</tr>

<tr>
 <th>Release Date:<th>
 <th><?php echo "<p> $albumdate  </p>" ?><th>

</tr>

<tr>
 <th>Genre(s): <th>
 <th>Genre of album <span id="result"></span> <th>

</tr>

<tr>
 <th>Buy Vinyl: <th>
 <th>Link to buy page<th>

</tr>

<tr>
 <th>Add to fave list: <th>
 <th>
 <?php 
 


if (!isset($_SESSION['id'])) {
  echo '<p> Sign in! </p>';
  } else if (mysqli_num_rows($fave_result) > 0) {
    echo '<input id="submitFaveButton" userId='.$user_id.' albumId='.$album_id.' onclick="faveFunction()" type="button" value="Unfave"/>';
    } else {
      echo '<input id= "submitFaveButton" userId='.$user_id.' albumId='.$album_id.' onclick="faveFunction()" type="button" value="Fave"/>';
          }

          

          

     

     
          
 
 ?><th>

</tr>

</table>

</aside>


<div class=albumComments> Comment section

<?php
echo "<form> 
    <input type='hidden' name='userId' value='Anonymous'>
    <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
    <textarea name='message'> </textarea> <br>
    <button id='commentButton' type='submitComment' name='submitComment'>Comment</button>
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

