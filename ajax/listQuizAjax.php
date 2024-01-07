<?php
include( "../config/config.php" );

$sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == 1) {

$sql = "SELECT id,class,subject,name,type,status,start_date,end_date FROM quiz order by id desc";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));

$i=0;
$data = array();
while( $employee = mysqli_fetch_assoc($resultset) ) {
	
	if ($employee['status'] == '1') { $status='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="active-btn">Active</a>';} else { $status ='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="inactive-btn">Inactive</a>';}

	if ($employee['type'] == '1') { $type='Quiz';} else { $type ='Paper';}

	if ($employee['type'] == '1') { $datetime = $employee['start_date'].' to '.$employee['end_date'];} else { $datetime = '-';}

	$clssql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$employee['class']."' and type=2 and status=1");
	$clsrow = mysqli_fetch_assoc($clssql);

	$subjsql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$employee['subject']."' and type=1 and status=1");
	$subjrow = mysqli_fetch_assoc($subjsql);

	$quizsql = mysqli_query($conn, "SELECT topic,subtopic FROM quiz_quest WHERE quizid='".$employee['id']."'");
	$quizrow = mysqli_fetch_assoc($quizsql);

	//$tpcsql = mysqli_query($conn, "SELECT topic FROM topics_subtopics WHERE id='".$quizrow['topic']."' and status=1");
	//$tpcrow = mysqli_fetch_assoc($tpcsql);

	//$sbtpcsql = mysqli_query($conn, "SELECT subtopic FROM topics_subtopics WHERE subtopic='".$quizrow['subtopic']."' and status=1");
	//$sbtpcrow = mysqli_fetch_assoc($sbtpcsql);
		
	$empRows = array();
	$empRows[] = $employee['id'];
	$empRows[] = $clsrow['name'].' / '.$subjrow['name'];
	$empRows[] = $employee['name'].' ('.$type.')';
	$empRows[] = $datetime;
	$empRows[] = $status;
	$empRows[] = '<a href="editQuiz.php?id='.$employee['id'].'" class="edit"><i class="fa fa-edit tx-gray-light"></i></a>';
	$empRows[] = $employee["type"] == 2 ? '<button class="btn btn-primary custom-btn" onclick="runQuery()" data-id="'. $employee["id"] .'">Question</button>
				  <button class="btn btn-primary custom-btn" onclick="runDQuery()" data-id="'. $employee["id"] .'">Answer</button>' : "";
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