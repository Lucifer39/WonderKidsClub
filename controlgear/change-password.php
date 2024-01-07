<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'controlgear/login');

$usersql = mysqli_query($conn, "SELECT isAdmin,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($usersql);

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
	header( 'location:' . $baseurl . 'controlgear/change-password?message=updated');
	exit;
	} else {
		$errMsg = '<div class="alert alert-danger" role="alert">New password is same as old password. Please try new password.</div>';
	}
}

if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'updated' ) {
	$errMsg = '<div class="alert alert-success" role="alert">Successfully Updated.</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/change-password');</script>";
}
?>
<?php include("header.php"); ?>
<main>
<div class="breadcrumbs-title-container">
	<div class="container-fluid align-items-center">
		<h5 class="page-title">Change Password - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>controlgear/dashboard"><i class="fa fa-home"></i></a>
				</li>
				<li>Change Password</li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="grid bg-white box-shadow-light">
				<div id="msg" class="msg">
					<?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
				</div>				
				<form id="Passform" action="" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-6">
							<h5 class="heading pb-3 mb-4 bb-1">Change Password</h5>
							<div class="form-group">
							<label class="label">Old Password <span class="required">*</span></label>
							<input type="password" name="oldPassword" id="oldPassword" class="form-control" value="<?php echo $sessionrow['oldPassword']; ?>" placeholder="Enter Old Password">
								<span class="error"></span>
						</div>
							<div class="form-group">
							<label class="label">New Password <span class="required">*</span></label>
							<input type="password" name="userPassword" id="userPassword" class="form-control" value="<?php echo $sessionrow['fullname']; ?>" placeholder="Enter New Password">
								<span class="note">(Should be 8 character long)</span>
								<span class="error"></span>
						</div>
							<div class="form-group">
							<label class="label">Confirm New Password <span class="required">*</span></label>
							<input type="password" name="userCnfPassword" id="userCnfPassword" class="form-control" value="<?php echo $sessionrow['fullname']; ?>" placeholder="Enter Confirm New Password">
								<span class="error"></span>
						</div>
						</div>
						<div class="col-md-12">
							<button type="submit" name="submit" id="submit" class="btn btn-primary custom-btn">Change Password</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>	
</main>
<?php include("left-navigation.php"); ?>
<?php include("footer.php"); ?>
<?php mysqli_close($conn); ?>