<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id'])) {
header('Location:'.$baseurl.'');
}

$url = trim($_SERVER["REQUEST_URI"],"/");
$id = substr($url, strpos($url, '=') + 1);

if (isset($_POST['submitgrp'])) {
	$class = $_POST['class'];
	$subject = $_POST['subject'];
  $name = $_POST['grpname'];

  mysqli_query( $conn, "update assign_grp Set class='".$class."',subject='".$subject."',grp_name='".trim($name)."',updated_at=NOW() WHERE id=".$id."" );
  
  mysqli_query($conn, "DELETE FROM assign_grpids WHERE assign_grp='".$id."'");
  //topic
  $stCount = count($_POST["subtopic"]);
  $topic = $_POST["subtopic"];		
  if($stCount > 0)
  {
      for($i=0; $i<$stCount; $i++)
      {
  $topicSQL = mysqli_query($conn, "SELECT parent FROM topics_subtopics WHERE id='".$topic[$i]."'");
  $topicROW = mysqli_fetch_array($topicSQL, MYSQLI_ASSOC);

          if(trim($topicROW['parent'] != ''))
          {
    $grpSQL = mysqli_query($conn, "SELECT topic FROM assign_grpids WHERE topic='".$topicROW['parent']."'  and assign_grp='".$id."'");
    $grpROW = mysqli_fetch_array($grpSQL, MYSQLI_ASSOC);
    
    if($grpROW['topic'] != $topicROW['parent']) {
    mysqli_query($conn, "INSERT INTO assign_grpids(assign_grp,topic) VALUES ('".$id."','".$topicROW['parent']."')");
    }
          }
      }
  }



//Subtopic
  $stCount = count($_POST["subtopic"]);
  $subtopic = $_POST["subtopic"];		
  if($stCount > 0)
  {
 //mysqli_query($conn, "DELETE FROM assign_grpids WHERE id='".$id."'");
      for($i=0; $i<$stCount; $i++)
      {
          if(trim($subtopic[$i] != ''))
          {	

            $topicSQL = mysqli_query($conn, "SELECT parent FROM topics_subtopics WHERE id='".$topic[$i]."'");
            $topicROW = mysqli_fetch_array($topicSQL, MYSQLI_ASSOC);
            
      mysqli_query($conn, "INSERT INTO assign_grpids(assign_grp,topic,subtopic) VALUES ('".$id."','".$topicROW['parent']."','".$subtopic[$i]."')");
          }
      }
  }

//AssignGrp
  $stCount = count($_POST["assigngrp"]);
  $subtopic = $_POST["assigngrp"];		
  if($stCount > 0)
  {
//mysqli_query($conn, "DELETE FROM assign_grpids WHERE id='".$prodid."'");
      for($i=0; $i<$stCount; $i++)
      {
          if(trim($subtopic[$i] != ''))
          {	
      mysqli_query($conn, "INSERT INTO assign_grpids(assign_grp,grpids) VALUES ('".$id."','".$subtopic[$i]."')");
          }
      }
  }
  
  
  mysqli_close($conn);	
	header('location:assign-group');
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
            <li><a href="assign-group"><span>Assign Groups</span></a></li>
            <li><span>Edit Assign Group</span></li>
          </ul>
        </div>
        <div class="col-md-12 d-flex align-items-center">
            <h2 class="section-title">Edit Assign Group</h2>
            <div class="flex-grow-1 text-end">
              <a href="assign-group" class="btn btn-red custom-btn">Back</a>
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
                    <?php $i=1; 
                    $classSql = mysqli_query($conn, "SELECT DISTINCT(a.class),b.name,b.id FROM grpwise as a INNER JOIN subject_class as b ON b.id=a.class INNER JOIN assign_grp as c ON c.class=b.id WHERE c.id=$id and a.status=1 order by a.class asc");
                    while($classRow = mysqli_fetch_assoc($classSql)) {
                    $selectsql = mysqli_query($conn, "SELECT DISTINCT b.id,b.name FROM assign_grp as a INNER JOIN subject_class as b ON b.id=a.class WHERE a.class='".$classRow['id']."' and a.id=$id"); 
                    $selectrow = mysqli_fetch_assoc($selectsql); ?>
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
                    <div id="displayTopic"></div>
                    <div id="displayloop" class="block-widget text-center mb-3 p-4 hide"></div>
                </div>

</div>
</form>
</div>

</div></div>

     

</section>
    </div>
</main>
<div>  
<?php require_once('footer.php'); ?>    
<script>
function selectClass() {
    var th = $('input[name="class"]:checked').val();
    var thID = <?php echo $id ?>;
    //$("#loaderIcon").show();
    jQuery.ajax({
        url: "assignAjax",
        data: {className:th,sbjid:thID},
        type: "POST",
        success: function (data) {
            $("#displaySubject").html(data);
            selectSubject();
            $('#displayloop,#displayTopic').addClass('hide');
            //$("#loaderIcon").hide();
        },
        error: function () {}
    });
}  
    
function selectSubject() {
    var sbj = $('input[name="subject"]:checked').val();
    var cls = $('input[name="class"]:checked').val();
    var thID = <?php echo $id ?>;
    //$("#loaderIcon").show();
    jQuery.ajax({
        url: "assignAjax",
        data: {
            subjectName: sbj,
            sbjclsName: cls,
            sbjid:thID
        },
        type: "POST",
        success: function (data) {
            $('#displayTopic').removeClass('hide');
            $("#displayTopic").html(data);
            $('#displayloop').addClass('hide');
            displayGName();
            //$("#loaderIcon").hide();
        },
        error: function () {}
    });
}    

function displayGName() {
    var cls = $('input[name="class"]:checked').val();
    var thID = <?php echo $id ?>;
    //$("#loaderIcon").show();
    jQuery.ajax({
        url: "assignAjax",
        data: {
            dispclsName: cls,
            sbjid:thID
        },
        type: "POST",
        success: function (data) {
            $("#displayloop").removeClass('hide').html(data);
            //$("#loaderIcon").hide();
        },
        error: function () {}
    });
}

$(function () {
    $('.noSpacesField').bind('input', function () {
        $(this).val(function (_, v) {
            return v.replace(/\s+/g, '');
        });
    });
});

var Password = {

    _pattern: /[a-zA-Z0-9_\-\+\.]/,


    _getRandomByte: function () {
        if (window.crypto && window.crypto.getRandomValues) {
            var result = new Uint8Array(1);
            window.crypto.getRandomValues(result);
            return result[0];
        } else if (window.msCrypto && window.msCrypto.getRandomValues) {
            var result = new Uint8Array(1);
            window.msCrypto.getRandomValues(result);
            return result[0];
        } else {
            return Math.floor(Math.random() * 256);
        }
    },

    generate: function (length) {
        return Array.apply(null, {
            'length': length
        })
            .map(function () {
                var result;
                while (true) {
                    result = String.fromCharCode(this._getRandomByte());
                    if (this._pattern.test(result)) {
                        return result;
                    }
                }
            }, this)
            .join('');
    }

};

$(document).on('click', '.eye-off', function () {
    $(this).children('img').attr('src', '../assets/images/eye.svg');
    $(this).addClass('eye-on');
    $("#tp_pass").attr('type', 'text');
});
$(document).on('click', '.eye-on', function () {
    $(this).children('img').attr('src', '../assets/images/eye-off.svg');
    $(this).removeClass('eye-on');
    $("#tp_pass").attr('type', 'password');
});

//Accordian
$(document).on('click', '.accordion-tabs .accordion-list.plus', function (e) {
    if ($(this).hasClass('plus')) {
        //$('.accordion-tabs .accordion-list').removeClass('plus');
        $(this).removeClass('plus').addClass('minus').removeClass('off').addClass('on');
        //$('.accordion-tabs .accordion-list .content').hide();
        $(this).find('.content').show();
    }
});

$(document).on('click', '.accordion-tabs .accordion-list.minus', function (e) {
    if ($(this).hasClass('minus')) {
        //$('.accordion-tabs .accordion-list').removeClass('minus');
        $(this).removeClass('minus').addClass('plus').removeClass('on').addClass('off');
        //$('.accordion-tabs .accordion-list .content').hide();
        $(this).find('.details').hide();
    }
});
</script>  
</body>
</html>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>