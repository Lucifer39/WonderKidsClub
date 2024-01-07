<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,id,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

$url = trim($_SERVER["REQUEST_URI"],"/");
$id = substr($url, strpos($url, '=') + 1);

$sql = mysqli_query($conn, "SELECT id,class,subject,topic,subtopic,type2,question,hint,opt_a,opt_b,opt_c,opt_d,correct_ans FROM count_quest WHERE id=".$id."");
$row = mysqli_fetch_array($sql);

$optstyle_qury = mysqli_query($conn, "SELECT style_id FROM opt_style WHERE quest_id=".$id."");
$optstyle_rslt = mysqli_fetch_array($optstyle_qury);

if (isset($_POST['submit']) || isset($_POST['update'])) {
	$clsName = $_POST['clsName'];
	$subjName = $_POST['subjName'];
	$tpName = $_POST['tpName'];
	$sbtpName = $_POST['sbtpName'];
	$flagtype = $_POST['flagtype'];
	$optstyle = $_POST['optstyle'];
	$question = mysqli_real_escape_string($conn, $_POST['editor']);
	$hint = mysqli_real_escape_string($conn, $_POST['hint']);
	$ans1 = mysqli_real_escape_string($conn, $_POST['ans1']);
	$ans2 = mysqli_real_escape_string($conn, $_POST['ans2']);
	$ans3 = mysqli_real_escape_string($conn, $_POST['ans3']);
	$ans4 = mysqli_real_escape_string($conn, $_POST['ans4']);
	$correct = $_POST['cans'];

	 if (!empty($clsName) || !empty($subjName) || !empty($question) || !empty($ans1) || !empty($ans2) || !empty($ans3) || !empty($ans4)) {	
		
		mysqli_query($conn, "delete FROM opt_style WHERE quest_id=0");
		if(isset($_POST['update'])) {

			mysqli_query( $conn, "update count_quest Set userid='".$sessionrow['id']."',class='".$clsName."',subject='".$subjName."',topic='".$tpName."',subtopic='".$sbtpName."',type2='".$flagtype."',question='".trim($question)."',hint='".trim($hint)."',opt_a='".trim($ans1)."',opt_b='".trim($ans2)."',opt_c='".trim($ans3)."',opt_d='".trim($ans4)."',correct_ans='".$correct."',updated_at=NOW() WHERE id=".$row['id']."" );
			if(!empty($optstyle_rslt['style_id'])) {
			mysqli_query( $conn, "update opt_style Set style_id='".$optstyle."'  WHERE quest_id=".$row['id']."" );
			} else {
				mysqli_query( $conn, "INSERT INTO opt_style(quest_id,style_id) VALUES ('".$row['id']."','".$optstyle."')" );
			}

		} elseif(isset($_POST['submit'])) {

			mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type2,question,hint,opt_a,opt_b,opt_c,opt_d,correct_ans,status,created_at,updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$flagtype."','".trim($question)."','".trim($hint)."','".trim($ans1)."','".trim($ans2)."','".trim($ans3)."','".trim($ans4)."','".$correct."',0,NOW(),NOW())" );
			mysqli_query( $conn, "INSERT INTO opt_style(quest_id,style_id) VALUES ('".$conn->insert_id."','".$optstyle."')" );
		}

		mysqli_close($conn);

		if(isset($_POST['update'])) {

			header( 'location:' . $baseurl . 'controlgear/question-bank?id='.$id);

		} elseif(isset($_POST['submit'])) {

			$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved</div>';
			header( 'location:' . $baseurl . 'controlgear/question-bank?message=success' );

		}		
		exit;	
	} else {
		$errMsg = '<div class="alert alert-danger" role="alert">Required field are empty.</div>';
	}
}

