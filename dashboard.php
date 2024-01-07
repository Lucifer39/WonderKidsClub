<?php 
include("config/config.php");
include("functions.php");

if (empty($_SESSION['id']) && empty($_SESSION['guest-class'])) {
    header('Location:' . $baseurl);
    exit;
}

if(isset($_SESSION['assign_topic'])) {
    header('Location:'.$baseurl.'fastest');
    exit();
}

include("dynamic/ques_session.php");
#header('Location: ' . $_SERVER['REQUEST_URI']);

$sessionsql = mysqli_query($conn, "SELECT isAdmin,fullname,school,class,avatar FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if(empty($_SESSION['id'])) {
    $sessionrow['class'] = $_SESSION['guest-class'];
}

$clsSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE id='".$sessionrow['class']."' and type=2 and status=1");
$clsrow = mysqli_fetch_array($clsSQL, MYSQLI_ASSOC);

$schSQL = mysqli_query($conn, "SELECT id,name FROM school_management WHERE id='".$sessionrow['school']."' and status=1");
$schrow = mysqli_fetch_array($schSQL, MYSQLI_ASSOC);

$usrSQL = mysqli_query($conn, "SELECT id,school,class FROM users WHERE id='".$_SESSION['id']."' and isAdmin=2 and status=1");
$usrrow = mysqli_fetch_array($usrSQL, MYSQLI_ASSOC);

$aboutSQL = mysqli_query($conn, "SELECT bio, adjectives FROM student_about WHERE student_id = '".$_SESSION['id']."'");
$aboutrow = mysqli_fetch_array($aboutSQL, MYSQLI_ASSOC);

$chkLevelSql = mysqli_query($conn, "SELECT COUNT(*) AS level FROM user_proficiency up
                                    JOIN topics_subtopics ts ON up.subtopic_id = ts.id
                                    WHERE up.userid = '".$_SESSION['id']."'
                                    AND ts.class_id = '".$sessionrow['class']."'
                                    AND up.proficiency_level = 3");

$chkLevelRow = mysqli_fetch_assoc($chkLevelSql);

$cntSbtpSql = mysqli_query($conn, "SELECT COUNT(*) AS total_levels FROM topics_subtopics
                                    WHERE class_id = '".$sessionrow['class']."'
                                    AND status = 1
                                    AND parent != 0");
$cntSbtpRow = mysqli_fetch_assoc($cntSbtpSql);

$levlSql = mysqli_query($conn, "SELECT up.userid, COUNT(up.subtopic_id) AS level
                                FROM user_proficiency up
                                JOIN topics_subtopics ts ON up.subtopic_id = ts.id
                                JOIN users u ON up.userid = u.id
                                WHERE up.proficiency_level = 3
                                AND ts.class_id = '".$sessionrow['class']."'
                                AND u.class = '".$sessionrow['class']."'
                                GROUP BY up.userid
                                HAVING COUNT(up.subtopic_id) = (
                                    SELECT COUNT(up1.subtopic_id)
                                    FROM user_proficiency up1
                                    JOIN topics_subtopics ts1 ON up1.subtopic_id = ts1.id
                                    WHERE up1.userid = '".$_SESSION['id']."'
                                    AND up1.proficiency_level = 3
                                    AND ts1.class_id = '".$sessionrow['class']."'
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
            AND tp1.class_id = '".$sessionrow['class']."'
        ) 
        AND tp.class_id = '".$sessionrow['class']."' ) )
    AND u.class =  '".$sessionrow['class']."'");
}
                                
$elgibleArr = array();
$lvl = 0;
while($lvlRow = mysqli_fetch_assoc($levlSql)) {
    $elgibleArr[] = $lvlRow['userid'];
    $lvl = $lvlRow['level'];
}

$eligibleIds = implode(", ", $elgibleArr);

