<?php 
include("config/config.php");
include("functions.php");
include("dynamic/ques_session.php");

include("header.php");


if(isset($_GET['forgot-pwd-confirmation'])) {
    $confrmSql = mysqli_query($conn, "SELECT id, confirmation_code FROM users WHERE confirmation_code='". $_GET['forgot-pwd-confirmation'] . "'");
    $confrmRslt = mysqli_fetch_assoc($confrmSql);


    if($_GET['forgot-pwd-confirmation'] == $confrmRslt['confirmation_code']) {
        $new_confirmation_code = md5(generateNumericOTP(6));

        mysqli_query($conn, "UPDATE users SET status=1, updated_at=NOW(), confirmation_code='$new_confirmation_code' WHERE confirmation_code='". $_GET['confirmation'] ."'");

        ?>
            <script>
                $(document).ready(function(){
                    $('#hiddenPwdInput').val(<?php echo $confrmRslt['id'] ?>);
                    $('#passwordForgotModal').modal('show');
                });
            </script>
        <?php

    }
}


//$confirmation_code = mysqli_real_escape_string($conn, $_GET['confirmation']); // Escape user input to prevent SQL injection
if(!empty($_GET['confirmation'])) {
$cnfrm_qury = mysqli_query($conn, "SELECT id,confirmation_code FROM users WHERE confirmation_code='".$_GET['confirmation']."'");
$cnfrm_rslt = mysqli_fetch_array($cnfrm_qury, MYSQLI_ASSOC);

if ($_GET['confirmation'] == $cnfrm_rslt['confirmation_code']) {  // Check if a record with the given confirmation code exists
    // Update user status and generate a new confirmation code

    $new_confirmation_code = md5(generateNumericOTP(6));

    mysqli_query($conn, "UPDATE users SET status=1, updated_at=NOW(), confirmation_code='$new_confirmation_code' WHERE confirmation_code='". $_GET['confirmation'] ."'");

    session_start();
    // Set the session ID after updating the user status
    $_SESSION['id'] = $cnfrm_rslt['id'];
    session_write_close();
    // Display confirmation message
    $sucMsg = "Your account has been confirmed successfully!";

    ?>
        <script>
            $(document).ready(function() {
                showToast({title: "Verfication Success!", content: "Your account has been confirmed successfully!"});
                setTimeout(() => window.location.href = "<?php echo $baseurl; ?>dashboard", 1000);
            });
        </script>
    <?php

    // echo $sucMsg;
    // header ('Location:'.$baseurl.'dashboard');
    // exit;
} else {
    // Display an error message if the confirmation code doesn't match
    // $sucMsg = "Invalid confirmation code. Please try again.";
    ?>
    <script>
        $(document).ready(function() {
            showToast({title: "Verification Failed!", content: "Invalid confirmation code. Please try again."});
        });
    </script>
<?php
}
}



$url = 'http';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $url .= "s";
}
$url .= "://";
if ($_SERVER['SERVER_PORT'] != "80") {
    $url .= $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
} else {
    $url .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
}

$parts = explode('/', $url);
// Remove empty elements
$parts = array_filter($parts);
// Skip first two elements as they are not part of the path
array_shift($parts);
array_shift($parts);
foreach ($parts as $part) {
    $parts[] = $part;
}

$prts = $parts[1];

