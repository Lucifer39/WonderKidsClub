<?php
$quizNsql = mysqli_query($conn, "SELECT name,class,subject FROM quiz WHERE id='".$result['id']."'");
$quizNrow = mysqli_fetch_array($quizNsql, MYSQLI_ASSOC);

$clssql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$quizNrow['class']."' and type=2 and status=1");
$clsrow = mysqli_fetch_assoc($clssql);

$subjsql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$quizNrow['subject']."' and type=1 and status=1");
$subjrow = mysqli_fetch_assoc($subjsql);
$html = '<div class="pdf-watermark"></div>';

$html .='<table class="mx-ma-ques" width="100%" cellpadding="0" cellspacing="0" style="font-family: Arial, Helvetica, sans-serif;">';
$html .= '<tbody><tr>';
$html .= '<div style=" display: flex; align-items: center; justify-content: center; padding: 1rem;"><img src="'. $baseurl .'assets/images/wonderkids-logo.svg" width="216" height="24"></div>';
$html .= '</tr>';
$html .= '<tr><td colspan="3" style="padding:10px 8px 5px; font-size: 24px; font-weight:bold; text-align: center; color: #58cc02;">'.$quizNrow['name'].'</td></tr>';
$html .= '<tr><td colspan="3" style="padding:5px 8px 15px 5px; border-bottom:1px solid #ddd; font-size: 16px; text-align: center; color: #58cc02;">'.$clsrow['name'].', '.$subjrow['name'].'</td></tr>';
$html .= '<tr><td colspan="3" style="padding:0px 8px 0px 5px; font-size: 16px; text-align: center;">&nbsp;</td></tr>';
$counter = 1;

$quizQry = mysqli_query($conn, "SELECT subtopic,question,question_id FROM quiz_quest WHERE quizid='".$result['id']."' ORDER BY id ASC");
$questionCount = 1; // Initialize the question count
//$html = ''; // Initialize the HTML variable

while ($quizRslt = mysqli_fetch_array($quizQry, MYSQLI_ASSOC)) {

if ($counter % 3 === 1) {
    if ($counter !== 1) {
        $html .= '</tr>'; // Close the previous table row
    }
    $html .= '<tr>'; // Start a new table row
}

$i = 1;
$questQry = mysqli_query($conn, "SELECT question,opt_a,opt_b,opt_c,opt_d,type,type1,correct_ans,subtopic FROM count_quest WHERE id='".$quizRslt['question_id']."'");
$querow = mysqli_fetch_array($questQry, MYSQLI_ASSOC);

$html .= '<td style="padding:6px 10px;">';
if ($querow['opt_a'] == $querow['correct_ans']) {
    $html .= 'Q' . $questionCount . '. A';
}
if ($querow['opt_b'] == $querow['correct_ans']) {
    $html .= 'Q' . $questionCount . '. B';
}
if ($querow['opt_c'] == $querow['correct_ans']) {
    $html .= 'Q' . $questionCount . '. C';
}
if ($querow['opt_d'] == $querow['correct_ans']) {
    $html .= 'Q' . $questionCount . '. D';
}
$html .= '</td>';

$counter++;
$questionCount++;
}

if (($counter - 1) % 3 !== 0) {
$html .= '</tr>'; // Close the last table row if needed
}

$html .= '</tbody></table>';
$html .= '<link rel="stylesheet" href="'.$baseurl.'assets/css/style.css">';

?>