<?php
include( "../config/config.php" );

$sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == 1) {

$sql = "SELECT id,name,description,price,discount,status FROM plan order by id asc";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));

$i=0;
$data = array();
while( $employee = mysqli_fetch_assoc($resultset) ) {
	
	
	if ($employee['status'] == '1') { $status='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="active-btn">Active</a>';} else { $status ='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="inactive-btn">Inactive</a>';}
	
	$empRows = array();
	$empRows[] = $employee['id'];
	$empRows[] = $employee['name'].'<br><span class="note">'.$employee['description'].'</span>';
  $empRows[] = $employee['price'];
  $empRows[] = $employee['discount'];
	$empRows[] = $status;
	$empRows[] = '<a href="packages.php?id='.$employee['id'].'" class="edit"><i class="fa fa-edit tx-gray-light"></i></a>';
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