<?php
$myhost = "";
$myuser = "";
$mypass = "";
$mydb = "";
$key = "2147828743"; //Don't touch this !

$rootUrl = (!empty($_SERVER['HTTPS']) ? 'https' : 'https') . '://' . $_SERVER['HTTP_HOST'] . '';

$con = mysqli_connect($myhost, $myuser, $mypass, $mydb);
mysqli_query($con, "SET NAMES UTF8") or die(mysqli_error($con));
setlocale(LC_TIME, 'en_US'); // modify this line if you are not in Europe. fr/FR mean France.
date_default_timezone_set('Europe/Paris'); // this too
error_reporting(E_ALL);


if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>