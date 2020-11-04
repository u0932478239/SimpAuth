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
// Check ban user

    $ban_check = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username' AND `isbanned` = '1'") or die(mysqli_error($con));

    if (mysqli_num_rows($ban_check) >= 1)
    {
        session_destroy();
        echo "<meta http-equiv='Refresh' Content='0; url=banned/'>";         
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
    <link rel="icon" type="image/x-icon" href="https://simpauth.xyz/favcon.png"/>

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/plugins.css" rel="stylesheet" type="text/css" />



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>


    <link rel="stylesheet" type="text/css" href="../plugins/dropify/dropify.min.css">
    <link href="../assets/css/users/account-setting.css" rel="stylesheet" type="text/css" />

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
    <!--  END NAVBAR  -->

    <!--  BEGIN NAVBAR  -->
    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

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


                    
                    <a href="../dashboard/index.php" aria-expanded="false" class="dropdown-toggle">
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
                    <a href="#" data-active="true" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
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
                        <a href="https://docs.simpauth.xyz" target="_blank" aria-expanded="false" class="dropdown-toggle">
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

    if (isset($_POST['savenewpassword']))
    {
        
        $username = xss_clean(mysqli_real_escape_string($con, $_SESSION['username']));
        $currentpass = xss_clean(mysqli_real_escape_string($con, $_POST['currentpass']));
        $newpassword = xss_clean(mysqli_real_escape_string($con, $_POST['newpassword']));
        $confirmnewpass = xss_clean(mysqli_real_escape_string($con, $_POST['repeatpassword']));


        if ($newpassword != $confirmnewpass)
        {
            
            
            echo '
                <script type=\'text/javascript\'>
                    
                const notyf = new Notyf();
                notyf
                .error({
                    message: \'New passwords do not match!\',
                    duration: 3500,
                    dismissible: true
                });                
                    
            </script>
            ';            
            

        }
        else
        {
            $result = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username'") or die(mysqli_error($con));

            while ($row = mysqli_fetch_array($result))
            {
                $pass = $row['password'];
                $email = $row['email'];                
            }

            if (password_verify($currentpass, $pass))
            {
                if (strlen($newpassword) <= 6)
                {
                    
                    echo '
                        <script type=\'text/javascript\'>
                            
                        const notyf = new Notyf();
                        notyf
                        .error({
                            message: \'The password must contain more than 6 characters!\',
                            duration: 3500,
                            dismissible: true
                        });                
                            
                    </script>
                    ';            
            

                      return;
                }
                else
                {
                    $pass_encrypted = password_hash($newpassword, PASSWORD_BCRYPT);
                    $update = mysqli_query($con, "UPDATE `owners` SET `password` = '$pass_encrypted' WHERE `username` = '$username'") or die(mysqli_error($con));
                        echo '
                            <script type=\'text/javascript\'>
                                
                            const notyf = new Notyf();
                            notyf
                            .success({
                                message: \'Password successfully updated!, please log in again.\',
                                duration: 3500,
                                dismissible: true
                            });                
                                
                        </script>
                        ';            
                     
                        echo '<META HTTP-EQUIV="Refresh" Content="2; URL=../account/logout.php">';       
                        die();
                }
            }
            else
            {
                
                echo '
                    <script type=\'text/javascript\'>
                                
                    const notyf = new Notyf();
                    notyf
                    .error({
                        message: \'Current password doesn`t match!\',
                        duration: 3500,
                        dismissible: true
                    });                
                                
                </script>
                ';                            
                

            }
        }

        function get_client_ip() {
             $ipaddress = '';
             if (getenv('HTTP_CLIENT_IP'))
                 $ipaddress = getenv('HTTP_CLIENT_IP');
             else if(getenv('HTTP_X_FORWARDED_FOR'))
             $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
             else if(getenv('HTTP_X_FORWARDED'))
                 $ipaddress = getenv('HTTP_X_FORWARDED');
            else if(getenv('HTTP_FORWARDED_FOR'))
                 $ipaddress = getenv('HTTP_FORWARDED_FOR');
             else if(getenv('HTTP_FORWARDED'))
                $ipaddress = getenv('HTTP_FORWARDED');
             else if(getenv('REMOTE_ADDR'))
                 $ipaddress = getenv('REMOTE_ADDR');
             else
                 $ipaddress = 'UNKNOWN';
             return $ipaddress;
         }
    }
    ?>



                    
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





                                <?php

                                    if (isset($_POST['create_api_key']))
                                    {                                        
                                        $username = xss_clean(mysqli_real_escape_string($con, $_SESSION['username']));

                                        $key = gen_key();

                                        $result_api_key = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username' AND `email` = '$email'") or die(mysqli_error($con));
                                        
                                        if (mysqli_num_rows($result_api_key) > 0)
                                        {
                                            while ($row = mysqli_fetch_array($result_api_key))
                                            {
                                                $api_key = $row['api_key'];
                                            }

                                            $update_api_key = mysqli_query($con, "UPDATE `owners` SET `api_key` = '$key' WHERE `username` = '$username'") or die(mysqli_error($con));

                                            if ($update_api_key)
                                            {
                                                
                                                
                                                echo '
                                                    <script type=\'text/javascript\'>
                                                                
                                                    const notyf = new Notyf();
                                                    notyf
                                                    .success({
                                                        message: \'Successfully generated a new api key!\',
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
                                                        message: \'Failed to generate secret key!\',
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


                                    function gen_key()
                                    {
                                        for ($i = 0; $i < 1; $i++)
                                        {
                                            $random_string = "";
                                            $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                            $chars_lenght = strlen($chars);
    
                                            for ($i = 0; $i < 25; $i++)
                                            {
                                                $random_string .= $chars[rand(0, $chars_lenght - 1)];
                                            }
                                            return $random_string;
                                        }
                                    }
                                ?>



        <div id="content" class="main-content">
            <div class="layout-px-spacing">                
                    
                <div class="account-settings-container layout-top-spacing">

                    <div class="account-content">
                        <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <div  class="section general-info">
                                        <div class="info">
                                            <h6 class="">General Information</h6>
                                            <div class="row">
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                        <div class="col-xl-2 col-lg-12 col-md-4">
                                                            <div class="upload mt-4 pr-md-4">
                                                                <input type="file" id="input-file-max-fs" class="dropify" data-default-file="../assets/img/profile-16.jpg" data-max-file-size="2M" disabled/>
                                                                <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Profile Picture</p>
								<h9>(Under Development)</h9>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        
                                                                        
                                                                                                                                           
                                                                    
                                                                        
                                                                        <div class="form-group">
                                                                            <label for="fullName">Username</label>
                                                                            <input type="text" class="form-control mb-4" value="<?php echo $username; ?>" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="profession">Email</label>
                                                                            <input type="text" class="form-control mb-4" value="<?php echo $email; ?>" disabled>
                                                                        </div>                                                                                                                                            
                                                                    <div class="form-group">
                                                                        <label for="profession">API Key</label>

                                                                        <?php

                                                                            $id = xss_clean(mysqli_real_escape_string($con, $_GET['id']));
                                                                            $username = xss_clean(mysqli_real_escape_string($con, $_SESSION['username']));

                                                                            $result = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username' AND `email` = '$email'") or die(mysqli_error($con));

                                                                            if (mysqli_num_rows($result) > 0)
                                                                            {
                                                                                while ($row = mysqli_fetch_array($result))
                                                                                {
                                                                                    $api_key = $row['api_key'];
                                                                                    $subscription = $row['premium'];
                                                                                }
                                                                            }



                                                                        ?>


                                                                        <input type="text" class="form-control mb-4" value="<?php echo ($subscription == "1" ? $api_key : "You can't get the API key without a premium subscription!"); ?>" disabled>
                                                                        <form method="POST" action="">
                                                                            <button name="create_api_key" class="btn btn-primary">Generate new API key</button>
                                                                        </form>
                                                                        </br>
                                                                        <?php
                                                                        $two_fac = false;
                                                                        ?>
                                                                        
                                                                    
                                                                       <?php

                                                                    require_once '../account/googleLib/GoogleAuthenticator.php';
                                                                    $gauth = new GoogleAuthenticator();
                                                                    
                                                                    function generateRandomStrings($length = 15) {
                                                                        return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
                                                                    }
                                                                    
                                                                    if (isset($_POST['twofactor_option']))
                                                                    {
                                                                        $two_fac = true;
                                                                        Option();
                                                                    }
                                                                    
                                                                    $code_to;
                                                                    
                                                                    if (isset($_POST['method_2factor']))
                                                                    {
                                                                        $two_fac = true;
                                                                        

                                                                        $code_2factor = $gauth->createSecret();
                                                                        $integrate_code = mysqli_query($con, "UPDATE `owners` SET `googleAuthCode` = '$code_2factor' WHERE `username` = '$username' AND `email` = '$email'") or die(mysqli_error($con));
                                                                    
                                                                        
                                                                        $integrate_code = true;
                                                                        if ($integrate_code)
                                                                        {
                                                                            $user_result = mysqli_query($con, "SELECT * from `owners` WHERE `username` = '$username' AND `email` = '$email'") or die(mysqli_error($con));
                                                                            while ($row = mysqli_fetch_array($user_result))
                                                                            {
                                                                                $secret_code = $row['googleAuthCode'];
                                                                                $code_to = $secret_code;
                                                                            }
                                                                            
                                            
                                                                            $google_QR_Code = $gauth->getQRCodeGoogleUrl($email, $secret_code, 'Akiza');
                                                                            
                                                                            echo '
                                                                            </br>
                                                                            </br>
                                                                            <form method="POST" action="">
                                                                            <div class="row">
                                                                            <div class="form-group">
                                                                            <label>Scan this QR code into your smartphone. </br>We recommend using the Authy application.</label>
                                                                            <img src="'.$google_QR_Code.'" />
                                                                            </br>
                                                                            </br>
                                                                            <label>Set it manually, code: '.$secret_code.'</label>
                                                                            <input type="text" name="scan_code" id="scan_code" class="form-control mb-4" required>
                                                                            <button type="submit" class="btn btn-primary" name="submit_code" id="submit_code">Submit</button>
                                                                            </div>
                                                                            </div>
                                                                            </form>
                                                                            ';                                                                            
                                                                        }
                                                                    }
                                                                    
                                                                    
                                                                    if (isset($_POST['submit_code']))
                                                                        {
                                                                            if (empty($_POST['scan_code']))
                                                                            {
                                                                                
                                                                                
                                                                                echo '
                                                                                    <script type=\'text/javascript\'>
                                                                                                    
                                                                                    const notyf = new Notyf();
                                                                                    notyf
                                                                                    .error({
                                                                                        message: \'You must fill in all the fields!\',
                                                                                        duration: 3500,
                                                                                        dismissible: true
                                                                                    });                
                                                                                                    
                                                                                </script>
                                                                                ';          
                                            
                                            
                                                                            }
                                                                            
                                                                            $code = $_POST['scan_code'];
                                                                            
                                                                            $user_result = mysqli_query($con, "SELECT * from `owners` WHERE `username` = '$username' AND `email` = '$email'") or die(mysqli_error($con));
                                                                            while ($row = mysqli_fetch_array($user_result))
                                                                            {
                                                                                $secret_code = $row['googleAuthCode'];
                                                                            }
                                                                            
                                                                            $checkResult = $gauth->verifyCode($secret_code, $code, 2);
                                                                            
                                                                            if ($checkResult)
                                                                            {
                                                                                
                                                                                $enable_2factor = mysqli_query($con, "UPDATE `owners` SET `twofactor` = '1' WHERE `username` = '$username' AND `email` = '$email'") or die(mysqli_error($con));
                                                                                
                                                                                if ($enable_2factor)
                                                                                {          

                                                                                    echo '
                                                                                        <script type=\'text/javascript\'>
                                                                                                        
                                                                                        const notyf = new Notyf();
                                                                                        notyf
                                                                                        .success({
                                                                                            message: \'Two-factor security has been successfully activated on your account!\',
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
                                                                                            message: \'There was a problem trying to activate security on your account!\',
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
                                                                                        message: \'The code entered is incorrect\',
                                                                                        duration: 3500,
                                                                                        dismissible: true
                                                                                    });                
                                                                                                        
                                                                                </script>
                                                                                ';                      
                                                                                    
                                                                            }
                                                                            
                                                                        }
                                                                    
                                                                    function Option()
                                                                    {
                                                                    echo '
                                                                     </div>
                                                                         <form method="POST" action="">
                                                                            <label>Select Two-Factor Authentication Provider</label>
                                                                                <div id="select_menu" class="form-group mb-4">
                                                                                    <select class="custom-select" name="option_freemode">
                                                                                        <option value="0">Authenticator</option>
                                                                                        <option value="1" disabled>Email</option>
                                                                                    </select>
                                                                                </div>
                                                                                <button class="btn btn-primary" name="method_2factor">Select</button>
                                                                            </form>
                                                                        ';
                                                                    
                                                                        
                                                                    }
                                                                    
                                                                    ?> 
                                                                        
                                                            
                                                                        <?php

                                                                        if (isset($_POST['disable_two_factor']))
                                                                        {
                                                                            $disable_2factor = mysqli_query($con, "UPDATE `owners` SET `twofactor` = '0' WHERE `username` = '$username' AND `email` = '$email'") or die(mysqli_error($con));                                                                            

                                                                            if ($disable_2factor)
                                                                            {
                                                                                
                                                                                echo '
                                                                                    <script type=\'text/javascript\'>
                                                                                                        
                                                                                    const notyf = new Notyf();
                                                                                    notyf
                                                                                    .success({
                                                                                        message: \'You have successfully disabled the two-factor (2FA) security of your account\',
                                                                                        duration: 3500,
                                                                                        dismissible: true
                                                                                    });                
                                                                                                        
                                                                                </script>
                                                                                ';           
                                                                                
                                                                            }
                                                                        }
                                                                            
                                                                        ?>
                                                                    
                                                                        
                                                                        
                                                                        <?php
                                                                        
                                                                        
                                                                        
                                                                        $user_result = mysqli_query($con, "SELECT * from `owners` WHERE `username` = '$username' AND `email` = '$email'") or die(mysqli_error($con));
                                                                        while ($_row = mysqli_fetch_array($user_result))
                                                                        {
                                                                            $two_factor_enabled = $_row['twofactor'];
                                                                        }
                                                                        
                                                                        if ($two_factor_enabled == "1")
                                                                        {
                                                                            
                                                                            echo '
                                                                            <form method="POST">
                                                                                <button class="btn btn-warning mb-2" name="disable_two_factor"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                                                                    Disable two-factor security on your account
                                                                                </button>
                                                                            </form>
                                                                            ';
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                            if ($two_fac == false)
                                                                            {
                                                                                echo '                                                              
                                                                                ';                                                                                
                                                                            }
                                                                            
                                                                        }
                                                                    ?>
                                                                        
                                                                    
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        </br>
                                                                    </div>
                                                                    
                                                                    
                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>





                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form class="section contact" method="POST" action="">
                                        <div class="info">
                                            <h5 class="">Change password</h5>
                                            <div class="row">
                                                <div class="col-md-11 mx-auto">
                                                    <div class="row">                                                    
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="address">Current password</label>
                                                                <input type="password" class="form-control mb-4" id="currentpass" name="currentpass" placeholder="Current password" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="email">New password</label>
                                                                <input type="password" class="form-control mb-4" id="newpassword" name="newpassword" placeholder="New password">
                                                            </div>
                                                        </div>       
                                                    </div>           
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="website1">Repeat password</label>
                                                                <input type="password" class="form-control mb-4" id="repeatpassword" name="repeatpassword" placeholder="Repeat new password">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" name="savenewpassword" id="savenewpassword" class="btn btn-primary">Save Changes</button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="social" class="section social">
                                        <div class="info">
                                            <h5 class="">Link your discord account!</h5>
                                            <div class="row">

                                                <div class="col-md-11 mx-auto">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group social-linkedin mb-3">
                                                                <div class="input-group-prepend mr-3">
                                                                    <span class="input-group-text" id="linkedin">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-hash"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><line x1="10" y1="3" x2="8" y2="21"></line><line x1="16" y1="3" x2="14" y2="21"></line></svg>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control" placeholder="linkedin Username" aria-label="Username" aria-describedby="discord" value="In development" disabled>                                                                
                                                            </div>
                                                        </div>                                                     
                                                    </div>
                                                    <br>
                                                    <button  class="btn btn-primary" disabled>Save Changes</button>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </form>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                </div>                                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php

        function xss_clean($data)
        {
            return strip_tags($data);
        }
    ?>

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




    <script src="../plugins/dropify/dropify.min.js"></script>
    <script src="../plugins/blockui/jquery.blockUI.min.js"></script>

    <script src="../assets/js/users/account-settings.js"></script>

</body>


</html>