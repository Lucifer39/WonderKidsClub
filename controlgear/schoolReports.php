<?php 
    include( "../config/config.php" );
    include( "../functions.php" );

    if(empty($_SESSION['id']))
	    header('Location:'.$baseurl.'');

    $sessionsql = mysqli_query($conn, "SELECT id, isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if(isset($_GET['select-school'])) {
        $school_id = $_GET['select-school'];
        ?>
            <script>
                var school_id = <?php echo json_encode($school_id); ?>;
            </script>
        <?php
    }
?>
<?php if($sessionrow['isAdmin'] == 1) { ?>
    <?php include("header.php"); ?>
    <div class="breadcrumbs-title-container">
		<div class="container-fluid">
			<h5 class="page-title">School Reports</h5>
			<div class="breadcrumbs">
				<ul>
					<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
					</li>
					<li>School Reports</li>
				</ul>
			</div>
		</div>
	</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="grid bg-white box-shadow-light">
                    <h5 class="heading">Select School</h5>

                    <form action="" method="get">
                            <div class="row">
                                <div class="input-group">
                                    <select name="select-school" id="" class="form-select">
                                        <option disabled <?php echo $school_id ? "" : "selected"; ?>>Select School</option>
                                        <?php 
                                            $sql = 'SELECT id, name FROM school_management WHERE status = 1'; 
                                            $result = mysqli_query($conn, $sql);
                                            
                                            while($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo $school_id && $school_id == $row['id'] ? "selected" : ""; ?>><?php echo $row['name']; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group">
                                    <input type="submit" value="Submit" class="btn btn-primary custom-btn">
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($_GET['select-school'])) { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="grid bg-white box-shadow-light">
                    <h5 class="heading">Class Wise</h5>

                    <table id="datalist-class" class="table table-hover table-sm custom-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th><input type="text" id="classes" class="form-control"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th width='50'>Sr.No.</th>
                                <th>Class</th>
                                <th>Registrations</th>
                                <th>Visitors</th>
                                <th>Average Accuracy</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid bg-white box-shadow-light">
                    <h5 class="heading">Student Wise</h5>

                    <table id="datalist-datewise-student" class="table table-hover table-sm custom-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th><input type="text" id="student_datewise_names" class="form-control"></th>
                                <th><input type="text" id="student_datewise_emails" class="form-control"></th>
                                <th><input type="text" id="student_datewise_schools" class="form-control"></th>
                                <th><input type="text" id="student_datewise_classes" class="form-control"></th>
                                <th>Total Questions</th>
                                <th>Total Questions</th>
                                <th>Total Questions</th>
                                <th>Total Questions</th>
                                <th></th>
                            </tr>
                            <tr>
                                <th width='50'>Sr.No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>School</th>
                                <th>Class</th>
                                <th>Today</th>
                                <th>Yesterday</th>
                                <th>Day Before Yesterday</th>
                                <th>Overall</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid bg-white box-shadow-light">
                    <h5 class="heading">Topic Wise</h5>

                    <table id="datalist-topic" class="table table-hover table-sm custom-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th><input type="text" id="topic_classes" class="form-control"></th>
                                <th><input type="text" id="topics" class="form-control"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th width='50'>Sr.No.</th>
                                <th>Class</th>
                                <th>Topic</th>
                                <th>Total Questions Attempted</th>
                                <th>Average Accuracy</th>
                                <th>Distinct Students</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid bg-white box-shadow-light">
                    <h5 class="heading">Subtopic Wise</h5>
                    <table id="datalist-subtopic" class="table table-hover table-sm custom-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th><input type="text" id="subtopic_classes" class="form-control"></th>
                                <th><input type="text" id="subtopic_topics" class="form-control"></th>
                                <th><input type="text" id="subtopics" class="form-control"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th width='50'>Sr.No.</th>
                                <th>Class</th>
                                <th>Topic</th>
                                <th>Subtopic</th>
                                <th>Total Questions Attempted</th>
                                <th>Average Accuracy</th>
                                <th>Distinct Students</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid bg-white box-shadow-light">
                    <h5 class="heading">Class Registration (Last 5 Days)</h5>

                    <table id="datalist-datewise-class" class="table table-hover table-sm custom-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th><input type="text" id="datewise_classes" class="form-control"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th width='50'>Sr.No.</th>
                                <th>Class</th>
                                <th>#Registrations</th>
                                <th>#Distinct Users</th>
                                <th>Avg. Attempted Questions per User</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php include("left-navigation.php"); ?>
<?php include("footer.php"); ?>
<?php mysqli_close($conn); ?>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>