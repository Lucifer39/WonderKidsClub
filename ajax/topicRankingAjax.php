<?php 
include("../config/config.php");
?>

<?php if(!empty($_POST["clsName"])) { ?>
	<label class="label mb-1">Select Subject <span class="required">*</span></label>
							<select name="subjName" id="subjName" onChange="selectSubject()" class="custom-select form-control" required>
							<option value="">Please Select</option>
							<?php $catsql = mysqli_query($conn, "SELECT DISTINCT a.name,a.id FROM subject_class as a INNER JOIN topics_subtopics as b ON b.subject_id=a.id WHERE b.class_id='".$_POST["clsName"]."' and a.status=1 and b.status=1");
							while($catrow = mysqli_fetch_array($catsql)) {
								if($catrow['id'] == $_POST['sbjN']) { ?>
							<option value="<?php echo $catrow['id']; ?>" selected><?php echo $catrow['name']; ?></option>
							<?php } else { ?>
								<option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['name']; ?></option>
							<?php } } ?>
						</select>
<?php } ?>


<?php if(!empty($_POST["sbjName"])) {?>
              <label class="label mb-3">Select Topic <span class="required">*</span></label>
			  <?php $catsql = mysqli_query($conn, "SELECT a.topic,a.id,tr.rank FROM topics_subtopics as a INNER JOIN subject_class as b ON b.id=a.subject_id LEFT JOIN topic_ranking tr ON tr.topic_id = a.id WHERE a.subject_id='".$_POST["sbjName"]."' and a.class_id='".$_POST["sbjclsName"]."' and parent=0 and a.status=1 and b.status=1");
							while($catrow = mysqli_fetch_array($catsql)) { ?>
                                    <div class="form-row align-items-center form-group">
                                    <div class="form-check flex-grow-1 pr-3 pl-1">
                                    <input class="form-check-input hide" name="topic[]" type="checkbox" value="<?php echo $catrow['id']; ?>" id="flexCheckDefault_<?php echo $i; ?>" checked>
                                    <label class="form-check-label" for="flexCheckDefault_<?php echo $i; ?>">
                                    <?php echo $catrow['topic']; ?>
                                    </label>
                                    </div>
                                    <input type="text" class="form-control w-auto" name="ranQues[]" placeholder="0" value="<?php echo $catrow['rank'] ?? 0; ?>">
                                    <input type="hidden" name="ranTopic[]" value="<?php echo $catrow['id']; ?>">
                                    </div>
                                <?php } ?>
<?php } ?>

                   