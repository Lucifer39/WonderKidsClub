<?php

$quizNsql = mysqli_query($conn, "SELECT name,class,subject FROM quiz WHERE id='".$result['id']."'");
$quizNrow = mysqli_fetch_array($quizNsql, MYSQLI_ASSOC);

$clssql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$quizNrow['class']."' and type=2 and status=1");
$clsrow = mysqli_fetch_assoc($clssql);

$subjsql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$quizNrow['subject']."' and type=1 and status=1");
$subjrow = mysqli_fetch_assoc($subjsql);

$html = '<div class="pdf-watermark"></div>';

$html .= '<div style="width: 100%; display: flex; align-items: center; justify-content: center; padding: 1rem;"><img src="'. $baseurl .'assets/images/wonderkids-logo.svg" width="216" height="24"></div>';
$html .= '<div style="font-family: Arial, Helvetica, sans-serif; padding:10px 8px 15px; font-size: 20px; font-weight:bold; border-bottom:1px solid #ddd; text-align: center; color: #58cc02;">'.$quizNrow['name'].'<br/><br/>'.$clsrow['name'].', '.$subjrow['name'].'</div>';
$quizQry = mysqli_query($conn, "SELECT subtopic,question,question_id FROM quiz_quest WHERE quizid='".$result['id']."' order by id asc");
$questionCount = 1; // Initialize the question count

while($quizRslt = mysqli_fetch_array($quizQry, MYSQLI_ASSOC)) {

$i=1;   
$questQry = mysqli_query($conn, "SELECT question,opt_a,opt_b,opt_c,opt_d,type,type1,correct_ans,subtopic,shape_info FROM count_quest WHERE id='".$quizRslt['question_id']."'");
while($querow = mysqli_fetch_array($questQry, MYSQLI_ASSOC)) { 

  
$sbtpcSQL = mysqli_query($conn, "SELECT id,parent,subtopic FROM topics_subtopics WHERE id='".$querow['subtopic']."' and parent!=0 and status=1");
$sbtpcrow = mysqli_fetch_array($sbtpcSQL, MYSQLI_ASSOC);

$html .= '<div style="font-family: Arial, Helvetica, sans-serif; font-size: 22px; font-weight:bold; padding-top:40px; margin-left: 20px;">';
include("dyn_cond.php");  
//$html .= ob_get_clean();ob_start();
$html .= 'Q'.$questionCount.'. '.$querow['question'].'</div><div style="font-family: Arial, Helvetica, sans-serif; padding-top:15px;">';
include("dyn_ques.php");
$html .= ob_get_clean();ob_start();
$html .= '</div>';
$html .= '<div class="img-sizing '.$Wt200.'" style="font-family: Arial, Helvetica, sans-serif; font-size:18px; padding-top:8px; margin-left: 20px;">A. ';
include("dyn_opta.php");
$html .= ob_get_clean();ob_start();
$html .= '</div><div class="img-sizing '.$Wt200.'" style="font-family: Arial, Helvetica, sans-serif; font-size:18px; padding-top:8px; margin-left: 20px;">B. ';
include("dyn_optb.php");
$html .= ob_get_clean();ob_start();
$html .= '</div><div class="img-sizing '.$Wt200.'" style="font-family: Arial, Helvetica, sans-serif; font-size:18px; padding-top:8px; margin-left: 20px;">C. ';
include("dyn_optc.php");
$html .= ob_get_clean();ob_start();
$html .= '</div><div class="img-sizing '.$Wt200.'" style="font-family: Arial, Helvetica, sans-serif; font-size:18px; padding-top:8px; margin-left: 20px;">D. ';
include("dyn_optd.php");
$html .= ob_get_clean();ob_start();
$html .= '</div></div>';  

if ($querow['opt_a'] == $querow['correct_ans']) {
    $correct = 'Q' . $questionCount . '. A';
}
if ($querow['opt_b'] == $querow['correct_ans']) {
    $correct = 'Q' . $questionCount . '. B';
}
if ($querow['opt_c'] == $querow['correct_ans']) {
    $correct = 'Q' . $questionCount . '. C';
}
if ($querow['opt_d'] == $querow['correct_ans']) {
    $correct = 'Q' . $questionCount . '. D';
}

//Insert Query for Offline Answer for Subtopic
mysqli_query( $conn, "INSERT INTO practice_offline(userid,subtopic,correct) VALUES ('".$_SESSION['id']."','".$sbtpcrow['id']."','".$correct."')");

$i++; $questionCount++; } };
$html .= '<link rel="stylesheet" href="'.$baseurl.'assets/css/style.css">';
?>