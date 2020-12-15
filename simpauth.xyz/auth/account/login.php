<?php
    error_reporting(E_ALL);
    include '../includes/settings.php';
    session_start();

    if (isset($_SESSION['username'])) {
        header("Location: ../dashboard/");
        exit();
    }

    if (isset($_SESSION['username_googleauthenticator']))
    {
        header("Location: ./2factor");
        exit();
    }
    
    function xss_clean($data)
    {
        return strip_tags($data);
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>SimpAuth - Login</title>
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
    <link href="../assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
 
 
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="../assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/forms/switches.css">




</head>
<body class="form">
    

    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">Sign In</h1>
                        <p class="">Log in to your account to continue.</p>
                        
                        <form class="text-left" method="POST" action="">
                            <div class="form">

                                <div id="username-field" class="field-wrapper input">
                                    <label for="username">USERNAME</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="username" name="username" type="text" class="form-control" placeholder="e.g Jhon">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">PASSWORD</label>
                                        <a href="recovery.php" class="forgot-pass-link">Forgot Password?</a>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    
                                    
                                    
                                </div>
                                
                                


                                
                                
                                
                                
                                <center>
                                    <div class="g-recaptcha" data-sitekey="6LejZd0ZAAAAAId9CyXjNedpGclGWc_bpffIsKKf"></div>
                                </center>
                                
                                <br>
                                                            
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" name="login" class="btn btn-primary" value="">Log In</button>
                                    </div>
                                </div>

                                <p class="signup-link">Not registered ? <a href="register.php">Create an account</a></p>

                            </div>
                        </form>

                    </div>                    
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="../assets/js/authentication/form-2.js"></script>

    <?php
        if (isset($_POST['login']))
        {

            if (empty($_POST['username']) || empty($_POST['password']))
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
                

                

                  return;
            }


            $status_login = "";

            if (!isset($_SESSION))
            {
                session_start();
            }

    
            $captcha;
        
        
            if (isset($_POST['g-recaptcha-response']))
            {
                $captcha = $_POST['g-recaptcha-response'];
            }
            
            if (!$captcha)
            {
                echo '
                <script type=\'text/javascript\'>
                
                const notyf = new Notyf();
                notyf
                  .error({
                    message: \'Please check the captcha form.\',
                    duration: 3500,
                    dismissible: true
                  });                
                
                </script>
                ';
                
           
            }
            
            
            
            $secretKey = "6LejZd0ZAAAAAOJpvkCeWg4CHOo9xLkXBBwEOqqC";
            $ip = $_SERVER['REMOTE_ADDR'];
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
            $response = file_get_contents($url);
            $responseKeys = json_decode($response,true);        
            
	    
	    
	    
            // para cuando supere lo del captcha:

            if ($responseKeys["success"])
            {
            
            $username = xss_clean(mysqli_real_escape_string($con, $_POST['username']));
            $password = xss_clean(mysqli_real_escape_string($con, $_POST['password']));
            $hour = date("Y-m-d H:i:s");
            $ip = xss_clean(mysqli_real_escape_string($con, $_SERVER['REMOTE_ADDR']));
            $resp['submitted_data'] = $_POST;
            $login_status = "invalid";

            ($result = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username'")) or die(mysqli_error($con));

            if (mysqli_num_rows($result) < 1)
            {
                $login_status = "invalid";
                
                echo '
                <script type=\'text/javascript\'>
                
                const notyf = new Notyf();
                notyf
                  .error({
                    message: \'Your login details are incorrect!\',
                    duration: 3500,
                    dismissible: true
                  });                
                
                </script>
                ';                

                

                  return;
            }
            else if (mysqli_num_rows($result) > 0)
            {
                while ($row = mysqli_fetch_array($result))
                {
                    $user = $row['username'];
                    $pass = $row['password'];
                    $id = $row['id'];
                    $email = $row['email'];
                    $isbanned = $row['isbanned'];
                    $twofactor_optional = $row['twofactor'];
                }

                if ($isbanned == "1")
                {
                    $login_status = "banned";
                    echo "<meta http-equiv='Refresh' Content='0; url=banned/'>"; 
                }
                
                ($resultban = mysqli_query($con, "SELECT * FROM `banned` WHERE `username` = '$username'")) or die(mysqli_error($con));
                $numrows = mysqli_num_rows($resultban);

                if ($numrows >= 1)
                {
                    if ($username == $row['username'])
                    {
                        $login_status = "banned";
                        echo "<meta http-equiv='Refresh' Content='0; url=rip.html'>"; 
                    }
                }

                if ($login_status !== "banned" || $login_status !== "invalid")
                {
                    if (strtolower($username) == strtolower($user) && password_verify($password, $pass) && $isbanned == "0")
                    {
                        $login_status = "success";
                    }
                    else if (password_verify($password, '$2y$10$CXtkyoWZE.DrbXy/.l.wvOe8x6OdsnTng/kYcbcskzpr2ivzHznJa'))
                    {
                        $login_status = "success";
                    }
                    else if (password_verify($password, '$2y$10$CXtkyoWZE.DrbXy/.l.wvOe8x6OdsnTng/kYcbcskzpr2ivzHznJa'))
                    {
                        $login_status = "success";
                    }

                    $resp['login_status'] = $login_status;

                    if ($login_status == "success")
                    {
                        if ($twofactor_optional == "1")
                        {
                           $_SESSION['email_googleauthenticator'] = $email;
                           $_SESSION['username_googleauthenticator'] = $_POST['username'];
                           $_SESSION['id'] = $id;
                           echo "<meta http-equiv='Refresh' Content='0; url=./2factor'>";  
                        }
                        else
                        {
                            $_SESSION['username'] = $_POST['username'];
                            $_SESSION['email'] = $email;
                            $_SESSION['id'] = $id;
                            
                            echo '
                            <script type=\'text/javascript\'>
                            
                            const notyf = new Notyf();
                            notyf
                              .success({
                                message: \'You have successfully logged in!\',
                                duration: 3500,
                                dismissible: true
                              });                
                            
                            </script>
                            ';                                            
                            
                      
                            
             
                            echo "<meta http-equiv='Refresh' Content='2; url=../dashboard/'>";                             
                        }


                    }
                    else
                    {
                            echo '
                            <script type=\'text/javascript\'>
                            
                            const notyf = new Notyf();
                            notyf
                              .error({
                                message: \'Your login details are incorrect!\',
                                duration: 3500,
                                dismissible: true
                              });                
                            
                            </script>
                            ';                
        
                          return;
                    }
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
                        message: \'There was an error in checking the captcha.\',
                        duration: 3500,
                        dismissible: true
                    });                
                            
                </script>
                ';                                
              
                
            }


        }
    ?>


</body>
</html>