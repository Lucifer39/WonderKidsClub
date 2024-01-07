<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

$url = trim($_SERVER["REQUEST_URI"],"/");
$id = substr($url, strpos($url, '=') + 1);

$sql = mysqli_query($conn, "SELECT id,ques,ans FROM homepage_faqs WHERE id=".$id."");
$row = mysqli_fetch_array($sql);

if (isset($_POST['submit']) || isset($_POST['update'])) {
	$catid = mysqli_real_escape_string($conn, $_POST['faqQues']);
	$about_textarea = mysqli_real_escape_string($conn, $_POST['faqAns']);

	if (!empty($catid)) {

    if(isset($_POST['update'])) {

        mysqli_query( $conn, "update homepage_faqs Set ques='".$catid."',ans='".$about_textarea."',updated_at=NOW() WHERE id=".$row['id']."" );

    } elseif(isset($_POST['submit'])) {		
	
        $sql = mysqli_query($conn, "INSERT INTO homepage_faqs(ques,ans,status,created_at,updated_at) VALUES ('".$catid."','".$about_textarea."',1,NOW(),NOW())");
    }
    
    mysqli_close($conn);

    if(isset($_POST['update'])) {

        header( 'location:' . $baseurl . 'controlgear/homeFaqs?id='.$id);

    } elseif(isset($_POST['submit'])) {
        $errMsg = '<div class="alert alert-success" role="alert">Successfully Saved</div>';
        header( 'location:' . $baseurl . 'controlgear/homeFaqs?message=success' );

    }
    exit();		
		
	} else {
		$errMsg = '<div class="alert alert-danger" role="alert">Required field are empty.</div>';
	}
}

if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' ) {
	$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/homeFaqs');</script>";

}
?>
<?php if($sessionrow['isAdmin'] == 1 || $sessionrow['type'] != 99) { ?>
<?php include("header.php"); ?>
<div class="breadcrumbs-title-container">
	<div class="container-fluid">
		<h5 class="page-title">Homepage - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
				</li>
				<li>FAQs</li>
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
						<div class="col-md-8 form-group">
							<label class="label">Question <span class="required">*</span></label>
							<input type="text" name="faqQues" id="faqQues" class="form-control" value="<?php echo $row['ques']; ?>">
						</div>
                        <div class="col-8 form-group">
                        <label class="label">Answer</label>
							<textarea name="faqAns" id="editor" class="ckeditor"><?php echo $row['ans']; ?></textarea>
						</div>
						<div class="col-md-8">
                        <?php if(!empty($row['id'])) { ?>
							<button type="submit" name="update" id="update" class="btn btn-primary custom-btn">update</button>
                            <a href="homeFaqs" class="btn btn-primary custom-btn ml-2">+ Add New</a>
						<?php } else { ?>
							<button type="submit" name="submit" id="submit" class="btn btn-primary custom-btn">Save</button>
						<?php } ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="col-md-12">
			<div class="grid bg-white box-shadow-light">
				<h5 class="heading">List of FAQs</h5>

					<table id="datalist" class="table table-hover table-sm custom-table" cellspacing="0">
						<thead>
						<tr>
								<th></th>
								<th><input type="text" id="faqQues" class="form-control"></th>
								<th><input type="text" id="status" class="form-control"></th>								
								<th></th>
							</tr>
							<tr>
								<th width="30">#ID</th>
								<th width="220">Question</th>
								<th width="50">Status</th>						
								<th width="40"></th>
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