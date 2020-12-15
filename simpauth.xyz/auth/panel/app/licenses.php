<?php

    include '../../includes/settings.php';
    error_reporting(0);

    if (!isset($_SESSION))
    {
        session_start();
    }

    if (!isset($_SESSION['username']))
    {
        header("Location: ../../account/login.php");
        exit();
    }

?>

<?php
    function xss_clean($data)
    {
        return strip_tags($data);
    }
?>

<?php 

    $id = xss_clean(mysqli_real_escape_string($con, $_GET['id']));
    $username = xss_clean(mysqli_real_escape_string($con, $_SESSION['username']));
    $result = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));
    $ban_check = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username' AND `isbanned` = '1'") or die(mysqli_error($con));

    if (mysqli_num_rows($ban_check) >= 1)
    {
        echo "<meta http-equiv='Refresh' Content='0; url=../../account/banned/'>";    
        exit();
    }

    while ($row = mysqli_fetch_array($result))
    {
        $isbanned = $row['banned'];
    }

    if ($isbanned == 1)
    {
        echo '
            <script type=\'text/javascript\'>
                
            const notyf = new Notyf();
            notyf
            .error({
                message: \'This program is banned!\',
                duration: 3500,
                dismissible: true
            });                
                
        </script>
        ';

        echo "<meta http-equiv='Refresh' Content='3; url=../app.php'>";    
        die();
    }

    if (mysqli_num_rows($result) < 1)
    {
        echo '
            <script type=\'text/javascript\'>
                
            const notyf = new Notyf();
            notyf
            .error({
                message: \'Invalid ID Program, redirecting(...)\',
                duration: 3500,
                dismissible: true
            });                
                
        </script>
        ';

        echo "<meta http-equiv='Refresh' Content='3; url=../app.php'>";    
        die();
    }

?>

<!DOCTYPE html>
<html lang="en">


<head>
<title>SimpAuth - A Free .NET Licensing Solution</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="title" content="SimpAuth - A Free .NET Licensing Solution">
	<meta name="description" content="A Free and Opensource Licensing System for .NET">
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://simpauth.xyz">
	<meta property="og:title" content="SimpAuth - A Free .NET Licensing Solution">
	<meta property="og:description" content="A Free and Opensource Licensing System for .NET">
	<meta property="og:image" content="https://cdn.discordapp.com/attachments/725094855185006612/771882879344181268/SimpAuth.png">
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:url" content="https://simpauth.xyz">
	<meta property="twitter:title" content="SimpAuth - A Free .NET Licensing Solution">
	<meta property="twitter:description" content="A Free and Opensource Licensing System for .NET">
	<meta property="twitter:image" content="https://cdn.discordapp.com/attachments/725094855185006612/771882879344181268/SimpAuth.png">
    

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/plugins.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="../../assets/css/forms/custom-clipboard.css">
    <script src="../../assets/js/clipboard/clipboard.min.js"></script>
    <script src="../../assets/js/forms/custom-clipboard.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    
    <link rel="stylesheet" type="text/css" href="../../plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="../../plugins/table/datatable/dt-global_style.css">

