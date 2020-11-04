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
    <title>Akiza | Plan prices </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="../dashboard/dist/images/akicon.ico" />
    <link href="../assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="../assets/js/loader.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/plugins.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <link href="../assets/css/components/timeline/custom-timeline.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="../plugins/pricing-table/css/component.css" rel="stylesheet" type="text/css" />

    <script src="https://autobuy.io/js/embed.min.js"></script>

    <script src="https://kit.fontawesome.com/fe49a7dc3e.js" crossorigin="anonymous"></script>

</head>
<body>


    <?php
    // Check ban user

        $ban_check = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username' AND `isbanned` = '1'") or die(mysqli_error($con));

        if (mysqli_num_rows($ban_check) >= 1)
        {
            session_destroy();
            echo "<meta http-equiv='Refresh' Content='0; url=../account/banned/'>";         
            die();
        }

    ?>


    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="index.html">
                        <img src="../assets/img/lock.svg" class="navbar-logo" alt="logo">
                    </a>
                </li>
                <li class="nav-item theme-text">
                    <a href="index.html" class="nav-link"> AKIZA </a>
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



    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

            <ul class="navbar-nav flex-row">
            </ul>
        </header>
    </div>



    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>


        <div class="sidebar-wrapper sidebar-theme">
            
            <nav id="sidebar">
                <div class="shadow-bottom"></div>

                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li class="menu">


                        
                        <a href="index.php" aria-expanded="false" class="dropdown-toggle">
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
                        <a href="#" data-active="true" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>                                
                                <span>Upgrade</span>
                            </div>
                        </a>
                    </li>
                   
                    <li class="menu">
                        <a href="../profile/" aria-expanded="false" class="dropdown-toggle">
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

        

        <?php
        
        if (isset($_POST['redeem_key']))
        {
            $token = xss_clean(mysqli_real_escape_string($con, $_POST['key_to_redeem']));
            $premium_check = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username' AND `premium` = '1'") or die(mysqli_error($con));
            
            if (mysqli_num_rows($premium_check) >= 1)
            {
                echo '
                    <script type=\'text/javascript\'>
                        
                    const notyf = new Notyf();
                    notyf
                    .error({
                        message: \'Your account is already premium!\',
                        duration: 3500,
                        dismissible: true
                    });                
                        
                </script>
                ';                
                
            }
            else
            {
                $checking_token =  mysqli_query($con, "SELECT * FROM `premium` WHERE `token` = '$token' AND `used` = '0'") or die(mysqli_error($con));
                
                if(mysqli_num_rows($checking_token) >= 1)
                {
                    $updatetoken = mysqli_query($con, "UPDATE `premium` SET `used` = '1', `used_by` = '$username' WHERE `token` = '$token'") or die(mysqli_error($con));
                    if ($updatetoken)
                    {
                        $updateuser = mysqli_query($con, "UPDATE `owners` SET `premium` = '1' WHERE `username` = '$username'") or die(mysqli_error($con));
                                        
                        if ($updateuser)
                        {
                            
                            echo '
                                <script type=\'text/javascript\'>
                                    
                                const notyf = new Notyf();
                                notyf
                                .success({
                                    message: \'Your account has been upgraded to premium!\',
                                    duration: 3500,
                                    dismissible: true
                                });                
                                    
                            </script>
                            ';           
                        }
                        else
                        {
                            
                            echo '
                                <script type=\'text/javascript\'>
                                    
                                const notyf = new Notyf();
                                notyf
                                .error({
                                    message: \'There was an error upgrading your account to premium!\',
                                    duration: 3500,
                                    dismissible: true
                                });                
                                    
                            </script>
                            ';           
                        
                        }
                    }
                    else
                    {
                        
                            echo '
                                <script type=\'text/javascript\'>
                                    
                                const notyf = new Notyf();
                                notyf
                                .error({
                                    message: \'There was an error upgrading your account to premium!\',
                                    duration: 3500,
                                    dismissible: true
                                });                
                                    
                            </script>
                            ';           
                        
 
                    }
                }
                else
                {
                    
                            echo '
                                <script type=\'text/javascript\'>
                                    
                                const notyf = new Notyf();
                                notyf
                                .error({
                                    message: \'Your license to upgrade the account does not exist!\',
                                    duration: 3500,
                                    dismissible: true
                                });                
                                    
                            </script>
                            ';           

                }                
                
            }
            
        }
        
        ?>
                                    
                                    
                                    
        

        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">


                  
                    <div class="col-lg-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Plan prices</h4>
                                    </div>           
                                </div>
                            </div>
                            
                                    
                            <div class="widget-content widget-content-area">
                                
                                    
                                <div class="container">                                    
                                    <div id="pricingWrapper" class="row">
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card stacked mt-5">
                                                <div class="card-header pt-0">
                                                    <span class="card-price">$0.00</span>
                                                    <h3 class="card-title mt-3 mb-1">Free plan</h3>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group list-group-minimal mb-3">
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">3 Programs
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Maximum 50 users per program
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Maximum 75 users per program
                                                        </li>
                                                    </ul>
                                                    <a href="#" class="btn btn-block btn-primary" disabled>FREE</a>
                                                </div>
                                            </div>
                                        </div>                              
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card stacked mt-5">
                                                <div class="card-header pt-0">
                                                    <span class="card-price"><small>$12.99</small></span>
                                                    <h3 class="card-title mt-3 mb-1">Premium Upgrade                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group list-group-minimal mb-3">
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">60 Programs
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">5000 Users per program
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">10000 Licenses per program
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Access to secure server-side variable management
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Unlimited server sided variables
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Customisable prefix for licences
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">API Access
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Prioritised Support
                                                        </li>
                                                    </ul>

                                                    <a data-autobuy-product="380244bf-9a9b-470f-8f0c-08d842cf9dbd" class="btn btn-block btn-primary">Buy Now</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card stacked mt-5">
                                                <div class="card-header pt-0">
                                                    <span class="card-price"><small>$19.99</small></span>
                                                    <h3 class="card-title mt-3 mb-1">Large projects</h3>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group list-group-minimal mb-3">
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Unlimited Programs
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Unlimited Users
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Unlimited Licenses
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Access to secure server-side variable management
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Unlimited server sided variables
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Customisable prefix for licences
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">API Access
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Prioritised Support
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Exclusive access to new features
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Support the project
                                                        </li>
                                                    </ul>
                                                    <a href="#" class="btn btn-block btn-primary" disabled>Soon</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <form class="simple-example" action="" method="POST">
                                        <div class="col-md-12 mb-4">
                                            <h6>Redeem your purchase license to get the premium rank!</h6>
                                            <input type="text" class="form-control" name="key_to_redeem" placeholder="" value="" required="">
                                            <button class="btn btn-primary submit-fn mt-2" type="submit" name="redeem_key">Redeem key</button>
                                        </div>
                                    </form>                                
                            </div>
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