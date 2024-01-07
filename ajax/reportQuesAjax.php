<?php
include( "../config/config.php" );

$sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == 1) {

$sql = "SELECT MAX(id) AS id, ques_id, user_id, status, MAX(created_at) AS created_at FROM report_question GROUP BY ques_id, user_id, status ORDER BY id DESC";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));

$i=0;
$data = array();
while( $employee = mysqli_fetch_assoc($resultset) ) {
	
	
	if ($employee['status'] == '0') { $status='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="active-btn">Resolved</a>';} else { $status ='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="inactive-btn">Issue</a>';}
    
  $schsql = mysqli_query($conn, "SELECT question,opt_a,opt_b,opt_c,opt_d,correct_ans FROM count_quest WHERE id='".$employee['ques_id']."'");
	$schrow = mysqli_fetch_assoc($schsql);
		
	$empRows = array();
    $empRows[] = "<a href='checkques?id=".$employee['ques_id']."' target='_blank'><u>".$employee['ques_id']."</u></a>";
    $empRows[] = $schrow['question'];
    $empRows[] = $schrow['opt_a'];
    $empRows[] = $schrow['opt_b'];
    $empRows[] = $schrow['opt_c'];
    $empRows[] = $schrow['opt_d'];
    $empRows[] = $schrow['correct_ans'];
    $empRows[] = $status;
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