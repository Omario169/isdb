<?php
    session_start();
    include_once 'includes/dbh.inc.php';
    
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>ISDB - Internet Sound Database</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="style.css">
   
   <!-- Font awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">


</head>


<!-- ##### Header Area Start ##### -->

    <header class="header-area1>
    
        <!-- Navbar Area -->
        <div class="oneMusic-main-menu">
            <div class="classy-nav-container2 breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="oneMusicNav">

                        
                        <h1> Internet Sound Database </h1>

                        

                        <!-- Nav brand -->
                        <a href="index.html" class="nav-brand"><img src="img/core-img/logo.png" alt="ISDB logo" style="width:50%;height:20%;"></a>

                            
                    </nav>
                </div>
            </div>
        </div>
    </header>
   
    <header class="header-area>
    
        <!-- Navbar Area -->
        <div class="oneMusic-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="oneMusicNav">

                       
                        

                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">

                            <!-- Close Button -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="albums-store.html">Albums</a></li>
                                    <li><a href="profile.php">Profile</a>
                                        <ul class="dropdown">
                                            <li><a href="index.html">Listen List</a></li>
                                            <li><a href="albums-store.html">Artist List</a></li>
                                            <li><a href="event.html">Shopping List</a></li>
                                         
                                           
                                            <li><a href="login.php">Login</a></li>
                                            <li><a href="#">Dropdown</a>
                                                <ul class="dropdown">
                                                    <li><a href="#">Even Dropdown</a></li>
                                                    <li><a href="#">Even Dropdown</a></li>
                                                    <li><a href="#">Even Dropdown</a></li>
                                                    <li><a href="#">Even Dropdown</a>
                                                        <ul class="dropdown">
                                                            <li><a href="#">Deeply Dropdown</a></li>
                                                            <li><a href="#">Deeply Dropdown</a></li>
                                                            <li><a href="#">Deeply Dropdown</a></li>
                                                            <li><a href="#">Deeply Dropdown</a></li>
                                                            <li><a href="#">Deeply Dropdown</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#">Even Dropdown</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="uploadimages.php">Upload Images</a></li>
                                    <li><a href="blog.html">News</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                   
                                   
                                    <!-- The following php code will display the log in form when the user is logged out. The log out button will subsequently be displayed if the user is logged in. -->
                                    </ul>
                                    <div class="header-login">
                                    <?php
                                        if (!isset($_SESSION['id'])) {
                                            echo '<form action="includes/login.inc.php" method="post">
                                            <input type="text" name="mailuid" placeholder="Username">
                                            <input type="password" name="pwd" placeholder="Password">
                                            <button type="submit" name="login-submit">Login</button>
                                            </form>
                                            <a href="register.php" class="header-signup">Signup</a>';
                                            }
                                            else if (isset($_SESSION['id'])) {
                                            echo '<form action="includes/logout.inc.php" method="post">
                                            <button type="submit" name="login-submit">Logout</button>
                                            </form>';
                                            }
                                            ?>
                                    </div>
                                        
                                   </div>
                            </div>
                            <!-- Nav End -->

                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>


