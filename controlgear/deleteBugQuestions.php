<?php 
    include( "../config/config.php" );
    include( "../functions.php" );

    if(empty($_SESSION['id']))
        header('Location:'.$baseurl.'');

    $sessionsql = mysqli_query($conn, "SELECT id, isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);
?>


<?php if($sessionrow['isAdmin'] == 1) { ?>
    <?php include("header.php"); ?>
	<div class="breadcrumbs-title-container">
		<div class="container-fluid">
			<h5 class="page-title">Delete Bug Questions</h5>
			<div class="breadcrumbs">
				<ul>
					<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
					</li>
					<li>Delete Bug Questions</li>
				</ul>
			</div>
		</div>
	</div>
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-7">
				<div class="grid bg-white box-shadow-light">			
					<div id="msg" class="msg">
						<?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
					</div>
					<!-- <form id="postForm" action="" method="post" enctype="multipart/form-data"> -->
						<div class="row">
							<div class="col-md-8">
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

                        
					<!-- </form> -->
				</div>
			</div>
            <div class="col-md-5 pl-md-0">
								<div class="grid bg-white box-shadow-light pl-4 pt-2 pr-2">
									<div class="content h-fix pr-4">
										<?php 
											$classSql = mysqli_query($conn, "SELECT id,name FROM subject_class WHERE type=2 and status=1");
											while($classRow = mysqli_fetch_assoc($classSql)) { 
										?>
												<h3 class="heading bb-1 pb-2 mt-4"><?php echo $classRow['name']; ?></h3>	
											<?php 	
												$tpcqury = mysqli_query($conn, "SELECT id,topic FROM topics_subtopics WHERE class_id='".$classRow['id']."' and parent=0 and status=1");
												while($tpcrow = mysqli_fetch_assoc($tpcqury)) { 
											?>
													<h3 class="heading mb-1 mt-4"><?php echo $tpcrow['topic']; ?></h3>
													<?php $sbtpcqury = mysqli_query($conn, "SELECT id,subtopic FROM topics_subtopics WHERE parent='".$tpcrow['id']."' and status=1");
														while($sbtpcrow = mysqli_fetch_assoc($sbtpcqury)) { 
															
															$cntqury = mysqli_query($conn, "SELECT COUNT(subtopic) as count_subtopic FROM count_quest WHERE subtopic='".$sbtpcrow['id']."'");
															$cntrslt = mysqli_fetch_assoc($cntqury);	
													?>
															<div class="text-grey"><?php echo $sbtpcrow['subtopic'].' - <strong>('.$cntrslt['count_subtopic'].')</strong>'; ?></div>
														<?php 
														} 
												} 
											} 
										?>
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