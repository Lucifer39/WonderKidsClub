<?php
include("config/config.php");
$link = $_SERVER[ 'PHP_SELF' ];
$link_array = explode( '/', $link );
$page = end( $link_array );

$chkplan_qury = mysqli_query($conn, "SELECT class,plan,fullname,email,subscribe_at,plan,confirmation_code FROM users WHERE id='".$_SESSION['id']."'");
$chkplan_rslt = mysqli_fetch_array($chkplan_qury, MYSQLI_ASSOC);

if($chkplan_rslt['plan'] == '0') {

    $currentDateTime = date('Y-m-d 00:00:00');

    $acptqury = mysqli_query($conn, "SELECT id, grp_id,userid FROM accept_grp WHERE userid='".$_SESSION['id']."'");
    $acptrslt = mysqli_fetch_array($acptqury, MYSQLI_ASSOC);

    $chkgrpSQL = "SELECT assign_grp FROM assign_grpids as a INNER JOIN grpwise as b ON b.id=a.grpids WHERE a.grpids='".$acptrslt['grp_id']."' and b.status=1 order by a.assign_grp asc";
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

    $chk_teach_qury = mysqli_query($conn, "SELECT DISTINCT subtopic,assign_grp FROM assign_grpids as a INNER JOIN assign_grp as b ON b.id=a.assign_grp WHERE a.assign_grp IN (".$assign_array.") and a.subtopic!='NULL' and b.status=1");  
    //$chk_teach_qury = mysqli_query($conn, "SELECT b.subtopic FROM accept_grp as a INNER JOIN assign_grpids as b ON b.assign_grp=a.grp_id INNER JOIN assign_grp as c ON c.id=a.grp_id WHERE a.userid='".$_SESSION['id']."' and c.status=1");
    $excludedSubtopicIds = [];
    $asgngrpids = [];
    while($chk_teach_rslt = mysqli_fetch_array($chk_teach_qury, MYSQLI_ASSOC))
    {
        $excludedSubtopicIds[] = $chk_teach_rslt['subtopic'];
        $asgngrpids[] = $chk_teach_rslt['assign_grp'];
    }
    
    $excludedSubtopicsString = "'" . implode("','", $excludedSubtopicIds) . "'";

    $dailyques_qury = mysqli_query($conn, "SELECT COUNT(id) as count FROM leaderboard WHERE userid='".$_SESSION['id']."' and created_at >='".$currentDateTime."' and subtopic NOT IN ($excludedSubtopicsString)");
    $dailyques_rslt = mysqli_fetch_array($dailyques_qury, MYSQLI_ASSOC);

    $dailylimit_qury = mysqli_query($conn, "SELECT limit_per_day, offer_start, offer_end FROM for_admin WHERE id=1");
    $dailylimit_rslt = mysqli_fetch_array($dailylimit_qury, MYSQLI_ASSOC);

    $asgngrpids = "'" . implode("','", $asgngrpids) . "'";
    //$acpt_qury = mysqli_query($conn, "SELECT b.subtopic FROM accept_grp as a INNER JOIN assign_grpids as b ON b.assign_grp=a.grp_id INNER JOIN assign_grp as c ON c.id=a.grp_id WHERE a.userid='".$_SESSION['id']."' and b.subtopic='".$sbtpcrow['id']."' and c.status=1");
    $acpt_qury = mysqli_query($conn, "SELECT DISTINCT subtopic FROM assign_grpids WHERE assign_grp IN (".$asgngrpids.") and subtopic='".$sbtpcrow['id']."'");
    $acpt_rslt = mysqli_fetch_array($acpt_qury, MYSQLI_ASSOC);

    if(strtotime($dailylimit_rslt['offer_start']) <= strtotime($currentDateTime) && strtotime($dailylimit_rslt['offer_end']) >= strtotime($currentDateTime) || !empty($acpt_rslt['subtopic'])) {
        $limitMsg = '';
    } elseif($dailylimit_rslt['limit_per_day'] <= $dailyques_rslt['count']) {
        $limitMsg = '<div class="start-widget p-md-5 p-3"><img src="'.$baseurl.'assets/images/oops.png" width="200" height="200"><h2 class="heading mb-0">Your daily limit exceed.</h2><a href="'.$baseurl.'dashboard" class="btn btn-animated btn-lg w-md-50 w-100 mt-md-4 mt-3"> Go to dashboard</a></div>';
    }

}
include("config/config_key.php");
$get_plus_toggle = mysqli_query($conn, "SELECT enable FROM toggle_section_config WHERE section = 'sub_domain_link'");
$get_plus_result = mysqli_fetch_assoc($get_plus_toggle);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
    <meta name="x-ua-compatible" content="IE=edge,chrome=1" http_equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $baseurl; ?>apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $baseurl; ?>favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $baseurl; ?>favicon-16x16.png">
    <link rel="manifest" href="<?php echo $baseurl; ?>site.webmanifest">
    <title>Wonderkids</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="<?php echo $baseurl; ?>assets/bootstrap-5.0.2-dist/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="<?php echo $baseurl; ?>assets/css/style.css?v=<?php echo intval(time() / 100); ?>" type="text/css" rel="stylesheet">
    <script src="<?php echo $baseurl; ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo $baseurl; ?>assets/js/selectdropdown.js"></script>
    <?php if($page == 'index.php') { ?>
    <link href="<?php echo $baseurl; ?>assets/swiper/css/swiper.min.css" type="text/css" rel="stylesheet">
    <script src="<?php echo $baseurl; ?>assets/swiper/js/swiper.min.js"></script>
    <?php } ?>

