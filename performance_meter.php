<?php
include("config/config.php");
include("functions.php");

session_start();

$usrSQL = mysqli_query($conn, "SELECT id,school,class FROM users WHERE id='".$_SESSION['id']."' and isAdmin=2 and status=1");
$usrrow = mysqli_fetch_array($usrSQL, MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $option = $_POST['opt'];
    $quesID = $_POST['ques'];

    $_SESSION['quesID'] = $quesID;
    
  } 
    $ques_qury = mysqli_query($conn, "SELECT id,class,subject,topic,subtopic FROM count_quest WHERE id='".$_SESSION['quesID']."'");
    $ques_rslt = mysqli_fetch_array($ques_qury, MYSQLI_ASSOC);


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

?>
<div class="score-widget">
                                <div class="heading heading-main bg-blue text-center">Performance Meter</div>
                                <div class="smart-score w-100">
                                    
                                <?php
                                    $uptoSQL = mysqli_query($conn, "SELECT COUNT(a.question) as ques_count FROM leaderboard as a, users as b WHERE b.id=a.userid and a.subtopic='".$ques_rslt['subtopic']."' and a.userid='".$usrrow['id']."'");
                                    $uptorow = mysqli_fetch_array($uptoSQL, MYSQLI_ASSOC); 

                                ?>
                                    <div class="title txt-orange text-center">Accuracy upto Q. No. <?php echo $uptorow['ques_count']; ?></div>
                                    <div class="lg-txt">
                                <?php
                                    $queswiseSQL = "SELECT a.userid, COUNT(a.correct) as correct_answers FROM leaderboard as a, users as b WHERE b.id=a.userid and a.question <= '".$_SESSION['quesID']."' and a.subtopic='".$ques_rslt['subtopic']."' and a.userid='".$usrrow['id']."' and a.correct != 'NULL'";
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
                                            ?>
                                    
                                    </div>
                                </div>
                                <div class="heading bg-pink flex-1">
                                    <span>Overall Rank</span>
                                    <?php 
                                    $correctSQL = "SELECT a.userid, SUM(a.scorecard) as correct_answers FROM leaderboard as a, users as b WHERE b.id=a.userid and b.class='".$usrrow['class']."' and a.subtopic='".$ques_rslt['subtopic']."' and a.class = '" . $usrrow['class'] . "' and b.id IN ($eligibleIds)  GROUP BY a.userid ORDER BY correct_answers desc";
                                    $result = mysqli_query($conn, $correctSQL); ?>
                                    
                                    <span>
                                        <?php //$rank = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $users[] = $row['userid'];
                                            $answers[] = $row['correct_answers'];
                                            //if ($usrrow['id'] == $row['userid']) {
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
                                                //if($usrrow['id'] ==  $users[$rank]) {
                                               // 
                                               foreach ($answers as $user => $user_answer) {
                                                   if ($user_answer == $answer) {
                                                    if($usrrow['id'] ==  $users[$user]) {
                                                     // echo "user  $users[$user]";
                                                      echo "$rank";
                                                      
                                                      if($practicenotifchk["enable"] == 1) {
                                                        if(!empty($usrrow["overall_rank"])) {
                                                            $text = "";
                                                            if($usrrow["overall_rank"] != 1 && $rank == 1){
                                                                $text = "Congrats! You just became topper across all students for this subtopic.";
                                                            }
                                                            else if($usrrow["overall_rank"] > 3 && $rank <= 3 && $rank > 1) {
                                                                $text = "Congrats! You just came in top-3 across all students for this subtopic.";
                                                            }
                                                            else if($usrrow["overall_rank"] == 1 && $rank > 1 && $rank < 3) {
                                                                $text = "Oops! You were just overtaken by someone across schools. Practice more, and get your 1st rank back.";
                                                            }
                                                            else if($usrrow["overall_rank"] <= 3 && $rank > 3) {
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

                                                        $usrrow["overall_rank"] = $rank;
                                                      }
                                                    }
                                                }
                                               }
                                      // }
                                                $rank += $count;
                                            }

                                            $correctSQL = "SELECT a.userid, SUM(a.scorecard) as correct_answers FROM leaderboard as a, users as b WHERE b.id=a.userid and b.class='".$usrrow['class']."' and a.subtopic='".$ques_rslt['subtopic']."' and a.userid='".$usrrow['id']."' and a.class = '" . $usrrow['class'] . "'  GROUP BY a.userid ORDER BY correct_answers desc";
                                            $result = mysqli_query($conn, $correctSQL);
                                            $chkoverCnt = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                            if(empty($chkoverCnt['userid'])) { echo "<span class='d-inline' data-bs-toggle='tooltip' data-bs-placement='top' title='Questions of other classes are not eligible for ranking'>N/A</span>"; }
                                            
                                             ?>
                                            </span>
                                </div>
                                <div class="heading bg-orange flex-1">
                                    <span>School Rank <span class="tab-none">(Classwise)</span></span>
                                    <span><?php
                                    $schwiseSQL = "SELECT a.userid, SUM(a.scorecard) as correct_answers FROM leaderboard as a, users as b WHERE b.id=a.userid and b.class='".$usrrow['class']."' and b.school='".$usrrow['school']."' and a.subtopic='".$ques_rslt['subtopic']."' and a.class = '" . $usrrow['class'] . "' and b.id IN ($eligibleIds)  GROUP BY a.userid ORDER BY correct_answers desc";
                                    $schwiseresult = mysqli_query($conn, $schwiseSQL); ?>
                                    
                                    <span>
                                        <?php //$rank = 1;
                                        while ($schwiserow = mysqli_fetch_assoc($schwiseresult)) {
                                            $usrs[] = $schwiserow['userid'];
                                            $ans[] = $schwiserow['correct_answers'];
                                            //if ($usrrow['id'] == $row['userid']) {
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
                                                //if($usrrow['id'] ==  $users[$rank]) {
                                               // 
                                               foreach ($ans as $user => $user_answer) {
                                                   if ($user_answer == $answer) {
                                                    if($usrrow['id'] ==  $usrs[$user]) {
                                                     // echo "user  $users[$user]";
                                                      echo "$ranks";

                                                      if($practicenotifchk["enable"] == 1) {
                                                      if(!empty($usrrow["school_rank"])) {
                                                        $texts = "";
                                                        if($usrrow["school_rank"] != 1 && $ranks == 1){
                                                            $texts = "Congrats! You just became topper in your school for this subtopic.";
                                                        }
                                                        else if($usrrow["school_rank"] > 3 && $ranks <= 3 && $ranks > 1) {
                                                            $texts = "Congrats! You just came in top-3 in your school for this subtopic.";
                                                        }
                                                        else if($usrrow["school_rank"] == 1 && $ranks > 1 && $ranks < 3) {
                                                            $texts = "Oops! You were overtaken by someone from your school. Practice more, and get your 1st rank back.";
                                                        }
                                                        else if($usrrow["school_rank"] <= 3 && $ranks > 3) {
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

                                                      $usrrow["school_rank"] = $ranks;
                                                    }
                                                    }
                                                }
                                               }
                                      // }
                                                $ranks += $count;
                                            }

                                            $schwiseSQL = "SELECT a.userid, SUM(a.scorecard) as correct_answers FROM leaderboard as a, users as b WHERE b.id=a.userid and b.class='".$usrrow['class']."' and b.school='".$usrrow['school']."' and a.subtopic='".$ques_rslt['subtopic']."' and a.class = '" . $usrrow['class'] . "' and a.userid='".$usrrow['id']."'  GROUP BY a.userid ORDER BY correct_answers desc";
                                            $schwiseresult = mysqli_query($conn, $schwiseSQL); 
                                            $chkschCnt = mysqli_fetch_array($schwiseresult, MYSQLI_ASSOC);
                                            if(empty($chkschCnt['userid'])) { echo "<span class='d-inline' data-bs-toggle='tooltip' data-bs-placement='top' title='Questions of other classes are not eligible for ranking'>N/A</span>"; }
                                            
                                            ?></span>
                                </div>
                            </div>