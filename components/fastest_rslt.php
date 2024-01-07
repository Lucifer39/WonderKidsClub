<?php

$crtqury = mysqli_query($conn, "SELECT COUNT(correct) as correct FROM fastest_leaderboard WHERE correct !='NULL' and userid='".$_SESSION['id']."' and quizid='".$quizrow['id']."'");
$crtrslt = mysqli_fetch_array($crtqury, MYSQLI_ASSOC); 

$wrgqury = mysqli_query($conn, "SELECT COUNT(wrong) as wrong FROM fastest_leaderboard WHERE wrong !='NULL' and userid='".$_SESSION['id']."' and quizid='".$quizrow['id']."'");
$wrgrslt = mysqli_fetch_array($wrgqury, MYSQLI_ASSOC);

$timequry = mysqli_query($conn, "SELECT updated_at FROM fastest_leaderboard WHERE userid='".$_SESSION['id']."' and quizid='".$quizrow['id']."' order by id desc");
$timerslt = mysqli_fetch_array($timequry, MYSQLI_ASSOC);

$timestamp1 = $quizrow['created_at'];
$timestamp2 = $timerslt['updated_at'];                     

$datetime1 = new DateTime($timestamp1);
$datetime2 = new DateTime($timestamp2);
$interval = $datetime1->diff($datetime2);
$duration = $interval->format('%H:%I:%S');

$fst_crt = $crtrslt['correct'];
$fst_wrg = $wrgrslt['wrong'];
$fst_time = $duration;

$fst_chk_qury = mysqli_query($conn, "SELECT correct,duration,topicid FROM fastest WHERE userid='".$_SESSION['id']."' and id='".$quizrow['id']."'");
$fst_chk_rslt = mysqli_fetch_array($fst_chk_qury, MYSQLI_ASSOC);

$rank = 1;
$topicleaderqury = mysqli_query($conn, "SELECT userid FROM fastest WHERE topicid='".$fst_chk_rslt['topicid']."' and correct IS NOT NULL and correct <> '' and correct != 0 ORDER BY correct desc,converttime");
while ($row = mysqli_fetch_assoc($topicleaderqury)) {
    
    if ($_SESSION['id'] == $row['userid']) {
        $urrank = $rank;
    }
    
    $rank++;
}
?>