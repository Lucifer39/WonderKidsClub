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
		<h5 class="page-title">Orders - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>controlgear/registerationUsers/"><i class="fa fa-home"></i></a>
				</li>
				<li>Orders</li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="grid bg-white box-shadow-light">
				<h5 class="heading d-flex align-items-center"><span class="mr-3">Orders List</span></h5>

					<div class="">
				<table id="datalist" class="table table-hover table-sm custom-table" cellspacing="0">
						<thead>
							<tr>
							    <th><input type="text" id="userSearch" class="form-control"></th>
								<th><input type="text" id="fullnameSearch" class="form-control"></th>
								<th><input type="text" id="emailSearch" class="form-control"></th>
								<th><input type="text" id="contactSearch" class="form-control"></th>
								<th><input type="text" id="clsSearch" class="form-control"></th>
								<th><input type="text" id="schSearch" class="form-control"></th>
								<th><input type="text" id="statusSearch" class="form-control"></th>
								<th></th>
							</tr>
							<tr>
								<th>User Name / ID</th>
								<th>Email</th>
								<th>Transcation ID</th>
								<th>Paid Amt</th>
								<th>Plan</th>
								<th>Status</th>
								<th>Created Date</th>
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