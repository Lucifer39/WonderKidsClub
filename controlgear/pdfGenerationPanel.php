<?php 
    include( "../config/config.php" );
    include( "../functions.php" );

    if(empty($_SESSION['id']))
	    header('Location:'.$baseurl.'');

    $sessionsql = mysqli_query($conn, "SELECT id, isAdmin, type FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    $errMsg;
    $uploadOk = 1;
    $subMsg = "";

    if(isset($_POST["upload"])) {

        $sel_class = $_POST["select-class-upload"];
        $targetDirectory = "../uploads/practice/$sel_class/"; // Specify your desired directory here

        // Loop through each uploaded file
        for ($i = 0; $i < count($_FILES["fileToUpload"]["name"]); $i++) {
            $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"][$i]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    
            // Check file size (you can adjust the size limit)
            if ($_FILES["fileToUpload"]["size"][$i] > 5000000) {
                $errMsg .= "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"][$i])) . " is too large.<br>";
                $uploadOk = 0;
            }
    
            // Allow only certain file formats (you can modify this list)
            if ($imageFileType != "pdf") {
                $errMsg .= "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"][$i])) . " is not allowed.<br>";
                $uploadOk = 0;
            }
    
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $errMsg .= "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"][$i])) . " was not uploaded.<br>";
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $targetFile)) {
                    $errMsg .= "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"][$i])) . " has been uploaded.<br>";
                } else {
                    $errMsg .= "Sorry, there was an error uploading " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"][$i])) . ".<br>";
                }
            }
        }
    
        // Redirect with the error/success message
        header('Location: ' . $baseurl . 'controlgear/pdfGenerationPanel?message=' . urlencode($errMsg));
        exit();
    }

    if(isset($_POST["generate"])) {
        $sql = "TRUNCATE TABLE nomenclature_mapping";
        $result = mysqli_query($conn, $sql);

        if($result) {
            $sql_insert = "INSERT INTO nomenclature_mapping (subtopic_id, class_name, parent_topic_name, subtopic, filename)
            SELECT
                ts.id AS subtopic_id,
                sc.name AS class_name,
                ts1.topic AS parent_topic_name,
                ts.subtopic,
                REGEXP_REPLACE(REGEXP_REPLACE(CONCAT(sc.name, '-', ts1.topic, '-', ts.subtopic, '-ws1.pdf'), ' ', '_'), '[^a-zA-Z0-9.()_-]', '') AS filename
            FROM topics_subtopics ts
            JOIN subject_class sc ON ts.class_id = sc.id
            JOIN topics_subtopics ts1 ON ts.parent = ts1.id
            UNION ALL
            SELECT
                ts.id AS subtopic_id,
                sc.name AS class_name,
                ts1.topic AS parent_topic_name,
                ts.subtopic,
                REGEXP_REPLACE(REGEXP_REPLACE(CONCAT(sc.name, '-', ts1.topic, '-', ts.subtopic, '-ws2.pdf'), ' ', '_'), '[^a-zA-Z0-9.()_-]', '') AS filename
            FROM topics_subtopics ts
            JOIN subject_class sc ON ts.class_id = sc.id
            JOIN topics_subtopics ts1 ON ts.parent = ts1.id
            UNION ALL
            SELECT
                ts.id AS subtopic_id,
                sc.name AS class_name,
                ts1.topic AS parent_topic_name,
                ts.subtopic,
                REGEXP_REPLACE(REGEXP_REPLACE(CONCAT(sc.name, '-', ts1.topic, '-', ts.subtopic, '-ws3.pdf'), ' ', '_'), '[^a-zA-Z0-9.()_-]', '') AS filename
            FROM topics_subtopics ts
            JOIN subject_class sc ON ts.class_id = sc.id
            JOIN topics_subtopics ts1 ON ts.parent = ts1.id
            UNION ALL
            SELECT
                ts.id AS subtopic_id,
                sc.name AS class_name,
                ts1.topic AS parent_topic_name,
                ts.subtopic,
                REGEXP_REPLACE(REGEXP_REPLACE(CONCAT(sc.name, '-', ts1.topic, '-', ts.subtopic, '-ws4.pdf'), ' ', '_'), '[^a-zA-Z0-9.()_-]', '') AS filename
            FROM topics_subtopics ts
            JOIN subject_class sc ON ts.class_id = sc.id
            JOIN topics_subtopics ts1 ON ts.parent = ts1.id
            UNION ALL
            SELECT
                ts.id AS subtopic_id,
                sc.name AS class_name,
                ts1.topic AS parent_topic_name,
                ts.subtopic,
                REGEXP_REPLACE(REGEXP_REPLACE(CONCAT(sc.name, '-', ts1.topic, '-', ts.subtopic, '-ws5.pdf'), ' ', '_'), '[^a-zA-Z0-9.()_-]', '') AS filename
            FROM topics_subtopics ts
            JOIN subject_class sc ON ts.class_id = sc.id
            JOIN topics_subtopics ts1 ON ts.parent = ts1.id";

            $result_insert = mysqli_query($conn, $sql_insert);

            if($result_insert) {
                header('Location: ' . $baseurl . 'controlgear/pdfGenerationPanel?message=' . urlencode("Successfully updated!"));
                exit();
            } else {
                header('Location: ' . $baseurl . 'controlgear/pdfGenerationPanel?message=' . urlencode("Something went wrong!"));
                exit();
            }
        } else {
            header('Location: ' . $baseurl . 'controlgear/pdfGenerationPanel?message=' . urlencode("Something went wrong!"));
            exit();
        }
    }

    if ( isset( $_GET[ 'message' ] )) {
        $errMsg = '<div class="alert alert-success" role="alert">'. $_GET[ 'message' ] .'</div>';
        echo "<script>window.history.pushState('','','" . $baseurl . "controlgear/pdfGenerationPanel');</script>";
    }

    if(isset($_POST['deletePdfClassSubmit'])) {
        $class = $_POST['delete-pdf-class'];

        $directory = '../uploads/practice/'. $class . '/';

        // Get all PDF files in the directory
        $pdfFiles = glob($directory . '*.pdf');

        // Loop through each file and delete it
        foreach ($pdfFiles as $pdfFile) {
            unlink($pdfFile);
        }
    }
