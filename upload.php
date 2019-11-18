<?php
  //The if statement will check if the form has been submitted. 
  if (isset($_POST['submit'])) {
    //The file is grabbed using the FILES superglobal.
    $file = $_FILES['file'];
    //We assign the different information gathered from the file into variables. This is for later use. 
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileError = $file['error'];
    $fileSize = $file['size'];
    //This is the temporary location the file is stored in the browser, while it waits to get uploaded.
    $fileTempName = $file['tmp_name'];
   
    //We need to split the file name into name and extension. 
    $fileExt = explode('.', $fileName);
    //Then we get the extention, we ask for the "end" which is the format of the extension and ask for the string in lowercase. 
    $fileActualExt = strtolower(end($fileExt));

    //These are the extensions that will be allowed to be uploaded into the website. 
    $allowed = array("jpg", "jpeg", "png", "pdf");

    //First we check if the extention is allowed on the uploaded file with the in_array function. 
    if (in_array($fileActualExt, $allowed)) {
      //Then we check if there was an upload error
      if ($fileError === 0) {
        //This is the file size limit (500mb)
        if ($fileSize < 500000) {
          //A unique ID is created to prevent users overwriting each others files. This replaces teh name of the uploaded file.
          $fileNameNew = uniqid('', true).".".$fileActualExt;
          //This is where the new files are uploaded.
          $fileDestination = 'uploads/'.$fileNameNew;
          // The following function uploads the file from our temporary location to the upload folder. 
          move_uploaded_file($fileTempName, $fileDestination);
          //Going back to the previous page
          header("Location: index.php?uploadsuccess");
        }
        else {
          echo "Your file is too big!";
        }
      }
      else {
        echo "There was an error uploading your file, try again!";
      }
    }
    else {
      echo "You cannot upload files of this type!";
    }
  }
