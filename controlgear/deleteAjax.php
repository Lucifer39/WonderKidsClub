<?php
	include("../config/config.php");

//School List
if(isset($_POST['delete_schoolList']))
{
	mysqli_query($conn, "DELETE FROM school_management WHERE id=".$_POST['delete_schoolList']."");
}
if(isset($_POST['schoolList_inactive']))
{
	mysqli_query($conn, "update school_management Set status='1' WHERE id=".$_POST['schoolList_inactive']."");
}
if(isset($_POST['schoolList_active']))
{
	mysqli_query($conn, "update school_management Set status='0' WHERE id=".$_POST['schoolList_active']."");
}

//Hero Image List
if(isset($_POST['delete_heroB']))
{
	mysqli_query($conn, "DELETE FROM homepage_banner WHERE id=".$_POST['delete_heroB']."");
}
if(isset($_POST['heroB_inactive']))
{
	mysqli_query($conn, "update homepage_banner Set status='1' WHERE id=".$_POST['heroB_inactive']."");
}
if(isset($_POST['heroB_active']))
{
	mysqli_query($conn, "update homepage_banner Set status='0' WHERE id=".$_POST['heroB_active']."");
}

//Topic and Sub-Topic List
/*if(isset($_POST['delete_tpsubtps']))
{
	mysqli_query($conn, "DELETE FROM topics_subtopics WHERE id=".$_POST['delete_tpsubtps']."");
}*/
if(isset($_POST['tpsubtps_inactive']))
{
	mysqli_query($conn, "update topics_subtopics Set status='1' WHERE id=".$_POST['tpsubtps_inactive']."");
}
if(isset($_POST['tpsubtps_active']))
{
	mysqli_query($conn, "update topics_subtopics Set status='0' WHERE id=".$_POST['tpsubtps_active']."");
}

//Subject
/*if(isset($_POST['delete_subject']))
{
	mysqli_query($conn, "DELETE FROM subject_class WHERE id=".$_POST['delete_subject']."");
}*/
if(isset($_POST['subject_inactive']))
{
	mysqli_query($conn, "update subject_class Set status='1' WHERE id=".$_POST['subject_inactive']."");
}
if(isset($_POST['subject_active']))
{
	mysqli_query($conn, "update subject_class Set status='0' WHERE id=".$_POST['subject_active']."");
}

//Class
/*if(isset($_POST['delete_class']))
{
	mysqli_query($conn, "DELETE FROM subject_class WHERE id=".$_POST['delete_class']."");
}*/
if(isset($_POST['class_inactive']))
{
	mysqli_query($conn, "update subject_class Set status='1' WHERE id=".$_POST['class_inactive']."");
}
if(isset($_POST['class_active']))
{
	mysqli_query($conn, "update subject_class Set status='0' WHERE id=".$_POST['class_active']."");
}

//tyPost
if(isset($_POST['delete_tyPost']))
{
	mysqli_query($conn, "DELETE FROM other_pages WHERE id=".$_POST['delete_tyPost']."");
}
	
//Blog Categories
if(isset($_POST['delete_blogCat']))
{
	mysqli_query($conn, "DELETE FROM blog_categories WHERE id=".$_POST['delete_blogCat']."");
}
if(isset($_POST['blogCat_inactive']))
{
mysqli_query($conn, "update blog_categories Set status='1' WHERE id=".$_POST['blogCat_inactive']."");
}
if(isset($_POST['blogCat_active']))
{
	mysqli_query($conn, "update blog_categories Set status='0' WHERE id=".$_POST['blogCat_active']."");
}

//blog Post
if(isset($_POST['delete_blogPost']))
{
	mysqli_query($conn, "DELETE FROM blog_post WHERE id=".$_POST['delete_blogPost']."");
	mysqli_query($conn, "DELETE FROM blog_relationship WHERE post_id=".$_POST['delete_blogPost']."");
}
if(isset($_POST['blogPost_active']))
{
mysqli_query($conn, "update blog_post Set status='0' WHERE id=".$_POST['blogPost_active']."");
}
if(isset($_POST['blogPost_inactive']))
{
	mysqli_query($conn, "update blog_post Set status='1' WHERE id=".$_POST['blogPost_inactive']."");
}

