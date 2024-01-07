<?php
include( "../config/config.php" );

$sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == 1) {

$sql = "SELECT * FROM orders order by id desc";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));

$i=0;
$data = array();
while( $employee = mysqli_fetch_assoc($resultset) ) {
			
	$empRows = array();
	$empRows[] = $employee['name'].'('.$employee['userid'].')';
	$empRows[] = $employee['email'];
	$empRows[] = $employee['transcation_id'];
	$empRows[] = $employee['paid_amt'].' '.strtoupper($employee['paid_curr']);
	$empRows[] = $employee['plan'];
	$empRows[] = ucfirst($employee['status']);
	$empRows[] = $employee['created'];
	$empRows[] = '<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="active-btn">Refund</a>';
	$data[] = $empRows; //checkout_session_id
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