<?php
include("config/config.php");
include("functions.php");

$sessionsql = mysqli_query($conn, "SELECT isAdmin,fullname,school,class FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == '2') {
if(isset($_POST['reportQues']))
{
    $reportquery = mysqli_query($conn, "SELECT id FROM report_question WHERE ques_id='".$_POST['reportQues']."' and user_id='".$_SESSION['id']."'");
    $reportrslt = mysqli_fetch_array($reportquery, MYSQLI_ASSOC);

    if(empty($reportrslt['id'])) {    
    mysqli_query( $conn, "INSERT INTO report_question(ques_id,user_id,status,created_at) VALUES ('".$_POST['reportQues']."','".$_SESSION['id']."','0','".$_POST['datetime']."')");
}
}
}

if($sessionrow['isAdmin'] == '2') {
    if(isset($_POST['requestQues']))
    {
        $requestquery = mysqli_query($conn, "SELECT id FROM request_solution WHERE ques_id='".$_POST['requestQues']."' and user_id='".$_SESSION['id']."'");
        $requestrslt = mysqli_fetch_array($requestquery, MYSQLI_ASSOC);
    
        if(empty($requestrslt['id'])) {    
        mysqli_query( $conn, "INSERT INTO request_solution(ques_id,user_id,status,created_at) VALUES ('".$_POST['requestQues']."','".$_SESSION['id']."','0','".$_POST['datetime']."')");
    }
    }
    }

if($sessionrow['isAdmin'] == '1') {
    if(isset($_POST['reportQuesBnk']))
    {
        $reportquery = mysqli_query($conn, "SELECT id FROM report_question_bank WHERE ques_id='".$_POST['reportQuesBnk']."' and user_id='".$_SESSION['id']."'");
        $reportrslt = mysqli_fetch_array($reportquery, MYSQLI_ASSOC);
    
        if(empty($reportrslt['id'])) {    
        mysqli_query( $conn, "INSERT INTO report_question_bank(ques_id,user_id,status,created_at,updated_at) VALUES ('".$_POST['reportQuesBnk']."','".$_SESSION['id']."','0','".$_POST['datetime']."','".$_POST['datetime']."')");
    }
    }
}

if (isset($_POST['assign_grp'])) {
    $value = $_POST['assign_grp'];
    
    // Store the value in the session
    $_SESSION['assign_grp'] = $value;
    
  }

//Fastest - Assign Topic
if (isset($_POST['asgn_topic'])) {
    $value = $_POST['asgn_topic'];
    $_SESSION['assign_topic'] = $value;
}
  

?>