</head>

<body> 

<?php if(!empty($sucMsg)) { echo $sucMsg; } ?>

<div aria-live="polite" aria-atomic="true" class="position-relative">
  <div class="toast-container position-fixed" style="z-index: 11" id="timer-toast-container">
    <!-- <div class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" id="myToast">
      <div class="toast-header">
        <img src="..." class="rounded me-2" alt="...">
        <strong class="me-auto" id="toast-title"></strong>
        <small class="text-muted">just now</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body" id="toast-body">
      </div>
    </div> -->
  </div>
</div>
<div aria-live="polite" aria-atomic="true" class="position-relative">
  <div class="toast-container position-fixed top-50 start-0 translate-middle-y p-3" style="z-index: 11;" id="toast-container">
    <!-- <div class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" id="myToast">
      <div class="toast-header">
        <img src="..." class="rounded me-2" alt="...">
        <strong class="me-auto" id="toast-title"></strong>
        <small class="text-muted">just now</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body" id="toast-body">
      </div>
    </div> -->
  </div>
</div>
<?php if(isset($_SESSION['id'])) { ?>
<div class="inventory-container hidden" id="inventory-container">
    <div class="toggle-container">
        <button type="button" id="booster-toggle" class="d-flex justify-content-center align-items-center">
            <img src="<?php echo $baseurl; ?>assets/notification_icons/rocket_booster.svg" height="35" width="35" alt="rocket icon">
        </button>
    </div>
    <div class="inventory" id="inventory"></div>
</div>
<?php } ?>

