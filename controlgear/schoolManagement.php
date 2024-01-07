<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,id,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if ( isset( $_POST[ 'update' ] ) ) {
	$catid = mysqli_real_escape_string($conn, $_POST['catname']);
	$scatid = mysqli_real_escape_string($conn, $_POST['stname']);

	//if ( !empty( $catid ) ) {		
		//$resultset_1 = mysqli_query($conn, "select id from school_management where name='".trim($catid)."'");
		//$count = mysqli_num_rows($resultset_1);
 //if($count == 0)
   // { 

	mysqli_query( $conn, "update school_management Set name='" . $catid . "', short_form='".$scatid."', updated_at=NOW() WHERE id=" . $_POST[ 'bookId' ] . "" );
	mysqli_close( $conn );
	header( 'location:' . $baseurl . 'controlgear/schoolManagement' );
	exit;

//}else{
	//$errMsg = '<div class="alert alert-danger" role="alert">The "'.trim($catid).'" is already present.</div>';
 //}	
 //} else {
	 //$errMsg = '<div class="alert alert-danger" role="alert">Required field are empty.</div>';
 //}
}

if ( isset( $_POST[ 'submit' ] ) ) {
	$catid = mysqli_real_escape_string( $conn, $_POST[ 'name' ] );
	$scatid = mysqli_real_escape_string( $conn, $_POST[ 'sname' ] );

	 if ( !empty( $catid ) ) {		
		$resultset_1 = mysqli_query($conn, "select id from school_management where name='".trim($catid)."'");
		$count = mysqli_num_rows($resultset_1);
 if($count == 0)
    {   

        mysqli_query( $conn, "INSERT INTO school_management(name,short_form,status,userid,created_at,updated_at) VALUES ('".trim($catid)."','".$scatid."',1,'".$sessionrow['id']."',NOW(),NOW())" );
		mysqli_close( $conn );
		$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved</div>';
		header( 'location:' . $baseurl . 'controlgear/schoolManagement?message=success' );
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
		  $sname = $filesop[1];
			  
		  $resultset_1 = mysqli_query($conn, "select id from school_management where name='".trim($fname)."'");
		$count = mysqli_num_rows($resultset_1);
 if($count == 0)
    {	  
			  
          $sql = "insert into school_management(name,short_form,status,userid,created_at,updated_at) values ('".$fname."','".$sname."','1','".$sessionrow['id']."',NOW(),NOW())";
          $stmt = mysqli_prepare($conn,$sql);
          mysqli_stmt_execute($stmt);
 }
         $c = $c + 1;
           }

            if($sql){
             header( 'location:' . $baseurl . 'controlgear/schoolManagement?message=successimport' );
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
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/schoolManagement');</script>";

} elseif ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'successimport' ) {
	$message = '<div class="alert alert-success" role="alert">Excel Data Imported into the Database</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/schoolManagement');</script>";

}


?>
<?php if($sessionrow['isAdmin'] == 1 && $sessionrow['type'] != 99) { ?>
<?php include("header.php"); ?>
<div class="breadcrumbs-title-container">
	<div class="container-fluid">
		<h5 class="page-title">Add/Upload Lists - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
				</li>
				<li>School Management</li>
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
							<label class="label">School Name <span class="required">*</span></label>
							<input type="text" name="name" id="name" class="form-control">
						</div>
						<div class="col-md-12 form-group">
							<label class="label">Short form <span class="required">*</span></label>
							<input type="text" name="sname" id="sname" class="form-control">
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
						<div class="col-md-12 mt-2">
						<a href="../uploads/sample.csv">Download Sample CSV</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-12">
			<div class="grid bg-white box-shadow-light">
				<h5 class="heading">School to merge</h5>
				<div class="input-group">
					<select name="destination-school" id="destination-school" class="form-select">
						<option value="" disabled selected>Select School</option>
						<?php 
							$sclSQL = mysqli_query($conn, "SELECT id,name FROM school_management");
							while($sclRow = mysqli_fetch_assoc($sclSQL)){
								?>
									<option value="<?php echo $sclRow['id'] ?>"><?php echo $sclRow['name'] ?></option>
								<?php
							}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="grid bg-white box-shadow-light">
				<h5 class="heading">List of Schools</h5>

					<table id="datalist" class="table table-hover table-sm custom-table" cellspacing="0">
						<thead>
						<tr>
								<th></th>
								<th><input type="text" id="ids" class="form-control"></th>
								<th><input type="text" id="school" class="form-control"></th>
								<th><input type="text" id="shortform" class="form-control"></th>
								<th><input type="text" id="status" class="form-control"></th>
								<th></th>
							</tr>
							<tr>
								<th width="40"></th>
								<th width="50">#ID</th>
								<th>School Name</th>
								<th>Short form</th>
								<th width="100">Status</th>
								<th width="50"></th>
							</tr>
						</thead>
						
					</table>

					<div class="input-group">
						<button class="btn btn-primary custom-btn" id="merge-btn">Merge</button>
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