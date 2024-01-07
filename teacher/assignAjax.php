<?php include("../config/config.php"); ?>

<?php if(!empty($_POST["className"])) { ?>
<?php $sbjMSql = mysqli_query($conn, "SELECT DISTINCT a.name FROM subject_class as a INNER JOIN topics_subtopics as b ON b.subject_id=a.id WHERE b.class_id='".$_POST["className"]."' and a.status=1 and b.status=1");
$sbjMRow = mysqli_fetch_assoc($sbjMSql); if(!empty($sbjMRow['name'])) { ?>  
<div class="block-widget text-center mb-3 p-4">
                        <h3 class="section-title mb-3 mt-1">Select Subject</h3>
                        <div class="multi-btn grid-4 text-center">
                        <?php $i=1; 
                        $grpSql = mysqli_query($conn, "SELECT DISTINCT(subject) FROM grpwise WHERE status=1 order by subject asc");
                        while($grpRow = mysqli_fetch_assoc($grpSql)) {
                        $sbjSql = mysqli_query($conn, "SELECT DISTINCT a.name,a.id FROM subject_class as a INNER JOIN topics_subtopics as b ON b.subject_id=a.id WHERE a.id=".$grpRow['subject']." and b.class_id='".$_POST["className"]."' and a.status=1 and b.status=1");
                        $sbjRow = mysqli_fetch_assoc($sbjSql); 
  $selectsql = mysqli_query($conn, "SELECT DISTINCT b.id,b.name FROM grpwise as a INNER JOIN subject_class as b ON b.id=a.subject INNER JOIN assign_grp as c ON c.subject=a.subject WHERE a.subject='".$sbjRow['id']."' and c.id='".$_POST["sbjid"]."'"); $selectrow = mysqli_fetch_array($selectsql);
  ?>


<?php if (!empty($selectrow['id'])) { ?>
  <div class="check-btn">
  <input class="form-check-input" type="radio" name="subject" onClick="selectSubject()" value="<?php echo $sbjRow['id']; ?>" id="subject_<?php echo $i; ?>" checked >
  <div class="label-wrapper">
  <label for="subject_<?php echo $i; ?>"></label>
  <span class="notchecked"><?php echo $sbjRow['name']; ?></span>
  </div>
  </div>
<?php } else { ?>
  <div class="check-btn">
  <input class="form-check-input" type="radio" name="subject" onClick="selectSubject()" value="<?php echo $sbjRow['id']; ?>" id="subject_<?php echo $i; ?>" >
  <div class="label-wrapper">
  <label for="subject_<?php echo $i; ?>"></label>
  <span class="notchecked"><?php echo $sbjRow['name']; ?></span>
  </div>
  </div>
<?php } ?>
<?php $i++; } ?>
</div>
                    </div>
                    <?php } } ?>

