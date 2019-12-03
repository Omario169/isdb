<?php
    
    include 'preloads/header.php';
    include_once 'includes/dbh.inc.php';

    
?>

<form method="POST" enctype="multipart/form-data">
      <!--The following input is used to select the file to upload-->
      <label> Choose an Image URL </label> <br> 
      <input type="file" name="album_image" id="album_image"> <br> 

      <label> Album description </label> <br> 
      <input type="text" name="album_description" placeholder="Enter Description"> <br> 

      <label> Release year </label> <br> 
      <input type="date" name="album_date" placeholder="Enter release date"> <br> 

      <label> Album name </label> <br> 
      <input type="text" name="album_name" placeholder="Enter album name"> <br> 


      <input type="submit" name="upload" value="Insert" id="insert">UPLOAD FILE</button>
    </form>
    </body>
    <!-- ##### Contact Area End ##### -->

    
    
    <?php
    include 'preloads/footer.php';
?>
   <?php
    include 'preloads/javascript.php';
?>


</html>

<?php


if(isset($_POST['upload']))
{
    $file = addslashes(file_get_contents($_FILES["album_image"]["tmp_name"]));
    $albumname = $_POST['album_name'];
    $albumdesc = $_POST['album_description'];
    $albumdate = $_POST['album_date'];

    $query = "INSERT INTO `albums_table`(`album_name`, `album_description`, `album_image`, `album_date`) VALUES ('$albumname', '$albumdesc', '$file', '$albumdate')";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        echo '<script type="text/javascript">alert("Album Profile uploaded")</script>';
    }
    else 
    {
        echo '<script type="text/javascript">alert("Album Profile NOT uploaded")</script>';
    }
}


?>

