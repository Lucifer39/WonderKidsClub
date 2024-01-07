<?php
	include("config/config.php");
	include("config/config_key.php");
	if($_SESSION['id'] || $_COOKIE['user_id']){
		session_start();
		session_unset();
		session_destroy();
		session_write_close();
		$cookie_name = "user_id";

		// Unset the cookie
		setcookie($cookie_name, "", time() - 3600, "/");
		unset($_COOKIE['user_id']);
		//setcookie("USERNAME",'',0,'/');
		session_regenerate_id(true);

		
}

if(isset($_GET["redirect"])) {
	header('Location: ' . urldecode($_GET["redirect"]));
}
else{
	header('Location: ' . SUB_DOMAIN_URL . "connection/logout.php?redirect=" . urlencode($baseurl));
}
?>