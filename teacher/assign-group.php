<?php include( "../config/config.php" ); 
include( "../functions.php" );

if(empty($_SESSION['id'])) {
header('Location:'.$baseurl.'');
}

$link = $_SERVER[ 'PHP_SELF' ];
$link_array = explode( '/', $link );
$page = end( $link_array );

if (isset($_POST['submitgrp'])) {
	$class = $_POST['class'];
	$subject = $_POST['subject'];
	$topic = $_POST['topic'];
    $name = $_POST['grpname'];
	$pass = $_POST['tp_pass'];

	mysqli_query( $conn, "INSERT INTO grpwise(user,class,subject,topic,name,pass,status,created_at,updated_at) VALUES ('".$_SESSION['id']."','".$class."','".$subject."','".$topic."','".trim($name)."','".md5($pass)."','1',NOW(),NOW())" );
	
    $prosql = mysqli_query($conn, "SELECT id FROM grpwise WHERE id='".$conn->insert_id."'");
	$prorow = mysqli_fetch_array($prosql, MYSQLI_ASSOC);
		
	$prodid = $prorow['id'];
	//$prodslug = $prorow['slug'];
    
    //Subtopic
		$stCount = count($_POST["subtopic"]);
		$subtopic = $_POST["subtopic"];		
		if($stCount > 0)
		{
			for($i=0; $i<$stCount; $i++)
			{
				if(trim($subtopic[$i] != ''))
				{	
			mysqli_query($conn, "INSERT INTO group_subtopic(grp,subtopic) VALUES ('".$prodid."','".$subtopic[$i]."')");
				}
			}
		}
    
    
    
    
    mysqli_close($conn);	
	header('location:'.$baseurl.'group?message=success');
	exit;	
}

if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' ) {
	$errMsg = '<div class="txt-white">Successfully Saved.</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "group');</script>";

}

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
<title>Wonderkids :: Assign Group</title>
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
            <li><span>Assign Groups</span></li>
          </ul>
        </div>
        <div class="col-md-12 d-flex align-items-center">
            <h2 class="section-title">Assign practice Topics / Subtopics to Student Groups</h2>
            <div class="flex-grow-1 text-end">
              <a href="create-assign-group" class="btn btn-red custom-btn">+ ASSIGN GROUP</a>
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
        <div class="table-responsive">
          <table cellpadding="0" cellspacing="0" class="table custom-table">
            <thead>
              <tr>
                <th width="130">Practice name</th>
                <th width="100">Class</th>
                <th width="150">Subject</th>
                <th width="350">Topic / Subtopic</th>
                <th>Performance</th>
                <th width="180">Student Group(s)</th>
                <th>Status</th>
                <th></th>
