<?php
include("config/config.php");
include("functions.php");


// $data = $_POST['data'];

$jsonData = json_decode(file_get_contents('php://input'), true);

// Extract the data
$data = $jsonData['data'];

$qury = mysqli_query($conn, "SELECT slug,id,parent,subtopic FROM topics_subtopics WHERE id='".str_replace('"', '', $data)."'");
$result = mysqli_fetch_assoc($qury);

$topicQury = mysqli_query($conn, "SELECT topic FROM topics_subtopics WHERE id='". $result["parent"] ."'");
$topic = mysqli_fetch_assoc($topicQury);

$quizNsql = mysqli_query($conn, "SELECT class,subject FROM count_quest WHERE subtopic='".$result['id']."'");
$quizNrow = mysqli_fetch_array($quizNsql, MYSQLI_ASSOC);

$clssql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$quizNrow['class']."' and type=2 and status=1");
$clsrow = mysqli_fetch_assoc($clssql);

$subjsql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$quizNrow['subject']."' and type=1 and status=1");
$subjrow = mysqli_fetch_assoc($subjsql);

//Delete Query for Offline old answer
mysqli_query( $conn, "delete FROM practice_offline WHERE userid='".$_SESSION['id']."' and subtopic = '".$result['id']."'");

$html = '<div class="external-pdf-container">';

$html .= '<div class="pdf-watermark"></div>';

// $html .='<div style="font-family: Arial, Helvetica, sans-serif; padding:10px 8px; font-size: 28px; font-weight: bold; text-align: center;">Wonder Kids</div>';
$html .= '<div style="width: 100%; display: flex; align-items: center; justify-content: center; padding: 1rem;"><img src="'. $baseurl .'assets/images/wonderkids-logo.svg" width="216" height="24"></div>';
$html .= '<div style="font-family: Arial, Helvetica, sans-serif; padding:10px 8px 15px; font-size: 20px; font-weight:bold; border-bottom:1px solid #ddd; text-align: center; color: #58cc02;">'.$result['subtopic'].', '.$topic['topic'].'</div>';
$html .= '<div style="font-family: Arial, Helvetica, sans-serif; padding:10px 8px 15px; font-size: 20px; font-weight:bold; border-bottom:1px solid #ddd; text-align: center; color: #58cc02;">'.$clsrow['name'].', '.$subjrow['name'].'</div>';
$questionCount = 1; // Initialize the question count
$i=1;   
$questQry = mysqli_query($conn, "SELECT id,question,opt_a,opt_b,opt_c,opt_d,type,type1,correct_ans,subtopic,shape_info FROM count_quest WHERE subtopic='".str_replace('"', '', $data)."' AND generated_pdf = 0 ORDER BY RAND() LIMIT 10");
while($querow = mysqli_fetch_array($questQry, MYSQLI_ASSOC)) { 

    mysqli_query($conn, "UPDATE count_quest SET generated_pdf = 1 WHERE id = ". $querow['id']);
  
$sbtpcSQL = mysqli_query($conn, "SELECT id,parent,subtopic FROM topics_subtopics WHERE id='".$querow['subtopic']."' and parent!=0 and status=1");
$sbtpcrow = mysqli_fetch_array($sbtpcSQL, MYSQLI_ASSOC);

$html .= '<div style="font-family: Arial, Helvetica, sans-serif; font-size: 22px; font-weight:bold; padding-top:40px; margin-left: 20px;">';
include("components/dyn_cond.php"); 
$Wt200 = " mw-100 ";
//$html .= ob_get_clean();ob_start();
$html .= 'Q'.$questionCount.'. '.$querow['question'].'</div><div style="font-family: Arial, Helvetica, sans-serif; padding-top:15px;">';
include("components/dyn_ques.php");
$html .= ob_get_clean();ob_start();
$html .= '</div>';
$html .= '<div class="img-sizing '.$Wt200.'" style="font-family: Arial, Helvetica, sans-serif; font-size:18px; padding-top:8px; margin-left: 20px;">A. ';
include("components/dyn_opta.php");
$html .= ob_get_clean();ob_start();
$html .= '</div><div class="img-sizing '.$Wt200.'" style="font-family: Arial, Helvetica, sans-serif; font-size:18px; padding-top:8px; margin-left: 20px;">B. ';
include("components/dyn_optb.php");
$html .= ob_get_clean();ob_start();
$html .= '</div><div class="img-sizing '.$Wt200.'" style="font-family: Arial, Helvetica, sans-serif; font-size:18px; padding-top:8px; margin-left: 20px;">C. ';
include("components/dyn_optc.php");
$html .= ob_get_clean();ob_start();
$html .= '</div><div class="img-sizing '.$Wt200.'" style="font-family: Arial, Helvetica, sans-serif; font-size:18px; padding-top:8px; margin-left: 20px;">D. ';
include("components/dyn_optd.php");
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


$i++; $questionCount++; };

$html .='<div style="page-break-before: always;"></div>';
//Answer Sheet

$html .='<table class="mx-ma-ques" width="100%" cellpadding="0" cellspacing="0" style="font-family: Arial, Helvetica, sans-serif;">';
$html .= '<tbody><tr>';
$html .= '<td colspan="3" style="padding:20px 8px; font-size: 28px; font-weight: bold; border-bottom:1px solid #ddd; text-align: center;">Answer Sheet</td>';
$html .= '</tr>';
$html .= '<tr><td colspan="3" style="padding:0px 8px 0px 5px; font-size: 16px; text-align: center;">&nbsp;</td></tr>';

$counter = 1;

$questQry = mysqli_query($conn, "SELECT correct FROM practice_offline WHERE userid='".$_SESSION['id']."' and subtopic='".$result['id']."'");
while ($querow = mysqli_fetch_array($questQry, MYSQLI_ASSOC)) {

    if ($counter % 3 === 1) {
        if ($counter !== 1) {
            $html .= '</tr>'; // Close the previous table row
        }
        $html .= '<tr>'; // Start a new table row
    }

    $html .= '<td style="padding:6px 10px;">'.$querow['correct'].'</td>';

    $counter++;
}

if (($counter - 1) % 3 !== 0) {
    $html .= '</tr>'; // Close the last table row if needed
}

$html .= '</tbody></table>';
$html .= '<link rel="stylesheet" href="'.$baseurl.'assets/css/style.css">';
$html .= '</div>';

// $html = "Hello World";
// header('Content-Type: text/html');

echo $html;