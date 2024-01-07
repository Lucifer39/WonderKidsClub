<?php 
include("../config/config.php");
?>

<?php if(!empty($_POST["className"])) {  ?>
<?php $sbjMSql = mysqli_query($conn, "SELECT DISTINCT a.name FROM subject_class as a INNER JOIN topics_subtopics as b ON b.subject_id=a.id WHERE b.class_id='".$_POST["className"]."' and a.status=1 and b.status=1");
$sbjMRow = mysqli_fetch_assoc($sbjMSql); if(!empty($sbjMRow['name'])) { ?>  
	<div class="block-widget text-center mb-3 p-4">
                        <h3 class="section-title mb-3 mt-1">Select Subject</h3>
                        <div class="multi-btn grid-4 text-center">
                        <?php $i=1; $sbjSql = mysqli_query($conn, "SELECT DISTINCT a.name,a.id FROM subject_class as a INNER JOIN topics_subtopics as b ON b.subject_id=a.id WHERE b.class_id='".$_POST["className"]."' and a.status=1 and b.status=1");
while($sbjRow = mysqli_fetch_assoc($sbjSql)) { 
  $selectsql = mysqli_query($conn, "SELECT DISTINCT b.id,b.name FROM grpwise as a INNER JOIN subject_class as b ON b.id=a.subject WHERE a.subject='".$sbjRow['id']."' and a.id='".$_POST["sbjid"]."'"); $selectrow = mysqli_fetch_array($selectsql);
  ?>


<?php if (!empty($selectrow['id'])) { ?>
  <div class="check-btn">
  <input class="form-check-input" type="radio" name="subject" onClick="displayGName()" value="<?php echo $sbjRow['id']; ?>" id="subject_<?php echo $i; ?>" checked>
  <div class="label-wrapper">
  <label for="subject_<?php echo $i; ?>"></label>
  <span class="notchecked"><?php echo $sbjRow['name']; ?></span>
  </div>
  </div>
<?php } else { ?>
  <div class="check-btn">
  <input class="form-check-input" type="radio" name="subject" onClick="displayGName()" value="<?php echo $sbjRow['id']; ?>" id="subject_<?php echo $i; ?>">
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



                   