</tr>
            </thead>
            <tbody>
              <?php $i=1; $grpSQL = mysqli_query($conn, "SELECT id,class,subject,grp_name,status FROM assign_grp WHERE user=".$_SESSION['id']."");
              while($grpROW = mysqli_fetch_array($grpSQL, MYSQLI_ASSOC)) { 
                $clsSQL = mysqli_query($conn, "SELECT name FROM subject_class WHERE id=".$grpROW['class']." and type=2 and status=1");
                $clsROW = mysqli_fetch_array($clsSQL, MYSQLI_ASSOC);

                $sbjSQL = mysqli_query($conn, "SELECT name FROM subject_class WHERE id=".$grpROW['subject']." and type=1 and status=1");
                $sbjROW = mysqli_fetch_array($sbjSQL, MYSQLI_ASSOC);
                
              ?>
             <tr><td colspan="6" class="divider"></td></tr>
              <tr><td><?php echo $grpROW['grp_name']; ?></td>
              <td><?php echo $clsROW['name']; ?></td>
              <td><?php echo $sbjROW['name']; ?></td>
              <td>
              <ul class="nolist clickList">
              <?php $topicSQL = mysqli_query($conn, "SELECT DISTINCT b.id,b.topic,a.assign_grp FROM assign_grpids as a INNER JOIN topics_subtopics as b on b.id=a.topic WHERE a.assign_grp=".$grpROW['id']." and b.parent=0 and b.status=1");
              while($topicROW = mysqli_fetch_array($topicSQL, MYSQLI_ASSOC)) { ?>
             <li><div class="ico"><span><?php echo $topicROW['topic']; ?></span></div>
              <ul class="sublist hide">
                <?php $subtopicSQL = mysqli_query($conn, "SELECT b.subtopic FROM assign_grpids as a INNER JOIN topics_subtopics as b on b.id=a.subtopic WHERE b.parent=".$topicROW['id']." and a.assign_grp=".$grpROW['id']." and b.status=1");
                while($subtopicROW = mysqli_fetch_array($subtopicSQL, MYSQLI_ASSOC)) { ?>
                 <li><span><?php echo $subtopicROW['subtopic']; ?></span></li>
             <?php } ?>
              </ul>
              </li>
              <?php } ?>
              </ul>
              </td>
              <td><a href="performance?id=<?php echo $grpROW['id'];?>" class="link">Click here</a></td>
              <td>
<ul class="nolist">
<?php $grpsSQL = mysqli_query($conn, "SELECT b.name FROM assign_grpids as a INNER JOIN grpwise as b on b.id=a.grpids WHERE a.assign_grp=".$grpROW['id']." and b.status=1");
while($grpsROW = mysqli_fetch_array($grpsSQL, MYSQLI_ASSOC)) { ?>
<li><span><?php echo $grpsROW['name']; ?></span></li>
<?php } ?>
<ul>
</td>
              <td width="50"><div class="form-check form-switch custom-switch">
  <input class="form-check-input notselect" name="grpcheck" type="checkbox" data-id="<?php echo $grpROW['id']; ?>" value="<?php echo $grpROW['status'];?>" role="switch" id="flexSwitchCheckDefault_<?php echo $i; ?>" <?php if($grpROW['status'] == '1') { echo "checked"; } else { echo " ";} ?> />
  <label class="form-check-label" for="flexSwitchCheckDefault_<?php echo $i; ?>"></label>
</div></td>
<td width="50" class="text-end">
  <a href="edit-assign-group?id=<?php echo $grpROW['id']; ?>" class="edit-dots" title="Edit Group"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M14.0625 18.75C14.0625 19.059 13.9709 19.3611 13.7992 19.6181C13.6275 19.875 13.3835 20.0753 13.0979 20.1936C12.8124 20.3118 12.4983 20.3428 12.1952 20.2825C11.8921 20.2222 11.6137 20.0734 11.3951 19.8549C11.1766 19.6363 11.0278 19.3579 10.9675 19.0548C10.9072 18.7517 10.9382 18.4376 11.0564 18.1521C11.1747 17.8666 11.375 17.6225 11.6319 17.4508C11.8889 17.2791 12.191 17.1875 12.5 17.1875C12.9144 17.1875 13.3118 17.3521 13.6049 17.6452C13.8979 17.9382 14.0625 18.3356 14.0625 18.75ZM12.5 7.8125C12.809 7.8125 13.1111 7.72086 13.3681 7.54917C13.625 7.37748 13.8253 7.13345 13.9436 6.84794C14.0618 6.56243 14.0928 6.24827 14.0325 5.94517C13.9722 5.64208 13.8234 5.36367 13.6049 5.14515C13.3863 4.92663 13.1079 4.77781 12.8048 4.71752C12.5017 4.65723 12.1876 4.68818 11.9021 4.80644C11.6165 4.9247 11.3725 5.12497 11.2008 5.38192C11.0291 5.63887 10.9375 5.94097 10.9375 6.25C10.9375 6.6644 11.1021 7.06183 11.3951 7.35486C11.6882 7.64788 12.0856 7.8125 12.5 7.8125ZM12.5 10.9375C12.191 10.9375 11.8889 11.0291 11.6319 11.2008C11.375 11.3725 11.1747 11.6165 11.0564 11.9021C10.9382 12.1876 10.9072 12.5017 10.9675 12.8048C11.0278 13.1079 11.1766 13.3863 11.3951 13.6049C11.6137 13.8234 11.8921 13.9722 12.1952 14.0325C12.4983 14.0928 12.8124 14.0618 13.0979 13.9436C13.3835 13.8253 13.6275 13.625 13.7992 13.3681C13.9709 13.1111 14.0625 12.809 14.0625 12.5C14.0625 12.0856 13.8979 11.6882 13.6049 11.3951C13.3118 11.1021 12.9144 10.9375 12.5 10.9375Z" fill="#666666"/>
</svg></a>
</td>
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