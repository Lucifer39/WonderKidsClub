<?php 
    include("config/config.php");
    include("functions.php");

    if(empty($_SESSION['id']))
    header('Location:'.$baseurl.'');

    $usrSQL = mysqli_query($conn, "SELECT id,school,class FROM users WHERE id='".$_SESSION['id']."' and isAdmin=2 and status=1");
    $usrrow = mysqli_fetch_array($usrSQL, MYSQLI_ASSOC);

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

<!-- <div class="sub-nav">
        <ul class="sub-list">
            <li class="list-item">
                All
            </li>
            <?php 
                while($topicrow = mysqli_fetch_array($topicsSQL, MYSQLI_ASSOC)){
                    ?>
                        <li class="list-item">
                            <?php echo $topicrow["topic_name"]; ?>
                        </li>
                    <?php
                }
            ?>
        </ul>
</div> -->
  <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 pe-lg-5 col-md-12">
                            <div class="breadcrumbs st-breadcrumbs mb-md-4 mb-3">
                                <span><a href="<?php echo $baseurl.'dashboard'; ?>">Home</a></span>
                                <span>Shortlisted Questions</span>
                            </div>
                <?php  //} else {  
                            if($limitMsg == '') { 
                                $quesow = [];
                                $quesTotSQL = mysqli_query($conn, "SELECT question_id AS id FROM shortlist_questions WHERE user_id = '". $_SESSION['id'] ."' ORDER BY RAND()");
                                while($quesTotrow = mysqli_fetch_array($quesTotSQL, MYSQLI_ASSOC)) {
                                    $quesow[] = $quesTotrow['id'];
                                }

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
                                    <input type="button" id="submitButton" name="submit" class="btn btn-orange btn-animated btn-lg mw-200" value="Submit" onclick="submitForm()" disabled>
                                    </div>
                            <div class="w-100 text-end me-2 desktop-none">

                            
                            <div class="submitReport text-center d-inline-block">
                                <a href="#" class="link reportques" onclick="removeShortlist(event)" data-id="<?php echo $querow['id']; ?>"><span class="d-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
</svg>
                                </span>
                                <span class="note">Remove</span></a>
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
                                <div class="mt-3 text-end tab-none">
                                    <div class="submitReport">
                                        <a href="#" class="link reportques" onclick="removeShortlist(event)" data-id="<?php echo $querow['id']; ?>"><span class="me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
</svg>
                                        </span>
                                        <span class="note">Remove From Shortlist</span></a>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
            </div>
        </div>
  </section>
  <?php include("footer.php"); mysqli_close($conn);?>