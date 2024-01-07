<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,id,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if ( isset( $_POST[ 'update' ] ) ) {
	$catid = mysqli_real_escape_string( $conn, $_POST[ 'catname' ] );

	$checksql = mysqli_query($conn, "SELECT parent FROM topics_subtopics WHERE id='".$_POST[ 'bookId' ]."'");
	$checkrow = mysqli_fetch_assoc($checksql);

	if($checkrow['parent'] == '0') {
		$cat = 'topic';
	} else {
		$cat = 'subtopic';
	}



	if ( !empty( $catid ) ) {		
	mysqli_query( $conn, "update topics_subtopics Set $cat='".trim($catid)."', slug='".slugify(trim($catid))."',updated_at=NOW() WHERE id=" . $_POST[ 'bookId' ] . "" );
	mysqli_close( $conn );
	header( 'location:' . $baseurl . 'controlgear/topicList' );
	exit;	
 }
}

if ( isset( $_POST[ 'submitTopic' ] ) ) {
	$tpName = mysqli_real_escape_string($conn, $_POST['tp_name']);
	$clsName = mysqli_real_escape_string($conn, $_POST['cls_name']);
	$subjName = mysqli_real_escape_string($conn, $_POST['subj_name']);

	if (!empty($tpName) && !empty($clsName) && !empty($subjName)) {		
		//$resultset_1 = mysqli_query($conn, "select id from topics_subtopics where topic='".trim($tpName)."' and userid='".$_SESSION['id']."'");
		//$count = mysqli_num_rows($resultset_1);
	//if($count == 0)
   // {   
        mysqli_query( $conn, "INSERT INTO topics_subtopics(topic,slug,class_id,subject_id,status,userid,parent,created_at,updated_at) VALUES ('".trim($tpName)."','".slugify(trim($tpName))."','".$clsName."','".$subjName."',1,'".$sessionrow['id']."',0,NOW(),NOW())" );
		mysqli_close( $conn );
		$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved</div>';
		header( 'location:' . $baseurl . 'controlgear/topicList?message=success' );
		exit;
   // }else{
      // $errMsg = '<div class="alert alert-danger" role="alert">The "'.trim($tpName).'" is already present.</div>';
   // }	
	} else {
		$errMsg = '<div class="alert alert-danger" role="alert">Required field are empty.</div>';
	}
}

//Sub-Topic
if ( isset( $_POST[ 'submitSubTopic' ] ) ) {
	$tpName = mysqli_real_escape_string($conn, $_POST['tp_name']);
	$subtpName = mysqli_real_escape_string($conn, $_POST['subtopname']);

	if (!empty($tpName) && !empty($subtpName)) {		
		//$resultset_1 = mysqli_query($conn, "select id from topics_subtopics where subtopic='".trim($subtpName)."' and userid='".$_SESSION['id']."'");
		//$count = mysqli_num_rows($resultset_1);
	//if($count == 0)
   // {   

		$catsql = mysqli_query($conn, "SELECT id,class_id,subject_id,topic from topics_subtopics WHERE id=$tpName and status=1");
		$catrow = mysqli_fetch_array($catsql);

        mysqli_query( $conn, "INSERT INTO topics_subtopics(subtopic,slug,class_id,subject_id,status,userid,parent,created_at,updated_at) VALUES ('".trim($subtpName)."','".slugify(trim($subtpName))."','".$catrow['class_id']."','".$catrow['subject_id']."',1,'".$sessionrow['id']."','".$tpName."',NOW(),NOW())" );
		mysqli_close( $conn );
		$errMsg1 = '<div class="alert alert-success" role="alert">Successfully Saved</div>';
		header( 'location:' . $baseurl . 'controlgear/topicList?message1=success' );
		exit;
    //}else{
      // $errMsg1 = '<div class="alert alert-danger" role="alert">The "'.trim($subtpName).'" is already present.</div>';
    //}	
	} else {
		$errMsg1 = '<div class="alert alert-danger" role="alert">Required field are empty.</div>';
	}
}


if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' ) {
	$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/topicList');</script>";

}