if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' ) {
	$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/question-bank');</script>";

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
				<li>Question Bank</li>
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
						<div class="col-md-12 form-row">
						<div class="col-md-6 form-group">
							<label class="label mb-1">Select Class <span class="required">*</span></label>
							<select name="clsName" id="clsName" onChange="selectClass()" class="custom-select form-control" required>
							<option value="">Please Select</option>
							<?php $catsql = mysqli_query($conn, "SELECT id,name from subject_class WHERE type=2 and status=1 order by id asc");
							while($catrow = mysqli_fetch_array($catsql)) {
							if($catrow['id'] == $row['class']) { ?>
								<option value="<?php echo $catrow['id']; ?>" selected><?php echo $catrow['name']; ?></option>
							<?php } else { ?>
								<option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['name']; ?></option>
							<?php } } ?>
						</select>
						</div>
						<div id="displaySubject" class="col-md-6 form-group"></div>
						<div id="displayTopic" class="col-md-6 form-group"></div>
						<div id="displaySubTopic" class="col-md-6 form-group"></div>
						</div>
						<div class="col-md-12 form-group">
						<label class="label d-block">Question type <span class="required">*</span></label>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="flagtype" value="q1" id="flexRadioDefault1" <?php if(isset($row['type2'])){ if($row['type2'] == 'q1'){ echo 'checked'; } } else { echo 'checked';} ?> required>
							<label class="form-check-label" for="flexRadioDefault1">Quiz</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="flagtype" value="p1" id="flexRadioDefault2" <?php if(isset($row['type2'])){ if($row['type2'] == 'p1'){ echo 'checked'; } } ?> required>
							<label class="form-check-label" for="flexRadioDefault2">Practice</label>
						</div>
						</div>
						<div class="col-md-6 form-group">
							<label class="label mb-1">Option Style</label>
							<select name="optstyle" id="optstyle" class="custom-select form-control" required>
							<option value="1" <?php if(isset($optstyle_rslt['style_id'])){ if($optstyle_rslt['style_id'] == '1'){ echo 'selected'; } } ?>>Text Grid 2</option>
							<option value="2" <?php if(isset($optstyle_rslt['style_id'])){ if($optstyle_rslt['style_id'] == '2'){ echo 'selected'; } } ?>>Text Horizontal</option>
							<option value="3" <?php if(isset($optstyle_rslt['style_id'])){ if($optstyle_rslt['style_id'] == '3'){ echo 'selected'; } } ?>>Image Horizontal</option>
							<option value="4" <?php if(isset($optstyle_rslt['style_id'])){ if($optstyle_rslt['style_id'] == '4'){ echo 'selected'; } } ?>>Image Grid 2</option>
						</select>
						</div>
						<div class="col-md-12 form-group">
						<label class="label">Question <span class="required">*</span></label>
						<textarea name="editor" id="editor" class="ckeditor"><?php echo $row['question']; ?></textarea>
						</div>
						<div class="col-md-12 form-group">
						<label class="label">Hint </label>
						<textarea rows="4" name="hint" id="hint" class="form-control"><?php echo $row['hint']; ?></textarea>
						</div>
						<div class="col-md-12 form-row">
						<div class="col-6 form-group mb-4">
						<label class="label d-flex align-items-center"><span class="mr-3">Answer 1</span> <div class="custom-control custom-checkbox answer-checkbox">
                              <input type="radio" class="custom-control-input" id="cans1" name="cans" value="1" <?php if($row['correct_ans'] == '1') { echo "checked";} else { echo 'checked';} ?>>
                              <label class="custom-control-label d-flex align-item-center" for="cans1">Correct Answer</label>
                            </div></label>
							<textarea name="ans1" id="ans1" class="ckeditor"><?php echo $row['opt_a']; ?></textarea>
							
						</div>
						<div class="col-6 form-group mb-4">
						<label class="label d-flex align-items-center"><span class="mr-3">Answer 2</span> <div class="custom-control custom-checkbox answer-checkbox">
                              <input type="radio" class="custom-control-input" id="cans2" name="cans" value="2" <?php if($row['correct_ans'] == '2') { echo "checked";} ?>>
                              <label class="custom-control-label d-flex align-item-center" for="cans2">Correct Answer</label>
                            </div></label>
							<textarea name="ans2" id="ans2" class="ckeditor"><?php echo $row['opt_b']; ?></textarea>
							
						</div>
						<div class="col-6 form-group mb-4">
						<label class="label d-flex align-items-center"><span class="mr-3">Answer 3</span> <div class="custom-control custom-checkbox answer-checkbox">
                              <input type="radio" class="custom-control-input" id="cans3" name="cans" value="3" <?php if($row['correct_ans'] == '3') { echo "checked";} ?>>
                              <label class="custom-control-label d-flex align-item-center" for="cans3">Correct Answer</label>
                            </div></label>
							<textarea name="ans3" id="ans3" class="ckeditor"><?php echo $row['opt_c']; ?></textarea>
						</div>
						<div class="col-6 form-group mb-4">
							<label class="label d-flex align-items-center"><span class="mr-3">Answer 4</span> <div class="custom-control custom-checkbox answer-checkbox">
                              <input type="radio" class="custom-control-input" id="cans4" name="cans" value="4" <?php if($row['correct_ans'] == '4') { echo "checked";} ?>>
                              <label class="custom-control-label d-flex align-item-center" for="cans4">Correct Answer</label>
                            </div></label>
							<textarea name="ans4" id="ans4" class="ckeditor"><?php echo $row['opt_d']; ?></textarea>
						</div>
						</div>
						<div class="col-md-12">
						<?php if(!empty($row['id'])) { ?>
							<button type="submit" name="update" id="submit" class="btn btn-primary custom-btn">update</button>
							<a href="checkques?id=<?php echo $id; ?>" class="btn btn-alert custom-btn" target="_blank">Preview</a>
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
<?php include("left-navigation.php"); ?>
<?php include("footer.php"); ?>
<?php mysqli_close($conn); ?>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>