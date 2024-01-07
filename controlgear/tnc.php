<?php
include( "../config/config.php" );
include( "../functions.php" );
include('resize-class.php');

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

$sql = mysqli_query($conn, "SELECT id,body,meta_details FROM other_pages WHERE id=4");
$row = mysqli_fetch_array($sql);

if (isset($_POST['submit'])) {
	$bodyContent = mysqli_real_escape_string($conn, $_POST['editor']);
	$meta = mysqli_real_escape_string( $conn, $_POST[ 'metadata' ] );

	    //$sql = mysqli_query($conn, "INSERT INTO other_pages(body,created_at,updated_at) VALUES ('".$bodyContent."',NOW(),NOW())");
		
	    mysqli_query( $conn, "update other_pages Set body='".$bodyContent."',meta_details='".$meta."', updated_at=NOW() WHERE id=4" );		
		mysqli_close($conn);
		$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved</div>';
		header( 'location:' . $baseurl . 'controlgear/tnc');
		exit();		
}
?>
<?php if($sessionrow['isAdmin'] == 1 && $sessionrow['type'] != 99) { ?>
<?php include("header.php"); ?>
<div class="breadcrumbs-title-container">
	<div class="container-fluid">
		<h5 class="page-title">Other Pages - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
				</li>
				<li>Terms & Conditions</li>
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
						<label class="label mb-2">Body Content</label>
						<textarea name="editor" id="editor" class="ckeditor"><?php echo $row['body']; ?></textarea>
					</div>
					<div class="form-group">
								<label class="label">Meta Details</label>
								<textarea rows="8" name="metadata" id="metadata" class="form-control"><?php echo $row['meta_details']; ?></textarea>
							</div>
				</div>
				<div class="col-md-4">
							<div class="form-group">
						<label class="label">Featured Image<span class="required">*</span> <span class="note">(Size: W: 1920px / H: 300px)</span></label>
						<?php if(!empty($row['image'])) { ?><figure> <a href="<?php echo $baseurl;?>uploads/pages/<?php echo $row['image']; ?>" target="_blank"><?php if(isset($row['image'])){ if($row['image'] == True){ echo "<img src='".$baseurl."uploads/pages/".substr($row['image'], 0 , (strrpos($row['image'], "."))).".".pathinfo($row['image'], PATHINFO_EXTENSION)."' class='img-fluid' />"; } } ?></a> <a href="javascript:void(0);" data-id="<?php echo $row['id']; ?>" class="deleteImg text-red"><i class="fa fa-times mt-1"></i> Delete Image</a>
					</figure><?php } ?>
						<div class="custom-file">
                      <input type="file" class="custom-file-input" id="imageFile" name="filename">
                      <label class="custom-file-label form-control" for="filename">
						  <?php if(!empty($row['image'])) { echo $row['image']; } else { echo "Please upload Image file only"; } ?></label>
                    </div>
					</div>
</div>
				<div class="col-md-12">
					<button type="submit" name="submit" id="submit" class="btn btn-primary custom-btn">Update</button>
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