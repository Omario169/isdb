<?php
include_once 'includes/dbh.inc.php';



if (!isset($_GET['user_id'])) {
      
}
else if (isset($_GET['user_id'])) {
 $user_id = $_GET['user_id'];
 
 }

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

  function createCommentRow($data){
    return '
    <div class="comment"> 
    <div class="user">'.$data['uidUsers'].'<span class="time"> '.$data['created_on'].'</span></div> 
    <div class="userComment">'.$data['message'].'</div> 
    <div class="reply"><a href="javascript:void(0)" data-commentID="'.$data['comment_id'].'" onclick="reply(this)">REPLY</a></div>
    <div class="replies"> 
    
 
 
    </div> 
  </div> 
    ';
}


if (isset($_POST['addComment'])) {
  $comment = $conn->real_escape_string($_POST['comment']);
  $isReply = $conn->real_escape_string($_POST['isReply']);

  if ($isReply) {
    $conn->query("INSERT INTO replies (replyMessage, commentID, userID, createdOn) VALUES ('$comment', '', '$user_id', NOW())");
    $sqlGetComment = $conn->query("SELECT replies.repliesID, uidUsers, message, DATE_FORMAT(replies.createdOn, '%Y-%m-%d') AS createdOn FROM replies 
    INNER JOIN users ON replies.userID = users.idUsers ORDER BY replies.repliesID DESC LIMIT 1");
} else {
    $conn->query("INSERT INTO user_comment_table (user_id, message, created_on) VALUES ('$user_id', '$comment', NOW())");
    $sqlGetComment = $conn->query("SELECT user_comment_table.comment_id, uidUsers, message, DATE_FORMAT(user_comment_table.created_on, '%Y-%m-%d') AS created_on FROM user_comment_table 
    INNER JOIN users ON user_comment_table.user_id = users.idUsers ORDER BY user_comment_table.comment_id DESC LIMIT 1");
}
      
  
  $data = $sqlGetComment->fetch_assoc();
  exit(createCommentRow($data));

}





  ?>