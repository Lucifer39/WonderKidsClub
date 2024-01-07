<?php 
include("config/config.php");
include("functions.php");

unset($_SESSION['checkresults']);
unset($_SESSION['schcheckresults']);

if(($_SESSION['id']))
#header('Location: ' . $_SERVER['REQUEST_URI']);

$sessionsql = mysqli_query($conn, "SELECT isAdmin,fullname,school,class,avatar FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_array($sessionsql, MYSQLI_ASSOC);

$clsSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE id='".$sessionrow['class']."' and type=2 and status=1");
$clsrow = mysqli_fetch_array($clsSQL, MYSQLI_ASSOC);

$schSQL = mysqli_query($conn, "SELECT id,name FROM school_management WHERE id='".$sessionrow['school']."' and status=1");
$schrow = mysqli_fetch_array($schSQL, MYSQLI_ASSOC);
$schrow_main = $schrow['name'];

$usrSQL = mysqli_query($conn, "SELECT id,school,class,fullname FROM users WHERE school='".$sessionrow['school']."' and class='".$sessionrow['class']."' and isAdmin=2 and status=1");
$usrrow = mysqli_fetch_array($usrSQL, MYSQLI_ASSOC);

$limit = 10;

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


if (isset($_POST['overallbtn'])) {
    $_SESSION['overallId'] = $_POST['tpid'];
}

if($sessionrow['isAdmin'] == '2') {
?>
<?php include("header.php");?>
<section class="section">
    <div class="container">
        <div class="row">
        <div class="col-md-12 pe-5">
                            <div class="breadcrumbs st-breadcrumbs mb-4">
                                <span><a href="<?php echo $baseurl.'dashboard'; ?>">Home</a></span>
                                <span>Leaderboard</span>
                            </div>
                            </div>
        <div class="col-lg-8 col-md-12">
        <div class="leaderboard-wrapper">
        <div class="mb-3 text-md-start text-center d-flex flex-md-row flex-column align-items-center">
        <a name="<?php echo $topicrslt['slug'];?>" id="<?php echo $topicrslt['slug'];?>"></a>
            <h2 class="section-title flex-1 mb-2">Leaderboard <spn class="note ms-1">- Practice</spn></h2>
            <div class="tabs">
            <a href="javascript:void(0);" data-overall="<?php echo $topicrslt['id']; ?>" class="active">Overall Rank</a>
             <a href="javascript:void(0);" data-school="<?php echo $topicrslt['id']; ?>">School Rank</a>  
            </div>
        </div>
        <ul class="leaderboard-list overallwise mb-5">
        <?php
            $correctSQL = "SELECT a.userid, SUM(a.scorecard) AS correct_answers, ROUND(AVG(a.time_taken), 1) AS average_time_taken FROM leaderboard as a, users as b WHERE b.id=a.userid and b.class='".$usrrow['class']."' and a.class = '" . $usrrow['class'] . "' and b.id IN ($eligibleIds)  GROUP BY a.userid ORDER BY correct_answers DESC, average_time_taken ASC LIMIT $limit";
            $result = mysqli_query($conn, $correctSQL);

            $users = [];
            $answers = [];
            $avg_time = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = $row['userid'];
                $answers[] = $row['correct_answers'];
                $avg_time[] = $row['average_time_taken'];
            }

            $counts = array_count_values($answers);
            $rank = 1;

            foreach ($counts as $answer => $count) {
                foreach ($answers as $user => $user_answer) {
                    if ($user_answer == $answer) {
                        $usrsSQL = mysqli_query($conn, "SELECT fullname,school,avatar FROM users WHERE id='".$users[$user]."' and isAdmin=2 and status=1");
                        $usrsrow = mysqli_fetch_array($usrsSQL, MYSQLI_ASSOC);

                        $schSQL = mysqli_query($conn, "SELECT id,name FROM school_management WHERE id='".$usrsrow['school']."' and status=1");
                        $schrow = mysqli_fetch_array($schSQL, MYSQLI_ASSOC);

                        if ($_SESSION['id'] ==  $users[$user]) {
                            //$_SESSION['checkresults'] = $users[$user]; ?>
                        <li class="selected">
                        <div class="data pe-0">
                            <img class="featured" src="<?php echo isset($usrsrow["avatar"]) ? $baseurl . "assets/images/avatars/" . $usrsrow["avatar"] : "assets/images/profile.jpg" ?>" width="50" height="50" alt="">
                        </div>
                        <div class="data w-100">
                            <div class="font15"><?php echo $usrsrow['fullname']; ?></div>
                            <div class="font13 txt-grey"><?php echo $schrow['name']; ?></div>
                        </div>
                        <div class="data text-center mob-none">
                            <div class="font17"><?php echo $lvl; ?></div>
                            <div class="font13 txt-grey">Level</div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><?php echo $user_answer; ?></div>
                            <div class="font13 txt-grey">Score</div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><?php echo $avg_time[$user]; ?></div>
                            <div class="font13 txt-grey">Time(in secs)</div>
                        </div>
                        <div class="data text-center flex-1">
                            <div class="font17"><?php echo $rank; ?></div>
                            <div class="font13 txt-grey">Rank</div>
                        </div>
                    </li>
                        <?php } else { ?>
                            <li data-id=<?php echo $users[$user]; ?>>
                        <div class="data pe-0">
                            <img class="featured" src="<?php echo isset($usrsrow["avatar"]) ? $baseurl . "assets/images/avatars/" . $usrsrow["avatar"] : "assets/images/profile.jpg" ?>" width="50" height="50" alt="">
                        </div>
                        <div class="data w-100">
                            <div class="font15"><?php echo $usrsrow['fullname']; ?></div>
                            <div class="font13 txt-grey"><?php echo $schrow['name']; ?></div>
                        </div>
                        <div class="data text-center mob-none">
                            <div class="font17"><?php echo $lvl; ?></div>
                            <div class="font13 txt-grey">Level</div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><?php echo $user_answer; ?></div>
                            <div class="font13 txt-grey">Score</div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><?php echo $avg_time[$user]; ?></div>
                            <div class="font13 txt-grey">Time(in secs)</div>
                        </div>
                        <div class="data text-center flex-1">
                            <div class="font17"><?php echo $rank; ?></div>
                            <div class="font13 txt-grey">Rank</div>
                        </div>
                    </li>
                        <?php } } } $rank += $count; } ?>
                        </ul>
                        <div class="tooltip">
                            <div class="iframe-container">
                                <iframe></iframe>
                            </div>
                        </div>
                        <ul class="leaderboard-list schoolwise mb-5">
        <?php
            $correctSQL = "SELECT a.userid, SUM(a.scorecard) AS correct_answers, ROUND(AVG(a.time_taken), 1) AS average_time_taken FROM leaderboard as a, users as b WHERE b.id=a.userid and b.class='" . $usrrow['class'] . "' and b.school='" . $usrrow['school'] . "' and a.class = '" . $usrrow['class'] . "' and b.id IN ($eligibleIds)  GROUP BY a.userid ORDER BY correct_answers DESC, average_time_taken ASC LIMIT $limit";
            
            $result = mysqli_query($conn, $correctSQL);

            $users = [];
            $answers = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = $row['userid'];
                $answers[] = $row['correct_answers'];
                $avg_time[] = $row['average_time_taken'];
            }

            $counts = array_count_values($answers);
            $rank = 1;

            foreach ($counts as $answer => $count) {
                foreach ($answers as $user => $user_answer) {
                    if ($user_answer == $answer) {
                        $usrsSQL = mysqli_query($conn, "SELECT fullname,school,avatar FROM users WHERE id='".$users[$user]."' and isAdmin=2 and status=1");
                        $usrsrow = mysqli_fetch_array($usrsSQL, MYSQLI_ASSOC);

                        $schSQL = mysqli_query($conn, "SELECT id,name FROM school_management WHERE id='".$usrsrow['school']."' and status=1");
                        $schrow = mysqli_fetch_array($schSQL, MYSQLI_ASSOC);

                        if ($_SESSION['id'] ==  $users[$user]) {
                            //$_SESSION['checkresults'] = $users[$user]; ?>
                            <li class="selected">
                        <div class="data pe-0">
                            <img class="featured" src="<?php echo isset($usrsrow["avatar"]) ? $baseurl . "assets/images/avatars/" . $usrsrow["avatar"] : "assets/images/profile.jpg" ?>" width="50" height="50" alt="">
                        </div>
                        <div class="data w-100">
                            <div class="font15"><?php echo $usrsrow['fullname']; ?></div>
                            <div class="font13 txt-grey"><?php echo $schrow['name']; ?></div>
                        </div>
                        <div class="data text-center mob-none">
                            <div class="font17"><?php echo $lvl; ?></div>
                            <div class="font13 txt-grey">Level</div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><?php echo $user_answer; ?></div>
                            <div class="font13 txt-grey">Score</div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><?php echo $avg_time[$user]; ?></div>
                            <div class="font13 txt-grey">Time(in secs)</div>
                        </div>
                        <div class="data text-center flex-1">
                            <div class="font17"><?php echo $rank; ?></div>
                            <div class="font13 txt-grey">Rank</div>
                        </div>
                    </li>
                        <?php } else { ?>
                            <li data-id=<?php echo $users[$user]; ?>>
                        <div class="data pe-0">
                            <img class="featured" src="<?php echo isset($usrsrow["avatar"]) ? $baseurl . "assets/images/avatars/" . $usrsrow["avatar"] : "assets/images/profile.jpg" ?>" width="50" height="50" alt="">
                        </div>
                        <div class="data w-100">
                            <div class="font15"><?php echo $usrsrow['fullname']; ?></div>
                            <div class="font13 txt-grey"><?php echo $schrow['name']; ?></div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><?php echo $lvl; ?></div>
                            <div class="font13 txt-grey ">Level</div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><?php echo $user_answer; ?></div>
                            <div class="font13 txt-grey ">Score</div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><?php echo $avg_time[$user]; ?></div>
                            <div class="font13 txt-grey">Time(in secs)</div>
                        </div>
                        <div class="data text-center flex-1">
                            <div class="font17"><?php echo $rank; ?></div>
                            <div class="font13 txt-grey">Rank</div>
                        </div>
                    </li>
                        <?php } } } $rank += $count; } ?>
                        </ul>
            </div>

           <!-- </diV>
        </div>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="row">
        <div class="col-md-12">-->
    <?php
    $topicqury = mysqli_query($conn, "SELECT id, slug, topic FROM topics_subtopics WHERE class_id='".$sessionrow['class']."' and subject_id=8 ORDER BY id ASC");
    while ($topicrslt = mysqli_fetch_array($topicqury, MYSQLI_ASSOC)) {

        $topicleaderqury = mysqli_query($conn, "SELECT userid, correct, duration,converttime FROM fastest WHERE topicid='".$topicrslt['id']."' and correct IS NOT NULL and correct <> '' and correct != 0 ORDER BY converttime ASC,correct desc");
        $row = mysqli_fetch_assoc($topicleaderqury);

        if(!empty($row['userid'])) { 
        ?>
        <div class="leaderboard-wrapper">
        <div class="mb-3 d-flex flex-md-row flex-column align-items-center">
        <a name="<?php echo $topicrslt['slug'];?>" id="<?php echo $topicrslt['slug'];?>"></a>
            <h2 class="section-title flex-1 mb-2"><?php echo $topicrslt['topic']; ?><span class="note ms-1">- Fastest 10</span></h2>
            <div class="tabs">
            <a href="javascript:void(0);" data-overall="<?php echo $topicrslt['id']; ?>" class="active">Overall Rank</a>
             <a href="javascript:void(0);" data-school="<?php echo $topicrslt['id']; ?>">School Rank</a>  
            </div>
        </div>
        <ul class="leaderboard-list overallwise mb-5">
            <?php
            $rank = 1;
            $i = 1; 
            $topicleaderqury = mysqli_query($conn, "SELECT a.userid, a.correct, a.duration,a.converttime FROM fastest as a, users as b WHERE b.id=a.userid and a.topicid='".$topicrslt['id']."' and a.correct IS NOT NULL and a.correct <> '' and a.correct != 0 ORDER BY a.correct desc,a.duration asc LIMIT $limit");
            while ($row = mysqli_fetch_assoc($topicleaderqury)) {
                $usrsSQL = mysqli_query($conn, "SELECT fullname, school,avatar FROM users WHERE id='".$row['userid']."' and isAdmin=2 and status=1");
                $usrsrow = mysqli_fetch_array($usrsSQL, MYSQLI_ASSOC);

                $schSQL = mysqli_query($conn, "SELECT id, name FROM school_management WHERE id='".$usrsrow['school']."' and status=1");
                $schrow = mysqli_fetch_array($schSQL, MYSQLI_ASSOC);

                if ($_SESSION['id'] == $row['userid']) { $_SESSION['topic_overall_'.$i.''] = $row['userid']; ?>
                    <li class="selected">
                        <div class="data pe-0">
                            <img class="featured" src="<?php echo isset($usrsrow["avatar"]) ? $baseurl . "assets/images/avatars/" . $usrsrow["avatar"] : "assets/images/profile.jpg" ?>" width="50" height="50" alt="">
                        </div>
                        <div class="d-flex flex-1 lt-flex">
                        <div class="data w-100 flex-1">
                            <div class="font15"><?php echo $usrsrow['fullname']; ?></div>
                            <div class="font13 txt-grey"><?php echo $schrow['name']; ?></div>
                        </div>
                        <div class="d-flex">
                        <div class="data text-center">
                            <div class="font17"><?php echo $row['correct']; ?><span class="mob-show">/10</span></div>
                            <div class="font13 txt-grey mob-none">out of 10</div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><span class="mob-show">Time:</span> <?php echo $row['duration']; ?></div>
                            <div class="font13 txt-grey mob-none">Time Duration</div>
                        </div>
                        </div>
                        </div>
                        <div class="d-flex rt-flex">                        
                        <div class="data text-center">
                            <div class="font17"><?php echo $rank; ?></div>
                            <div class="font13 txt-grey">Rank</div>
                        </div>
                        </div>
                    </li>
                    <?php
                } else {
                    ?>
                    <li data-id=<?php echo $row["userid"]; ?>>
                    <div class="data pe-0">
                            <img class="featured" src="<?php echo isset($usrsrow["avatar"]) ? $baseurl . "assets/images/avatars/" . $usrsrow["avatar"] : $baseurl ."assets/images/profile.jpg" ?>" width="50" height="50" alt="">
                        </div>
                        <div class="d-flex flex-1 lt-flex">
                        <div class="data w-100 flex-1">
                            <div class="font15"><?php echo $usrsrow['fullname']; ?></div>
                            <div class="font13 txt-grey"><?php echo $schrow['name']; ?></div>
                        </div>
                        <div class="d-flex">
                        <div class="data text-center">
                            <div class="font17"><?php echo $row['correct']; ?><span class="mob-show">/10</span></div>
                            <div class="font13 txt-grey mob-none">out of 10</div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><span class="mob-show">Time:</span> <?php echo $row['duration']; ?></div>
                            <div class="font13 txt-grey mob-none">Time Duration</div>
                        </div>
                        </div>
                        </div>
                        <div class="d-flex rt-flex">                        
                        <div class="data text-center">
                            <div class="font17"><?php echo $rank; ?></div>
                            <div class="font13 txt-grey">Rank</div>
                        </div>
                        </div>
                    </li>
                    <?php
                }
             $rank++; $i++;
            }
             if($_SESSION['topic_overall_'.$i.''] != $row['userid']) {
                $urrank = 1;
                $younot_qury = mysqli_query($conn, "SELECT a.userid, a.correct, a.duration,a.converttime FROM fastest as a, users as b WHERE b.id=a.userid and a.topicid='".$topicrslt['id']."' and a.correct IS NOT NULL and a.correct <> '' and a.correct != 0 ORDER BY a.correct desc,a.duration asc");
                $count_overall = 0;
                while ($younot_rslt = mysqli_fetch_assoc($younot_qury)) {
                    $count_overall++;
                    $usrsSQL = mysqli_query($conn, "SELECT fullname, school,avatar FROM users WHERE id='".$younot_rslt['userid']."' and isAdmin=2 and status=1");
                    $usrsrow = mysqli_fetch_array($usrsSQL, MYSQLI_ASSOC);
    
                    $schSQL = mysqli_query($conn, "SELECT id, name FROM school_management WHERE id='".$usrsrow['school']."' and status=1");
                    $schrow = mysqli_fetch_array($schSQL, MYSQLI_ASSOC);
    
                    if ($_SESSION['id'] == $younot_rslt['userid'] && $count_overall > $limit) { ?>
                        <li class="selected">
                        <div class="data pe-0">
                            <img class="featured" src="<?php echo isset($usrsrow["avatar"]) ? $baseurl . "assets/images/avatars/" . $usrsrow["avatar"] : $baseurl ."assets/images/profile.jpg" ?>" width="50" height="50" alt="">
                        </div>
                        <div class="d-flex flex-1 lt-flex">
                        <div class="data w-100 flex-1">
                            <div class="font15"><?php echo $usrsrow['fullname']; ?></div>
                            <div class="font13 txt-grey"><?php echo $schrow['name']; ?></div>
                        </div>
                        <div class="d-flex">
                        <div class="data text-center">
                            <div class="font17"><?php echo $younot_rslt['correct']; ?><span class="mob-show">/10</span></div>
                            <div class="font13 txt-grey mob-none">out of 10</div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><span class="mob-show">Time:</span> <?php echo $younot_rslt['duration']; ?></div>
                            <div class="font13 txt-grey mob-none">Time Duration</div>
                        </div>
                        </div>
                        </div>
                        <div class="d-flex rt-flex">                        
                        <div class="data text-center">
                            <div class="font17"><?php echo $rank; ?></div>
                            <div class="font13 txt-grey">Rank</div>
                        </div>
                        </div>
                        </li>
                        <?php
                    }
                    $urrank++; unset($_SESSION['topic_overall_'.$i.'']); 
                } 
                  
            }  
            ?>
        </ul>
        <ul class="leaderboard-list schoolwise mb-5">
            <?php
            $rank = 1;
            $i = 1; 
            $topicleaderqury = mysqli_query($conn, "SELECT a.userid, a.correct, a.duration,a.converttime FROM fastest as a, users as b where a.userid=b.id and a.topicid='".$topicrslt['id']."' and b.school='".$sessionrow['school']."' and a.correct IS NOT NULL and a.correct <> '' and a.correct != 0 ORDER BY a.correct desc,a.duration asc LIMIT $limit");
            while ($row = mysqli_fetch_assoc($topicleaderqury)) {
                $usrsSQL = mysqli_query($conn, "SELECT fullname, school,avatar FROM users WHERE id='".$row['userid']."' and isAdmin=2 and status=1");
                $usrsrow = mysqli_fetch_array($usrsSQL, MYSQLI_ASSOC);

                $schSQL = mysqli_query($conn, "SELECT id, name FROM school_management WHERE id='".$usrsrow['school']."' and status=1");
                $schrow = mysqli_fetch_array($schSQL, MYSQLI_ASSOC);

                // var_dump($row);

                if ($_SESSION['id'] == $row['userid']) { $_SESSION['topic_school_'.$i.''] = $row['userid']; ?>
                    <li class="selected">
                    <div class="data pe-0">
                            <img class="featured" src="<?php echo isset($usrsrow["avatar"]) ? $baseurl . "assets/images/avatars/" . $usrsrow["avatar"] : "assets/images/profile.jpg" ?>" width="50" height="50" alt="">
                        </div>
                        <div class="d-flex flex-1 lt-flex">
                        <div class="data w-100 flex-1">
                            <div class="font15"><?php echo $usrsrow['fullname']; ?></div>
                            <div class="font13 txt-grey"><?php echo $schrow['name']; ?></div>
                        </div>
                        <div class="d-flex">
                        <div class="data text-center">
                            <div class="font17"><?php echo $row['correct']; ?><span class="mob-show">/10</span></div>
                            <div class="font13 txt-grey mob-none">out of 10</div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><span class="mob-show">Time:</span> <?php echo $row['duration']; ?></div>
                            <div class="font13 txt-grey mob-none">Time Duration</div>
                        </div>
                        </div>
                        </div>
                        <div class="d-flex rt-flex">                        
                        <div class="data text-center">
                            <div class="font17"><?php echo $rank; ?></div>
                            <div class="font13 txt-grey">Rank</div>
                        </div>
                        </div>
                    </li>
                    <?php
                } else {
                    ?>
                    <li>
                    <div class="data pe-0">
                            <img class="featured" src="<?php echo isset($usrsrow["avatar"]) ? $baseurl . "assets/images/avatars/" . $usrsrow["avatar"] : "assets/images/profile.jpg" ?>" width="50" height="50" alt="">
                        </div>
                        <div class="d-flex flex-1 lt-flex">
                        <div class="data w-100 flex-1">
                            <div class="font15"><?php echo $usrsrow['fullname']; ?></div>
                            <div class="font13 txt-grey"><?php echo $schrow['name']; ?></div>
                        </div>
                        <div class="d-flex">
                        <div class="data text-center">
                            <div class="font17"><?php echo $row['correct']; ?><span class="mob-show">/10</span></div>
                            <div class="font13 txt-grey mob-none">out of 10</div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><span class="mob-show">Time:</span> <?php echo $row['duration']; ?></div>
                            <div class="font13 txt-grey mob-none">Time Duration</div>
                        </div>
                        </div>
                        </div>
                        <div class="d-flex rt-flex">                        
                        <div class="data text-center">
                            <div class="font17"><?php echo $rank; ?></div>
                            <div class="font13 txt-grey">Rank</div>
                        </div>
                        </div>
                    </li>
                    <?php
                }
             $rank++; $i++;
            }
             if($_SESSION['topic_school_'.$i.''] != $row['userid']) {
                $urrank = 1;
                $younot_qury = mysqli_query($conn, "SELECT a.userid, a.correct, a.duration,a.converttime FROM fastest as a, users as b where a.userid=b.id and a.topicid='".$topicrslt['id']."' and b.school='".$sessionrow['school']."' and a.correct IS NOT NULL and a.correct <> '' and a.correct != 0 ORDER BY a.correct desc,a.duration asc");
                $count_schoolwise = 0;
                while ($younot_rslt = mysqli_fetch_assoc($younot_qury)) {
                    $count_schoolwise++;
                    $usrsSQL = mysqli_query($conn, "SELECT fullname, school, avatar FROM users WHERE id='".$younot_rslt['userid']."' and isAdmin=2 and status=1");
                    $usrsrow = mysqli_fetch_array($usrsSQL, MYSQLI_ASSOC);
    
                    $schSQL = mysqli_query($conn, "SELECT id, name FROM school_management WHERE id='".$usrsrow['school']."' and status=1");
                    $schrow = mysqli_fetch_array($schSQL, MYSQLI_ASSOC);
    
                    if ($_SESSION['id'] == $younot_rslt['userid'] && $count_schoolwise > $limit) { ?>
                        <li class="selected">
                        <div class="data pe-0">
                            <img class="featured" src="<?php echo isset($usrsrow["avatar"]) ? $baseurl . "assets/images/avatars/" . $usrsrow["avatar"] : "assets/images/profile.jpg" ?>" width="50" height="50" alt="">
                        </div>
                        <div class="d-flex flex-1 lt-flex">
                        <div class="data w-100 flex-1">
                            <div class="font15"><?php echo $usrsrow['fullname']; ?></div>
                            <div class="font13 txt-grey"><?php echo $schrow['name']; ?></div>
                        </div>
                        <div class="d-flex">
                        <div class="data text-center">
                            <div class="font17"><?php echo $younot_rslt['correct']; ?><span class="mob-show">/10</span></div>
                            <div class="font13 txt-grey mob-none">out of 10</div>
                        </div>
                        <div class="data text-center">
                            <div class="font17"><span class="mob-show">Time:</span> <?php echo $younot_rslt['duration']; ?></div>
                            <div class="font13 txt-grey mob-none">Time Duration</div>
                        </div>
                        </div>
                        </div>
                        <div class="d-flex rt-flex">                        
                        <div class="data text-center">
                            <div class="font17"><?php echo $rank; ?></div>
                            <div class="font13 txt-grey">Rank</div>
                        </div>
                        </div>
                        </li>
                        <?php
                    }
                    $urrank++; unset($_SESSION['topic_school_'.$i.'']); 
                } 
                  
            }  
            ?>
        </ul>
        </div>
        <?php
    }
} 
    ?>
