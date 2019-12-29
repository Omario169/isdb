<?php
include 'preloads/header.php';
include_once 'includes/dbh.inc.php';
include 'getComments.php';
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


//sql to get comments into website







    //sql to add comments

if (isset($_POST['addComment'])) {
    $comment = $conn->real_escape_string($_POST['comment']);

    $conn->query("INSERT INTO user_comment_table (user_id, message, created_on) VALUES ('$user_id', '$comment', NOW())");
    $sqlGetComment = $conn->query("SELECT uidUsers, message, DATE_FORMAT(user_comment_table.created_on, '%Y-%m-%d') AS created_on FROM user_comment_table 
    INNER JOIN users ON user_comment_table.user_id = users.idUsers ORDER BY user_comment_table.comment_id DESC LIMIT $start, 20
    ");
    $data = $sqlGetComment->fetch_assoc();
    exit(createCommentRow($data));

}




$sqlNumComments = $conn->query("SELECT comment_id FROM user_comment_table");
$numComments = $sqlNumComments->num_rows;

?>



 <div id="albumcontent"> 


<div class=albumtitle> <?php echo "<h1> $albumname  </h1>" ?> and Review</div>
<main><h2>Description</h2> <?php echo "<p> $albumdesc  </p>" ?></main>


<section>Comment Section 





</section>

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

<?php if (!isset($_SESSION['id'])) {
  echo '<p> Sign in to comment ! </p>';
  } else  {
    echo '<textarea class="form-control" id="mainComment" placeholder= "add public comment" id="" cols="30" rows="2"></textarea><br>
    <button style= "float:right" class="btn-primary btn" id="addComment" userId='.$user_id.'>Add Comment</button>';
  }

 

?>

<!-- echo '<input id="submitFaveButton" userId='.$user_id.' albumId='.$album_id.' onclick="faveFunction()" type="button" value="Unfave"/>'; -->

<!-- <textarea class="form-control" id="mainComment" placeholder= "add public comment" id="" cols="30" rows="2"></textarea><br>
  <button style= "float:right" class="btn-primary btn" id="addComment">Add Comment</button> -->
<h2><b id="numComments"><?php echo $numComments?> Comments</b></h2>
  <div class="userComments"> 
    <div class="comment"> 
      
      <div class="replies"> 
      <div class="comment"> 
        
    </div> 
   
   
      </div> 
    </div> 
  </div> 


</div>



 </div>




     
   
    <!-- ##### Contact Area End ##### -->

    <?php
    include 'preloads/footer.php';
    ?>

  
<script type="text/javascript">

//the following uses Ajax and Jquery to upload the users comments to the database
let max = <?php echo $numComments ?>;


    $(document).ready(function () {
        $("#addComment").on('click', function () {
            var comment = $("#mainComment").val();

            var addCommentButton = document.getElementById("addComment");
            var userId2 = addCommentButton.getAttribute("userId");

            var urlToRequestComment = "getComments.php?user_id="+userId2

            if (comment.length > 5) {
                $.ajax({
                    url: urlToRequestComment,
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        addComment: 1,
                        comment: comment
                    }, success: function (response) {
                        max++;
                        $("#numComments").text(max + " Comments");
                        $(".userComments").prepend(response);
                        }
                    });
            } else alert('Please Check Your Inputs');
        });
    });

//The following function will get the comments dynamically from the database    






function getAllComments(start, max,) {
    if (start > max) {
        return;
    }

    $.ajax({
        url: "getComments.php",
        method: 'POST',
        dataType: 'text',
        data: {
            getAllComments: 1,
            start: start
        }, success: function (response) {
            $(".userComments").append(response);
            getAllComments((start+20), max);
        }
    });
}


      

    // function reply(caller) {
    //     commentID = $(caller).attr('data-commentID');
    //     $(".replyRow").insertAfter($(caller));
    //     $('.replyRow').show();
    // }

   
    getAllComments(0, max);

    
</script>
    
</body>

</html>



