<?php
include( "../config/config.php" );
include( "../functions.php" );
include('resize-class.php');

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if (isset($_POST['submit'])) {
	$catid = mysqli_real_escape_string( $conn, $_POST['adTitle'] );
	$meta = mysqli_real_escape_string( $conn, $_POST[ 'metadata' ] );
	$about_textarea = mysqli_real_escape_string( $conn, $_POST['editor'] );
	$adCat = $_POST['adCat'];
	$icap = $_POST['imgcap'];
	$adStatus = $_POST['adStatus'];
//&& $adCat != '0'
	if (!empty($catid)) {
		
	if (!empty($_FILES['largefilename']['name'])) {	
	if (is_uploaded_file($_FILES['largefilename']['tmp_name'])) {

    $filename = $_FILES['largefilename']['name'];
	$file_part = pathinfo($filename);
	$ext = $file_part['extension'];
    $file_size = $_FILES['largefilename']['size'];
    $file_type = $_FILES['largefilename']['type'];
	$allowTypes = array('jpeg', 'jpg', 'JPG', 'PNG', 'GIF','SVG','svgz');

    if (($file_size > 2097152)){      
        $errMsg = '<div class="alert alert-danger" role="warning">File too large. File must be less than 2 megabytes.</div>'; 
	} elseif ($file_type=="image/jpeg" || $file_type=="image/jpg" || $file_type=="image/JPG" || $file_type=="image/pjpeg" || $file_type=="image/gif" || $file_type=="image/png" || $file_type=="image/svg+xml") {
	$file = "".slugify($catid)."";
	$large_image = "".$file.".".$ext;
	$path = '../uploads/blog/';
	move_uploaded_file($_FILES['largefilename']['tmp_name'],$path.$large_image);
	correctImageOrientation($path.$large_image);

	    $resizeObj = new resize($path.$large_image);

		$quality = 80;
		
		//$resizeObj -> saveImage($path.$large_image,$quality);
		
		$resizeObj -> resizeImage(1200,9999,landscape);
		$resizeObj -> saveImage($path.$large_image,$quality);

		$resizeObj -> resizeImage(600,9999,landscape);
		$resizeObj -> saveImage($path.$file.'-600w.'.$ext,$quality);
		
		   } else {
     $errMsg = '<div class="alert alert-danger" role="alert">You may only upload JPG or JPEG files.</div>';
    }
} 
	} else {
		$large_image = '';
	}
		
		
		$sql = mysqli_query($conn, "INSERT INTO blog_post(title,slug,content,featured,status,meta_details,created_at,updated_at) VALUES ('".$catid."','".slugify($catid)."','".$about_textarea."','".$large_image."','".$adStatus."','".$meta."',NOW(),NOW())");
		
		
		//$prodid = $row['id'];
		//$number = count($_POST["adCat"]);
		//$keylights = $_POST["adCat"];

		$prosql = mysqli_query($conn, "SELECT id FROM blog_post WHERE id='".$conn->insert_id."'");
		$prorow = mysqli_fetch_array($prosql, MYSQLI_ASSOC);
		
		$prodid = $prorow['id'];

	//Categories
$recomendsql = mysqli_query($conn, "SELECT COUNT(*) as total, MAX(id) as maxnum FROM blog_relationship WHERE post_id='".$prodid."'");
$recomendrow = mysqli_fetch_array($recomendsql, MYSQLI_ASSOC);

$recomendtotal = $recomendrow['total'];
$recomendmaxnum = $recomendrow['maxnum'];		
		
$recomendCount = count($_POST["adCat"]);
$recomendheading = $_POST["adCat"];
		
    //if(!empty($recomendtotal)) {
	mysqli_query($conn, "DELETE FROM blog_relationship WHERE post_id='".$prodid."'");
	for($i=0; $i<$recomendCount; $i++)
	{
		if(trim($_POST["adCat"][$i] != ''))
		{
			
			$sql=mysqli_query($conn, "INSERT INTO blog_relationship(post_id,cat_id) VALUES ('".$prodid."','".mysqli_real_escape_string($conn,$recomendheading[$i])."')");
	} 
    }
    
    if(trim($_POST["adCat"] == '')){
        	$sql=mysqli_query($conn, "INSERT INTO blog_relationship(post_id,cat_id) VALUES ('".$prodid."',0)");
        }
			
		
		
		
		mysqli_close($conn);
		$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved</div>';
		header( 'location:' . $baseurl . 'controlgear/blogPost?message=success' );
		exit();		
		
	} else {
		$errMsg = '<div class="alert alert-danger" role="alert">Required field are empty.</div>';
	}
}

if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' ) {
	$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/blogPost');</script>";

}
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
				<li>Add Post</li>
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
				<div class="col-md-8">
							<div class="form-group">
								<label class="label">Title <span class="required">*</span></label>
								<input type="text" name="adTitle" id="adTitle" class="form-control">
							</div>
							<div class="form-group">
								<label class="label">Body Content</label>
								<textarea name="editor" id="editor" class="ckeditor"></textarea>
							</div>
							<div class="form-group">
								<label class="label">Meta Details</label>
								<textarea rows="8" name="metadata" id="metadata" class="form-control"></textarea>
							</div>
						</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="label">Category <span class="required">*</span></label>
						<select name="adCat[]" id="adCat" class="selectpicker form-control" data-live-search="true" multiple>
							<option value="0">Please Select</option>
							
<?php $catsql = mysqli_query($conn, "SELECT * from blog_categories order by name asc"); while($catrow = mysqli_fetch_array($catsql))
{ ?>
<tr>
                      <option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['name']; ?></option>
<?php }  ?>
							
						</select>
						</div>
					<div class="form-group">
						<label class="label">Featured Image <span class="required">*</span> <span class="note">(Size: W: 1200px /  H: 500px)</span></label>
						<div class="custom-file">
                      <input type="file" class="custom-file-input" id="largefilename" name="largefilename">
                      <label class="custom-file-label form-control" for="largefilename">Please upload Image file only</label>
                    </div>
					</div>
					<div class="form-group">
						<label class="label">Status</label>
						<select name="adStatus" id="adStatus" class="custom-select form-control">
							<option value="0">Publish</option>
							<option value="1">Draft</option>
						</select>
					</div>
				</div>
				<div class="col-md-12">
					<button type="submit" name="submit" id="submit" class="btn btn-primary custom-btn">Save</button>
				</div>
			</div>
		</form>
	</div>
	<div class="grid bg-white box-shadow-light">
		<h5 class="heading">Blog List</h5>
			<table id="blogPost" class="table table-hover table-sm custom-table" cellspacing="0">
				<thead>
					<tr>
						<th>#ID</th>
						<th class="th-sm">Image</th>
						<th class="th-sm">Title</th>						
						<th class="th-sm">Status</th>
						<th class="th-sm"></th>
					</tr>
				</thead>
			</table>
	</div>	

	
</div>
<?php include("left-navigation.php"); ?>
<?php include("footer.php"); ?>
<?php mysqli_close($conn); ?>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>