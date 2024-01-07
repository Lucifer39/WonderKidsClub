<?php 
ini_set('max_execution_time', '-1');
ini_set('memory_limit ', '-1');
include("config/config.php");
include("functions.php");

// include autoloader
require_once 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

if(empty($_SESSION['id']))
header('Location:'.$baseurl.'');

$sessionsql = mysqli_query($conn, "SELECT isAdmin,fullname,school,class FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

$chkquiz_qury = mysqli_query($conn, "SELECT id,name FROM quiz WHERE class='".$sessionrow['class']."' and type=2 and status=1");
$chkquiz_rslt = mysqli_fetch_assoc($chkquiz_qury);

$clssql = mysqli_query($conn, "SELECT name FROM subject_class WHERE id='".$sessionrow['class']."' and type=2 and status=1");
$clsrow = mysqli_fetch_assoc($clssql);

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

if($parts[0] == 'paper') {
    $query = mysqli_query($conn, "SELECT id,name,slug,class,subject FROM quiz WHERE slug='".$parts[1]."' and type=2 and status=1");
    $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

    if (isset($_POST['submit'])) {

        $html = '';
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $options->set('tempDir', '/tmp'); //folder name and location can be changed
        $dompdf = new Dompdf($options);

        include('components/offline_ques.php');

        $dompdf->load_html($html);
        $dompdf->set_paper("letter", "portrait" );
        $dompdf->render();
        //$dompdf->set_base_path(''.$baseurl.'assets/css/style.css');
        $attachment = $dompdf->output();

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="'.$result['slug'].'.pdf"');
        header('Content-Length: ' . strlen($attachment));

        echo $attachment;
    }

    if (isset($_POST['ansmit'])) {

        $html = '';
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $options->set('tempDir', '/tmp'); //folder name and location can be changed
        $dompdf = new Dompdf($options);

        include('components/offline_ans.php');

        $dompdf->load_html($html);
        $dompdf->set_paper("letter", "portrait" );
        $dompdf->render();
        //$dompdf->set_base_path(''.$baseurl.'assets/css/style.css');
        $attachment = $dompdf->output();

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="'.$result['slug'].'-answer-sheet.pdf"');
        header('Content-Length: ' . strlen($attachment));

        echo $attachment;
    }
}

if($sessionrow['isAdmin'] == '2' && !empty($chkquiz_rslt['id'])) {
include("header.php"); ?>
<section class="section pb-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs st-breadcrumbs mb-3">
                    <span><a href="<?php echo $baseurl; ?>">Home</a></span>
                    <?php if(!empty($chkquiz_rslt['name'])) { ?>
                        <span><a href="paper">Offline Paper(s)</a></span>
                    <?php } else { ?>
                        <span>Offline Paper(s)</span>
                    <?php } ?>
                    <?php if(!empty($chkquiz_rslt['name'])) { ?>
                        <span><?php echo $chkquiz_rslt['name']; ?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if($parts[1] == $result['slug']) { ?>
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="student-wrapper">
                            <?php $quizQry = mysqli_query($conn, "SELECT subtopic,question,question_id FROM quiz_quest WHERE quizid='".$result['id']."' order by id asc");
                                $questionCount = 1; // Initialize the question count
                                
                                while($quizRslt = mysqli_fetch_array($quizQry, MYSQLI_ASSOC)) {
                                
                                $i=1;   
                                $questQry = mysqli_query($conn, "SELECT question,opt_a,opt_b,opt_c,opt_d,type,type1,correct_ans,subtopic FROM count_quest WHERE id = ".$quizRslt['question_id']."");
                                while($querow = mysqli_fetch_array($questQry, MYSQLI_ASSOC)) { 
                                    
                                $sbtpcSQL = mysqli_query($conn, "SELECT id,parent,subtopic FROM topics_subtopics WHERE id='".$querow['subtopic']."' and parent!=0 and status=1");
                                $sbtpcrow = mysqli_fetch_array($sbtpcSQL, MYSQLI_ASSOC);

                                include("components/dyn_cond.php");
                                ?>
                                <div class="ques-wrapper mx-ma-ques mb-5">
                                <h2 class="page-title mb-2"><?php echo 'Q'.$questionCount.'. '.$querow['question']; ?></h2>
                                <?php include("components/dyn_ques.php"); ?>
                                <div class="options img-sizing">
                                <div class="mt-3">A. <?php include("components/dyn_opta.php"); ?></div>
                                <div class="mt-3">B. <?php include("components/dyn_optb.php"); ?></div>
                                <div class="mt-3">C. <?php include("components/dyn_optc.php"); ?></div>
                                <div class="mt-3">D. <?php include("components/dyn_optd.php"); ?></div>
                                </div>                                
                                </div>

                            <?php  $i++; $questionCount++; } } ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                        <form id="postForm" action="" method="post" enctype="multipart/form-data">
					<button type="submit" name="submit" id="submit" class="btn btn-animated btn-lg pe-sm-4 ps-sm-4 btn-w-100">Download Paper</button>
                    <button type="submit" name="ansmit" id="ansmit" class="btn btn-dark btn-animated btn-lg pe-sm-4 ps-sm-4 btn-w-100 ms-sm-2 mt-sm-0 mt-3">Download Answer</button>
                                </form>
				</div>
                </div>
    </div>
    </section>
    <?php } else { ?>
<section class="section p-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-3">
            <h1 class="page-title txt-navy">Offline Paper(s)</h1>
            <p class="lead">Welcome to the world of learning and discovery for <?php echo $clsrow['name']; ?> students.</p>
            </div>
    <?php 
    $otherCls_qury = mysqli_query($conn, "SELECT a.class_id,a.quizid FROM quiz_other_class as a INNER JOIN quiz as b ON b.id=a.quizid WHERE a.class_id='".$sessionrow['class']."' and b.type=2 and b.status=1");
    while($otherCls_rslt = mysqli_fetch_array($otherCls_qury))
    {
        $otherCls[] = $otherCls_rslt['quizid'];
    }
    
    $pprqury = mysqli_query($conn, "SELECT id,name,slug FROM quiz WHERE (class='".$sessionrow['class']."' and type=2) or (id IN (" . implode(',', $otherCls) . ") AND type = 2) and status=1 order by id desc");
          while($pprslt = mysqli_fetch_array($pprqury, MYSQLI_ASSOC)) { ?>
          <div class="col-lg-3 col-md-6 mb-4">
          <div class="blk-widget-inner offline-ppr"><a href="paper/<?php echo $pprslt['slug'];?>"><h3 class="heading"><?php echo $pprslt['name'];?></h3></a>
          <div class="footer-widget">
          <span><a href="javascript:void(0);" onclick="runQuery();" data-id="<?php echo $pprslt['id'];?>">Questions</a></span>
          <span><a href="javascript:void(0);" onclick="runDQuery();" data-id="<?php echo $pprslt['id'];?>">Answers</a></span>
                                        </div>
                </div>
                </div>
        <?php } ?>
        </div>
    </div>
</section>
    <?php } ?>
    <?php include("footer.php"); mysqli_close($conn); } else { header('Location:'.$baseurl.''); } ?>