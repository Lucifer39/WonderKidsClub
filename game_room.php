<?php 
    include("config/config.php");
    include("functions.php");
    include("battle_functions.php");

    if(empty($_SESSION['id']))
    header('Location:'.$baseurl.'');

    $usrSQL = mysqli_query($conn, "SELECT id,school,class FROM users WHERE id='".$_SESSION['id']."' and isAdmin=2 and status=1");
    $usrrow = mysqli_fetch_array($usrSQL, MYSQLI_ASSOC);

    if(!isset($_GET['room'])) {
        header("Location: ". $baseurl);
    }

    $room_id = $_GET['room'];
    
    if(!checkProperPlayer($room_id, $_SESSION['id'])) {
        header('Location:'.$baseurl.'');
    }

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
<?php 
    $topicsSQL = mysqli_query($conn, "SELECT cq.topic AS topic_id, ts.topic AS topic_name FROM shortlist_questions sq 
                                        JOIN count_quest cq
                                        ON sq.question_id = cq.id
                                        JOIN topics_subtopics ts
                                        ON cq.topic = ts.id
                                        WHERE sq.user_id = '". $_SESSION['id'] ."'");
?>
  <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 pe-lg-5 col-md-12">
                            <div class="breadcrumbs st-breadcrumbs mb-md-4 mb-3">
                                <span><a href="<?php echo $baseurl.'dashboard'; ?>">Home</a></span>
                                <span>Game room</span>
                            </div>

                            <div class="timer-wrapper timer-container-waiting-room position-relative border-0 mb-2" style="right: auto">
                                <div class="time-main"><img class="me-2" src="../assets/images/clock-time.svg" width="25" height="25" alt=""><div id="timer"></div></div>
                            </div>
                <?php  //} else {  
                            if($limitMsg == '') { 
                                $quesow = [];
                                $quesTotSQL = getNextQuestion($room_id);

                                if($quesTotSQL == 0) {
                                    header("Location: ". $baseurl . "battle_leaderboard?room=$room_id");
                                }

                                $quesow[] = $quesTotSQL;

                                $getQuesEndTimeSQL = mysqli_query($conn, "SELECT end_time FROM battle_room_questions WHERE room_id = '$room_id' AND ques_id = '$quesTotSQL'");
                                $getQuesEndTimeRes = mysqli_fetch_assoc($getQuesEndTimeSQL);

                                $queSQL = mysqli_query($conn, "SELECT id,question,opt_a,opt_b,opt_c,opt_d,type,type1,correct_ans,shape_info,subtopic,type2 FROM count_quest WHERE id =".$quesow[0]." and status=1");
                            
                                $querow = mysqli_fetch_array($queSQL, MYSQLI_ASSOC);
                            

                            if($querow['type2'] == 'p1' || $querow['type2'] == 'q1') {
                                $resizeTxt = 'resizeTxt';
                            } else if($querow['subtopic'] =='51') {
                                $resizeTxt = 'txtresize';    
                            } else {
                                $resizeTxt = 'txtresize';
                            }

                            if (!empty($querow['question'])) {
                            
                               $sbtpcrow['id'] = $querow['subtopic'];
                               $super_id = $sbtpcrow['id'];
                                if($super_id == '263') {
                                    $sbtpcrow['id'] = $querow['shape_info'];
                                } 
                                include("components/dyn_cond.php");
                            ?>
                            <form id="myForm" action="" method="post" enctype="multipart/form-data" class="mob-bottom-padding">
                            <input type="hidden" name="ques" value="<?php echo $querow['id']; ?>">
                            <input type="hidden" name="room-code" value="<?php echo $room_id; ?>">
                            <?php if($querow['type2'] == 'p1' || $querow['type2'] == 'q1') { ?>
                                <h1 class="page-title mb-2 text-center"><?php echo $querow['question']; ?></h1> 
                            <?php } else { ?>
                            <div class="page-title-wrapper">
                            <h1 class="page-title mb-2 text-center"><?php echo $querow['question']; ?></h1> 
                            </div>
                            <?php } ?>
                            <?php include("components/dyn_ques.php"); ?>
                            <div id="result">
                            <ul class="options multi-btn <?php echo $quesCls.$stlCls; ?>">
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="opt" value="<?php if($querow['type2'] == 'p1') { echo "1"; } else { echo $querow['opt_a']; } ?>" onchange="checkSelection()" id="opt_1" required>
                                        <div class="label-wrapper <?php echo $optCls.$stloptCls; ?>">
                                            <label for="opt_1"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_opta.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="opt" value="<?php if($querow['type2'] == 'p1') { echo "2"; } else { echo $querow['opt_b']; } ?>" onchange="checkSelection()"  id="opt_2" required>
                                        <div class="label-wrapper <?php echo $optCls.$stloptCls; ?>">
                                            <label for="opt_2"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_optb.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="opt" value="<?php if($querow['type2'] == 'p1') { echo "3"; } else { echo $querow['opt_c']; } ?>" onchange="checkSelection()" id="opt_3" required>
                                        <div class="label-wrapper <?php echo $optCls.$stloptCls; ?>">
                                            <label for="opt_3"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_optc.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="opt" value="<?php if($querow['type2'] == 'p1') { echo "4"; } else { echo $querow['opt_d']; } ?>" onchange="checkSelection()" id="opt_4" required>
                                        <div class="label-wrapper <?php echo $optCls.$stloptCls; ?>">
                                            <label for="opt_4"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("components/dyn_optd.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="text-center mt-md-4 mt-3 mb-4 mob-footer-fixed">
                                <div class="w-100 text-start desktop-none">
                                </div>
                            <div class="w-100 ps-2">
                                    <input type="button" id="submitButton" name="submit" class="btn btn-orange btn-animated btn-lg mw-200" value="Submit" onclick="submitForm(this)" disabled>
                                    </div>
                            <div class="w-100 text-end me-2 desktop-none">

                            
                            <div class="submitReport text-center d-inline-block">
                                <div class="p-1">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#battleLeaderboardModal"><img src="<?php echo $baseurl; ?>assets/images/leaderboard_battle.svg" alt="leaderboard icon" width="30" height="30"></a>
                                </div>
                            </div>
                        </div>

                        
                        </div>
                        </div>
                        </form>  
                        <?php } else { ?>
                            <div class="text-center p-5">
                            <h1 class="page-title">You have not shortlisted any questions yet....</h1>
                            </div>                          
                          <?php } } else { echo $limitMsg; } ?>
                </div>
                <div class="col-lg-4 footer-fixed">
                        <div class="rightside-wrapper">
                            <div class="position-stikcy">
                                <div class="mt-3 text-end tab-none" id="battle-leaderboard">
                                <?php 
                                    $getRankingSQL = mysqli_query($conn, "SELECT brp.user_id, brp.score, u.fullname, sm.name AS school, sc.name AS class, u.avatar,
                                                                                    RANK() OVER (ORDER BY brp.score DESC) AS ranking
                                                                            FROM battle_room_players brp
                                                                            JOIN users u ON brp.user_id = u.id
                                                                            JOIN school_management sm ON u.school = sm.id
                                                                            JOIN subject_class sc ON u.class = sc.id
                                                                            WHERE room_id = '$room_id' AND left_room = 0
                                                                            ORDER BY score DESC");
                                ?>

                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 p-2">
                                            <div class="leaderboard-wrapper">
                                                <div class="mb-3 text-md-start text-center d-flex flex-md-row flex-column align-items-center">
                                                    <h2 class="section-title flex-1 mb-2">Leaderboard <span class="note ms-1">- Battles</span></h2>
                                                </div>
                                                <ul class="leaderboard-list overallwise mb-5">
                                                    <?php 
                                                        while($getRankingRow = mysqli_fetch_assoc($getRankingSQL)) {
                                                            ?>
                                                                <li class="<?php echo $getRankingRow['user_id'] == $_SESSION['id'] ? "selected" : ""; ?>">
                                                                    <div class="data pe-0">
                                                                        <img class="featured1" src="<?php echo isset($getRankingRow["avatar"]) ? $baseurl . "assets/images/avatars/" . $getRankingRow["avatar"] : "assets/images/profile.jpg" ?>" width="25" height="25" alt="">
                                                                    </div>
                                                                    <div class="data w-100 text-center p-1">
                                                                        <div class="font15"><?php echo $getRankingRow['fullname'] ?? "Test"; ?></div>
                                                                        <!-- <div class="font13 txt-grey"><?php echo $schrow['name'] ?? "BVB Vidya School"; ?></div> -->
                                                                    </div>
                                                                    <div class="data text-center">
                                                                        <div class="font15"><?php echo $getRankingRow['score'] ?? 100; ?></div>
                                                                        <div class="font13 txt-grey">Score</div>
                                                                    </div>
                                                                    <div class="data text-center flex-1">
                                                                        <div class="font15"><?php echo $getRankingRow['ranking'] ?? 1; ?></div>
                                                                        <div class="font13 txt-grey">Rank</div>
                                                                    </div>
                                                                </li>
                                                            <?php
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            </div>
                            </div>
                    </div>
            </div>
        </div>
  </section>
  <?php include("footer.php"); mysqli_close($conn);?>