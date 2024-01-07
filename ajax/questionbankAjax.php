<?php
include( "../config/config.php" );

$sessionsql = mysqli_query($conn, "SELECT isAdmin,id,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == 1) {

if($sessionrow['isAdmin'] == 1 && $sessionrow['type'] == 99) {
	$sql = "SELECT id,userid,class,subject,topic,subtopic,type2,question,status FROM count_quest WHERE type2='q1' and userid='".$sessionrow['id']."' or type2='p1' and userid='".$sessionrow['id']."' order by id desc";
} elseif($sessionrow['isAdmin'] == 1 && $sessionrow['type'] == 0) {
	$sql = "SELECT id,userid,class,subject,topic,subtopic,type2,question,status FROM count_quest WHERE type2='q1' or type2='p1' order by id desc";
}

$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));

$i=0;
$data = array();
while( $employee = mysqli_fetch_assoc($resultset) ) {
	
	if($sessionrow['isAdmin'] == 1 && $sessionrow['type'] == 99) {
		if ($employee['status'] == '1') { $status='<span class="active-btn">Active</span>';} else { $status ='<span class="inactive-btn">Inactive</span>'; $delBtn = "<a href='javascript:void(0);' data-id='".$employee['id']."' class='delete ml-1'><i class='fa fa-trash-alt'></i></a>";}
	} else {	
		if ($employee['status'] == '1') { $status='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="active-btn">Active</a>';} else { $status ='<a href="javascript:void(0);" data-id="'.$employee['id'].'" class="inactive-btn">Inactive</a>';}
	}

	if ($employee['type2'] == 'q1') { $type='Quiz';} else { $type ='Practice';}
	
	$clssql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$employee['class']."' and type=2 and status=1");
	$clsrow = mysqli_fetch_assoc($clssql);

	$subjsql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$employee['subject']."' and type=1 and status=1");
	$subjrow = mysqli_fetch_assoc($subjsql);

	$tpcsql = mysqli_query($conn, "SELECT topic FROM topics_subtopics WHERE id='".$employee['topic']."' and status=1");
	$tpcrow = mysqli_fetch_assoc($tpcsql);

	$sbtpcsql = mysqli_query($conn, "SELECT subtopic FROM topics_subtopics WHERE id='".$employee['subtopic']."' and status=1");
	$sbtpcrow = mysqli_fetch_assoc($sbtpcsql);
	
	if (!empty($employee['remark'])) {
		$remTitle = 'Edit';
	} else {
		$remTitle = 'Add';
	}

	$remark_qury = mysqli_query($conn, "SELECT remark FROM question_bank_remark WHERE ques_id='".$employee['id']."'");
	$remark_rslt = mysqli_fetch_assoc($remark_qury);
	
	$stnqury = mysqli_query($conn, "SELECT fullname FROM users WHERE id='".$employee['userid']."'");
	$stnrslt = mysqli_fetch_assoc($stnqury);
		
	$empRows = array();
	$empRows[] = $employee['id'];
	$empRows[] = $clsrow['name'].' / '.$subjrow['name'].' / '.$tpcrow['topic'].' / '.$sbtpcrow['subtopic'];
	$empRows[] = $type;
	$empRows[] = "<a href='checkques?id=".$employee['id']."' target='_blank'><u>".$employee['question']."</u></a>";
	$empRows[] = $stnrslt['fullname'].' / '.$employee['userid'];
	$empRows[] = $status;
	if($sessionrow['isAdmin'] == 1 && $sessionrow['type'] == 99) {
		$empRows[] = $remark_rslt['remark'];
	} else {
		$empRows[] = $remark_rslt['remark'].'<br><br><a href="javascript:void(0);" class="edit" data-toggle="modal" data-id="'.$employee['id'].'" data-name="'.$remark_rslt['remark'].'" data-target="#editmodal"><i class="fa fa-edit tx-gray-light"></i>'.$remTitle.' Remark</a></br></br>';
	}
	$empRows[] = '<a href="question-bank.php?id='.$employee['id'].'" class="edit"><i class="fa fa-edit tx-gray-light"></i></a> '.$delBtn.'';
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