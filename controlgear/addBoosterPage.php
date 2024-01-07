<?php 
    include( "../config/config.php" );
    include( "../functions.php" );

    if(empty($_SESSION['id']))
	    header('Location:'.$baseurl.'');

    $sessionsql = mysqli_query($conn, "SELECT id, isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if (isset($_POST['submit'])) {
        // Process other form data
        $name = $_POST["name"];
        $timer = $_POST["timer"];
        $minTime = $_POST["minTime"];
        $score_multiplier = $_POST['scoreMult'];
        $boosterInfo = $_POST['info'];
        $incMult = $_POST['incScoreMult'];

    
        // Process image file
        $targetDirectory = "../assets/notification_icons/";
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $msg = "File is not an image.";
            $uploadOk = 0;
        }

        if(file_exists($targetFile)) {
            $msg = "File already exists";
            $uploadOk = 0;
        }
    
        // Check file size
        if ($_FILES["image"]["size"] > 50000000) {
            $msg = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
    
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" && $imageFileType != 'svg') {
            $msg = "Sorry, only JPG, JPEG, PNG, GIF & SVG files are allowed.";
            $uploadOk = 0;
        }
    
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            // $msg = "Sorry, your file was not uploaded.";
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {

                $imageFileName = basename($_FILES["image"]["name"]);
                // Insert data into MySQL table
                $sql = "INSERT INTO boosters (booster_name, booster_timer, minimum_time, booster_icon, score_multiplier, created_at, updated_at, status, booster_info, incorrect_score_multiplier)
                        VALUES ('$name', '$timer', '$minTime', '$imageFileName', '$score_multiplier', NOW(), NOW(), 1, '$boosterInfo', $incMult)";
    
                if ($conn->query($sql) === TRUE) {
                    $msg = "success";
                } else {
                    $msg = "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $msg = "Sorry, there was an error uploading your file.";
            }
        }
    
        // Close MySQL connection
        $conn->close();

        header( 'location:' . $baseurl . 'controlgear/addBoosterPage?message='. urlencode($msg) );

    }

    if(isset($_POST['update'])) {
        $name = $_POST["name"];
        $timer = $_POST["timer"];
        $minTime = $_POST["minTime"];
        $score_multiplier = $_POST['scoreMult'];
        $boosterInfo = $_POST['info'];
        $incMult = $_POST['incScoreMult'];

        $uploadOk = 1;

        if(!empty($_FILES["image"]['name'])) {
            $targetDirectory = "../assets/notification_icons/";
            $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $msg = "File is not an image.";
                $uploadOk = 0;
            }

            if(file_exists($targetFile)) {
                $msg = "File already exists";
                $uploadOk = 0;
            }
        
            // Check file size
            if ($_FILES["image"]["size"] > 50000000) {
                $msg = "Sorry, your file is too large.";
                $uploadOk = 0;
            }
        
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" && $imageFileType != 'svg') {
                $msg = "Sorry, only JPG, JPEG, PNG, GIF & SVG files are allowed.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                // $msg = "Sorry, your file was not uploaded.";
            } else {
                // If everything is ok, try to upload file
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
    
                    $imageFileName = basename($_FILES["image"]["name"]);
                    // Insert data into MySQL table
                    
                } else {
                    $msg = "Sorry, there was an error uploading your file.";
                }
            }        
        } else {
            $booster_sql = "SELECT * FROM boosters WHERE id = '". $_GET['b_id'] ."'";
            $booster_res = mysqli_query($conn, $booster_sql);
            $booster_row = mysqli_fetch_assoc($booster_res);
            $imageFileName = $booster_row['booster_icon'];
        }

        $sql = "UPDATE boosters 
                SET booster_name = '$name', booster_timer = $timer, score_multiplier = $score_multiplier, minimum_time = $minTime , updated_at = NOW(), booster_info = '$boosterInfo', incorrect_score_multiplier = $incMult
                WHERE id = " . $_GET['b_id'];
        if(mysqli_query($conn, $sql)) {
            $msg = "success";
        } else {
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close MySQL connection
        $conn->close();
        header( 'location:' . $baseurl . 'controlgear/addBoosterPage?message='. urlencode($msg) );

    }

    if(isset($_GET['b_id'])) {
        $booster_sql = "SELECT * FROM boosters WHERE id = '". $_GET['b_id'] ."'";
        $booster_res = mysqli_query($conn, $booster_sql);
        $booster_row = mysqli_fetch_assoc($booster_res);
    }

    if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' ) {
        $errMsg = '<div class="alert alert-success" role="alert">Successfully Saved.</div>';
        echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/addBoosterPage');</script>";
    
    } else if ( isset( $_GET["message"] ) && $_GET['message'] !== 'success' ) {
        $errMsg = '<div class="alert alert-success" role="alert">'. urldecode($_GET['message']) .'</div>';
        echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/addBoosterPage');</script>";
    }
    

?>
<?php if($sessionrow['isAdmin'] == 1) { ?>
    <?php include("header.php"); ?>
    <div class="breadcrumbs-title-container">
		<div class="container-fluid">
			<h5 class="page-title">Add Boosters</h5>
			<div class="breadcrumbs">
				<ul>
					<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
					</li>
					<li>Add Boosters</li>
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
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $booster_row['booster_name'] ?? ""; ?>" required>
                            </div>

                            <div class="mb-1">
                                <label for="info" class="form-label">Bonus:</label>
                                <textarea class="form-control" id="info" name="info" rows="4" required><?php echo $booster_row['booster_info'] ?? ""; ?></textarea>
                            </div>

                            <!-- Image -->
                            <div class="mb-1">
                                <label for="image" class="form-label">Image: <?php echo $booster_row['booster_icon'] ?? ""; ?></label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" <?php echo !isset($_GET["b_id"]) ? "required" : ""; ?>>
                            </div>

                            <!-- Timer -->
                            <div class="mb-1">
                                <label for="timer" class="form-label">Timer (in seconds):</label>
                                <input type="number" class="form-control" id="timer" name="timer" value="<?php echo $booster_row['booster_timer'] ?? ""; ?>" required>
                            </div>

                            <!-- Minimum Time -->
                            <div class="mb-1">
                                <label for="minTime" class="form-label">Minimum Time (in seconds):</label>
                                <input type="number" class="form-control" id="minTime" name="minTime" value="<?php echo $booster_row['minimum_time'] ?? ""; ?>" required>
                            </div>

                            <div class="mb-1">
                                <label for="scoreMult" class="form-label">Score Multiplier:</label>
                                <input type="text" class="form-control" id="scoreMult" name="scoreMult" value="<?php echo $booster_row['score_multiplier'] ?? 1; ?>" required>
                            </div>

                            <div class="mb-1">
                                <label for="incScoreMult" class="form-label">Incorrect Score Multiplier:</label>
                                <input type="text" class="form-control" id="incScoreMult" name="incScoreMult" value="<?php echo $booster_row['incorrect_score_multiplier'] ?? 1; ?>" required>
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