<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <!-- Basic Page Needs
================================================== -->
<title>Hireo</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/colors/blue.css">
</head>
<body>
    <!-- Header Container
================================================== -->
<header id="header-container" class="fullwidth">

<!-- Header -->
<div id="header">
    <div class="container">
        
        <!-- Left Side Content -->
        <div class="left-side">
            
            <!-- Logo -->
            <div id="logo">
                <a href="index.php"><img src="images/logo2.png" data-sticky-logo="images/logo.png" data-transparent-logo="images/logo2.png" alt=""></a>
            </div>

            <!-- Main Navigation -->
            <nav id="navigation">
                <ul id="responsive">

                    <li><a href="index.php">Home</a></li>

                    <li><a href="search-jobs.php">Job search</a>
                        
                    </li>

                    <li><a href="browse-employer.php">Search for an Employer</a>
                        
                    </li>
                </ul>
            </nav>
            <div class="clearfix"></div>
            <!-- Main Navigation / End -->
            
        </div>
        <!-- Left Side Content / End -->


        <!-- Right Side Content / End -->
        <div class="right-side" style="margin-top:30px">
        <a href="index-logged-out.php" style="color:white"><i class="icon-material-outline-power-settings-new"></i> Logout</a>

            </div>
            <!-- User Menu / End -->

            <!-- Mobile Navigation Button -->
            <span class="mmenu-trigger">
                <button class="hamburger hamburger--collapse" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </span>

        </div>
        <!-- Right Side Content / End -->

    </div>
</div>
<!-- Header / End -->

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->
</body>
</html>