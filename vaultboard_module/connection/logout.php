<?php 
session_set_cookie_params(0, '/', ".wonderkids.club");    


session_start();
require_once('../global/navigation.php');

session_unset();

if(isset($_GET["redirect"])) {
    header('Location: ' . urldecode($_GET["redirect"]));
}
else {
    header("Location:". ROOT_DOMAIN_URL . "logout?redirect=" . urlencode(GLOBAL_URL));
}
exit();
?>