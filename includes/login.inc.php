<?php
// This if statement will check if the user got to the login.in page via clicking the button. 
if (isset($_POST['login-submit'])) {

  // The connection script is included for later use. 
  
  require 'dbh.inc.php';

  // The data from the sign up form is passed into the following variables to be used later. 
  $mailuid = $_POST['mailuid'];
  $password = $_POST['pwd'];

  //Error handlers are made to catch any errors made by the user. If errors are made we stop the script from rinning and take the user back to the login form with a error message. 

  // This will check for empty inputs in the login form.
  if (empty($mailuid) || empty($password)) {
    header("Location: ../index.php?error=emptyfields&mailuid=".$mailuid);
    exit();
  }
  else {

    //Next, we will retrieve the password the user set in the database and check that it has the same username as what the user typed in. 
    //We then need to de-hash it and check if it matches the password the user typed into the login form. 

    //A connection to the database is made using prepared statements and work by sending SQL to the database. We then fill in the palceholders by sending the users data. 
    $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
    // A new statement is inititalised using a connection to the database. 
    $stmt = mysqli_stmt_init($conn);
    // Then we prepare our SQL statement AND check if there are any errors with it.
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      // If there is an error we send the user back to the signup page.
      header("Location: ../index.php?error=sqlerror");
      exit();
    }
    else {

      // If there is no error then we continue

      // We then need to bind the parameters that are passed into the statement, and bind the data from the users. 
      mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
      // The prepared statement is executed and sent to the database. 
      mysqli_stmt_execute($stmt);
      // And we get the result from the statement.
      $result = mysqli_stmt_get_result($stmt);
      // The result is then stored into a variable
      if ($row = mysqli_fetch_assoc($result)) {
        // Then we match the password from the database with the password the user submitted. The result is returned as a boolean.
        $pwdCheck = password_verify($password, $row['pwdUsers']);
        // If they don't match an error message is displayed. 
        if ($pwdCheck == false) {
          // If there is an error we send the user back to the signup page.
          header("Location: ../index.php?error=wrongpwd");
          exit();
        }
        // If there is a match we know the correct user is logged inside. 
        else if ($pwdCheck == true) {

         //Session variables are created which are based on the users information in the database. 
          //The database data that is retrived is then stored in a session varaible. This will be used on all pages running a session. 
          //a session will be started on this page to be able to create the variables. 
          session_start();
          // The session variables are created. 
          $_SESSION['id'] = $row['idUsers'];
          $_SESSION['uid'] = $row['uidUsers'];
          $_SESSION['email'] = $row['emailUsers'];
          // The user is signed in now and is taken back to the front page. 
          header("Location: ../index.php?login=success");
          exit();
        }
      }
      else {
        header("Location: ../index.php?login=wronguidpwd");
        exit();
      }
    }
  }
  // The database connection and the prepared statement are both closed to save resources. 
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  // If the user tries to access this page an inproper way, we send them back to the signup page.
  header("Location: ../register.php");
  exit();
}
