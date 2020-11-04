<?php

include '../includes/settings.php';
error_reporting(0);
function get_client_ip() 
{
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
        $ipaddress = 'N/A';
    return $ipaddress;
}

if (!strlen(strstr($_SERVER['HTTP_USER_AGENT'], "Akiza_Session")) <= 0)
{
    $action = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['action'])));        
    $program_key = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['application_id'])));  
    $ip = get_client_ip();

    switch ($action)
    {
        case "initialize":
            $verify_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or die(Encrypt(json_encode(array("status" => "internal_error"))));  
                
            if (mysqli_num_rows($verify_program) > 0)
            {
                while ($row = mysqli_fetch_array($verify_program))
                {
                    $version = $row['version'];
                    $banned = $row['banned'];
                    $freemode = $row['freemode'];
                    $enabled = $row['enabled'];
                    $hash = $row['hash'];
                    $downloadlink = $row['downloadlink'];
                    $devmode = $row['developermode'];
                    $hwidlock = $row['hwidlock'];
                    $antidebug = $row['antidebug'];
                    $hashcheck = $row['hashcheck'];
                    $updatercheck = $row['enableupdater'];
                }

                if ($banned == "1")
                {
                    die(Encrypt(json_encode(array("status" => "banned_app"))));
                }
                else
                {
                    die(Encrypt(json_encode(array(
                            "status" => "success",
                            "version" => $version,
                            "freemode" => $freemode,
                            "enabled" => $enabled,
                            "hash" => $hash,
                            "devmode" => $devmode,
                            "hwidlock" => $hwidlock,
                            "antidebug" => $antidebug,
                            "hashcheck" => $hashcheck,
                            "optionalupdater" => $updatercheck,
                            "updater_link" => $downloadlink
                    ))));
                }
            }
            else
            {
                die(Encrypt(json_encode(array("status" => "error", "info" => "Application not found!"))));
            }
            break;



            case "login":
                $username = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['username'])));
                $password = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['password'])));
                $hwid = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['hwid'])));
                $timestamp = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['date'])));

                if (empty($username) || empty($password) || empty($hwid) || empty($timestamp))
                {
                    die(Encrypt(json_encode(array("status" => "null_entry"))));
                }

                $verify_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or die(Encrypt(json_encode(array("status" => "internal_error")))); 

                if (mysqli_num_rows($verify_program) > 0)
                {
                    while ($row_app = mysqli_fetch_array($verify_program))
                    {
                        $hwid_lock = $row_app['hwidlock'];
                        $banned_app = $row_app['banned'];
                    }

                    if ($banned_app == "1")
                    {
                        die(Encrypt(json_encode(array("status" => "banned_app"))));
                    }

                    $user_verify = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(Encrypt(json_encode(array("status" => "internal_error")))); 
                    if (mysqli_num_rows($user_verify) < 1)
                    {
                        die(Encrypt(json_encode(array("status" => "incorrect_details"))));
                    }                
                    else if (mysqli_num_rows($user_verify) > 0)
                    {
                        while ($row_user = mysqli_fetch_array($user_verify))
                        {
                            $user = $row_user['username'];
                            $pass = $row_user['password'];
                            $level = $row_user['level'];
                            $isbanned = $row_user['banned'];
                            $user_hwid = $row_user['hwid'];
                            $expires = $row_user['expires'];
                            $ip = $row_user['ip'];
                            $license = $row_user['email'];
                        }

                        if (strtolower($username) == strtolower($user) && (password_verify($password, $pass)))
                        {
                            if ($user_hwid == "RESET")
                            {
                                $update_hwid = mysqli_query($con, "UPDATE `users` SET `hwid` = '$hwid' WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(Encrypt(json_encode(array("status" => "internal_error"))));
                                if ($update_hwid)
                                {
                                    die(Encrypt(json_encode(array("status" => "hwid_reseted"))));                                    
                                }
                                else
                                {
                                    die(Encrypt(json_encode(array("status" => "internal_error"))));    
                                }
                            }

                            $date = new DateTime($expires);
                            $today = new DateTime();

                            if ($date < $today)
                            {
                                die(Encrypt(json_encode(array("status" => "expired_time"))));
                            }
                            else
                            {
                                if ($isbanned == "1")
                                {
                                    die(Encrypt(json_encode(array("status" => "banned_user"))));
                                }
                                else
                                {
                                    if ($hwid_lock == "1")
                                    {
                                        if ($hwid != $user_hwid || $hwid !== $user_hwid)
                                        {
                                            die(Encrypt(json_encode(array("status" => "incorrect_hwid"))));
                                        }
                                    }

                                    die(Encrypt(json_encode(array(
                                        "status" => "success",
                                        "username" => $user,
                                        "license" => $license,
                                        "level" => $level,
                                        "expires" => $expires,
                                        "hwid" => $user_hwid,
                                        "ip" =>  $ip,
                                        "timestamp" => $timestamp
                                    ))));
                                }
                            }
                        }
                    }
                }
            break;



            case "register":
                $username = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['username'])));
                $password = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['password'])));
                $hwid = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['hwid'])));
                $license = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['license'])));                

                if (empty($username) || empty($password) || empty($hwid) || empty($license))
                {
                    die(Encrypt(json_encode(array("status" => "null_entry"))));
                }

                $program_verify = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or die(Encrypt(json_encode(array("status" => "internal_error"))));

                if (mysqli_num_rows($program_verify) < 1)
                {
                    die(Encrypt(json_encode(array("status" => "error", "info" => "Program not found!"))));
                }
                else
                {
                    while ($row_user = mysqli_fetch_array($program_verify))
                    {
                        $app_owner = $row_user['owner'];
                        $app_banned = $row_user['banned'];
                    }

                    if ($app_banned == "1")
                    {
                        die(Encrypt(json_encode(array("status" => "error", "info" => "The developer of this program has been banned, therefore you cannot login or register."))));                        
                    }

                    if (mysqli_num_rows($program_verify) > 0)
                    {
                        $user_verify = mysqli_query($con, "SELECT `username` FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(Encrypt(json_encode(array("status" => "internal_error"))));

                        if (mysqli_num_rows($user_verify) > 0)
                        {
                            die(Encrypt(json_encode(array("status" => "error", "info" => "Username already in use."))));
                        }
                        else
                        {
                            $grab_info = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$app_owner'") or die(Encrypt(json_encode(array("status" => "internal_error"))));

                            while ($row_owner = mysqli_fetch_array($grab_info))
                            {
                                $subscription = $row_owner['premium'];
                            }

                            $maximum_users = mysqli_query($con, "SELECT * FROM `users` WHERE `programtoken` = '$program_key'") or die(Encrypt(json_encode(array("status" => "internal_error"))));
                            if ($subscription == "1")
                            {
                                if (mysqli_num_rows($maximum_users) > 5000)
                                {
                                    die(Encrypt(json_encode(array("status" => "error", "info" => "Program owner has exceeded their max user quota."))));
                                }
                            }
                            else if ($subscription == "0")
                            {
                                if (mysqli_num_rows($maximum_users) > 50)
                                {
                                    die(Encrypt(json_encode(array("status" => "error", "info" => "Program owner has exceeded their max user quota."))));
                                }
                            }

                            $license_verify = mysqli_query($con, "SELECT * FROM `tokens` WHERE `programtoken` = '$program_key' AND `token` = '$license' AND `used` = '0'") or die(Encrypt(json_encode(array("status" => "internal_error"))));

                            if (mysqli_num_rows($license_verify) > 0)
                            {
                                while ($row_license = mysqli_fetch_array($license_verify))
                                {
                                    $days = $row_license['days'];
                                    $level = $row_license['level'];
                                }

                                $update_license = mysqli_query($con, "UPDATE `tokens` SET `used` = '1', `used_by` = '$username' WHERE `programtoken` = '$program_key' AND `token` = '$license'") or die(Encrypt(json_encode(array("status" => "internal_error"))));

                                if ($update_license)
                                {
                                    $update_user = mysqli_query($con, "UPDATE `programs` SET `clients` = clients + 1 WHERE `authtoken` = '$program_key'") or die(Encrypt(json_encode(array("status" => "internal_error"))));

                                    if ($update_user)
                                    {
                                        $today = new DateTime();
                                        $new_date = $today->modify('+'.$days.' days');
                                        $date_2 = $new_date;
                                        $Time = ''.$date_2->format('Y-m-d H:i:s').'';

                                        $pass_encrypted = password_hash($password, PASSWORD_BCRYPT);

                                        $add_user = mysqli_query($con, "INSERT INTO `users` (username, password, email, level, expires, hwid, ip, banned, programtoken)
                                        VALUES ('$username', '$pass_encrypted', '$license', '$level', '$Time', '$hwid', '$ip', '0', '$program_key')") or die(Encrypt(json_encode(array("status" => "internal_error"))));

                                        if ($add_user)
                                        {
                                            die(Encrypt(json_encode(array(
                                                "status" => "success",
                                                "username" => $username,
                                                "expires" => $Time,
                                                "level" => $level
                                            ))));
                                        }
                                    }
                                    else
                                    {
                                        die(Encrypt(json_encode(array(
                                            "status" => "error",
                                            "info" => "Internal error"
                                        ))));
                                    }
                                }
                                else
                                {
                                    die(Encrypt(json_encode(array(
                                        "status" => "error",
                                        "info" => "Couldn't update license!, try again."
                                    ))));                                    
                                }
                            }
                            else
                            {
                                die(Encrypt(json_encode(array(
                                    "status" => "error",
                                    "info" => "Invalid license!"
                                ))));                                 
                            }
                        }

                    }
                    else
                    {
                        die(Encrypt(json_encode(array(
                            "status" => "error",
                            "info" => "Invalid program!"
                        ))));
                    }
                }
            break;



            case "extend_subscription":                
                $username = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['username'])));
                $password = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['password'])));
                $hwid = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['hwid'])));
                $license = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['license'])));      
                
                if (empty($username) || empty($password) || empty($hwid) || empty($license))
                {
                    die(Encrypt(json_encode(array(
                        "status" => "error",
                        "info" => "You must fill in all the fields!"
                    ))));
                }
                
                $verify_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or die(Encrypt(json_encode(array("status" => "internal_error"))));
                
                if (mysqli_num_rows($verify_program) > 0)
                {
                    while ($app_row = mysqli_fetch_array($verify_program))
                    {
                        $app_hwidlock = $app_row['hwidlock'];
                    }

                    $verify_user = mysqli_query($con, "SELECT `username` FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(Encrypt(json_encode(array("status" => "internal_error"))));
                    if (mysqli_num_rows($verify_user) <= 0)
                    {
                        die(Encrypt(json_encode(array(
                            "status" => "error",
                            "info" => "Username doesn't exist!"
                        ))));
                    }
                    else
                    {
                        $user_info = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(Encrypt(json_encode(array("status" => "internal_error"))));

                        while ($user_row = mysqli_fetch_array($user_info))
                        {
                            $user = $user_row['username'];
                            $pass = $user_row['password'];
                            $expires = $user_row['expires'];
                            $user_banned = $user_row['banned'];
                            $user_hwid = $user_row['hwid'];
                        }

                        if (strtolower($user) == strtolower($username) && (password_verify($password, $pass)))
                        {
                            if ($user_banned == "1")
                            {
                                die(Encrypt(json_encode(array(
                                    "status" => "error",
                                    "info" => "Your account is banned from this application!"
                                ))));
                            }

                            if ($app_hwidlock == "1")
                            {
                                if ($hwid != $user_hwid)
                                {
                                    die(Encrypt(json_encode(array(
                                        "status" => "error",
                                        "info" => "The HWID is incorrect!"
                                    ))));
                                }
                            }

                            $license_verify = mysqli_query($con, "SELECT * FROM `tokens` WHERE `programtoken` = '$program_key' AND `token` = '$license' AND `used` = '0'") or die(Encrypt(json_encode(array("status" => "internal_error"))));

                            if (mysqli_num_rows($license_verify) > 0)
                            {
                                while ($lic_row = mysqli_fetch_array($license_verify))
                                {
                                    $days = $lic_row['days'];
                                    $level = $lic_row['level'];
                                }
                            }                            
                            else
                            {
                                die(Encrypt(json_encode(array(
                                    "status" => "error",
                                    "info" => "Invalid license!"
                                ))));
                            }

                            $update_license = mysqli_query($con, "UPDATE `tokens` SET `used` = '1', `used_by` = '$username' WHERE `programtoken` = '$program_key' AND `token` = '$license'") or die(Encrypt(json_encode(array("status" => "internal_error"))));

                            if ($update_license)
                            {
                                $today = new DateTime($expires);
                                $new_date = $today->modify('+'.$days.' days');
                                $date_2 = $new_date;
                                $Time = ''.$date_2->format('Y-m-d H:i:s');

                                $add_license = mysqli_query($con, "UPDATE `users` SET `expires` = '$Time', `level` = '$level' WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(Encrypt(json_encode(array("status" => "internal_error"))));

                                if ($add_license)
                                {
                                    die(Encrypt(json_encode(array(
                                        "status" => "success",
                                        "new_expires" => $Time
                                    ))));
                                }
                            }
                            else
                            {
                                die(Encrypt(json_encode(array(
                                    "status" => "error",
                                    "info" => "Couldn't update license!, try again."
                                ))));
                            }
                        }
                        else
                        {
                            die(Encrypt(json_encode(array(
                                "status" => "error",
                                "info" => "Incorrect username or password."
                            ))));
                        }
                    }


                }
                else
                {
                    die(Encrypt(json_encode(array(
                        "status" => "error",
                        "info" => "Program secret doesn't exist"
                    ))));
                }

            break;



            case "var":
                $variable_key = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['variable_key'])));
                $variable_name = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['variable_name'])));
                $username = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['username'])));
                $password = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['password'])));
                $hwid = Decrypt(xss_clean(mysqli_real_escape_string($con, $_POST['hwid'])));

                if (empty($variable_key) || empty($variable_name) || empty($username) || empty($password) || empty($hwid))
                {
                    die(Encrypt(json_encode(array(
                        "status" => "error",
                        "info" => "You must fill in all the fields!"
                    ))));
                }

                $verify_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or die(Encrypt(json_encode("internal_error")));
                if (mysqli_num_rows($verify_program) > 0)
                {
                    $result = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(Encrypt(json_encode("internal_error")));
            
                    while ($row = mysqli_fetch_array($verify_program))
                    {
                        $hwidlock = $row['hwidlock'];
                    }
            
                    if (mysqli_num_rows($result) < 1)
                    {
                        die(Encrypt(json_encode("incorrect_credentials")));
                    }
                    else if (mysqli_num_rows($result) > 0)        
                    {
                        while ($row_2 = mysqli_fetch_array($result))
                        {
                            $user = $row_2['username'];
                            $pass = $row_2['password'];
                            $level = $row_2['level'];
                            $isbanned = $row_2['banned'];
                            $hwidd = $row_2['hwid'];
                            $expires = $row_2['expires'];
                            $ip = $row_2['ip'];
                            $license = $row_2['license'];
                        }
            
                        if (strtolower($username) == strtolower($user) && (password_verify($password, $pass)))
                        {
                            if ($hwidd == "RESET")
                            {
                                $update_hwid = mysqli_query($con, "UPDATE `users` SET `hwid` = '$hwid' WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(Encrypt(json_encode("internal_error")));
                                if ($update_hwid)
                                {
                                    die(Encrypt(json_encode("hwid_updated")));
                                }   
                                else
                                {
                                    die(Encrypt(json_encode("internal_error")));
                                }
                            }
            
            
                            $date = new DateTime($expires);
                            $today = new DateTime();
                            
                            if ($date < $today)
                            {
                                die(Encrypt(json_encode("subscription_expired")));
                            }
                            else
                            {
                                if ($isbanned == "1")
                                {
                                    die(Encrypt(json_encode("banned_user")));
                                }
                                else
                                {
                                    if ($hwid == $hwidd)
                                    {
                                        $check_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `variablekey` = '$variable_key' AND `authtoken` = '$program_key'") or die(Encrypt(json_encode("internal_error")));
            
            
                                        if (mysqli_num_rows($check_program) > 0)
                                        {
                                            $encrypted_var = array();
                                            $select_variable = mysqli_query($con, "SELECT * FROM `vars` WHERE `name` = '$variable_name' AND `programtoken` = '$program_key'");
                                                                            
                                            if ($select_variable)
                                            {
                                                if (mysqli_num_rows($select_variable) < 1)
                                                {
                                                    die(Encrypt(json_encode("not_found")));
                                                }
                                                else if (mysqli_num_rows($select_variable) > 0)
                                                {
                                                    $var_nvalue;
            
                                                    while ($select = mysqli_fetch_array($select_variable))
                                                    {
                                                        $var_nvalue = $select['value'];
                                                    }
            
                                                    die(Encrypt(json_encode($var_nvalue)));
                                                }
                                            }
                                        }
                                    }
                                }
                            }
            
            
                        }
                        else
                        {
                            die(Encrypt(json_encode("incorrect_credentials")));
                        }
                        
                    }
            
                }

            break;



    }
}
else
{
    die(Encrypt(json_encode(array("status" => "failed_connection"))));
}