</head>
<body>
    
    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                </li>
                <li class="nav-item theme-text">
                <a href="https://simpauth.xyz/auth" class="nav-link"> SimpAuth </a>
                </li>
            </ul>

            <ul class="navbar-item flex-row ml-md-auto">




                <li class="nav-item dropdown user-profile-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <img src="../../assets/img/profile-16.jpg" alt="avatar">
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="">
                            <div class="dropdown-item">
                                <a href="../../profile/"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Profile</a>
                            </div>
                            <div class="dropdown-item">
                                <a href="../../account/logout.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Sign Out</a>
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

        </header>
    </div>

    
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

 <!--  BEGIN SIDEBAR  -->
 <div class="sidebar-wrapper sidebar-theme">
            
    <nav id="sidebar">
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <br><br>
            <li class="menu">
                <a href="../app.php" aria-expanded="false" class="dropdown-toggle">
                    <div class="">                                
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-down-left"><polyline points="9 10 4 15 9 20"></polyline><path d="M20 4v7a4 4 0 0 1-4 4H4"></path></svg>
                        <span>Leave</span>
                    </div>
                </a>                        
            </li>
        </br>

            <?php
                $id = xss_clean(mysqli_real_escape_string($con, $_GET['id']));
            ?>           

            <li class="menu">
                <center><h6 style="color: lightgray">General</h6></center></p>
                <a href="settings.php?id=<?php echo $id; ?>" aria-expanded="false" class="dropdown-toggle">
                    <div class="">                                
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span>Settings</span>
                    </div>
                </a>                        
            </li>

            <li class="menu">
                <a href="#" data-active="true" aria-expanded="true" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-right"><line x1="21" y1="10" x2="7" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="21" y1="18" x2="7" y2="18"></line></svg>
                        <span>Licenses</span>
                    </div>
                </a>                        
            </li>

            <li class="menu">
                <a href="users.php?id=<?php echo $id; ?>"  aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>Users</span>
                    </div>
                </a>                        
            </li>
            
            <li class="menu">                    
                <br>
                <br>
                <center><h6 style="color: lightgray">Security</h6></center></p>
                <!--<a href="files.php?id=<?php echo $id; ?>" aria-expanded="false" class="dropdown-toggle">                            
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                        <span>File Upload</span>
                    </div>
                </a>   -->                   
                <a href="variables.php?id=<?php echo $id; ?>" aria-expanded="false" class="dropdown-toggle">                            
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                        <span>Variables</span>
                    </div>
                </a>                        
            </li>

            <li class="menu">
                <br>
                <br>
                <center><h6 style="color: lightgray">Extra</h6></center></p>
                <a href="https://docs.simpauth.xyz" target="_blank" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        <span>Documentation</span>
                    </div>
                </a>
            </li>
            
        </ul>
        
    </nav>

</div>

