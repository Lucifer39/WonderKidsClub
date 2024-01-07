<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

?>
<?php if($sessionrow['isAdmin'] == 1 && $sessionrow['type'] != 99) { ?>
<?php include("header.php"); ?>
<div class="breadcrumbs-title-container">
	<div class="container-fluid">
		<h5 class="page-title">Users - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>controlGear/registerationUsers/"><i class="fa fa-home"></i></a>
				</li>
				<li>Unverified Users</li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
	<div class="col-md-12">
			<div class="grid bg-white box-shadow-light">
				<h5 class="heading d-flex align-items-center"><span class="mr-3">Unverified Users</span></h5>
					<div class="">
				<table id="datalist" class="table table-hover table-sm custom-table" cellspacing="0">
						<thead>
							<tr>
								<th><input type="text" id="fullnameSearch" class="form-control"></th>
								<th><input type="text" id="emailSearch" class="form-control"></th>
								<th><input type="text" id="contactSearch" class="form-control"></th>
								<th><input type="text" id="userType" class="form-control"></th>
								<th><input type="text" id="courseSearch" class="form-control"></th>
								<th><input type="text" id="yearSearch" class="form-control"></th>
								<th><input type="text" id="collegeSearch" class="form-control"></th>
								<th><input type="text" id="companySearch" class="form-control"></th>
								<th><input type="text" id="reasonfor" class="form-control"></th>
								<th><input type="text" id="otherreasonfor" class="form-control"></th>
								<th></th>
							</tr>
							<tr>
								<th width="100">#ID</th>
								<th width="100">Name</th>
								<th>Email</th>
								<th>Contact</th>
								<th>Role</th>
								<th>Class</th>
								<th>DOB</th>
								<th>isVerified</th>
								<th>Status</th>
								<th>Joining Date</th>
								<th></th>
							</tr>
						</thead>
						
					</table>
				</div>
				</div>
		
		</div>
	</div>


</div>
<?php include("left-navigation.php"); ?>
<?php include("footer.php"); ?>
<?php mysqli_close($conn); ?>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>