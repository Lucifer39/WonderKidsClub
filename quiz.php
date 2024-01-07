<?php 
include("config/config.php");
include("functions.php");

if (empty($_SESSION['id'])) {
    header('Location:' . $baseurl);
    exit;
}

$sessionsql = mysqli_query($conn, "SELECT isAdmin,fullname,school,class FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

$chkquiz_qury = mysqli_query($conn, "SELECT id FROM quiz WHERE class='".$sessionrow['class']."' and type=1 and status=1");
$chkquiz_rslt = mysqli_fetch_assoc($chkquiz_qury);

$clssql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$sessionrow['class']."' and type=2 and status=1");
$clsrow = mysqli_fetch_assoc($clssql);

//Fetch Slug Array
$url = 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 's' : '') . '://' . $_SERVER['SERVER_NAME'];

if ($_SERVER['SERVER_PORT'] != "80") {
    $url .= ":" . $_SERVER['SERVER_PORT'];
}

$url .= $_SERVER['REQUEST_URI'];

$parts = array_filter(explode('/', $url));
array_shift($parts);
array_shift($parts);
$parts = array_merge($parts, $parts);


//Quiz Query
$quiz_query = mysqli_query($conn, "SELECT id FROM quiz WHERE slug='".$parts[2]."' and status=1");
$quiz_rslts = mysqli_fetch_array($quiz_query, MYSQLI_ASSOC);

//Quiz Time Starts
$quiz_start_query = mysqli_query($conn, "SELECT id,starts FROM quiz_time_starts WHERE quizid='".$quiz_rslts['id']."' and userid='".$_SESSION['id']."'");
$quiz_start_rslt = mysqli_fetch_array($quiz_start_query, MYSQLI_ASSOC);

$createdDateTime = $quiz_start_rslt['starts'];

if (isset($_POST['startQuiz'])) {

    $currentDateTime = date('Y-m-d H:i:s');
    mysqli_query($conn, "INSERT INTO quiz_time_starts(userid,quizid,starts) VALUES ('".$_SESSION['id']."','".$quiz_rslts['id']."','".$currentDateTime."')");

    header('Location: ' . $_SERVER['REQUEST_URI'] . '/' . $topicrslt['slug']);
    exit;
}

function my_sort($a, $b) {
    if ($a == $b) return 0;
    return ($a < $b) ? -1 : 1;
}

$usrSQL = mysqli_query($conn, "SELECT id,school,class FROM users WHERE id='" . $_SESSION['id'] . "' and isAdmin=2 and status=1");
$usrrow = mysqli_fetch_array($usrSQL, MYSQLI_ASSOC);

$quizSQL = mysqli_query($conn, "SELECT id,class,subject,name,slug FROM quiz WHERE slug='".$parts[1]."' and status=1");
$quizrow = mysqli_fetch_array($quizSQL, MYSQLI_ASSOC);

$leaderSQL = mysqli_query($conn, "SELECT created_at FROM quiz_leaderboard WHERE quizid='" . $quizrow['id'] . "' order by id asc");
$leaderrow = mysqli_fetch_array($leaderSQL, MYSQLI_ASSOC);

//$createdDateTime = $leaderrow['created_at'];

