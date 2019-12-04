<?php
$dBServername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "loginsystem_isdb";

// Create connection
$conn = mysqli_connect($dBServername, $dBUsername, $dBPassword, $dBName);
$db = mysqli_select_db($conn, 'loginsystem_isdb');

// Check connection, if unable to connect error message below will be displayed.
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


