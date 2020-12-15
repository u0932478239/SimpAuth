
<?php
    include '../includes/settings.php';
    session_start();
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
    <link href="../assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">


    <link rel="stylesheet" type="text/css" href="../assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/forms/switches.css">
</head>
<body class="form">
    

    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">Register</h1>
                        <p class="signup-link register">Already have an account? <a href="login.php">Log in</a></p>
                        <form class="text-left" method="POST" action="">
                            <div class="form">

                                <div id="username-field" class="field-wrapper input">
                                    <label for="username">USERNAME</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="username" name="username" type="text" class="form-control" placeholder="Username">
                                </div>

                                <div id="email-field" class="field-wrapper input">
                                    <label for="email">EMAIL</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign register"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                                    <input id="email" name="email" type="text" value="" class="form-control" placeholder="Email">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">PASSWORD</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">REPEAT PASSWORD</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="repeatpassword" name="repeatpassword" type="password" class="form-control" placeholder="Repeat Password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </div>

                                <center>
                                    <div class="g-recaptcha" data-sitekey="6LejZd0ZAAAAAId9CyXjNedpGclGWc_bpffIsKKf"></div>
                                </center>
                                <br>
                                
                                <div class="field-wrapper terms_condition">
                                    <div class="n-chk">
                                        <label class="new-control new-checkbox checkbox-primary">
                                          <input type="checkbox" class="new-control-input" name="terms">
                                          <span class="new-control-indicator"></span><span><a href="https://simpauth.xyz/auth/tos.php" target="_blank">I agree to the  terms and conditions </a></span>
                                        </label>
                                    </div>

                                </div>

                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" name="registersubmit" class="btn btn-primary" value="">Get Started!</button>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>                    
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <?php

        function xss_clean($data)
        {
            return strip_tags($data);
        }

        $register_status = "success";

        if (isset($_POST['registersubmit']))
        {
            
            
            if (!isset($_POST['terms']))
            {
                echo '
                <script type=\'text/javascript\'>
                
                const notyf = new Notyf();
                notyf
                  .error({
                    message: \'You must accept the terms of service in order to register on the website!\',
                    duration: 3500,
                    dismissible: true
                  });                
                
                </script>
                ';

                
            }
            else
            {
                
            // para cuando supere el captcha
            
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
                    message: \'Please check the captcha form!\',
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
                $repeatpassword = xss_clean(mysqli_real_escape_string($con, $_POST['repeatpassword']));
                
                $email = xss_clean(mysqli_real_escape_string($con, $_POST['email']));

                $result = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username'") or die(mysqli_error($con));
            
                if ($repeatpassword != $password)
                {
                    
                    echo '
                    <script type=\'text/javascript\'>
                    
                    const notyf = new Notyf();
                    notyf
                      .error({
                        message: \'Password do not match!\',
                        duration: 3500,
                        dismissible: true
                      });                
                    
                    </script>
                    ';
                

                    return;
                }
                else if (strlen($password) <= 5)
                {
                    echo '
                    <script type=\'text/javascript\'>
                    
                    const notyf = new Notyf();
                    notyf
                      .error({
                        message: \'Use a longer password!\',
                        duration: 3500,
                        dismissible: true
                      });                
                    
                    </script>
                    ';
                    


                        return;
                }
                else if (mysqli_num_rows($result) >= 1)
                {   
                    
                    echo '
                    <script type=\'text/javascript\'>
                    
                    const notyf = new Notyf();
                    notyf
                      .error({
                        message: \'Username already taken!\',
                        duration: 3500,
                        dismissible: true
                      });                
                    
                    </script>
                    ';
                    

                        return;
                }
                else if (strlen($email) > 40)
                {
                    echo '
                    <script type=\'text/javascript\'>
                    
                    const notyf = new Notyf();
                    notyf
                      .error({
                        message: \'Email too long!, maximum lenght is 40 characters.\',
                        duration: 3500,
                        dismissible: true
                      });                
                    
                    </script>
                    ';
                    


                        return;
                }
                else if (strlen($password) > 30)
                {
                    echo '
                    <script type=\'text/javascript\'>
                    
                    const notyf = new Notyf();
                    notyf
                      .error({
                        message: \'Password too long!, maximum lenght is 30 characters.\',
                        duration: 3500,
                        dismissible: true
                      });                
                    
                    </script>
                    ';

                     return;
                }
                else
                {
                    $user_check = mysqli_query($con, "SELECT `username` FROM `owners` WHERE `username` = '$username'") or die(mysqli_error($con));
                    $do_user_check = mysqli_num_rows($user_check);
    
                    if ($do_user_check > 0)
                    {
                        $register_status = "user_taken";
                    }
    
                    $email_check = mysqli_query($con, "SELECT `email` FROM `owners` WHERE `email` = '$email'") or die(mysqli_error($con));
                    $do_email_check = mysqli_num_rows($email_check);

                    if ($do_email_check > 0)
                    {
                        $register_status = "email_token";
                    }

                    if ($register_status == "success")
                    {
                        $pass_encrypted = password_hash($password, PASSWORD_BCRYPT);
                        mysqli_query($con, "INSERT INTO `owners` (username, password, email, isbanned) VALUES ('$username', '$pass_encrypted', '$email', 0)") or die(mysqli_error($con));
                        $register_status = "success";
                    }

                    if ($register_status == true)
                    {
                        echo '
                        <script type=\'text/javascript\'>
                        
                        const notyf = new Notyf();
                        notyf
                          .success({
                            message: \'Successfully registered!, Redirecting(...)\',
                            duration: 3500,
                            dismissible: true
                          });                
                        
                        </script>
                        ';

                      
                          echo '<META HTTP-EQUIV="REFRESH" CONTENT="2;URL=login.php">';
                          exit();
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
                        message: \'There was an error in checking the captcha\',
                        duration: 3500,
                        dismissible: true
                    });                
                        
                </script>
                ';
                        
     
            }
        }
    }
?> 
    
    <script src="../assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    
    <script src="../assets/js/authentication/form-2.js"></script>

</body>

</html>