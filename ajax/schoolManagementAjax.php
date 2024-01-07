<?php
include( "../config/config.php" );

$sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == 1) {

$sql = "SELECT id,name,short_form,status FROM school_management order by created_at desc";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));

$i=0;
$data = array();
while( $employee = mysqli_fetch_assoc($resultset) ) {
	
	
	if ($employee['status'] == '1') { $status='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="active-btn">Active</a>';} else { $status ='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="inactive-btn">Inactive</a>';}
	
	$empRows = array();
	$empRows[] = '<input type="checkbox" data-id="'. $employee['id'] .'" class="school-checkbox">';
	$empRows[] = $employee['id'];
	$empRows[] = $employee['name'];
	$empRows[] = $employee['short_form'];
	$empRows[] = $status;
	$empRows[] = '<a href="javascript:void(0);" class="edit" data-toggle="modal" data-id="'.$employee['id'].'" data-name="'.$employee['name'].'" data-short="'.$employee['short_form'].'" data-target="#editmodal"><i class="fa fa-edit tx-gray-light"></i></a> <a href="javascript:void(0);" data-id="'.$employee['id'].'" class="delete"><i class="fa fa-trash-alt"></i></a>';
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