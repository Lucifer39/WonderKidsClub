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
          </ul>
        </div>
        <div class="col-md-12 d-flex align-items-center">
            <h2 class="section-title">Create Student Groups by Sections or any specific needs</h2>
            <div class="flex-grow-1 text-end">
              <a href="create-group" class="btn btn-red custom-btn">+ CREATE GROUP</a>
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
                <th>Group Name</th>
                <th>Password</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Student List</th>
                <th>Group Link</th>
                <th>Status</th>
                <th></th>
</tr>
            </thead>
            <tbody>
              <?php $i=1; $grpSQL = mysqli_query($conn, "SELECT id,class,subject,name,pass,status,link FROM grpwise WHERE user=".$_SESSION['id']."");
              while($grpROW = mysqli_fetch_array($grpSQL, MYSQLI_ASSOC)) { 
                $clsSQL = mysqli_query($conn, "SELECT name,slug FROM subject_class WHERE id=".$grpROW['class']." and type=2 and status=1");
                $clsROW = mysqli_fetch_array($clsSQL, MYSQLI_ASSOC);

                $sbjSQL = mysqli_query($conn, "SELECT name,slug FROM subject_class WHERE id=".$grpROW['subject']." and type=1 and status=1");
                $sbjROW = mysqli_fetch_array($sbjSQL, MYSQLI_ASSOC);
                
              ?>
             <tr><td colspan="6" class="divider"></td></tr>
              <tr><td><?php echo $grpROW['name']; ?></td>
              <td><a href="javascript:void(0);" data-link="<?php echo $grpROW['pass']; ?>" class="link copylink agn-pass"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17 7H22V17H17V19C17 19.2652 17.1054 19.5196 17.2929 19.7071C17.4804 19.8946 17.7348 20 18 20H20V22H17.5C16.95 22 16 21.55 16 21C16 21.55 15.05 22 14.5 22H12V20H14C14.2652 20 14.5196 19.8946 14.7071 19.7071C14.8946 19.5196 15 19.2652 15 19V5C15 4.73478 14.8946 4.48043 14.7071 4.29289C14.5196 4.10536 14.2652 4 14 4H12V2H14.5C15.05 2 16 2.45 16 3C16 2.45 16.95 2 17.5 2H20V4H18C17.7348 4 17.4804 4.10536 17.2929 4.29289C17.1054 4.48043 17 4.73478 17 5V7ZM2 7H13V9H4V15H13V17H2V7ZM20 15V9H17V15H20ZM8.5 12C8.5 11.6022 8.34196 11.2206 8.06066 10.9393C7.77936 10.658 7.39782 10.5 7 10.5C6.60218 10.5 6.22064 10.658 5.93934 10.9393C5.65804 11.2206 5.5 11.6022 5.5 12C5.5 12.3978 5.65804 12.7794 5.93934 13.0607C6.22064 13.342 6.60218 13.5 7 13.5C7.39782 13.5 7.77936 13.342 8.06066 13.0607C8.34196 12.7794 8.5 12.3978 8.5 12ZM13 10.89C12.39 10.33 11.44 10.38 10.88 11C10.32 11.6 10.37 12.55 11 13.11C11.55 13.63 12.43 13.63 13 13.11V10.89Z" fill="#212529"/>
</svg><span class="ms-2">Copy Password</span></a></td>
              <td><?php echo $clsROW['name']; ?></td>
              <td><?php echo $sbjROW['name']; ?></td>
              <td><a href="grp_students?id=<?php echo $grpROW['id'];?>" class="link">Click here</a></td>
              <td>
                <a href="javascript:void(0);" data-link="<?php echo $baseurl.'link/'.$grpROW['link']; ?>" class="link fw-500 copylink agn-url"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M5 22C4.45 22 3.979 21.804 3.587 21.412C3.195 21.02 2.99934 20.5493 3 20V6H5V20H16V22H5ZM9 18C8.45 18 7.979 17.804 7.587 17.412C7.195 17.02 6.99934 16.5493 7 16V4C7 3.45 7.196 2.979 7.588 2.587C7.98 2.195 8.45067 1.99934 9 2H18C18.55 2 19.021 2.196 19.413 2.588C19.805 2.98 20.0007 3.45067 20 4V16C20 16.55 19.804 17.021 19.412 17.413C19.02 17.805 18.5493 18.0007 18 18H9ZM9 16H18V4H9V16Z" fill="#212529"/>
</svg><span class="ms-1">Copy Url</span></a>
              </td>
              <td width="50"><div class="form-check form-switch custom-switch">
  <input class="form-check-input notselect" name="grpcheck" type="checkbox" data-id="<?php echo $grpROW['id']; ?>" value="<?php echo $grpROW['status'];?>" role="switch" id="flexSwitchCheckDefault_<?php echo $i; ?>" <?php if($grpROW['status'] == '1') { echo "checked"; } else { echo " ";} ?> />
  <label class="form-check-label" for="flexSwitchCheckDefault_<?php echo $i; ?>"></label>
</div></td>
<td width="50" class="text-end">
  <a href="create-group?id=<?php echo $grpROW['id']; ?>" class="edit-dots" title="Edit Group"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
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