</div>


        <div class="col-md-4 tab-none">
            <div class="pos-sticky">
            <div class="blk-widget-inner singleUser">
            <div class="header-widget text-center flex-column">
            <img class="featured mb-2" src="<?php echo isset($sessionrow["avatar"]) ? $baseurl . "assets/images/avatars/" . $sessionrow["avatar"] : "assets/images/profile.jpg" ?>" width="100" height="100" alt="">
            <h3><?php echo $sessionrow['fullname']; ?></h3>
            <h5><?php echo $schrow_main; ?></h5>
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

$chk_ovr_qury = mysqli_query($conn, "SELECT a.userid, SUM(a.scorecard) AS correct_answers, ROUND(AVG(a.time_taken), 1) AS average_time_taken FROM leaderboard as a, users as b WHERE b.id=a.userid and b.class='" . $usrrow['class'] . "' and a.class = '" . $usrrow['class'] . "' and b.id IN ($eligibleIds) and b.id='". $_SESSION['id'] ."'  GROUP BY a.userid ORDER BY correct_answers DESC, average_time_taken ASC");
$chk_ovr_rank = mysqli_fetch_array($chk_ovr_qury, MYSQLI_ASSOC);
if(empty($chk_ovr_rank['userid'])) {
    echo "<span class='d-inline' data-bs-toggle='tooltip' data-bs-placement='top' title='Practice atleast 1 correct'>N/A</span>";
}
?>
</span>
                                        </div>
                    <div>School Rank