if (isset($prts)) {

$acptgrpqury = mysqli_query($conn, "SELECT id FROM grpwise WHERE link='".$prts."'");
$acptgrprslt = mysqli_fetch_array($acptgrpqury, MYSQLI_ASSOC);

$acptqury = mysqli_query($conn, "SELECT id FROM accept_grp WHERE grp_id='".$acptgrprslt['id']."' and userid='".$_SESSION['id']."'");
$acptrslt = mysqli_fetch_array($acptqury, MYSQLI_ASSOC);

if(empty($acptrslt['id'])) {

if (isset($_POST['assigngrp'])) {
    $password = $_POST['tp_pass'];
    $subtop_id = $_POST['subTopid'];
    

    $sql = mysqli_query($conn, "SELECT id,class,subject,pass FROM grpwise WHERE link='".$prts."' and pass = '".$password."'");
    $row = mysqli_fetch_assoc($sql);

    if(!empty($row['id'])) {

    $asngrpsql = mysqli_query($conn, "SELECT assign_grp FROM assign_grpids WHERE grpids = '".$row['id']."'");
    $asngrprow = mysqli_fetch_assoc($asngrpsql);

    $sbjSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE id='".$row['subject']."' and type=1 and status=1");
    $sbjrow = mysqli_fetch_array($sbjSQL, MYSQLI_ASSOC);

    $clsSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE id='".$row['class']."' and type=2 and status=1");
    $clsrow = mysqli_fetch_array($clsSQL, MYSQLI_ASSOC);

        $chk_usr_qury = mysqli_query($conn, "SELECT id,email,fullname FROM users WHERE id='".$_SESSION['id']."'");
        $chk_usr_rslt = mysqli_fetch_array($chk_usr_qury, MYSQLI_ASSOC);

        if ($_POST['tchusr'] == '0') {
            mysqli_query( $conn,"insert into tch_grp_usr_list(grp_id,name,email,status,created_at,updated_at) values ('".$row['id']."','".$chk_usr_rslt['fullname']."','".$chk_usr_rslt['email']."',0,NOW(),NOW())" );
        } else {
            mysqli_query( $conn, "update tch_grp_usr_list Set email='".$chk_usr_rslt[ 'email' ]."',status=1, updated_at=NOW() WHERE id=".$_POST['tchusr']."" );
        }

        mysqli_query( $conn, "INSERT INTO accept_grp(userid,grp_id,assign_grp_id,confirmation,updated_at) VALUES ('".$_SESSION['id']."','".$row['id']."','".$asngrprow['assign_grp']."','".md5(uniqid())."',NOW())" );  
        
        mysqli_close( $conn );
        $current_url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header( 'Location:'.$baseurl.$sbjrow['slug'].'/'.$clsrow['slug'].'');
    } else {
        $errMsg = '<div class="alert alert-danger" role="alert">Your password does not match</div>';
    }

    if(!empty($errMsg)) { ?>
        <script type="text/javascript">
        $(document).ready(function(){
            $("#assignModal").modal("show");
        });
        </script>
   <?php } 
}

if(!empty($acptgrprslt['id'])){ 
if(!empty($_SESSION['id'])) { ?>
<script type="text/javascript">$(document).ready(function(){$("#assignModal").modal("show");});</script>
<?php } else { ?>
<script type="text/javascript">$(document).ready(function(){$("#loginModal").modal("show");});</script>
<?php } } } else { header( 'location:'.$baseurl.''); }

} else {}
?>
        <section class="section pt-0 pb-md-4 pb-0 mb-lg-5 mb-0">
            <div class="swiper-container home-swiper hero-wrapper">
                <div class="swiper-wrapper">
                    <?php  $homeSlider_qury = mysqli_query($conn, "SELECT body,hero_img,bg_img,url FROM homepage_banner WHERE status=1 order by id asc");
                    while($homeSlider_rslt = mysqli_fetch_array($homeSlider_qury, MYSQLI_ASSOC)) { 
                        
                        $imgurl = "uploads/slidingBanner/".substr($homeSlider_rslt['hero_img'], 0 , (strrpos($homeSlider_rslt['hero_img'], "."))).".".pathinfo($homeSlider_rslt['hero_img'], PATHINFO_EXTENSION)."";
                        $img_size_array = getimagesize($imgurl);
    ?>
                    <div class="swiper-slide pt-md-0 pt-4 pb-md-0 pb-4" style="background-image:url('uploads/slidingBanner/<?php echo $homeSlider_rslt['bg_img']; ?>'); height:auto; display:flex; align-items:center">
                        <?php if (empty($_SESSION['id'])) { ?>
                        <a href="#login" data-bs-toggle="modal" data-bs-target="#loginModal" class="linkbtn">
                        <?php } else { ?>
                        <a href="<?php echo $homeSlider_rslt['url']; ?>" target="_blank" class="linkbtn">
                        <?php } ?>
                    <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-md-start text-center pt-md-4">
                        <img class="img-fluid img-tb-animated hero-image max-ht-350" src="<?php echo $imgurl; ?>" <?php echo $img_size_array[3]; ?> alt="">
                    </div>
                    <div class="col-md-6 text-md-start text-center mt-md-0 mt-4">
                        <h3 class="hero-title mb-lg-4 mb-3 md">
                            <?php echo $homeSlider_rslt['body']; ?>
                        </h3>
                    </div>
                </div>
                        </div>
                </a>
            </div>
<?php } ?>

</div>

