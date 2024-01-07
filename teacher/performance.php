<?php include( "../config/config.php" ); 
include( "../functions.php" );

if(empty($_SESSION['id'])) {
header('Location:'.$baseurl.'');
}

$link = $_SERVER[ 'PHP_SELF' ];
$link_array = explode( '/', $link );
$page = end( $link_array );

$url = trim($_SERVER["REQUEST_URI"],"/");
$id = substr($url, strpos($url, '=') + 1);

//$grpSQL = mysqli_query($conn, "SELECT name FROM grpwise WHERE id=".$id."");
//$grpROW = mysqli_fetch_array($grpSQL, MYSQLI_ASSOC);

$sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == '3') {
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<meta name="x-ua-compatible" content="IE=edge,chrome=1" http_equiv="X-UA-Compatible">
<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no" >
<meta name="msapplication-tap-highlight" content="no">
<meta name="theme-color" content="#">
<title>Wonderkids :: Group</title>
<?php require_once('headpart.php'); ?>
</head>
<body id="teacher-wrapper">
<div class="teacher-wrapper">
<?php require_once('left-navigation.php'); ?>  
    <main>
        <div class="lt-260">    
        <?php require_once('header.php'); ?>
    <section class="section pt-0 pb-3 ml-1 mr-1">
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-4 mb-4">
          <ul class="breadcrumbs">
            <li><a href="group"><span>Home</span></a></li>
            <li><span>Groups</span></li>
            <li><span>Performance</span></li>
          </ul>
        </div>
        <div class="col-md-12 d-flex align-items-center">
            <h2 class="section-title"><?php echo $grpROW['name']; ?></h2>
            <div class="flex-grow-1 text-end">
              <a href="assign-group" class="btn btn-red custom-btn">Back</a>
            </div>
            </div>
      </div>
    </div>
    </section>
    <section class="section pt-0 ml-1 mr-1">
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="block-widget">
          <div class="mb-2">
        <input class="form-control" id="myInput" type="text" placeholder="Search..">
        </div>
        <div class="table-responsive">
          <table id="myTable" cellpadding="0" cellspacing="0" class="table custom-table tablesorter">
            <thead>
              <tr>
                <th>Student Name</th>
                <th >Correct</th>
                <th >Attempt</th>
                <th >Percent</th>
</tr>
            </thead>
            <tbody>
              <?php 
              
              $grpids_qury = mysqli_query($conn, "SELECT grpids,subtopic FROM assign_grpids WHERE assign_grp=".$id."");
              while($grpids_row = mysqli_fetch_array($grpids_qury, MYSQLI_ASSOC)) {
                  $grpids[] = $grpids_row['grpids'];
                  $grp_subtopics[] = $grpids_row['subtopic'];
              }
              
              $grpids = "'" . implode("','", $grpids) . "'";
              $grp_subtopics = "'" . implode("','", $grp_subtopics) . "'";
              
              $i=1; $tch_usr_qury = mysqli_query($conn, "SELECT id,name,email,optional,status,created_at,grp_id FROM tch_grp_usr_list WHERE grp_id IN (".$grpids.")");
              while($tch_usr_row = mysqli_fetch_array($tch_usr_qury, MYSQLI_ASSOC)) { 

              $usr_accept = $tch_usr_row['created_at'];
              
              $asngrp_qury = mysqli_query($conn, "SELECT a.created_at FROM assign_grp as a INNER JOIN assign_grpids as b ON b.assign_grp=a.id WHERE b.assign_grp='".$id."'");
              $asngrp_rslt = mysqli_fetch_array($asngrp_qury, MYSQLI_ASSOC);
              
              $asngrp_attempt = $asngrp_rslt['created_at'];  
              
              $chkusr_qury = mysqli_query($conn, "SELECT id FROM users WHERE email='".$tch_usr_row['email']."'");
              $chkusr_rslt = mysqli_fetch_array($chkusr_qury, MYSQLI_ASSOC);

              $chk_date_qury = mysqli_query($conn, "SELECT created_at FROM leaderboard WHERE userid='".$chkusr_rslt['id']."' order by id desc");
              $chk_date_rslt = mysqli_fetch_array($chk_date_qury, MYSQLI_ASSOC);

              $ques_attempt = $chk_date_rslt['created_at'];  

              $count_ques_qury = mysqli_query($conn, "SELECT COUNT(id) as count FROM leaderboard WHERE userid='".$chkusr_rslt['id']."' and subtopic IN (".$grp_subtopics.") and created_at >= '".$usr_accept."' and created_at >= '".$asngrp_attempt."' and created_at <= '".$ques_attempt."'");
              $count_ques_rslt = mysqli_fetch_array($count_ques_qury, MYSQLI_ASSOC); 

              $crt_ques_qury = mysqli_query($conn, "SELECT COUNT(correct) as correct FROM leaderboard WHERE userid='".$chkusr_rslt['id']."' and subtopic IN (".$grp_subtopics.") and correct != 'NULL' and created_at >= '".$usr_accept."' and created_at >= '".$asngrp_attempt."' and created_at <= '".$ques_attempt."'");
              $crt_ques_rslt = mysqli_fetch_array($crt_ques_qury, MYSQLI_ASSOC); 
              ?>
             <tr><td vaign="middle"><?php echo $tch_usr_row['name']; ?></td>
              <td vaign="middle" ><?php echo $crt_ques_rslt['correct']; ?></td>
              <td vaign="middle" ><?php echo $count_ques_rslt['count']; ?></td>
              <td vaign="middle" ><?php echo round(($crt_ques_rslt['correct']/$count_ques_rslt['count'])*100,2); ?>%</td>
              </tr>
              <?php $i++; } ?>
            </tbody>
          </table>
        </div>
        </div>
      </div>
      </div>
    </div>
    </section>
    </div>
</main>
<div>  
<?php require_once('footer.php'); ?>    
</body>
</html>
<?php mysqli_close($conn); ?>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>