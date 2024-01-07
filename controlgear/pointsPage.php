<?php 
     include( "../config/config.php" );
     include( "../functions.php" );
 
     if(empty($_SESSION['id']))
         header('Location:'.$baseurl.'');
 
     $sessionsql = mysqli_query($conn, "SELECT id, isAdmin FROM users WHERE id='".$_SESSION['id']."'");
     $sessionrow = mysqli_fetch_assoc($sessionsql);

     $ptsSQL = "SELECT correct_pts, wrong_pts FROM game_points LIMIT 1";
     $ptsResult = mysqli_query($conn, $ptsSQL);
     $ptsRow = mysqli_fetch_assoc($ptsResult);

     if(isset($_POST["submit"])) {
        $correct = $_POST["correct-pts"];
        $wrong = $_POST["wrong-pts"];

        $updSQL = "UPDATE game_points SET correct_pts = $correct , wrong_pts = $wrong WHERE id = 1;";
        $updResult = mysqli_query($conn, $updSQL);
        if($updResult) {
            header('Location: ' . $baseurl . 'controlgear/pointsPage?message=' . urlencode("Successfully updated!"));
            exit();
        }
     }

     if ( isset( $_GET[ 'message' ] )) {
        $errMsg = '<div class="alert alert-success" role="alert">'. $_GET[ 'message' ] .'</div>';
        echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/pointsPage');</script>";
    }
?>
<?php if($sessionrow['isAdmin'] == 1) { ?>
    <?php include("header.php"); ?>
	<div class="breadcrumbs-title-container">
		<div class="container-fluid">
			<h5 class="page-title">Points</h5>
			<div class="breadcrumbs">
				<ul>
					<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
					</li>
					<li>Points</li>
				</ul>
			</div>
		</div>
	</div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="grid bg-white box-shadow-light">
                    <div id="msg" class="msg">
						<?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
					</div>
                    <form action="" method="post">
                        <h5 class="heading">Points</h5>
                        <div class="row p-2">
                            <div class="col-md-7">
                                <h6 class="p-2">Correct Points</h6>
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="correct-pts" class="form-control w-auto" value="<?php echo $ptsRow['correct_pts']; ?>">
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-md-7">
                                <h6 class="p-2">Wrong Points</h6>
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="wrong-pts" class="form-control w-auto" value="<?php echo $ptsRow['wrong_pts']; ?>">
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-md-7">
                                <input type="submit" class="btn btn-primary custom-btn" value="Save Changes" name="submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include("left-navigation.php"); ?>
<?php include("footer.php"); ?>
<?php mysqli_close($conn); ?>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>