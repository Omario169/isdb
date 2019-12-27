<?php
include_once 'includes/dbh.inc.php';

if (isset($_POST['getAllComments'])) {
    $start = $conn->real_escape_string($_POST['start']);
    
    $response = "";
    $sqlGetComment = $conn->query("SELECT uidUsers, message, DATE_FORMAT(user_comment_table.created_on, '%Y-%m-%d') AS created_on FROM user_comment_table 
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
    <div class="replies"> 
    
 
 
    </div> 
  </div> 
    ';
}

  ?>