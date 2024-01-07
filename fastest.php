<?php 
include("config/config.php");
include("functions.php");

if (empty($_SESSION['id'])) {
    header('Location:' . $baseurl);
    exit;
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
$parts = array_filter($parts);
array_shift($parts);
array_shift($parts);
foreach ($parts as $part) {
    $parts[] = $part;
}

$usrSQL = mysqli_query($conn, "SELECT id,school,class FROM users WHERE id='" . $_SESSION['id'] . "' and isAdmin=2 and status=1");
$usrrow = mysqli_fetch_array($usrSQL, MYSQLI_ASSOC);

$tpcSQL = mysqli_query($conn, "SELECT id,topic,slug,class_id,subject_id FROM topics_subtopics WHERE (slug='" . $parts[1] . "' and class_id='".$usrrow['class']."') or (id='" . $_SESSION['assign_topic'] . "' and class_id='".$usrrow['class']."') and status=1");
$tpcrow = mysqli_fetch_array($tpcSQL, MYSQLI_ASSOC);

$tpcQury = mysqli_query($conn, "SELECT subject_id,class_id FROM topics_subtopics WHERE id='".$_SESSION['assign_topic']."' and status=1");
$tpcRslt = mysqli_fetch_array($tpcQury, MYSQLI_ASSOC);

$clsSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE id='".$tpcrow['class_id']."' or id='".$tpcRslt['class_id']."' and type=2 and status=1");
$clsrow = mysqli_fetch_array($clsSQL, MYSQLI_ASSOC);

$sbjSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE id='".$tpcrow['subject_id']."' or id='".$tpcRslt['subject_id']."' and type=1 and status=1");
$sbjrow = mysqli_fetch_array($sbjSQL, MYSQLI_ASSOC);

$quizqury = mysqli_query($conn, "SELECT id,created_at,correct FROM fastest WHERE userid='" . $_SESSION['id'] . "' and topicid='" . $tpcrow['id'] . "' ORDER BY id desc LIMIT 1");
$quizrow = mysqli_fetch_array($quizqury, MYSQLI_ASSOC);

$createdDateTime = $quizrow['created_at'];

if (isset($_POST['tryAgain'])) {
    $_SESSION['assign_topic'] = $tpcrow['id'];
    header('Location: '.$baseurl.'fastest');
    exit;
}

if (isset($_POST['startQuiz'])) {
    $fchkqury = mysqli_query($conn, "SELECT id, userid, topicid FROM fastest WHERE userid='" . $_SESSION['id'] . "' and topicid='" . $_SESSION['assigned_topic'] . "'");
    $fchkrslt = mysqli_fetch_array($fchkqury, MYSQLI_ASSOC);

    $currentDateTime = date('Y-m-d H:i:s');

    if (empty($fchkrslt['topicid'])) {
        mysqli_query($conn, "INSERT INTO fastest(userid, topicid, correct, wrong, duration,school,created_at) VALUES ('" . $_SESSION['id'] . "','" . $_SESSION['assigned_topic'] . "',0,0,0,'".$usrrow['school']."','" . $currentDateTime . "')");
    } else {
        mysqli_query($conn, "update fastest Set created_at='" . $currentDateTime . "' WHERE userid='" . $_SESSION['id'] . "'");
    }

    mysqli_query($conn, "delete FROM fastest_leaderboard WHERE userid='" . $_SESSION['id'] . "' and quizid='" . $fchkrslt['id'] . "'");

    $topicqury = mysqli_query($conn, "SELECT slug FROM topics_subtopics WHERE id='" . $_SESSION['assigned_topic'] . "'");
    $topicrslt = mysqli_fetch_array($topicqury, MYSQLI_ASSOC);

    unset($_SESSION['assigned_topic']);
    unset($_SESSION['fastest_correct']);
    unset($_SESSION['fastest_time']);
    unset($_SESSION['urrank']);

    header('Location: ' . $_SERVER['REQUEST_URI'] . '/' . $topicrslt['slug']);
    exit;
}

function my_sort($a, $b) {
    if ($a == $b) return 0;
    return ($a < $b) ? -1 : 1;
}


if (isset($_POST['submit'])) {
    $option = $_POST['opt'];
    $quesID = $_POST['ques'];

    if (!empty($quesID)) {
        $chkSQL = mysqli_query($conn, "SELECT id,correct_ans FROM count_quest WHERE id='" . $quesID . "'");
        $chkrow = mysqli_fetch_array($chkSQL, MYSQLI_ASSOC);

        if ($chkrow['correct_ans'] == $option) {
            $correct = $option;
            $wrong = "NULL";
        } else {
            $correct = "NULL";
            $wrong = $option;
        }

        $currentDateTime = date('Y-m-d H:i:s');

        mysqli_query($conn, "INSERT INTO fastest_leaderboard(quizid,userid,question,correct,wrong,created_at,updated_at) VALUES ('" . $quizrow['id'] . "','" . $_SESSION['id'] . "','" . $quesID . "','" . $correct . "','" . $wrong . "','" . $currentDateTime . "','" . $currentDateTime . "')");

        $fstqury = mysqli_query($conn, "SELECT COUNT(id) as count FROM fastest_leaderboard WHERE userid='" . $_SESSION['id'] . "' and quizid='" . $quizrow['id'] . "'");
        $fstrslt = mysqli_fetch_array($fstqury, MYSQLI_ASSOC);

        if ($fstrslt['count'] > 9) {
            include("components/fastest_rslt.php");

            if(!empty($quizrow['correct'])) {
            $_SESSION['fastest_correct'] = $fst_chk_rslt['correct'];
            $_SESSION['fastest_time'] = $fst_chk_rslt['duration'];
            $_SESSION['urrank'] = $urrank;
            }
            
        if ($fst_crt >= 1 && $fst_crt <= 9) {
            $fst_crt = "0" . $fst_crt;
        } else {
            $fst_crt = $fst_crt;
        }
        
        if ($fst_wrg >= 1 && $fst_wrg <= 9) {
            $fst_wrg = "0" . $fst_wrg;
        } else {
            $fst_wrg = $fst_wrg;
        }

            if ($fst_chk_rslt['correct'] < $fst_crt && $fst_chk_rslt['duration'] > $fst_time || $fst_chk_rslt['correct'] < $fst_crt && $fst_chk_rslt['duration'] < $fst_time) {
                mysqli_query($conn, "update fastest Set converttime='" . strtotime($fst_time) . "', correct='" . $fst_crt . "',wrong='" . $fst_wrg . "',duration='" . $fst_time . "' WHERE userid='" . $_SESSION['id'] . "' and id='" . $quizrow['id'] . "'");
            }
        }
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}

include("header.php"); ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
  const textContainers = document.querySelectorAll('.resizeTxt');

  textContainers.forEach(textContainer => {
    const originalText = textContainer.textContent;

    const resizeTextToFit = () => {
      const maxWidth = textContainer.offsetWidth;
      const maxHeight = textContainer.offsetHeight;

      let fontSize = 18; // Initial font size
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
});

//Resize Heading
document.addEventListener("DOMContentLoaded", function() {
            const textContainers = document.querySelectorAll('.page-title-wrapper .page-title');

            textContainers.forEach(textContainer => {
                const originalText = textContainer.textContent;

                const resizeTextToFit = () => {
                    const maxWidth = textContainer.offsetWidth;
                    const maxHeight = textContainer.offsetHeight;

                    let fontSize = 26; // Initial font size

                    if (window.innerWidth > 992) {
                        fontSize = 26;
                    } else if (window.innerWidth > 768) {
                        fontSize = 22;
                    } else if (window.innerWidth <= 574) {
                        fontSize = 20; // Font size for screens less than or equal to 574px
                    }

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
<?php if(!empty($_SESSION['assign_topic'])) { $_SESSION['assigned_topic'] = $_SESSION['assign_topic']; unset($_SESSION['assign_topic']); ?>
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs st-breadcrumbs mb-5">
                    <span><a href="<?php echo $baseurl; ?>">Home</a></span>
                    <span><a href="<?php echo $baseurl.$sbjrow['slug'].'/'.$clsrow['slug']; ?>"><?php echo $clsrow['name']; ?></a></span>
                    <span><?php echo $tpcrow['topic']; ?></span>
                    <span>Fastest 10</span>
                </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="start-widget">
                    <div class="mb-3">
                        <img src="assets/images/fastest.svg" height="80" alt="">
                    </div>
                <h2 class="heading mb-4">Are you ready for the Fastest 10? </h2>
                <button type="submit" name="startQuiz" class="btn btn-animated btn-lg mw-200">Start</button>
                </div>
            </form>  
            </div>
        </div>
    </div>
</section> 
<?php } elseif(!empty($tpcrow['id'])) { ?>
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 position-relative">
                            <div class="breadcrumbs st-breadcrumbs mb-3">
                                <span><a href="<?php echo $baseurl; ?>">Home</a></span>
                                <span><a href="<?php echo $baseurl.$sbjrow['slug'].'/'.$clsrow['slug']; ?>"><?php echo $clsrow['name']; ?></a></span>
                                <span><?php echo $tpcrow['topic']; ?></span>
                                <span>Fastest 10</span>
                            </div>
                            
                            <?php   
                            
                            $fastestqury = mysqli_query($conn, "SELECT COUNT(id) as count FROM fastest_leaderboard WHERE userid='".$_SESSION['id']."' and quizid='".$quizrow['id']."'");
                            $fastestrslt = mysqli_fetch_array($fastestqury, MYSQLI_ASSOC);
 
                            if($fastestrslt['count'] < 10) { ?>

                            <div class="timer-wrapper mb-lg-0 mb-3 pb-lg-0 pb-3">
                            <div class="timer-heading">Q.<?php echo $fastestrslt['count']+1; ?> of 10</div>    
                            <div class="time-main"><img class="me-2" src="../assets/images/clock-time.svg" width="25" height="25" alt=""><div id="timer"></div></div>
                            </div>
                            
                          <?php $queSQL = mysqli_query($conn, "SELECT id,question,opt_a,opt_b,opt_c,opt_d,type,type1,correct_ans,subtopic,shape_info FROM count_quest WHERE topic='".$tpcrow['id']."' and type2 !='q1' or topic='".$tpcrow['id']."' ORDER BY RAND()");
                            $querow = mysqli_fetch_array($queSQL, MYSQLI_ASSOC);

                            $sbtpcSQL = mysqli_query($conn, "SELECT id,parent,subtopic FROM topics_subtopics WHERE id='".$querow['subtopic']."' and parent!=0 and status=1");
                            $sbtpcrow = mysqli_fetch_array($sbtpcSQL, MYSQLI_ASSOC);

                            include("components/dyn_cond.php");

                            if($sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38' && $querow['type'] == '0' || $sbtpcrow['id'] == '38' && $querow['type'] == '1') { 
                                $quesCls .= "horizontal-options ";
                            } elseif ($sbtpcrow['id'] == '7' && $querow['type'] == '2' || $sbtpcrow['id'] == '7' && $querow['type'] == '3' || $sbtpcrow['id'] == '12' && $querow['type'] == '2' || $sbtpcrow['id'] == '12' && $querow['type'] == '3') { 
                                $quesCls .= "font-md";
                            }
                            
                            
                            if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38') { 
                                $optCls .= "ht-200 br-grey ";
                            }
                            
                            if($sbtpcrow['id'] == '13' && $querow['type'] == '0' || $sbtpcrow['id'] == '13' && $querow['type'] == '1' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37') { 
                                $optCls .= "img-grid ";
                            }
                            
                            if($sbtpcrow['id'] == '22' || $sbtpcrow['id'] == '31' || $sbtpcrow['id'] == '33' || $sbtpcrow['id'] == '34' || $sbtpcrow['id'] == '35') {
                                $optCls .= "font-md";
                            }
                            
                             ?>
                            <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="ques" value="<?php echo $querow['id']; ?>">
                            <h1 class="page-title mb-2 pt-md-4 pt-0 text-center"><?php echo $querow['question']; ?></h1>
                            <?php include("components/dyn_ques.php"); ?>
                            <ul class="options multi-btn <?php echo $quesCls; ?>">
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="opt" value="<?php echo $querow['opt_a']; ?>" id="opt_1" required>
                                        <div class="label-wrapper <?php echo $optCls; ?>">
                                            <label for="opt_1"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_opta.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="opt" value="<?php echo $querow['opt_b']; ?>" id="opt_2" required>
                                        <div class="label-wrapper <?php echo $optCls; ?>">
                                            <label for="opt_2"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_optb.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="opt" value="<?php echo $querow['opt_c']; ?>" id="opt_3" required>
                                        <div class="label-wrapper <?php echo $optCls; ?>">
                                            <label for="opt_3"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_optc.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="opt" value="<?php echo $querow['opt_d']; ?>" id="opt_4" required>
                                        <div class="label-wrapper <?php echo $optCls; ?>">
                                            <label for="opt_4"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_optd.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                        </ul>
                                        <div class="text-center mt-4">
                                    <?php 
                                            if($fastestrslt['count'] >= 9) { ?>
                                            <input type="submit" name="submit" class="btn btn-animated btn-lg mw-200" value="Finish">
                                            <?php } else { ?>
                                                <input type="submit" name="submit" class="btn btn-orange btn-animated btn-lg mw-200" value="Submit">
                                                <?php } ?>
                                    
                            </div>
                        </form>
                        <?php } else { ?>
                            <?php include("components/fastest_rslt.php"); ?>
                            <div class="start-widget p-md-5 p-4">
                <h2 class="heading mb-0">
                <?php
                if (empty($_SESSION['fastest_correct'])) {
                    echo "Congrats!! Submit Successfull";
                } elseif (($fst_crt == $_SESSION['fastest_correct'] && $fst_time < $_SESSION['fastest_time'])) {
                    echo "Same Score, Less Time - Congrats!!";
                } elseif(($fst_crt > $_SESSION['fastest_correct'] && $fst_time < $_SESSION['fastest_time'])) {
                    echo "Better Score, less time - Double Congrats!!";
                } elseif(($fst_crt > $_SESSION['fastest_correct'] && $fst_time > $_SESSION['fastest_time'])) {
                    echo "Better Score, more time - Congrats!!";
                } elseif(($fst_crt < $_SESSION['fastest_correct'])) {
                    echo "Worse Score - Oops!! You couldn't beat your last score. ";
                } elseif(($fst_crt == $_SESSION['fastest_correct'])) {
                    echo "Same Score, more time - Oops!! You couldn't beat your last score.";
                } 
                ?>
            </h2>  
            
            <?php 
                
                $score = $fst_crt-$_SESSION['fastest_correct'];
               
                $time1 = new DateTime($_SESSION['fastest_time']);
                $time2 = new DateTime($fst_time);                
                $interval = $time1->diff($time2);                
                $time = $interval->format('%H:%I:%S');

                if($_SESSION['urrank'] > $urrank) {
                    $lstRnk = $_SESSION['urrank']-$urrank;
                    $lstRnk = '<span class="lstRslt txt-green"><img src="'.$baseurl.'assets/images/up-arrow.svg" width="15" height="15"> '.$lstRnk.'*</span>';
                } elseif($_SESSION['urrank'] == $urrank) {
                    $lstRnk = '<span class="lstRslt">Same as last</span>';  
                } else {
                    $lstRnk = $urrank-$_SESSION['urrank'];
                    $lstRnk = '<span class="lstRslt txt-red"><img src="'.$baseurl.'assets/images/down-arrow.svg" width="15" height="15"> '.$lstRnk.'*</span>';
                }

                if($_SESSION['fastest_time'] > $fst_time) {
                    $lstTime = '<span class="lstRslt txt-green">'.$time.' less</span>';
                } elseif($_SESSION['fastest_time'] == $fst_time) {
                    $lstTime = '<span class="lstRslt">Same as last</span>';  
                } else {
                    $lstTime = '<span class="lstRslt txt-red">'.$time.' more</span>';
                }

                if (!empty($_SESSION['fastest_correct'])) {

                    if (($fst_crt == $_SESSION['fastest_correct'] && $fst_time < $_SESSION['fastest_time'])) {
                        $lstTime = $lstTime;
                        $lstCrt = '<span class="lstRslt">Same as last</span>';
                        $lstRnk = $lstRnk;
                    } elseif(($fst_crt > $_SESSION['fastest_correct'] && $fst_time < $_SESSION['fastest_time'])) {
                        $lstTime = $lstTime;
                        $lstCrt = '<span class="lstRslt txt-green"><img src="'.$baseurl.'assets/images/up-arrow.svg" width="15" height="15"> '.$score.'</span>';
                        $lstRnk = $lstRnk;
                    } elseif(($fst_crt > $_SESSION['fastest_correct'] && $fst_time > $_SESSION['fastest_time'])) {
                        $lstTime = $lstTime;
                        $lstCrt = '<span class="lstRslt txt-green"><img src="'.$baseurl.'assets/images/up-arrow.svg" width="15" height="15"> '.$score.'</span>';
                        $lstRnk = $lstRnk;
                    }
                } else {
                    $lstTime = '';
                    $lstCrt = '';
                    $lstRnk = '';
                }

                
                ?>

                <div class="results mb-md-5 mb-4">
                <div class="lt-flex">
                    <div><span class="head">Correct</span><span class="data"><?php echo $fst_crt; ?></span><?php echo $lstCrt; ?></div>
                    <div><span class="head">Wrong</span><span class="data"><?php echo $fst_wrg; ?></span></div>
                    </div>
                    <div class="rt-flex">
                    <div><span class="head">Duration</span><span class="data"><?php echo $fst_time; ?></span><?php echo $lstTime; ?></div>
                    <div><span class="head">Rank</span><span class="data"><?php echo $urrank; ?></span><?php echo $lstRnk; ?></div>
                    </div>
                </div>
                <div class="d-flex flex-md-row flex-column">
                <form action="" method="post" enctype="multipart/form-data" class="w-md-50 w-100 me-md-3">
                <button type="submit" name="tryAgain" class="btn custom-btn btn-lg w-100">
                <?php
                if (($fst_crt == $_SESSION['fastest_correct'] && $fst_time < $_SESSION['fastest_time']) || 
                    ($fst_crt > $_SESSION['fastest_correct'] && $fst_time < $_SESSION['fastest_time']) || 
                    ($fst_crt > $_SESSION['fastest_correct'] && $fst_time > $_SESSION['fastest_time'])) {
                    echo "Improve Further";
                } elseif ($fst_crt < $_SESSION['fastest_correct'] || $fst_crt == $_SESSION['fastest_correct']) {
                    echo "Try Again";
                }
                ?>
                </button>
                        </form>
                        <a href="<?php echo $baseurl.'leaderboard#'.$tpcrow['slug']; ?>" class="btn custom-btn btn-dark btn-lg w-md-50 w-100 mt-md-0 mt-2"> View Leaderboard</a>
                        </div>
                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4">
                            
                            
                        </div>
                    </div>
                </div>
    </div>
    </section>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>
<?php include("footer.php"); mysqli_close($conn);?>