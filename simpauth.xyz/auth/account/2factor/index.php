<?php
    error_reporting(E_ALL);
    include '../../includes/settings.php';
    require_once '../googleLib/GoogleAuthenticator.php';
    $gauth = new GoogleAuthenticator();
    
    session_start();

    if (empty($_SESSION['username_googleauthenticator'])) {
        header("Location: ../login.php");
        exit();
    }

    
    $user = $_SESSION['username_googleauthenticator'];
    $email = $_SESSION['email_googleauthenticator'];
    $user_result = mysqli_query($con, "SELECT * from `owners` WHERE `username` = '$user' AND `email` = '$email'") or die(mysqli_error($con));
    
    while ($row_user = mysqli_fetch_array($user_result))
    {
        $secret_key = $row_user['googleAuthCode'];
    }
    
    $google_QR_Code = $gauth->getQRCodeGoogleUrl($email, $secret_key, 'Akiza');


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
    <title>Akiza | Login</title>
    <link rel="shortcut icon" href="../../dashboard/dist/images/akicon.ico" />

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

</head>
<body class="form">
    

    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">2Factor enabled</h1>
                        <p class="">Please enter the code that appears in the authenticator to continue.</p>
                        
                        <form class="text-left" method="POST" action="">
                            <div class="form">

                                
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="google_code">Place your code here:</label>
                                        <a href="https://discord.gg/UmJbzMd" target="_blank" class="forgot-pass-link">Don't have your device?</a>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="scan_code" name="scan_code" type="text" class="form-control" required>

                                    
                                    
                                </div>
                            
                                
                                <br>
                                                            
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" name="verify_code" class="btn btn-primary" value="">Submit</button>
                                    </div>
                                </div>

                                <p class="signup-link"><a href="../logout.php">Log Out</a></p>

                            </div>
                        </form>

                    </div>                    
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/authentication/form-2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
	
    <?php
        if (isset($_POST['verify_code']))
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
                

                  return;
            }


            $status_login = "";

            if (!isset($_SESSION))
            {
                session_start();
            }
            
            $code = $_POST['scan_code'];
            $username = $_SESSION['username_googleauthenticator'];
            $email_user = $_SESSION['email_googleauthenticator'];
            
            $user_result = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username' AND `email` = '$email_user'") or die(mysqli_error($con));
            
            while ($row = mysqli_fetch_array($user_result))
            {
                $google_Code = $row['googleAuthCode'];
            }
            
            $checkResult = $gauth->verifyCode($google_Code, $code, 2);
            
            if ($checkResult)
            {
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email_user;
                
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

                  echo "<meta http-equiv='Refresh' Content='2; url=../../dashboard'>"; 
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



    ?>


</body>
</html>