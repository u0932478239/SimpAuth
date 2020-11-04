<?php

    include '../../../includes/settings.php';
    error_reporting(0);

    if (!isset($_SESSION))
    {
        session_start();
    }

    if (!isset($_SESSION['username']))
    {
        header("Location: ../../../account/login.php");
        exit();
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
    <link rel="icon" type="image/x-icon" href="https://simpauth.xyz/favcon.png"/>

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../../assets/css/plugins.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../../plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="../../../plugins/table/datatable/dt-global_style.css">

</head>
<body>
    


<?php
    function xss_clean($data)
    {
        return strip_tags($data);
    }
?>






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
                        <img src="../../../assets/img/profile-16.jpg" alt="avatar">
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="">
                            <div class="dropdown-item">
                                <a href="../../../profile/"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Profile</a>
                            </div>
                            <div class="dropdown-item">
                                <a href="../../../account/logout.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Sign Out</a>
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
            

    <?php
        $id = xss_clean(mysqli_real_escape_string($con, $_GET['id']));
        $client = xss_clean(mysqli_real_escape_string($con, $_GET['varid']));
    ?>

    <nav id="sidebar">
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <br><br>
            <li class="menu">
                <a href="../variables.php?id=<?php echo $id; ?>" aria-expanded="false" class="dropdown-toggle">
                    <div class="">                                
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-down-left"><polyline points="9 10 4 15 9 20"></polyline><path d="M20 4v7a4 4 0 0 1-4 4H4"></path></svg>
                        <span>Leave</span>
                    </div>
                </a>                        
            </li>
        </br>

           

            <li class="menu">
                <center><h6 style="color: lightgray">General</h6></center></p>
                <a href="../settings.php?id=<?php echo $id; ?>" aria-expanded="false" class="dropdown-toggle">
                    <div class="">                                
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span>Settings</span>
                    </div>
                </a>                        
            </li>

            <li class="menu">
                <a href="../licenses.php?id=<?php echo $id; ?>" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-right"><line x1="21" y1="10" x2="7" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="21" y1="18" x2="7" y2="18"></line></svg>
                        <span>Licenses</span>
                    </div>
                </a>                        
            </li>

            <li class="menu">
                <a href="../users.php?id=<?php echo $id; ?>"  aria-expanded="false" class="dropdown-toggle">
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
                <!--<a href="../files.php?id=<?php echo $id; ?>" aria-expanded="false" class="dropdown-toggle">                            
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                        <span>File Upload</span>
                    </div>
                </a>  -->                    
                <a href="../variables.php?id=<?php echo $id; ?>" data-active="true" aria-expanded="false" class="dropdown-toggle">                            
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

            $username = xss_clean(mysqli_real_escape_string($con, $_SESSION['username']));
            $result = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));
            $ban_check = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username' AND `isbanned` = '1'") or die(mysqli_error($con));

            if (mysqli_num_rows($ban_check) >= 1)
            {
                echo "<meta http-equiv='Refresh' Content='0; url=../../../account/banned/'>";    
                exit();
            }

            while ($row = mysqli_fetch_array($result))
            {
                $isbanned = $row['banned'];
                $app_key = $row['authtoken'];
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
                    
                echo "<meta http-equiv='Refresh' Content='3; url=../../app.php'>";    
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

                echo "<meta http-equiv='Refresh' Content='3; url=../../app.php'>";    
                die();
            }

            $var_exist = mysqli_query($con, "SELECT * FROM `vars` WHERE `id` = '$client' AND `programtoken` = '$app_key' AND `owner` = '$username'") or die(mysqli_error($con));

            if (mysqli_num_rows($var_exist) <= 0)
            {
                
                echo '
                    <script type=\'text/javascript\'>
                                                
                    const notyf = new Notyf();
                    notyf
                    .error({
                        message: \'Attempting to edit invalid variable!\',
                        duration: 3500,
                        dismissible: true
                    });                
                                            
                    </script>
                ';

                echo "<meta http-equiv='Refresh' Content='3; url=../../app.php'>";    
                die();
            }
            else
            {
                while ($row = mysqli_fetch_array($var_exist))
                {
                    $var_value = $row['value'];
                    $var_name = $row['name'];
                }
            }
        ?>


        <?php

            if (isset($_POST['var_value_update']))
            {
                $variable_value = xss_clean(mysqli_real_escape_string($con, $_POST['variable_value']));

                if (!empty($variable_value))
                {
                    $sending_variable = mysqli_query($con, "UPDATE `vars` SET `value` = '$variable_value' WHERE `programtoken` = '$app_key' AND `id` = '$client' AND `owner` = '$username'") or die(mysqli_error($con));

                    if ($sending_variable)
                    {
                        echo '
                            <script type=\'text/javascript\'>
                                                        
                            const notyf = new Notyf();
                            notyf
                            .success({
                                message: \'Successfully updated variable!\',
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
                            message: \'You must enter a variable value!\',
                            duration: 3500,
                            dismissible: true
                        });                
                                                    
                        </script>
                    ';
                        
                }
            }

        ?>


        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                
                <div class="row layout-top-spacing">
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">

                                    

                            <?php

                                $username = xss_clean(mysqli_real_escape_string($con, $_SESSION['username']));
                                $id = xss_clean(mysqli_real_escape_string($con, $_GET['id']));

                                $searching_pr = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));
                                
                                while ($row = mysqli_fetch_array($searching_pr))
                                {
                                    $app_key = $row['authtoken'];
                                }

                                $grab_variables = mysqli_query($con, "SELECT * FROM `vars` WHERE `programtoken` = '$app_key' AND `id` = '$client'") or die(mysqli_error($con));

                                while ($row = mysqli_fetch_array($grab_variables))
                                {                                    
                                    {
                                    echo '
                                    <form method="POST" action="">
                                    <div class="table-responsive mb-4 mt-4">         
                                    <h5>Variable name</h5>
                                    <input type="text" id="variable_name" class="form-control" name="variable_name" value="'.$row['name'].'" disabled>
                                    <br>                
                                    <h5>New variable value</h5>
                                    <input type="text" id="variable_value" class="form-control" name="variable_value" placeholder="'.$row['value'].'">
                                    <br>
                                    <button name="var_value_update" class="btn btn-primary mb-2" type="submit" id="submit">Update</button>
                                    </form>
                                    '
                                    ;
                                    }
                                }
                                


                            ?>


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

    </div>

    
    
    

    <script src="../../../assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="../../../bootstrap/js/popper.min.js"></script>
    <script src="../../../bootstrap/js/bootstrap.min.js"></script>
    <script src="../../../plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../../../assets/js/app.js"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="../../../assets/js/custom.js"></script>



    <script src="../../../plugins/table/datatable/datatables.js"></script>
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