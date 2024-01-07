<?php
	include("../config/config.php");
	if($_SESSION['id']){
		session_start();
		session_unset();
		session_destroy();
		session_write_close();
		//setcookie("USERNAME",'',0,'/');
		session_regenerate_id(true);
		
}
header('Location:'.$baseurl.'');
?>