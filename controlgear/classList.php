<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,id FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if ( isset( $_POST[ 'update' ] ) ) {
	$catid = mysqli_real_escape_string( $conn, $_POST[ 'catname' ] );

	if ( !empty( $catid ) ) {		
		$resultset_1 = mysqli_query($conn, "select id from subject_class where name='".trim($catid)."' type=2");
		$count = mysqli_num_rows($resultset_1);
 if($count == 0)
    { 

	mysqli_query( $conn, "update subject_class Set name='".trim($catid)."', slug='".slugify(trim($catid))."',updated_at=NOW() WHERE id=" . $_POST[ 'bookId' ] . "" );
	mysqli_close( $conn );
	header( 'location:' . $baseurl . 'controlgear/classList' );
	exit;

}else{
	//$errMsg = '<div class="alert alert-danger" role="alert">The "'.trim($catid).'" is already present.</div>';
 }	
 } else {
	 //$errMsg = '<div class="alert alert-danger" role="alert">Required field are empty.</div>';
 }
}

if ( isset( $_POST[ 'submit' ] ) ) {
	$catid = mysqli_real_escape_string( $conn, $_POST[ 'name' ] );

	 if ( !empty( $catid ) ) {		
		$resultset_1 = mysqli_query($conn, "select id from subject_class where name='".trim($catid)."' and type=2");
		$count = mysqli_num_rows($resultset_1);
 if($count == 0)
    {   

        mysqli_query( $conn, "INSERT INTO subject_class(name,slug,status,userid,type,created_at,updated_at) VALUES ('".trim($catid)."','".slugify(trim($catid))."',1,'".$sessionrow['id']."',2,NOW(),NOW())" );
		mysqli_close( $conn );
		$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved</div>';
		header( 'location:' . $baseurl . 'controlgear/classList?message=success' );
		exit;
    }else{
       $errMsg = '<div class="alert alert-danger" role="alert">The "'.trim($catid).'" is already present.</div>';
    }	
	} else {
		$errMsg = '<div class="alert alert-danger" role="alert">Required field are empty.</div>';
	}
}


//Import 
if (isset($_POST["impsubmit"])) {

    $allowedFileType = [
        'application/vnd.ms-excel',
        'text/csv'        
    ];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {

        
		$file = $_FILES['file']['tmp_name'];
          $handle = fopen($file, "r");
          $c = 0;
          while(($filesop = fgetcsv($handle, 10000, ",")) !== false)
                    {
          $fname = $filesop[0];
			  
		  $resultset_1 = mysqli_query($conn, "select id from subject_class where name='".trim($fname)."' and type=2");
		$count = mysqli_num_rows($resultset_1);
 if($count == 0)
    {	  
			  
          $sql = "insert into subject_class(name,status,userid,type,created_at,updated_at) values ('".$fname."','1','".$sessionrow['id']."',2,NOW(),NOW())";
          $stmt = mysqli_prepare($conn,$sql);
          mysqli_stmt_execute($stmt);
 }
         $c = $c + 1;
           }

            if($sql){
             header( 'location:' . $baseurl . 'controlgear/classList?message=successimport' );
			 exit;
		} 
		 else
		 {
            $message = '<div class="alert alert-danger" role="alert">Problem or Duplicates Field in Importing Excel Data</div>';
          }
    } else {
        $message = '<div class="alert alert-danger" role="alert">Invalid File Type. Upload excel (.csv) format only.</div>';
    }
}

if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' ) {
	$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/classList');</script>";

} elseif ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'successimport' ) {
	$message = '<div class="alert alert-success" role="alert">Excel Data Imported into the Database</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/classList');</script>";

}


?>
<?php if($sessionrow['isAdmin'] == 1) { ?>
<?php include("header.php"); ?>
<div class="breadcrumbs-title-container">
	<div class="container-fluid">
		<h5 class="page-title">Add/Upload Lists - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
				</li>
				<li>Classes</li>
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
							<label class="label">Class Name <span class="required">*</span></label>
							<input type="text" name="name" id="name" class="form-control">
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
				<div id="msg1" class="msg">
					<?php if(isset($message)){ echo "".$message.""; } ?>
				</div>
				<form action="" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-12 form-group">
							<label class="label">Import Excel (.csv) format only</label>
							<input type="file" name="file" id="file" accept=".csv" class="custom-file">
						</div>
						<div class="col-md-12">
							<button type="submit" name="impsubmit" id="impsubmit" class="btn btn-primary custom-btn">Import</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-12">
			<div class="grid bg-white box-shadow-light">
				<h5 class="heading">List of Classes</h5>

					<table id="datalist" class="table table-hover table-sm custom-table" cellspacing="0">
						<thead>
						<tr>
								<th></th>
								<th><input type="text" id="subject" class="form-control"></th>
								<th><input type="text" id="status" class="form-control"></th>
								<th></th>
							</tr>
							<tr>
								<th width="50">#ID</th>
								<th>Class Name</th>
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