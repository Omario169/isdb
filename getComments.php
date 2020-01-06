<?php
include_once 'includes/dbh.inc.php';



if (!isset($_GET['user_id'])) {
      
}
else if (isset($_GET['user_id'])) {
 $user_id = $_GET['user_id'];
 
 }


 //Username, date, comment needed. The username is not provided from the comment table, as a result we need to use a Inner join in order to get it. 
if (isset($_POST['getAllComments'])) {
    $start = $conn->real_escape_string($_POST['start']);
    
    $response = "";
    $sqlGetComment = $conn->query("SELECT user_comment_table.comment_id, uidUsers, message, DATE_FORMAT(user_comment_table.created_on, '%Y-%m-%d') AS created_on FROM user_comment_table 
    INNER JOIN users ON user_comment_table.user_id = users.idUsers ORDER BY user_comment_table.comment_id DESC LIMIT $start, 20
    ");

    

    while($data= $sqlGetComment->fetch_assoc())
    $response .= createCommentRow($data);

    exit($response);
  }

// The function has the structure of the comment. Which is dynamically grabbed from the database. 

  function createCommentRow($data){
    return '
    <div class="comment"> 
    <div class="user">'.$data['uidUsers'].'<span class="time"> '.$data['created_on'].'</span></div> 
    <div class="userComment">'.$data['message'].'</div> 
    <div class="reply"><a href="javascript:void(0)" data-commentID="'.$data['comment_id'].'" value="true" onclick="reply(this)">REPLY</a></div>
    <div class="replies"> 
    
 
 
    </div> 
  </div> 
    ';
}

//The following is for use after I actually make the current issue resolved. Also to save time. This will automatically load the current replies. 

//  function createCommentRow($data){

//    global $conn;

//    $response = '
//    <div class="comment"> 
//    <div class="user">'.$data['uidUsers'].'<span class="time"> '.$data['created_on'].'</span></div> 
//    <div class="userComment">'.$data['message'].'</div> 
//    <div class="reply"><a href="javascript:void(0)" data-commentID="'.$data['comment_id'].'" onclick="reply(this)">REPLY</a></div>
//    <div class="replies">'; 
  
//    $sqlGetCommentR = $conn->query("SELECT replies.repliesID, uidUsers, message, DATE_FORMAT(replies.createdOn, '%Y-%m-%d') AS createdOn FROM replies 
//    INNER JOIN users ON replies.userID = users.idUsers WHERE replies.commentID = '".$data['comment_id']."' ORDER BY replies.repliesID DESC LIMIT 1");
//    while($dataR= $sqlGetCommentR->fetch_assoc())
//    $response .= createCommentRow($dataR);

//  $response .= '
//    </div> 
//  </div> 
//    ';

//    return $response;
//  }



if (isset($_POST['addComment'])) {
  $comment = $conn->real_escape_string($_POST['comment']);
  $isReply = $conn->real_escape_string($_POST['isReply']);
  $commentID  = $conn->real_escape_string($_POST['commentID']);

  if ($isReply == 'true') {
    $conn->query("INSERT INTO replies (replyMessage, commentID, userID, createdOn) VALUES ('$comment', '$commentID', '$user_id', NOW())");
    $sqlGetComment = $conn->query("SELECT replies.repliesID, uidUsers, replies.replyMessage, DATE_FORMAT(replies.createdOn, '%Y-%m-%d') AS createdOn FROM replies 
    INNER JOIN users ON replies.userID = users.idUsers ORDER BY replies.repliesID DESC LIMIT 1");
} else {
    $conn->query("INSERT INTO user_comment_table (user_comment_table.user_id, user_comment_table.message, user_comment_table.created_on) VALUES ('$user_id', '$comment', NOW())");
    $sqlGetComment = $conn->query("SELECT user_comment_table.comment_id, uidUsers, user_comment_table.message, DATE_FORMAT(user_comment_table.created_on, '%Y-%m-%d') 
    AS created_on FROM user_comment_table INNER JOIN users ON user_comment_table.user_id = users.idUsers ORDER BY user_comment_table.comment_id DESC LIMIT 1");
}
      //Problem atm is that replies go into the database, however main comments fail to go into main comment table. 
  
  $data = $sqlGetComment->fetch_assoc();
  exit(createCommentRow($data));

}





  ?>