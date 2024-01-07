<?php
include( "../config/config.php" );

if(isset($_POST['grpAct_active'])) {
	mysqli_query($conn, "update grpwise Set status='0' WHERE id=".$_POST['grpAct_active']."");
}
if(isset($_POST['grpAct_inactive'])) {
	mysqli_query($conn, "update grpwise Set status='1' WHERE id=".$_POST['grpAct_inactive']."");
}

//Assign Group
if(isset($_POST['agrpAct_active'])) {
	mysqli_query($conn, "update assign_grp Set status='0' WHERE id=".$_POST['agrpAct_active']."");
}
if(isset($_POST['agrpAct_inactive'])) {
	mysqli_query($conn, "update assign_grp Set status='1' WHERE id=".$_POST['agrpAct_inactive']."");
}

//Teacher user List
if(isset($_POST['del_tchusr'])) {
	mysqli_query($conn, "DELETE FROM tch_grp_usr_list WHERE id=".$_POST['del_tchusr']."");
}
if(isset($_POST['tchusr_active'])) {
	mysqli_query($conn, "update tch_grp_usr_list Set status='0' WHERE id=".$_POST['tchusr_active']."");
}
if(isset($_POST['tchusr_inactive'])) {
	mysqli_query($conn, "update tch_grp_usr_list Set status='1' WHERE id=".$_POST['tchusr_inactive']."");
}