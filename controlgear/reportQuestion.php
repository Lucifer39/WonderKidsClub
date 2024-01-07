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
		<h5 class="page-title">Report Question(s) - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>controlgear/registerationUsers/"><i class="fa fa-home"></i></a>
				</li>
				<li>Report Question(s)</li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="grid bg-white box-shadow-light">
				<h5 class="heading d-flex align-items-center"><span class="mr-3">List of report questions</span></h5>

					<div class="">
				<table id="datalist" class="table table-hover table-sm custom-table" cellspacing="0">
						<thead>
							<tr>
							    <th><input type="text" id="quesid" class="form-control"></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
                                <th></th>
                                <th></th>
								<th><input type="text" id="dateSearch" class="form-control"></th>
							</tr>
							<tr>
								<th>Ques ID</th>
								<th>Question</th>
								<th>Opt A</th>
								<th>Opt B</th>
								<th>Opt C</th>
								<th>Opt D</th>
                                <th>Correct Answer</th>
								<th>Status</th>
                                <th>Report Date</th>
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