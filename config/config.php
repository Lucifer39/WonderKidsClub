<?php
// session_set_cookie_params(0, '/', '.wonderkids.club');
ob_start();
error_reporting(E_ERROR); ini_set('display_errors', 'On');
ini_set('session.save_path',realpath('https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'config/sessions.php'));

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

#header("Access-Control-Allow-Origin: *");
#header("Access-Control-Allow-Methods: GET, POST");

// $baseurl = "http://localhost/edtech/";
$baseurl = "http://localhost/Wonderkids_Internship/";

date_default_timezone_set('Asia/Kolkata'); 
//$today= time();
//echo(date("d-m-Y",$today));
//echo "<br>";
//echo date("h:i:sa");
//echo "<br>";
$curr_DateTime = date('Y-m-d H:i:s');

session_start();

$conn=mysqli_connect("localhost","root","","staging", 3306);
// $conn->set_charset("utf8");
if(!$conn)
{
die("Connection failed: " . mysqli_connect_error());
}

define('STRIPE_API_KEY', 'sk_test_51O9WvhSBRGmgfoNTcPvfzM0d3fiVjW6KAACYlaVEKWSq5TafJ74GP7uHundlBwJcEIWE3laKDrmFWnTiHJdUUYtP00pTID1UTE');
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51O9WvhSBRGmgfoNTXrUikvyQ4turQWGLORo7KGMvCGdZAOXhqg3FM5x3DIuQMD9nUJIhcNb2zlmbTEaLUzgO27gh00FglC7FMO');

// define('STRIPE_API_KEY', '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');
// define('STRIPE_PUBLISHABLE_KEY', 'pk_live_51O9WvhSBRGmgfoNToV1vdpzoudgQpwAXbANjNHpFiMMPZL1d2PSxWh58eVecdtMyph69sbojRdv2sS83rjBPtlkc000u31qYPC');

define('STRIPE_SUCCESS_URL', ''.$baseurl.'success.php'); 
define('STRIPE_CANCEL_URL', ''.$baseurl.'cancel'); 

define('PHONE_PE_API_KEY', '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399');
define('PHONE_PE_KEY_INDEX', 1);
define('PHONE_PE_MERCHANT_ID', 'PGTESTPAYUAT');
define('PHONE_PE_SUCCESS_URL', $baseurl . 'phone_pe_success');
?>