<?php
include( "../config/config.php" );
include( "../functions.php" );
include('resize-class.php');

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

$url = trim($_SERVER["REQUEST_URI"],"/");
$id = substr($url, strpos($url, '=') + 1);

$sql = mysqli_query($conn, "SELECT id,hero_img,bg_img,body,url FROM homepage_banner WHERE id=".$id."");
$row = mysqli_fetch_array($sql);

if (isset($_POST['submit']) || isset($_POST['update'])) {
	$about_textarea = mysqli_real_escape_string( $conn, $_POST['editor'] );
	$url = mysqli_real_escape_string( $conn, $_POST['url'] );

	//if (!empty($catid) && $adCat != '0' && $type != '0') {
		
		if (!empty($_FILES['filename']['name'])) {	
		if (is_uploaded_file($_FILES['filename']['tmp_name'])) {

    $filename = $_FILES['filename']['name'];
	$file_part = pathinfo($filename);
	$ext = $file_part['extension'];
    $file_size = $_FILES['filename']['size'];
    $file_type = $_FILES['filename']['type'];
	$allowTypes = array('jpeg', 'jpg', 'JPG', 'PNG', 'GIF','SVG','svgz');
	$filenameWithoutExtension = $file_part['filename'];

    if (($file_size > 2097152)){      
        $errMsg = '<div class="alert alert-danger" role="warning">File too large. File must be less than 2 megabytes.</div>'; 
	} elseif ($file_type=="image/jpeg" || $file_type=="image/jpg" || $file_type=="image/JPG" || $file_type=="image/pjpeg" || $file_type=="image/gif" || $file_type=="image/png" || $file_type=="image/svg+xml") {
	$file = "".slugify($filenameWithoutExtension)."";
	$thumb_image = "".$file."-hero-image.".$ext;
	$path = '../uploads/slidingBanner/';
	move_uploaded_file($_FILES['filename']['tmp_name'],$path.$thumb_image);
	correctImageOrientation($path.$thumb_image);

	    $resizeObj = new resize($path.$thumb_image);

		$quality = 80;
		
		//$resizeObj -> saveImage($path.$thumb_image,$quality);
		
		//$resizeObj -> resizeImage(200,9999,landscape);
		$resizeObj -> saveImage($path.$thumb_image,$quality);
		
		   } else {
     $errMsg = '<div class="alert alert-danger" role="alert">You may only upload JPG or JPEG files.</div>';
    }
} 
	} else {
		$thumb_image = $row['hero_img'];
	}
		
		//LargeFilename
		if (!empty($_FILES['largefilename']['name'])) {	
		if (is_uploaded_file($_FILES['largefilename']['tmp_name'])) {

    $filename = $_FILES['largefilename']['name'];
	$file_part = pathinfo($filename);
	$ext = $file_part['extension'];
    $file_size = $_FILES['largefilename']['size'];
    $file_type = $_FILES['largefilename']['type'];
	$allowTypes = array('jpeg', 'jpg', 'JPG', 'PNG', 'GIF','SVG','svgz');
	$filenameWithoutExtension = $file_part['filename'];

    if (($file_size > 2097152)){      
        $errMsg = '<div class="alert alert-danger" role="warning">File too large. File must be less than 2 megabytes.</div>'; 
	} elseif ($file_type=="image/jpeg" || $file_type=="image/jpg" || $file_type=="image/JPG" || $file_type=="image/pjpeg" || $file_type=="image/gif" || $file_type=="image/png" || $file_type=="image/svg+xml") {
	$file = "".slugify($filenameWithoutExtension)."";
	$large_image = "".$file."-bg-image.".$ext;
	$path = '../uploads/slidingBanner/';
	move_uploaded_file($_FILES['largefilename']['tmp_name'],$path.$large_image);
	correctImageOrientation($path.$large_image);

	    $resizeObj = new resize($path.$large_image);

		$quality = 80;
		
		//$resizeObj -> saveImage($path.$large_image,$quality);
		
		//$resizeObj -> resizeImage(1200,9999,landscape);
		$resizeObj -> saveImage($path.$large_image,$quality);
		
		   } else {
     $errMsg = '<div class="alert alert-danger" role="alert">You may only upload JPG or JPEG files.</div>';
    }
} 
	} else {
		$large_image = $row['bg_img'];
	}
		
	if(isset($_POST['update'])) {

		mysqli_query( $conn, "update homepage_banner Set body='".$about_textarea."',url='".$url."', hero_img='".$thumb_image."', bg_img='".$large_image."',updated_at=NOW() WHERE id=".$id."" );
		mysqli_close($conn);
		header( 'location:' . $baseurl . 'controlGear/homeBanner?id='.$id);

	} elseif(isset($_POST['submit'])) {
		$sql = mysqli_query($conn, "INSERT INTO homepage_banner(body,url,hero_img,bg_img,status,created_at,updated_at) VALUES ('".$about_textarea."',url='".$url."','".$thumb_image."','".$large_image."',1,NOW(),NOW())");
		mysqli_close($conn);
		$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved</div>';
		header( 'location:' . $baseurl . 'controlGear/homeBanner?message=success' );
		exit();		
	}
	//} else {
		//$errMsg = '<div class="alert alert-danger" role="alert">Required field are empty.</div>';
	//}
}