<span><?php
$correctSQL = "SELECT a.userid, SUM(a.scorecard) AS correct_answers, ROUND(AVG(a.time_taken), 1) AS average_time_taken FROM leaderboard as a, users as b WHERE b.id=a.userid and b.school='" . $usrrow['school'] . "' and b.class='" . $usrrow['class'] . "' and a.class = '" . $usrrow['class'] . "' and b.id IN ($eligibleIds)  GROUP BY a.userid ORDER BY correct_answers DESC, average_time_taken ASC";

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

$chk_sch_qury = mysqli_query($conn, "SELECT a.userid, SUM(a.scorecard) AS correct_answers, ROUND(AVG(a.time_taken), 1) AS average_time_taken FROM leaderboard as a, users as b WHERE b.id=a.userid and b.school='" . $usrrow['school'] . "' and b.class='" . $usrrow['class'] . "' and b.id = '". $_SESSION['id'] ."' and a.class = '" . $usrrow['class'] . "' and b.id IN ($eligibleIds)  GROUP BY a.userid ORDER BY correct_answers DESC, average_time_taken ASC");
$chk_ovr_rank = mysqli_fetch_array($chk_sch_qury, MYSQLI_ASSOC);
if(empty($chk_ovr_rank['userid'])) {
    echo "<span class='d-inline' data-bs-toggle='tooltip' data-bs-placement='top' title='Practice atleast 1 correct'>N/A</span>";
}
?>
</span>

                    </div>
                                        </div>
                </div>

            </div>
        </div>
    </div>
</section>
<?php include("footer.php"); mysqli_close($conn);?>
<?php } else { ?>
<?php #header('Location:'.$baseurl.''); ?>
<?php } ?>