<div class="swiper-prev"><img src="assets/images/left-chevron.svg" height="40" alt=""></div>
<div class="swiper-next"><img src="assets/images/right-chevron.svg" height="40" alt=""></div>
<div class="swiper-pagination"></div>
                    </div>   
                    
                    </div>
            </div>
        </section>
        <section class="section pt-lg-5 pb-lg-5 pt-4">
            <div class="container pb-lg-5 pb-4">
                <div class="text-center mb-lg-5 mb-4">
                    <h2 class="section-title-lg">How it works</h2>
                    <p class="lead pl-md-5 pl-0 pr-md-aus">Your One Stop Solution for Building 21<sup>st</sup> Century Maths Skills for kids. Here, kids Learn while Having Fun. Useful tool with Teachers/Parents to make kids practice and get expertise</p>
                </div>
                <div class="row position-relative w-100">
                    <div class="dotted-line">
                        <img class="img-fluid" src="<?php echo $baseurl; ?>assets/images/dotted-line.svg" width="1014" height="202">
                    </div>
                    <div class="col-md-4 mt-4">
                        <div class="ic-wt-head pe-lg-5 ps-lg-5 pe-md-3 ps-md-3 text-center">
                            <div class="icon mb-lg-4 mb-3"><?php if (empty($_SESSION['id'])) { ?>
                        <a href="#register" data-bs-toggle="modal" data-bs-target="#registerModal" class="linkbtn">
                            <?php } ?>
                                <img class="img-fluid" src="<?php echo $baseurl; ?>assets/images/signup.svg" width="170" height="170" alt="">
                                <?php if (empty($_SESSION['id'])) { ?>
                                </a>
                                <?php } ?>
                            </div>
                            <h3 class="heading"><?php if (empty($_SESSION['id'])) { ?>
                        <a href="#register" data-bs-toggle="modal" data-bs-target="#registerModal" class="linkbtn">
                            <?php } ?>Signup<?php if (empty($_SESSION['id'])) { echo "</a>"; } else {} ?></h3>
                            <p>Register for free, have free access to numerous questions, worksheets and leaderboard</p>
                        </div>
                    </div>
                    <div class="col-md-4 mt-4">
                        <div class="ic-wt-head pe-lg-5 ps-lg-5 pe-md-3 ps-md-3 text-center">
                            <div class="icon mb-lg-4 mb-3">
                                <?php if (empty($_SESSION['id'])) { ?>
                        <a href="#register" data-bs-toggle="modal" data-bs-target="#registerModal" class="linkbtn">
                            <?php } else { ?>
                                <a href="dashboard" class="linkbtn" target="_blank">
                                    <?php } ?>
                                <img class="img-fluid" src="<?php echo $baseurl; ?>assets/images/practice.svg" width="170" height="170" alt="">
                                </a>
                            </div>
                            <h3 class="heading"><?php if (empty($_SESSION['id'])) { ?>
                        <a href="#register" data-bs-toggle="modal" data-bs-target="#registerModal" class="linkbtn">
                            <?php } else { ?><a href="dashboard" class="linkbtn" target="_blank"><?php } ?>Practice</a></h3>
                            <p>Choose from different set of skills and be a Maths expert</p>
                        </div>
                    </div>
                    <div class="col-md-4 mt-4">
                        <div class="ic-wt-head pe-lg-5 ps-lg-5 pe-md-3 ps-md-3 text-center">
                            <div class="icon mb-lg-4 mb-3">
                                <?php if (empty($_SESSION['id'])) { ?>
                        <a href="#register" data-bs-toggle="modal" data-bs-target="#registerModal" class="linkbtn">
                            <?php } else { ?>
                                <a href="leaderboard" class="linkbtn" target="_blank">
                                    <?php } ?>
                                <img class="img-fluid" src="<?php echo $baseurl; ?>assets/images/leaderboard.svg" width="170" height="170" alt="">
                                </a>
                            </div>
                            <h3 class="heading">
                                <?php if (empty($_SESSION['id'])) { ?>
                        <a href="#register" data-bs-toggle="modal" data-bs-target="#registerModal" class="linkbtn">
                            <?php } else { ?><a href="leaderboard" class="linkbtn" target="_blank"><?php } ?>Leaderboard</a></h3>
                            <p>Challenge yourself and your friends, compete and aim for placing yourself on the top</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section bg-lightpink pt-lg-5 pb-lg-5 pt-4 pb-4">
            <div class="container pt-md-4 pb-md-4 pb-3">
                <div class="text-center mb-md-4">
                    <h2 class="section-title-lg">Choose your level</h2>
                    <p class="lead mb-0">Start your learning and practice with your class and click here to your class</p>
                </div>
                <div class="row justify-content-center">
                <?php 
                
                $cls_array = array('nursery','prep');
                $cls_list = "'" . implode("', '", $cls_array) . "'";
                $sclwiseSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE type=2 and status=1 and slug IN ($cls_list) order by id asc");
                while($sclwiseRow = mysqli_fetch_assoc($sclwiseSQL)) { ?>
                    <div class="col-lg-4 col-md-6 col-6 mt-4">
                    <?php 
                    $topicsql = mysqli_query($conn, "SELECT DISTINCT subject_id FROM topics_subtopics WHERE class_id=".$sclwiseRow['id']." and parent=0 and status=1");
                    while($topicrow = mysqli_fetch_assoc($topicsql)) {

                    $subjectsql = mysqli_query($conn, "SELECT name,slug FROM subject_class WHERE id=".$topicrow['subject_id']." and status=1");
                    $subjectrow = mysqli_fetch_assoc($subjectsql);    

                    $topiCntsql = mysqli_query($conn, "SELECT COUNT(subtopic) as count FROM topics_subtopics WHERE class_id=".$sclwiseRow['id']." and subject_id=".$topicrow['subject_id']." and parent!=0 and status=1");
                    $topiCntrow = mysqli_fetch_assoc($topiCntsql); ?>

                        <a href="<?php echo $subjectrow['slug'].'/'.$sclwiseRow['slug']; ?>" class="btn-animated level-list">
                            <div class="lt">
                                <h3 class="title"><?php echo $sclwiseRow['name']; ?></h3></div>
                            <div class="rt">
                                <span class="lg"><?php echo $topiCntrow['count']; ?></span>
                                <span class="md">Skills</span>
                            </div>
                        </a>
                    </div>
                    <?php } } ?>
                </div>
                <div class="row justify-content-center">
                <?php 
                $cls_array = array('nursery','prep');
                $cls_list = "'" . implode("', '", $cls_array) . "'";
                $sclwiseSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE type=2 and status=1 and slug NOT IN ($cls_list) order by id asc");
                while($sclwiseRow = mysqli_fetch_assoc($sclwiseSQL)) { ?>
                    <div class="col-lg-4 col-md-6 col-6 mt-4">
                    <?php 
                    $topicsql = mysqli_query($conn, "SELECT DISTINCT subject_id FROM topics_subtopics WHERE class_id=".$sclwiseRow['id']." and parent=0 and status=1");
                    while($topicrow = mysqli_fetch_assoc($topicsql)) {

                    $subjectsql = mysqli_query($conn, "SELECT name,slug FROM subject_class WHERE id=".$topicrow['subject_id']." and status=1");
                    $subjectrow = mysqli_fetch_assoc($subjectsql);    

                    $topiCntsql = mysqli_query($conn, "SELECT COUNT(subtopic) as count FROM topics_subtopics WHERE class_id=".$sclwiseRow['id']." and subject_id=".$topicrow['subject_id']." and parent!=0 and status=1");
                    $topiCntrow = mysqli_fetch_assoc($topiCntsql); ?>
                         
                        <a href="<?php echo $subjectrow['slug'].'/'.$sclwiseRow['slug']; ?>" class="btn-animated level-list">
                            <div class="lt">
                                <h3 class="title"><?php echo $sclwiseRow['name']; ?></h3></div>
                            <div class="rt">
                                <span class="lg"><?php echo $topiCntrow['count']; ?></span>
                                <span class="md">Skills</span>
                            </div>
                        </a>
                    </div>
                    <?php } } ?>
                </div>
            </div>
        </section>
        <section class="section pt-4">
            <div class="container pt-3">
                <div class="row align-items-center">
                    <div class="col-md-5 text-center mb-md-3 mb-4">
                        <img class="img-fluid max-ht-350" src="<?php echo $baseurl; ?>assets/images/maths.png" width="451" height="397" alt="">
                        <?php if (empty($_SESSION['id'])) { ?>
                        <a href="#register" data-bs-toggle="modal" data-bs-target="#registerModal" class="studentRegister btn btn-animated btn-lg ps-5 pe-5 mt-4">Sign up for Free</a>
                        <?php } ?>
                    </div>
                    <div class="col-md-7 ps-md-5">
                        <div class="wj-head-txt">
                            <h3 class="title mb-md-3 mb-1"><?php if (empty($_SESSION['id'])) { ?>
                        <a href="#register" data-bs-toggle="modal" data-bs-target="#registerModal" class="linkbtn">
                        <?php } else { ?>
                        <a href="dashboard" class="linkbtn"><?php } ?>Exciting Quizzes</a></h3>
                            <p>Daily/weekly Quizzes to test your skills and knowledge in various topics</p>
                        </div>
                        <div class="wj-head-txt">
                            <h3 class="title mb-md-3 mb-1"><?php if (empty($_SESSION['id'])) { ?>
                        <a href="#register" data-bs-toggle="modal" data-bs-target="#registerModal" class="linkbtn">
                        <?php } else { ?>
                        <a href="dashboard" class="linkbtn"><?php } ?>Fastest 10</a></h3>
                            <p>Solve 10 questions from each Maths skill in fastest possible manner. Break records, Set new records and Challenge your friends. </p>
                        </div>
                        <div class="wj-head-txt">
                            <h3 class="title mb-md-3 mb-1"><?php if (empty($_SESSION['id'])) { ?>
                        <a href="#register" data-bs-toggle="modal" data-bs-target="#registerModal" class="linkbtn">
                        <?php } else { ?>
                        <a href="dashboard" class="linkbtn"><?php } ?>Offline Practice</a></h3>
                            <p>Freedom to download multiple worksheets and practice offline for all Maths skills </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php $check_hm_faqs_qury = mysqli_query($conn, "SELECT id FROM homepage_faqs WHERE status=1 order by id asc");
        $check_hm_faqs_rslt = mysqli_fetch_assoc($check_hm_faqs_qury); if(!empty($check_hm_faqs_rslt['id'])) {  ?>
        <section class="section pt-lg-5 pb-lg-5 pt-4 pb-4 bg-lightblue">
            <div class="container pt-3 pb-3">
                <div class="text-center mb-lg-5 mb-4">
                    <h2 class="section-title-lg">Frequently asked questions</h2>
                    <p class="lead">It is a long established fact that a reader will be distracted by the readable</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="accordion-tabs">
                            <?php $hm_faqs_qury = mysqli_query($conn, "SELECT id,ques, ans FROM homepage_faqs WHERE status=1 order by id asc");
                            while($hm_faqs_rslt = mysqli_fetch_assoc($hm_faqs_qury)) { ?>
                            <div class="accordion-list plus off">
                                <a href="javascript:void(0);" class="accordion-heading">
                                    <div class="d-flex align-items-center">
                                        <h3 class="heading flex-grow-1"><?php echo $hm_faqs_rslt['ques']; ?></h3>
                                        <span class="symbol"></span>
                                    </div>
                                </a>
                                <div class="content">
                                <?php echo $hm_faqs_rslt['ans']; ?>
                                </div>

                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php }
 ?>
        <section class="section pt-lg-5 pt-4 pb-lg-5 pb-4">
            <div class="container pt-4 pb-4">
                <div class="row flex-row-reverse">
                    <div class="col-md-5 mb-md-0 mb-4">
                        <img class="img-fluid max-ht-350" src="<?php echo $baseurl; ?>assets/images/try-wonderkids-for-free.png" width="350" height="450" alt="">
                    </div>
                    <div class="col-md-7">
                        <h2 class="section-title-lg mb-lg-5 mb-4">Try Wonderkids for free</h2>
                        <ul class="icon-list mb-md-4 mb-2">
                            <li><span class="ico me-2"><img src="<?php echo $baseurl; ?>assets/images/check.svg" width="20" height="20" alt=""></span><span>Practice unlimited Maths (Online and Offline) </span></li>
                            <li><span class="ico me-2"><img src="<?php echo $baseurl; ?>assets/images/check.svg" width="20" height="20" alt=""></span><span>Challenge your friends, break records and set new records</span></li>
                            <li><span class="ico me-2"><img src="<?php echo $baseurl; ?>assets/images/check.svg" width="20" height="20" alt=""></span><span>Daily/Weekly Quizzes </span></li>
                            <li><span class="ico me-2"><img src="<?php echo $baseurl; ?>assets/images/check.svg" width="20" height="20" alt=""></span><span>Compete across schools</span></li>
                            <li><span class="ico me-2"><img src="<?php echo $baseurl; ?>assets/images/check.svg" width="20" height="20" alt=""></span><span>Compete with your friends/classmates</span></li>
                        </ul>
                        <?php if (empty($_SESSION['id'])) { ?>
                        <a href="#register" data-bs-toggle="modal" data-bs-target="#registerModal" class="studentRegister btn btn-dark btn-animated btn-lg ps-5 pe-5 mt-4">Sign up for Free</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
<?php include("footer.php"); mysqli_close($conn);?>
    