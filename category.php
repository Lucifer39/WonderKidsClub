<?php 
include("config/config.php");
include("functions.php");

// if(empty($_SESSION['id']))
// header('Location:'.$baseurl.'');

if(isset($_SESSION['assign_topic'])) {
    header('Location: ../fastest');
    exit();
}

include("dynamic/ques_session.php");

$sessionsql = mysqli_query($conn, "SELECT isAdmin,school,class FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

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

// $prt_1 = $parts[0]; 
// $prt_2 = $parts[1]; 

/*--------live server---------*/
$prt_1 = $parts[1]; 
$prt_2 = $parts[2]; 

$sbjSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE slug='".slugify($prt_1)."' and type=1 and status=1");
$sbjrow = mysqli_fetch_array($sbjSQL, MYSQLI_ASSOC);

$clsSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE slug='".slugify($prt_2)."' and type=2 and status=1");
$clsrow = mysqli_fetch_array($clsSQL, MYSQLI_ASSOC);

include("header.php");

if($sessionrow['isAdmin'] == '2' || empty($_SESSION['id'])) {
?>
<?php ?>
<section class="section pb-0">
    <div class="container">
    <div class="breadcrumbs st-breadcrumbs mb-md-4 mb-3">
                                <span><a href="<?php echo $baseurl; ?>">Home</a></span>
                                <span><?php echo $sbjrow['name']; ?></span>
                                <span><?php echo $clsrow['name']; ?></span>
                            </div>
                            <section class="row pb-2">
                    <div class="col-6 mt-md-0 mt-3 p-1">
                    <?php if(empty($_SESSION['id'])) { ?>
                        <a href="#login" onclick="showWithoutLoginModal()" class="grid-2 btn-animated quiz">
                        <?php } else { ?>
                        <a href="<?php echo $baseurl; ?>shortlist" class="grid-2 btn-animated quiz">
                        <?php } ?>
                            <div class="lt">
                                <h4>Shortlisted Questions</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 mt-md-0 mt-3 p-1">
                    <?php if(empty($_SESSION['id'])) { ?>
                        <a href="#login" onclick="showWithoutLoginModal()" class="grid-2 btn-animated practice">
                        <?php } else { ?>
                        <a href="<?php echo $baseurl; ?>leaderboard" class="grid-2 btn-animated practice">
                        <?php } ?>

                            <div class="lt">
                                <h4>Visit Leaderboard</h4>
                            </div>
                        </a>
                    </div>
                    <!-- <div class="col-4 mt-md-0 mt-3 p-1">
                        <a href="shortlist" class="grid-2 btn-animated quiz">
                            <div class="lt">
                                <h4>Compete Fastest</h4>
                            </div>
                        </a>
                    </div> -->
                </section>
        <div class="mb-5">
            <h1 class="page-title txt-navy"><?php echo $clsrow['name']; ?></h1>
            <p class="lead">Welcome to the world of learning and discovery for <?php echo $clsrow['name']; ?> students.</p>
        </div>
</div>
</section>
<section class="section pt-0 pb-0">
    <div class="container">
    <div class="row mb-3">

        <?php $topicsql = mysqli_query($conn, "SELECT ts.id,ts.topic,ts.class_id,ts.slug FROM topics_subtopics ts LEFT JOIN topic_ranking tr ON tr.topic_id=ts.id WHERE ts.class_id=".$clsrow['id']." and ts.subject_id=".$sbjrow['id']." and ts.parent=0 and ts.status=1 ORDER BY tr.rank ASC");
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

        shuffle($pastelColors);

        $sno = 0;
        while($topicrow = mysqli_fetch_array($topicsql, MYSQLI_ASSOC)) { 
            $sno++;
        $chk_sbtopicsql = mysqli_query($conn, "SELECT ts.id,ts.subtopic,ts.slug,ts.class_id,ts.subject_id FROM topics_subtopics ts LEFT JOIN subtopic_ranking sr ON sr.subtopic_id=ts.id WHERE ts.parent=".$topicrow['id']." and ts.status=1 ORDER BY sr.rank ASC");
        $chk_sbtopicsrow = mysqli_fetch_array($chk_sbtopicsql, MYSQLI_ASSOC);
        if(!empty($chk_sbtopicsrow['id'])) {
        
        ?>
            <div class="accordion mb-3" id="accordionExample">
            <div class="accordion-item" style="background-color: #f5f5dc">  
                <h2 class="accordion-header" id="heading<?=$sno?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$sno?>" aria-expanded="true" aria-controls="collapse<?=$sno?>" style="background-color: <?php echo $pastelColors[$sno % count($pastelColors)]['darker']; ?>">
            <h2 class="section-title d-flex align-items-center"><span><?php echo $topicrow['topic']; ?></span>
            <?php if($topicrow['class_id'] == $sessionrow['class']) { ?>
            <a href="javascript:void(0);" data-topic="<?php echo $topicrow['id']; ?>" class="action-link fastest-topic ms-3"><img src="<?php echo $baseurl; ?>assets/images/fastest_icon.svg" width="25" height="25" alt="fastest img"></a>
        <?php } else if(empty($_SESSION['id'])) { ?> 
            <a href="#" onclick="showWithoutLoginModal()"><img src="<?php echo $baseurl; ?>assets/images/fastest_icon_disabled.svg" width="25" height="25" alt="fastest img"></a>
        <?php } else { ?> 
            <a href="#" class="action-link ms-3" data-bs-toggle='tooltip' data-bs-placement='top' title='Fastest is available only in the registered class.'><img src="<?php echo $baseurl; ?>assets/images/fastest_icon_disabled.svg" width="25" height="25" alt="fastest img"></a>
        <?php } ?>
        </h2>   
                </button>
        </h2>         
        
        <div id="collapse<?=$sno?>" class="accordion-collapse collapse  " aria-labelledby="heading<?=$sno?>" data-bs-parent="#accordionExample">
        <div class="row accordion-body">
         
            <?php $sbtopicsql = mysqli_query($conn, "SELECT ts.id,ts.subtopic,ts.slug,ts.class_id,ts.subject_id FROM topics_subtopics ts LEFT JOIN subtopic_ranking sr ON sr.subtopic_id=ts.id WHERE ts.parent=".$topicrow['id']." and ts.status=1 ORDER BY sr.rank ASC");
            while($sbtopicrow = mysqli_fetch_array($sbtopicsql, MYSQLI_ASSOC)) {
                
            $chkques_qury = mysqli_query($conn, "SELECT id FROM count_quest WHERE subtopic=".$sbtopicrow['id']."");
            $chkques_row = mysqli_fetch_array($chkques_qury, MYSQLI_ASSOC);
                
            if(!empty($chkques_row['id'])) {

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

            $acptgrpSQL = mysqli_query($conn, "SELECT subtopic,assign_grp, grp_name FROM assign_grpids as a INNER JOIN assign_grp as b ON b.id=a.assign_grp WHERE a.assign_grp IN (".$assign_array.") and a.subtopic='".$sbtopicrow['id']."' and b.status=1 order by b.id desc");  
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
                    <a href="<?php echo $_SERVER['REQUEST_URI'].'/'.$topicrow['slug'].'/'.$sbtopicrow['slug']; ?>" data-grp="<?php echo $acptID; ?>" data-id="<?php echo $sbtopicrow['id']; ?>">
                <?php } ?>
                    <h3 class="heading"><?php echo $sbtopicrow['subtopic']; ?></h3>
                    <?php if (!empty($acptgrprow['subtopic'])) { ?>
                    <div class="assign-tag" title="<?php echo $acptgrprow['grp_name'];?>"><img src="../assets/images/school.svg" height="18" alt=""></div>
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
                    <span><a href="<?php echo $_SERVER['REQUEST_URI'].'/'.$topicrow['slug'].'/'.$sbtopicrow['slug']; ?>" data-grp="<?php echo $acptID; ?>" data-id="<?php echo $sbtopicrow['id']; ?>">Practice</a></span>
                    <?php } ?>
                </div>
                </div>
                </div>
                <?php } } ?>
                </div>
        </div>
                </div>

                </div>
        <?php } } ?>
        </div>

    </div>
</section>
<section class="section bg-lightblue pt-lg-5 pb-lg-5 pt-4 pb-4">
            <div class="container pt-md-4 pb-md-4 pb-3">
                <div class="text-center mb-md-4">
                    <h2 class="section-title-lg">Choose your level</h2>
                    <p class="lead mb-0">Most features are available only for your registered class. <br> Start your learning experience and practice each skill till you become Nunber Ninja.</p>
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

                        <a href="<?php echo $baseurl . $subjectrow['slug'].'/'.$sclwiseRow['slug']; ?>" class="btn-animated level-list">
                        <?php  } else { ?>
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
                        <a href="<?php echo $baseurl. $subjectrow['slug'].'/'.$sclwiseRow['slug']; ?>" class="btn-animated level-list">
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
        </section
<?php include("footer.php"); mysqli_close($conn);?>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>