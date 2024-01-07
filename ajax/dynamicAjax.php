<?php 
include("../config/config.php");
?>

<?php if(!empty($_POST["clsName"])) { ?>
	<label class="label mb-1">Select Subject <span class="required">*</span></label>
							<select name="subjName" id="subjName" onChange="selectSubject()" class="custom-select form-control">
							<option value="">Please Select</option>
							<?php $catsql = mysqli_query($conn, "SELECT DISTINCT a.name,a.id FROM subject_class as a INNER JOIN topics_subtopics as b ON b.subject_id=a.id WHERE b.class_id='".$_POST["clsName"]."' and a.status=1 and b.status=1");
							while($catrow = mysqli_fetch_array($catsql)) { ?>
							<option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['name']; ?></option>
							<?php } ?>
						</select>
<?php } ?>


<?php if(!empty($_POST["sbjName"])) {?>
              <label class="label mb-1">Select Topic <span class="required">*</span></label>
							<select name="tpName" id="tpName" onChange="selectTopic()" class="custom-select form-control">
							<option value="">Please Select</option>
							<?php $catsql = mysqli_query($conn, "SELECT a.topic,a.id FROM topics_subtopics as a INNER JOIN subject_class as b ON b.id=a.subject_id WHERE a.subject_id='".$_POST["sbjName"]."' and a.class_id='".$_POST["sbjclsName"]."' and parent=0 and a.status=1 and b.status=1");
							while($catrow = mysqli_fetch_array($catsql)) { ?>
							<option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['topic']; ?></option>
							<?php } ?>
						</select>
<?php } ?>

                    <?php if(!empty($_POST["tpName"])) {  ?>
                      <label class="label mb-1">Select Sub-Topic <span class="required">*</span></label>
							<select name="sbtpName" id="sbtpName" onChange="selectSubTopic()" class="custom-select form-control">
							<option value="">Please Select</option>
							<?php $catsql = mysqli_query($conn, "SELECT subtopic,id FROM topics_subtopics WHERE parent=".$_POST["tpName"]." and status=1");
							while($catrow = mysqli_fetch_array($catsql)) { ?>
							<option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['subtopic']; ?></option>
							<?php } ?>
						</select>
                        <?php } ?>

                   