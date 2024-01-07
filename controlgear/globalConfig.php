<?php 
    include( "../config/config.php" );
    include( "../functions.php" );

    if(empty($_SESSION['id']))
	    header('Location:'.$baseurl.'');

    $sessionsql = mysqli_query($conn, "SELECT id, isAdmin, type FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    $getQuesDataSQL = mysqli_query($conn, "SELECT * FROM config WHERE name = 'ques_before_login'");
    $getQuesDataRow = mysqli_fetch_assoc($getQuesDataSQL);

    if(isset($_POST['save'])) {
        $configId = $_POST['config-id'];
        $configValue = $_POST['numQues'];
        $currentDateTime = date('Y-m-d h:m:i');

        $updSql = mysqli_query($conn, "UPDATE config SET value = '$configValue', updated_at = '$currentDateTime', created_at = '$currentDateTime' WHERE id = '$configId'");

        if($updSql) {
            header('Location: ' . $baseurl . 'controlgear/globalConfig?message=' . urlencode("Successfully updated!"));
            exit();
        } else {
            header('Location: ' . $baseurl . 'controlgear/globalConfig?message=' . urlencode("Something went wrong! Error: " . $conn->error));
            exit();
        }
    }

    if ( isset( $_GET[ 'message' ] )) {
        $errMsg = '<div class="alert alert-success" role="alert">'. $_GET[ 'message' ] .'</div>';
        echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/globalConfig');</script>";
    }
?>

<?php if($sessionrow['isAdmin'] == 1) { ?>
    <?php include("header.php"); ?>

    <div class="breadcrumbs-title-container">
		<div class="container-fluid">
			<h5 class="page-title">Global Settings</h5>
			<div class="breadcrumbs">
				<ul>
					<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
					</li>
					<li>Global Settings</li>
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
                    <h5 class="heading">Settings</h5>
                    <form action="" method="post">
                        <div class="input-group mb-3 row">
                            <input type="hidden" name="config-id" value="<?php echo $getQuesDataRow['id']; ?>">
                            <div class="col-md-5">
                                Questions Allowed Before Login
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="numQues" class="form-control w-auto" value="<?php echo $getQuesDataRow['value'] ?? 5; ?>">
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="submit" name="save" value="Save Changes" class="btn btn-primary custom-btn">
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