<?php

session_start();
function encrypt($message, $pass){
$method = 'aes-256-cbc';
$password = substr(hash('sha256', $pass, true), 0, 32);
$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
$encrypted = base64_encode(openssl_encrypt($message, $method, $password, OPENSSL_RAW_DATA, $iv));
return $encrypted;
}

function decrypt($encrypted, $pass){
$method = 'aes-256-cbc';
$password = substr(hash('sha256', $pass, true), 0, 32);
$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
$decrypted = openssl_decrypt(base64_decode($encrypted), $method, $password, OPENSSL_RAW_DATA, $iv);
return $decrypted;
}

function SendEncryptedResponse($message)
{
   echo $message;
   exit;
}
?>