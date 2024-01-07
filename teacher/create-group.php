<?php include( "../config/config.php"); 
include( "../functions.php");

if(empty($_SESSION['id'])) {
header('Location:'.$baseurl.'');
}

$url = trim($_SERVER["REQUEST_URI"],"/");
$id = substr($url, strpos($url, '=') + 1);

$sql = mysqli_query($conn, "SELECT id,name,pass FROM grpwise WHERE id=$id and status=1");
$row = mysqli_fetch_array($sql, MYSQLI_ASSOC);

if (isset($_POST['submitgrp']) || isset($_POST['updategrp'])) {
	$class = $_POST['class'];
	$subject = $_POST['subject'];
  $name = $_POST['grpname'];
	$pass = $_POST['tp_pass'];

  if(isset($_POST['updategrp'])) {
  mysqli_query( $conn, "update grpwise Set class='".$class."',subject='".$subject."',name='".trim($name)."',pass='".$pass."',updated_at=NOW() WHERE id=".$id."" );
  $prodid = $id;
} else {
  $link = 'ed'.$class.$subject.'a'.generateRandomURL(10);
  
  $checkqry = mysqli_query($conn, "SELECT id FROM grpwise WHERE link='".$link."'");
	$checkrslt = mysqli_fetch_array($checkqry, MYSQLI_ASSOC);

  if(empty($checkrslt['id'])) {
    mysqli_query( $conn, "INSERT INTO grpwise(user,class,subject,name,pass,link,status,created_at,updated_at) VALUES ('".$_SESSION['id']."','".$class."','".$subject."','".trim($name)."','".$pass."','".$link."','1',NOW(),NOW())" );
  } else {
    $link = 'ed'.$class.$subject.'a'.generateRandomURL(10);
    mysqli_query( $conn, "INSERT INTO grpwise(user,class,subject,name,pass,link,status,created_at,updated_at) VALUES ('".$_SESSION['id']."','".$class."','".$subject."','".trim($name)."','".$pass."','".$link."','1',NOW(),NOW())" );
  }


  $prosql = mysqli_query($conn, "SELECT id,class,subject FROM grpwise WHERE id='".$conn->insert_id."'");
	$prorow = mysqli_fetch_array($prosql, MYSQLI_ASSOC);
		
	$prodid = $prorow['id'];
}

 // Import CSV, XLSX, and XLS
$allowedFileTypes = [
  'text/csv',
  'application/vnd.ms-excel',
  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
];

if (in_array($_FILES["file"]["type"], $allowedFileTypes)) {
  $file = $_FILES['file']['tmp_name'];

  if ($_FILES["file"]["type"] == "text/csv") {
      // CSV file
      $handle = fopen($file, "r");
      $c = 1;
      while (($filesop = fgetcsv($handle, 10000, ",")) !== false) {
          $name = $filesop[0];
          $email = $filesop[1];
          $optional = $filesop[2];

          $sql = "INSERT INTO tch_grp_usr_list(grp_id, name, email, optional, status, created_at, updated_at) VALUES ('".$prodid."','".$name."','".$email."','".$optional."',0,NOW(),NOW())";
          $stmt = mysqli_prepare($conn, $sql);
          mysqli_stmt_execute($stmt);

          $c = $c + 1;
      }
  } elseif ($_FILES["file"]["type"] == "application/vnd.ms-excel" || $_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
      // XLS or XLSX file
      require '../PHPExcel-master/PHPExcel.php';
      require '../PHPExcel-master/PHPExcel/IOFactory.php'; // Load PHPExcel IOFactory class

      $objPHPExcel = PHPExcel_IOFactory::load($file);
      $worksheet = $objPHPExcel->getActiveSheet();
      $rows = $worksheet->toArray();

      for ($row = 1; $row < count($rows); $row++) {
          $name = $rows[$row][0];
          $email = $rows[$row][1];
          $optional = $rows[$row][2];

          $sql = "INSERT INTO tch_grp_usr_list(grp_id, name, email, optional, status, created_at, updated_at) VALUES ('".$prodid."','".$name."','".$email."','".$optional."',0,NOW(),NOW())";
          $stmt = mysqli_prepare($conn, $sql);
          mysqli_stmt_execute($stmt);
      }
  }
}
  
  mysqli_close($conn);	
	header('location:group');
	exit;	
}

$sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == '3') {
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<meta name="x-ua-compatible" content="IE=edge,chrome=1" http_equiv="X-UA-Compatible">
<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no" >
<meta name="msapplication-tap-highlight" content="no">
<meta name="theme-color" content="#">
<title>Wonderkids :: Group</title>
<?php require_once('headpart.php'); ?>
</head>
<body onload="selectClass();">
<div class="teacher-wrapper">
<?php require_once('left-navigation.php'); ?>  
    <main>
        <div class="lt-260">    
        <?php require_once('header.php'); ?>
    <section class="section pt-0 pb-3 ml-1 mr-1">
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-4 mb-4">
          <ul class="breadcrumbs">
            <li><a href="group"><span>Home</span></a></li>
            <li><a href="group"><span>Groups</span></a></li>
            <li><span>Create Group</span></li>
          </ul>
        </div>
        <div class="col-md-12 d-flex align-items-center">
            <h2 class="section-title">Create Group</h2>
            <div class="flex-grow-1 text-end">
              <a href="group" class="btn btn-red custom-btn">Back</a>
            </div>
            </div>
      </div>
    </div>
    </section>
    <section class="section pt-0 ml-1 mr-1">
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
      <form action="" method="post" enctype="multipart/form-data">
            <div class="row justify-content-center">
                <div class="col-md-12 mb-3">
                    <div class="block-widget text-center mb-3 p-4">
                    <h3 class="section-title mb-3 mt-1">Select Class</h3>
                    <div class="multi-btn grid-4 text-center">
                    <?php $i=1; $classSql = mysqli_query($conn, "SELECT id,name FROM subject_class WHERE type=2 and status=1");
while($classRow = mysqli_fetch_assoc($classSql)) { 
  $selectsql = mysqli_query($conn, "SELECT DISTINCT b.id,b.name FROM grpwise as a INNER JOIN subject_class as b ON b.id=a.class WHERE a.class='".$classRow['id']."' and a.id=$id"); $selectrow = mysqli_fetch_array($selectsql);  
?>
<?php if (!empty($selectrow['id'])) { ?>
  <div class="check-btn">
  <input class="form-check-input" type="radio" name="class" onClick="selectClass()" value="<?php echo $classRow['id']; ?>" id="class_<?php echo $i; ?>" checked>
  <div class="label-wrapper">
  <label for="class_<?php echo $i; ?>"></label>
  <span class="notchecked"><?php echo $classRow['name']; ?></span>
  </div>
  </div>
  <?php } else { ?>
    <div class="check-btn">
  <input class="form-check-input" type="radio" name="class" onClick="selectClass()" value="<?php echo $classRow['id']; ?>" id="class_<?php echo $i; ?>">
  <div class="label-wrapper">
  <label for="class_<?php echo $i; ?>"></label>
  <span class="notchecked"><?php echo $classRow['name']; ?></span>
  </div>
  </div>
  <?php } ?>  
                    
<?php $i++; } ?>
                    </div>
                    </div>
                    <div id="displaySubject"></div>
                    <div id="displayloop" class="block-widget text-center mb-3 p-4 hide">
                    <div class="row justify-content-center text-left">
                    <div class="col-md-5">
                      <div class="mb-3 text-start">
                      <label class="label mb-1">Group Name</label>
                      <input type="text" name="grpname" class="form-control" placeholder="Group Name" value="<?php if(isset($row['name'])){ echo $row['name']; } ?>" required>
                      </div>
                      <div class="mb-3 text-start">
                      <label class="label mb-1">Group Password</label>
                      <div class="input-group input-append mb-1">  
                                    <input type="password" name="tp_pass" id="tp_pass" class="form-control noSpacesField" autocomplete="off" placeholder="Group Password" value="<?php if(isset($row['pass'])){ echo $row['pass']; } ?>" required>
                                    <div class="input-group-append bg-white">
                                      <button class="btn btn-link eye-off" id="viewButton" type="button"><img src="../assets/images/eye-off.svg" width="22" ></button>
                                    </div>
                                  </div>
                    <span class="note text-left">Note: Minimum of 8 characters. <span class="generate_pass" onclick='document.getElementById("tp_pass").value = Password.generate(16)'>generate password</span></span>
                    
                        </div>
                        <div class="mb-3 text-start">
                        <label class="label mb-1">Upload Student List Excel</label>
							<input type="file" name="file" id="file" accept=".csv,.xlsx,.xls" class="form-control">
              <a href="<?php echo $baseurl; ?>uploads/grp-list.xlsx" class="note link" download><u>Download Sample</u></a>
                        </div>
                        <?php if(!empty($row['id'])) { ?>
                          <button type="submit" name="updategrp" class="btn btn-red custom-btn">Edit GROUP</button>
						<?php } else { ?>
							<button type="submit" name="submitgrp" class="btn btn-red custom-btn">CREATE GROUP</button>
						<?php } ?>
                        
                    <?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
                    </div>
                    
                    </div>
                    </div>
                </div>

</div>
</form>
</div>
</div>
</div>
            
            

</section>
    </div>
</main>
<div>  
<?php require_once('footer.php'); ?>    
<script>
function selectClass() {
        var th = $('input[name="class"]:checked').val();
        <?php if(!empty($row['id'])) { ?> var thID = <?php echo $id ?>; <?php } ?>
//$("#loaderIcon").show();
jQuery.ajax({
url: "../ajax/classAjax",
<?php if(!empty($row['id'])) { ?>
data:{className:th,sbjid:thID},
<?php } else { ?>
  data:{className:th},
<?php } ?>
type: "POST",
success:function(data){
$("#displaySubject").html(data);
if($('input[name="subject"]').is(':checked') == false){
      $('#displayloop').addClass('hide');
    } else {
      $('#displayloop').removeClass('hide');
    }
//$("#loaderIcon").hide();
},
error:function (){}
});
}

function selectSubject() {
        var sbj = $('input[name="subject"]:checked').val();
        var cls = $('input[name="class"]:checked').val();
//$("#loaderIcon").show();
jQuery.ajax({
url: "../ajax/classAjax",
data:{subjectName:sbj,sbjclsName:cls},
type: "POST",
success:function(data){
$("#displayTopic").html(data);
//$("#loaderIcon").hide();
},
error:function (){}
});
}

function displayGName(){
if($('select[name="subject"]').val() == ''){
      $('#displayloop').addClass('hide');
    } else {
      $('#displayloop').removeClass('hide');
    }
}

$(function(){
  $('.noSpacesField').bind('input', function(){
    $(this).val(function(_, v){
     return v.replace(/\s+/g, '');
    });
  });
});

var Password = {
 
 _pattern : /[a-zA-Z0-9_\-\+\.]/,
 
 
 _getRandomByte : function()
 {
   if(window.crypto && window.crypto.getRandomValues) 
   {
     var result = new Uint8Array(1);
     window.crypto.getRandomValues(result);
     return result[0];
   }
   else if(window.msCrypto && window.msCrypto.getRandomValues) 
   {
     var result = new Uint8Array(1);
     window.msCrypto.getRandomValues(result);
     return result[0];
   }
   else
   {
     return Math.floor(Math.random() * 256);
   }
 },
 
 generate : function(length)
 {
   return Array.apply(null, {'length': length})
     .map(function()
     {
       var result;
       while(true) 
       {
         result = String.fromCharCode(this._getRandomByte());
         if(this._pattern.test(result))
         {
           return result;
         }
       }        
     }, this)
     .join('');  
 }    
   
};

$(document).on('click','.eye-off', function () {
  $(this).children('img').attr('src', '../assets/images/eye.svg');
  $(this).addClass('eye-on');
  $("#tp_pass").attr('type','text'); 
});
$(document).on('click','.eye-on', function () {
  $(this).children('img').attr('src', '../assets/images/eye-off.svg');
  $(this).removeClass('eye-on');
  $("#tp_pass").attr('type','password'); 
});
    </script>  
</body>
</html>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>