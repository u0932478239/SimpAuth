<?php
function addpadding($string, $blocksize = 32)
{
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
}
function encrypt($string, $pass)
{
    $key = substr(hash('sha256', $pass, true), 0, 32);
    $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, addpadding($string), MCRYPT_MODE_CBC, $iv));
}
function strippadding($string)
    {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if(preg_match("/$slastc{".$slast."}/", $string)){
        $string = substr($string, 0, strlen($string)-$slast);
            return $string;
        } else {
            return false;
        }
   }
function decrypt($string, $pass)
    {
        $key = substr(hash('sha256', $pass, true), 0, 32);
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $string = base64_decode($string);
        return strippadding(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_CBC, $iv));
    }
$data = rawurldecode($_GET['data']);
$program = $_GET['p'];
$response = decrypt($data, $program);
echo encrypt($response, $program);
die();
?>