?>

<?php if($sessionrow['isAdmin'] == 1) { ?>
    <?php include("header.php"); ?>
	<div class="breadcrumbs-title-container">
		<div class="container-fluid">
			<h5 class="page-title">PDF Generate</h5>
			<div class="breadcrumbs">
				<ul>
					<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
					</li>
					<li>PDF Generate</li>
				</ul>
			</div>
		</div>
	</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="grid bg-white box-shadow-light">
                    <form action="" method="post">
                        <h5 class="heading">Generate Nomenclature</h5>
                        <div class="input-group">
                            <input type="submit" value="Generate" name="generate" class="btn btn-primary custom-btn">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
            <div class="grid bg-white box-shadow-light">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <!-- <input type="file" name="fileToUpload" id="fileToUpload">
                                    <input type="submit" value="Upload File" name="upload"> -->
                                    <h5 class="heading">Upload PDF</h5>
                                    <div class="input-group mb-2">
                                        <select name="select-class-upload" class="select-form">
                                            <option disabled selected>Select Class For Upload</option>
                                            <option value="nursery">Nursery</option>
                                            <option value="prep">Prep</option>
                                            <option value="class_1">Class 1</option>
                                            <option value="class_2">Class 2</option>
                                            <option value="class_3">Class 3</option>
                                            <option value="class_4">Class 4</option>
                                            <option value="class_5">Class 5</option>
                                        </select>
                                    </div>

                                    <div class="input-group mt-2">
                                        <input type="file" class="form-control p-1" id="fileToUpload" name="fileToUpload[]" aria-describedby="inputGroupFileAddon04" aria-label="Upload" multiple>
                                        <button class="btn btn-primary custom-btn m-1 mt-0" type="submit" value="Upload File" name="upload" id="inputGroupFileAddon04">Upload</button>
                                    </div>
                                </form>
							</div>
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
					<!-- <form id="postForm" action="" method="post" enctype="multipart/form-data"> -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="label mb-1">Select Class <span class="required">*</span></label>
									<select name="clsName" id="clsName" onChange="selectClass()" class="custom-select form-control" required>
										<option value="">Please Select</option>
										<?php $catsql = mysqli_query($conn, "SELECT id,name from subject_class WHERE type=2 and status=1 order by id asc");
										while($catrow = mysqli_fetch_array($catsql)) { ?>
											<option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['name']; ?></option>
										<?php } ?>
									</select>
								</div>
								<div id="displaySubject" class="form-group"></div>
								<div id="displayTopic" class="form-group"></div>
								<div id="displaySubTopic" class="form-group"></div>
							</div>
							
						</div>

                        
					<!-- </form> -->
				</div>
			</div>
		</div>
		
	</div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="grid bg-white box-shadow-light">
                    <h5 class="heading">Delete By Class</h5>
                    <form action="" method="post">
                        <div class="input-group mb-2">
                            <select name="delete-pdf-class" class="select-form">
                                <option disabled selected>Select Class For Upload</option>
                                <option value="nursery">Nursery</option>
                                <option value="prep">Prep</option>
                                <option value="class_1">Class 1</option>
                                <option value="class_2">Class 2</option>
                                <option value="class_3">Class 3</option>
                                <option value="class_4">Class 4</option>
                                <option value="class_5">Class 5</option>
                            </select>
                        </div>
                        <div class="input-group mb-2">
                            <input type="submit" name="deletePdfClassSubmit" class="btn btn-primary custom-btn" value="Delete">
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