<?php

    if (isset($_POST['delete_license']))
    {
        $to_delete = xss_clean(mysqli_real_escape_string($con, $_POST['secret']));
        $result = mysqli_query($con, "DELETE FROM `tokens` WHERE `owner` = '$username' AND `token` = '$to_delete'") or die(mysqli_error($con));

        if ($result)
        {
            echo '
                <script type=\'text/javascript\'>
                    
                const notyf = new Notyf();
                notyf
                .success({
                    message: \'Successfully deleted license!\',
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
                    message: \'An error occurred, try again!\',
                    duration: 3500,
                    dismissible: true
                });                
                    
            </script>
            ';
        }
    }

    if (isset($_POST['delete_all']))
    {
        $result = mysqli_query($con, "DELETE FROM `tokens` WHERE `owner` = '$username'") or die(mysqli_error($con));

        if ($result)
        {
            
            echo '
                <script type=\'text/javascript\'>
                    
                const notyf = new Notyf();
                notyf
                .success({
                    message: \'Successfully deleted all license!\',
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
                    message: \'An error occurred, try again!\',
                    duration: 3500,
                    dismissible: true
                });                
                    
            </script>
            ';            
        }

    }

    if (isset($_POST['delete_all_unused']))
    {
        $result = mysqli_query($con, "DELETE FROM `tokens` WHERE `owner` = '$username' AND `used` = '0'") or die(mysqli_error($con));

        if ($result)
        {

            echo '
                <script type=\'text/javascript\'>
                    
                const notyf = new Notyf();
                notyf
                .success({
                    message: \'All licenses un-used have been successfully deleted!\',
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
                    message: \'An error occurred, try again!\',
                    duration: 3500,
                    dismissible: true
                });                
                    
            </script>
            ';                        
        }
    }

    if (isset($_POST['delete_all_used']))
    {
        $result = mysqli_query($con, "DELETE FROM `tokens` WHERE `owner` = '$username' AND `used` = '1'") or die(mysqli_error($con));

        if ($result)
        {
            
            echo '
                <script type=\'text/javascript\'>
                    
                const notyf = new Notyf();
                notyf
                .success({
                    message: \'All licenses used have been successfully deleted!\',
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
                    message: \'An error occurred, try again!\',
                    duration: 3500,
                    dismissible: true
                });                
                    
            </script>
            ';                      
        }
    }

    if (isset($_POST['create_licenses']))
    {
        $id = xss_clean(mysqli_real_escape_string($con, $_GET['id']));
        $time_options = xss_clean(mysqli_real_escape_string($con, $_POST['options_time']));
        $level_licenses = xss_clean(mysqli_real_escape_string($con, $_POST['level_licenses']));
        $amount_licenses =  xss_clean(mysqli_real_escape_string($con, $_POST['amount_licenses']));
        $prefix_licenses =  xss_clean(mysqli_real_escape_string($con, $_POST['prefix_licenses']));
        $custom_days_licenses =  xss_clean(mysqli_real_escape_string($con, $_POST['custom_days_time']));


        $days_license = 0;

        if (strlen($prefix_licenses) > 20)
        {
            
            echo '
                <script type=\'text/javascript\'>
                    
                const notyf = new Notyf();
                notyf
                .error({
                    message: \'Your token prefix must be 20 characters or less!\',
                    duration: 3500,
                    dismissible: true
                });                
                    
            </script>
            ';                                  
        }
        else if (count(explode(' ', $prefix_licenses)) > 1)
        {
            
            echo '
                <script type=\'text/javascript\'>
                    
                const notyf = new Notyf();
                notyf
                .error({
                    message: \'Your token prefix must not contain any spaces!\',
                    duration: 3500,
                    dismissible: true
                });                
                    
            </script>
            ';                                              
            
        }

        if ($amount_licenses > 0 && $amount_licenses <= 50)
        {            
        }
        else
        {
            
            
            echo '
                <script type=\'text/javascript\'>
                    
                const notyf = new Notyf();
                notyf
                .error({
                    message: \'Invalid amount to generate!\',
                    duration: 3500,
                    dismissible: true
                });                
                    
            </script>
            ';                                                          
            

            echo "<meta http-equiv='Refresh' Content='2'; url='".$_SERVER."'>";
            die();
        }

        $result = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));
        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_array($result))
            {
                $app_token = $row['authtoken'];
            }
        }
        else
        {
            
            echo '
                <script type=\'text/javascript\'>
                    
                const notyf = new Notyf();
                notyf
                .error({
                    message: \'Invalid program ID or session username!\',
                    duration: 3500,
                    dismissible: true
                });                
                    
            </script>
            ';                                                                      

            echo "<meta http-equiv='Refresh' Content='2'; url='".$_SERVER."'>";
            die();
        }

        $grabinfo = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username'") or die(mysqli_error($con));

        while ($row = mysqli_fetch_array($grabinfo))
        {
            $subscription = $row['premium'];            
        }

        $users_count = mysqli_query($con, "SELECT * FROM `users` WHERE `programtoken` = '$app_token'") or die(mysqli_error($con));
        $check = 1;

        if ($subscription == "0")
        {
            if (mysqli_num_rows($users_count) > 50)
            {
                $check = 0;


                echo '
                    <script type=\'text/javascript\'>
                        
                    const notyf = new Notyf();
                    notyf
                    .error({
                        message: \'You cannot have more than 50 users! Purchase premium to remove this limit.\',
                        duration: 3500,
                        dismissible: true
                    });                
                        
                </script>
                ';                 
            
            }
        }

        if ($subscription == "1")
        {
            if (mysqli_num_rows($users_count) > 5000)
            {
                
                echo '
                    <script type=\'text/javascript\'>
                        
                    const notyf = new Notyf();
                    notyf
                    .error({
                        message: \'You cannot have more than 5000 users! Purchase "Large projects plan" to remove this limit.\',
                        duration: 3500,
                        dismissible: true
                    });                
                        
                </script>
                ';                                 
                
                $check = 0;

            }
        }

        if ($check == 1)
        {
            if ($time_options == "1d")
            {
                $days_license = 1;
            }
            else if ($time_options == "3d")
            {
                $days_license = 3;
            }
            else if ($time_options == "1w")
            {
                $days_license = 7;
            }
            else if ($time_options == "1m")
            {
                $days_license = 30;
            }
            else if ($time_options == "3m")
            {
                $days_license = 90;
            }
            else if ($time_options == "lifetime")
            {
                $days_license = 99999;
            }
            else if ($time_options == "custom")
            {
                $days_license = $custom_days_licenses;
            }
            else
            {
                
                echo '
                    <script type=\'text/javascript\'>
                        
                    const notyf = new Notyf();
                    notyf
                    .error({
                        message: \'Invalid license time!\',
                        duration: 3500,
                        dismissible: true
                    });                
                        
                </script>
                ';                                                 

                echo "<meta http-equiv='Refresh' Content='2'; url='".$_SERVER."'>";
                die();
            }

            if ($level_licenses > 10 || $level_licenses <= 0)
            {
                
                echo '
                    <script type=\'text/javascript\'>
                        
                    const notyf = new Notyf();
                    notyf
                    .error({
                        message: \'Invalid license level! (Maximum: 10)\',
                        duration: 3500,
                        dismissible: true
                    });                
                        
                </script>
                ';                                                 

                echo "<meta http-equiv='Refresh' Content='2'; url='".$_SERVER."'>";
                die();
            }


            $license_count = mysqli_query($con, "SELECT * FROM `tokens` WHERE `program` = '$id'") or die(mysqli_error($con));
            $check_anti_kid = 1;

            if ($subscription == "0")
            {
                if (mysqli_num_rows($license_count) >= 75 || $amount_licenses + mysqli_num_rows($license_count) > 75)
                {
                    $check_anti_kid = 0;


                    echo '
                        <script type=\'text/javascript\'>
                            
                        const notyf = new Notyf();
                        notyf
                        .error({
                            message: \'You cannot generate more than 75 licenses! Purchase premium to remove this limit.\',
                            duration: 3500,
                            dismissible: true
                        });                
                            
                    </script>
                    ';                                                 

                }
            }

            if ($subscription == "1")
            {
                if (mysqli_num_rows($license_count) >= 10000)
                {
                    $check_anti_kid = 0;


                    echo '
                        <script type=\'text/javascript\'>
                            
                        const notyf = new Notyf();
                        notyf
                        .error({
                            message: \'You cannot generate more than 10,000 licenses! Purchase "Large projects" to remove this limit.\',
                            duration: 3500,
                            dismissible: true
                        });                
                            
                    </script>
                    ';                                                 

                }
            }

            if ($subscription == "0" && $prefix_licenses != "AkizaIO")
            {
                $check_anti_kid = 0;
                
                
                    echo '
                        <script type=\'text/javascript\'>
                            
                        const notyf = new Notyf();
                        notyf
                        .error({
                            message: \'You can t change the prefix!, buy the premium subscription to have this feature\',
                            duration: 3500,
                            dismissible: true
                        });                
                            
                    </script>
                    ';                          
                
                
            }

            if ($check_anti_kid == 1)
            {
                $check_valid_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `id` = '$id'") or die(mysqli_error($con));

                if (mysqli_num_rows($check_valid_program) < 1)
                {
                    
                    
                    echo '
                        <script type=\'text/javascript\'>
                            
                        const notyf = new Notyf();
                        notyf
                        .error({
                            message: \'Invalid program ID!\',
                            duration: 3500,
                            dismissible: true
                        });                
                            
                    </script>
                    ';                                   
                    
                }
                else
                {
                    $license_format = xss_clean(mysqli_real_escape_string($con, $_POST['options_format']));

                    for ($i = 0; $i < $amount_licenses; $i++)
                    {
                        if ($license_format == "format1")
                        {
                            $license_key = GenerateTokenFormat1();
                        }
                        else if ($license_format == "format2")
                        {
                            $license_key = GenerateTokenFormat2();
                        }
                        else
                        {
                            $license_key = GenerateToken();
                        }

                        if (!empty($prefix_licenses))
                        {
                            $insert_prefix = mysqli_query($con, "INSERT INTO `tokens` (token, owner, program, days, used, used_by, level, programtoken) VALUES ('$prefix_licenses-$license_key', '$username', '$id', '$days_license', 0, '', '$level_licenses', '$app_token')") or die(mysqli_error($con));                            
                        }
                        else
                        {
                            $insert_prefix = mysqli_query($con, "INSERT INTO `tokens` (token, owner, program, days, used, used_by, level, programtoken) VALUES ('$license_key', '$username', '$id', '$days_license', 0, '', '$level_licenses', '$app_token')") or die(mysqli_error($con));                            
                        }
                    }

                    if ($insert_prefix)
                    {
                        
                        echo '
                            <script type=\'text/javascript\'>
                                
                            const notyf = new Notyf();
                            notyf
                            .success({
                                message: \'Successfully created licenses!\',
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
                                message: \'An error has occurred!\',
                                duration: 3500,
                                dismissible: true
                            });                
                                
                        </script>
                        ';                                                                                   
                        
                    }
                }
            }
        }

    }

    function GenerateToken() {
        for($i = 0; $i < 1; $i++) {
          $randomString = "";
          $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength = strlen($characters);
          for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
          }
          return $randomString;
        }
      }
    
    
    function GenerateTokenFormat1() {
        for ($i = 0; $i < 3; $i++){
            
        $randomString = "";
        for($i = 0; $i < 1; $i++) {
          $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength = strlen($characters);
          for ($i = 0; $i < 5; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
          }
        }
        $randomString2 = "";
        for($i = 0; $i < 1; $i++) {
          $characters2 = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength2 = strlen($characters2);
          for ($i = 0; $i < 5; $i++) {
            $randomString2 .= $characters2[rand(0, $charactersLength2 - 1)];
          }
        }
        $randomString3 = "";
        for($i = 0; $i < 1; $i++) {
          $characters3 = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength3 = strlen($characters3);
          for ($i = 0; $i < 5; $i++) {
            $randomString3 .= $characters3[rand(0, $charactersLength3 - 1)];
          }
        }
          return $randomString . "-" . $randomString2 . "-" . $randomString3;
          }
        }
        
    function GenerateTokenFormat2() {
        for ($i = 0; $i < 4; $i++){
            
        $randomString = "";
        for($i = 0; $i < 1; $i++) {
          $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength = strlen($characters);
          for ($i = 0; $i < 5; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
          }
        }
        $randomString2 = "";
        for($i = 0; $i < 1; $i++) {
          $characters2 = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength2 = strlen($characters2);
          for ($i = 0; $i < 5; $i++) {
            $randomString2 .= $characters2[rand(0, $charactersLength2 - 1)];
          }
        }
        $randomString3 = "";
        for($i = 0; $i < 1; $i++) {
          $characters3 = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength3 = strlen($characters3);
          for ($i = 0; $i < 5; $i++) {
            $randomString3 .= $characters3[rand(0, $charactersLength3 - 1)];
          }
        }
        
        $randomString4 = "";
        for($i = 0; $i < 1; $i++) {
          $characters4 = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength4 = strlen($characters4);
          for ($i = 0; $i < 5; $i++) {
            $randomString4 .= $characters4[rand(0, $charactersLength4 - 1)];
          }
        }    
          return $randomString . "-" . $randomString2 . "-" . $randomString3 . "-" . $randomString4;
          }
        }    

