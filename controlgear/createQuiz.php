<?php
include( "../config/config.php" );
include( "../functions.php" );

require_once '../dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,class,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if (isset($_POST['submit'])) {
	$type = $_POST['selQuiz'];
	$name = $_POST['heading'];
	$process = $_POST['quessel'];
	$clsName = $_POST['clsName'];
	$subjName = $_POST['subjName'];
	//$tpName = $_POST['tpName'];
	$otherCls = $_POST['otherCls'];

	if (!empty($name)) {

		if($type == '1') {
			$t = 'quiz';
		} else {
			$t = 'paper';
		}
	
		$clssql = mysqli_query($conn, "SELECT slug FROM subject_class WHERE id='".$clsName."' and type=2 and status=1");
		$clsrow = mysqli_fetch_assoc($clssql);
	
		$subjsql = mysqli_query($conn, "SELECT slug FROM subject_class WHERE id='".$subjName."' and type=1 and status=1");
		$subjrow = mysqli_fetch_assoc($subjsql);
	
		if($process == '1') {
			$p = 'm';
		} else {
			$p = 'a';
		}
		
		$slug = slugify($name).'-'.$p.$t.'-'.$clsrow['slug'].'-'.$subjrow['slug'].'-'.date('dmY',strtotime(date('Y-m-d')));

	if($type == '1') {
		$start_d = $_POST['strtdate'];
		$end_d = $_POST['enddate'];
		$crt_marks = $_POST['crtmarks'];
		$neg_marks = $_POST['negmarks'];

		$sql = mysqli_query($conn, "INSERT INTO quiz(userid,type,name,start_date,end_date,correct_marks,negative_marks,selection,class,subject,status,slug,created_at,updated_at) VALUES ('".$_SESSION['id']."','".$type."','".$name."','".$start_d."','".$end_d."','".$crt_marks."','".$neg_marks."','".$process."','".$clsName."','".$subjName."','1','".$slug."',NOW(),NOW())");
	} else {
		$sql = mysqli_query($conn, "INSERT INTO quiz(userid,type,name,selection,class,subject,status,slug,created_at,updated_at) VALUES ('".$_SESSION['id']."','".$type."','".$name."','".$process."','".$clsName."','".$subjName."','1','".$slug."',NOW(),NOW())");
	}
	
		$prosql = mysqli_query($conn, "SELECT id,class,subject FROM quiz WHERE id='".$conn->insert_id."'");
		$prorow = mysqli_fetch_array($prosql, MYSQLI_ASSOC);
		
		$prodid = $prorow['id'];
		//$prodslug = $prorow['slug'];

        //Random Quest
		$randomQuesCount = count($_POST["subtopic"]); 
		$randomQues = $_POST["subtopic"];
		$ranQues = $_POST["ranQues"];
		$ranTopic = $_POST["ranTopic"];
		//if($randomQuesCount > 0)
		//{
			for($i=0; $i<$randomQuesCount; $i++)
			{
				//if($_POST["subtopic"][$i] > 0)
				//{	
					//echo $randomQues[$i];
					//echo $ranQues[$i];
					$randquessql = mysqli_query($conn, "SELECT id FROM count_quest WHERE class='".$prorow['class']."' and subject='".$prorow['subject']."' and topic='".$ranTopic[$i]."' and subtopic='".$randomQues[$i]."' ORDER BY RAND() LIMIT ".$ranQues[$i]."");
					while($randquesrow = mysqli_fetch_array($randquessql)) {

							mysqli_query($conn, "INSERT INTO quiz_quest(quizid,topic,subtopic,question,question_id) VALUES ('".$prodid."','".$ranTopic[$i]."','".$randomQues[$i]."','".$ranQues[$i]."','".$randquesrow['id']."')");
						}
					//mysqli_query($conn, "INSERT INTO quiz_quest(quizid,topic,subtopic,question) VALUES ('".$prodid."','".$ranTopic[$i]."','".$randomQues[$i]."','".$ranQues[$i]."')");
				//}
				mysqli_query($conn, "DELETE FROM quiz_quest WHERE question=0");
			}
			//die();
		//}	
 
		mysqli_query($conn, "DELETE FROM quiz_other_class WHERE quizid='".$prodid."'");
		mysqli_query($conn, "INSERT INTO quiz_other_class(quizid,class_id,created_at,updated_at) VALUES ('".$prodid."','".$sessionrow['class']."',NOW(),NOW())");
		for($i=0; $i<count($otherCls); $i++) 
			{
				mysqli_query($conn, "INSERT INTO quiz_other_class(quizid,class_id,created_at,updated_at) VALUES ('".$prodid."','".$otherCls[$i]."',NOW(),NOW())");
			}


	   /*if($t == 'paper') {
		$html = '';
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $options->set('tempDir', '/tmp'); //folder name and location can be changed
        $dompdf = new Dompdf($options);

        include('../components/offline_ques.php');

        $dompdf->load_html($html);
        $dompdf->set_paper("letter", "portrait" );
        $dompdf->render();
        // Path to the directory where you want to save the PDF
		$savePath = '../offline/';

		// Filename for the PDF
		$filename = ''.$slug .'-question.pdf';

		// Save the PDF to the specified folder
		file_put_contents($savePath . $filename, $pdfOutput);
	   }*/
		
		mysqli_close($conn);
		$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved</div>';
		header( 'location:' . $baseurl . 'controlgear/createQuiz?message=success' );
		exit();		
		
	} else {
		$errMsg = '<div class="alert alert-danger" role="alert">Required field are empty.</div>';
	}
}