if($sessionrow['isAdmin'] == '2' || empty($_SESSION['id'])) {
?>
<?php include("header.php");?>
<section class="section pb-0 student-dashboard">
    <div class="container pb-4">
    <div class="row">
        <div class="col-md-12">
        <div class="blk-widget-inner singleUser">
            <div class="header-widget">
                <div class="d-flex">

                <?php if(!isset($get_student["avatar"])){ ?>
                    <img class="featured" src="assets/images/profile.jpg" width="100" height="100" alt="">
                <?php }else{ ?>
                    <img class="featured" src="<?php echo $baseurl; ?>assets/images/avatars/<?php echo $get_student["avatar"]; ?>" width="100" height="100" alt="">
                <?php } ?>
                    <div class="header-widget-user">
                    <h2><?php echo $sessionrow['fullname'] ?? "Guest"; ?></h2>
                    <h5><?php echo $clsrow['name'];?></h5>
                    <h5><?php echo $schrow['name'] ?? "N/A"; ?></h5>
                    <div class="level-text">LEVEL <?php echo $chkLevelRow['level']; ?></div>
                    </div>
                </div>
                <div class="header-widget-about ps-2">

                    <?php if(isset($aboutrow['bio']) && isset($aboutrow['adjectives'])){ ?>
                    <h4>My Traits</h4>
                    <div class="mt-2 ps-2">
                        <h5><?php 
                            $words = explode(",", $aboutrow["adjectives"]); // Split the string by comma and space

                            $niceHexColors = array(
                                "#FF5733",
                                "#3498DB",
                                "#2ECC71",
                                "#FFA500",
                                "#9B59B6",
                                "#FF6B81",
                                "#8B4513",
                                "#00BCD4",  // Cyan
                                "#FFD700",  // Gold
                                "#FF6347",  // Tomato
                                "#40E0D0",  // Turquoise
                                "#9932CC",  // Dark Orchid
                                "#FF1493",  // Deep Pink
                                "#1E90FF",  // Dodger Blue
                                "#228B22",  // Forest Green
                                "#DC143C",  // Crimson
                                "#4B0082",  // Indigo
                                "#800000",  // Maroon
                                "#008080",  // Teal
                                "#FF8C00",  // Dark Orange
                                "#7B68EE",  // Medium Slate Blue
                            );

                            shuffle($niceHexColors);
                            $colour_count = 0;
                            
                            foreach ($words as &$word) {
                                $color = $niceHexColors[$colour_count % count($niceHexColors)];
                                if (!empty($word)) {
                                    $word = '<span style="color: '.$color.';"><b>' . trim($word)[0] . '</b>' . substr(trim($word), 1) . '</span>';
                                }
                                $colour_count++;
                            }
                            
                            $newString = implode(", ", $words); // Join the modified words back together
                            
                            echo $newString;
                        ?></h5>
                        <h4 class="mt-4">Know Me</h4>
                        <h5><?php 
                            $words = explode(" ", $aboutrow['bio']);

                            $colour_count = 0;
                            
                            foreach ($words as &$word) {
                                $color = $niceHexColors[$colour_count % count($niceHexColors)];
                                if (!empty($word)) {
                                    $word = '<span style="color: '.$color.';"><b>' . trim($word)[0] . '</b>' . substr(trim($word), 1) . '</span>';
                                }
                                $colour_count++;
                            }
                            
                            $newString = implode(" ", $words); // Join the modified words back together
                            
                            echo $newString;
                        ?></h5>
                    </div>
                    <?php } else {

                        if(!empty($_SESSION['id'])) {
                        ?>

                            <a href="chatbot/" class="p-0 pt-1">

                        <?php } else { ?>
                            <a href="#login" data-bs-toggle="modal" data-bs-target="#loginModal" class="p-0 pt-1">
                       <?php } ?>

                                <div class="dot"></div><div class="update-profile-info"> <b style="font-size: 1.25rem;"> <?php echo (isset($aboutrow['bio']) || isset($aboutrow['adjectives'])) ? "Complete" : "Update"; ?> Profile <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
</svg>              </b>             <div>  Update <?php if(!isset($sessionrow['avatar'])) { ?> "Your Avatar", <?php } if(!isset($aboutrow['bio'])) { ?> "Know About Me", <?php } if(!isset($aboutrow['adjectives'])) { ?> "Best Adjectives to Describe me" <?php } ?> using our Wonderbot!
                    </div></div></a>
                        
                        <?php
                    } ?>
                </div>
            </div>
                <div class="footer-widget">
                                        <div>Overall Rank

                                        <span><?php
$correctSQL = "SELECT a.userid, SUM(a.scorecard) AS correct_answers, ROUND(AVG(a.time_taken), 1) AS average_time_taken FROM leaderboard as a, users as b WHERE b.id=a.userid and b.class='" . $usrrow['class'] . "' and a.class = '" . $usrrow['class'] . "' and b.id IN ($eligibleIds)  GROUP BY a.userid ORDER BY correct_answers DESC, average_time_taken ASC";
$result = mysqli_query($conn, $correctSQL);

$users = [];
$answers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row['userid'];
    $answers[] = $row['correct_answers'];
}