?>



        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                
                <div class="row layout-top-spacing">
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">

                        <?php
                            $result = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));
                            while ($row = mysqli_fetch_array($result))
                            {
                                $app_token = $row['authtoken'];
                            }

                            $grabprograms = mysqli_query($con, "SELECT * FROM `tokens` WHERE `owner` = '$username' AND `programtoken` = '$app_token'") or die(mysqli_error($con));
                            
                            echo '
                            <div class="">
                                <h6>These are all your (unused) licenses!</h6>
                                <textarea class="form-control mb-4" rows="3">';
                            while ($row = mysqli_fetch_array($grabprograms))
                            {
                                if ($row['used'] == "0")
                                {
                                    echo $row['token'] . "\n";
                                }                                
                            }
                            echo '</textarea>
                                        </div>
                            ';
                            ?>

                        
                            <div class="table-responsive mb-4 mt-4">         
                                <form method="POST" action="">
                                    <center>
                                        <button class="btn btn-outline-success mb-2" name="delete_all">Delete all licenses</button>
                                        <button class="btn btn-outline-success mb-2" name="delete_all_unused">Delete all un-used licenses</button>
                                        <button class="btn btn-outline-success mb-2" name="delete_all_used">Delete all used licenses</button>
                                    </center>
                                </form>


                                <br>
                                <br>

                                <table id="zero-config" class="table table-hover" style="width:100%">
                                    <thead>

                                        <tr>
                                            <th>ID</th>
                                            <th>License</th>
                                            <th>Used?</th>
                                            <th>Used by</th>
                                            <th>Expire <small>(days)</small></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                       <?php
                                        $result = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));
                                        while ($row = mysqli_fetch_array($result))
                                        {
                                            $app_token = $row['authtoken'];
                                        }

                                        $grabprograms = mysqli_query($con, "SELECT * FROM `tokens` WHERE `owner` = '$username' AND `programtoken` = '$app_token'") or die(mysqli_error($con));

                                        while ($row = mysqli_fetch_array($grabprograms))
                                        {
                                            {
                                                if ($row['used_by'] == "")
                                                {
                                                    $usedby = "N/A";
                                                }
                                                else
                                                {
                                                    $usedby = $row['used_by'];
                                                }

                                                echo '
                                                <tr>
                                                    <td>'.$row['id'].'</td>
                                                    <td>'.$row['token'].'</td>
                                                    <td>
                                                    '.($row['used'] == "1" ? "
                                                    <svg style=\"color: green\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-check\"><polyline points=\"20 6 9 17 4 12\"></polyline></svg>
                                                    " :                                                     
                                                    "<svg style=\"color: red\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-x\"><line x1=\"18\" y1=\"6\" x2=\"6\" y2=\"18\"></line><line x1=\"6\" y1=\"6\" x2=\"18\" y2=\"18\"></line></svg>").'
                                                    </td>
                                                    <td>'.$usedby.'</td>
                                                    <td>'.$row['days'].'</td>
                                                    <td>              
                                                        <form method="POST" action="">
                                                            <input class="w3-input" type="hidden" name="secret" value="'.$row['token'].'">                                  
                                                            <button class="btn btn-outline-danger mb-2" name="delete_license">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg><span class="icon-name"></span>                                                    
                                                            </button>
                                                        </form>                                                        
                                                    </td>                                                    
                                                </tr>
                                                ';
                                            }
                                        }

                                       ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>License</th>
                                            <th>Used?</th>
                                            <th>Last used by</th>
                                            <th>Expire <small>(days)</small></th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            </br>
                            </br>
                            </br>
                            </br>
                            </br>
                            <form method="POST" action="">
                                <h4>Generate Licenses</h4>
                                <br>
                                <h5>Amount</h5>
                                <input class="form-control" id="number" name="amount_licenses" required type="number" value="1", min="1", max="50">
                                <br>

                                <h5>Prefix</h5>
                                <input type="text" id="text" class="form-control" name="prefix_licenses" placeholder="SimpAuth" value="SimpAuth">
                                <br>

                                <h5>Level</h5>
                                <input class="form-control" id="number" name="level_licenses" required type="number" value="1", min="1", max="10">
                                <br>

                                <h5>Custom Days</h5>
                                <input class="form-control" name="custom_days_time" required type="number" value="0">
                                <br>

                                <h5>Time</h5>
                                <select id="options_time" class="form-control" name="options_time">
                                    <option value="1d">
                                        1 Day
                                    </option>
                                    <option value="3d">
                                        3 Days
                                    </option>
                                    <option value="1w">
                                        1 Week
                                    </option>
                                    <option value="1m">
                                        1 Month
                                    </option>
                                    <option value="3m">
                                        3 Months
                                    </option>
                                    <option value="lifetime" selected="selected">
                                        Lifetime
                                    </option>                                
                                    <option value="custom">
                                        Custom
                                    </option>
                                </select>

                                </br>

                                <h5>License Format</h5>
                                <select id="options_format" class="form-control" name="options_format">
                                    <option value="default">
                                        Default
                                    </option>
                                    <option value="format1">
                                        XXXXX-XXXXX-XXXXX
                                    </option>
                                    <option value="format2">
                                        XXXXX-XXXXX-XXXXX-XXXXX
                                    </option>
                                </select>

                                </br>
                                </br>
                                <button class="btn btn-primary mb-2" id="submit" type="submit" name="create_licenses">Generate licenses</button>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                <p class=""><a target="_blank" href="https://github.com/YungSamzy/SimpAuth">GitHub</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                </div>
            </div>
        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->
    
    
    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../../assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="../../bootstrap/js/popper.min.js"></script>
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <script src="../../plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../../assets/js/app.js"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="../../assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../../plugins/table/datatable/datatables.js"></script>
    <script>
        $('#zero-config').DataTable({
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 5 
        });
    </script>

</body>

</html>