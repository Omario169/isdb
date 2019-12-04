<?php
// Here we check whether the user got to this page by clicking the proper register button.
if (isset($_POST['signup-submit'])) {

  // The connection script is uncluded so we can use it later.

  require 'dbh.inc.php';

  // All the data from the register form is passed into several variables to be in use later. 
  $username = $_POST['uid'];
  $email = $_POST['mail'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];

  // Error handling

  // This will check for empty inputs from the user when submitting their details. 
  if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
    header("Location: ../register.php?error=emptyfields&uid=".$username."&mail=".$email);
    exit();
  }
  // This will check for invalid usernames and invalid emails. 
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../register.php?error=invaliduidmail");
    exit();
  }
  //This will check for invalid usernames, this will display the valid numbers and letters available. 
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../register.php?error=invaliduid&mail=".$email);
    exit();
  }
  // We check for an invalid e-mail.
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../register.php?error=invalidmail&uid=".$username);
    exit();
  }
  // We check if the repeated password is NOT the same.
  else if ($password !== $passwordRepeat) {
    header("Location: ../register.php?error=passwordcheck&uid=".$username."&mail=".$email);
    exit();
  }
  else {

    
    //The following is another error handler that will check if the username inputted is available. This is done using prepared statements for security. 


    //The SQL statement searches the database to check for identical usernames. 
    $sql = "SELECT uidUsers FROM users WHERE uidUsers=?;";
    // The prepared statement is created. The database connection is added. 
    $stmt = mysqli_stmt_init($conn);
    // Then we prepare our SQL statement and check for any errors.
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      // If there is an error we send the user back to the register page.
      header("Location: ../register.php?error=sqlerror");
      exit();
    }
    else {
     
      // We need to bind the different parameters that is expected to pass into the statement, and bind the users given data. 
      mysqli_stmt_bind_param($stmt, "s", $username);
      // The prepared statement is executed and send it to the database
      mysqli_stmt_execute($stmt);
      // Then we store the result from the statement.
      mysqli_stmt_store_result($stmt);
      //We then get the number of results from the statement. This will allow us to tell if the username exists or not. 
      $resultCount = mysqli_stmt_num_rows($stmt);
      // The prepared statement is then closed. 
      mysqli_stmt_close($stmt);
      // If the result count is more than 0 the username is taken and the user will be redirected. 
      if ($resultCount > 0) {
        header("Location: ../register.php?error=usertaken&mail=".$email);
        exit();
      }
      else {
      
       //Next, an SQL statement is prepared that will insert the user of the website into the database. This will be done using a prepared statement for security. 

        //The prepared statement sends the SQL code to the database first. Later the placeholder, "?", will be filled by sending the user data. 
        $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?, ?, ?);";
        //A new statement is initialised using the connection from the database server. 
        $stmt = mysqli_stmt_init($conn);
        // The SQL statement is prepared and  checked for errors.
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          // If there is an error we send the user back to the register page.
          header("Location: ../register.php?error=sqlerror");
          exit();
        }
        else {

          //The users password will be hased to make it un-readable in case someone gets access to the database without permission. Another security implementation. 
          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

          // Next we need to bind the type of parameters we expect to pass into the statement, and bind the inputted data from the user.
          mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
          // Then we execute the prepared statement and send it to the database.
          // The user is now registered. 
          mysqli_stmt_execute($stmt);
          // The user is sent back to the register page with a success message. 
          header("Location: ../register.php?register=success");
          exit();

        }
      }
    }
  }
  // The prepared statement and database connection is then closed. 
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  // If the user tries to access this page an inproper way, we send them back to the register page.
  header("Location: ../register.php");
  exit();
}

$sql = "SELECT * FROM user WHERE uidUsers='$username'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    $userid = $row['id'];
    $sql = "INSERT INTO profileimg (userid, status)
    VALUES ('$userid' 1)"; 
    mysqli_query($conn, $sql);
    header("Locatiob: index.php");

  }
} else {
  echo "You have an error!";
}
