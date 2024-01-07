<?php
include( "../config/config.php" );

$sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == 1) {

$sql = "SELECT id,title,status,featured FROM blog_post order by created_at desc";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));

$i=0;
$data = array();
while( $employee = mysqli_fetch_assoc($resultset) ) {
	
	
	if ($employee['status'] == '0') { $status='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="active-btn">Active</a>';} else { $status ='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="inactive-btn">Inactive</a>';}
	
	$empRows = array();
	$empRows[] = $i+1;
	$empRows[] = '<img class="img-fluid" src="../uploads/blog/'.$employee['featured'].'" width="80">';
	$empRows[] = $employee['title'];
	$empRows[] = $status;
	$empRows[] = '<a href="editblogPost.php?id='.$employee['id'].'" class="edit"><i class="fa fa-edit tx-gray-light"></i></a> <a href="javascript:void(0);" data-id="'.$employee['id'].'" class="delete"><i class="fa fa-trash-alt"></i></a>';
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