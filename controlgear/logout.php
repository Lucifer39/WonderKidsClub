<?php
	include("../config/config.php");
	include("../config/config_key.php");

	if($_SESSION['id']){
		session_start();
		session_unset();
		session_destroy();
		session_write_close();
		//setcookie("USERNAME",'',0,'/');
		session_regenerate_id(true);
		
}
if(isset($_GET["redirect"])) {
	header('Location: ' . urldecode($_GET["redirect"]));
}
else{
	header('Location: ' . SUB_DOMAIN_URL . "connection/logout.php?redirect=" . urlencode($baseurl . 'controlgear/login'));
}
?>