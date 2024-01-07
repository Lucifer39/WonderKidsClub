<?php 
include("../config/config.php");
include("../functions.php");
//include("../dynamic/ques_session.php");

$link = $_SERVER[ 'PHP_SELF' ];
$link_array = explode( '/', $link );
$page = end( $link_array );

if(empty($_SESSION['id']))
	header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,id FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

$url = trim($_SERVER["REQUEST_URI"],"/");
$id = substr($url, strpos($url, '=') + 1);

$optstyle_qury = mysqli_query($conn, "SELECT style_id FROM opt_style WHERE quest_id=".$id."");
$optstyle_rslt = mysqli_fetch_array($optstyle_qury);

if($optstyle_rslt['style_id'] == 1) {
    $stloptCls = ' font-md ';
} elseif($optstyle_rslt['style_id'] == 2) {
    $stlCls = ' horizontal-options ';
    $stloptCls = ' font-md ';
} elseif($optstyle_rslt['style_id'] == 3) {
    $stlCls = ' horizontal-options ';
    $stloptCls = ' ht-200 br-grey img-grid';
} elseif($optstyle_rslt['style_id'] == 4) {
    $stloptCls = ' ht-200 br-grey ';
}

if (isset($_POST['reportBtn'])) {
    $quesID = $_POST['subTopid'];
    $report = $_POST['report'];

    mysqli_query( $conn, "update report_question Set remark='".$report."',status='0', updated_at=NOW() WHERE ques_id=".$id."" );
	mysqli_close( $conn );

    $errMsg = '<div class="alert alert-success" role="alert">Thanks for submitting.</div>';
}
?>
<?php if($sessionrow['isAdmin'] == 1) { ?>
<?php include("../header.php"); ?>
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
  });
});
  </script>
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 pe-5">
                            <div class="breadcrumbs st-breadcrumbs mb-5">
                                <span><a href="<?php echo $baseurl; ?>">Home</a></span>
                                <span><?php echo $sbjrow['name']; ?>Test Mode</span>
                            </div>
                            <?php
                             $queSQL = mysqli_query($conn, "SELECT id,question,opt_a,opt_b,opt_c,opt_d,type,type1,correct_ans,shape_info,subtopic,type2 FROM count_quest WHERE id='".$id."'");
                             $querow = mysqli_fetch_array($queSQL, MYSQLI_ASSOC);

                             $sbtpcSQL = mysqli_query($conn, "SELECT id,parent,subtopic FROM topics_subtopics WHERE id ='".$querow["subtopic"]."' and status=1");
                             $sbtpcrow = mysqli_fetch_array($sbtpcSQL, MYSQLI_ASSOC);
                            
                            if($querow['type2'] == 'p1' || $querow['type2'] == 'q1') {
                                $resizeTxt = 'resizeTxt';
                            } else if($querow['subtopic'] =='51') {
                                $resizeTxt = 'txtresize';    
                            } else {
                                $resizeTxt = 'txtresize';
                            }

                            include("../components/dyn_cond.php");
                            
                            ?>
                            <h1 class="page-title mb-4 text-center"><?php echo $querow['question']; ?></h1>
                            <?php include("../components/dyn_ques.php"); ?>
                            <ul class="options multi-btn <?php echo $quesCls.$stlCls; ?>">
                                <li>
                                    <div class="check-btn ">
                                        <input class="form-check-input" type="radio" name="" id="opt_1" readonly>
                                        <div class="label-wrapper <?php echo $optCls.$optA.$stloptCls; if($querow['type2'] == 'p1' && $querow['correct_ans'] == 1) { echo 'right-ans'; } elseif($querow['type2'] == 'p1' && $resulrow['wrong'] == 1) { echo 'wrong-ans'; } ?>"><label for="opt_1"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("../components/dyn_opta.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="" id="opt_2" readonly>
                                        <div class="label-wrapper <?php echo $optCls.$optB.$stloptCls; if($querow['type2'] == 'p1' && $querow['correct_ans'] == 2) { echo 'right-ans'; } elseif($querow['type2'] == 'p1' && $resulrow['wrong'] == 2) { echo 'wrong-ans'; } ?> ?>"><label for="opt_2"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("../components/dyn_optb.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="" id="opt_3" readonly>
                                        <div class="label-wrapper <?php echo $optCls.$optC.$stloptCls; if($querow['type2'] == 'p1' && $querow['correct_ans'] == 3) { echo 'right-ans'; } elseif($querow['type2'] == 'p1' && $resulrow['wrong'] == 3) { echo 'wrong-ans'; } ?> ?>"><label for="opt_3"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("../components/dyn_optc.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="" id="opt_4" readonly>
                                        <div class="label-wrapper <?php echo $optCls.$optD.$stloptCls; if($querow['type2'] == 'p1' && $querow['correct_ans'] == 4) { echo 'right-ans'; } elseif($querow['type2'] == 'p1' && $resulrow['wrong'] == 4) { echo 'wrong-ans'; } ?> ?>"><label for="opt_4"></label>
                                            <span class="notchecked <?php echo $resizeTxt; ?>">
                                            <?php include("../components/dyn_optd.php"); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="text-center mt-4">
                                    <a href="question-bank?id=<?php echo $id; ?>" class="btn bg-orange" target="_blank">Edit Again</a>
                            </div>
                        </div>
                        <div class="col-md-4 mt-md-0 mt-4">
                            <div class="reports-wrapper mb-3">
                            <div class="heading">Question(s) Report</div>
                            <div class="reports">
                            <?php 
                            $rpt_qury = mysqli_query($conn, "SELECT user_id,report,remark FROM report_question WHERE ques_id='".$id."'");
                            while($rpt_rslt = mysqli_fetch_assoc($rpt_qury)) {
                                $stnqury = mysqli_query($conn, "SELECT fullname FROM users WHERE id='".$rpt_rslt['user_id']."'");
                                $stnrslt = mysqli_fetch_assoc($stnqury); ?>
                         <div class="pt-2 pb-2 bt-1">
                         <div class="lg-txt">
                            <?php echo $rpt_rslt['report']; ?></div>
                            <div class="md-txt"><?php echo $stnrslt['fullname'].'('.$rpt_rslt['user_id'].')'; ?>
                            <div class="sm-txt">Remark: <?php echo $rpt_rslt['remark']; ?></div>
                        </div>   
                         </div> 
                            <?php } ?>    
                        </div>
                            </div>
                            <form action="" method="post" class="reportForm">
                            <div class="mb-md-3 mb-2">
                                <div class="input-group input-append"> 
                                    <input type="hidden" name="subTopid" id="subtopic" value=""> 
                                    <textarea rows="5" name="report" id="report" class="form-control" placeholder="Write your remarks" required></textarea>                                 
                                  </div>                                 
                            </div>
                        <div class="mb-2 text-center btn-wrapper">
                        <input type="submit" name="reportBtn" class="btn btn-pink btn-animated btn-lg mw-200" value="Submit">
                    </div>
                    </form>
                    <?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
                        </div>  
                    </div>
                </div>
    </div>
    </section>
    <script>
        var currentDate = new Date();

// Get the current date components
var year = currentDate.getFullYear();
var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
var day = ('0' + currentDate.getDate()).slice(-2);

// Get the current time components
var hours = ('0' + currentDate.getHours()).slice(-2);
var minutes = ('0' + currentDate.getMinutes()).slice(-2);
var seconds = ('0' + currentDate.getSeconds()).slice(-2);

// Create the formatted datetime string
var formattedDatetime = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

$(document).on("click",".reportques",function(){var a=$(this).data("id");$.ajax({url:'<?php echo $baseurl;?>actajax',method:'POST',data:{'reportQuesBnk':a,'datetime':formattedDatetime},success:function(response){$('#submitReport').text('Your query submitted successfully');},
error: function(xhr, status, error) { console.log(error); }})});
    </script>
    <?php include("../footer.php"); mysqli_close($conn);?>
    <?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>