<?php

include '../includes/settings.php';

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
        $ipaddress = 'N/A';
    return $ipaddress;
}

if (!strlen(strstr($_SERVER['HTTP_USER_AGENT'], "Akiza_Session")) <= 0)
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $post_Body = file_get_contents("php://input");
        $datos_Decode = json_decode($post_Body, true);
        
        
        if (isset($datos_Decode['action']))
        {
            $action = strtolower($datos_Decode['action']);
            $api_key = strtolower($datos_Decode['api_key']);
            $program_key = strtolower($datos_Decode['program_key']);
            
            switch ($action)
            {
                
                default:
                	http_response_code(405);
                    echo json_encode(array("status" => "Failed", "message" => "The action does not exist."));                    
                    break;
                
                case "appinfo":

                    $api_exist = mysqli_query($con, "SELECT * FROM `owners` WHERE `api_key` = '$api_key'") or die(mysqli_error($con));
                
                    if (mysqli_num_rows($api_exist) > 0)
                    {
                        while ($row = mysqli_fetch_array($api_exist))
                        {
                            $user_api_key = strtolower($row['username']);
                        }
                    
                        $program_exist = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or die(mysqli_error($con));
                        if (mysqli_num_rows($program_exist) > 0)
                        {
                            while ($row = mysqli_fetch_array($program_exist))
                            {
                                $owner_program_key = strtolower($row['owner']);
                                $app_name = $row['name'];
                                $app_version = $row['version'];
                                $app_banned = $row['banned'] == "1" ? "Yes" : "No";
                                $app_freemode = ($row['freemode'] == "1" ? "Yes" : "No");
                                $app_enabled = ($row['enabled'] == "1" ? "Online" : "Offline");
                                $link_auto_updater = $row['downloadlink'] == "1";
                                $app_enable_updater = ($row['enableupdater'] == "1" ? "Yes" : "No");
                                $app_hash = $row['hash'];
                                $app_hashchecker = $row['hashcheck'] == "1" ? "Yes" : "No";
                                $app_dev_mode = $row['developermode'] == "1" ? "Yes" : "No";
                                $app_hwidlock = $row['hwidlock'] == "1" ? "Yes" : "No";
                                $app_antidebug = $row['antidebug'] == "1" ? "Yes" : "No";                        
                            }
    
                            if ($owner_program_key != $user_api_key)
                            {
								http_response_code(403);
                            	die(json_encode(array("status" => "Failed", "message" => "The entered API key does not belong to the application owner account.")));                                
                            }
                            else
                            {
                            
                                $information = array(
                                    "Status" => "$app_enabled",
                                    "Name" => "$app_name",
                                    "Version" => "$app_version",
                                    "Banned" => "$app_banned",
                                    "Freemode" => "$app_freemode",
                                    "Updater" => "$app_enable_updater",
                                    "Link_Updater" => "$link_auto_updater",
                                    "HashChecker" => "$app_hashchecker",
                                    "Hash" => "$app_hash",
                                    "Developer_mode" => "$app_dev_mode",
                                    "HWIDLock" => "$app_hwidlock",
                                    "AntiDebug" => "$app_antidebug"
                                );
    
                                echo json_encode($information);
                                http_response_code(200);
    
                            }
                        }
                        else
                        {                                                      
                            http_response_code(404);
                            die(json_encode(array("status" => "Failed", "message" => "Program not  found")));                            
                        }
                    }
                    else
                    {
                    	http_response_code(404);         
                        die(json_encode(array("status" => "Failed", "message" => "The entered api key does not exist in our database!")));                        
                    }

                break;



                case "login":       
                    
                    $username = $datos_Decode['username'];
                    $password = $datos_Decode['password'];
                    $hwid = $datos_Decode['hwid'];



                    $api_exist = mysqli_query($con, "SELECT * FROM `owners` WHERE `api_key` = '$api_key'") or die(mysqli_error($con));
                
                    if (mysqli_num_rows($api_exist) > 0)
                    {
                        while ($row = mysqli_fetch_array($api_exist))
                        {
                            $user_api_key = strtolower($row['username']);
                        }
                    
                        $program_exist = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or die(mysqli_error($con));
                        if (mysqli_num_rows($program_exist) > 0)
                        {
                            while ($row = mysqli_fetch_array($program_exist))
                            {
                                $owner_program_key = strtolower($row['owner']);    
                                $hwidlock = $row['hwidlock'];
                                $app_banned = ($row['banned'] == "1" ? true : false);
                            }
    
                            if ($app_banned)
                            {                            	
                                http_response_code(403);
                                die(json_encode(array("status" => "banned_app", "message" => "The developer of this program has been banned, therefore you cannot login or register.")));                                
                            }

                            if ($owner_program_key != $user_api_key)
                            {
                                http_response_code(403);
                                die(json_encode(array("status" => "Failed", "message" => "The entered API key does not belong to the application owner account.")));                                
                            }
                            else
                            {

                                $result = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(mysqli_error($con));
                                
                                if (mysqli_num_rows($result) < 1)
                                {
                                    http_response_code(404);
                                    die(json_encode(array("status" => "invalid_credentials")));
                                }
                                else if (mysqli_num_rows($result) > 0)                            
                                {
                                    while ($row = mysqli_fetch_array($result))
                                    {
                                        $user = $row['username'];
                                        $pass = $row['password'];
                                        $level = (int)$row['level'];
                                        $user_banned = ($row['banned'] == "1" ? true : false);
                                        $user_hwid = $row['hwid'];
                                        $expires = $row['expires'];
                                        $ip = $row['ip'];
                                        $license = $row['email'];
                                    }                                

                                    if (strtolower($username) == strtolower($user) && (password_verify($password, $pass)))
                                    {
                                        if ($user_hwid == "RESET")
                                        {
                                            $reset_hwid = mysqli_query($con, "UPDATE `users` SET `hwid` = '$hwid' WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(mysqli_error($con));

                                            if ($reset_hwid)
                                            {
                                                die(json_encode(array("status" => "hwid_reseted")));
                                            }
                                            else
                                            {
                                                die(json_encode(array("status" => "internal_error")));
                                            }
                                        }

                                        $date = new DateTime($expires);
                                        $today = new DateTime();

                                        if ($date < $today)
                                        {
                                            die(json_encode(array("status" => "subscription_expired")));
                                        }
                                        else
                                        {
                                            if ($user_banned)
                                            {
                                                die (json_encode(array("status" => "user_banned")));
                                            }
                                            else
                                            {
                                                if ($hwid == $user_hwid)
                                                {
                                                    $information = array(
                                                        "status" => "success",
                                                        "username" => $user,
                                                        "license" => $license,
                                                        "level" => $level,
                                                        "hwid" => $user_hwid,
                                                        "ip" => $ip,
                                                        "expires" => $expires                                                        
                                                    );
                                                    
                                                    die(json_encode($information));
                                                    http_response_code(200);
                                                }
                                                else
                                                {
                                                    if ($hwidlock == "1")
                                                    {
                                                        $information = array(
                                                            "status" => "invalid_hwid"
                                                        );
                                                        http_response_code(403);
                                                        die(json_encode($information));
                                                        
                                                    }
                                                    else
                                                    {
                                                        $information = array(
                                                            "status" => "success",
                                                            "username" => $user,
                                                            "license" => $license,
                                                            "level" => $level,
                                                            "hwid" => $user_hwid,
                                                            "ip" => $ip,
                                                            "expires" => $expires                                                        
                                                        );
                                                        
                                                        die(json_encode($information));
                                                        http_response_code(200);                                                        
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        http_response_code(404);
                                        die(json_encode(array("status" => "invalid_credentials")));
                                    }
                                }    
                            }
                        }
                        else
                        {
                        	http_response_code(404);
                            die(json_encode(array("status" => "Failed", "message" => "Program not found")));                            
                        }
                    }
                    else
                    {
                        http_response_code(404);         
                        die(json_encode(array("status" => "Failed", "message" => "The entered api key does not exist in our database!")));                        
                    }
                	break;         



                	case "extend_subscription":
                    $username = $datos_Decode['username'];
                    $password = $datos_Decode['password'];
                    $hwid = $datos_Decode['hwid'];
                    $license = $datos_Decode['license'];



                    $api_exist = mysqli_query($con, "SELECT * FROM `owners` WHERE `api_key` = '$api_key'") or die(mysqli_error($con));
                
                    if (mysqli_num_rows($api_exist) > 0)
                    {
                        while ($row = mysqli_fetch_array($api_exist))
                        {
                            $user_api_key = strtolower($row['username']);
                        }
                    
                        $program_exist = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or die(mysqli_error($con));
                        if (mysqli_num_rows($program_exist) > 0)
                        {
                            while ($row = mysqli_fetch_array($program_exist))
                            {
                                $owner_program_key = strtolower($row['owner']);    
                                $hwidlock = $row['hwidlock'];
                                $app_banned = ($row['banned'] == "1" ? true : false);
                            }
    
                            if ($app_banned)
                            {                            	
                                http_response_code(403);
                                die(json_encode(array("status" => "banned_app", "message" => "The developer of this program has been banned, therefore you cannot login or register.")));                                
                            }

                            if ($owner_program_key != $user_api_key)
                            {
                                http_response_code(403);
                                die(json_encode(array("status" => "Failed", "message" => "The entered API key does not belong to the application owner account.")));                                
                            }
                            else
                            {

                                $result = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(mysqli_error($con));
                                
                                if (mysqli_num_rows($result) < 1)
                                {
                                    die(json_encode(array("status" => "invalid_credentials")));
                                }
                                else if (mysqli_num_rows($result) > 0)                            
                                {
                                	while ($row = mysqli_fetch_array($result))
                                	{
                                		$user = $row['username'];
                                		$pass = $row['password'];
                                		$expires = $row['expires'];
                                		$user_banned = $row['banned'];
                                		$user_hwid = $row['hwid'];
                                	}

                                	if (strtolower($username) == strtolower($user) && (password_verify($password, $pass)))
                                	{
                                		if ($user_banned == "1")
                                		{
                                			die(json_encode(array("status" => "user_banned")));                                			
                                		}

                                		if ($hwidlock == "1")
                                		{
                                			if ($hwid != $user_hwid)
                                			{
                                				die(json_encode(array("status" => "invalid_hwid")));
                                			}                                			
                                		}

                                		$verify_license = mysqli_query($con, "SELECT * FROM `tokens` WHERE `programtoken` = '$program_key' AND `token` = '$license' AND `used` = '0'") or die(mysqli_error($con));

                                		if (mysqli_num_rows($verify_license) > 0)
                                		{
                                			while ($row = mysqli_fetch_array($verify_license))
                                			{
                                				$days = $row['days'];
                                				$level = $row['level'];
                                			}
                                		}
                                		else
                                		{
                                			die(json_encode(array("status" => "invalid_license")));
                                		}

                                		$update_license = mysqli_query($con, "UPDATE `tokens` SET `used` = '1', `used_by` = '$username' WHERE `programtoken` = '$program_key' AND `token` = '$license'") or die(mysqli_error($con));

                                		if ($update_license)
                                		{
                                			$today = new DateTime($expires);
                                			$newDate = $today->modify('+'.$days.' days');
                                			$date2 = $newDate;
                                			$Time = ''.$date2->format('Y-m-d H:i:s').'';

                                			$add_new_time = mysqli_query($con, "UPDATE `users` SET `expires` = '$Time', `level` = '$level' WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(mysqli_error($con));

                                			if ($add_new_time)
                                			{
                                				http_response_code(200);
                                				die(json_encode(array("status" => "successfully_redeemed")));
                                			}
                                			else
                                			{
                                				die(json_encode(array("status" => "Couldn't update license.")));
                                			}
                                		}
                                		else
                                		{
                                			die(json_encode(array("status" => "Couldn't update license.")))          ;                      			
                                		}
                                	}
                                	else
                                	{
                                		die(json_encode(array("status" => "invalid_credentials")));
                                	}

                                }    
                            }
                        }
                        else
                        {
                        	http_response_code(404);
                            die(json_encode(array("status" => "Failed", "message" => "Program not found")));                            
                        }
                    }
                    else
                    {
                        http_response_code(404);         
                        die(json_encode(array("status" => "Failed", "message" => "The entered api key does not exist in our database!")));                        
                    }
                	break;
                
                
                
                case "register":       
                    
                    $username = $datos_Decode['username'];
                    $password = $datos_Decode['password'];
                    $hwid = $datos_Decode['hwid'];
                    $license = $datos_Decode['license'];
                    $ip = get_client_ip();

                    $api_exist = mysqli_query($con, "SELECT * FROM `owners` WHERE `api_key` = '$api_key'") or die(mysqli_error($con));
                
                    if (mysqli_num_rows($api_exist) > 0)
                    {
                        while ($row = mysqli_fetch_array($api_exist))
                        {
                            $user_api_key = strtolower($row['username']);
                            $subscription = ($row['premium'] == "1" ? true : false);
                        }
                    
                        $program_exist = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or die(mysqli_error($con));
                        if (mysqli_num_rows($program_exist) > 0)
                        {
                            while ($row = mysqli_fetch_array($program_exist))
                            {
                                $owner_program_key = strtolower($row['owner']);    
                                $hwidlock = $row['hwidlock'];
                                $app_banned = ($row['banned'] == "1" ? true : false);                                
                            }
    
                            if ($app_banned)
                            {
                                $information = array(
                                    "status" => "banned_app",
                                    "message" => "The developer of this program has been banned, therefore you cannot login or register."
                                );
                                http_response_code(403);
                                die(json_encode($information));                                

                            }

                            if ($owner_program_key != $user_api_key)
                            {
                                $information = array(
                                    "status" => "Forbidden",
                                    "code" => 403,
                                    "message" => "The entered API key does not belong to the application owner account."
                                    );
                                
                                echo json_encode($information);
                                http_response_code(403);
                            }
                            else
                            {                                

                                $verify_user = mysqli_query($con, "SELECT `username` FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or die(mysqli_error($con));
                            
                                if (mysqli_num_rows($verify_user) > 0)
                                {
                                    $information = array(
                                        "status" => "Username already in use."
                                    );

                                    http_response_code(401);
                                    die(json_encode($information));
                                }
                                else if ($subscription)
                                {
                                    $app_users = mysqli_query($con, "SELECT * FROM `users` WHERE `programtoken` = '$program_key'") or die(mysqli_error($con));
                                    if (mysqli_num_rows($app_users) > 5000)
                                    {
                                        http_response_code(426);
                                        die(json_encode(array("status" => "Program owner has exceeded their max user quota.")));
                                    }
                                }
                                else if (!$subscription)
                                {
                                    $app_users = mysqli_query($con, "SELECT * FROM `users` WHERE `programtoken` = '$program_key'") or die(mysqli_error($con));
                                    if (mysqli_num_rows($app_users) > 5000)
                                    {
                                        http_response_code(426);
                                        die(json_encode(array("status" => "Program owner has exceeded their max user quota.")));
                                    }
                                }


                                $token_check = mysqli_query($con, "SELECT * FROM `tokens` WHERE `programtoken` = '$program_key' AND `token` = '$license' AND `used` = '0'") or die(mysqli_error($con));

                                if (mysqli_num_rows($token_check) > 0)
                                {
                                    while ($row = mysqli_fetch_array($token_check))
                                    {
                                        $days = $row['days'];
                                        $level = $row['level'];                                            
                                    }

                                    $update_license = mysqli_query($con, "UPDATE `tokens` SET `used` = '1', `used_by` = '$username' WHERE `programtoken` = '$program_key' AND `token` = '$license'") or die(mysqli_error($con));
                                    if ($update_license)
                                    {
                                        $update_user = mysqli_query($con, "UPDATE `programs` SET `clients` = clients + 1 WHERE `authtoken` = '$program_key'") or die(mysqli_error($con));

                                        if ($update_user)
                                        {
                                            $today = new DateTime();
                                            $newDate = $today->modify('+'.$days.' days');
                                            $date2 = $newDate;
                                            $Time = ''.$date2->format('Y-m-d H:i:s').'';

                                            $pass_encrypted = password_hash($password, PASSWORD_BCRYPT);

                                            $register_user = mysqli_query($con, "INSERT INTO `users` (username, password, email, level, expires, hwid, ip, banned, programtoken)
                                            VALUES ('$username', '$pass_encrypted', '$license', '$level', '$Time', '$hwid', '$ip', '0', '$program_key')") or die(mysqli_error($con));

                                            if ($register_user)
                                            {
                                                die(json_encode(array("status" => "successfully_registered")));
                                                http_response_code(200);                                                    
                                            }
                                        }
                                        else
                                        {
                                            die(json_encode(array("status" => "internal_error")));
                                            http_response_code(403);
                                        }
                                    }
                                    else
                                    {
                                        die(json_encode(array("status" => "Couldn't update license.")));
                                        http_response_code(403);  
                                    }
                                }
                                else
                                {
                                    die(json_encode(array("status" => "Invalid_license")));
                                    http_response_code(404);
                                } 
                            }
                        }
                        else
                        {
                            $information = array(
                                "status" => "Not Found",
                                "code" => 404,
                                "message" => "Program not found!"
                                );
                            
                            echo json_encode($information);
                            http_response_code(404);
                        }
                    }
                    else
                    {
                        $information = array(
                            "status" => "Not Found",
                            "code" => 404,
                            "message" => "The entered api key does not exist in our database!"
                            );
                            
                        echo json_encode($information);
                        http_response_code(404);         
                    }
                break;                   
                
                
                
                
                
            }
            
        }
    
    
        // otras acciones

    
        // else final
        else
        {
            $information = array(
                "error" => "Method Not Allowed",
                "code" => 405,
                "message" => "The action does not exist."
            );
            echo json_encode($information);
        }
    }
}
else
{
    $information = array(
        "error" => "Unauthorized",
        "code" => 401,
        "message" => "Failed connection, check authorization data."
    );
    echo json_encode($information);
}


?>