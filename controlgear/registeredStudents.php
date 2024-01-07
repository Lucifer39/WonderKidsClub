<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if ( isset( $_POST[ 'update' ] ) ) {
	$catid = $_POST['catname'];

	mysqli_query( $conn, "update users Set password='".md5($catid)."', updated_at=NOW() WHERE id=".$_POST['bookId']."");
	mysqli_close( $conn );
	header( 'location:' . $baseurl . 'controlgear/registerationUsers' );
	exit;
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
          $fullname = $filesop[0];
		  $email = $filesop[1];
		  $password = $filesop[2];
		  $contact = $filesop[3];
		  $role = $filesop[4];
		  $course = $filesop[5];
		  $year_of_graduation = $filesop[6];
		  $college = $filesop[7];
		  $company = $filesop[8];
		  $reason_signup = $filesop[9];
	      $other_reason_signup  = $filesop[10];
		  $from_where = $filesop[11];
	      $userRole = $filesop[12];		  
		  $verified = $filesop[13];	
		  $status = $filesop[14];
		  $created_at = date('Y-m-d H:i:s', strtotime($filesop[15]));
			  
		  $resultset_1 = mysqli_query($conn, "select * from users where email='".$email."'");
		$count = mysqli_num_rows($resultset_1);
 if($count == 0) {
			  if($c>0)
    {	  	  
          $sql = "insert into users(fullname,email,password,contact,role,course,year_of_graduation,college_name,company_name,reason_signup,other_reason_signup,from_where,userRole,verified,status,created_at) values ('".mysqli_real_escape_string( $conn, $fullname)."','".$email."','".md5($password)."','".$contact."','".$role."','".mysqli_real_escape_string( $conn, RTRIM($course))."','".$year_of_graduation."','".mysqli_real_escape_string( $conn, RTRIM($college))."','".mysqli_real_escape_string( $conn,RTRIM($company))."','".$reason_signup."','".$other_reason_signup."','".$from_where."','".$userRole."','".$verified."','".$status."','".$created_at."')";
          $stmt = mysqli_prepare($conn,$sql);
          mysqli_stmt_execute($stmt);
 }
         $c = $c + 1;
 }
           }

            if($sql){
			 header( 'location:' . $baseurl . 'controlgear/registerationUsers?message=successimport' );
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


if(isset($_POST["expsubmit"])) {
$query = mysqli_query($conn, "SELECT id,userid,fullname,email,contact,status,school,class,created_at FROM users WHERE type=1");
//$row = mysqli_fetch_assoc($query);	
	

if($query->num_rows > 0){
    $delimiter = ",";
    $filename = "registered_users_" . date('Y-m-d') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('User ID','Name', 'Email', 'Contact','Class','School','Status','Created Date');
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){

		$clssql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$row['class']."' and type=2 and status=1");
	$clsrow = mysqli_fetch_assoc($clssql);

  $schsql = mysqli_query($conn, "SELECT name FROM school_management WHERE id='".$row['school']."' and status=1");
	$schrow = mysqli_fetch_assoc($schsql);

		$status = ($row['status'] == '1')?'Active':'Inactive';
        $lineData = array($row['userid'],$row['fullname'], $row['email'], $row['contact'],$clsrow['name'],$schrow['name'],$status,$row['created_at']);
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;	
}

if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' ) {
	$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/registerationUsers');</script>";

} elseif ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'successimport' ) {
	$message = '<div class="alert alert-success" role="alert">Excel Data Imported into the Database</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/registerationUsers');</script>";

}



?>
<?php if($sessionrow['isAdmin'] == 1 && $sessionrow['type'] != 99) { ?>
<?php include("header.php"); ?>
<div class="breadcrumbs-title-container">
	<div class="container-fluid">
		<h5 class="page-title">Users - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>controlgear/registerationUsers/"><i class="fa fa-home"></i></a>
				</li>
				<li>Registered Students</li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<!--<div class="col-md-4">
			<div class="grid bg-white box-shadow-light">
				<div id="msg" class="msg">
					<?php //if(isset($message)){ echo "".$message.""; } ?>
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
		</div>-->
		<div class="col-md-12">
			<div class="grid bg-white box-shadow-light">
				<h5 class="heading d-flex align-items-center"><span class="mr-3">Students List</span> <form action="" method="post" enctype="multipart/form-data"><button type="submit" name="expsubmit" id="expsubmit" class="btn btn-primary custom-btn mb-0">Export</button></form></h5>

					<div class="">
				<table id="datalist" class="table table-hover table-sm custom-table" cellspacing="0">
						<thead>
							<tr>
							    <th><input type="text" id="userSearch" class="form-control"></th>
								<th><input type="text" id="fullnameSearch" class="form-control"></th>
								<th><input type="text" id="emailSearch" class="form-control"></th>
								<th><input type="text" id="contactSearch" class="form-control"></th>
								<th><input type="text" id="clsSearch" class="form-control"></th>
								<th><input type="text" id="schSearch" class="form-control"></th>
								<th><input type="text" id="statusSearch" class="form-control"></th>
								<th><input type="text" id="dateSearch" class="form-control"></th>
							</tr>
							<tr>
								<th>#ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Contact</th>
								<th>Class</th>
								<th>School</th>
								<th>Status</th>
								<th>Joining Date</th>
							</tr>
						</thead>
						
					</table>
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