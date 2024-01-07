<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if ( isset( $_POST[ 'update' ] ) ) {
	$catid = mysqli_real_escape_string( $conn, $_POST[ 'catname' ] );

	if ( !empty( $catid ) ) {
		$resultset_1 = mysqli_query($conn, "select name from blog_categories where name='".trim($catid)."'");
		$count = mysqli_num_rows($resultset_1);
 if($count == 0)
    {  
	
	$checkslug = mysqli_query($conn, "select COUNT(slug) as selectcount,slug from blog_categories where slug='".slugify($catid)."'");
	$slugrow = mysqli_fetch_array($checkslug);
	
	if(!empty($slugrow[0] > 0)) {
		$slug = $slugrow[0]+1;
		$slug = slugify($catid)."-".$slug;	
	} else {
		$slug = slugify($catid);
	}

	mysqli_query( $conn, "update blog_categories Set name='" . trim($catid) . "', slug='" . $slug . "', updated_at=NOW() WHERE id=" . $_POST[ 'bookId' ] . "" );
	mysqli_close( $conn );
	header( 'location:' . $baseurl . 'controlgear/blogCategories' );
	exit;
}
	}
}

if ( isset( $_POST[ 'submit' ] ) ) {
	$catid = mysqli_real_escape_string( $conn, $_POST[ 'categoryName' ] );

	if ( !empty( $catid ) ) {
		$resultset_1 = mysqli_query($conn, "select name from blog_categories where name='".$catid."'");
		$count = mysqli_num_rows($resultset_1);
 if($count == 0)
    {   
	 
	 $checkslug = mysqli_query($conn, "select COUNT(slug) as selectcount,slug from blog_categories where slug='".slugify($catid)."'");
	$slugrow = mysqli_fetch_array($checkslug);
	
	if(!empty($slugrow[0] > 0)) {
		$slug = $slugrow[0]+1;
		$slug = slugify($catid)."-".$slug;	
	} else {
		$slug = slugify($catid);
	}
	 
		$sql = mysqli_query( $conn, "INSERT INTO blog_categories(name,slug,status,created_at,updated_at) VALUES ('" . $catid . "','" . $slug . "',1,NOW(), NOW())" );
		mysqli_close( $conn );
		$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved</div>';
		header( 'location:' . $baseurl . 'controlgear/blogCategories?message=success' );
		exit;
	 }else{
       $errMsg = '<div class="alert alert-danger" role="alert">The "'.$catid.'" is already present.</div>';
    }
	} else {
		$errMsg = '<div class="alert alert-danger" role="alert">Required field are empty.</div>';
	}
}

if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' ) {
	$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/blogCategories');</script>";

}
//mysqli_close($conn);
?>
<?php if($sessionrow['isAdmin'] == 1 || $sessionrow['type'] != 99) { ?>
<?php include("header.php"); ?>
<div class="breadcrumbs-title-container">
	<div class="container-fluid">
		<h5 class="page-title">Blog Management - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
				</li>
				<li>Categories</li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-5">
			<div class="grid bg-white box-shadow-light">
				<div id="msg" class="msg">
					<?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
				</div>
				<form id="myForm" action="" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-12 form-group">
							<label class="label">Categories Name <span class="required">*</span></label>
							<input type="text" name="categoryName" id="categoryName" class="form-control">
						</div>
						<div class="col-md-12">
							<button type="submit" name="submit" id="submit" class="btn btn-primary custom-btn">Save</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-7">
			<div class="grid bg-white box-shadow-light">
				<h5 class="heading">Categories List</h5>

					<table id="blogCategories" class="table table-hover table-sm custom-table" cellspacing="0">
						<thead>
							<tr>
								<th>#ID</th>
								<th>Category Name</th>
								<th>Status</th>
								<th>Delete</th>
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