if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' ) {
	$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlGear/homeBanner');</script>";

}
?>
<?php if($sessionrow['isAdmin'] == 1) { ?>
<?php include("header.php"); ?>
<div class="breadcrumbs-title-container">
	<div class="container-fluid">
		<h5 class="page-title">Homepage - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>newsadmin/dashboard/"><i class="fa fa-home"></i></a>
				</li>
				<li>Sliding Banner</li>
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
						<label class="label">Banner Text <span class="required">*</span></label>
						<textarea name="editor" id="editor" class="ckeditor"><?php echo $row['body']; ?></textarea>
					</div>
					<div class="form-group">
								<label class="label">Url</label>
								<input type="text" name="url" id="url" class="form-control" value="<?php echo $row['url']; ?>">
							</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="label">Banner Image <span class="required">*</span> <span class="note">(Size: W: 500px /  H: 500px)</span></label>
						<?php if(isset($row['hero_img'])){ if($row['hero_img'] == True){ echo "<figure><img src='../uploads/slidingBanner/".substr($row['hero_img'], 0 , (strrpos($row['hero_img'], "."))).".".pathinfo($row['hero_img'], PATHINFO_EXTENSION)."' class='img-fluid' /></figure>"; } } ?>
						<div class="custom-file">
                      <input type="file" class="custom-file-input" id="filename" name="filename">
                      <label class="custom-file-label form-control" for="filename"><?php if(isset($row['hero_img'])) { echo $row['hero_img']; } else { echo "Please upload Image file only"; } ?></label>
                    </div>
					</div>
					<div class="form-group">
						<label class="label">Background Image <span class="required">*</span> <span class="note">(Size: W: 1920px /  H: 400px)</span></label>
						<?php if(isset($row['bg_img'])){ if($row['bg_img'] == True){ echo "<figure><img src='../uploads/slidingBanner/".substr($row['bg_img'], 0 , (strrpos($row['bg_img'], "."))).".".pathinfo($row['bg_img'], PATHINFO_EXTENSION)."' class='img-fluid' /></figure>"; } } ?>
						<div class="custom-file">
                      <input type="file" class="custom-file-input" id="largefilename" name="largefilename">
                      <label class="custom-file-label form-control" for="largefilename"><?php if(isset($row['bg_img'])) { echo $row['bg_img']; } else { echo "Please upload Image file only"; } ?></label>
                    </div>
					</div>
				</div>
				<div class="col-md-12">
				<?php if(isset($_GET['id'])) { ?>
							<button type="submit" name="update" id="update" class="btn btn-primary custom-btn">update</button>
							<?php } else { ?>
					<button type="submit" name="submit" id="submit" class="btn btn-primary custom-btn">Save</button>
					<?php } ?>
				</div>
			</div>
		</form>
	</div>
	<div class="grid bg-white box-shadow-light">
		<h5 class="heading">Banner List</h5>
			<table id="datalist" class="table table-hover table-sm custom-table" cellspacing="0">
				<thead>
					<tr>
						<th>#ID</th>
						<th class="th-sm">Title</th>
						<th class="th-sm">Banner</th>
						<th class="th-sm">Background</th>
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