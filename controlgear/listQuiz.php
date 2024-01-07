<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,id,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

$errMsg;
$uploadOk = 1;
$subMsg = "";

if(isset($_POST["upload"])) {

	$sel_class = $_POST["select-class-upload"];
	$targetDirectory = "../uploads/offline_practice/"; // Specify your desired directory here

	// Loop through each uploaded file
	for ($i = 0; $i < count($_FILES["fileToUpload"]["name"]); $i++) {
		$targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"][$i]);
		$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

		// Check if the file already exists
		if (file_exists($targetFile)) {
			$errMsg .= "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"][$i])) . " already exists.<br>";
			$uploadOk = 0;
		}

		// Check file size (you can adjust the size limit)
		if ($_FILES["fileToUpload"]["size"][$i] > 5000000) {
			$errMsg .= "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"][$i])) . " is too large.<br>";
			$uploadOk = 0;
		}

		// Allow only certain file formats (you can modify this list)
		if ($imageFileType != "pdf") {
			$errMsg .= "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"][$i])) . " is not allowed.<br>";
			$uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			$errMsg .= "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"][$i])) . " was not uploaded.<br>";
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $targetFile)) {
				$errMsg .= "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"][$i])) . " has been uploaded.<br>";
			} else {
				$errMsg .= "Sorry, there was an error uploading " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"][$i])) . ".<br>";
			}
		}
	}

	// Redirect with the error/success message
	header('Location: ' . $baseurl . 'controlgear/listQuiz?message=' . urlencode($errMsg));
	exit();
}

if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] !== 'successimport') {
	$errMsg = '<div class="alert alert-success" role="alert">'. $_GET[ 'message' ] .'</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/listQuiz');</script>";
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
		 $class = $filesop[0];
		 $subject = $filesop[1];
		 $topic = $filesop[2];
		 $subtopic = $filesop[3];
		 $type = $filesop[4];
		 $question = $filesop[5];
		 $hint = $filesop[6];
		 $opt_a = $filesop[7];
		 $opt_b = $filesop[8];
		 $opt_c = $filesop[9];
		 $opt_d = $filesop[10];
		 $correct = $filesop[11];
			 
		 //$resultset_1 = mysqli_query($conn, "select * from question_bank where email='".$email."'");
	   //$count = mysqli_num_rows($resultset_1);
//if($count == 0) {
			 //if($c>0)
  // {	  	  
		 $sql = "insert into count_quest(userid,class,subject,topic,subtopic,type1,question,hint,opt_a,opt_b,opt_c,opt_d,correct_ans,status,created_at,updated_at) values ('".$sessionrow['id']."','".$class."','".$subject."','".$topic."','".$subtopic."','".$type."','".trim($question)."','".trim($hint)."','".trim($opt_a)."','".trim($opt_b)."','".trim($opt_c)."','".trim($opt_d)."','".$correct."',1,NOW(),NOW())";
		 $stmt = mysqli_prepare($conn,$sql);
		 mysqli_stmt_execute($stmt);
//}
		//$c = $c + 1;
//}
		  }

		   if($sql){
			header( 'location:' . $baseurl . 'controlgear/questionList?message=successimport' );
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

if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'successimport' ) {
	$message = '<div class="alert alert-success" role="alert">Excel Data Imported into the Database</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/questionList');</script>";

}


?>
<?php if($sessionrow['isAdmin'] == 1) { ?>
<?php include("header.php"); ?>
<div class="breadcrumbs-title-container">
	<div class="container-fluid">
		<h5 class="page-title">Quiz / Paper - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
				</li>
				<li>List of quiz/paper</li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="grid bg-white box-shadow-light">
				<h5 class="heading">List of quiz/paper</h5>
					<div class="p-3">
						<h6 class="heading">Upload pdf</h6>
						<form action="" method="post" enctype="multipart/form-data">
							<div class="input-group">
								<input type="file" class="form-control" id="fileToUpload" name="fileToUpload[]" aria-describedby="upload" aria-label="Upload" multiple>
								<button class="btn btn-primary custom-btn" type="submit" value="Upload File" name="upload" id="inputGroupFileAddon04">Upload</button>
							</div>
						</form>
					</div>
					<table id="datalist" class="table table-hover table-sm custom-table" cellspacing="0">
						<thead>
						<tr>
								<th></th>
								<th><input type="text" id="clsSubj" class="form-control"></th>
								<th><input type="text" id="ques" class="form-control"></th>
								<th><input type="text" id="status" class="form-control"></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr>
								<th width="50">#ID</th>
								<th>Class / Subject / Topic / Subtopic</th>
								<th>Quiz / Paper Name (Type)</th>
								<th>Start / End Date</th>
								<th width="100">Status</th>
								<th width="50"></th>
								<th width="100">Download</th>
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