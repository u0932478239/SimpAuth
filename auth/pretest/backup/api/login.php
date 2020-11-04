<?php
include '../includes/settings.php';
error_reporting(0);
if(!strlen(strstr($_SERVER['HTTP_USER_AGENT'],"Akiza_Session")) <= 0 ) {
$username = strip_tags(trim(xss_clean(mysqli_real_escape_string($con, $_POST['username']))));
$password = strip_tags(trim(xss_clean(mysqli_real_escape_string($con, $_POST['password']))));
$hwid = strip_tags(trim(xss_clean(mysqli_real_escape_string($con, $_POST['hwid']))));
$programid = strip_tags(trim(xss_clean(mysqli_real_escape_string($con, $_POST['program_key']))));
$timestamp = strip_tags(trim(xss_clean(mysqli_real_escape_string($con, $_POST['date']))));

$username = str_replace("#", "+", $username);
$password = str_replace("#", "+", $password);
$hwid = str_replace("#", "+", $hwid);
$programid = str_replace("#", "+", $programid);
$timestamp = str_replace("#", "+", $timestamp);

$username = Decrypt($username);
$password = Decrypt($password);
$hwid = Decrypt($hwid);
$programid = Decrypt($programid);
$timestamp = Decrypt($timestamp);

$username = str_replace("'", "", $username);
$password = str_replace("'", "", $password);
$hwid = str_replace("'", "", $hwid);
$programid = str_replace("'", "", $programid);
$timestamp = str_replace("'", "", $timestamp);


$sqlerror = Encrypt(json_encode(array("status" => "error", "info" => "SQL error.")));
$incorrectdetails = Encrypt(json_encode(array("status" => "incorrect_details", "info" => "Incorrect username or password.")));
$userbanned = Encrypt(json_encode(array("status" => "banned_user", "info" => "Your account has been banned!")));
$incorrecthwid = Encrypt(json_encode(array("status" => "incorrect_hwid", "info" => "Incorrect machine ID.")));
$timeexpired = Encrypt(json_encode(array("status" => "time_expired", "info" => "Your time has expired!")));
$nullentry = Encrypt(json_encode(array("status" => "failed", "info" => "Please fill in all fields before attempting to login!")));
$resethwid = Encrypt(json_encode(array("status" => "hwid_reseted", "info" => "Your HWID has been reset, please login again.")));
$programbanned = Encrypt(json_encode(array("status" => "banned_app", "info" => "The developer of this program has been banned, therefore you cannot login or register.")));

if(empty($username) || empty($password) || empty($hwid) || empty($programid) || empty($timestamp)){
    die($nullentry);
}

$checkprogram = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$programid'") or die(Encrypt($sqlerror));
if(mysqli_num_rows($checkprogram) > 0){ //program ID exists
$result = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username' AND `programtoken` = '$programid'") or die(mysqli_error($con));

while($row1 = mysqli_fetch_array($checkprogram)){
        $hwidlock = $row1['hwidlock'];
        $bannned = $row1['banned'];
      }
      
      if ($bannned == "1"){
          die($programbanned);
      }

if(mysqli_num_rows($result) < 1){
    
die($incorrectdetails); //username doesn't exist
      
}elseif(mysqli_num_rows($result) > 0){

      while($row = mysqli_fetch_array($result)){
        $user = $row['username'];
        $pass = $row['password'];
        $level = $row['level'];
        $isbanned = $row['banned'];
        $hwidd = $row['hwid'];
        $expires = $row['expires'];
        $ip = $row['ip'];
        $email = $row['email'];
      } //username exists, carry on..
if(strtolower($username) == strtolower($user) && (password_verify($password, $pass))){ //check username and pass after all checks are done..
      if ($hwidd == "RESET"){
       $lulzz = mysqli_query($con, "UPDATE `users` SET `hwid` = '$hwid' WHERE `username` = '$username' AND `programtoken` = '$programid'") or die(Encrypt($sqlerror));
       if ($lulzz) {
       die($resethwid);   
       }
       else{
         die($sqlerror);
       }
      }
      
      $date = new DateTime($expires);
      $today = new DateTime();
      if ($date < $today){
        die($timeexpired);
      }
      else {
      if ($isbanned == 1){
      die($userbanned);
      }
       else{ //user isn't banned, next check..
        if ($hwid == $hwidd || $hwid === $hwidd){ //hwid matches, carry on...
         $success = Encrypt(json_encode(array("status" => "success", "info" => "Successfully logged in!", "username" => $user, "license" => $email, "level" => $level, "expires" => $expires, "hwid" => $hwidd, "ip" => $ip, "timestamp" => $timestamp)));
         die($success);
        }
        else{ //hwid doesn't exist
        if ($hwidlock == "1") { 
        die($incorrecthwid);
        }
        else{
         $success = Encrypt(json_encode(array("status" => "success", "info" => "Successfully logged in!", "username" => $user, "license" => $email, "level" => $level, "expires" => $expires, "hwid" => $hwidd, "ip" => $ip, "timestamp" => $timestamp)));
         die($success);
        }
        }
       }
     }
}
else{
 die($incorrectdetails);
}
}
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