if ( isset( $_GET[ 'message1' ] ) && $_GET[ 'message1' ] == 'success' ) {
	$errMsg1 = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/topicList');</script>";

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
				<li>List of Topics</li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">
			<div class="grid bg-white box-shadow-light">
			<div class="msg">
			<?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
</div>
				<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="row">
					<div class="col-md-12 form-group">
							<label class="label">Select Class <span class="required">*</span></label>
							<select name="cls_name" id="cls_name" class="selectpicker form-control" data-live-search="true">
							<option value="">Please Select</option>
							<?php $catsql = mysqli_query($conn, "SELECT id,name from subject_class WHERE type=2 and status=1 order by id asc");
							while($catrow = mysqli_fetch_array($catsql))
							{ ?>
							<option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['name']; ?></option>
							<?php } ?>
						</select>
						</div>
						<div class="col-md-12 form-group">
							<label class="label">Select Subject <span class="required">*</span></label>
							<select name="subj_name" id="subj_name" class="selectpicker form-control" data-live-search="true">
							<option value="">Please Select</option>
							<?php $catsql = mysqli_query($conn, "SELECT id,name from subject_class WHERE type=1 and status=1 order by name asc");
							while($catrow = mysqli_fetch_array($catsql))
							{ ?>
							<option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['name']; ?></option>
							<?php } ?>
						</select>
						</div>
						<div class="col-md-12 form-group">
							<label class="label">Topic Name <span class="required">*</span></label>
							<input type="text" name="tp_name" id="tp_name" class="form-control" autocomplete="off">
						</div>
						<div class="col-md-12">
							<button type="submit" name="submitTopic" class="btn btn-primary custom-btn">Save</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-6">
			<div class="grid bg-white box-shadow-light">
			<div class="msg1">
			<?php if(isset($errMsg1)){ echo "".$errMsg1.""; } ?>
</div>
				<form action="" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-12 form-group">
							<label class="label">Select Topic <span class="required">*</span></label>
							<select name="tp_name" id="tp_name" class="selectpicker form-control" data-live-search="true">
							<option value="">Please Select</option>
							<?php $catsql = mysqli_query($conn, "SELECT id,topic,class_id,subject_id from topics_subtopics WHERE parent=0 and status=1 order by class_id,id asc");
							while($catrow = mysqli_fetch_array($catsql))
							{ 
								$clssql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$catrow['class_id']."' and type=2 and status=1");
								$clsrow = mysqli_fetch_assoc($clssql);
							
								$subjsql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$catrow['subject_id']."' and type=1 and status=1");
								$subjrow = mysqli_fetch_assoc($subjsql);
								
								?>
							<option value="<?php echo $catrow['id']; ?>"><?php echo $clsrow['name'].' / '.$subjrow['name'].' / '.$catrow['topic']; ?></option>
							<?php } ?>
						</select>
						</div>
						<div class="col-md-12 form-group">
							<label class="label">Sub-Topic Name<span class="required">*</span></label>
							<input type="text" name="subtopname" id="subtopname" class="form-control">
						</div>
						<div class="col-md-12">
							<button type="submit" name="submitSubTopic" class="btn btn-primary custom-btn">Save</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-12">
			<div class="grid bg-white box-shadow-light">
			<h5 class="heading">List of Topics</h5>

<table id="datalisttpc" class="table table-hover table-sm custom-table" cellspacing="0">
	<thead>
	<tr>
			<th></th>
			<th><input type="text" id="clsName" class="form-control"></th>
			<th><input type="text" id="topicName" class="form-control"></th>
			<th><input type="text" id="tpcstatus" class="form-control"></th>
			<th></th>
		</tr>
		<tr>
			<th width="50">#ID</th>
			<th>Class / Subject</th>
			<th>Topic Name</th>
			<th width="100">Status</th>
			<th width="50"></th>
		</tr>
	</thead>
	
</table>
				</div></div>
		<div class="col-md-12">
			<div class="grid bg-white box-shadow-light">
			<h5 class="heading">List of Sub-Topics</h5>

<table id="datalist" class="table table-hover table-sm custom-table" cellspacing="0">
	<thead>
	<tr>
			<th></th>
			<th><input type="text" id="clssName" class="form-control"></th>
			<th><input type="text" id="subtopicName" class="form-control"></th>
			<th><input type="text" id="status" class="form-control"></th>
			<th></th>
		</tr>
		<tr>
			<th width="50">#ID</th>
			<th>Class / Subject/ Topic</th>
			<th>Sub-Topic Name</th>
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