if (isset($_POST['submit'])) {
    $option = $_POST['opt'];
    $quesID = $_POST['ques'];

    $tpcqury = mysqli_query($conn, "SELECT id,topic,subtopic FROM quiz_quest WHERE question_id='" . $quesID . "' and quizid='" . $quizrow['id'] . "'");
    $tpcrslt = mysqli_fetch_array($tpcqury, MYSQLI_ASSOC);

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

        mysqli_query($conn, "INSERT INTO quiz_leaderboard(quest_id,quizid,userid,class,subject,topic,subtopic,school,user_class,question,correct,wrong,created_at,updated_at)
        VALUES ('" . $tpcrslt['id'] . "','" . $quizrow['id'] . "','" . $_SESSION['id'] . "','" . $quizrow['class'] . "','" . $quizrow['subject'] . "','" . $tpcrslt['topic'] . "','" . $tpcrslt['subtopic'] . "','" . $usrrow['school'] . "','" . $usrrow['class'] . "','" . $quesID . "','" . $correct . "','" . $wrong . "','" . $currentDateTime . "','" . $currentDateTime . "')");

        $leaderSQL = mysqli_query($conn, "SELECT question FROM quiz_leaderboard   WHERE userid='" . $_SESSION['id'] . "' and id='" . $conn->insert_id . "' order by id desc");
        $leaderrow = mysqli_fetch_array($leaderSQL, MYSQLI_ASSOC);

        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}

if(!empty($chkquiz_rslt['id'])) {
include("header.php");
?>
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
  </script>
<section class="section pb-0">
    <div class="container">
        <div class="row">
            <div class="col-md-8 position-relative">
                <div class="breadcrumbs st-breadcrumbs mb-3">
                    <span><a href="<?php echo $baseurl; ?>">Home</a></span>
                    <?php if(!empty($quizrow['name'])) { ?>
                        <span><a href="../quiz">Quiz</a></span>
                    <?php } else { ?>
                        <span>Quiz</span>
                    <?php } ?>
                    <?php if(!empty($quizrow['name'])) { ?>
                        <span><?php echo $quizrow['name']; ?></span>
                    <?php } ?>
                </div>
<?php if($parts[1] != $quizrow['slug']) { ?>
            <h1 class="page-title txt-navy pt-md-4 pt-0">Quiz</h1>
            <p class="lead">Welcome to the world of learning and discovery for <?php echo $clsrow['name']; ?> students.</p>
            </div>
        </div>
    </div>
</section>
<section class="section pt-0 pb-0">
    <div class="container">
        <div class="row mb-5">
            <?php 

                $otherCls_qury = mysqli_query($conn, "SELECT a.class_id,a.quizid FROM quiz_other_class as a INNER JOIN quiz as b ON b.id=a.quizid WHERE a.class_id='".$sessionrow['class']."' and b.status=1");
                while($otherCls_rslt = mysqli_fetch_array($otherCls_qury)) {
                    $otherCls[] = $otherCls_rslt['quizid'];
                }

                $quiz_qury = mysqli_query($conn, "SELECT id, name, slug, start_date, end_date FROM quiz WHERE (class = '" . $sessionrow['class'] . "' AND type = 1) OR (id IN (" . implode(',', $otherCls) . ") AND type = 1) ORDER BY id DESC");
                while($quiz_rslt = mysqli_fetch_array($quiz_qury, MYSQLI_ASSOC)) {  
                    
                $quiz_qcnt_qry = mysqli_query($conn, "SELECT COUNT(id) as count FROM quiz_leaderboard WHERE userid='".$_SESSION['id']."' and quizid='".$quiz_rslt['id']."'");
                $quiz_qcnt_rslt = mysqli_fetch_array($quiz_qcnt_qry, MYSQLI_ASSOC);

                $quiz_qustcnt_qry = mysqli_query($conn, "SELECT COUNT(id) as count FROM quiz_quest WHERE quizid='".$quiz_rslt['id']."'");
                $quiz_qustcnt_rslt = mysqli_fetch_array($quiz_qustcnt_qry, MYSQLI_ASSOC);
            ?>
            <div class="col-md-12 mb-4">
            <?php if(strtotime(date('Y-m-d H:i:s')) >= strtotime($quiz_rslt['start_date'])) { 
                            $activeLink = "quiz/".$quiz_rslt['slug']."";

                            if($quiz_qcnt_rslt['count'] == $quiz_qustcnt_rslt['count']) {
                                $activeName = "Your Score";
                            } else {
                                $activeName = "Start Quiz";
                            }
                        } else {
                            $activeLink = "javascript:void(0)";
                            $activeName = "Starts at ".DATE('d M', strtotime($quiz_rslt['start_date']))."";
                        }
                    ?>
            <div class="blk-widget-inner flex-md-row-reverse list">
            <div class="rt">
                                                <div class="date">
                                                    <div>
                                                        <div class="d"><?php echo DATE('d', strtotime($quiz_rslt['start_date'])); ?></div>
                                                        <div class="my"><?php echo DATE('M Y', strtotime($quiz_rslt['start_date'])); ?></div>
                                                    </div>
                                                    <div class="divider">-</div>
                                                    <div>
                                                        <div class="d"><?php echo DATE('d', strtotime($quiz_rslt['end_date'])); ?></div>
                                                        <div class="my"><?php echo DATE('M Y', strtotime($quiz_rslt['end_date'])); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="lt">
                                            <a href="<?php echo $activeLink; ?>" class="acpt-grp flex-column">
                        <h3 class="heading mb-1"><?php echo $quiz_rslt['name'];?></h3>  
                       
                                               
                    </a>
                    <p>Total Question: <?php echo $quiz_qustcnt_rslt['count'];?></p> 
                    <a href="<?php echo $activeLink;?>" class="btn btn-d-border"><?php echo $activeName;?></a>
                    <?php if($quiz_qcnt_rslt['count'] == $quiz_qustcnt_rslt['count']) { ?>
                        <a href="" class="ms-1 btn btn-d-border">Result</a>
                    <?php } ?>
                                            </div>
                                            
                                        </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php } else { ?>
<?php if(empty($quiz_start_rslt['id'])) { ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="start-widget pt-md-4 pt-0">
                    <div class="mb-3">
                        <img src="../assets/images/fastest.svg" height="80" alt="">
                    </div>
                <h2 class="heading mb-md-5 mb-4">Are you ready for <br><?php echo $quizrow['name']; ?>? </h2>
                <button type="submit" name="startQuiz" class="btn btn-animated btn-lg pe-5 ps-5 w-50 btn-w-100">Start</button>
                </div>
            </form>  
            </div>
        </div>
    </div>
</section>
<?php } elseif(!empty($quiz_start_rslt['id'])) { ?> 
                            <?php 
                            $quiz_ques_qry = mysqli_query($conn, "SELECT COUNT(id) as count FROM quiz_leaderboard WHERE userid='".$_SESSION['id']."' and quizid='".$quizrow['id']."'");
                            $quiz_ques_rslt = mysqli_fetch_array($quiz_ques_qry, MYSQLI_ASSOC);

                            $ordSQL = mysqli_query($conn, "SELECT quest_id FROM quiz_leaderboard WHERE userid='".$_SESSION['id']."' and quizid='".$quizrow['id']."' order by id desc");
                            $ordrow = mysqli_fetch_array($ordSQL, MYSQLI_ASSOC);

                            $quiz_qustcnt_qry = mysqli_query($conn, "SELECT COUNT(id) as count FROM quiz_quest WHERE quizid='".$quizrow['id']."'");
                            $quiz_qustcnt_rslt = mysqli_fetch_array($quiz_qustcnt_qry, MYSQLI_ASSOC);

                            $quesTotSQL = mysqli_query($conn, "SELECT id FROM quiz_quest WHERE quizid='".$quizrow['id']."' and id > '".$ordrow['quest_id']."'");
                            while($quesTotrow = mysqli_fetch_array($quesTotSQL, MYSQLI_ASSOC)) {
                                $quesow[] = $quesTotrow['id'];
                            }  if(!empty($quesow[0])) { ?>

                            <div class="timer-wrapper mb-4 pb-4">
                            <div class="timer-heading">Q.<?php echo $quiz_ques_rslt['count']+1; ?> of <?php echo $quiz_qustcnt_rslt['count'];?></div>    
                            <div class="time-main"><img class="me-2" src="../assets/images/clock-time.svg" width="25" height="25" alt=""><div id="timer"></div></div>
                            </div>

                            <?php } if(!empty($quesow[0])) { if (!empty($ordrow['quest_id'])) {
                                $quizqury = mysqli_query($conn, "SELECT question_id,topic,subtopic FROM quiz_quest WHERE quizid='".$quizrow['id']."' and id='".$quesow[0]."' order by id asc LIMIT 1");
                            } else {
                                $quizqury = mysqli_query($conn, "SELECT question_id,topic,subtopic FROM quiz_quest WHERE quizid='".$quizrow['id']."' order by id asc LIMIT 1");
                            }
                            while($quizrslt = mysqli_fetch_array($quizqury, MYSQLI_ASSOC)) {
                            
                            
                            
                            $queSQL = mysqli_query($conn, "SELECT id,question,opt_a,opt_b,opt_c,opt_d,type,type1,correct_ans FROM count_quest WHERE class='".$quizrow['class']."' and subject='".$quizrow['subject']."' and topic='".$quizrslt['topic']."' and subtopic='".$quizrslt['subtopic']."' and id =".$quizrslt['question_id']."");
                            $querow = mysqli_fetch_array($queSQL, MYSQLI_ASSOC);

                            $sbtpcSQL = mysqli_query($conn, "SELECT id,parent,subtopic FROM topics_subtopics WHERE id='".$quizrslt['subtopic']."' and parent!=0 and status=1");
                            $sbtpcrow = mysqli_fetch_array($sbtpcSQL, MYSQLI_ASSOC);

                            include("components/dyn_cond.php");

                           

                             ?>
                            <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="ques" value="<?php echo $querow['id']; ?>">
                            <h1 class="page-title mb-3 text-center pt-md-4 pt-0"><?php echo $querow['question']; ?></h1>
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
                                        <div class="text-center mt-3">
                                    <?php 
                                    $ordSQL = mysqli_query($conn, "SELECT COUNT(quest_id) as count FROM quiz_leaderboard WHERE userid='".$_SESSION['id']."' and quizid='".$quizrow['id']."' order by id desc");
                                    $ordrow = mysqli_fetch_array($ordSQL, MYSQLI_ASSOC);

                                    $checkqury = mysqli_query($conn, "SELECT COUNT(id) as count FROM quiz_quest WHERE quizid='".$quizrow['id']."'");
                                    $checkrow = mysqli_fetch_array($checkqury, MYSQLI_ASSOC); 

                                            if($checkrow['count']-1 == $ordrow['count']) { ?>
                                            <input type="submit" name="submit" class="btn btn-dark btn-animated btn-lg mw-200" value="Finish">
                                            <?php } else { ?>
                                                <input type="submit" name="submit" class="btn btn-orange btn-animated btn-lg mw-200" value="Submit">
                                                <?php } ?>
                                    
                            </div>
                        </form>
                        <?php } } else { ?>
                            <div class="start-widget p-md-5 p-3">
                <h2 class="heading mb-0">Thank you for submitting the quiz!</h2>
                <?php include("components/fastest_rslt.php"); ?>
                <div class="results quiz-results mb-5">

                <?php
                $quiz_crt_qury = mysqli_query($conn, "SELECT COUNT(correct) as correct FROM quiz_leaderboard WHERE userid='".$_SESSION['id']."' and quizid='".$quizrow['id']."' and correct != 'NULL'");
                $quiz_crt_rslt = mysqli_fetch_array($quiz_crt_qury, MYSQLI_ASSOC);

                $quiz_wrg_qury = mysqli_query($conn, "SELECT COUNT(wrong) as wrong FROM quiz_leaderboard WHERE userid='".$_SESSION['id']."' and quizid='".$quizrow['id']."' and wrong != 'NULL'");
                $quiz_wrg_rslt = mysqli_fetch_array($quiz_wrg_qury, MYSQLI_ASSOC);

                $quiz_time_qury = mysqli_query($conn, "SELECT updated_at FROM quiz_leaderboard WHERE userid='".$_SESSION['id']."' and quizid='".$quizrow['id']."' order by id desc");
                $quiz_time_rslt = mysqli_fetch_array($quiz_time_qury, MYSQLI_ASSOC);

                $datetime1 = new DateTime($createdDateTime);
                $datetime2 = new DateTime($quiz_time_rslt['updated_at']);
                $duration = $datetime1->diff($datetime2);
                ?>

                    <div><span class="head">Correct</span><span class="data"><?php echo $quiz_crt_rslt['correct']; ?></span></div>
                    <div><span class="head">Wrong</span><span class="data"><?php echo $quiz_wrg_rslt['wrong']; ?></span></div>
                    <div><span class="head">Duration</span><span class="data"><?php echo $duration->format("%H:%I:%S"); ?></span></div>
                </div>
                <a href="../dashboard" class="btn btn-animated btn-lg pe-5 ps-5">Go to dashboard</a>
                </div>                          
                          <?php } ?>
                        </div>
                        <div class="col-md-4">
                            
                            
                        </div>
                    </div>
                </div>
    </div>
    </section>
    <?php } ?>
    <?php } ?>
    <?php include("footer.php"); ?>
    <?php } else { header('Location:'.$baseurl.'dashboard'); 
    } mysqli_close($conn);?>