<?php 
    include( "../config/config.php" );
    include( "../functions.php" );

    if(empty($_SESSION['id']))
	    header('Location:'.$baseurl.'');

    $sessionsql = mysqli_query($conn, "SELECT id, isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if(isset($_POST["submit"])) {
        if(isset($_POST["subdomainlinkchk"])) {
            mysqli_query($conn, "UPDATE toggle_section_config SET enable = 1 WHERE section = 'sub_domain_link'");
        }
        else{
            mysqli_query($conn, "UPDATE toggle_section_config SET enable = 0 WHERE section = 'sub_domain_link'");
        }

        if(isset($_POST["practicenotificationchk"])) {
            mysqli_query($conn, "UPDATE toggle_section_config SET enable = 1 WHERE section = 'practice_notifications'");
        }
        else{
            mysqli_query($conn, "UPDATE toggle_section_config SET enable = 0 WHERE section = 'practice_notifications'");
        }
    }
?>
<?php if($sessionrow['isAdmin'] == 1) { ?>
    <?php include("header.php"); ?>
    <div class="breadcrumbs-title-container">
        <div class="container-fluid">
		    <h5 class="page-title">Toggle Settings</h5>
			<div class="breadcrumbs">
				<ul>
					<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
					</li>
					<li>Toggle Settings</li>
				</ul>
		    </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form class="grid bg-white box-shadow-light" action="" method="post">
                    <div class="row">
                        <div class="col-md-7">
                            <h3 class="heading">Setting</h3>
                        </div>
                        <div class="col-md-5">
                            <h3 class="heading">Toggle</h3>
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="col-md-7">
                            <h6>Sub domain link</h6>
                        </div>
                        <div class="col-md-5">
                            <div class="btn-group">
                                <?php
                                    $subdomainsql = mysqli_query($conn, "SELECT enable FROM toggle_section_config WHERE section = 'sub_domain_link'");
                                    $subdomainchk = mysqli_fetch_assoc($subdomainsql);
                                ?>
                                <input type="checkbox" name="subdomainlinkchk" class="btn-check" id="subdomainlinkchk" autocomplete="off" <?php echo $subdomainchk["enable"] == 1 ? "checked" : ""; ?>>
                            </div>
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="col-md-7">
                            <h6>Notifications Practice</h6>
                        </div>
                        <div class="col-md-5">
                            <div class="btn-group">
                                <?php
                                    $practicenotifsql = mysqli_query($conn, "SELECT enable FROM toggle_section_config WHERE section = 'practice_notifications'");
                                    $practicenotifchk = mysqli_fetch_assoc($practicenotifsql);
                                ?>
                                <input type="checkbox" class="btn-check" id="practicenotificationchk" name="practicenotificationchk" autocomplete="off" <?php echo $practicenotifchk["enable"] == 1 ? "checked" : ""; ?>>
                            </div>
                        </div>
                    </div>
                    <div class="row p-3">
                        <button type="submit" name="submit" class="btn btn-primary custom-btn">Save changes</button>
                    </div>
                </fo>
            </div>
        </div>
    </div>
<?php include("left-navigation.php"); ?>
<?php include("footer.php"); ?>
<?php mysqli_close($conn); ?>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>