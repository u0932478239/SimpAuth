<?php
include '../includes/settings.php';
//error_reporting(0);

if(!strlen(strstr($_SERVER['HTTP_USER_AGENT'],"Akiza_Session")) <= 0 ) {

$username = xss_clean(mysqli_real_escape_string($con, $_POST['username']));
$password = xss_clean(mysqli_real_escape_string($con, $_POST['password']));
$hwid = xss_clean(mysqli_real_escape_string($con, $_POST['hwid']));
$programid = xss_clean(mysqli_real_escape_string($con, $_POST['program_key']));
$token = xss_clean(mysqli_real_escape_string($con, $_POST['license']));
$ip = $_SERVER['REMOTE_ADDR'];

$username = str_replace("#", "+", $username);
$password = str_replace("#", "+", $password);
$hwid = str_replace("#", "+", $hwid);
$programid = str_replace("#", "+", $programid);
$token = str_replace("#", "+", $token);

$username = Decrypt($username);
$password = Decrypt($password);
$hwid = Decrypt($hwid);
$programid = Decrypt($programid);
$token = Decrypt($token);

$username = str_replace("'", "", $username);
$password = str_replace("'", "", $password);
$hwid = str_replace("'", "", $hwid);
$programid = str_replace("'", "", $programid);
$token = str_replace("'", "", $token);

$sqlerror = Encrypt(json_encode(array("status" => "error", "info" => "SQL error.")));
$progsecret = Encrypt(json_encode(array("status" => "error", "info" => "Program secret doesn't exist")));
$usertaken = Encrypt(json_encode(array("status" => "error", "info" => "Username doesn't exist!")));
$invalidtoken = Encrypt(json_encode(array("status" => "error", "info" => "Invalid license.")));
$finaleerror = Encrypt(json_encode(array("status" => "error", "info" => "Unable to update expired time.")));
$tokenerror = Encrypt(json_encode(array("status" => "error", "info" => "Couldn't update license.")));
$banned = Encrypt(json_encode(array("status" => "error", "info" => "Your account is banned!")));
$incorrecthwid = Encrypt(json_encode(array("status" => "error", "info" => "Incorrect hwid!")));
$bruh = Encrypt(json_encode(array("status" => "error", "info" => "Incorrect username or password.")));
$nullentry = Encrypt(json_encode(array("status" => "error", "info" => "Please fill in all fields before attempting to register!")));

if(empty($username) || empty($password) || empty($hwid) || empty($programid) || empty($token)){
    die($nullentry);
}

$checkprogram = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$programid'") or die(Encrypt($sqlerror));
if(mysqli_num_rows($checkprogram) > 0){
    
while($row1 = mysqli_fetch_array($checkprogram)){
        $hwidlock = $row1['hwidlock'];
      }
    
$user_check = mysqli_query($con, "SELECT `username` FROM `users` WHERE `username` = '$username' AND `programtoken` = '$programid'") or die(mysqli_error($con));
  
$do_user_check = mysqli_num_rows($user_check);
  
if($do_user_check <= 0){
die($usertaken);
}
else{
    $ultimate_bruh = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' AND `programtoken` = '$programid'") or die(mysqli_error($con));
    while($row = mysqli_fetch_array($ultimate_bruh)){
    $user = $row['username'];
    $pass = $row['password'];
    $expiresbruh = $row['expires'];
    $isbanned = $row['banned'];
    $hwidd = $row['hwid'];
    }
if(strtolower($username) == strtolower($user) && (password_verify($password, $pass))){

if ($isbanned == 1){
  die($banned);
}

if($hwidlock == 1) {
if ($hwid == $hwidd){
  
}
else{
    die($incorrecthwid);
}
}

$checktoken = mysqli_query($con, "SELECT * FROM `tokens` WHERE `programtoken` = '$programid' AND `token` = '$token' AND `used` = '0'") or die(Encrypt($sqlerror));
if(mysqli_num_rows($checktoken) > 0){
while($row = mysqli_fetch_array($checktoken)){
    $days = $row['days'];
    $level = $row['level'];
}

}
else{
    die($invalidtoken);
}

$updatetoken = mysqli_query($con, "UPDATE `tokens` SET `used` = '1', `used_by` = '$username' WHERE `programtoken` = '$programid' AND `token` = '$token'") or die(Encrypt($sqlerror));
if ($updatetoken) {
$today = new DateTime($expiresbruh);
$newDate = $today->modify('+'.$days.' days');
$date2 = $newDate;
$TIME = ''.$date2->format('Y-m-d H:i:s').'';


$addshit = mysqli_query($con, "UPDATE `users` SET `expires` = '$TIME', `level` = '$level' WHERE `username` = '$username' AND `programtoken` = '$programid'") or die(mysqli_error($con));
if ($addshit){
$success = Encrypt(json_encode(array("status" => "success", "info" => "Successfully redeemed token!", "username" => $username, "expires" => $TIME)));
die($success);
}
else{
    die($tokenerror);
}
}
else{
    die($tokenerror);
}

//success

}
else{
    die($bruh);
}
}
}
else{
    die($progsecret);
}

}
else{
    header("Location: https://akiza.io/");    
    die("");
}



function SaltString($string){
    $string = str_replace("z", "?", $string);
    $string = str_replace("a", "!", $string);
    $string = str_replace("b", "}", $string);
    $string = str_replace("c", "{", $string);
    $string = str_replace("d", "]", $string);
    $string = str_replace("e", "[", $string);
    return $string;
}

function DesaltString($string){
    $string = str_replace("?", "z", $string);
    $string = str_replace("!", "a", $string);
    $string = str_replace("}", "b", $string);
    $string = str_replace("{", "c", $string);
    $string = str_replace("]", "d", $string);
    $string = str_replace("[", "e", $string);
    return $string;
}

    function Encrypt($string)
		{
           $plaintext = $string;
           $password = base64_decode(DesaltString($_POST['session_key']));
           $method = 'aes-256-cbc';
           $password = substr(hash('sha256', $password, true), 0, 32);
           $iv = base64_decode(DesaltString($_POST['session_iv']));
           $encrypted = base64_encode(openssl_encrypt($plaintext, $method, $password, OPENSSL_RAW_DATA, $iv));
           return $encrypted;
		}
		function Decrypt($string)
		{
           $plaintext = $string;
           $password = base64_decode(DesaltString($_POST['session_key']));
           $method = 'aes-256-cbc';
           $password = substr(hash('sha256', $password, true), 0, 32);
           $iv = base64_decode(DesaltString($_POST['session_iv']));
           $decrypted = openssl_decrypt(base64_decode($plaintext), $method, $password, OPENSSL_RAW_DATA, $iv);
           return $decrypted;
		}
   function xss_clean($data)
  {
     return strip_tags($data);
  }




?>