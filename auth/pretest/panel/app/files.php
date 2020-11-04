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

<!DOCTYPE html>
<html lang="en">

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

<head>
    <title>Akiza | Server side files  </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">    
    <link rel="shortcut icon" href="../../dashboard/dist/images/akicon.ico" />

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/plugins.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    
    <link href="../../plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
    <script src="../../plugins/file-upload/file-upload-with-preview.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="../../plugins/table/datatable/dt-global_style.css">

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
                <a href="licenses.php?id=<?php echo $id; ?>" aria-expanded="false" class="dropdown-toggle">
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
                <a href="#" data-active="true" aria-expanded="false" class="dropdown-toggle">                            
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                        <span>File upload</span>
                    </div>
                </a>                      
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


    if (isset($_POST['file_delete']))
    {
        $file_code = xss_clean(mysqli_real_escape_string($con, $_POST['file_code']));
        $file_name = xss_clean(mysqli_real_escape_string($con, $_POST['file_name']));
        $file_save_code = xss_clean(mysqli_real_escape_string($con, $_POST['file_save_code']));
        
        $var_exist = mysqli_query($con, "SELECT * FROM `files` WHERE `filename` = '$file_name' AND `code` = '$file_code' AND `save_code` = '$file_save_code'") or die(mysqli_error($con));
        if (mysqli_num_rows($var_exist) == 0)
        {
            
            echo '
                <script type=\'text/javascript\'>
                                        
                const notyf = new Notyf();
                notyf
                .error({
                    message: \'File doesnt exist!\',
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
                while ($row = mysqli_fetch_array($result))
                {
                    $app_key = $row['authtoken'];
                }

                
                $file_del = mysqli_query($con, "DELETE FROM `files` WHERE `filename` = '$file_name' AND `code` = '$file_code' AND `programtoken` = '$app_key'") or die(mysqli_error($con));
                if ($file_del)
                {
                    unlink("uploads/" . $file_save_code . "_" . $file_name);
                    
                    echo '
                        <script type=\'text/javascript\'>
                                                
                        const notyf = new Notyf();
                        notyf
                        .success({
                            message: \'Successfully deleted file!\',
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
                            message: \'Failed to delete the file!\',
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
                        message: \'Program doesnt exist!\',
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
                    <h5>Secure file download</h5>
                    <?php

                    if (isset($_POST['upload_file']))
                    {
                        $target_dir = "uploads/";
                        $target_filename = $_FILES['file_to']["name"];
                        $target_size = $_FILES['file_to']["size"];
                        $target_file = $target_dir . basename($_FILES["file_to"]["name"]);
                        $upload_ok = 1;
                        $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                        
                        if (empty($target_filename))
                        {
                            echo '
                                <script type=\'text/javascript\'>
                                                                    
                                const notyf = new Notyf();
                                notyf
                                .error({
                                    message: \'You must upload something before you hit the upload button!\',
                                    duration: 3500,
                                    dismissible: true
                                });                
                                                                    
                                </script>
                            ';           
                            
                            $upload_ok = 0;
                        }
                        
                        if ($extension == "php" || $extension == "py" || $extension == "exe")
                        {
                            echo '
                                <script type=\'text/javascript\'>
                                                                    
                                const notyf = new Notyf();
                                notyf
                                .error({
                                    message: \'File not allowed to upload!\',
                                    duration: 3500,
                                    dismissible: true
                                });                
                                                                    
                                </script>
                            ';        
                            
                            $upload_ok = 0;
                        }
                        else if ($target_size > 1000000)
                        {
                            echo '
                                <script type=\'text/javascript\'>
                                                                    
                                const notyf = new Notyf();
                                notyf
                                .error({
                                    message: \'Sorry, the maximum amount to upload is 1MB!\',
                                    duration: 3500,
                                    dismissible: true
                                });                
                                                                    
                                </script>
                            ';        
                            
                            $upload_ok = 0;
                        }
                        else
                        {
                            
                            $result = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));
                            if (mysqli_num_rows($result) > 0)
                            {
                                while ($row = mysqli_fetch_array($result))
                                {
                                    $app_key = $row['authtoken'];
                                }
                                
                                $checking_uploads = mysqli_query($con, "SELECT * FROM `files` WHERE `owner` = '$username' AND `programtoken` = '$app_key'") or die(mysqli_error($con));
                                
                                $grabinfo = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username'") or die(mysqli_error($con));
                        
                                while ($row = mysqli_fetch_array($grabinfo))
                                {
                                    $subscription = $row['premium'];            
                                }
                                
                                if ($subscription == 0)
                                {
                                    if (mysqli_num_rows($checking_uploads) > 2)
                                    {
                                        echo '
                                            <script type=\'text/javascript\'>
                                                                                
                                            const notyf = new Notyf();
                                            notyf
                                            .error({
                                                message: \'Sorry, the maximum you can upload is 3 files!, buy subscription to remove the limit.\',
                                                duration: 3500,
                                                dismissible: true
                                            });                
                                                                                
                                            </script>
                                        ';            
                                        
                                        $upload_ok = 0;
                                    }                                    
                                }
                                
                                
                            }
                            else
                            {
                                echo '
                                    <script type=\'text/javascript\'>
                                                                    
                                    const notyf = new Notyf();
                                    notyf
                                    .error({
                                        message: \'Program doesnt exist!\',
                                        duration: 3500,
                                        dismissible: true
                                    });                
                                                                        
                                    </script>
                                ';           
                                
                                $upload_ok = 0;
                            }                            
                            
                            
                            
                            
                            if ($upload_ok == 1)
                            {
                                $code = generateToken();
                                $save_code = saveCode();
                                
                                $insert_file = mysqli_query($con, "INSERT INTO `files` (filename, extension, code, save_code, programtoken, owner) VALUES ('$target_filename', '$extension', '$code', '$save_code', '$app_key', '$username')") or die(mysqli_error($con));                            
                                
                                $to_save = $save_code . "_" . $target_filename;
                
                                if ($insert_file)
                                {
                                    move_uploaded_file($_FILES["file_to"]["tmp_name"], "uploads/" . $to_save);   
                                    echo '
                                        <script type=\'text/javascript\'>
                                                                            
                                        const notyf = new Notyf();
                                        notyf
                                        .success({
                                            message: \'File uploaded successfully!\',
                                            duration: 3500,
                                            dismissible: true
                                        });                
                                                                            
                                        </script>
                                    ';                                            
                                }
                                
                            }
                        }
                    }
                    
                    function saveCode()
                    {
                        for ($i = 0; $i < 1; $i++)
                        {
                            $random_string = "";
                            $chars = '0123456789ABCDEFGabcdefg';
                            $chars_lenght = strlen($chars);

                            for ($i = 0; $i < 5; $i++)
                            {
                                $random_string .= $chars[rand(0, $chars_lenght - 1)];
                            }

                            return $random_string;
                        }
                    }

                    function generateToken()
                    {
                        for ($i = 0; $i < 1; $i++)
                        {
                            $random_string = "";
                            $chars = '0123456789ABCDEFGabcdefg';
                            $chars_lenght = strlen($chars);

                            for ($i = 0; $i < 35; $i++)
                            {
                                $random_string .= $chars[rand(0, $chars_lenght - 1)];
                            }

                            return $random_string;
                        }
                    }

                    ?>


                        <div class="widget-content widget-content-area br-6">
                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="custom-file-container" data-upload-id="myFirstImage">
                                    <label>Upload (Single File) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                        <label>
                                            <input type="file" name="file_to" id="file_to" accept="*" class="form-control custom-file-container__custom-file__custom-file-control">
                                        </label>
                                    </div>
                                    </br>
                                    <p><p>
                                    <button name="upload_file" class="btn btn-outline-info mb-2">Upload</button>
                            </form>
                            
                            
                            <div class="table-responsive mb-4 mt-4">         

                                <table id="zero-config" class="table table-hover" style="width:100%">
                                    <thead>

                                        <tr>
                                            <th>Secret code</th>
                                            <th>File name</th>
                                            <th>Extension</th>
                                            <th>Storage ID</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                            $id = xss_clean(mysqli_real_escape_string($con, $_GET['id']));

                                            $result = mysqli_query($con, "SELECT * FROM `programs` WHERE `owner` = '$username' AND `id` = '$id'") or die(mysqli_error($con));

                                            while ($row = mysqli_fetch_array($result))
                                            {
                                                $app_key = $row['authtoken'];
                                            }

                                            $grab_files = mysqli_query($con, "SELECT * FROM `files` WHERE `owner` = '$username' AND `programtoken` = '$app_key'") or die(mysqli_error($con));

                                            while ($row = mysqli_fetch_array($grab_files))
                                            {
                                                $var_id = $row['id'];

                                                echo '
                                                
                                                    <tr>    
                                                        <td>'.xss_clean($row['code']).'</td>
                                                        <td>'.xss_clean($row['filename']).'</td>
                                                        <td>'.xss_clean($row['extension']).'</td>
                                                        <td>'.xss_clean($row['save_code']).'</td>
                                                        <form method="POST" action="">
                                                        <input type="hidden" name="file_code" value="'.xss_clean($row['code']).'">
                                                        <input type="hidden" name="file_name" value="'.xss_clean($row['filename']).'">
                                                        <input type="hidden" name="file_save_code" value="'.xss_clean($row['save_code']).'">
                                                        
                                                        <td>   
                                                            <div class="icon-container">
                                                                <button name="file_delete" style="border: none; background: none; color: lightgray">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg><span class="icon-name"></span>                                                            
                                                                </button>
                                                            </div>                                                    
                                                        </td>
                                                        </form>
                                                    </tr>                                                
                                                                                           
                                            ';
                                            }

                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Value</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
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