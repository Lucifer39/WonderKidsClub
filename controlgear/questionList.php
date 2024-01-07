<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,id,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if ( isset( $_POST[ 'update' ] ) ) {
	$catid = mysqli_real_escape_string($conn, $_POST['catname']);

	$chk_remark_qury = mysqli_query($conn, "SELECT id FROM question_bank_remark WHERE ques_id='".$_POST['bookId']."'");
	$chk_remark_rslt = mysqli_fetch_assoc($chk_remark_qury);

	if(!empty($chk_remark_rslt['id'])) {
		mysqli_query( $conn, "update question_bank_remark Set remark='".$catid."', updated_at=NOW() WHERE ques_id=".$_POST['bookId']."" );
	} else {
		mysqli_query( $conn, "INSERT INTO question_bank_remark(ques_id,remark,created_at,updated_at) VALUES ('".$_POST['bookId']."','".trim($catid)."',NOW(),NOW())" );
	}
	mysqli_close( $conn );
	header( 'location:' . $baseurl . 'controlgear/questionList' );
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
		 $optstyle = $filesop[12];
			 
		// $resultset_1 = mysqli_query($conn, "select * from count_quest where email='".$email."'");
	   	// $count = mysqli_num_rows($resultset_1);
//if($count == 0) {
if($c>0)
 {	  	  
		 $sql = "insert into count_quest(userid,class,subject,topic,subtopic,type2,question,hint,opt_a,opt_b,opt_c,opt_d,correct_ans,status,created_at,updated_at) values ('".$sessionrow['id']."','".$class."','".$subject."','".$topic."','".$subtopic."','".$type."','".trim($question)."','".trim($hint)."','".trim($opt_a)."','".trim($opt_b)."','".trim($opt_c)."','".trim($opt_d)."','".$correct."',0,NOW(),NOW())";
		 $stmt = mysqli_prepare($conn,$sql);
		 mysqli_stmt_execute($stmt);

		 $sql1 = "insert into opt_style(quest_id,style_id) VALUES ('".$conn->insert_id."','".$optstyle."')";
		 $stmt1 = mysqli_prepare($conn,$sql1);
		 mysqli_stmt_execute($stmt1);
		 
}
$c = $c + 1;
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
		<h5 class="page-title">Question Bank - </h5>
		<div class="breadcrumbs">
			<ul>
				<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
				</li>
				<li>Questions List</li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
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
						<a href="../uploads/question-bank-sample.csv">Download Sample CSV</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-12">
			<div class="grid bg-white box-shadow-light">
				<h5 class="heading">List of Question Bank</h5>

					<table id="datalist" class="table table-hover table-sm custom-table" cellspacing="0">
						<thead>
						<tr>
								<th></th>
								<th><input type="text" id="clsSubj" class="form-control"></th>
								<th><input type="text" id="ques" class="form-control"></th>
								<th></th>
								<th><input type="text" id="status" class="form-control"></th>								
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr>
								<th width="30">#ID</th>
								<th width="220">Class / Subject / Topic / Subtopic</th>
								<th width="60">Type</th>
								<th width="150">For view click here to question</th>
								<th width="100">By User/ID</th>
								<th width="50">Status</th>
								<th width="150">Remark</th>								
								<th width="40"></th>
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