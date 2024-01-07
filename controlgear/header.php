<?php
$link = $_SERVER[ 'PHP_SELF' ];
$link_array = explode( '/', $link );
$page = end( $link_array );

if($page == 'header.php' || $page == 'header') {
include( "../config/config.php" );
header('Location:'.$baseurl.'controlgear/dashboard');	
}

$headersql = mysqli_query($conn, "SELECT * FROM users WHERE id='".$_SESSION['id']."'");
$headerrow = mysqli_fetch_array($headersql);

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="robots" CONTENT="noindex, nofollow"/>
	<title>EdTech</title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="<?php echo $baseurl; ?>assets/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">
	<link href="<?php echo $baseurl; ?>assets/bootstrap-4.4.1/css/bootstrap.min.css" type="text/css" rel="stylesheet">
	<link href="<?php echo $baseurl; ?>assets/bootstrap-select/css/bootstrap-select.min.css" type="text/css" rel="stylesheet">
	<link href="<?php echo $baseurl; ?>assets/perfectscrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet">
	<link href="<?php echo $baseurl; ?>assets/datatables/datatables.min.css" type="text/css" rel="stylesheet">
	<link href="<?php echo $baseurl; ?>assets/css/admin.css" type="text/css" rel="stylesheet" media="all">
	<script src="<?php echo $baseurl; ?>assets/js/jquery-3.5.1.slim.min.js"></script>
	<script src="<?php echo $baseurl; ?>tinymce/tinymce.min.js"></script>
</head>

<?php if($page == 'question-bank.php' || $page == 'editQuiz.php') { ?>
<body onload="selectClass();">
<?php } else { //selQuiz()?>
<body>
<?php } ?>
<?php if(($_SESSION['id'])) { ?>
<div class="dashboard dashboard-wrapper">
			<header class="header">
				<div class="container-fluid">
					<div class="top-bar">
						<div id="bars_button" class="bars_button"><a href="javascript:void(0);" title="Menu"><i class="fa fa-bars"></i></a>
						</div>
						<div class="logo">
							<h1 class="page-title"><a href="<?php echo $baseurl; ?>">EdTech</a></h1>
						</div>
						<div class="top-right">
							<nav>
								<ul class="top-navigation">
									<li><i class="far fa-user"></i> <?php echo $headerrow['fullname']; ?></li>
									<li><a href="<?php echo $baseurl; ?>controlgear/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</header>
			<div class="wrapper">
				<div class="dashboard-panel">	
<?php } else { ?>
		<header class="header">
		<div class="container-fluid text-center">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<h1 class="page-title"><a href="<?php echo $baseurl; ?>">EdTech</a></h1>
			</div>
		</div>
	</header>
<?php } ?>	