function Encrypt($string)
{
   $plaintext = $string;
   $password = base64_decode($_POST['session_key']);
   $method = 'aes-256-cbc';
   $password = substr(hash('sha256', $password, true), 0, 32);
   $iv = base64_decode($_POST['request_iv']);
   $encrypted = base64_encode(openssl_encrypt($plaintext, $method, $password, OPENSSL_RAW_DATA, $iv));
   return $encrypted;
}


function Decrypt($string)
{
   $plaintext = $string;
   $password = base64_decode($_POST['session_key']);
   $method = 'aes-256-cbc';
   $password = substr(hash('sha256', $password, true), 0, 32);
   $iv = base64_decode($_POST['request_iv']);
   $decrypted = openssl_decrypt(base64_decode($plaintext), $method, $password, OPENSSL_RAW_DATA, $iv);
   return $decrypted;
}

function API_Decrypt($string)
{
   $plaintext = $string;
   $password = base64_decode($_POST['session_api_key']);
   $method = 'aes-256-cbc';
   $password = substr(hash('sha256', $password, true), 0, 32);
   $iv = base64_decode($_POST['request_api_iv']);
   $decrypted = openssl_decrypt(base64_decode($plaintext), $method, $password, OPENSSL_RAW_DATA, $iv);
   return $decrypted;
}


function xss_clean($data)
{
    return strip_tags($data);
}


?>