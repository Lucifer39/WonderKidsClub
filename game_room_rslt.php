<?php
include("config/config.php");
include("functions.php");

$usrSQL = mysqli_query($conn, "SELECT id,school,class FROM users WHERE id='".$_SESSION['id']."' and isAdmin=2 and status=1");
$usrrow = mysqli_fetch_array($usrSQL, MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $option = $_POST['opt'];
    $quesID = $_POST['ques'];
    $room_id = $_POST['room-code'];

if(!empty($quesID)) {
    $chkSQL = mysqli_query($conn, "SELECT id,correct_ans FROM count_quest WHERE id='".$quesID."'");
    $chkrow = mysqli_fetch_array($chkSQL, MYSQLI_ASSOC);

    if ($chkrow['correct_ans'] == $option) {
        $correct = $option;
        $wrong = "NULL";

            $fullmarks = 10;
            $getStartTimeSQL = mysqli_query($conn, "SELECT start_time FROM battle_room_questions WHERE room_id = '$room_id' AND ques_id = '$quesID'");
            $getStartTimeRes = mysqli_fetch_assoc($getStartTimeSQL);

            function calculatePercentageAnswer($startTimestamp) {
                // Convert the startTimestamp to a DateTime object
                $startTime = new DateTime($startTimestamp);
            
                // Get the current time as a DateTime object
                $currentTime = new DateTime();
            
                // Calculate the interval between start time and current time
                $interval = $currentTime->diff($startTime);
            
                // Calculate the elapsed time in seconds
                $elapsedTimeInSeconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
            
                // Define the threshold times and corresponding percentages
                $thresholds = [30, 40, 50, 60];
                $percentages = [1, 0.75, 0.5, 0.25];
            
                // Initialize the percentage
                $percentage = 0;
            
                // Find the appropriate percentage based on the elapsed time
                foreach ($thresholds as $key => $threshold) {
                    if ($elapsedTimeInSeconds <= $threshold) {
                        $percentage = $percentages[$key];
                        break;
                    }
                }
            
                return $percentage;
            }

            $result = intval($fullmarks * calculatePercentageAnswer($getStartTimeRes['start_time']));

            mysqli_query($conn, "UPDATE battle_room_players SET score = score + $result WHERE room_id = '$room_id' AND user_id = '". $_SESSION['id'] ."'");
        
            ?>
                <script>
                    showToast({title: "Correctly updated", content: "Score updated"});
                </script>
            <?php

    } else {
        $correct = "NULL";
        $wrong = $option;

        mysqli_query($conn, "UPDATE battle_room_players SET score = score - 2 WHERE room_id = '$room_id' AND user_id = '". $_SESSION['id'] ."'");

        ?>
        <script>
            showToast({title: "Incorrectly updated", content: "Score updated"});
        </script>
    <?php
    }

    ?>
        <script>
            $(document).ready(function() {
                socket.send('leaderboard');
            });
        </script>
    <?php

    $currentDateTime = date('Y-m-d H:i:s');

    $chkQuesid_rslt = mysqli_query($conn, "SELECT class,subject,topic,subtopic FROM count_quest WHERE id='".$quesID."'");
    $chkQuesid_qury = mysqli_fetch_array($chkQuesid_rslt, MYSQLI_ASSOC);  
    
    //$leaderSQL = mysqli_query($conn, "SELECT question FROM leaderboard WHERE userid='".$_SESSION['id']."' and id='".$conn->insert_id."' order by id desc");
   // $leaderrow = mysqli_fetch_array($leaderSQL, MYSQLI_ASSOC);

    $_SESSION['quesID'] = $quesID;
    
  } 
}

$chkQuesid_rslt = mysqli_query($conn, "SELECT class,subject,topic,subtopic FROM count_quest WHERE id='".$quesID."'");
    $chkQuesid_qury = mysqli_fetch_array($chkQuesid_rslt, MYSQLI_ASSOC);

$sbtpcSQL = mysqli_query($conn, "SELECT id,parent,subtopic FROM topics_subtopics WHERE id='".$chkQuesid_qury['subtopic']."' and parent!=0 and status=1");
$sbtpcrow = mysqli_fetch_array($sbtpcSQL, MYSQLI_ASSOC);

      $queSQL = mysqli_query($conn, "SELECT id,question,opt_a,opt_b,opt_c,opt_d,type,type1,correct_ans,shape_info,subtopic,type2 FROM count_quest WHERE id =".$quesID." and status=1");
    $querow = mysqli_fetch_array($queSQL, MYSQLI_ASSOC);
                            
                            // $resulSQL = mysqli_query($conn, "SELECT correct,wrong FROM leaderboard WHERE question='".$quesID."' and userid=".$_SESSION['id']."");
                            // $resulrow = mysqli_fetch_array($resulSQL, MYSQLI_ASSOC); 

                            $resulrow = array("correct" => $correct, "wrong" => $wrong);

                            if($querow['type2'] == 'p1' || $querow['type2'] == 'q1') {
                                $resizeTxt = 'resizeTxt';
                            } else if($querow['subtopic'] =='51') {
                                $resizeTxt = 'txtresize';    
                            } else {
                                $resizeTxt = 'txtresize';
                            }

                            $super_id = $sbtpcrow['id'];
                            if($super_id == '263') {
                                $sbtpcrow['id'] = $querow['shape_info'];
                            } 

                            include("components/dyn_cond.php");
                            include("components/dyn_ques.php");
                            ?>

<ul class="options multi-btn <?php echo $quesCls.$stlCls; ?>">
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
                            </ul>
                            <?php if($limitMsg == '') { ?>
                                <div class="text-center mt-md-4 mt-3 mb-4 mob-footer-fixed">
                                <div class="w-100 text-start desktop-none">
                            <input type="submit" name="" class="btn btn-dark btn-animated btn-lg" value="PREV" style="visibility:hidden">
                            </div>
                            <div class="w-100 ps-2">
                                    <!-- <input type="submit" name="next" class="btn btn-orange btn-animated btn-lg mw-200" value="Next"> -->
                                    </div>
                            <div class="w-100 text-end me-2 desktop-none">

                            
                            <div class="submitReport text-center d-inline-block">
                                <!-- TODO: leaderboard mobile -->
                                <div class="p-1">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#battleLeaderboardModal"><img src="<?php echo $baseurl; ?>assets/images/leaderboard_battle.svg" alt="leaderboard icon" width="30" height="30"></a>
                                </div>
                            </div>
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