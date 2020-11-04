<?php

include '../includes/settings.php';
error_reporting(0);

if (!strlen(strstr($_SERVER['HTTP_USER_AGENT'], "Akiza_Session")) <= 0)
{
    $program_key = Decryption(strip_tags(trim(xss_clean(mysqli_real_escape_string($con, $_POST['program_key'])))));
    $variable_key = Decryption(strip_tags(trim(xss_clean(mysqli_real_escape_string($con, $_POST['variable_key'])))));
    $variable_name = Decryption(strip_tags(trim(xss_clean(mysqli_real_escape_string($con, $_POST['variable_name'])))));
    $username = Decryption(strip_tags(trim(xss_clean(mysqli_real_escape_string($con, $_POST['username'])))));
    $password = Decryption(strip_tags(trim(xss_clean(mysqli_real_escape_string($con, $_POST['password'])))));
    $hwid = Decryption(strip_tags(trim(xss_clean(mysqli_real_escape_string($con, $_POST['hwid'])))));

    if (empty($program_key) || empty($variable_key) || empty($username) || empty($password) || empty($hwid))
    {
        die(Encryption(json_encode("null_entry")));
    }



    $verify_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or die(Encryption(json_encode("internal_error")));
    if (mysqli_num_rows($verify_program) > 0)
    {
        $result = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(Encryption(json_encode("internal_error")));

        while ($row = mysqli_fetch_array($verify_program))
        {
            $hwidlock = $row['hwidlock'];
        }

        if (mysqli_num_rows($result) < 1)
        {
            die(Encryption(json_encode("incorrect_credentials")));
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
                    $update_hwid = mysqli_query($con, "UPDATE `users` SET `hwid` = '$hwid' WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(Encryption(json_encode("internal_error")));
                    if ($update_hwid)
                    {
                        die(Encryption(json_encode("hwid_updated")));
                    }   
                    else
                    {
                        die(Encryption(json_encode("internal_error")));
                    }
                }


                $date = new DateTime($expires);
                $today = new DateTime();
                
                if ($date < $today)
                {
                    die(Encryption(json_encode("subscription_expired")));
                }
                else
                {
                    if ($isbanned == "1")
                    {
                        die(Encryption(json_encode("banned_user")));
                    }
                    else
                    {
                        if ($hwid == $hwidd)
                        {
                            $check_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `variablekey` = '$variable_key' AND `authtoken` = '$program_key'") or die(Encryption(json_encode("internal_error")));


                            if (mysqli_num_rows($check_program) > 0)
                            {
                                $encrypted_var = array();
                                $select_variable = mysqli_query($con, "SELECT * FROM `vars` WHERE `name` = '$variable_name' AND `programtoken` = '$program_key'");
                                                                
                                if ($select_variable)
                                {
                                    if (mysqli_num_rows($select_variable) < 1)
                                    {
                                        die(Encryption(json_encode("not_found")));
                                    }
                                    else if (mysqli_num_rows($select_variable) > 0)
                                    {
                                        $var_nvalue;

                                        while ($select = mysqli_fetch_array($select_variable))
                                        {
                                            $var_nvalue = $select['value'];
                                        }

                                        die(Encryption(json_encode($var_nvalue)));
                                    }
                                }
                            }
                        }
                    }
                }


            }
            else
            {
                die(Encryption(json_encode("incorrect_credentials")));
            }
            
        }

    }
}




// Functions

function Encryption($string)
{
    $plaintext = $string;
    $password = base64_decode($_POST['session_key']);
    $method = 'aes-256-cbc';
    $password = substr(hash('sha256', $password, true), 0, 32);
    $iv = base64_decode($_POST['session_iv']);
    $encrypted = base64_encode(openssl_encrypt($plaintext, $method, $password, OPENSSL_RAW_DATA, $iv));
    return $encrypted;
}

function Decryption($string)
{
    $plaintext = $string;
    $password = base64_decode($_POST['session_key']);
    $method = 'aes-256-cbc';
    $password = substr(hash('sha256', $password, true), 0, 32);
    $iv = base64_decode($_POST['session_iv']);
    $decrypted = openssl_decrypt(base64_decode($plaintext), $method, $password, OPENSSL_RAW_DATA, $iv);
    return $decrypted;
}

function xss_clean($data)
{
    return strip_tags($data);
}

?>