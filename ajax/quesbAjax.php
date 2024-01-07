<?php 
include("../config/config.php");
?>

<?php if(!empty($_POST["clsName"])) { ?>
	<label class="label mb-1">Select Subject <span class="required">*</span></label>
							<select name="subjName" id="subjName" onChange="selectSubject()" class="custom-select form-control" required>
							<option value="">Please Select</option>
							<?php $catsql = mysqli_query($conn, "SELECT name,id FROM subject_class WHERE status=1 and type=1");
							while($catrow = mysqli_fetch_array($catsql)) {
								if($catrow['id'] == $_POST['sbjN']) { ?>
							<option value="<?php echo $catrow['id']; ?>" selected><?php echo $catrow['name']; ?></option>
							<?php } else { ?>
								<option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['name']; ?></option>
							<?php } } ?>
						</select>
<?php } ?>


<?php if(!empty($_POST["sbjName"])) {?>
              <label class="label mb-1">Select Topic <span class="required">*</span></label>
							<select name="tpName" id="tpName" onChange="selectTopic()" class="custom-select form-control" data-live-search="true" required>
							<option value="">Please Select</option>
							<?php $catsql = mysqli_query($conn, "SELECT topic,id,class_id,subject_id FROM topics_subtopics WHERE class_id='".$_POST["sbjclsName"]."' and parent=0 and status=1");
							while($catrow = mysqli_fetch_array($catsql)) {
								if($catrow['id'] == $_POST['topicName']) { ?>
								<option value="<?php echo $catrow['id']; ?>" selected><?php echo $catrow['topic']; ?></option>
							<?php } else { ?>
								<option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['topic']; ?></option>
							<?php } } ?>
						</select>
<?php } ?>

                    <?php if(!empty($_POST["tpName"])) {  ?>
                      <label class="label mb-1">Select Sub-Topic <span class="required">*</span></label>
							<select name="sbtpName" id="sbtpName" onChange="selectSubTopic()" class="custom-select form-control" required>
							<option value="">Please Select</option>
							<?php $catsql = mysqli_query($conn, "SELECT subtopic,id FROM topics_subtopics WHERE parent=".$_POST["tpName"]." and status=1");
							while($catrow = mysqli_fetch_array($catsql)) {
							if($catrow['id'] == $_POST['subtopicName']) { ?>
								<option value="<?php echo $catrow['id']; ?>" selected><?php echo $catrow['subtopic']; ?></option>
							<?php } else { ?>
								<option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['subtopic']; ?></option>
							<?php } } ?>
						</select>
                        <?php } ?>

                   