if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' ) {
	$errMsg = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';
	echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/createQuiz');</script>";

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
				<li>Create Quiz</li>
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
								<label class="label">Select Quiz or Paper <span class="required">*</span></label>
								<select name="selQuiz" id="selQuiz" onChange="selQuiz()" class="custom-select form-control">
								<option value="">Please Select</option>
									<option value="1">Quiz</option>
									<option value="2">Paper</option>
								</select>
							</div>
							<div class="form-group">
								<label class="label">Quiz/Paper Name <span class="required">*</span></label>
								<input type="text" name="heading" id="heading" class="form-control" value="">
							</div>
							<div id="displayQuiz" class="form-row hide">
							<div class="form-group col-6">
								<label class="label">Start Date <span class="required">*</span></label>
								<input type="date" name="strtdate" id="strtdate" class="form-control startdate" value="">
							</div>
							<div class="form-group col-6">
								<label class="label">End Date <span class="required">*</span></label>
								<input type="date" name="enddate" id="enddate" class="form-control enddate" value="">
							</div>
							<div class="form-group col-6">
								<label class="label">Correct Marks</label>
								<input type="text" name="crtmarks" id="crtmarks" class="form-control" value="0">
							</div>
							<div class="form-group col-6">
								<label class="label">Negative Marks</label>
								<input type="text" name="negmarks" id="negmarks" class="form-control" value="0">
							</div>
							</div>
							<div class="form-group">
								<label class="label">Question Selection <span class="required">*</span></label>
								<select name="quessel" id="quessel" class="custom-select form-control">
								<option value="">Please Select</option>
									<option value="1">Manual</option>
									<option value="2">Automatically</option>
								</select>
							</div>
							<div class="form-group">
							<label class="label mb-1">Select Class <span class="required">*</span></label>
							<select name="clsName" id="clsName" onChange="selectClass()" class="custom-select form-control" required>
								<option value="">Please Select</option>
								<?php $catsql = mysqli_query($conn, "SELECT id,name from subject_class WHERE type=2 and status=1 order by id asc");
								while($catrow = mysqli_fetch_array($catsql)) { ?>
									<option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['name']; ?></option>
								<?php } ?>
							</select>
						</div>
						<div id="displaySubject" class="form-group"></div>
						<div id="displayTopic" class="form-group"></div>
						<div id="displaySubTopic" class="form-group"></div>
						</div>
				<div class="col-md-12">
					<button type="submit" name="submit" id="submit" class="btn btn-primary custom-btn">Save</button>
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