<?php
include("config/config.php");
include("functions.php");

$usrSQL = mysqli_query($conn, "SELECT id,school,class FROM users WHERE id='".$_SESSION['id']."' and isAdmin=2 and status=1");
$usrrow = mysqli_fetch_array($usrSQL, MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $option = $_POST['opt'];
    $quesID = $_POST['ques'];

if(!empty($quesID)) {
    $chkSQL = mysqli_query($conn, "SELECT id,correct_ans FROM count_quest WHERE id='".$quesID."'");
    $chkrow = mysqli_fetch_array($chkSQL, MYSQLI_ASSOC);

    $chkQuesid_rslt = mysqli_query($conn, "SELECT class,subject,topic,subtopic FROM count_quest WHERE id='".$quesID."'");
    $chkQuesid_qury = mysqli_fetch_array($chkQuesid_rslt, MYSQLI_ASSOC); 

    if(!isset($SESSION['num_ques'. $chkQuesid_qury['subtopic']])) {
        $SESSION['num_ques'. $chkQuesid_qury['subtopic']] = 0;
    }

    $SESSION['num_ques'. $chkQuesid_qury['subtopic']]++;


    if(!empty($_SESSION['id'])) {
    if ($chkrow['correct_ans'] == $option) {
        $pts = $_SESSION["correct-pts"];

        if(isset($_SESSION['power-up'])) {
            $answerTime = time();

            $_SESSION['normal-points'] += $pts;
            if(isset($_SESSION['question-time']) && $answerTime - $_SESSION['question-time'] <= $_SESSION['minimum-time']) {
                $pts = $_SESSION['correct-pts'] * $_SESSION['score-multiplier'];

                $_SESSION['booster-points'] += $pts;
            }
        }

        $chkProSQL = mysqli_query($conn, "SELECT questions_practiced, proficiency_level FROM user_proficiency WHERE userid = '". $_SESSION['id'] . "' AND subtopic_id = '". $chkQuesid_qury['subtopic'] ."'");

        if(mysqli_num_rows($chkProSQL) == 0) {
            mysqli_query($conn, "INSERT INTO user_proficiency (userid, subtopic_id, questions_practiced, proficiency_level, updated_at) VALUES ('". $_SESSION['id'] ."', '". $chkQuesid_qury['subtopic'] ."', 1, 0, NOW())");
        } else {
            $proficiency = 0;
            $proficiency_label = "";
            $flag_pro = false;
            $chkProRow = mysqli_fetch_assoc($chkProSQL);

            $proficiency_sql = mysqli_query($conn, "SELECT id,name, icon FROM proficiency_levels WHERE minimum_questions = '". ($chkProRow['questions_practiced'] + 1) . "'");

            if(mysqli_num_rows($proficiency_sql) > 0) {
                $proficiency_row = mysqli_fetch_assoc($proficiency_sql);
                mysqli_query($conn, "UPDATE user_proficiency SET proficiency_level = '". $proficiency_row['id'] ."' WHERE userid = '". $_SESSION['id'] . "' AND subtopic_id = '". $chkQuesid_qury['subtopic'] ."'");
                ?>
                    <script>
                        $(document).ready(function(){
                            <?php if($proficiency_row['id'] == 3) { ?> 
                                setTimeout(() => {
                                    $('#levelUpModal').modal('show');
                                }, 1750); 
                            <?php } else { ?> 
                                setTimeout(() => showToast({ title: 'Skill Up!', content: 'You are now a <?php echo $proficiency_row['name']; ?> for this subtopic.', imgBanner: '<?php echo $proficiency_row['icon']; ?>' }), 1000);    
                            <?php } ?>
                        });
                    </script>
                <?php
            }

            mysqli_query($conn, "UPDATE user_proficiency SET questions_practiced = questions_practiced + 1 WHERE userid = '". $_SESSION['id'] . "' AND subtopic_id = '". $chkQuesid_qury['subtopic'] ."'");

        }

        $correct = $option;
        $wrong = "NULL";
        $_SESSION['correct-streak']++;

        if($pts != 0 ) {
        ?>
            <script>
                $(document).ready(function(){
                    showToast({ title: 'Congratulations!', content: 'You have scored +<?php echo $pts ?> points', imgBanner: 'correct.png' });
                });
            </script>
        <?php
        } else {
            ?>
            <script>
                $(document).ready(function(){
                    showToast({ title: 'Congratulations!', content: 'You have answered correctly!', imgBanner: 'correct.png' });
                });
            </script>
        <?php
        }

        if($pts !== 0) {
            $streakSQL = mysqli_query($conn, "SELECT b.id, bc.minimum_questions, b.booster_icon 
                                            FROM booster_criteria bc 
                                            JOIN boosters b 
                                            ON bc.booster = b.id
                                            WHERE bc.minimum_questions > 0");

            $streakFlag = false;
            
            while($streakRow = mysqli_fetch_assoc($streakSQL)) {
                if(intval($streakRow['minimum_questions']) > 0 && $_SESSION['correct-streak'] == intval($streakRow['minimum_questions'])) {
                    $streakFlag = true;
                ?>
                    <script>
                        $(document).ready(function(){
                            $.ajax({
                                type: "post",
                                url: "<?php echo $baseurl ?>ajax/addBooster",
                                data: {
                                    b_id: <?php echo $streakRow['id']; ?>
                                },
                                success: function(res) {
                                    var response =JSON.parse(res);

                                    if(response.status == "success") {
                                        setTimeout(() => showToast({ title: 'Congratulations!', imgBanner: '<?php echo $streakRow['booster_icon']; ?>', content: 'You have unlocked a booster!.' }), 500);
                                        getBoosterCount();
                                        var toggleContainer = document.querySelector('.toggle-container');
                                        shakeElement(toggleContainer, 2000);
                                    }
                                }
                            })
                        });
                    </script>
                <?php
                } 
            }   
            
            if(!$streakFlag) {
                ?>
                    <script>
                        $(document).ready(function(){
                            setTimeout(() => showToast({ title: 'Question Streak', content: 'You are on streak <?php echo $_SESSION['correct-streak'] ?>', imgBanner: 'streak.svg' }), 500);
                        });
                    </script>
                <?php
            }
        }
    } else {
        $correct = "NULL";
        $wrong = $option;
        $pts = - ($_SESSION["wrong-pts"]);

        if(isset($_SESSION['power-up'])) {
            $answerTime = time();

            $_SESSION['normal-points'] += $pts;
            if(isset($_SESSION['question-time']) && $answerTime - $_SESSION['question-time'] <= $_SESSION['minimum-time']) {
                $pts = - ($_SESSION["wrong-pts"] * $_SESSION['incorrect-score-multiplier']);

                $_SESSION['booster-points'] += $pts;
            }
        }

        if($pts != 0) {
            ?>
                <script>
                    $(document).ready(function(){
                        showToast({ title: 'Oops!', content: 'You have lost <?php echo abs($pts) ?> point(s)', imgBanner: 'wrong.png' });
                    });
                </script>
            <?php

            if($_SESSION['correct-streak'] > 0) {
                ?>
                <script>
                    $(document).ready(function(){
                        setTimeout(() => showToast({ title: 'Oh No!', content: 'You have lost your streak', imgBanner: 'anti-streak.svg' }), 500);
                    });
                </script>
                <?php
            }
            $_SESSION["correct-streak"] = 0;
        } else {
            ?>
            <script>
                $(document).ready(function(){
                    showToast({ title: 'Oops!', content: 'You have answered incorrectly!', imgBanner: 'wrong.png' });
                });
            </script>
        <?php
        }
    }

    ?>
        
    <?php
    $currentDateTime = date('Y-m-d H:i:s'); 
    $time_taken = time() - $_SESSION['leaderboard_time'];


    mysqli_query( $conn, "INSERT INTO leaderboard(userid,class,subject,topic,subtopic,school,user_class,question,correct,wrong,created_at,scorecard, time_taken) VALUES ('".$_SESSION['id']."','".$chkQuesid_qury['class']."','".$chkQuesid_qury['subject']."','".$chkQuesid_qury['topic']."','".$chkQuesid_qury['subtopic']."','".$usrrow['school']."','".$usrrow['class']."','".$quesID."','".$correct."','".$wrong."','".$currentDateTime ."','$pts', '$time_taken')");
    
    //$leaderSQL = mysqli_query($conn, "SELECT question FROM leaderboard WHERE userid='".$_SESSION['id']."' and id='".$conn->insert_id."' order by id desc");
   // $leaderrow = mysqli_fetch_array($leaderSQL, MYSQLI_ASSOC);
    }

    $_SESSION['quesID'] = $quesID;
    
    
  } 
}

$chkQuesid_rslt = mysqli_query($conn, "SELECT class,subject,topic,subtopic FROM count_quest WHERE id='".$quesID."'");
    $chkQuesid_qury = mysqli_fetch_array($chkQuesid_rslt, MYSQLI_ASSOC);

$chkShortlistSQL = mysqli_query($conn, "SELECT * FROM shortlist_questions WHERE question_id = '". $quesID ."' AND user_id = '". $_SESSION['id'] ."'");
$chkShortlistrow = mysqli_fetch_assoc($chkShortlistSQL);

$sbtpcSQL = mysqli_query($conn, "SELECT id,parent,subtopic FROM topics_subtopics WHERE id='".$chkQuesid_qury['subtopic']."' and parent!=0 and status=1");
$sbtpcrow = mysqli_fetch_array($sbtpcSQL, MYSQLI_ASSOC);

      $queSQL = mysqli_query($conn, "SELECT id,question,opt_a,opt_b,opt_c,opt_d,type,type1,correct_ans,shape_info,subtopic,type2 FROM count_quest WHERE id =".$quesID." and status=1");
    $querow = mysqli_fetch_array($queSQL, MYSQLI_ASSOC);
                            
                            $resulSQL = mysqli_query($conn, "SELECT correct,wrong FROM leaderboard WHERE question='".$quesID."' and userid=".$_SESSION['id']."");
                            $resulrow = mysqli_fetch_array($resulSQL, MYSQLI_ASSOC); 

                            if(empty($_SESSION['id']) && $chkrow['correct_ans'] !== $option) {
                                $resulrow['correct'] = "NULL";
                                $resulrow['wrong'] = $option;
                            }  else if(empty($_SESSION['id']) && $chkrow['correct_ans'] == $option) {
                                $resulrow['correct'] = $option;
                                $resulrow['wrong'] = "NULL";
                            }

                            $super_id = $sbtpcrow['id'];
                            if($super_id == '263') {
                                $sbtpcrow['id'] = $querow['shape_info'];
                            } 

                            if($querow['type2'] == 'p1' || $querow['type2'] == 'q1') {
                                $resizeTxt = 'resizeTxt';
                            } else if($querow['subtopic'] =='51') {
                                $resizeTxt = 'txtresize';    
                            } else {
                                $resizeTxt = 'txtresize';
                            }
                            
                            if($resulrow['correct'] != 'NULL') {
                                $status = "<img class='grow' src='".$baseurl."assets/images/correct.png' width='313' height='313' alt='correct'>";
                            } else {
                                $status = "<img class='grow' src='".$baseurl."assets/images/wrong.png' width='313' height='313' alt='wrong'>";
                            }
                            
                            include("components/dyn_cond.php");
                            include("components/dyn_ques.php");

                            $sound_file = '';
                            $path = './assets/sounds/';

                            if($correct !== 'NULL') {
                                $path = $path . 'correct/';
                            } else  {
                                $path = $path . 'wrong/';
                            }
  
                            if (is_dir($path)) {
                                $files = array_diff(scandir($path), array('..', '.'));
                                
                                if ($files) {
                                    $randomFileIndex = array_rand($files);
                                    $sound_file = $files[$randomFileIndex];
                                }
                            } else {
                                echo "The specified directory does not exist.";
                            }

                            ?>

<audio id="audioPlayer" autoplay>
  <source src="<?php echo $baseurl . $path . $sound_file; ?>" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>

<ul class="options multi-btn rslt_ul <?php echo $quesCls.$stlCls; ?>">
                                <li>
                                    <div class="check-btn ">
                                        <input class="form-check-input" type="radio" name="" id="opt_1" readonly>
                                        <div class="label-wrapper <?php echo $optCls.$optA.$stloptCls; if($querow['type2'] == 'p1' && $querow['correct_ans'] == 1) { echo 'right-ans'; } elseif($querow['type2'] == 'p1' && $resulrow['wrong'] == 1) { echo 'wrong-ans'; } ?>"><label for="opt_1"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_opta.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="" id="opt_2" readonly>
                                        <div class="label-wrapper <?php echo $optCls.$optB.$stloptCls; if($querow['type2'] == 'p1' && $querow['correct_ans'] == 2) { echo 'right-ans'; } elseif($querow['type2'] == 'p1' && $resulrow['wrong'] == 2) { echo 'wrong-ans'; } ?> ?>"><label for="opt_2"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_optb.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="" id="opt_3" readonly>
                                        <div class="label-wrapper <?php echo $optCls.$optC.$stloptCls; if($querow['type2'] == 'p1' && $querow['correct_ans'] == 3) { echo 'right-ans'; } elseif($querow['type2'] == 'p1' && $resulrow['wrong'] == 3) { echo 'wrong-ans'; } ?> ?>"><label for="opt_3"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_optc.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="" id="opt_4" readonly>
                                        <div class="label-wrapper <?php echo $optCls.$optD.$stloptCls; if($querow['type2'] == 'p1' && $querow['correct_ans'] == 4) { echo 'right-ans'; } elseif($querow['type2'] == 'p1' && $resulrow['wrong'] == 4) { echo 'wrong-ans'; } ?> ?>"><label for="opt_4"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_optd.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <!-- <div id="overlay" class="overlay"><?php echo $status; ?></div> -->
                                <script>
                                    const audioElement = document.getElementById("audioPlayer");

                                    audioElement.volume = 0.7;
                                    audioElement.play();

//                                     setTimeout(() => {
//   const box = document.getElementById('overlay');

//   // 👇️ hides element (still takes up space on the page)
//   box.style.visibility = 'hidden';
// }, 500);
                                </script>
                            </ul>
                            <?php if($limitMsg == '') { ?>
                                <div class="text-center mt-md-4 mt-3 mb-4 mob-footer-fixed">
                                <span class="w-100 text-start" <?php if(empty($_SESSION['id'])) {
                                echo 'style="display:none"';
                            } ?>>
                                <button class="btn btn-dark btn-animated btn-lg" onclick="goToPrevQuestion(event)">Prev</button>
                            </span>
                            <span class="w-100 ps-2">
                                    <input type="submit" name="next" class="btn btn-orange btn-animated btn-lg mw-200" value="Next">
                                    </span>
                            <div class="w-100 text-end display-flex desktop-none">

                            
                            <?php if($limitMsg == '') { ?>
                                <?php
                                $quesposquery = mysqli_query($conn, "SELECT id FROM count_quest WHERE class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."' and id > '".$ordrow['question']."' or class='".$clsrow['id']."' and subject='".$sbjrow['id']."' and topic='".$tpcrow['id']."' and subtopic='".$super_id."' and id = '".$_SESSION['quesID']."'");
                                $quesposrslt = mysqli_fetch_array($quesposquery, MYSQLI_ASSOC);
                                ?>
                            <div class="text-center d-inline-block ms-1 me-2 submitReport">    
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#reportModal" class="link reportques" data-id="<?php echo $quesID; ?>" <?php if(empty($_SESSION['id'])) { echo "style='visibility: hidden;'"; } ?>><span class="d-block"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12.3787 2.07239L1.37866 21.0724H23.3787M12.3787 6.07239L19.9087 19.0724H4.84866M11.3787 10.0724V14.0724H13.3787V10.0724M11.3787 16.0724V18.0724H13.3787V16.0724" fill="black"/>
</svg></span></a></div>

<div class="text-center d-inline-block ms-1 me-2 submitRequest">    
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#requestModal" class="link requestques" data-id="<?php echo $quesID; ?>" <?php if(empty($_SESSION['id'])) { echo "style='visibility: hidden;'"; } ?>><span class="d-block"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12.3787 2.07239L1.37866 21.0724H23.3787M12.3787 6.07239L19.9087 19.0724H4.84866M11.3787 10.0724V14.0724H13.3787V10.0724M11.3787 16.0724V18.0724H13.3787V16.0724" fill="black"/>
</svg></span></a></div>


<div class="submitReport text-center d-inline-block">
                                <?php if(!isset($chkShortlistrow["id"])) { ?>
                                    <a href="#" class="link reportques" onclick="setShortlistMobile(event)" data-id="<?php echo $quesID; ?>" <?php if(empty($_SESSION['id'])) { echo "style='visibility: hidden;'"; } ?>>
                                    <span class="d-block">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>
</span>
</a>
                                    <?php } else {
                                        ?>
                                    <a href="#" class="link reportques" onclick="removeShortlistMobile(event)" data-id="<?php echo $quesID; ?>" <?php if(empty($_SESSION['id'])) { echo "style='visibility: hidden;'"; } ?>><span class="d-block">

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
                            <?php } else { ?>
                                <div id="limitModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="limitLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body popup-text">
            <div class="text-end">
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
</svg>
</button>
                            </div>
            <?php echo $limitMsg; ?>
            </div>
        </div>
    </div>
</div>
                                <?php } ?>