<?php
    include '../includes/settings.php';
    error_reporting(0);

    if (!isset($_SESSION))
    {
        session_start();
    }

    $username = xss_clean(mysqli_real_escape_string($con, $_SESSION['username']));

    if (!isset($_SESSION['username']))
    {
        header("Location: ../account/login.php");
        exit();
    }
?>

<?php

    function xss_clean($data)
    {
        return strip_tags($data);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Akiza | Dashboard </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="../dashboard/dist/images/akicon.ico" />
    <link href="../assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="../assets/js/loader.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/plugins.css" rel="stylesheet" type="text/css" />

    <link href="../assets/css/components/timeline/custom-timeline.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />

    <!-- Alertas -->
    <link href="../plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/components/custom-sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    <script src="../plugins/sweetalerts/promise-polyfill.js"></script>
    <script src="../plugins/sweetalerts/sweetalert2.min.js"></script>
    <script src="../plugins/sweetalerts/custom-sweetalert.js"></script>

    <script src="https://kit.fontawesome.com/fe49a7dc3e.js" crossorigin="anonymous"></script>

</head>
<body>


<?php
// Check ban user

    $ban_check = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username' AND `isbanned` = '1'") or die(mysqli_error($con));

    if (mysqli_num_rows($ban_check) >= 1)
    {
        session_destroy();
        echo "<meta http-equiv='Refresh' Content='0; url=banned.php'>";         
        die();
    }

?>



    
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="#">
                        <img src="../assets/img/lock.svg" class="navbar-logo" alt="logo">
                    </a>
                </li>
                <li class="nav-item theme-text">
                    <a href="#" class="nav-link"> AKIZA </a>
                </li>
            </ul>



            <ul class="navbar-item flex-row ml-md-auto">




                <li class="nav-item dropdown user-profile-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <img src="../assets/img/profile-16.jpg" alt="avatar">
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="">
                            <div class="dropdown-item">
                                <a href="../profile/"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Profile</a>
                            </div>
                            <div class="dropdown-item">
                                <a href="../account/logout.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Sign Out</a>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN NAVBAR  -->
    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

            <ul class="navbar-nav flex-row">
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">
            
            <nav id="sidebar">
                <div class="shadow-bottom"></div>

                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li class="menu">


                        
                        <a href="#" data-active="true" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Dashboard</span>
                            </div>
                        </a>
                    </li>

            

                    
                    <li class="menu">
                        <a href="../panel/app.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                                <span>Applications</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="prices.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>                                
                                <span>Upgrade</span>
                            </div>
                        </a>
                    </li>
                   
                    <li class="menu">
                        <a href="../profile/index.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>                                
                                <span>Profile</span>
                            </div>
                        </a>                        
                    </li>

                    <li class="menu">                    
                        <br>
                        <br>
                        <center><h6 style="color: lightgray">Resources</h6></center></p>
                        <a href="download.php" aria-expanded="false" class="dropdown-toggle">                            
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                <span>Downloads</span>
                            </div>                            
                        </a>                        
                    </li>
                    
                    <li class="menu">
                        <a href="https://docs.akiza.io/" target="_blank" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-terminal"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>
                                <span>Documentation</span>
                            </div>
                        </a>                        
                    </li>   
                    
                </ul>
                
            </nav>

        </div>
        <!--  END SIDEBAR  -->
        
        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">


                  

                    <?php
                    // Statistics
                        $grabinfo = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username'") or die(mysqli_error($con));

                        while ($row = mysqli_fetch_array($grabinfo))
                        {
                            $email = xss_clean(mysqli_real_escape_string($con, $row['email']));
                            $subscription = $row['premium'];

                            $programcount = mysqli_query($con, "SELECT count('id') FROM `programs` WHERE `owner` = '$username'") or die(mysqli_error($con));
                            $row1 = mysqli_fetch_array($programcount);

                            $tokencount = mysqli_query($con, "SELECT count('id') FROM `tokens` WHERE `owner` = '$username'") or die(mysqli_error($con));

                            $row2 = mysqli_fetch_array($tokencount);
                        }

                    ?>




                    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="row widget-statistic">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="widget widget-one_hybrid widget-followers">
                                    <div class="widget-heading">
                                        <div class="w-icon">
                                            <i class="far fa-list-alt"></i>
                                                                                </div>
                                        <p class="w-value"><?php echo $row1[0]; echo ($subscription == "1" ? "/60" : "/1"); ?></p>
                                        <h5 class="">Applications</h5>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="widget widget-one_hybrid widget-referral">
                                    <div class="widget-heading">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                        </div>
                                        <p class="w-value"><?php echo $row2[0]; echo ($subscription == "1" ? "/10,000" : "/75"); ?></p>
                                        <h5 class="">Total Licenses</h5>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="widget widget-one_hybrid widget-engagement">
                                    <div class="widget-heading">
                                        <div class="w-icon">
                                            <i class="fas fa-ticket-alt"></i>
                                        </div>
                                        <p class="w-value"><?php echo ($subscription == "1" ? "Premium" : "Member"); ?></p>
                                        <h5 class="">Subscription</h5>
                                    </div>
                                </div>                                
                            </div>        
                                                    
                        </div>     
                                                                                                                                 
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="widget widget-one_hybrid widget-followers">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                                <p class="w-value"><?php echo $username; ?></p>
                                <h5 class="">Username</h5>
                            </div>
                        </div>                                
                    </div>     
                    <br><br><br><br><br><br><br><br>
                                        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-card-two">
                            <div class="widget-content">

                                <div class="media">
                                    <div class="w-img">
                                        <img src="../assets/img/g-8.png" alt="avatar">
                                    </div>
                                    <div class="media-body">
                                        <h6>Enter our discord server!</h6>
                                        <p class="meta-date-time">AkizaIO | .NET Secure authentication system</p>
                                    </div>
                                </div>

                                <div class="card-bottom-section">
                                    <h5>74 Total members </h5>

                                    <a href="https://discord.gg/UmJbzMd" target="_blank" class="btn">Enter now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-activity-three">

                            <div class="widget-heading">
                                <h5 class="">Announcements</h5>
                            </div>

                            <div class="widget-content">

                                <div class="mt-container mx-auto">   
                                <div class="t-content">
                                        <div class="t-uppercontent">
                                            <h5>New security!</h5>
                                            <h6>A new encryption security was added which makes your application much more secure, it creates a fully encrypted connection between the client and server ensuring that no attacker can bypass it, you can download the class and usage examples in the "downloads" section on your left.</h6>
                                            <span class="">10 October, 2020</span>
                                        </div>
                                     </div>                  
                                <br>                                
                                <div class="t-content">
                                        <div class="t-uppercontent">
                                            <h5>Updates!</h5>
                                            <h6>There have been many changes, new class API for .NET, two-factor security for accounts, Universal API, among other things, if you want to stay as updated as possible, enter the discord server!</h6>
                                            <span class="">5 October, 2020</span>
                                        </div>
                                     </div>                  
                                <br>
                                <div class="t-content">
                                        <div class="t-uppercontent">
                                            <h5>New discord server!</h5>
                                            <h6>The old discord server will no longer receive announcements about updates, or support, please enter to our the new discord server listed in the box next to it.</h6>
                                            <span class="">27 Sept, 2020</span>
                                        </div>
                                     </div>                  
                                <br>
                                <br>
                                    <div class="t-content">
                                        <div class="t-uppercontent">
                                            <h5>Welcome!</h5>
                                            <h6>This is the first announcement in the new Akiza.IO! page, I hope you like the new changes :)</h6>
                                            <span class="">27 Sept, 2020</span>
                                        </div>
                                     </div>
                                </div>               


                            </div>                            
                        </div>
                    </div>                


                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-activity-three">

                            <div class="widget-heading">
                                <h5 class="">Tutorial</h5>
                            </div>
                            </br>
                        
                            <center>
                                <iframe width="300" height="200" src="https://www.youtube.com/embed/xW35ZWpjt-Y" frameborder="1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </center>        


                        </div>
                    </div>        

                
                </div>




            
            </div>

            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">© 2020 <a target="_blank" href="https://akiza.io/">Akiza.IO</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                </div>
            </div>
        </div>
        <!--  END CONTENT PART  -->

    </div>

    <script src="../assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="../assets/js/custom.js"></script>

    <script src="../plugins/apex/apexcharts.min.js"></script>
    <script src="../assets/js/dashboard/dash_2.js"></script>

</body>
</html>