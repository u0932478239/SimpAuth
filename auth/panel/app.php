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


<?php 

    $ban_check = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username' AND `isbanned` = '1'") or die(mysqli_error($con));

    if (mysqli_num_rows($ban_check) >= 1)
    {
        echo "<meta http-equiv='Refresh' Content='0; url=../account/banned/'>";    
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


    <link href="../https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/plugins.css" rel="stylesheet" type="text/css" />

    
    <link href="../assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/animate/animate.css" rel="stylesheet" type="text/css" />



    <link rel="stylesheet" type="text/css" href="../plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="../plugins/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="../plugins/table/datatable/custom_dt_multiple_tables.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <link href="../plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    <script src="../plugins/sweetalerts/promise-polyfill.js"></script>
</head>
<body>
    
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
                        <a href="../dashboard/index.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Dashboard</span>
                            </div>
                        </a>
                    </li>



                   

                    <li class="menu">
                        <a href="#" data-toggle="collapse" data-active="true" aria-expanded="true" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                                <span>Applications</span>
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
                        <a href="../dashboard/download.php" aria-expanded="false" class="dropdown-toggle">                            
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                <span>Downloads</span>
                            </div>                            
                        </a>                        
                    </li>
                    
                    <li class="menu">
                        <a href="https://docs.simpauth.xyz/" target="_blank" aria-expanded="false" class="dropdown-toggle">
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

        <!--  BEGIN CONTENT AREA  -->

        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        
        <?php

            if (isset($_POST['pauseprogram']))
            {

                $secret = xss_clean(mysqli_real_escape_string($con, $_POST['secret']));
                $name = xss_clean(mysqli_real_escape_string($con, $_POST['name']));

                $epicc = mysqli_query($con, "SELECT * FROM `programs` WHERE `name` = '$name' AND `id` = '$secret' AND owner = '$username'") or die(mysqli_error($con));
                
                if (mysqli_num_rows($epicc) < 1)
                {
                    echo '
                    <script type=\'text/javascript\'>
                    
                    const notyf = new Notyf();
                    notyf
                      .error({
                        message: \'Invalid ID Program!\',
                        duration: 3500,
                        dismissible: true
                      });                
                    
                    </script>
                    ';                    
                
                }
                else
                {
                    $pauseprogram = mysqli_query($con, "UPDATE `programs` SET `enabled` = '0' WHERE `programs`.`id` = '$secret'") or die(mysqli_error($con));

                    if ($pauseprogram)
                    {
                        echo '
                        <script type=\'text/javascript\'>
                        
                        const notyf = new Notyf();
                        notyf
                          .success({
                            message: \'Successfully paused program!\',
                            duration: 3500,
                            dismissible: true
                          });                
                        
                        </script>
                        ';                    
                
                    }
                }
            }

            if (isset($_POST['resumeprogram']))
            {

                $secret = xss_clean(mysqli_real_escape_string($con, $_POST['secret']));
                $name = xss_clean(mysqli_real_escape_string($con, $_POST['name']));


                $epicc = mysqli_query($con, "SELECT * FROM `programs` WHERE `name` = '$name' AND `id` = '$secret' AND owner = '$username'") or die(mysqli_error($con));
                
                if (mysqli_num_rows($epicc) < 1)
                {
                    
                    echo '
                    <script type=\'text/javascript\'>
                    
                    const notyf = new Notyf();
                    notyf
                      .error({
                        message: \'Invalid ID Program!\',
                        duration: 3500,
                        dismissible: true
                      });                
                    
                    </script>
                    ';               
                }
                else
                {
                    $pauseprogram = mysqli_query($con, "UPDATE `programs` SET `enabled` = '1' WHERE `programs`.`id` = '$secret'") or die(mysqli_error($con));

                    echo '
                    <script type=\'text/javascript\'>
                    
                    const notyf = new Notyf();
                    notyf
                      .success({
                        message: \'Successfully resumed program!\',
                        duration: 3500,
                        dismissible: true
                      });                
                    
                    </script>
                    ';               
                    
                }
            }

            if (isset($_POST['deleteprogram']))
            {
                $secret = xss_clean(mysqli_real_escape_string($con, $_POST['secret']));
                $name = xss_clean(mysqli_real_escape_string($con, $_POST['name']));

                $epicc = mysqli_query($con, "SELECT * FROM `programs` WHERE `name` = '$name' AND `id` = '$secret' AND owner = '$username'") or die(mysqli_error($con));

                if (mysqli_num_rows($epicc) < 1)
                {
                    
                    echo '
                    <script type=\'text/javascript\'>
                    
                    const notyf = new Notyf();
                    notyf
                      .error({
                        message: \'Invalid ID Program!\',
                        duration: 3500,
                        dismissible: true
                      });                
                    
                    </script>
                    ';               
                    
                }
                else
                {
                    $grabprograms = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$username'") or die(mysqli_error($con));

                    while ($row = mysqli_fetch_array($grabprograms))
                    {
                        $programtoken = $row['authtoken'];
                    }

                    $cleantoken = mysqli_query($con, "DELETE FROM `tokens` WHERE `owner` = '$username' AND `programtoken` = '$programtoken'") or die(mysqli_error($con));


                    if ($cleantoken)
                    {
                        $querydel = mysqli_query($con, "DELETE FROM `programs` WHERE `name` = '$name' AND `id` = '$secret'");

                        if ($querydel)
                        {
                            
                            echo '
                            <script type=\'text/javascript\'>
                            
                            const notyf = new Notyf();
                            notyf
                              .success({
                                message: \'Successfully deleted the program!\',
                                duration: 3500,
                                dismissible: true
                              });                
                            
                            </script>
                            ';               
                        }
                    }
                }

            }


            if (isset($_POST['createapplication']))
            {
                function GenerateAuthToken() {
                    for($i = 0; $i < 1; $i++) {
                      $randomString = "";
                      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                      $charactersLength = strlen($characters);
                      for ($i = 0; $i < 45; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                      }
                      return $randomString;
                    }
                  }
                  function GenerateEncKey() {
                    for($i = 0; $i < 1; $i++) {
                      $randomString = "";
                      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                      $charactersLength = strlen($characters);
                      for ($i = 0; $i < 32; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                      }
                      return $randomString;
                    }
                  }

                $auth_generated = GenerateAuthToken();
                $enckey = GenerateEncKey();
                $app_name = xss_clean(mysqli_real_escape_string($con, $_POST['program_name']));

                if (trim($app_name) == '' || strlen($app_name) <= 0)
                {
                    
                    echo '
                        <script type=\'text/javascript\'>
                            
                        const notyf = new Notyf();
                        notyf
                        .success({
                            message: \'Successfully deleted the program!\',
                            duration: 3500,
                            dismissible: true
                        });                
                            
                    </script>
                    ';               
                            
                }
                else
                {
                    $name_check = mysqli_query($con, "SELECT `name` FROM `programs` WHERE `name` = '$app_name'") or die(mysqli_error($con));
                    $do_name_check = mysqli_num_rows($name_check);
                    if ($do_name_check > 0)
                    {    
                        
                        echo '
                            <script type=\'text/javascript\'>
                                
                            const notyf = new Notyf();
                            notyf
                            .error({
                                message: \'Program name already taken!\',
                                duration: 3500,
                                dismissible: true
                            });                
                                
                        </script>
                        ';             
                    
                    }
                    else
                    {
                        $grabinfo = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username'") or die(mysqli_error($con));
                        while ($row = mysqli_fetch_array($grabinfo))
                        {
                            $subscription = $row['premium']; 
                        }

                        $count_check = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$username'") or die(mysqli_error($con));
                        $do_count_check = mysqli_num_rows($count_check);
                        $boolcheck = 1;

                        if ($subscription == "0") 
                        {
                            if ($do_count_check >= 1)
                            {
                                $boolcheck = 0;
                                
                                echo '
                                    <script type=\'text/javascript\'>
                                        
                                    const notyf = new Notyf();
                                    notyf
                                    .error({
                                        message: \'You cannot have more than 1 programs! Purchase premium to remove this limit.\',
                                        duration: 3500,
                                        dismissible: true
                                    });                
                                        
                                </script>
                                ';             
                        
                            }                            
                        }

                        if ($subscription == "1") 
                        {
                            if ($do_count_check >= 60)
                            {
                                $boolcheck = 0;
                                
                                echo '
                                    <script type=\'text/javascript\'>
                                        
                                    const notyf = new Notyf();
                                    notyf
                                    .error({
                                        message: \'You cannot have more than 60 programs!\',
                                        duration: 3500,
                                        dismissible: true
                                    });                
                                        
                                </script>
                                ';                                            
                                
                            }
                        }

                        if ($boolcheck == 1)
                        {
                            $querycreate = mysqli_query($con, "INSERT INTO `programs` (owner, name, authtoken, enckey, version, banned, clients) VALUES ('$username', '$app_name', '$auth_generated', '$enckey', 1.0, 0, 0)") or die(mysqli_error($con));
                            if ($querycreate)
                            {

                                echo '
                                    <script type=\'text/javascript\'>
                                        
                                    const notyf = new Notyf();
                                    notyf
                                    .success({
                                        message: \'Successfully program created!\',
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

        ?>

        <div id="content" class="main-content">
            <div class="layout-px-spacing">                
                <div class="row layout-top-spacing">                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                            <div class="table-responsive mb-4 mt-4">
                                <table class="multi-table table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Application Name</th>
                                            <th>Application Key</th>
                                            <th>Application Encryption Key</th>
                                            <th>Version</th>
                                            <th>Total Users</th>
                                            <th>Banned</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php

                                        function countAllUsersInProgram($programKey)
                                        {
                                            global $con;
                                            $programUsers = mysqli_query($con, "SELECT * FROM `users` WHERE `programtoken` = '$programKey'") or die(mysqli_error($con));

                                            $amount = mysqli_num_rows($programUsers);

                                            return $amount;
                                        }

                                        $kek = xss_clean(mysqli_real_escape_string($con, $_SESSION['username']));
                                        $grabprograms = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$kek'") or die(mysqli_error($con));

                                        while ($row = mysqli_fetch_array($grabprograms))
                                        {
                                            {
                                                echo '
                                                <tr>
                                                <form method="POST" action=""> 
                                                <input type="hidden" name="secret" value="'.$row['id'].'" />
                                                <input type="hidden" name="name" value="'.$row['name'].'" />   
                                                    <td>'.$row['id'].'</td>
                                                    <td>'.$row['name'].'</td>
                                                    <td>'.$row['authtoken'].'</td>
                                                    <td>'.$row['enckey'].'</td>
                                                    <td>'.$row['version'].'</td>
                                                    <td>'.countAllUsersInProgram($row['authtoken']).'</td>
                                                    '.($row['banned'] == "1" ? "<td><span class=\"badge badge-danger\"> Banned </span></td>" : "<td><span class=\"badge badge-success\"> Unbanned </span></td>").'
                                                    
                                                    <td>
                                                        '.($row['enabled'] == "1" ? "<div class=\"t-dot bg-success\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"\" data-original-title=\"Online\"></div>" : "<div class=\"t-dot bg-danger\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"\" data-original-title=\"Offline\"></div>").'
                                                    </td>


                                                    <td>                                                

                                                    <a href=\'app/settings.php?id='.$row['id'].'\'>
                                                        <div class="btn btn-outline-primary mb-2">                                                    
                                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                                            <!-- Panel --!>                                                   
                                                        </div>
                                                    </a>


                                                    '.($row['enabled'] == "0" ? 
                                                    "
                                                    <button id=\"submit\" name=\"resumeprogram\" type=\"submit\" class=\"btn btn-primary mb-2 mr-2\">
                                                    <svg viewBox=\"0 0 24 24\" width=\"24\" height=\"24\" stroke=\"currentColor\" stroke-width=\"2\" fill=\"none\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"css-i6dzq1\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polygon points=\"10 8 16 12 10 16 10 8\"></polygon></svg>
                                                    <!-- Resume --!>
                                                    </button>
                                                    " : "
                                                    <button id=\"submit\" name=\"pauseprogram\" type=\"submit\" class=\"btn btn-outline-warning mb-2\">
                                                    <svg viewBox=\"0 0 24 24\" width=\"24\" height=\"24\" stroke=\"currentColor\" stroke-width=\"2\" fill=\"none\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"css-i6dzq1\" style=\"color: #ff8d14\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><line x1=\"10\" y1=\"15\" x2=\"10\" y2=\"9\"></line><line x1=\"14\" y1=\"15\" x2=\"14\" y2=\"9\"></line></svg>
                                                    <!-- Pause --!>
                                                    </button>
                                                    ").'


                                                    <button class="btn btn-outline-danger mb-2" name="deleteprogram">
                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>                                                        
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
                                            <th>Application Name</th>
                                            <th>Application Key</th>
                                            <th>Application Encryption Key</th>
                                            <th>Version</th>
                                            <th>Total users</th>
                                            <th>Banned</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>                                                                
                            </div>                           
                        </br>       
                        </br>
                        </br>
                        </br>
                            <form method="POST" action="">
                                <tbody>
                                    <tr>
                                        <td>Application Name:</td><p><p>
                                        <td><input required type="text" id="text" class="form-control" name="program_name" ></td>
                                    </tr>                                    
                                    </br>                                
                                    <button id="submit" name="createapplication" class="btn btn-primary mb-2">Create new application</button>                                
                                </tbody>
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



    

    <script src="../plugins/table/datatable/datatables.js"></script>
    <script>
        $(document).ready(function() {
            $('table.multi-table').DataTable({
                "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                   "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [5, 10, 20, 50],
                "pageLength": 5,
                drawCallback: function () {
                    $('.t-dot').tooltip({ template: '<div class="tooltip status" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' })
                    $('.dataTables_wrapper table').removeClass('table-striped');
                }
            });
        } );
    </script>

</body>

</html>