<?php if(!empty($_POST["subjectName"])) { ?>
	<div class="block-widget text-center mb-3 p-4">
                        <h3 class="section-title mb-3 mt-1">Select Topic</h3>
                        <div class="accordion-tabs">
                        <?php $i=1; $classSql = mysqli_query($conn, "SELECT a.topic,a.id,a.subtopic FROM topics_subtopics as a INNER JOIN subject_class as b ON b.id=a.subject_id WHERE a.subject_id='".$_POST["subjectName"]."' and a.class_id='".$_POST["sbjclsName"]."' and parent=0 and a.status=1 and b.status=1");
while($classRow = mysqli_fetch_assoc($classSql)) {

  $stCountsql = mysqli_query($conn, "SELECT DISTINCT subtopic FROM topics_subtopics WHERE parent='".$classRow['id']."'"); 
  $stCountrow = mysqli_fetch_assoc($stCountsql);

  if(!empty($stCountrow['subtopic'])) {

  $selectsql = mysqli_query($conn, "SELECT DISTINCT topic FROM assign_grpids WHERE topic='".$classRow['id']."' and assign_grp='".$_POST['sbjid']."'"); 
  $selectrow = mysqli_fetch_assoc($selectsql);
  
  ?>
  <div class="accordion-list plus <?php if(!empty($selectrow['topic'])) { echo "on minus"; } else {echo "off"; } ?>">
                <div class="accordion-heading">
                <div class="d-flex align-items-md-center justify-content-start">
                    <h3 class="heading flex-grow-1 ">  
  <?php echo $classRow['topic']; ?></h3><span class="symbol"></span></div>
</div>
                <div class="content">
                <div class="multi-btn grid-4 text-center">
                <?php $j=1; $ids=$classRow['id']; $sbjSql = mysqli_query($conn, "SELECT subtopic,id FROM topics_subtopics WHERE parent IN ($ids) and status=1");
while($sbjRow = mysqli_fetch_assoc($sbjSql)) {
  
  $selectsql = mysqli_query($conn, "SELECT DISTINCT subtopic FROM assign_grpids WHERE subtopic='".$sbjRow['id']."' and assign_grp='".$_POST['sbjid']."'"); 
  $selectrow = mysqli_fetch_assoc($selectsql);

  if (!empty($selectrow['subtopic'])) { 
  ?>
                <div class="check-btn">
  <input class="form-check-input" type="checkbox" name="subtopic[]" onClick="displayGName()" value="<?php echo $sbjRow['id']; ?>" id="subtopic_<?php echo $sbjRow['id'].$j; ?>" checked>
  <div class="label-wrapper">
  <label for="subtopic_<?php echo $sbjRow['id'].$j; ?>"></label>
  <span class="notchecked"><?php echo $sbjRow['subtopic']; ?></span>
  </div>
  </div>
  <?php } else { ?>
    <div class="check-btn">
  <input class="form-check-input" type="checkbox" name="subtopic[]" onClick="displayGName()" value="<?php echo $sbjRow['id']; ?>" id="subtopic_<?php echo $sbjRow['id'].$j; ?>" >
  <div class="label-wrapper">
  <label for="subtopic_<?php echo $sbjRow['id'].$j; ?>"></label>
  <span class="notchecked"><?php echo $sbjRow['subtopic']; ?></span>
  </div>
  </div>
  <?php } ?>
  <?php $j++; } } ?>
                </div>
                </div>
</div>
<?php $i++; }?>
</div>
                    </div>
                    <?php } ?>


<?php if(!empty($_POST["dispclsName"])) {
  $sql = mysqli_query($conn, "SELECT grp_name FROM assign_grp WHERE id='".$_POST['sbjid']."' and status=1");
  $row = mysqli_fetch_array($sql, MYSQLI_ASSOC);
  ?>
  <div class="row justify-content-center text-left">
    <div class="col-md-5">
      <div class="mb-3">
        <input type="text" name="grpname" class="form-control" placeholder="Practice Name" value="<?php echo $row['grp_name']; ?>">
      </div>
      <div class="mb-3">
        <select name="assigngrp[]" id="assigngrp" class="form-select" multiple >
          <option value="">Please Select Student Group(s)</option>
          <?php $catsql = mysqli_query($conn, "SELECT id,name from grpwise WHERE class='".$_POST["dispclsName"]."' and user='".$_SESSION['id']."' and status=1 order by name asc"); 
          while($catrow = mysqli_fetch_array($catsql)) { 
            
            $selectsql = mysqli_query($conn, "SELECT DISTINCT grpids FROM assign_grpids WHERE grpids='".$catrow['id']."' and assign_grp='".$_POST['sbjid']."'"); 
  $selectrow = mysqli_fetch_assoc($selectsql);

  if (!empty($selectrow['grpids'])) {
            ?>
          <option value="<?php echo $catrow['id']; ?>" selected><?php echo $catrow['name']; ?></option>
          <?php } else { ?>
            <option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['name']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
      </div>
      <button type="submit" name="submitgrp" class="btn btn-red custom-btn">Create GROUP</button>
      <?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
    </div>
  </div>
  <script>

var select_box_element = document.querySelector('#assigngrp');

dselect(select_box_element, {
    search: false
});

</script>
<?php } ?>