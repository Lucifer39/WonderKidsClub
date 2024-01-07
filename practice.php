<?php 
include("config/config.php");
include("functions.php");



function my_sort($a, $b) {
    if ($a == $b) return 0;
    return ($a < $b) ? -1 : 1;
}

// if(empty($_SESSION['id']))
// header('Location:'.$baseurl.'');

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

// array_shift($parts);
foreach ($parts as $part) {
    $parts[] = $part;
}

$prt_1 = $parts[1]; 
$prt_2 = $parts[2]; 
$prt_3 = $parts[3]; 
$prt_4 = $parts[4];

/*-------live server------------*/ 
// $prt_1 = $parts[0]; 
// $prt_2 = $parts[1]; 
// $prt_3 = $parts[2]; 
// $prt_4 = $parts[3];

$prev_flag = false;

$usrSQL = mysqli_query($conn, "SELECT id,school,class FROM users WHERE id='".$_SESSION['id']."' and isAdmin=2 and status=1");
$usrrow = mysqli_fetch_array($usrSQL, MYSQLI_ASSOC);

$sbjSQL = mysqli_query($conn, "SELECT id,name FROM subject_class WHERE slug='".slugify($prt_1)."' and type=1 and status=1");
$sbjrow = mysqli_fetch_array($sbjSQL, MYSQLI_ASSOC);

$clsSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE slug='".slugify($prt_2)."' and type=2 and status=1");
$clsrow = mysqli_fetch_array($clsSQL, MYSQLI_ASSOC);

$sbtpcSQL = mysqli_query($conn, "SELECT id,parent,subtopic,class_id FROM topics_subtopics WHERE class_id='".$clsrow['id']."' and subject_id='".$sbjrow['id']."' and slug='".slugify($prt_4)."' and parent!=0 and status=1");
$sbtpcrow = mysqli_fetch_array($sbtpcSQL, MYSQLI_ASSOC);

$tpcSQL = mysqli_query($conn, "SELECT id,topic FROM topics_subtopics WHERE class_id='".$clsrow['id']."' and subject_id='".$sbjrow['id']."' and id='".$sbtpcrow['parent']."' and slug='".slugify($prt_3)."' and status=1");
$tpcrow = mysqli_fetch_array($tpcSQL, MYSQLI_ASSOC);

$eligibleSbtp = true;

if($sbtpcrow['class_id'] !== $usrrow['class']) { $eligibleSbtp = false; }

