<?php

//The session is started, then unset and then destroyed. The user will then be redirected to the index page. 
session_start();
session_unset();
session_destroy();
header("Location: ../index.php");
