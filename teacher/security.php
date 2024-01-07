<?php include( "../config/config.php" ); 
include( "../functions.php" );

if(empty($_SESSION['id'])) {
header('Location:'.$baseurl.'');
}

$link = $_SERVER[ 'PHP_SELF' ];
$link_array = explode( '/', $link );
$page = end( $link_array );

$passsql = mysqli_query($conn, "SELECT password FROM users where id='".$_SESSION['id']."'");
$passrow = mysqli_fetch_assoc($passsql);

if (isset( $_POST['submit'])) {
	$oldpass = mysqli_real_escape_string($conn, $_POST['oldPassword']);
	$changepass = mysqli_real_escape_string($conn, $_POST['userPassword']);
	$cnf_changepass = mysqli_real_escape_string($conn, $_POST['userCnfPassword']);
	
	if(md5($oldpass) != $passrow['password']) {
		$errMsg = '<div class="alert alert-danger" role="alert">Old password not match.</div>';
	} elseif(md5($changepass) != $passrow['password']) {	
	mysqli_query( $conn, "update users Set password='".md5($changepass)."', updated_at=NOW() WHERE id='".$_SESSION['id']."'");	
	header( 'location:security?message=updated');
	exit;
	} else {
		$errMsg = '<div class="alert alert-danger" role="alert">New password is same as old password. Please try new password.</div>';
	}
}

if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'updated' ) {
	$errMsg = '<div class="alert alert-success" role="alert">Successfully Updated.</div>';
	echo "<script>window.history.pushState('','','security');</script>";
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
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<title>Wonderkids :: Security and logins</title>
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
            <li><span>My Profile : Security and logins</span></li>
          </ul>
        </div>
      </div>
    </div>
    </section>
    <section class="section pt-0 ml-1 mr-1">
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-2">
        <ul class="linklist mt-4">
          <li><a href="profile">Personal Information</a></li>
          <li><a href="security" class="active">Security and logins</a></li>
        </ul> 
      </div>
      <div class="col-md-10">
        <div class="block-widget p-4">
          <div class="mb-4 mt-2">
          <h2 class="section-title">Security and logins</h2>
          </div>
          <div id="msg" class="msg">
					<?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
				</div>	
        <form action="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
            <div class="mb-3">
            <label class="label">Old Password</label>
            <input type="password" name="oldPassword" id="oldPassword" class="form-control custom-control" placeholder="Type old password" required>
            <span class="error"></span>
          </div>
          <div class="mb-3">
            <label class="label">New Password</label>
            <input type="password" name="userPassword" id="userPassword" class="form-control custom-control" placeholder="Type new password" required>
            <span class="note">(Should be 8 character long)</span>
            <span class="error"></span>
          </div>
          <div class="mb-3">
            <label class="label">Confirm Password</label>
            <input type="password" name="userCnfPassword" id="userCnfPassword" class="form-control custom-control" placeholder="Type confirm password" required>
            <span class="error"></span>
          </div>
          <input type="submit" name="submit" class="btn btn-red custom-btn" value="Save">
            </div>
          </div>
        </form>
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