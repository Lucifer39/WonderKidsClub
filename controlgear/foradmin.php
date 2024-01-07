<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

$sql = mysqli_query($conn, "SELECT limit_per_day,offer_start,offer_end FROM for_admin WHERE id=1");
$row = mysqli_fetch_array($sql);


if (isset($_POST['submit'])) {
	$limit = $_POST['limit'];
	$start = $_POST['strdate'];
	$end = $_POST['enddate'];

	mysqli_query( $conn, "update for_admin Set limit_per_day='".$limit."',offer_start='".$start."',offer_end='".$end."' WHERE id=1" );		
	mysqli_close($conn);
	header( 'location:' . $_SERVER['REQUEST_URI']);
	exit();	
}
?>
<?php if($sessionrow['isAdmin'] == 1 && $sessionrow['type'] != 99) { ?>
<?php include("header.php"); ?>
<div class="breadcrumbs-title-container">
	<div class="container-fluid">
		<h5 class="page-title">For Admin - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
				</li>
				<li>For Admin</li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="grid bg-white box-shadow-light">
		<div id="msg" class="msg">
			<?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
		</div>
		<form id="postForm" action="" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-5">
							<div class="form-group">
								<label class="label">Question Limit Per Day</label>
								<input type="number" name="limit" id="limit" class="form-control" placeholder="Only digits" value="<?php echo $row['limit_per_day']; ?>">
							</div>
							<div class="form-row tour-group">
						<div class="col-6 form-group">
							<label class="label mb-1">Offer Start Date</label>
							<input type="date" name="strdate" id="strdate" class="form-control startdate" value="<?php echo $row['offer_start']; ?>">
						</div>
						<div class="col-6 form-group">
							<label class="label mb-1">Offer End Date</label>
							<input type="date" name="enddate" id="enddate" class="form-control enddate" value="<?php echo $row['offer_end']; ?>">
						</div>
						</div>
						</div>
				<div class="col-md-12">
					<button type="submit" name="submit" id="submit" class="btn btn-primary custom-btn">Save</button>
				</div>
			</div>
		</form>
	</div>	
</div>
<?php include("left-navigation.php"); ?>
<?php include("footer.php"); ?>
<?php mysqli_close($conn); ?>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>