<div class="student-wrapper">
    <header>
        <div class="header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-6 mt-3 mb-3">
                        <a href="<?php echo $baseurl; ?>"><img class="img-fluid" src="<?php echo $baseurl; ?>assets/images/wonderkids-logo.svg" width="216" height="24" alt=""></a>
                    </div>
                    <div class="col-lg-9 col-md-8 col-6 d-flex justify-content-end align-items-center">
                        <div class="top-number text-end tab-none">
                            <!-- <span class="md-txt">24*7 Customer Support</span> -->
                            <?php if(empty($_SESSION['id'])) { ?>
                                <a href="#login" data-bs-toggle="modal" data-bs-target="#loginModal" class="link">Customer Support</a>
                            <?php } else { ?>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#contactModal" class="link">Customer Support</a>
                            <?php } ?>
                        </div>
                        <?php if(empty($_SESSION['id'])) { ?>
                        <a href="#login" data-bs-toggle="modal" data-bs-target="#loginModal" class="icon-link first">
                            <span class="icon"><img src="<?php echo $baseurl; ?>assets/images/user.svg" width="24" height="24" alt=""></span>
                            <span class="md-txt">Login</span>
                        </a>
                        <?php } else { ?>
                            <?php if($sessionrow['isAdmin'] != 1) {
                                $get_student_sql = mysqli_query($conn, "SELECT fullname,avatar FROM users WHERE id = " . $_SESSION['id']);
                                $get_student = mysqli_fetch_assoc($get_student_sql);
                            ?>
                                <a href="<?php echo $baseurl; ?>dashboard" class="mob-none icon-link first">
                                    <span class="icon">
                                        <img src="<?php echo $baseurl; ?>assets/images/dashboard_icon.svg" width="24" height="24" alt="">
                                    </span>
                                    <span class="md-txt">Dashboard</span>
                                </a>
                                <div class="icon-link" data-bs-toggle="dropdown" id="dropdown-nav">
                                    <span class="icon">
                                        <?php if(!isset($get_student["avatar"])){ ?>
                                            <img src="<?php echo $baseurl; ?>assets/images/user.svg" width="24" height="24" alt="">
                                        <?php }else{ ?>
                                            <img src="<?php echo $baseurl; ?>assets/images/avatars/<?php echo $get_student["avatar"]; ?>" width="24" height="24" alt="">
                                        <?php } ?>
                                    </span>
                                    <span class="md-txt"><?php echo explode(" ", $get_student["fullname"])[0] ?? "Dashboard"; ?></span>
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="dropdown-nav">
                                    <li class="desktop-none md-txt"><a class="dropdown-item" href="<?php echo $baseurl; ?>dashboard"><img src="<?php echo $baseurl; ?>assets/images/dashboard_icon.svg" class="me-1 mb-1">Dashboard</a></li>
                                    <li class="md-txt dropdown-submenu dropstart">
                                        <a class="dropdown-item" href="#">
                                            <img src="<?php echo $baseurl; ?>assets/images/about_icon.svg" class="me-1 mb-1">Update Info
                                        </a>

                                        <ul class="dropdown-menu" style="right: 150px" aria-labelledby="dropdown-nav">
                                            <li class="md-txt"><a class="dropdown-item" href="<?php echo $baseurl; ?>chatbot/"><img src="<?php echo $baseurl; ?>assets/images/about_icon.svg" class="me-1 mb-1">Update Profile</a></li>
                                            <li class="md-txt"><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#passwordChangeModal"><img src="<?php echo $baseurl; ?>assets/images/edit_img.svg" class="me-1 mb-1" height="18" width="18">Update Password</a></li>
                                            <li class="md-txt"><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#schoolClassUpdateModal"><img src="<?php echo $baseurl; ?>assets/images/edit_img.svg" class="me-1 mb-1" height="18" width="18">Update Class/School</a></li>
                                        </ul>
                                    </li>


                                    <li class="md-txt"><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#infoModal"><img src="<?php echo $baseurl; ?>assets/images/about_icon.svg" class="me-1 mb-1">Booster Info</a></li>
                                    <li class="md-txt"><a class="dropdown-item" href="<?php echo $baseurl; ?>shortlist/"><img src="<?php echo $baseurl; ?>assets/images/about_icon.svg" class="me-1 mb-1">Practice Shortlist</a></li>
                                     <?php if($get_plus_result["enable"] == 1) { ?>
                                        <li class="md-txt"><a href="<?php echo SUB_DOMAIN_URL; ?>" class="dropdown-item" 
                                            <?php 
                                                if(!empty($_SESSION["id"])){
                                                    echo 'style="display:block"';
                                                }
                                            ?>
                                        >   
                                                <img src="<?php echo $baseurl; ?>assets/images/wonderkids_plus_icon.svg" class="me-1 mb-1">
                                                Wonderkids plus
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li class="md-txt"><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#contactModal"><img src="<?php echo $baseurl; ?>assets/images/contact.svg" class="me-1 mb-1" height="18" width="18">Contact Us</a></li>
                                    <li class="md-txt"><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#messageModal"><img src="<?php echo $baseurl; ?>assets/images/contact.svg" class="me-1 mb-1" height="18" width="18">Messages</a></li>
                                    <li class="md-txt"><a href="<?php echo $baseurl; ?>packages" class="dropdown-item"><img src="<?php echo $baseurl ?>assets/images/subscription_icon.svg" class="me-1 mb-1" height="18" width="18 alt="sub img">Smarty Packs</a></li>
                                    <li class="md-txt"><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#battleModal"><img src="<?php echo $baseurl ?>assets/images/battle_icon.svg" class="me-1 mb-1" height="18" width="18 alt="sub img">Battles</a></li>
                                    <li class="md-txt"><a href="<?php echo $baseurl; ?>logout" class="dropdown-item" >
                                    <img src="<?php echo $baseurl; ?>assets/images/logout.svg" class="me-1 mb-1" height="18" width="18">
                                    Logout
                                    </a></li>
                                </ul>
                            <?php } ?>
                        <?php } 
                        
                        if($get_plus_result["enable"] == 1 && empty($_SESSION["id"])) {?>  
                            <a href="<?php echo SUB_DOMAIN_URL; ?>" class="icon-link first">
                                <span class="icon"><img src="<?php echo $baseurl; ?>assets/images/subdomain_icon.svg" width="24" height="24" alt=""></span>
                                <span class="md-txt">Wonderkids Plus</span>
                            </a>  
                        <?php } ?>                    
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>