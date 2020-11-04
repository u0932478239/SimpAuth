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
    <title>Akiza | Application settings </title>
    <meta charset="utf-8">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="../../dashboard/dist/images/akicon.ico" />

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/plugins.css" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" type="text/css" href="../../plugins/bootstrap-select/bootstrap-select.min.css">

    
    <link rel="stylesheet" type="text/css" href="../../plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="../../plugins/table/datatable/dt-global_style.css">

    <link rel="stylesheet" type="text/css" href="../../assets/css/forms/switches.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    
    <link href="../../plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    <script src="../../plugins/sweetalerts/promise-polyfill.js"></script>


</head>
<body>
    

    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="#">
                        <img src="../../assets/img/lock.svg" class="navbar-logo" alt="logo">
                    </a>
                </li>
                <li class="nav-item theme-text">
                    <a href="#" class="nav-link"> AKIZA </a>
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
                        <a href="#" data-active="true" aria-expanded="true" class="dropdown-toggle">
                            <div class="">                                
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                <span>Settings</span>
                            </div>
                        </a>                        
                    </li>

                    <li class="menu">
                        <a href="licenses.php?id=<?php echo $id; ?>"  aria-expanded="false" class="dropdown-toggle">
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
                        <a href="files.php?id=<?php echo $id; ?>"  aria-expanded="false" class="dropdown-toggle">                            
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                                <span>File upload</span>
                            </div>
                        </a>      
                        <a href="variables.php?id=<?php echo $id; ?>"  aria-expanded="false" class="dropdown-toggle">                            
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
                        <a href="https://docs.akiza.io/" target="_blank" aria-expanded="false" class="dropdown-toggle">
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

            $id = xss_clean(mysqli_real_escape_string($con, $_GET['id']));
            $result = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));

            while ($row = mysqli_fetch_array($result))
            {
                $app_enabled = xss_clean($row['enabled']);
                $app_freemode = xss_clean($row['freemode']);
                $app_devmode = xss_clean($row['developermode']);
                $app_hwidlock = xss_clean($row['hwidlock']);
                $app_antidebug = xss_clean($row['antidebug']);
                $app_hashcheck = xss_clean($row['hashcheck']);
                $app_updater = xss_clean($row['enableupdater']);
                $app_hash = xss_clean($row['hash']);
                $app_link_updater = xss_clean($row['downloadlink']);
                $app_version = xss_clean($row['version']);
            }

        ?>


        <?php

            if (isset($_POST['savesettings']))            
            {
                $id = xss_clean(mysqli_real_escape_string($con, $_GET['id']));
                $freemode = xss_clean(mysqli_real_escape_string($con, $_POST['option_freemode']));
                $enabled = xss_clean(mysqli_real_escape_string($con, $_POST['option_enabled']));
                $devmode = xss_clean(mysqli_real_escape_string($con, $_POST['option_devmode']));
                $hwidlock = xss_clean(mysqli_real_escape_string($con, $_POST['option_hwidlock']));
                $antidebug = 0;

                if (!$freemode == 0 && !$freemode == 1 || !$enabled == 0 && !$enabled == 1 || !$devmode == 0 && !$devmode == 1 || !$hwidlock == 0 && !$hwidlock == 1 || !$antidebug == 0 && !$antidebug == 1)
                {
                    
                    echo '
                        <script type=\'text/javascript\'>
                            
                        const notyf = new Notyf();
                        notyf
                        .error({
                            message: \'Invalid Input!\',
                            duration: 3500,
                            dismissible: true
                        });                
                            
                    </script>
                    ';
                }
                else
                {
                    $result = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));

                    if (mysqli_num_rows($result) > 0)
                    {
                        $sending_collection = mysqli_query($con, "UPDATE `programs` SET `freemode` = '$freemode', `enabled` = '$enabled', `developermode` = '$devmode', `antidebug` = '$antidebug', `hwidlock` = '$hwidlock' WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));

                        if ($sending_collection)
                        {
                            echo '
                                <script type=\'text/javascript\'>
                                    
                                const notyf = new Notyf();
                                notyf
                                .success({
                                    message: \'Successfully edited changes!\',
                                    duration: 3500,
                                    dismissible: true
                                });                
                                    
                            </script>
                            ';

                            echo "<meta http-equiv='Refresh' Content='2'; url='".$_SERVER."'>"; 
                        }
                        else
                        {
                            
                            echo '
                                <script type=\'text/javascript\'>
                                    
                                const notyf = new Notyf();
                                notyf
                                .error({
                                    message: \'An error occurred while saving the selected data, try again!\',
                                    duration: 3500,
                                    dismissible: true
                                });                
                                    
                            </script>
                            ';
                            
                        }
                    }
                }
            }


            if (isset($_POST['save_integrity']))
            {
                $id = xss_clean(mysqli_real_escape_string($con, $_GET['id']));
                $hash_check = xss_clean(mysqli_real_escape_string($con, $_POST['option_hashcheck']));
                $hash_program = xss_clean(mysqli_real_escape_string($con, $_POST['option_hash']));

                if (strlen($hash_program) > 100)
                {
                    
                    echo '
                        <script type=\'text/javascript\'>
                                    
                        const notyf = new Notyf();
                        notyf
                        .error({
                            message: \'The program hash cannot contain more than 100 characters!\',
                            duration: 3500,
                            dismissible: true
                        });                
                                    
                    </script>
                    ';
                }
                else
                {
                    $result = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));

                    if (mysqli_num_rows($result) > 0)
                    {
                        $sending_collection = mysqli_query($con, "UPDATE `programs` SET `hash` = '$hash_program', `hashcheck` = '$hash_check' WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));

                        if ($sending_collection)
                        {
                            
                            echo '
                                <script type=\'text/javascript\'>
                                            
                                const notyf = new Notyf();
                                notyf
                                .success({
                                    message: \'Successfully edited changes!\',
                                    duration: 3500,
                                    dismissible: true
                                });                
                                            
                            </script>
                            ';

                            echo "<meta http-equiv='Refresh' Content='2'; url='".$_SERVER."'>"; 
                        }
                        else
                        {
                            
                            
                            echo '
                                <script type=\'text/javascript\'>
                                            
                                const notyf = new Notyf();
                                notyf
                                .error({
                                    message: \'An error occurred while saving the selected data, try again!\',
                                    duration: 3500,
                                    dismissible: true
                                });                
                                            
                            </script>
                            ';                            
                            
                        }
                    }
                }
            }

            if (isset($_POST['save_updatersettings']))
            {
                $id = xss_clean(mysqli_real_escape_string($con, $_GET['id']));
                $updater_link = xss_clean(mysqli_real_escape_string($con, $_POST['option_updater_link']));
                $updater_check = xss_clean(mysqli_real_escape_string($con, $_POST['option_updater_check']));
                $updater_version = xss_clean(mysqli_real_escape_string($con, $_POST['option_updater_version']));

                $result = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));

                if (mysqli_num_rows($result))
                {
                    $sending_collection = mysqli_query($con, "UPDATE `programs` SET `version` = '$updater_version', `downloadlink` = '$updater_link', `enableupdater` = '$updater_check' WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));
                    if ($sending_collection)
                    {
                            echo '
                                <script type=\'text/javascript\'>
                                            
                                const notyf = new Notyf();
                                notyf
                                .success({
                                    message: \'Successfully edited changes!\',
                                    duration: 3500,
                                    dismissible: true
                                });                
                                            
                            </script>
                            ';

                        echo "<meta http-equiv='Refresh' Content='2'; url='".$_SERVER."'>"; 
                    }
                    else
                    {
                        
                        echo '
                            <script type=\'text/javascript\'>
                                                
                            const notyf = new Notyf();
                            notyf
                            .error({
                                message: \'An error occurred while saving the selected data, try again!\',
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
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                        <form method="POST" action="">
                            <div class="table-responsive mt-4 mb-4">
                                <h4>Settings</h4>
                                </br>
                                </br>
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">                                    
                                    <h5>Application enabled</h5>
                                </div>          

                                <div class="">
                                    <div class="col-md-12">
                                        <div id="select_menu" class="form-group mb-4">
                                            <select class="custom-select" name="option_enabled">
                                                <option value="<?php echo ($app_enabled == "1" ? "1" : "0") ?>"><?php echo ($app_enabled == "1" ? "True" : "False"); ?></option>
                                                <option value="<?php echo ($app_enabled == "1" ? "0" : "1") ?>"><?php echo ($app_enabled == "1" ? "False" : "True"); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">                                    
                                    <h5>Free mode</h5>
                                </div>     

                                <div class="">
                                    <div class="col-md-12">
                                        <div id="select_menu" class="form-group mb-4">
                                            <select class="custom-select" name="option_freemode">
                                                <option value="<?php echo ($app_freemode == "1" ? "1" : "0") ?>"><?php echo ($app_freemode == "1" ? "True" : "False"); ?></option>
                                                <option value="<?php echo ($app_freemode == "1" ? "0" : "1") ?>"><?php echo ($app_freemode == "1" ? "False" : "True"); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">                                    
                                    <h5>Developer mode</h5>
                                </div>     

                                <div class="">
                                    <div class="col-md-12">
                                        <div id="select_menu" class="form-group mb-4">
                                            <select class="custom-select" name="option_devmode">
                                                <option value="<?php echo ($app_devmode == "1" ? "1" : "0") ?>"><?php echo ($app_devmode == "1" ? "True" : "False"); ?></option>
                                                <option value="<?php echo ($app_devmode == "1" ? "0" : "1") ?>"><?php echo ($app_devmode == "1" ? "False" : "True"); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">                                    
                                    <h5>HWID Lock</h5>
                                </div>                                

                                <div class="">
                                    <div class="col-md-12">
                                        <div id="select_menu" class="form-group mb-4">
                                            <select class="custom-select" name="option_hwidlock">
                                                <option value="<?php echo ($app_hwidlock == "1" ? "1" : "0") ?>"><?php echo ($app_hwidlock == "1" ? "True" : "False"); ?></option>
                                                <option value="<?php echo ($app_hwidlock == "1" ? "0" : "1") ?>"><?php echo ($app_hwidlock == "1" ? "False" : "True"); ?></option>
                                            </select>
                                        </div>
                                        <button class="btn btn-primary mb-2" type="submit" name="savesettings">Save Settings</button>
                                    </div>
                                </div>

                            </div>
                            </form>

                            <br>
                            <h4>Integrity</h4>
                            <br>
                            <form method="POST" action="">

                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">                                    
                                <h5>Integrity security <small>(Verify the hash of the program)</small></h5>
                            </div>                                
                            <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                <input type="text" id="option_hash" class="form-control" name="option_hash" placeholder="<?php echo ($app_hash == null ? "Program hash" : $app_hash); ?>" value="<?php echo ($app_hash == null ? "" : $app_hash); ?>">         
                                <br>                       
                            </div>                                  
                                <div class="">
                                    <div class="col-md-12 ">
                                        <div id="select_menu" class="form-group mb-4">
                                            <select class="custom-select" name="option_hashcheck">
                                                <option value="<?php echo ($app_hashcheck == "1" ? "1" : "0") ?>"><?php echo ($app_hashcheck == "1" ? "True" : "False"); ?></option>
                                                <option value="<?php echo ($app_hashcheck == "1" ? "0" : "1") ?>"><?php echo ($app_hashcheck == "1" ? "False" : "True"); ?></option>
                                            </select>
                                        </div>
                                        <button name="save_integrity" class="btn btn-primary mb-2">Save Integrity Settings</button>  

                                    </div>                                
                                </div>         
                            </form>

                            <br>
                            <br>
                            <br>
                            <h4>Updater</h4>
                            <br>
                            <form method="POST" action="">

                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">                                    
                               <h6><small>(what it will do is that if there is a new version, it will open the page you enter)</small></h6>
                            </div>                                
                            <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                <input type="text" id="option_updater_version" class="form-control" name="option_updater_version" placeholder="<?php echo $app_version; ?>" value="<?php echo ($app_version == null ? "" : $app_version); ?>">         
                                <br>
                                <input type="text" id="option_updater_link" class="form-control" name="option_updater_link" value="<?php echo ($app_link_updater == null ? "" : $app_link_updater); ?>" placeholder="<?php echo ($app_link_updater == null ? "Link" : $app_link_updater); ?>">         
                                <br>           
                            </div>      
                            <div class="">
                                    <div class="col-md-12 ">
                                        <div id="select_menu" class="form-group mb-4">
                                            <select class="custom-select" name="option_updater_check">
                                                <option value="<?php echo ($app_updater == "1" ? "1" : "0") ?>"><?php echo ($app_updater == "1" ? "True" : "False"); ?></option>
                                                <option value="<?php echo ($app_updater == "1" ? "0" : "1") ?>"><?php echo ($app_updater == "1" ? "False" : "True"); ?></option>
                                            </select>
                                        </div>
                                        <button name="save_updatersettings" class="btn btn-primary mb-2">Save Updater Settings</button>  
                                    </div>                                
                                </div>    
                                
                            </form>                                                            

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


    <script src="../../plugins/table/datatable/datatables.js"></script>

</body>

</html>