<?php
$link = $_SERVER[ 'PHP_SELF' ];
$link_array = explode( '/', $link );
$page = end( $link_array );
include("../config/config_key.php");


if($page == 'left-navigation.php' || $page == 'left-navigation') {
  include( "../config/config.php" );
  header('Location:'.$baseurl.'controlgear/dashboard');	
}

$encoded_encrypted_number = "";
$iv = "";
if(SECRET_KEY) {
    $iv = openssl_random_pseudo_bytes(16);
    $encrypted_number = openssl_encrypt($_SESSION['id'], 'aes-256-cbc', SECRET_KEY, 0, $iv);
    $encoded_encrypted_number = urlencode(base64_encode($encrypted_number));
}


?>

<div class="container-fluid">
      <div id="m_aside_left" class="m_aside_left">
        <div id="m_ver_menu" class="m_aside_menu">
          <ul class="m_menu_nav">
            <li class="m_menu_item_heading">Main</li>
            <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/dashboard" class="m_menu_link" title="Dashboard">
              <div class="m-menu_link_title"><i class="fa fa-tachometer-alt"></i><span class="name">Dashboard</span></div>
              </a></li>
              <?php if($sessionrow['isAdmin'] == 1 && $sessionrow['type'] != 99 || $sessionrow['isAdmin'] == 1 && $sessionrow['type'] == 0) { ?>
                <li class="m_menu_item m_menu_item_submenu"><a href="javascript:void(0);" class="m_menu_link" title="">
                    <div class="m-menu_link_title"><i class="fa fa-user-check"></i><span class="name">Config</span></div>
                  </a>
                  <div class="m_menu_submenu">
                    <ul class="m_menu_subnav">
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/globalConfig" class="m_menu_link" title=""><span class="m-menu_link_title">Global</span></a></li>
                     </ul>
                  </div>	  
            </li>
                
                <li class="m_menu_item m_menu_item_submenu"><a href="javascript:void(0);" class="m_menu_link" title="">
                    <div class="m-menu_link_title"><i class="fa fa-user-check"></i><span class="name">Users</span></div>
                  </a>
                  <div class="m_menu_submenu">
                    <ul class="m_menu_subnav">
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/registeredStudents" class="m_menu_link" title=""><span class="m-menu_link_title">Registered Students</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/registeredTeachers" class="m_menu_link" title=""><span class="m-menu_link_title">Registered Teachers</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/unverifiedUsers" class="m_menu_link" title=""><span class="m-menu_link_title">Unverified Users</span></a></li>
                    </ul>
                  </div>	  
            </li>
            <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/orders" class="m_menu_link" title="Toggle Settings">
              <div class="m-menu_link_title"><i class="far fa-file" aria-hidden="true"></i><span class="name">Orders</span></div>
              </a></li>
            <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/packages" class="m_menu_link" title="Toggle Settings">
              <div class="m-menu_link_title"><i class="far fa-file" aria-hidden="true"></i><span class="name">SmartyPacks (Packages)</span></div>
              </a></li>
            <li class="m_menu_item m_menu_item_submenu"><a href="javascript:void(0);" class="m_menu_link" title="">
              <div class="m-menu_link_title"><i class="far fa-folder"></i><span class="name">Add/Upload Lists</span></div>
              </a>
			<div class="m_menu_submenu">
                    <ul class="m_menu_subnav">
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/schoolManagement" class="m_menu_link" title=""><span class="m-menu_link_title">School Management</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/classList" class="m_menu_link" title=""><span class="m-menu_link_title">Classes</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/subjectList" class="m_menu_link" title=""><span class="m-menu_link_title">Subjects</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/topicList" class="m_menu_link" title=""><span class="m-menu_link_title">Topics / Sub-Topics</span></a></li>
						        </ul>
                  </div>	  
            </li>
            <li class="m_menu_item m_menu_item_submenu"><a href="javascript:void(0);" class="m_menu_link" title="">
              <div class="m-menu_link_title"><i class="far fa-folder"></i><span class="name">Rankings</span></div>
              </a>
			<div class="m_menu_submenu">
                    <ul class="m_menu_subnav">
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/topicRanking" class="m_menu_link" title=""><span class="m-menu_link_title">Topic Ranking</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/subtopicRanking" class="m_menu_link" title=""><span class="m-menu_link_title">Subtopic Ranking</span></a></li>
						        </ul>
                  </div>	  
            </li>
            <li class="m_menu_item m_menu_item_submenu"><a href="javascript:void(0);" class="m_menu_link" title="">
              <div class="m-menu_link_title"><i class="far fa-folder"></i><span class="name">Reports</span></div>
              </a>
			            <div class="m_menu_submenu">
                    <ul class="m_menu_subnav">
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/overallReports" class="m_menu_link" title=""><span class="m-menu_link_title">Overall</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/schoolReports" class="m_menu_link" title=""><span class="m-menu_link_title">School</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/classReports" class="m_menu_link" title=""><span class="m-menu_link_title">Class</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/studentReports" class="m_menu_link" title=""><span class="m-menu_link_title">Student</span></a></li>
						        </ul>
                  </div>	  
            </li>
            <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/dynamic-quest" class="m_menu_link" title="">
              <div class="m-menu_link_title"><i class="fa fa-question"></i><span class="name">Dynamic Question</span></div>
              </a>
            </li>
            <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/dynamic-quest-multiple" class="m_menu_link" title="">
              <div class="m-menu_link_title"><i class="fa fa-question"></i><span class="name">Dynamic Multiple</span></div>
              </a>
            </li>

            <li class="m_menu_item m_menu_item_submenu"><a href="javascript:void(0);" class="m_menu_link" title="">
              <div class="m-menu_link_title"><i class="fa fa-gamepad"></i><span class="name">Gamification</span></div>
              </a>
			            <div class="m_menu_submenu">
                    <ul class="m_menu_subnav">
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/pointsPage" class="m_menu_link" title=""><span class="m-menu_link_title">Points</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/addBoosterPage" class="m_menu_link" title=""><span class="m-menu_link_title">Add Boosters</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/addBoosterCriteriaPage" class="m_menu_link" title=""><span class="m-menu_link_title">Add Booster Criteria</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/boosterPage" class="m_menu_link" title=""><span class="m-menu_link_title">View Boosters</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/boosterCriteriaPage" class="m_menu_link" title=""><span class="m-menu_link_title">View Booster Criteria</span></a></li>
                    </ul>
                  </div>	  
            </li>
            <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/reportQuestion" class="m_menu_link" title="Report Question">
              <div class="m-menu_link_title"><i class="fa fa-flag" aria-hidden="true"></i><span class="name">Report Question(s)</span></div>
              </a></li>
              <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/userQueries" class="m_menu_link" title="Report Question">
              <div class="m-menu_link_title"><i class="fa fa-flag" aria-hidden="true"></i><span class="name">User Queries</span></div>
              </a></li>
              <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/foradmin" class="m_menu_link" title="For Admin">
              <div class="m-menu_link_title"><i class="fa fa-flag" aria-hidden="true"></i><span class="name">For Admin</span></div>
              </a></li>
              <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/toggle_settings" class="m_menu_link" title="Toggle Settings">
              <div class="m-menu_link_title"><i class="fa fa-flag" aria-hidden="true"></i><span class="name">Toggle Settings</span></div>
              </a></li>

            <?php } ?>
            <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/pdfGenerationPanel" class="m_menu_link" title="">
              <div class="m-menu_link_title"><i class="fa fa-question"></i><span class="name">PDF Generate</span></div>
              </a>
            </li>
            <li class="m_menu_item m_menu_item_submenu"><a href="javascript:void(0);" class="m_menu_link" title="">
              <div class="m-menu_link_title"><i class="far fa-sticky-note"></i><span class="name">Quiz/Paper</span></div>
              </a>
			<div class="m_menu_submenu">
                    <ul class="m_menu_subnav">
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/createQuiz" class="m_menu_link" title=""><span class="m-menu_link_title">Create Quiz/Paper</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/listQuiz" class="m_menu_link" title=""><span class="m-menu_link_title">List of Quiz/Paper</span></a></li>
                      </ul>
                  </div>	  
            </li>
            <li class="m_menu_item m_menu_item_submenu"><a href="javascript:void(0);" class="m_menu_link" title="">
              <div class="m-menu_link_title"><i class="far fa-sticky-note"></i><span class="name">Question Bank</span></div>
              </a>
			<div class="m_menu_submenu">
                    <ul class="m_menu_subnav">
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/question-bank" class="m_menu_link" title=""><span class="m-menu_link_title">Add Question</span></a></li>
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/questionList" class="m_menu_link" title=""><span class="m-menu_link_title">Questions List</span></a></li>
                      </ul>
                  </div>	  
            </li>
            <?php if($sessionrow['isAdmin'] == 1 && $sessionrow['type'] != 99 || $sessionrow['isAdmin'] == 1 && $sessionrow['type'] == 0) { ?>
              <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/deleteQuestions" class="m_menu_link" title="">
                <div class="m-menu_link_title"><i class="fa fa-question"></i><span class="name">Delete Questions</span></div>
                </a>
              </li>
              <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/deleteBugQuestions" class="m_menu_link" title="">
                <div class="m-menu_link_title"><i class="fa fa-question"></i><span class="name">Delete Bug Questions</span></div>
                </a>
              </li>
              <li class="m_menu_item m_menu_item_submenu"><a href="javascript:void(0);" class="m_menu_link" title="">
              <div class="m-menu_link_title"><i class="far fa-folder"></i><span class="name">Homepage</span></div>
              </a>
			      <div class="m_menu_submenu">
                    <ul class="m_menu_subnav">
                    <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/homeBanner" class="m_menu_link" title=""><span class="m-menu_link_title">Sliding Banners</span></a></li>
                    <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/homeFaqs" class="m_menu_link" title=""><span class="m-menu_link_title">FAQs</span></a></li>
                    </ul>
                  </div>	  
            </li>
              <li class="m_menu_item m_menu_item_submenu"><a href="javascript:void(0);" class="m_menu_link" title="">
              <div class="m-menu_link_title"><i class="far fa-folder"></i><span class="name">Other Pages</span></div>
              </a>
			<div class="m_menu_submenu">
                    <ul class="m_menu_subnav">
                    <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/privacy" class="m_menu_link" title=""><span class="m-menu_link_title">Privacy Policy</span></a></li>
						<li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/disclaimer" class="m_menu_link" title=""><span class="m-menu_link_title">Disclaimer</span></a></li>
						<li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/tnc" class="m_menu_link" title=""><span class="m-menu_link_title">Terms &amp; Conditions</span></a></li>
						<li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/copyright" class="m_menu_link" title=""><span class="m-menu_link_title">Copyright Notice</span></a></li>
                    </ul>
                  </div>	  
            </li>
            <!--<li class="m_menu_item m_menu_item_submenu"><a href="javascript:void(0);" class="m_menu_link" title="">
              <div class="m-menu_link_title"><i class="far fa-folder"></i><span class="name">Blog Management</span></div>
              </a>
			<div class="m_menu_submenu">
                    <ul class="m_menu_subnav">
                      <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/blogCategories" class="m_menu_link" title=""><span class="m-menu_link_title">Blog Category</span></a></li>
						<li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/blogPost" class="m_menu_link" title=""><span class="m-menu_link_title">Blog Post</span></a></li>
                    </ul>
                  </div>	  
            </li>-->
            <li class="m_menu_item"><a href="<?php echo SUB_DOMAIN_URL; ?>admin/<?php echo "?data=" . $encoded_encrypted_number . "&iv=" . urlencode($iv); ?>" class="m_menu_link" title="">
                <div class="m-menu_link_title"><i class="fa fa-share"></i><span class="name">Plus Admin</span></div>
                </a>
            </li>
            <?php } ?>
			  <li class="m_menu_item"><a href="<?php echo $baseurl; ?>controlgear/change-password" class="m_menu_link" title="">
              <div class="m-menu_link_title"><i class="fa fa-key"></i><span class="name">Change Password</span></div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>