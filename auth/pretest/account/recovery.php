<?php
    error_reporting(E_ALL);
    include '../includes/settings.php';
    session_start();

    if (isset($_SESSION['username'])) {
        header("Location: ../dashboard/");
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
    <title>Akiza | Recovery your password</title>
    <link rel="shortcut icon" href="../dashboard/dist/images/akicon.ico" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/forms/switches.css">
    
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>

    
    <script src="../assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    
    
    <link href="../plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/components/custom-sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    <script src="../plugins/sweetalerts/promise-polyfill.js"></script>
    <script src="../plugins/sweetalerts/sweetalert2.min.js"></script>
    <script src="../plugins/sweetalerts/custom-sweetalert.js"></script>


</head>
<body class="form no-image-content">
    
    
    <?php

    $register_status = 'success';

    if (isset($_POST['reset']))
    {
        $captcha;
        
        
        if (isset($_POST['g-recaptcha-response']))
        {
            $captcha = $_POST['g-recaptcha-response'];
        }
        
        if (!$captcha)
        {
            echo '
            <script type=\'text/javascript\'>
            const toast = swal.mixin({
                toast: true,
                position: \'top-end\',
                showConfirmButton: false,
                timer: 3500,
                padding: \'2em\'
                });
                
                toast({
                type: \'success\',
                title: \'Please check the captcha form.\',
                    
                padding: \'2em\',
                })
                </script>
                ';                   
        }
        
        
        
        $secretKey = "6Ldsls4ZAAAAALEe7_s7LOfVT2ysn65p67xmDM49";
        $ip = $_SERVER['REMOTE_ADDR'];
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);        
        
        
	    
            // para cuando supere lo del captcha:

        if ($responseKeys["success"])
        {

            
            $email = xss_clean(mysqli_real_escape_string($con, $_POST['email']));

            $result = mysqli_query($con, "SELECT * FROM `owners` WHERE `email` = '$email'") or die(mysqli_error($con));

            if (mysqli_num_rows($result) == 1)
            {

                $newPass = generateRandomString();
                $newPassHashed = password_hash($newPass, PASSWORD_BCRYPT);
                $fromName = 'AKIZA';



                $htmlContent = ' 
                    <html> 
                    <head> 
                        <title>AKIZA - You Requested A Password Reset</title> 
                    </head> 
                    <body> 
                        <h1>We have reset your password</h1> 
                        <p>Your new password is: <b>'.$newPass.'</b></p>
                        <p>Login to your account and change your password for the best privacy.</p>
                        <p style="margin-top: 20px;">Thanks,<br><b>AkizaIO Support.</b></p>
                    </body> 
                    </html>'; 


                // Set content-type header for sending HTML email 
                $headers = "MIME-Version: 1.0" . "\r\n"; 
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
                 

                $subject = 'AKIZA - Password Reset';

                $from = "noreply@akiza.io";
                
                $headers .= "From:" . $from;
                    
                if (mail($email, $subject, $htmlContent, $headers))
                {
                    $update = mysqli_query($con, "UPDATE `owners` SET `password` = '$newPassHashed' WHERE `email` = '$email'") or die(mysqli_error($con));

                    echo '
                    <script type=\'text/javascript\'>
                    const toast = swal.mixin({
                        toast: true,
                        position: \'top-end\',
                        showConfirmButton: false,
                        timer: 3500,
                        padding: \'2em\'
                        });
                
                        toast({
                        type: \'success\',
                        title: \'Please check your email, I sent your a new password!\',
                    
                        padding: \'2em\',
                        })
                        </script>
                        ';                        
                        
                    

                }
                else 
                {
                    
                    echo '
                    <script type=\'text/javascript\'>
                    const toast = swal.mixin({
                        toast: true,
                        position: \'top-end\',
                        showConfirmButton: false,
                        timer: 3500,
                        padding: \'2em\'
                        });
                
                        toast({
                        type: \'error\',
                        title: \'Failed to reset password. Please contact an admin!\',
                    
                        padding: \'2em\',
                        })
                        </script>
                        ';                                       
                    
                }

            }
            
        }
                else 
                {
                    
                    echo '
                    <script type=\'text/javascript\'>
                    const toast = swal.mixin({
                        toast: true,
                        position: \'top-end\',
                        showConfirmButton: false,
                        timer: 3500,
                        padding: \'2em\'
                        });
                
                        toast({
                        type: \'error\',
                        title: \'There was an error in checking the captcha!\',
                    
                        padding: \'2em\',
                        })
                        </script>
                        ';                                       
                    
                }        
    }
?>



    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">Password Recovery</h1>
                        <p class="signup-link recovery">Enter your email and instructions will sent to you!</p>
                        <form class="text-left" method="POST" action="">
                            <div class="form">

                                <div id="email-field" class="field-wrapper input">
                                    <div class="d-flex justify-content-between">
                                        <label for="email">EMAIL</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                                    <input id="email" name="email" type="text" class="form-control" value="" placeholder="Email">
                                </div>


                                <center>
                                    
                                    <div class="g-recaptcha" data-sitekey="6Ldsls4ZAAAAAEq9hIAwxM66nB8Mkzplssoytrp3"></div>
                                </center>
                                <br>
                                
                                
                                <div class="d-sm-flex justify-content-between">

                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" name="reset" >Reset</button>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>                    
                </div>
            </div>
        </div>
    </div>

    

    <script src="../assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    
    <script src="../assets/js/authentication/form-2.js"></script>

</body>

</html>