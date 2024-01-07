<?php 
    include( "../config/config.php" );
    include( "../functions.php" );

    if(empty($_SESSION['id']))
	    header('Location:'.$baseurl.'');

    $sessionsql = mysqli_query($conn, "SELECT id, isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if (isset($_POST['submit'])) {
        // Process other form data
        $booster = $_POST["booster"];
        $minDay = $_POST["minDay"];
        $minQues = $_POST["minQues"];
        $name = $_POST['critName'];
        $info = $_POST['critInfo'];

        $sql = "INSERT INTO booster_criteria (booster, name, info, minimum_day_streak, minimum_questions, created_at, updated_at)
                    VALUES ('$booster', '$name', '$info', '$minDay', '$minQues', NOW(), NOW())";

        if ($conn->query($sql) === TRUE) {
            $msg = "success";
        } else {
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close MySQL connection
        $conn->close();

        header( 'location:' . $baseurl . 'controlgear/addBoosterCriteriaPage?message='. urlencode($msg) );

    }

    if(isset($_POST['update'])) {
        $booster = $_POST["booster"];
        $minDay = $_POST["minDay"];
        $minQues = $_POST["minQues"];
        $name = $_POST['critName'];
        $info = $_POST['critInfo'];

       
        $sql = "UPDATE booster_criteria 
                SET booster = '$booster', name = '$name', info = '$info', minimum_day_streak = $minDay, minimum_questions = $minQues, updated_at = NOW()
                WHERE id = " . $_GET['b_id'];
        if(mysqli_query($conn, $sql)) {
            $msg = "success";
        } else {
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close MySQL connection
        $conn->close();
        header( 'location:' . $baseurl . 'controlgear/addBoosterCriteriaPage?message='. urlencode($msg) );

    }

    if(isset($_GET['b_id'])) {
        $booster_sql = "SELECT * FROM booster_criteria WHERE id = '". $_GET['b_id'] ."'";
        $booster_res = mysqli_query($conn, $booster_sql);
        $booster_row = mysqli_fetch_assoc($booster_res);
    }

    if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' ) {
        $errMsg = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';
        echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/addBoosterCriteriaPage');</script>";
    
    } else if ( isset( $_GET["message"] ) && $_GET['message'] !== 'success' ) {
        $errMsg = '<div class="alert alert-success" role="alert">'. urldecode($_GET['message']) .'</div>';
        echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/addBoosterCriteriaPage');</script>";
    }
    

?>
<?php if($sessionrow['isAdmin'] == 1) { ?>
    <?php include("header.php"); ?>
    <div class="breadcrumbs-title-container">
		<div class="container-fluid">
			<h5 class="page-title">Add Booster Criteria</h5>
			<div class="breadcrumbs">
				<ul>
					<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
					</li>
					<li>Add Booster Criteria</li>
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
                        <form action="" method="post" enctype="multipart/form-data">
                            <!-- Name -->
                            <div class="mb-1">
                                <label for="booster" class="form-label">Select Booster:</label>
                                <select name="booster">
                                    <option value="" selected disabled>Select Booster</option>
                                    <?php 
                                        $booster_sql = mysqli_query($conn, "SELECT id, booster_name FROM boosters");
                                        while($row = mysqli_fetch_assoc($booster_sql)) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php echo isset($_GET['b_id']) && $_GET['b_id'] == $row['id'] ? "selected" : ""; ?>><?php echo $row['booster_name']; ?></option>
                                       <?php } ?>
                                </select>
                            </div>

                            <div class="mb-1">
                                <label for="critName" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="critName" name="critName" value="<?php echo $booster_row['name'] ?? 0; ?>" required>
                            </div>

                            <div class="mb-1">
                                <label for="critInfo" class="form-label">Info:</label>
                                <input type="text" class="form-control" id="critInfo" name="critInfo" value="<?php echo $booster_row['info'] ?? 0; ?>" required>
                            </div>

                            <div class="mb-1">
                                <label for="minDay" class="form-label">Day Streak:</label>
                                <input type="text" class="form-control" id="minDay" name="minDay" value="<?php echo $booster_row['minimum_day_streak'] ?? 0; ?>" required>
                            </div>

                            <div class="mb-1">
                                <label for="minQues" class="form-label">Question Streak:</label>
                                <input type="text" class="form-control" id="minQues" name="minQues" value="<?php echo $booster_row['minimum_questions'] ?? 0; ?>" required>
                            </div>

                            <!-- Submit Button -->
                            <?php if(isset($_GET["b_id"])) { ?>
                                <input type="submit" name="update" value="Update" class="btn btn-primary custom-btn">
                            <?php } else { ?>
                                <input type="submit" name="submit" value="Submit" class="btn btn-primary custom-btn">
                            <?php } ?>
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