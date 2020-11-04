<?php
include '../includes/settings.php';
error_reporting(0);
if(!strlen(strstr($_SERVER['HTTP_USER_AGENT'],"Akiza_Session")) <= 0 ) {
$programid = xss_clean(mysqli_real_escape_string($con, $_POST['program_key']));

// $programid = str_replace("#", "+", $programid);

$program_decrypted = Decrypt($programid);
// $programid = str_replace("'", "", $programid);

$sqlerror = Encrypt(json_encode(array("status" => "error", "info" => "SQL error.")));
$programbanned = Encrypt(json_encode(array("status" => "error", "info" => "This program has been banned!")));
$noprogram = Encrypt(json_encode(array("status" => "error", "info" => "Unable to find a program with this ID, contact the developer." . $program_decrypted)));


$checkprogram = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$program_decrypted'") or die(Encrypt($sqlerror));
if(mysqli_num_rows($checkprogram) > 0){ //program ID exists
while($row = mysqli_fetch_array($checkprogram)){
        $version = $row['version'];
        $name = $row['name'];
        $banned = $row['banned'];
        $clients = $row['clients'];
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
      if ($banned == 1){
        die($programbanned);
      }
      else{
        $success = Encrypt(json_encode(array("status" => "success", "info" => "Successfully grabbed variables", "version" => $version, "clients" => $clients, "freemode" => $freemode, "enabled" => $enabled, "hash" => $hash,  "devmode" => $devmode, "hwidlock" => $hwidlock, "antidebug" => $antidebug, "programname" => $name, "hashcheck" => $hashcheck, "optionalupdater" => $updatercheck, "updater_link" => $downloadlink)));
        die($success);
      }
    }
else {
die($noprogram);
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