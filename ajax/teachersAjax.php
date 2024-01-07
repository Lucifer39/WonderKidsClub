<?php
include( "../config/config.php" );

$sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == 1) {

$sql = "SELECT id,userid,fullname,email,contact,status,school,created_at FROM users WHERE type=2 order by id desc";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));

$i=0;
$data = array();
while( $employee = mysqli_fetch_assoc($resultset) ) {
	
	
	if ($employee['status'] == '1') { $status='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="active-btn">Active</a>';} else { $status ='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="inactive-btn">Inactive</a>';}
	$adminVer = 0;

	$verSQL = mysqli_query($conn, "SELECT admin_verified FROM verified_teachers WHERE email = '". $employee['email'] . "'");
	$verRow = mysqli_fetch_assoc($verSQL);

	if(mysqli_num_rows($verSQL) > 0 && $verRow['admin_verified'] == '1') {
		$adminVer = 1;
	}

  $schsql = mysqli_query($conn, "SELECT name FROM school_management WHERE id='".$employee['school']."' and status=1");
	$schrow = mysqli_fetch_assoc($schsql);
		
	$empRows = array();
	$empRows[] = $employee['userid'];
	$empRows[] = $employee['fullname'];
  $empRows[] = $employee['email'];
  $empRows[] = $employee['contact'];
  $empRows[] = $schrow['name'];
	$empRows[] = $status;
	$empRows[] = $adminVer == 1 ? '<a href="javascript:void(0);" data-id="'.$employee['email'].'" class="admin-active-btn">Verified</a>' : '<a href="javascript:void(0);" data-id="'.$employee['email'].'" class="admin-inactive-btn">Unverified</a>' ;
  $empRows[] = $employee['created_at'];
	$data[] = $empRows;
	$i++;
}
$results = array(
	"sEcho" => 1,
"iTotalRecords" => count($data),
"iTotalDisplayRecords" => count($data),
  "aaData"=>$data);
echo json_encode($results);

} else {
header('Location:'.$baseurl.'');
}
?>