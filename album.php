<?php
include 'preloads/header.php';
include_once 'includes/dbh.inc.php';
include 'getComments.php';
include 'starRating.php';
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



//getting the number of comments from the database. 

$sqlNumComments = $conn->query("SELECT comment_id FROM user_comment_table");
$numComments = $sqlNumComments->num_rows;

?>



 <div id="albumcontent"> 


<div class=albumtitle> <?php echo "<h1> $albumname  </h1>" ?> <h2>Average ISDB user score: <?php echo round($avg,2) ?></h2> 

<div style="padding: 0px;color:white;">
        <h2> Your Rating</h2>
        <i class="fa fa-star fa-2x" data-index="0"></i>
        <i class="fa fa-star fa-2x" data-index="1"></i>
        <i class="fa fa-star fa-2x" data-index="2"></i>
        <i class="fa fa-star fa-2x" data-index="3"></i>
        <i class="fa fa-star fa-2x" data-index="4"></i>
    </div>


</div>
<main><h2>Description</h2> <?php echo "<p> $albumdesc  </p>" ?></main>


<section><h2> Track listing </h2> 





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


<div class=albumComments> <h2>Comment section</h2>

<?php if (!isset($_SESSION['id'])) {
  echo '<p> Sign in to comment ! </p>';
  } else  {
    echo '<textarea class="form-control" id="mainComment" placeholder= "add public comment" id="" cols="30" rows="2"></textarea><br>
    <button style= "float:right" class="btn-primary btn" onclick="isReply = false;" id="addComment" userId='.$user_id.'>Add Comment</button>';
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

 <div class="replyRow" style="display:none">
 <textarea class="form-control" id="replyComment" placeholder= "add public comment" id="" cols="30" rows="2"></textarea><br>
    <button style= "float:right" class="btn-default btn"  onclick="$('.replyRow').hide();">Close</button>
    <button style= "float:right" class="btn-primary btn" id="addReply" onclick= "isReply = true;">Add Reply</button>
 </div>




     
   
    <!-- ##### Contact Area End ##### -->

    <?php
    include 'preloads/footer.php';
    ?>

  
<script type="text/javascript">

//the following uses Ajax and Jquery to upload the users comments to the database. A flag is given weather or not the comment is a reply or not. 



var isReply = false, commentID = 0, max = <?php echo $numComments ?>;


    $(document).ready(function () {
        $("#addComment, #addReply").on('click', function () {
            var comment;
            
            if (!isReply)
             comment = $("#mainComment").val();
            else
              comment = $("#replyComment").val();

            var addCommentButton = document.getElementById("addComment");
            var userId2 = addCommentButton.getAttribute("userId");

            var urlToRequestComment = "getComments.php?user_id="+userId2

//comment length must be more than 5 characters. 
            if (comment.length > 5) {
                $.ajax({
                    url: urlToRequestComment,
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        addComment: 1,
                        comment: comment,
                        isReply: isReply,
                        commentID: commentID
                    }, success: function (response) {
                        max++;
                        $("#numComments").text(max + " Comments");

                        if (!isReply) {
                          $(".userComments").prepend(response);
                          $("#mainComment").val("");
                       } else {
                         //this resets comment ID back to 0
                            commentID = 0;
                            $("#replyComment").val("");
                            $(".replyRow").hide();
                            $('.replyRow').parent().next().append(response);
                        }
                      }
                   });
            } else alert('Please Check Your Inputs');
        });
    });


//The following function will get the comments dynamically from the database. If start is bigger than maximum we will exit and stop getting the comments.    
//ajax request made. Starting point is 20 which is the number of comments we get in each iteration. 


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


//Need to know who is the caller. Original comment. Comment ID is changed from caller.    

 function reply(caller) {
   commentID = $(caller).attr('data-commentID');
     $(".replyRow").insertAfter($(caller));
     $('.replyRow').show();
 }

//This is the call to the function "getAllComments"    
getAllComments(0, max);

    
</script>
    
</body>

</html>