$counts = array_count_values($answers);
$rank = 1;

foreach ($counts as $answer => $count) {
    foreach ($answers as $user => $user_answer) {
        if ($user_answer == $answer && $_SESSION['id'] == $users[$user]) {
            echo $rank;
        }
    }
    $rank += $count;
}

// print_r("SELECT a.userid, SUM(a.scorecard) AS correct_answers, ROUND(AVG(a.time_taken), 1) AS average_time_taken FROM leaderboard as a, users as b WHERE b.id=a.userid and b.class='" . $usrrow['class'] . "' and b.id IN ($eligibleIds)  GROUP BY a.userid ORDER BY correct_answers DESC, average_time_taken ASC");

$chk_ovr_qury = mysqli_query($conn, "SELECT a.userid, SUM(a.scorecard) AS correct_answers, ROUND(AVG(a.time_taken), 1) AS average_time_taken FROM leaderboard as a, users as b WHERE b.id=a.userid and b.class='" . $usrrow['class'] . "' and a.class = '" . $usrrow['class'] . "' and b.id IN ($eligibleIds) and b.id = '". $_SESSION['id'] ."'  GROUP BY a.userid ORDER BY correct_answers DESC, average_time_taken ASC");
$chk_ovr_rank = mysqli_fetch_array($chk_ovr_qury, MYSQLI_ASSOC);
if(empty($chk_ovr_rank['userid'])) {
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
                    <div>School Rank

<span><?php
$correctSQL = "SELECT a.userid, SUM(a.scorecard) AS correct_answers FROM leaderboard as a, users as b WHERE b.id=a.userid and b.school='" . $usrrow['school'] . "' and b.class='" . $usrrow['class'] . "' and a.class = '" . $usrrow['class'] . "' and b.id IN ($eligibleIds)  GROUP BY a.userid ORDER BY correct_answers DESC";
$result = mysqli_query($conn, $correctSQL);

$users = [];
$answers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row['userid'];
    $answers[] = $row['correct_answers'];
}

$counts = array_count_values($answers);
$rank = 1;

foreach ($counts as $answer => $count) {
    foreach ($answers as $user => $user_answer) {
        if ($user_answer == $answer && $_SESSION['id'] == $users[$user]) {
            echo $rank;
        }
    }
    $rank += $count;
}