if(!empty($_SESSION['id'])) {
$levlSql = mysqli_query($conn, "SELECT up.userid, COUNT(up.subtopic_id) AS level
                                FROM user_proficiency up
                                JOIN topics_subtopics ts ON up.subtopic_id = ts.id
                                JOIN users u ON up.userid = u.id
                                WHERE up.proficiency_level = 3
                                AND ts.class_id = '".$usrrow['class']."'
                                AND u.class = '".$usrrow['class']."'
                                GROUP BY up.userid
                                HAVING COUNT(up.subtopic_id) = (
                                    SELECT COUNT(up1.subtopic_id)
                                    FROM user_proficiency up1
                                    JOIN topics_subtopics ts1 ON up1.subtopic_id = ts1.id
                                    WHERE up1.userid = '".$_SESSION['id']."'
                                    AND up1.proficiency_level = 3
                                    AND ts1.class_id = '".$usrrow['class']."'
                                )");

if(mysqli_num_rows($levlSql) == 0) {
    $levlSql = mysqli_query($conn, "SELECT u.id AS userid, '0' AS level 
    FROM users u
    WHERE (u.id NOT IN ( 
        SELECT up2.userid FROM user_proficiency up2
    ) OR u.id IN ( 
       SELECT up.userid 
        FROM user_proficiency up
        JOIN topics_subtopics tp ON up.subtopic_id = tp.id
        WHERE up.userid NOT IN ( 
            SELECT up1.userid 
            FROM user_proficiency up1
            JOIN topics_subtopics tp1 ON tp1.id = up1.subtopic_id
            WHERE up1.proficiency_level = 3
            AND tp1.class_id = '".$usrrow['class']."'
        ) 
        AND tp.class_id = '".$usrrow['class']."' ) )
    AND u.class =  '".$usrrow['class']."'");
}
                                
$elgibleArr = array();
$lvl = 0;
while($lvlRow = mysqli_fetch_assoc($levlSql)) {
    $elgibleArr[] = $lvlRow['userid'];
    $lvl = $lvlRow['level'];
}

$eligibleIds = implode(", ", $elgibleArr);

$chkLevelSql = mysqli_query($conn, "SELECT COUNT(*) AS level FROM user_proficiency up
                                    JOIN topics_subtopics ts ON up.subtopic_id = ts.id
                                    WHERE up.userid = '".$_SESSION['id']."'
                                    AND ts.class_id = '".$usrrow['class']."'
                                    AND up.proficiency_level = 3");

$chkLevelRow = mysqli_fetch_assoc($chkLevelSql);
$chkLevelRow['level']++;

$cntSbtpSql = mysqli_query($conn, "SELECT COUNT(*) AS total_levels FROM topics_subtopics
                                    WHERE class_id = '".$usrrow['class']."'
                                    AND status = 1
                                    AND parent != 0");
$cntSbtpRow = mysqli_fetch_assoc($cntSbtpSql);
$cntSbtpRow['total_levels']++;

$practicenotifsql = mysqli_query($conn, "SELECT enable FROM toggle_section_config WHERE section = 'practice_notifications'");
$practicenotifchk = mysqli_fetch_assoc($practicenotifsql);


    $ptsSQL = mysqli_query($conn, "SELECT correct_pts, wrong_pts FROM game_points LIMIT 1");
    $ptsRow = mysqli_fetch_assoc($ptsSQL);

if($sbtpcrow['class_id'] == $usrrow['class']) {

    $_SESSION['correct-pts'] = $ptsRow['correct_pts'];
    $_SESSION['wrong-pts'] = $ptsRow['wrong_pts'];

} else {

    $_SESSION['correct-pts'] = 0;
    $_SESSION['wrong-pts'] = 0;
    
}

$_SESSION['leaderboard_time'] = time();

}


if (isset($_POST['next'])) {
    include("dynamic/ques_session.php");
    unset($_SESSION['quesID']);
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

/*if (isset($_POST['next'])) {
    include("dynamic/ques_session.php");
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

if (isset($_POST['submit'])) {
    $option = $_POST['opt'];
    $quesID = $_POST['ques'];

    
if(!empty($quesID)) {
    $chkSQL = mysqli_query($conn, "SELECT id,correct_ans FROM count_quest WHERE id='".$quesID."'");
    $chkrow = mysqli_fetch_array($chkSQL, MYSQLI_ASSOC);

    if ($chkrow['correct_ans'] == $option) {
        $correct = $option;
        $wrong = "NULL";
    } else {
        $correct = "NULL";
        $wrong = $option;
    }

    $currentDateTime = date('Y-m-d H:i:s');
    
    mysqli_query( $conn, "INSERT INTO leaderboard(userid,class,subject,topic,subtopic,school,user_class,question,correct,wrong,created_at) VALUES ('".$_SESSION['id']."','".$clsrow['id']."','".$sbjrow['id']."','".$tpcrow['id']."','".$sbtpcrow['id']."','".$usrrow['school']."','".$usrrow['class']."','".$quesID."','".$correct."','".$wrong."','".$currentDateTime ."')");
   
    
  //  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $leaderSQL = mysqli_query($conn, "SELECT question FROM leaderboard WHERE userid='".$_SESSION['id']."' and id='".$conn->insert_id."' order by id desc");
        $leaderrow = mysqli_fetch_array($leaderSQL, MYSQLI_ASSOC);

        $_SESSION['quesID'] = $leaderrow['question'];
        
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
      // header('Location: ' . $_SERVER['REQUEST_URI']);
       // exit;

  //  }
    
    //mysqli_close($conn);
  }
}*/


$chstpcSQL = mysqli_query($conn, "SELECT user_id FROM check_subtopic WHERE user_id='".$_SESSION['id']."' and subtopic_id='".$sbtpcrow['id']."' and practice_id ='".$_SESSION['assign_grp']."'");
$chstpcrow = mysqli_fetch_array($chstpcSQL, MYSQLI_ASSOC);

if(empty($chstpcrow['user_id']) && !empty($_SESSION['id'])) {
mysqli_query( $conn, "INSERT INTO check_subtopic(user_id,subtopic_id,practice_id,created_at) VALUES ('".$_SESSION['id']."','".$sbtpcrow['id']."','".$_SESSION['assign_grp']."',NOW())");
}

$chkQuesQuotaSQL = mysqli_query($conn, "SELECT value FROM config WHERE id = 1");
$chkQuesQuotaRow = mysqli_fetch_assoc($chkQuesQuotaSQL);

if($_SESSION['num_ques_'. $sbtpcrow['id']] >= intval($chkQuesQuotaRow['value'])) {
    $limitMsg = '<div class="start-widget p-md-5 p-3"><img src="'.$baseurl.'assets/images/oops.png" width="200" height="200"><h2 class="heading mb-0">Your limit has exceeded. <br> Login to browse more questions.</h2><a href="'.$baseurl.'" class="btn btn-animated btn-lg w-md-50 w-100 mt-md-4 mt-3"> Go Home</a></div>';
}

include("header.php");

if(!isset($_SESSION['correct-streak'])) {
    $_SESSION["correct-streak"] = 0;
}


if (isset($_POST['reportBtn'])) {
    $quesID = $_POST['subTopid'];
    $report = $_POST['report'];

    mysqli_query( $conn, "INSERT INTO report_question(user_id,ques_id,report,status,created_at) VALUES ('".$_SESSION['id']."','".$quesID."','".$report."',1,NOW())");

    $errMsg = '<div class="alert alert-success" role="alert">Thanks for submitting.</div>';

    if(!empty($errMsg)) { ?>
        <script type="text/javascript">
        $(document).ready(function(){$("#reportModal").modal("show"); $("#reportModal").find(".reportForm").hide();});
        </script>
   <?php 
   } 
}

if (isset($_POST['requestBtn'])) {
    $quesID = $_POST['subTopid'];
    $request = $_POST['request'];

    mysqli_query( $conn, "INSERT INTO request_solution(user_id,ques_id,request,status,created_at) VALUES ('".$_SESSION['id']."','".$quesID."','".$request."',1,NOW())");

    $errMsg = '<div class="alert alert-success" role="alert">We will get back to you.</div>';

    if(!empty($errMsg)) { ?>
        <script type="text/javascript">
        $(document).ready(function(){$("#requestModal").modal("show"); $("#requestModal").find(".requestForm").hide();});
        </script>
   <?php 
   } 
}

?>
<script>
function hasTextContent(element) {
    return element.innerText.trim() !== '';
}
   /* document.addEventListener("DOMContentLoaded", function() {
  const textContainers = document.querySelectorAll('.resizeTxt');

  textContainers.forEach(textContainer => {
    const originalText = textContainer.textContent;

    const resizeTextToFit = () => {
      const maxWidth = textContainer.offsetWidth;
      const maxHeight = textContainer.offsetHeight;

      let fontSize = 18; // Initial font size
      textContainer.style.fontSize = fontSize + 'px';
if (hasTextContent(textContainer)) {
      while (textContainer.scrollHeight > maxHeight || textContainer.scrollWidth > maxWidth) {
        fontSize--;
        textContainer.style.fontSize = fontSize + 'px';
      }
    };
   }

    resizeTextToFit(); 

    // Add a window resize event listener to update the text size on window resize
    window.addEventListener('resize', resizeTextToFit);
  });
});



function resizeTextInContainers() {
  const textContainers = document.querySelectorAll('.txtresize');
  textContainers.forEach(textContainer => {
    const originalText = textContainer.textContent;
    
    const resizeTextToFit = () => {
      const maxWidth = textContainer.offsetWidth;
      const maxHeight = textContainer.offsetHeight;
      
      let fontSize = 26; // Initial font size
      textContainer.style.fontSize = fontSize + 'px';
      
      while (textContainer.scrollHeight > maxHeight || textContainer.scrollWidth > maxWidth) {
        fontSize--;
        textContainer.style.fontSize = fontSize + 'px';
      }
    };
    
    resizeTextToFit();
    
    // Add a window resize event listener to update the text size on window resize
    window.addEventListener('resize', resizeTextToFit);
  });
}


// Initial text resizing
document.addEventListener("DOMContentLoaded", resizeTextInContainers);
*/
//Resize Heading
const resizeTextToFit = (textContainer) => {
    const maxWidth = textContainer.offsetWidth;
    const maxHeight = textContainer.offsetHeight;

    let fontSize = 26; // Initial font size
    let minFontSize = 20;

    if (window.innerWidth > 992) {
        fontSize = 26;
        minFontSize = 25;
    } else if (window.innerWidth > 768) {
        fontSize = 22;
        minFontSize = 20;
    } else if (window.innerWidth <= 574) {
        fontSize = 20; // Font size for screens less than or equal to 574px
        minFontSize = 18;
    }

    // textContainer.style.fontSize = fontSize + 'px';

    while (fontSize >= minFontSize && (textContainer.scrollHeight > maxHeight || textContainer.scrollWidth > maxWidth)) {
        fontSize--;
    }

    textContainer.style.fontSize = fontSize + 'px';

};



document.addEventListener('DOMContentLoaded', function() {

    const textContainers = document.querySelectorAll('.page-title-wrapper .page-title');


    textContainers.forEach(textContainer => {
        const originalText = textContainer.textContent;
        textContainer.style.visibility = 'hidden'; // Hide the text initially
        resizeTextToFit(textContainer);
        textContainer.style.visibility = 'visible'; // Make the text visible after resizing
    });
    
    // Add a window resize event listener to update the text size on window resize
    window.addEventListener('resize', function() {
        textContainers.forEach(textContainer => {
            resizeTextToFit(textContainer);
        });
    });
});


        //Change uploads 
        $(document).ready(function() {
            // Function to replace file paths
            function replaceFilePaths() {
                // Select all elements with the 'src' attribute containing '../uploads'
                $('*[src*="../uploads"]').each(function() {
                var originalSrc = $(this).attr('src');
                var newSrc = originalSrc.replace('../uploads', '<?php echo $baseurl; ?>uploads');
                $(this).attr('src', newSrc);
                });
            }

            // Call the function to replace file paths
            replaceFilePaths();
        });
  </script>
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 pe-lg-5 col-md-12">
                            <div class="d-flex" id="practice-breadcrumbs">
                               <div class="breadcrumbs st-breadcrumbs mb-md-4 mb-3 flex-grow-1">
                                <span><a href="<?php echo $baseurl.'dashboard'; ?>">Home</a></span>
                                <span><?php echo $sbjrow['name']; ?></span>
                                <span><a href="../../<?php echo $clsrow['slug']; ?>"><?php echo $clsrow['name']; ?></a></span>
                                <span><?php echo $tpcrow['topic']; ?></span>
                                <span><?php echo $sbtpcrow['subtopic']; ?></span>
                            </div>
                            <div class="text-end">
                                <a href="../../<?php echo $clsrow['slug']; ?>" class="pink-link"><img src="<?php echo $baseurl; ?>assets/images/back.svg" width="20" height="20" alt="back">Back to topics</a>
                            </div>
                            </div>
                            
                         <?php  //} else {  
                            if($limitMsg == '') {
                                $ordSQL = mysqli_query($conn, "SELECT question FROM leaderboard WHERE userid='".$_SESSION['id']."' and class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$sbtpcrow['id']."' order by id desc");
                                $ordrow = mysqli_fetch_array($ordSQL, MYSQLI_ASSOC);
                                
                                if(!empty($_SESSION['id'])) {
                                    $quesTotSQL = mysqli_query($conn, "SELECT id FROM count_quest WHERE class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and status=1 and subtopic='".$sbtpcrow['id']."' and (type2 = 'p1' or type2 IS NULL) and id > '".$ordrow['question']."'");
                                } else {
                                    $quesTotSQL = mysqli_query($conn, "SELECT id FROM count_quest WHERE class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and status=1 and subtopic='".$sbtpcrow['id']."' and (type2 = 'p1' or type2 IS NULL) ORDER BY RAND() LIMIT 1");
                                }
                                while($quesTotrow = mysqli_fetch_array($quesTotSQL, MYSQLI_ASSOC)) {
                                    $quesow[] = $quesTotrow['id'];
                                }

                                //$cntordSQL = mysqli_query($conn, "SELECT COUNT(question) as ques_count FROM leaderboard WHERE userid='".$_SESSION['id']."' and class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."'");
                                //$cntordrow = mysqli_fetch_array($cntordSQL, MYSQLI_ASSOC);

                                if (!empty($ordrow['question'])) {
                                $queSQL = mysqli_query($conn, "SELECT id,question,opt_a,opt_b,opt_c,opt_d,type,type1,correct_ans,shape_info,subtopic,type2 FROM count_quest WHERE class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$sbtpcrow['id']."' and id =".$quesow[0]." and status=1");
                            } else {
                                $queSQL = mysqli_query($conn, "SELECT id,question,opt_a,opt_b,opt_c,opt_d,type,type1,correct_ans,shape_info,subtopic,type2 FROM count_quest WHERE class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$sbtpcrow['id']."' and (type2 = 'p1' or type2 IS NULL) and id =".$quesow[0]."  and status=1 order by id asc");
                            }

                            $querow = mysqli_fetch_array($queSQL, MYSQLI_ASSOC);

                            $super_id = $sbtpcrow['id'];
                            if($super_id == '263') {
                                $sbtpcrow['id'] = $querow['shape_info'];
                            } 

                            // var_dump($_SESSION["prev_ques"]);

                            if(!empty($_SESSION["prev_ques"])
                                 && $_SESSION["prev_ques"]["subject"] == $sbjrow['id'] 
                                 && $_SESSION["prev_ques"]["topic"] == $tpcrow['id'] 
                                 && $_SESSION["prev_ques"]["subtopic"] == $super_id
                                 && isset($_SESSION["prev_ques"]["question"])
                                 && $_SESSION["prev_ques"]["question"] !== $querow["id"]){
                                    $prev_flag = true;
                                    $queSQL2 = mysqli_query($conn, "SELECT cq.id, cq.question, cq.opt_a, cq.opt_b, cq.opt_c, cq.opt_d, cq.type, cq.type1, cq.correct_ans, cq.shape_info, cq.subtopic, cq.type2 
                                                                    FROM leaderboard l 
                                                                    JOIN count_quest cq
                                                                    ON l.question = cq.id
                                                                    WHERE l.userid = '".$_SESSION['id']."'
                                                                    AND l.class = '".$clsrow['id']."'
                                                                    AND l.subject = '".$sbjrow['id']."'
                                                                    AND l.topic = '".$tpcrow['id']."'
                                                                    AND l.subtopic = '".$super_id."'
                                                                    AND l.question = '". $_SESSION["prev_ques"]["question"] ."'
                                                                    AND cq.status = 1");

                                    $querow = mysqli_fetch_array($queSQL2, MYSQLI_ASSOC);
                                 }

                                $chkShortlistSQL = mysqli_query($conn, "SELECT * FROM shortlist_questions WHERE question_id = '". $querow["id"] ."' AND user_id = '". $_SESSION['id'] ."'");
                                $chkShortlistrow = mysqli_fetch_assoc($chkShortlistSQL);

                                // var_dump($querow["id"]);
                            
                            $resulSQL = mysqli_query($conn, "SELECT correct,wrong FROM leaderboard WHERE userid='".$_SESSION['id']."' and question='".$querow['id']."'");
                            $resulrow = mysqli_fetch_array($resulSQL, MYSQLI_ASSOC);

                            if($querow['type2'] == 'p1' || $querow['type2'] == 'q1') {
                                $resizeTxt = 'resizeTxt';
                            } else if($querow['subtopic'] =='51') {
                                $resizeTxt = 'txtresize';    
                            } else if($qupuerow['subtopic'] == '216') {
                                $resizeTxt= '';
                                
                            }else {
                                $resizeTxt = 'txtresize';
                            }

                            if (!empty($querow['question'])) {

                               
                                include("components/dyn_cond.php");
                                
                            
                            ?>
                            <form id="myForm" action="" method="post" enctype="multipart/form-data" class="mob-bottom-padding">
                            <input type="hidden" name="ques" value="<?php echo $querow['id']; ?>">
                            <?php if($querow['type2'] == 'p1' || $querow['type2'] == 'q1') { ?>
                                <h1 class="page-title mb-2 text-center"><?php echo $querow['question']; ?></h1> 
                            <?php } else { ?>
                            <div class="page-title-wrapper" style="visibility: hidden;">
                            <h1 class="page-title mb-2 text-center"><?php echo $querow['question']; ?></h1> 
                            </div>
                            <?php } ?>
                            <?php include("components/dyn_ques.php"); ?>
                            <div id="result">
                            <ul class="options multi-btn <?php echo $quesCls.$stlCls; ?>">
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="opt" value="<?php if($querow['type2'] == 'p1') { echo "1"; } else { echo $querow['opt_a']; } ?>" onchange="checkSelection()" id="opt_1" >
                                        <div class="label-wrapper <?php echo $optCls.$stloptCls;if($prev_flag){echo $optA; if($querow['type2'] == 'p1' && $querow['correct_ans'] == 1) { echo 'right-ans'; } elseif($querow['type2'] == 'p1' && $resulrow['wrong'] == 1) { echo 'wrong-ans'; }} ?> ?>">
                                            <label for="opt_1"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_opta.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="opt" value="<?php if($querow['type2'] == 'p1') { echo "2"; } else { echo $querow['opt_b']; } ?>" onchange="checkSelection()"  id="opt_2" >
                                        <div class="label-wrapper <?php echo $optCls.$stloptCls;if($prev_flag){echo $optB;if($querow['type2'] == 'p1' && $querow['correct_ans'] == 2) { echo 'right-ans'; } elseif($querow['type2'] == 'p1' && $resulrow['wrong'] == 2) { echo 'wrong-ans'; }} ?> ?>">
                                            <label for="opt_2"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_optb.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="opt" value="<?php if($querow['type2'] == 'p1') { echo "3"; } else { echo $querow['opt_c']; } ?>" onchange="checkSelection()" id="opt_3" >
                                        <div class="label-wrapper <?php echo $optCls.$stloptCls;if($prev_flag){echo $optC; if($querow['type2'] == 'p1' && $querow['correct_ans'] == 3) { echo 'right-ans'; } elseif($querow['type2'] == 'p1' && $resulrow['wrong'] == 3) { echo 'wrong-ans'; }} ?> ?>">
                                            <label for="opt_3"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_optc.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="opt" value="<?php if($querow['type2'] == 'p1') { echo "4"; } else { echo $querow['opt_d']; } ?>" onchange="checkSelection()" id="opt_4" >
                                        <div class="label-wrapper <?php echo $optCls.$stloptCls;if($prev_flag){echo $optD; if($querow['type2'] == 'p1' && $querow['correct_ans'] == 4) { echo 'right-ans'; } elseif($querow['type2'] == 'p1' && $resulrow['wrong'] == 4) { echo 'wrong-ans'; }} ?> ?>">
                                            <label for="opt_4"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_optd.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="text-center mt-md-4 mt-3 mb-4 mob-footer-fixed">
                            <span class="w-100 text-start" <?php if(empty($_SESSION['id'])) {
                                echo 'style="display:none"';
                            } ?>>
                                <button class="btn btn-dark btn-animated btn-lg" onclick="goToPrevQuestion(event)">Prev</button>
                            </span>
                            <span class="w-100 ps-2">
                                <?php if(!$prev_flag) { 
                                    if(isset($_SESSION['power-up']) && $sbtpcrow['class_id'] == $usrrow['class']) {
                                            $_SESSION['question-time'] = time();
                                            $maximum_time = time() + $_SESSION['minimum-time'];

                                            if($_SESSION['destination-timer'] - time() < $_SESSION['minimum-time']) {
                                                $maximum_time = time() + $_SESSION['destination-timer'] - time();
                                            }

                                            ?>
                                                <script>
                                                    $(document).ready(() => {
                                                        var targetTimestampMax = <?php echo $maximum_time ; ?>;
                                                        showTimerToast({ content: targetTimestampMax, keepOpen: true, toastId: 'maximumTimer', disablePower: false, imgBanner: 'fast-clock.svg', info: 'Maximum time to get booster points' });
                                                    });
                                                </script>
                                            <?php
                                        }    
                                ?>
                                    <input type="button" id="submitButton" name="submit" class="btn btn-orange btn-animated btn-lg mw-200" value="Submit" onclick="submitForm(this)" disabled>
                                <?php } else { ?>
                                    <button class="btn btn-orange btn-animated btn-lg" onclick="goToNextQuestion(event)">Next</button>
                                <?php } ?>    
                                </span>
                            <div class="w-100 text-end display-flex desktop-none">

                            
                            <?php if($limitMsg == '') { ?>
                                <?php
                                $quesposquery = mysqli_query($conn, "SELECT id FROM count_quest WHERE class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."' and id > '".$ordrow['question']."' or class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."' and id = '".$_SESSION['quesID']."'");
                                $quesposrslt = mysqli_fetch_array($quesposquery, MYSQLI_ASSOC);
                                ?>
                            <div class="text-center d-inline-block ms-1 me-2 submitReport">    
                            <a href="#report" data-bs-toggle="modal" data-bs-target="#reportModal" class="link reportques" data-id="<?php echo $quesposrslt['id']; ?>" <?php if(empty($_SESSION['id'])) { echo "style='visibility: hidden;'"; } ?>><span class="d-block"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12.3787 2.07239L1.37866 21.0724H23.3787M12.3787 6.07239L19.9087 19.0724H4.84866M11.3787 10.0724V14.0724H13.3787V10.0724M11.3787 16.0724V18.0724H13.3787V16.0724" fill="black"/>
</svg></span></a></div>

<div class="text-center d-inline-block ms-1 me-2 submitRequest">    
                            <a href="#request" data-bs-toggle="modal" data-bs-target="#requestModal" class="link requestques" data-id="<?php echo $quesposrslt['id']; ?>" <?php if(empty($_SESSION['id'])) { echo "style='visibility: hidden;'"; } ?>><span class="d-block"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12.3787 2.07239L1.37866 21.0724H23.3787M12.3787 6.07239L19.9087 19.0724H4.84866M11.3787 10.0724V14.0724H13.3787V10.0724M11.3787 16.0724V18.0724H13.3787V16.0724" fill="black"/>
</svg></span></a></div>


                            <div class="submitReport text-center d-inline-block">
                                <?php if(!isset($chkShortlistrow["id"])) { ?>
                                    <a href="#" class="link reportques" onclick="setShortlistMobile(event)" data-id="<?php echo $quesposrslt['id']; ?>" <?php if(empty($_SESSION['id'])) { echo "style='visibility: hidden;'"; } ?>><span class="d-block">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>
</span>

</a>

                                    <?php } else {
                                        ?>
                                    <a href="#" class="link reportques" onclick="removeShortlistMobile(event)" data-id="<?php echo $quesposrslt['id']; ?>" <?php if(empty($_SESSION['id'])) { echo "style='visibility: hidden;'"; } ?>><span class="d-block">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg>
                                        </span>

                                    </a>
                                        <?php
                                    } ?>
                            </div>
                        <?php } ?>
                        </div>
                        </div>
                        </div>
                        </form>  
                        <?php } else { ?>
                            <div class="text-center p-5">
                            <h1 class="page-title">We will have a question for you shortly....</h1>
                            </div>                          
                          <?php } } else { echo $limitMsg; } ?>
                        </div>
                        <div class="col-lg-4 footer-fixed">
                        <div class="rightside-wrapper">
                            <div class="position-stikcy">
                            <div id="performance">
                            <div class="score-widget">
                                <div class="heading heading-main bg-blue text-center">Performance Meter</div>
                                <div class="smart-score w-100">
                                    
                                <?php
                                    $uptoSQL = mysqli_query($conn, "SELECT COUNT(question) as ques_count FROM leaderboard WHERE userid='".$_SESSION['id']."' and class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."' order by id desc");
                                    $uptorow = mysqli_fetch_array($uptoSQL, MYSQLI_ASSOC); 

                                    
                                    $usercntSQL = mysqli_query($conn, "SELECT COUNT(DISTINCT userid) AS user_count FROM leaderboard WHERE class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."'");
                                    $usercntrow = mysqli_fetch_array($usercntSQL, MYSQLI_ASSOC);

                                    $quesSQL = mysqli_query($conn, "SELECT question FROM leaderboard WHERE userid='".$_SESSION['id']."' and class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."' order by id desc");
                                    $quesrow = mysqli_fetch_array($quesSQL, MYSQLI_ASSOC);

                                    $usercntSQL = mysqli_query($conn, "SELECT COUNT(DISTINCT userid) AS user_count FROM leaderboard WHERE class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."'");
                                    $usercntrow = mysqli_fetch_array($usercntSQL, MYSQLI_ASSOC);

                                    $clscntSQL = mysqli_query($conn, "SELECT COUNT(DISTINCT school) AS school_count FROM leaderboard WHERE class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."'");
                                    $clscntrow = mysqli_fetch_array($clscntSQL, MYSQLI_ASSOC);
                                    
                                    $quescntSQL = mysqli_query($conn, "SELECT COUNT(id) as quescnt FROM leaderboard WHERE userid='".$_SESSION['id']."' and class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."'");
                                    $quescntrow = mysqli_fetch_array($quescntSQL, MYSQLI_ASSOC);

                                ?>

                                    <div class="title txt-orange text-center">Accuracy upto Q. No. <?php echo $uptorow['ques_count']; ?></div>
                                    <div class="lg-txt">
                                <?php
                                    $queswiseSQL = "SELECT userid, COUNT(correct) AS correct_answers FROM leaderboard WHERE question <= '".$quesrow['question']."' and class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."' and userid='".$usrrow['id']."' and correct != 'NULL' GROUP BY userid ORDER BY correct_answers DESC";
                                    $queswiseresult = mysqli_query($conn, $queswiseSQL); 
                                ?>
                                    
                                    <span>
                                        <?php $queswiserow = mysqli_fetch_assoc($queswiseresult);
if(empty($uptorow['ques_count'])) { 
    if(!empty($_SESSION['id'])) {
        $tooltipMsg = 'Practice atleast 1 correct';
    } else {
        $tooltipMsg = 'Login to see ranks';
    }
    echo "<span class='d-inline' data-bs-toggle='tooltip' data-bs-placement='top' title='$tooltipMsg'>N/A</span>"; 
} else {
                                        echo round(($queswiserow['correct_answers']/$uptorow['ques_count']*100),0)."%";
}
                                        /*//$rank = 1;
                                        while ($queswiserow = mysqli_fetch_assoc($queswiseresult)) {
                                            $queswise_users[] = $queswiserow['userid'];
                                            $queswise_answers[] = $queswiserow['correct_answers'];
                                            //if ($_SESSION['id'] == $row['userid']) {
                                            //echo $rank;
                                            //}
                                            //$rank++;
                                            } 
                                           
                                            // Count the number of occurrences of each answer
                                            $counts = array_count_values($queswise_answers);
                                            
                                            // Sort the users based on their answer counts in descending order
                                            //asort($counts);
                                            
                                            // Loop through the sorted counts and assign a rank to each user
                                            $ranks = 1;
                                            foreach ($counts as $answer => $count) {
                                                //if($_SESSION['id'] ==  $users[$rank]) {

                                               // 
                                               foreach ($queswise_answers as $user => $user_answer) {
                                               
                                                if ($user_answer == $answer) {

                                                    if($_SESSION['id'] ==  $queswise_users[$user]) {
                                                        // echo "user  $users[$user]";
                                                        //echo $answer;
                                                        //echo $queswise_users[$user];
                                                    // echo $queswise_users[2]; ;
                                                        echo "$ranks<span class='per-txt'>%</span>";
                                                    }
                                                }
                                               }
                                      // }
                                                $ranks += $count;
                                            }*/

                                            /*$queswiseSQL = "SELECT userid, COUNT(correct) AS correct_answers FROM leaderboard WHERE question <= '".$quesrow['question']."' and user_class='".$usrrow['class']."' and class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."' and userid='".$usrrow['id']."' and correct != 'NULL' GROUP BY userid ORDER BY correct_answers DESC";
                                            $queswiseresult = mysqli_query($conn, $queswiseSQL);
                                            $chkquesCnt = mysqli_fetch_array($queswiseresult, MYSQLI_ASSOC);
                                            if(empty($chkquesCnt['userid'])) { echo '0'; }
                                            */
                                            ?>
                                    
                                    </div>
                                </div>
                                <div class="heading bg-pink flex-1">
                                    <span>Overall Rank</span>
                                    <?php 
                                    $correctSQL = "SELECT a.userid, SUM(a.scorecard) as correct_answers FROM leaderboard as a, users as b WHERE b.id=a.userid and b.class='".$usrrow['class']."' and a.subtopic='".$super_id."' and b.id IN ($eligibleIds)  GROUP BY a.userid ORDER BY correct_answers desc";
                                    $result = mysqli_query($conn, $correctSQL); ?>
                                    
                                    <span>
                                        <?php //$rank = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $users[] = $row['userid'];
                                            $answers[] = $row['correct_answers'];
                                            //if ($_SESSION['id'] == $row['userid']) {
                                            //echo $rank;
                                            //}
                                            //$rank++;
                                        } 
                                            // Count the number of occurrences of each answer
                                            $counts = array_count_values($answers);                                            
                                            // Sort the users based on their answer counts in descending order
                                           // asort($counts);
                                            
                                            // Loop through the sorted counts and assign a rank to each user
                                            $rank = 1;
                                            foreach ($counts as $answer => $count) {
                                                //if($_SESSION['id'] ==  $users[$rank]) {
                                               // 
                                               foreach ($answers as $user => $user_answer) {
                                                   if ($user_answer == $answer) {
                                                    if($_SESSION['id'] ==  $users[$user]) {
                                                        if($eligibleSbtp) {
                                                     // echo "user  $users[$user]";
                                                      echo "$rank";
                                                      
                                                      if($practicenotifchk["enable"] == 1) {
                                                        if(!empty($_SESSION["overall_rank"])) {
                                                            $text = "";
                                                            if($_SESSION["overall_rank"] != 1 && $rank == 1){
                                                                $text = "Congrats! You just became topper across all students for this subtopic.";
                                                            }
                                                            else if($_SESSION["overall_rank"] > 3 && $rank <= 3 && $rank > 1) {
                                                                $text = "Congrats! You just came in top-3 across all students for this subtopic.";
                                                            }
                                                            else if($_SESSION["overall_rank"] == 1 && $rank > 1 && $rank < 3) {
                                                                $text = "Oops! You were just overtaken by someone across schools. Practice more, and get your 1st rank back.";
                                                            }
                                                            else if($_SESSION["overall_rank"] <= 3 && $rank > 3) {
                                                                $text = "Oops! You just moved out of top 3 overall. Practice more to be in top-3.";
                                                            }


                                                            if($text !== "") {
                                                                ?>
                                                                    <script>
                                                                        var text = <?php json_encode($text); ?>;
                                                                        alert(text);
                                                                    </script>
                                                                <?php
                                                            }
                                                        }

                                                        $_SESSION["overall_rank"] = $rank;
                                                      }
                                                    } else {
                                                        echo "<span class='d-inline' data-bs-toggle='tooltip' data-bs-placement='top' title='Questions of other classes are not eligible for ranking'>N/A</span>";
                                                    }
                                                  }
                                                }
                                               }
                                      // }
                                                $rank += $count;
                                            }

                                            $correctSQL = "SELECT a.userid, SUM(a.scorecard) as correct_answers FROM leaderboard as a, users as b WHERE b.id=a.userid and b.class='".$usrrow['class']."' and a.subtopic='".$super_id."' and a.userid='".$usrrow['id']."'  GROUP BY a.userid ORDER BY correct_answers desc";
                                            $result = mysqli_query($conn, $correctSQL);
                                            $chkoverCnt = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                            if(empty($chkoverCnt['userid'])) { 
                                                if(!empty($_SESSION['id'])) {
                                                    $tooltipMsg = 'Practice atleast 1 correct';
                                                } else {
                                                    $tooltipMsg = 'Login to see ranks';
                                                }
                                                echo "<span class='d-inline' data-bs-toggle='tooltip' data-bs-placement='top' title='$tooltipMsg'>N/A</span>";
                                            }
                                            
                                             ?>
                                            </span>
                                </div>
                                <div class="heading bg-orange flex-1">
                                    <span>School Rank <span class="tab-none">(Classwise)</span></span>
                                    <span><?php
                                    $schwiseSQL = "SELECT a.userid, SUM(a.scorecard) as correct_answers FROM leaderboard as a, users as b WHERE b.id=a.userid and b.class='".$usrrow['class']."' and b.school='".$usrrow['school']."' and a.subtopic='".$super_id."' and b.id IN ($eligibleIds)  GROUP BY a.userid ORDER BY correct_answers desc";
                                    $schwiseresult = mysqli_query($conn, $schwiseSQL); ?>
                                    
                                    <span>
                                        <?php //$rank = 1;
                                        while ($schwiserow = mysqli_fetch_assoc($schwiseresult)) {
                                            $usrs[] = $schwiserow['userid'];
                                            $ans[] = $schwiserow['correct_answers'];
                                            //if ($_SESSION['id'] == $row['userid']) {
                                            //echo $rank;
                                            //}
                                            //$rank++;
                                            } 
                                           
                                            // Count the number of occurrences of each answer
                                            $counts = array_count_values($ans);
                                            
                                            // Sort the users based on their answer counts in descending order
                                            //asort($counts);
                                            
                                            // Loop through the sorted counts and assign a rank to each user
                                            $ranks = 1;
                                            foreach ($counts as $answer => $count) {
                                                //if($_SESSION['id'] ==  $users[$rank]) {
                                               // 
                                               foreach ($ans as $user => $user_answer) {
                                                   if ($user_answer == $answer) {
                                                    if($_SESSION['id'] ==  $usrs[$user]) {
                                                        if($eligibleSbtp) {
                                                     // echo "user  $users[$user]";
                                                      echo "$ranks";

                                                      if($practicenotifchk["enable"] == 1) {
                                                      if(!empty($_SESSION["school_rank"])) {
                                                        $texts = "";
                                                        if($_SESSION["school_rank"] != 1 && $ranks == 1){
                                                            $texts = "Congrats! You just became topper in your school for this subtopic.";
                                                        }
                                                        else if($_SESSION["school_rank"] > 3 && $ranks <= 3 && $ranks > 1) {
                                                            $texts = "Congrats! You just came in top-3 in your school for this subtopic.";
                                                        }
                                                        else if($_SESSION["school_rank"] == 1 && $ranks > 1 && $ranks < 3) {
                                                            $texts = "Oops! You were overtaken by someone from your school. Practice more, and get your 1st rank back.";
                                                        }
                                                        else if($_SESSION["school_rank"] <= 3 && $ranks > 3) {
                                                            $texts = "Oops! You just moved out of top 3 from your school. Practice more to be in top-3.";
                                                        }

                                                        if($texts !== "") {
                                                            ?>
                                                                <script>
                                                                    var texts = <?php json_encode($texts); ?>;
                                                                    showNotification(texts);
                                                                </script>
                                                            <?php
                                                        }
                                                      }

                                                      $_SESSION["school_rank"] = $ranks;
                                                    }
                                                    } else {
                                                        echo "<span class='d-inline' data-bs-toggle='tooltip' data-bs-placement='top' title='Questions of other classes are not eligible for ranking'>N/A</span>";
                                                    }
                                                  }
                                                }
                                               }
                                      // }
                                                $ranks += $count;
                                            }

                                            $schwiseSQL = "SELECT a.userid, SUM(a.scorecard) as correct_answers FROM leaderboard as a, users as b WHERE b.id=a.userid and b.class='".$usrrow['class']."' and b.school='".$usrrow['school']."' and a.subtopic='".$super_id."' and a.userid='".$usrrow['id']."'  GROUP BY a.userid ORDER BY correct_answers desc";
                                            $schwiseresult = mysqli_query($conn, $schwiseSQL); 
                                            $chkschCnt = mysqli_fetch_array($schwiseresult, MYSQLI_ASSOC);
                                            if(empty($chkschCnt['userid'])) { 
                                                if(!empty($_SESSION['id'])) {
                                                    $tooltipMsg = 'Practice atleast 1 correct';
                                                } else {
                                                    $tooltipMsg = 'Login to see ranks';
                                                }
                                                echo "<span class='d-inline' data-bs-toggle='tooltip' data-bs-placement='top' title='$tooltipMsg'>N/A</span>";
                                            }
                                            
                                            ?></span>
                                </div>
                            </div>
                            </div>
                            <?php if($limitMsg == '') { ?>
                            <div class="mt-3 text-end tab-none">
                                <?php
                                $quesposquery = mysqli_query($conn, "SELECT id FROM count_quest WHERE class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."' and id > '".$ordrow['question']."' or class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."' and id = '".$_SESSION['quesID']."'");
                                $quesposrslt = mysqli_fetch_array($quesposquery, MYSQLI_ASSOC);
                                ?>
                            <div class="submitReport">    
                            <a href="#report" data-bs-toggle="modal" data-bs-target="#reportModal" class="link reportques" data-id="<?php echo $quesposrslt['id']; ?>" <?php if(empty($_SESSION['id'])) { echo "style='visibility: hidden;'"; } ?>><span class="me-1"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12.3787 2.07239L1.37866 21.0724H23.3787M12.3787 6.07239L19.9087 19.0724H4.84866M11.3787 10.0724V14.0724H13.3787V10.0724M11.3787 16.0724V18.0724H13.3787V16.0724" fill="black"/>
</svg></span><span class="note">Report a Question</span></a></div>

<div class="submitRequest">    
                            <a href="#request" data-bs-toggle="modal" data-bs-target="#requestModal" class="link requestques" data-id="<?php echo $quesposrslt['id']; ?>" <?php if(empty($_SESSION['id'])) { echo "style='visibility: hidden;'"; } ?>><span class="me-1"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12.3787 2.07239L1.37866 21.0724H23.3787M12.3787 6.07239L19.9087 19.0724H4.84866M11.3787 10.0724V14.0724H13.3787V10.0724M11.3787 16.0724V18.0724H13.3787V16.0724" fill="black"/>
</svg></span><span class="note">Request a Solution</span></a></div>


                            <div class="submitReport">
                                <?php if(!isset($chkShortlistrow["id"])) { ?>
                                    <a href="#" class="link reportques" onclick="setShortlist(event)" data-id="<?php echo $quesposrslt['id']; ?>" <?php if(empty($_SESSION['id'])) { echo "style='visibility: hidden;'"; } ?>><span class="me-1">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>
                                
                                    </span>
                                <span class="note">Shortlist This Question</span>
                                </a>
                                    <?php } else {
                                        ?>
                                        <a href="#" class="link reportques" onclick="removeShortlist(event)" data-id="<?php echo $quesposrslt['id']; ?>"><span class="me-1">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-star-fill" viewBox="0 0 16 16">
  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
</svg><span class="note">Shortlisted This Question</span>
                                    </a>
                                    </span>
                                        <?php
                                    } ?>
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
                </div></div>
    </div>
    </section>
    <?php include("footer.php"); mysqli_close($conn);?>