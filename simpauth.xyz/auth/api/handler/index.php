<?php
include '../../includes/settings.php';
if ($_SERVER['HTTP_USER_AGENT'] !== "SimpAuth.V2")
{
    header("Location: https://beta.simpauth.xyz");
    die();
}
class AES
	{
		var $key = "";
		function __construct($SecretKey)
		{
			$this->key=$this->Pass2Key($SecretKey);
		}
		function Pass2Key($SecretKey)
		{
			return substr(base64_encode(pack('H*',hash("sha512", $SecretKey))), 0, 32);
		}
		function Encrypt($string = "")
		{
			return rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->key, $string, MCRYPT_MODE_CBC, $this->key)));
		}
		function Decrypt($string = "")
		{
			return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->key, base64_decode($string), MCRYPT_MODE_CBC, $this->key));
		}
	}
    function getRealIP() {
    
            if (!empty($_SERVER['HTTP_CLIENT_IP']))
                return $_SERVER['HTTP_CLIENT_IP'];
               
            if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
           
            return $_SERVER['REMOTE_ADDR'];
    }
    function Encrypt($data, $enckey)
    {
        $cipher=new AES($enckey);
        $encrypted=$cipher->Encrypt($data);
        return $encrypted;
    }
    function getEncKey($program)
    {
        $servername = "185.201.11.181";
        $username = "u402869651_simpauth";
        $password = "HarvestGeek2!";
        
        try {
          $conn = new PDO("mysql:host=$servername;dbname=u402869651_simpauth", $username, $password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
          echo 'Error';
          die();
        }
        $sql = "SELECT * FROM `programs` WHERE `authtoken` = '$program'";
        $result = $conn->query($sql);
        $row = $result->fetchAll(PDO::FETCH_COLUMN, 4);
        $encryptionkey = $row[0];
        return "$encryptionkey";
    }
    function SendEncryptedResponse($text)
    {
        print_r(Encrypt($text, getEncKey($_POST['program'])));
    }
    if ($_POST['data'] != "")
    {
        $pro = rawurldecode($_POST['program']);
        $data = rawurldecode($_POST['data']);
        $decoded = json_decode(base64_decode($_POST['data'], $_POST['program']));
        
	    $action = $decoded->{"action"};
	    $program_key = $decoded->{"application_id"};
	    $ip_visitor = getRealIP();

        switch ($action)
        {
            case "initialize":
                $verify_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or  SendEncryptedResponse(json_encode(array("action" => "internal_error"))); 
                    
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
                        SendEncryptedResponse(json_encode(array("action" => "banned_app")));
                    }
                    else
                    {
                        SendEncryptedResponse(json_encode(array(
                                "action" => "initialize",
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
                        )));
                    }
                }
                else
                {
                    SendEncryptedResponse(json_encode(array("action" => "unfound_application")));
                }
                break;
                
            case "login":
                $username = $decoded->{"username"};
                $password  = $decoded->{"password"};
                $hwid  = $decoded->{"hwid"};
                $timestamp  = $decoded->{"date"};
    
                if (empty($username) || empty($password) || empty($hwid) || empty($timestamp))
                {
                    SendEncryptedResponse(json_encode(array("action" => "null_entry")));
                }
    
                $verify_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or  SendEncryptedResponse(json_encode(array("action" => "internal_error"))); 
    
                if (mysqli_num_rows($verify_program) > 0)
                {
                    while ($row_app = mysqli_fetch_array($verify_program))
                    {
                        $hwid_lock = $row_app['hwidlock'];
                        $banned_app = $row_app['banned'];
                    }
    
                    if ($banned_app == "1")
                    {
                        SendEncryptedResponse(json_encode(array("action" => "banned_app")));
                    }
    
                    $user_verify = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error"))); 
                    if (mysqli_num_rows($user_verify) < 1)
                    {
                        SendEncryptedResponse(json_encode(array(
                            "action" => "login",
                            "status" => "incorrect_details")));
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
                                $update_hwid = mysqli_query($con, "UPDATE `users` SET `hwid` = '$hwid' WHERE `username` = '$username' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                                if ($update_hwid)
                                {
                                    SendEncryptedResponse(json_encode(array(
                                        "action" => "login",
                                        "status" => "hwid_reseted")));                                    
                                }
                                else
                                {
                                    SendEncryptedResponse(json_encode(array("action" => "internal_error")));    
                                }
                            }
    
                            $date = new DateTime($expires);
                            $today = new DateTime();
    
                            if ($date < $today)
                            {
                                SendEncryptedResponse(json_encode(array(
                                    "action" => "login",
                                    "status" => "expired_time")));
                            }
                            else
                            {
                                if ($isbanned == "1")
                                {
                                    SendEncryptedResponse(json_encode(array(
                                        "action" => "login",
                                        "status" => "banned_user")));
                                }
                                else
                                {
                                    if ($hwid_lock == "1")
                                    {
                                        if ($hwid != $user_hwid || $hwid !== $user_hwid)
                                        {
                                            SendEncryptedResponse(json_encode(array(
                                                "action" => "login",
                                                "status" => "incorrect_hwid")));
                                        }
                                    }
    
                                    SendEncryptedResponse(json_encode(array(
                                        "action" => "login",
                                        "status" => "success",
                                        "username" => $user,
                                        "license" => $license,
                                        "level" => $level,
                                        "expires" => $expires,
                                        "hwid" => $user_hwid,
                                        "ip" =>  $ip,
                                        "timestamp" => $timestamp
                                    )));
                                }
                            }
                        }
                        else
                        {
                            SendEncryptedResponse(json_encode(array(
                                "action" => "login",
                                "status" => "incorrect_details")));                            
                        }
                    }
                }
                break;

                case "register":
                    $username = $decoded->{"username"};
                    $password = $decoded->{"password"};
                    $hwid = $decoded->{"hwid"};
                    $license = $decoded->{"license"};  
                    $ip = $decoded->{"ip"};
                    
                    if (empty($username) || empty($password) || empty($hwid) || empty($license))
                    {
                        SendEncryptedResponse(json_encode(array("action" => "null_entry")));
                    }
    
                    $program_verify = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
    
                    if (mysqli_num_rows($program_verify) < 1)
                    {
                        SendEncryptedResponse(json_encode(array("action" => "unfound_application")));
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
                            SendEncryptedResponse(json_encode(array(
                                "action" => "banned_app")));                        
                        }
    
                        if (mysqli_num_rows($program_verify) > 0)
                        {
                            $user_verify = mysqli_query($con, "SELECT `username` FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
    
                            if (mysqli_num_rows($user_verify) > 0)
                            {
                                SendEncryptedResponse(json_encode(array(
                                    "action" => "register",
                                    "status" => "username_used")));
                            }
                            else
                            {
                                $grab_info = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$app_owner'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
    
                                while ($row_owner = mysqli_fetch_array($grab_info))
                                {
                                    $subscription = $row_owner['premium'];
                                }
    
                                $maximum_users = mysqli_query($con, "SELECT * FROM `users` WHERE `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                                if ($subscription == "1")
                                {
                                    if (mysqli_num_rows($maximum_users) > 5000)
                                    {
                                        SendEncryptedResponse(json_encode(array(
                                            "action" => "register",
                                            "status" => "max_quote")));
                                    }
                                }
                                else if ($subscription == "0")
                                {
                                    if (mysqli_num_rows($maximum_users) > 50)
                                    {
                                        SendEncryptedResponse(json_encode(array(
                                            "action" => "register",
                                            "status" => "max_quote")));
                                    }
                                }
    
                                $license_verify = mysqli_query($con, "SELECT * FROM `tokens` WHERE `programtoken` = '$program_key' AND `token` = '$license' AND `used` = '0'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
    
                                if (mysqli_num_rows($license_verify) > 0)
                                {
                                    while ($row_license = mysqli_fetch_array($license_verify))
                                    {
                                        $days = $row_license['days'];
                                        $level = $row_license['level'];
                                    }
    
                                    $update_license = mysqli_query($con, "UPDATE `tokens` SET `used` = '1', `used_by` = '$username' WHERE `programtoken` = '$program_key' AND `token` = '$license'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
    
                                    if ($update_license)
                                    {
                                        $update_user = mysqli_query($con, "UPDATE `programs` SET `clients` = clients + 1 WHERE `authtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
    
                                        if ($update_user)
                                        {
                                            $today = new DateTime();
                                            $new_date = $today->modify('+'.$days.' days');
                                            $date_2 = $new_date;
                                            $Time = ''.$date_2->format('Y-m-d H:i:s').'';
    
                                            $pass_encrypted = password_hash($password, PASSWORD_BCRYPT);
    
                                            $add_user = mysqli_query($con, "INSERT INTO `users` (username, password, email, level, expires, hwid, ip, banned, programtoken)
                                            VALUES ('$username', '$pass_encrypted', '$license', '$level', '$Time', '$hwid', '$ip', '0', '$program_key')") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
    
                                            if ($add_user)
                                            {
                                                SendEncryptedResponse(json_encode(array(
                                                    "action" => "register",
                                                    "status" => "success",
                                                    "username" => $username,
                                                    "expires" => $Time,
                                                    "level" => $level
                                                )));
                                            }
                                        }
                                        else
                                        {
                                            SendEncryptedResponse(json_encode(array(
                                                "action" => "internal_error"
                                            )));
                                        }
                                    }
                                    else
                                    {
                                        SendEncryptedResponse(json_encode(array(
                                            "action" => "internal_error",
                                        )));                                    
                                    }
                                }
                                else
                                {
                                    SendEncryptedResponse(json_encode(array(
                                        "action" => "register",
                                        "status" => "invalid_license"
                                    )));                                 
                                }
                            }
    
                        }
                        else
                        {
                            SendEncryptedResponse(json_encode(array(
                                "action" => "unfound_application"
                            )));
                        }
                    }
                break;
                
                
                case "extend_subscription":
                    $username = $decoded->{"username"};
                    $password = $decoded->{"password"};
                    $hwid = $decoded->{"hwid"};
                    $license = $decoded->{"license"};     
                    
                    if (empty($username) || empty($password) || empty($hwid) || empty($license))
                    {
                        SendEncryptedResponse(json_encode(array(
                            "action" => "null_entry"
                        )));
                    }
                    
                    $verify_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                    
                    if (mysqli_num_rows($verify_program) > 0)
                    {
                        while ($app_row = mysqli_fetch_array($verify_program))
                        {
                            $app_hwidlock = $app_row['hwidlock'];
                        }
    
                        $verify_user = mysqli_query($con, "SELECT `username` FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                        if (mysqli_num_rows($verify_user) <= 0)
                        {
                            SendEncryptedResponse(json_encode(array(
                                "action" => "extend_subscription",
                                "status" => "incorrect_details"
                            )));
                        }
                        else
                        {
                            $user_info = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
    
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
                                    SendEncryptedResponse(json_encode(array(
                                        "action" => "extend_subscription",
                                        "status" => "banned_user"
                                    )));
                                }
    
                                if ($app_hwidlock == "1")
                                {
                                    if ($hwid != $user_hwid)
                                    {
                                        die(Encrypt(json_encode(array(
                                            "action" => "extend_subscription",
                                            "status" => "incorrect_hwid"
                                        ))));
                                    }
                                }
    
                                $license_verify = mysqli_query($con, "SELECT * FROM `tokens` WHERE `programtoken` = '$program_key' AND `token` = '$license' AND `used` = '0'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
    
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
                                    SendEncryptedResponse(json_encode(array(
                                        "action" => "extend_subscription",
                                        "status" => "incorrect_license"
                                    )));
                                }
    
                                $update_license = mysqli_query($con, "UPDATE `tokens` SET `used` = '1', `used_by` = '$username' WHERE `programtoken` = '$program_key' AND `token` = '$license'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
    
                                if ($update_license)
                                {
                                    $today = new DateTime($expires);
                                    $new_date = $today->modify('+'.$days.' days');
                                    $date_2 = $new_date;
                                    $Time = ''.$date_2->format('Y-m-d H:i:s');
    
                                    $add_license = mysqli_query($con, "UPDATE `users` SET `expires` = '$Time', `level` = '$level' WHERE `username` = '$username' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
    
                                    if ($add_license)
                                    {
                                        SendEncryptedResponse(json_encode(array(
                                            "action" => "extend_subscription",
                                            "status" => "success"
                                        )));
                                    }
                                }
                                else
                                {
                                    SendEncryptedResponse(json_encode(array(
                                        "action" => "internal_error"
                                    )));
                                }
                            }
                            else
                            {
                                SendEncryptedResponse(json_encode(array(
                                    "action" => "extend_subscription",
                                    "status" => "incorrect_details"
                                )));
                            }
                        }
    
    
                    }
                    else
                    {
                        SendEncryptedResponse(json_encode(array(
                            "action" => "unfound_application"
                        )));
                    }
                break;
                
                
                case "var":
                    $username = $decoded->{"username"};
                    $password = $decoded->{"password"};
                    $hwid = $decoded->{"hwid"};
                    $variable_key = $decoded->{"variable_key"};
                    $variable_name = $decoded->{"variable_name"};

    
                    if (empty($variable_key) || empty($variable_name) || empty($username) || empty($password) || empty($hwid))
                    {
                        SendEncryptedResponse(json_encode(array(
                            "action" => "null_entry"
                        )));
                    }
    
                    $verify_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                    if (mysqli_num_rows($verify_program) > 0)
                    {
                        $result = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                
                        while ($row = mysqli_fetch_array($verify_program))
                        {
                            $hwidlock = $row['hwidlock'];
                        }
                
                        if (mysqli_num_rows($result) < 1)
                        {
                            SendEncryptedResponse(json_encode(array(
                                "action" => "var",
                                "status" => "incorrect_details")));                            
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
                                $license = $row_2['email'];
                            }
                
                            if (strtolower($username) == strtolower($user) && (password_verify($password, $pass)))
                            {
                                if ($hwidd == "RESET")
                                {
                                    $update_hwid = mysqli_query($con, "UPDATE `users` SET `hwid` = '$hwid' WHERE `username` = '$username' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                                    if ($update_hwid)
                                    {
                                         
                                    }   
                                    else
                                    {
                                        SendEncryptedResponse(json_encode(array(
                                            "action" => "internal_error")));
                                    }
                                }
                
                
                                $date = new DateTime($expires);
                                $today = new DateTime();
                                
                                if ($date < $today)
                                {
                                    SendEncryptedResponse(json_encode("subscription_expired"));
                                }
                                else
                                {
                                    if ($isbanned == "1")
                                    {
                                        SendEncryptedResponse(json_encode("banned_user"));
                                    }
                                    else
                                    {
                                        if ($hwid == $hwidd)
                                        {
                                            $check_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `variablekey` = '$variable_key' AND `authtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                
                
                                            if (mysqli_num_rows($check_program) > 0)
                                            {
                                                $encrypted_var = array();
                                                $select_variable = mysqli_query($con, "SELECT * FROM `vars` WHERE `name` = '$variable_name' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                                                                                
                                                if ($select_variable)
                                                {
                                                    if (mysqli_num_rows($select_variable) < 1)
                                                    {
                                                        SendEncryptedResponse(json_encode(array(
                                                            "action" => "var",
                                                            "status" => "unfound_variable"
                                                        )));
                                                        
                                                    }
                                                    else if (mysqli_num_rows($select_variable) > 0)
                                                    {
                                                        $var_nvalue;
                
                                                        while ($select = mysqli_fetch_array($select_variable))
                                                        {
                                                            $var_nvalue = $select['value'];
                                                        }
                                                        
                                                        SendEncryptedResponse(json_encode(array(
                                                            "action" => "var",
                                                            "status" => "success",
                                                            "var_name" => $variable_name,
                                                            "var_value" => $var_nvalue
                                                        )));
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                
                
                            }
                            else
                            {
                                SendEncryptedResponse(json_encode(array(
                                    "action" => "var",
                                    "status" => "incorrect_details")));                                 
                            }
                            
                        }
                
                    }
                break;
                
                
                case "variable":
                    $username = $decoded->{"username"};
                    $password = $decoded->{"password"};
                    $hwid = $decoded->{"hwid"};
                    $variable_code = $decoded->{"variable_code"};

    
                    if (empty($username) || empty($variable_code) || empty($password) || empty($hwid))
                    {
                        SendEncryptedResponse(json_encode(array(
                            "action" => "null_entry"
                        )));
                    }
    
                    $verify_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                    if (mysqli_num_rows($verify_program) > 0)
                    {
                        $result = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                
                        while ($row = mysqli_fetch_array($verify_program))
                        {
                            $hwidlock = $row['hwidlock'];
                        }
                
                        if (mysqli_num_rows($result) < 1)
                        {
                            SendEncryptedResponse(json_encode(array(
                                "action" => "var",
                                "status" => "incorrect_details")));                            
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
                                $license = $row_2['email'];
                            }
                
                            if (strtolower($username) == strtolower($user) && (password_verify($password, $pass)))
                            {
                                if ($hwidd == "RESET")
                                {
                                    $update_hwid = mysqli_query($con, "UPDATE `users` SET `hwid` = '$hwid' WHERE `username` = '$username' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                                    if (!$update_hwid)
                                    {
                                        SendEncryptedResponse(json_encode(array(
                                            "action" => "internal_error")));
                                    }
                                }
                
                
                                $date = new DateTime($expires);
                                $today = new DateTime();
                                
                                if ($date < $today)
                                {
                                    SendEncryptedResponse(json_encode("subscription_expired"));
                                }
                                else
                                {
                                    if ($isbanned == "1")
                                    {
                                        SendEncryptedResponse(json_encode("banned_user"));
                                    }
                                    else
                                    {
                                        if ($hwid == $hwidd)
                                        {

                
                                                $encrypted_var = array();
                                                $select_variable = mysqli_query($con, "SELECT * FROM `vars` WHERE `code` = '$variable_code' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                                                                                
                                                if ($select_variable)
                                                {
                                                    if (mysqli_num_rows($select_variable) < 1)
                                                    {
                                                        SendEncryptedResponse(json_encode(array(
                                                            "action" => "var",
                                                            "status" => "unfound_variable"
                                                        )));
                                                        
                                                    }
                                                    else if (mysqli_num_rows($select_variable) > 0)
                                                    {
                                                        $var_nvalue;
                
                                                        while ($select = mysqli_fetch_array($select_variable))
                                                        {
                                                            $var_nvalue = $select['value'];
                                                        }
                                                        
                                                        SendEncryptedResponse(json_encode(array(
                                                            "action" => "var",
                                                            "status" => "success",
                                                            "code" => $variable_code,
                                                            "var_value" => $var_nvalue
                                                        )));
                                                    }
                                                }
                                        }
                                    }
                                }
                
                
                            }
                            else
                            {
                                SendEncryptedResponse(json_encode(array(
                                    "action" => "var",
                                    "status" => "incorrect_details")));                                 
                            }
                            
                        }
                
                    }
                break;                
                
                
                
                case "licenseLogin":
                $license_key = $decoded->{"license"};
                $hwid  = $decoded->{"hwid"};
                $timestamp  = $decoded->{"date"};
                $ip = $decoded->{"ip"};
                
                if (empty($license_key) || empty($hwid) || empty($timestamp))
                {
                    SendEncryptedResponse(json_encode(array("action" => "null_entry")));
                }
    
                $verify_program = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_key'") or  SendEncryptedResponse(json_encode(array("action" => "internal_error"))); 
    
                if (mysqli_num_rows($verify_program) > 0)
                {
                
                    while ($row_app = mysqli_fetch_array($verify_program))
                    {
                        $hwid_lock = $row_app['hwidlock'];
                        $banned_app = $row_app['banned'];
                    }
    
                    if ($banned_app == "1")
                    {
                        SendEncryptedResponse(json_encode(array("action" => "banned_app")));
                    }
    
                    // Verifica si existe el usuario..
                    $user_verify = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$license_key' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error"))); 
                    if (mysqli_num_rows($user_verify) < 1) // Si no existe..
                    {
                        // verifica si la licencia existe
                        $license_verify = mysqli_query($con, "SELECT * FROM `tokens` WHERE `programtoken` = '$program_key' AND `token` = '$license_key' AND `used` = '0'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                        
                        // si es que existe..
                        if (mysqli_num_rows($license_verify) > 0)
                        {
                            
                            // agarra el days y el level
                            while ($row_lic = mysqli_fetch_array($license_verify))
                            {
                                $days = $row_lic['days'];
                                $level = $row_lic['level'];
                            }
                            
                            // Agrega que la licencia fue usada..
                            $update_license = mysqli_query($con, "UPDATE `tokens` SET `used` = '1', `used_by` = '$license_key' WHERE `programtoken` = '$program_key' AND `token` = '$license_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                            if ($update_license)
                            {
                                $today = new DateTime();
                                $new_date = $today->modify('+'.$days.' days');
                                $date_2 = $new_date; 
                                $Time = ''.$date_2->format('Y-m-d H:i:s').'';
    
                                $password_encrypted = password_hash($license_key, PASSWORD_BCRYPT);
                                $add_license = mysqli_query($con, "INSERT INTO `users` (username, password, email, level, expires, hwid, ip, banned, programtoken)
                                VALUES ('$license_key', '$password_encrypted', '$license_key', '$level', '$Time', '$hwid', '$ip', '0', '$program_key')") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
    
                                if ($add_license)
                                {
                                    $user_verify2 = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$license_key' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error"))); 
                                    
                                    while ($row_license_info = mysqli_fetch_array($user_verify2))
                                    {
                                        $level = $row_license_info['level'];
                                        $lichwid = $row_license_info['hwid'];
                                        $isbanned = $row_license_info['banned'];
                                        $expires = $row_license_info['expires'];
                                        $ip = $row_license_info['ip'];
                                    }
                                    
                                    
                                    $date = new DateTime($expires);
                                    $today = new DateTime();
                
                                    if ($date < $today)
                                    {
                                        SendEncryptedResponse(json_encode(array(
                                            "action" => "licenseLogin",
                                            "status" => "expired_time")));
                                    }
                                    else
                                    {
                                        if ($isbanned == "1")
                                        {
                                            SendEncryptedResponse(json_encode(array(
                                                "action" => "licenseLogin",
                                                "status" => "banned_user")));
                                        }
                                        else
                                        {
                                            if ($hwid_lock == "1")
                                            {
                                                if ($lichwid == "RESET")
                                                {
                                                    $update_hwid = mysqli_query($con, "UPDATE `users` SET `hwid` = '$hwid' WHERE `username` = '$license_key' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                                                    if ($update_hwid)
                                                    {
                                                        SendEncryptedResponse(json_encode(array(
                                                            "action" => "licenseLogin",
                                                            "status" => "success",
                                                            "license" => $license_key,
                                                            "level" => $level,
                                                            "expires" => $expires,
                                                            "hwid" => $hwid,
                                                            "ip" => $ip
                                                        )));                                   
                                                    }
                                                    else
                                                    {
                                                        SendEncryptedResponse(json_encode(array("action" => "internal_error")));    
                                                    }                            
                                                }
                                                
                                                if ($hwid != $lichwid || $hwid !== $lichwid)
                                                {
                                                    SendEncryptedResponse(json_encode(array(
                                                        "action" => "licenseLogin",
                                                        "status" => "incorrect_hwid")));
                                                }
                                            }
                
                                            SendEncryptedResponse(json_encode(array(
                                                "action" => "licenseLogin",
                                                "status" => "success",
                                                "license" => $license_key,
                                                "level" => $level,
                                                "expires" => $expires,
                                                "hwid" => $hwid,
                                                "ip" =>  $ip
                                            )));
                                        }
                                    }                                    
                                    
                                }
                            }
                            else
                            {
                                SendEncryptedResponse(json_encode(array(
                                    "action" => "internal_error"
                                )));
                            }
                            
                        }
                        else
                        {
                            SendEncryptedResponse(json_encode(array(
                                "action" => "licenseLogin",
                                "status" => "incorrect_details")));                            
                        }
                    }
                    else if (mysqli_num_rows($user_verify) > 0)
                    {
                        while ($row_license_info = mysqli_fetch_array($user_verify))
                        {
                            $level = $row_license_info["level"];
                            $lichwid = $row_license_info["hwid"];
                            $isbanned = $row_license_info["banned"];
                            $expires = $row_license_info["expires"];
                            $ip = $row_license_info["ip"];
                        }
                        if ($lichwid == "RESET")
                        {
                            $update_hwid = mysqli_query($con, "UPDATE `users` SET `hwid` = '$hwid' WHERE `username` = '$license_key' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                            if ($update_hwid)
                            {
                                SendEncryptedResponse(json_encode(array(
                                    "action" => "licenseLogin",
                                    "status" => "success",
                                    "license" => $license_key,
                                    "level" => $level,
                                    "expires" => $expires,
                                    "hwid" => $hwid,
                                    "ip" =>  $ip
                                )));                                   
                            }
                            else
                            {
                                SendEncryptedResponse(json_encode(array("action" => "internal_error")));    
                            }                            
                        }
                        
                        
                        $date = new DateTime($expires);
                        $today = new DateTime();
    
                        if ($date < $today)
                        {
                            SendEncryptedResponse(json_encode(array(
                                "action" => "licenseLogin",
                                "status" => "expired_time")));
                        }
                        else
                        {
                            if ($isbanned == "1")
                            {
                                SendEncryptedResponse(json_encode(array(
                                    "action" => "licenseLogin",
                                    "status" => "banned_user")));
                            }
                            else
                            {
                                if ($hwid_lock == "1")
                                {
                                    
                                        if ($lichwid == "RESET")
                                        {
                                            $update_hwid = mysqli_query($con, "UPDATE `users` SET `hwid` = '$hwid' WHERE `username` = '$license_key' AND `programtoken` = '$program_key'") or SendEncryptedResponse(json_encode(array("action" => "internal_error")));
                                            if ($update_hwid)
                                            {
                                                SendEncryptedResponse(json_encode(array(
                                                    "action" => "licenseLogin",
                                                    "status" => "success",
                                                    "license" => $license_key,
                                                    "level" => $level,
                                                    "expires" => $expires,
                                                    "hwid" => $hwid,
                                                    "ip" =>  $ip
                                                )));                                   
                                            }
                                            else
                                            {
                                                SendEncryptedResponse(json_encode(array("action" => "internal_error")));    
                                            }                            
                                        }                                    
                                    
                                    if ($hwid != $lichwid || $hwid !== $lichwid)
                                    {
                                        SendEncryptedResponse(json_encode(array(
                                            "action" => "licenseLogin",
                                            "status" => "incorrect_hwid")));
                                    }
                                }
    
                                SendEncryptedResponse(json_encode(array(
                                    "action" => "licenseLogin",
                                    "status" => "success",
                                    "license" => $license_key,
                                    "level" => $level,
                                    "expires" => $expires,
                                    "hwid" => $lichwid,
                                    "ip" =>  $ip
                                )));
                            }
                        }
                    }
                }                    
                break;
            
        }
    }
    else
    {
        die(json_encode(array("status" => "error", "message" => "Action not found", "code" => "404")));
    }


function xss_clean($data)
{
	return strip_tags($data);
}

?>