<?php 
    include( "../config/config.php" );
    include( "../functions.php" );

    if(empty($_SESSION['id']))
	    header('Location:'.$baseurl.'');

    $sessionsql = mysqli_query($conn, "SELECT id, isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if(isset($_POST["submit"])) {
        $topics = $_POST["ranTopic"];
        $ranks = $_POST["ranQues"];

        for($i = 0; $i < count($topics); $i++) {
            $sql = mysqli_query($conn,"INSERT INTO topic_ranking (topic_id, rank)
                                        VALUES (". $topics[$i] .", ". $ranks[$i] .")
                                        ON DUPLICATE KEY UPDATE
                                        rank = ". $ranks[$i] ." ");

            mysqli_fetch_assoc($sql);
        }

        mysqli_close($conn);
        $errMsg = '<div class="alert alert-success" role="alert">Successfully Saved</div>';
        header( 'location:' . $baseurl . 'controlgear/topicRanking?message=success' );
        exit();
    }

    if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' ) {
        $errMsg = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';
        echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/topicRanking');</script>";
    
    }
?>
<?php if($sessionrow['isAdmin'] == 1) { ?>
    <?php include("header.php"); ?>
    <div class="breadcrumbs-title-container">
		<div class="container-fluid">
			<h5 class="page-title">Topic Rankings</h5>
			<div class="breadcrumbs">
				<ul>
					<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
					</li>
					<li>Topic Rankings</li>
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
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-12">
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
                        </div>
                        <div class="row">
                            <div class="input-group">
                                <input type="submit" class="btn btn-primary custom-btn" name="submit" value="Save">
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