//Question Bank
if(isset($_POST['delete_quesB']))
{
	mysqli_query($conn, "DELETE FROM count_quest WHERE id=".$_POST['delete_quesB']."");
}
if(isset($_POST['quesB_active']))
{
mysqli_query($conn, "update count_quest Set status='0' WHERE id=".$_POST['quesB_active']."");
}
if(isset($_POST['quesB_inactive']))
{
	mysqli_query($conn, "update count_quest Set status='1' WHERE id=".$_POST['quesB_inactive']."");
}

//Quiz
if(isset($_POST['quizB_active']))
{
mysqli_query($conn, "update quiz Set status='0' WHERE id=".$_POST['quizB_active']."");
}
if(isset($_POST['quizB_inactive']))
{
	mysqli_query($conn, "update quiz Set status='1' WHERE id=".$_POST['quizB_inactive']."");
}


//Students and Teachers
if(isset($_POST['stusers_active']))
{
	mysqli_query($conn, "update users Set status='0' WHERE id=".$_POST['stusers_active']."");
}
if(isset($_POST['stusers_inactive']))
{
	mysqli_query($conn, "update users Set status='1' WHERE id=".$_POST['stusers_inactive']."");
}

if(isset($_POST['admin_stusers_active']))
{
	mysqli_query($conn, "update verified_teachers Set admin_verified='0', updated_at = NOW() WHERE email='".$_POST['admin_stusers_active']."'");
}
if(isset($_POST['admin_stusers_inactive']))
{
	$getVer = mysqli_query($conn, "SELECT admin_verified FROM verified_teachers WHERE email = '".$_POST['admin_stusers_inactive']."'");

	if(mysqli_num_rows($getVer) > 0) {
		mysqli_query($conn, "update verified_teachers Set admin_verified='1', updated_at = NOW() WHERE id='".$_POST['admin_stusers_inactive']."'");
	} else {
		mysqli_query($conn, "INSERT INTO verified_teachers(email,admin_verified,updated_at,created_at) VALUES ('".$_POST['admin_stusers_inactive']."', 1, NOW(), NOW())");
	}
}

//Students and Teachers
if(isset($_POST['reportQues_active']))
{
	mysqli_query($conn, "update report_question Set status='1' WHERE id=".$_POST['reportQues_active']."");
}
if(isset($_POST['reportQues_inactive']))
{
	mysqli_query($conn, "update report_question Set status='0' WHERE id=".$_POST['reportQues_inactive']."");
}

//Reports Question Bank
if(isset($_POST['reportQuesBnk_active']))
{
	mysqli_query($conn, "update report_question_bank Set status='0' WHERE id=".$_POST['reportQuesBnk_active']."");
}
if(isset($_POST['reportQuesBnk_inactive']))
{
	mysqli_query($conn, "update report_question_bank Set status='1' WHERE id=".$_POST['reportQuesBnk_inactive']."");
}


//Home FAQs
if(isset($_POST['home_faqs_active']))
{
	mysqli_query($conn, "update homepage_faqs Set status='0' WHERE id=".$_POST['home_faqs_active']."");
}
if(isset($_POST['home_faqs_inactive']))
{
	mysqli_query($conn, "update homepage_faqs Set status='1' WHERE id=".$_POST['home_faqs_inactive']."");
}
if(isset($_POST['home_faqs_delete']))
{
	mysqli_query($conn, "DELETE FROM homepage_faqs WHERE id=".$_POST['home_faqs_delete']."");
}

//Packages
if(isset($_POST['packages_active']))
{
	mysqli_query($conn, "update plan Set status='0' WHERE id=".$_POST['packages_active']."");
}
if(isset($_POST['packages_inactive']))
{
	mysqli_query($conn, "update plan Set status='1' WHERE id=".$_POST['packages_inactive']."");
}


?>