<?php
include( "../config/config.php" );

$sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == 1) {

$sql = "SELECT id,body,hero_img,bg_img,status FROM homepage_banner order by id desc";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));

$i=0;
$data = array();
while( $employee = mysqli_fetch_assoc($resultset) ) {
	
	if ($employee['status'] == '1') { $status='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="active-btn">Active</a>';} else { $status ='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="inactive-btn">Inactive</a>';}
		
	$empRows = array();
	$empRows[] = $employee['id'];
	$empRows[] = $employee['body'];
	$empRows[] = '<img src="../uploads/slidingBanner/'.$employee['hero_img'].'" width="150" height="150">';
	$empRows[] = '<img src="../uploads/slidingBanner/'.$employee['bg_img'].'" width="150" height="150">';
	$empRows[] = $status;
	$empRows[] = '<a href="homeBanner?id='.$employee['id'].'" class="edit"><i class="fa fa-edit tx-gray-light"></i></a> <a href="javascript:void(0);" data-id="'.$employee['id'].'" class="delete"><i class="fa fa-trash-alt"></i></a>';
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