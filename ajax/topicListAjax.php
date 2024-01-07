<?php
include( "../config/config.php" );

$sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == 1) {

$sql = "SELECT id,topic,status,parent,userid,class_id,subject_id FROM topics_subtopics WHERE parent=0 order by class_id,id asc";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));

$i=0;
$data = array();
while( $employee = mysqli_fetch_assoc($resultset) ) {
	
	
	if ($employee['status'] == '1') { $status='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="active-btn">Active</a>';} else { $status ='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="inactive-btn">Inactive</a>';}
	
	$clssql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$employee['class_id']."' and type=2 and status=1");
	$clsrow = mysqli_fetch_assoc($clssql);

	$subjsql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$employee['subject_id']."' and type=1 and status=1");
	$subjrow = mysqli_fetch_assoc($subjsql);
		
	$empRows = array();
	$empRows[] = $employee['id'];
	$empRows[] = $clsrow['name'].' / '.$subjrow['name'];
	$empRows[] = $employee['topic'];
	$empRows[] = $status;
	$empRows[] = '<a href="javascript:void(0);" class="edit" data-toggle="modal" data-id="'.$employee['id'].'" data-name="'.$employee['topic'].'" data-target="#editmodal"><i class="fa fa-edit tx-gray-light"></i></a>';
	//<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="delete"><i class="fa fa-trash-alt"></i></a>
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