$chk_sch_qury = mysqli_query($conn, "SELECT a.userid, SUM(a.scorecard) AS correct_answers FROM leaderboard as a, users as b WHERE b.id=a.userid and b.school='" . $usrrow['school'] . "' and b.class='" . $usrrow['class'] . "' and a.class = '" . $usrrow['class'] . "' and b.id IN ($eligibleIds)  and b.id = '". $_SESSION['id'] ."'  GROUP BY a.userid ORDER BY correct_answers DESC");
$chk_ovr_rank = mysqli_fetch_array($chk_sch_qury, MYSQLI_ASSOC);
if(empty($chk_ovr_rank['userid'])) {
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
                                        </div>
                </div>
        
        <div class="text-end mt-2 me-2">
            <?php if(empty($_SESSION['id'])) { ?> 
                <a href="#login" onclick="showWithoutLoginModal()" class="link-btn">    
            <?php } else { ?>
                <a href="leaderboard" class="link-btn">
            <?php } ?>
            View all leaderboard
        </a>
        </div>
                        </div>  
    </div>
</div>
</div>
<?php
$chk_quiz_paper_qury = mysqli_query($conn, "SELECT a.class_id,a.quizid,b.id FROM quiz_other_class as a INNER JOIN quiz as b ON b.id=a.quizid WHERE a.class_id='".$sessionrow['class']."' and b.status=1");
while($chk_quiz_paper_rslt = mysqli_fetch_array($chk_quiz_paper_qury)) { 
    $chk_quiz_paper_array[] = $chk_quiz_paper_rslt['id'];
    }

$chk_quiz_paper_display_qury = mysqli_query($conn, "SELECT COUNT(id) as count FROM quiz WHERE (class='".$sessionrow['class']."' and type='2') or (class='".$sessionrow['class']."' and type='1') or (id IN (" . implode(',', $chk_quiz_paper_array) . ") AND type = 2 ) or (id IN (" . implode(',', $chk_quiz_paper_array) . ") AND type = 1 ) and status=1");
$chk_quiz_paper_display_rslt = mysqli_fetch_array($chk_quiz_paper_display_qury, MYSQLI_ASSOC);
if(!empty($chk_quiz_paper_display_rslt['count'])) { ?>
<section class="section pt-0 pb-5">
            <div class="container">
                <div class="row">
                    <?php 
                    $otherCls_qury = mysqli_query($conn, "SELECT a.class_id,a.quizid FROM quiz_other_class as a INNER JOIN quiz as b ON b.id=a.quizid WHERE a.class_id='".$sessionrow['class']."' and b.type=2 and b.status=1");
                    while($otherCls_rslt = mysqli_fetch_array($otherCls_qury))
                    {
                        $otherCls[] = $otherCls_rslt['quizid'];
                    }
                    
                    $pprqury = mysqli_query($conn, "SELECT COUNT(id) as count FROM quiz WHERE (class='".$sessionrow['class']."' and type=2) or (id IN (" . implode(',', $otherCls) . ") AND type = 2) and status=1");
          $pprslt = mysqli_fetch_array($pprqury, MYSQLI_ASSOC);
          
          if(!empty($pprslt['count'])) { ?>
                    <div class="col-md-6">
                        <a href="paper" class="grid-2 btn-animated practice">
                            <div class="lt">
                                <h2 class="title">Offline <br>Practice</h2>
                            </div>
                            <div class="rt">
                                <div class="lg"><?php echo $pprslt['count']; ?></div>
                                <div class="md">Practice</div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                    
                    <?php 
                   $otherCls_qury = mysqli_query($conn, "SELECT a.class_id,a.quizid FROM quiz_other_class as a INNER JOIN quiz as b ON b.id=a.quizid WHERE a.class_id='".$sessionrow['class']."' and b.status=1");
                   while($otherCls_rslt = mysqli_fetch_array($otherCls_qury)) {
                       $otherCls[] = $otherCls_rslt['quizid'];
                   }
      
                    
                    $quizqury = mysqli_query($conn, "SELECT COUNT(id) as count FROM quiz WHERE (class = '" . $sessionrow['class'] . "' AND type = 1) OR (id IN (" . implode(',', $otherCls) . ") AND type = 1) and status=1");
          $quizrslt = mysqli_fetch_array($quizqury, MYSQLI_ASSOC);
          if(!empty($quizrslt['count'])) { ?>
          <div class="col-md-6 mt-md-0 mt-3">
                        <a href="quiz" class="grid-2 btn-animated quiz">
                            <div class="lt">
                                <h2 class="title">Weekly <br>Quiz</h2>
                            </div>
                            <div class="rt">
                                <div class="lg"><?php echo $quizrslt['count']; ?></div>
                                <div class="md">Quiz</div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <?php } ?>

        <section class="section pt-0 pb-0">
    <div class="container">
        <div class="row mb-4">
<?php 
$sbjSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE slug='mathematics' and type=1 and status=1");
$sbjrow = mysqli_fetch_array($sbjSQL, MYSQLI_ASSOC);

$clsSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE id='".$sessionrow['class']."' and type=2 and status=1");
$clsrow = mysqli_fetch_array($clsSQL, MYSQLI_ASSOC);

$topicsql = mysqli_query($conn, "SELECT ts.id,ts.topic,ts.class_id,ts.slug FROM topics_subtopics ts LEFT JOIN topic_ranking tr ON tr.topic_id=ts.id WHERE ts.class_id=".$clsrow['id']." and ts.subject_id=".$sbjrow['id']." and ts.parent=0 and ts.status=1 ORDER BY tr.rank ASC");
$pastelColors = array(
    array(
        'lighter' => "#FFFACD", // Lemon Chiffon
        'darker' => "#EEE5B2"
    ),
    array(
        'lighter' => "#FFDAB9", // Peach Puff
        'darker' => "#ECC5A5"
    ),
    array(
        'lighter' => "#F0FFF0", // Honeydew
        'darker' => "#D9EAD3"
    ),
    array(
        'lighter' => "#E6E6FA", // Lavender
        'darker' => "#CCC1E0"
    ),
    array(
        'lighter' => "#FFD700", // Light Gold
        'darker' => "#E5C100"
    ),
    array(
        'lighter' => "#FFB6C1", // Light Pink
        'darker' => "#E5A4B1"
    ),
    array(
        'lighter' => "#87CEEB", // Sky Blue
        'darker' => "#7CB6D9"
    ),
    array(
        'lighter' => "#98FB98", // Mint Green
        'darker' => "#8BE289"
    ),
    array(
        'lighter' => "#FFA07A", // Light Salmon
        'darker' => "#E89270"
    ),
    array(
        'lighter' => "#DDA0DD", // Plum
        'darker' => "#C88EC8"
    ),
    array(
        'lighter' => "#00FA9A", // Medium Spring Green
        'darker' => "#00E68C"
    ),
    array(
        'lighter' => "#FFC0CB", // Pink
        'darker' => "#E5A2A9"
    ),
    array(
        'lighter' => "#B0E0E6", // Powder Blue
        'darker' => "#9ACCD1"
    ),
    array(
        'lighter' => "#F0E68C", // Khaki
        'darker' => "#E2D575"
    ),
    array(
        'lighter' => "#FFECB3", // Peach
        'darker' => "#E2D575"
    ),
    array(
        'lighter' => "#FFE4B5", // Moccasin
        'darker' => "#E4D1A6"
    ),
    array(
        'lighter' => "#F5F5DC", // Beige
        'darker' => "#D8D8B7"
    ),
    array(
        'lighter' => "#E0FFFF", // Light Cyan
        'darker' => "#B7E2E2"
    ),
    array(
        'lighter' => "#FFF8DC", // Cornsilk
        'darker' => "#ECE4B1"
    ),
    array(
        'lighter' => "#FFF0F5", // Lavender Blush
        'darker' => "#E2D3D9"
    ),
    array(
        'lighter' => "#F5FFFA", // Mint Cream
        'darker' => "#D1E8D1"
    ),
    array(
        'lighter' => "#FAFAD2", // Light Goldenrod Yellow
        'darker' => "#EAE3B5"
    ),
    array(
        'lighter' => "#FFEFD5", // Papaya Whip
        'darker' => "#E8DDBE"
    ),
    array(
        'lighter' => "#FFEBCD", // Blanched Almond
        'darker' => "#E8D3B8"
    ),
    array(
        'lighter' => "#FDF5E6", // Old Lace
        'darker' => "#ECE1CE"
    )
);

/*$pastelColors = array("#ff80ed", "#ffc0cb", "#ffd700", "#00ffff", "#ffa500", "#ff737", "#40e0d0", "#bada55", "#8a2be2", "#ccff00", "#00ff7f", "#ff4040", "#ffff6");*/


shuffle($pastelColors);

$sno=0;
        while($topicrow = mysqli_fetch_array($topicsql, MYSQLI_ASSOC)) { 
            $sno++;
            ?>

            <div class="accordion mb-3" id="accordionExample">
                <div class="accordion-item" style="background-color:#f5f5dc ">
            <h2 class="accordion-header" id="heading<?=$sno?>">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$sno?>" aria-expanded="true" aria-controls="collapse<?=$sno?>" style="background-color: <?php echo $pastelColors[$sno % count($pastelColors)]['darker']; ?>">
            <h2 class="section-title d-flex align-items-center"><span><?php echo $topicrow['topic']; ?></span>
            <?php if(!empty($_SESSION['id']) && $topicrow['class_id'] == $sessionrow['class']) { ?>
            <a href="javascript:void(0);" data-topic="<?php echo $topicrow['id']; ?>" class="action-link fastest-topic ms-3"><img src="<?php echo $baseurl; ?>assets/images/fastest_icon.svg" width="25" height="25" alt="fastest img"></a>
        <?php } else if(empty($_SESSION['id'])) { ?> 
            <a href="#" onclick="showWithoutLoginModal()"><img src="<?php echo $baseurl; ?>assets/images/fastest_icon_disabled.svg" width="25" height="25" alt="fastest img"></a>
        <?php } ?>
        </h2>
            </button>
        </h2>

        <div id="collapse<?=$sno?>" class="accordion-collapse collapse  " aria-labelledby="heading<?=$sno?>" data-bs-parent="#accordionExample">
        <div class="row accordion-body">
           
            <?php $sbtopicsql = mysqli_query($conn, "SELECT ts.id,ts.subtopic,ts.slug,ts.class_id,ts.subject_id FROM topics_subtopics ts LEFT JOIN subtopic_ranking sr ON sr.subtopic_id=ts.id WHERE ts.parent=".$topicrow['id']." and ts.status=1 ORDER BY sr.rank ASC");
            while($sbtopicrow = mysqli_fetch_array($sbtopicsql, MYSQLI_ASSOC)) {

            //accept grp
            $acptqury = mysqli_query($conn, "SELECT c.assign_grp,a.userid,a.grp_id FROM accept_grp as a INNER JOIN grpwise as b ON b.id=a.grp_id INNER JOIN assign_grpids as c ON c.grpids=b.id WHERE a.userid='".$_SESSION['id']."'");
           // $acpt_rslt = mysqli_fetch_array($acptqury, MYSQLI_ASSOC);

           // $_SESSION['acceptID'] = $acpt_rslt['userid'];

            $grpids = [];
            while($chk_teach_rslt = mysqli_fetch_assoc($acptqury))
            {
                $grpids[] = $chk_teach_rslt['grp_id'];
            }
    
            $grpids = implode(",",$grpids);

            $_SESSION['grp_id'] = $grpids;

            $chkgrpSQL = "SELECT assign_grp FROM assign_grpids as a INNER JOIN grpwise as b ON b.id=a.grpids WHERE a.grpids IN (".$grpids.") and b.status=1 order by a.assign_grp asc";
            $chkgrprow = mysqli_query($conn, $chkgrpSQL);

            $assign_grp = array(); // Initialize $assign_grp as an empty array

            while ($row = mysqli_fetch_assoc($chkgrprow)) {
            $assign_grp[] = $row['assign_grp'];
            }

            $counts = array_count_values($assign_grp);

            $assign_grps = array(); // Initialize $assign_grp as an empty array

            foreach ($counts as $assign_grp => $count) {
                
                $assign_grps[] = $assign_grp;

            }

            $assign_array = implode(",",$assign_grps);

            $acptgrpSQL = mysqli_query($conn, "SELECT subtopic,assign_grp,grp_name FROM assign_grpids as a INNER JOIN assign_grp as b ON b.id=a.assign_grp WHERE a.assign_grp IN (".$assign_array.") and a.subtopic='".$sbtopicrow['id']."' and b.status=1 order by b.id desc");  
            $acptgrprow = mysqli_fetch_array($acptgrpSQL, MYSQLI_ASSOC);
            

            $_SESSION['assign_grp'] = $acptgrprow['assign_grp'];
            
            mysqli_query($conn, "DELETE FROM check_subtopic WHERE practice_id=0");
            $chstpcSQL = mysqli_query($conn, "SELECT user_id FROM check_subtopic WHERE user_id='".$_SESSION['id']."' and subtopic_id='".$acptgrprow['subtopic']."' and practice_id='".$acptgrprow['assign_grp']."'");
            $chstpcrow = mysqli_fetch_array($chstpcSQL, MYSQLI_ASSOC);

            $chkProficienctSql = mysqli_query($conn, "SELECT pl.id FROM user_proficiency up
                                                    LEFT JOIN proficiency_levels pl ON up.proficiency_level = pl.id
                                                    WHERE userid = '".$_SESSION['id']."' AND subtopic_id = '". $sbtopicrow['id'] ."'");


?>
            <div class="col-lg-3 col-md-6 col-12 mb-md-4 mb-3">
            <div class="blk-widget-inner">
            <?php if (!empty($asgrprow['subtopic']) && (empty($acptgrprow['subtopic']))) { ?>
                <a href="#assign" data-id="<?php echo $sbtopicrow['slug']; ?>" data-bs-toggle="modal" data-bs-target="#assignModal" class="acpt-grp">
                <?php } else { $acptID = $acptgrprow['assign_grp']; ?>
                    <a href="<?php echo $baseurl.$sbjrow['slug'].'/'.$clsrow['slug'].'/'.$topicrow['slug'].'/'.$sbtopicrow['slug']; ?>" data-grp="<?php echo $acptID; ?>" data-id="<?php echo $sbtopicrow['id']; ?>">
                <?php } ?>
                    <h3 class="heading"><?php echo $sbtopicrow['subtopic']; ?></h3>
                    <?php if (!empty($acptgrprow['subtopic'])) { ?>
                    <div class="assign-tag" title="<?php echo $acptgrprow['grp_name']; ?>"><img src="<?php echo $baseurl; ?>assets/images/school.svg" height="18" alt=""></div>
                    <?php } ?>
                    <?php if (empty($chstpcrow['user_id']) && !empty($acptgrprow['subtopic'])) { ?>
                    <span class='tag new-tag'>New</span>  
                <?php } ?>
                <div class="proficiency-tag">
                <?php if(mysqli_num_rows($chkProficienctSql) > 0) { 
                    $chkProficienctRow = mysqli_fetch_assoc($chkProficienctSql);
                    $count_pro = 0;
                    ?>
                    <?php
                    if(empty($chkProficienctRow['id'])) { 
                        $count_pro++;
                    ?>
                        <img src="../assets/images/half-filled-star.svg" height="18" alt="">
                    <?php }
                    while($count_pro++ < $chkProficienctRow['id']){ ?> 
                        <img src="../assets/images/filled-star.svg" height="18" alt="">
                    <?php } 
                    while($count_pro++ <= 3) { ?> 
                        <img src="../assets/images/star.svg" height="18" alt="">
                    <?php } ?>
                <?php } else {
                    $count_pro = 0;
                    while($count_pro++ < 3) { ?> 
                        <img src="../assets/images/star.svg" height="18" alt="">
                    <?php }
                } ?>
                </div>

                </a>
                <div class="footer-widget">
                <?php if (!empty($asgrprow['subtopic']) && (empty($acptgrprow['subtopic']))) { ?>
                    
                    <span><a href="#assign" data-id="<?php echo $sbtopicrow['slug']; ?>" data-bs-toggle="modal" data-bs-target="#assignModal" class="acpt-grp">Practice</a></span>
                    <?php } else { $acptID = $acptgrprow['assign_grp']; ?>
                        <span><a href="#" data-bs-toggle="modal" data-bs-target="#pdfDownloadModal" onclick="fetch_pdf()" data-id="<?php echo $sbtopicrow['id'];?>">Offline</a></span>
                    <span><a href="<?php echo $baseurl.$sbjrow['slug'].'/'.$clsrow['slug'].'/'.$topicrow['slug'].'/'.$sbtopicrow['slug']; ?>" data-grp="<?php echo $acptID; ?>" data-id="<?php echo $sbtopicrow['id']; ?>">Practice</a></span>
                        <?php } ?>
                </div>
                </div>
                </div>
                <?php } ?>
        </div>
        </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</section>
<section class="section bg-lightblue pt-lg-5 pb-lg-5 pt-4 pb-4">
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
                    $topiCntrow = mysqli_fetch_assoc($topiCntsql);

                    ?>
                        <?php if($sessionrow['class'] != $sclwiseRow['id'] ) { ?>
                        <?php if(empty($_SESSION['id'])) { ?>
                        <a href="#login" data-bs-toggle="modal" data-bs-target="#loginModal" class="btn-animated level-list">
                        <?php } else { ?>
                        <a href="<?php echo $subjectrow['slug'].'/'.$sclwiseRow['slug']; ?>" class="btn-animated level-list">
                        <?php } } else { ?>
                            <div class="level-list inactive">
                            <?php } ?>
                            <div class="lt">
                                <h3 class="title"><?php echo $sclwiseRow['name']; ?></h3></div>
                            <div class="rt">
                                <span class="lg"><?php echo $topiCntrow['count']; ?></span>
                                <span class="md">Skills</span>
                            </div>
                            <?php if($sessionrow['class'] != $sclwiseRow['id'] ) {  ?>
                        </a>
                        <?php } else { ?>
                        </div>
                            <?php } ?>
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
                         <?php if(empty($_SESSION['id'])) { ?>
                        <a href="#login" data-bs-toggle="modal" data-bs-target="#loginModal" class="btn-animated level-list">
                        <?php } else { ?>
                        <a href="<?php echo $subjectrow['slug'].'/'.$sclwiseRow['slug']; ?>" class="btn-animated level-list">
                        <?php } ?>
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
<?php include("footer.php"); mysqli_close($conn);?>
<?php } else { ?>
<?php #header('Location:'.$baseurl.''); ?>
<?php } ?>