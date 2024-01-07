<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,id,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

$url = trim($_SERVER["REQUEST_URI"],"/");
$id = substr($url, strpos($url, '=') + 1);

$sql = mysqli_query($conn, "SELECT id,name,description,price,discount,total_days FROM plan WHERE id=".$id."");
$row = mysqli_fetch_array($sql);

if (isset($_POST['submit']) || isset($_POST['update'])) {
	$pname = $_POST['pl_name'];
	$pdesc = $_POST['pl_desc'];
	$pprice = $_POST['pl_price'];
	$pdiscount = $_POST['pl_discount'];
	$ptdays = $_POST['pl_days'];

	 if (!empty($pname) || !empty($pprice)) {	
		
		if(isset($_POST['update'])) {

			mysqli_query( $conn, "update plan Set name='".$pname."',description='".$pdesc."',price='".$pprice."',discount='".$pdiscount."',total_days='".$ptdays."',modified=NOW() WHERE id=".$row['id']."" );

		} elseif(isset($_POST['submit'])) {

			mysqli_query( $conn, "INSERT INTO plan(name,description,price,discount,total_days,status,created,modified) VALUES ('".$pname."','".$pdesc."','".$pprice."','".$pdiscount."','".$ptdays."',1,NOW(),NOW())" );

		}

		mysqli_close($conn);

		if(isset($_POST['update'])) {

			header( 'location:' . $baseurl . 'controlgear/packages?id='.$id);

		} elseif(isset($_POST['submit'])) {

			$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved</div>';
			header( 'location:' . $baseurl . 'controlgear/packages?message=success' );

		}		
		exit;	
	} else {
		$errMsg = '<div class="alert alert-danger" role="alert">Required field are empty.</div>';
	}
}

if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' ) {
	$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/packages');</script>";

} 


?>
<?php if($sessionrow['isAdmin'] == 1) { ?>
<?php include("header.php"); ?>
<div class="breadcrumbs-title-container">
	<div class="container-fluid">
		<h5 class="page-title">Packages - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
				</li>
				<li>SmartyPacks (Packages)</li>
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
				<form id="myForm" action="" method="post" enctype="multipart/form-data">
					<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label mb-1 d-block">Plan name <span class="required">*</span></label>
							<input type="text" name="pl_name" class="form-control" value="<?php echo $row['name']; ?>">
						</div>	
						<div class="form-group">
							<label class="label mb-1 d-block">Plan description</label>
							<textarea rows="5" name="pl_desc" class="form-control"><?php echo $row['description']; ?></textarea>
						</div>
						<div class="form-row">
						<div class="form-group col-4">
							<label class="label mb-1 d-block">Price <span class="required">*</span></label>
							<input type="number" name="pl_price" class="form-control" value="<?php echo $row['price']; ?>">
						</div>	
						<div class="form-group col-4">
							<label class="label mb-1 d-block">Discount (%)</label>
							<input type="number" name="pl_discount" class="form-control" value="<?php echo $row['discount']; ?>">
						</div>
						<div class="form-group col-4">
							<label class="label mb-1 d-block">Duration (days)</label>
							<input type="number" name="pl_days" class="form-control" value="<?php echo $row['total_days']; ?>">
						</div>
</div>
<div class="form-group">
						<?php if(!empty($row['id'])) { ?>
							<div class="d-flex align-items-center">
							<button type="submit" name="update" id="submit" class="btn btn-primary custom-btn">update</button>
							<a href="packages" class="link ml-2 heading txt-dark flex-grow-1 mb-0 text-right"><i class="fa fa-plus-circle"></i> Create Package</a>
						</div>
						<?php } else { ?>
							<button type="submit" name="submit" id="submit" class="btn btn-primary custom-btn">Save</button>
						<?php } ?>	
						</div>
					</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-12">
			<div class="grid bg-white box-shadow-light">
				<h5 class="heading">List of Packages</h5>

					<table id="datalist" class="table table-hover table-sm custom-table" cellspacing="0">
						<thead>
							<tr>
								<th width="50">#ID</th>
								<th>Plan name</th>
								<th width="50">Price</th>
								<th width="50">Discount</th>
								<th width="100">Status</th>
								<th width="50"></th>
							</tr>
						</thead>
						
					</table>
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