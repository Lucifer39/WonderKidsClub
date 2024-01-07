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

$sql = mysqli_query($conn, "SELECT id,title,slug,featured,status,meta_details,content FROM blog_post WHERE id=".$id."");
$row = mysqli_fetch_array($sql);

$catsql = mysqli_query($conn, "SELECT * FROM blog_categories WHERE id=".$row['category_id']."");
$catrow = mysqli_fetch_array($catsql);

if (isset($_POST['submit'])) {
	$catid = mysqli_real_escape_string( $conn, $_POST['adTitle'] );
	$slug1 = mysqli_real_escape_string( $conn, $_POST[ 'slug' ] );
	$meta = mysqli_real_escape_string( $conn, $_POST[ 'metadata' ] );
	$about_textarea = mysqli_real_escape_string( $conn, $_POST['editor'] );
	$adCat = $_POST['adCat'];
	$adStatus = $_POST['adStatus'];
	$icap = $_POST['imgcap'];
//&& $adCat != '0'
	if (!empty($catid)) {

		if(!empty($slug1)) {

			mysqli_query( $conn, "update blog_post Set slug='".slugify($slug1)."' WHERE id=".$id."" );
            $checkslug = mysqli_query($conn, "select COUNT(slug) as selectcount from blog_post where slug='".slugify($slug1)."'");
	        $slugrow = mysqli_fetch_array($checkslug);
			if($slugrow[0] > 1) {
				$slug = $slugrow[0];
				$slug = slugify($slug1)."-".$slug;	
			} else {
				$slug = slugify($slug1);
			}	
		} else {
	mysqli_query( $conn, "update blog_post Set slug='".slugify($catid)."' WHERE id=".$id."" );	
	$checkslug = mysqli_query($conn, "select COUNT(slug) as selectcount from blog_post where name='".trim($catid)."'");
	$slugrow = mysqli_fetch_array($checkslug);

	if($slugrow[0] > 1) {
		$slug = $slugrow[0];
		$slug = slugify($catid)."-".$slug;	
	} else {
		$slug = slugify($catid);
	}	
		
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
		$large_image = $row['featured'];
	}
		
		mysqli_query( $conn, "update blog_post Set title='".$catid."', slug='".$slug."',content='".$about_textarea."',featured='".$large_image."',meta_details='".$meta."',status='".$adStatus."',updated_at=NOW() WHERE id=".$row['id']."" );
		
		$prodid = $row['id'];
		$number = count($_POST["adCat"]);
		$keylights = $_POST["adCat"];
		
		//Categories
$recomendsql = mysqli_query($conn, "SELECT COUNT(*) as total, MAX(id) as maxnum FROM blog_relationship WHERE post_id='".$row['id']."'");
$recomendrow = mysqli_fetch_array($recomendsql, MYSQLI_ASSOC);

$recomendtotal = $recomendrow['total'];
$recomendmaxnum = $recomendrow['maxnum'];		
		
$recomendCount = count($_POST["adCat"]);
$recomendheading = $_POST["adCat"];
		
    //if(!empty($recomendtotal)) {
	mysqli_query($conn, "DELETE FROM blog_relationship WHERE post_id='".$row['id']."'");
	for($i=0; $i<$recomendCount; $i++)
	{
		if(trim($_POST["adCat"][$i] != ''))
		{
			
			$sql=mysqli_query($conn, "INSERT INTO blog_relationship(post_id,cat_id) VALUES ('".$row['id']."','".mysqli_real_escape_string($conn,$recomendheading[$i])."')");
	} 
    }
    
    if(trim($_POST["adCat"] == '')){
        	$sql=mysqli_query($conn, "INSERT INTO blog_relationship(post_id,cat_id) VALUES ('".$row['id']."',0)");
        }
		
		
		
		
		mysqli_close($conn);
		$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved</div>';
		header( 'location:' . $baseurl . 'controlgear/editblogPost?id='.$id);
		exit();			
	} else {
		$errMsg = '<div class="alert alert-danger" role="alert">Required field are empty.</div>';
	}
}
?>
<?php if($sessionrow['isAdmin'] == 1 && $sessionrow['type'] != 99) { ?>
<?php include("header.php"); ?>
<div class="breadcrumbs-title-container">
	<div class="container-fluid">
		<h5 class="page-title">Add Post - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>dashboard/"><i class="fa fa-home"></i></a>
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
						<label class="label">Title<span class="required">*</span></label>
						<input type="text" name="adTitle" id="adTitle" class="form-control" value="<?php echo $row['title']; ?>">
						<div class="permalink">Permalink: <a href="<?php echo $baseurl.$row['slug'];?>" target="_blank"><?php echo $baseurl;?><span>blog/<?php echo $row['slug']; ?></span></a><span id="editpermalink" class="small-btn">Edit</span></div>
					</div>
					<div id="editable-post-name" class="form-group hide">
								<label class="label">Slug <span class="required">*</span></label>
								<input type="text" name="slug" id="slug" class="form-control" value="<?php echo $row['slug']; ?>">
							</div>
					<div class="form-group">
						<label class="label">Body Content <span class="required">*</span></label>
						<textarea name="editor" id="editor" class="ckeditor"><?php echo $row['content']; ?></textarea>
					</div>
					<div class="form-group">
								<label class="label">Meta Details</label>
								<textarea rows="8" name="metadata" id="metadata" class="form-control"><?php echo $row['meta_details']; ?></textarea>
							</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">
							<label class="label">Categories <span class="required">*</span></label>					
						<select name="adCat[]" id="adCat" class="selectpicker form-control" data-live-search="true" multiple>
            <?php $unsql = mysqli_query($conn, "SELECT b.id,b.title,a.cat_id FROM blog_relationship as a INNER JOIN ppt_details as b ON b.id=a.post_id WHERE a.cat_id=0 and a.post_id='".$row['id']."'"); $unrow = mysqli_fetch_array($unsql); ?>
             <?php if (!empty($unrow['id'])) { ?>
                        <option value="0" selected>Uncategorized</option>
                        <?php } else { ?>
             <option value="0">Uncategorized</option>
                        <?php } ?>
						<?php $applisql1 = mysqli_query($conn, "SELECT id,name from blog_categories order by name asc"); while($applirow1 = mysqli_fetch_array($applisql1)) { 
	
						$recommendsql = mysqli_query($conn, "SELECT DISTINCT b.id,b.title,a.cat_id FROM blog_relationship as a INNER JOIN blog_post as b ON b.id=a.post_id WHERE a.cat_id='".$applirow1['id']."' and a.post_id='".$row['id']."'"); $recommendrow = mysqli_fetch_array($recommendsql); ?>
						
                       
						<?php if (!empty($recommendrow['id'])) { ?>
						
						<option value="<?php echo $applirow1['id']; ?>" selected><?php echo $applirow1['name']; ?></option>
						<?php } else { ?>	
						<option value="<?php echo $applirow1['id']; ?>"><?php echo $applirow1['name']; ?></option>
						<?php } } ?>
					</select>
						</div>
					<div class="form-group">
						<label class="label">Large Image <span class="required">*</span> <span class="note">(Size: W: 1200px /  H: 500px)</span></label>
						<figure> <a href="../uploads/blog/<?php echo $row['featured']; ?>" target="_blank"><?php if(isset($row['featured'])){ if($row['featured'] == True){ echo "<img src='../uploads/blog/".substr($row['featured'], 0 , (strrpos($row['featured'], "."))).".".pathinfo($row['featured'], PATHINFO_EXTENSION)."' class='img-fluid' />"; } } ?></a> </figure>
						<div class="custom-file">
                      <input type="file" class="custom-file-input" id="largefilename" name="largefilename">
                      <label class="custom-file-label form-control" for="largefilename">
						  <?php if(isset($row['featured'])) { echo $row['featured']; } else { echo "Please upload Image file only"; } ?></label>
                    </div>
					</div>
					<div class="form-group">
						<label class="label">Status</label>
						<select name="adStatus" id="adStatus" class="custom-select form-control">
							<option value="0" <?php if(isset($row['status'])){ if($row['status'] == '0'){ echo 'selected'; } } ?>>Publish</option>
							<option value="1" <?php if(isset($row['status'])){ if($row['status'] == '1'){ echo 'selected'; } } ?>>Draft</option>
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