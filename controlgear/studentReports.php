<?php 
    include( "../config/config.php" );
    include( "../functions.php" );

    if(empty($_SESSION['id']))
	    header('Location:'.$baseurl.'');

    $sessionsql = mysqli_query($conn, "SELECT id, isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if(isset($_GET['select-user'])) {
        $user_id = $_GET['select-user'];
        ?>
            <script>
                var user_id = <?php echo json_encode($user_id); ?>;
            </script>
        <?php
    }
?>
<?php if($sessionrow['isAdmin'] == 1) { ?>
    <?php include("header.php"); ?>
    <div class="breadcrumbs-title-container">
		<div class="container-fluid">
			<h5 class="page-title">Student Reports</h5>
			<div class="breadcrumbs">
				<ul>
					<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
					</li>
					<li>Student Reports</li>
				</ul>
			</div>
		</div>
	</div>
    <div class="container-fluid">
    <div class="row">
            <div class="col-md-12">
                <div class="grid bg-white box-shadow-light">
                    <h5 class="heading">Date Wise</h5>
                    <table id="datalist-student-attempted-datewise" class="table table-hover table-sm custom-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th><input type="text" id="student_name_search" class="form-control"></th>
                                <th><input type="text" id="student_email_search" class="form-control"></th>
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
    </div>

    <?php if(isset($_GET['select-user'])) { 
        $sql_user = 'SELECT u.id, u.fullname AS name, u.email, u.contact, sc.name AS class, u.avatar, sm.name AS school 
                        FROM users u
                        JOIN subject_class sc
                        ON u.class = sc.id
                        JOIN school_management sm
                        ON u.school = sm.id
                        WHERE u.id = ' . $_GET['select-user'];
        $result = mysqli_query($conn, $sql_user);
        $user = mysqli_fetch_assoc($result);

    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="grid bg-white box-shadow-light text-center">
                    <h5 class="heading"><?php echo $user['name']; ?></h5>
                    <div class="p-1"><?php echo $user['class'] . " | "  . $user['school'] ; ?></div>
                    <div class="p-1"><?php echo $user['email']; ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
    <div class="row">
            <div class="col-md-12">
                <div class="grid bg-white box-shadow-light">
                    <h5 class="heading">Date Wise</h5>
                    <table id="datalist-student-datewise" class="table table-hover table-sm custom-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th><input type="text" id="topic_subtopic_classes" class="form-control"></th>
                                <th>Total Questions</th>
                                <th>Total Questions</th>
                                <th>Total Questions</th>
                                <th>Total Questions</th>
                            </tr>
                            <tr>
                                <th width='50'>Sr.No.</th>
                                <th>Class / Topic /Subtopic</th>
                                <th>Today</th>
                                <th>Yesterday</th>
                                <th>Day Before Yesterday</th>
                                <th>Overall</th>
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
                            </tr>
                            <tr>
                                <th width='50'>Sr.No.</th>
                                <th>Class</th>
                                <th>Topic</th>
                                <th>Total Questions Attempted</th>
                                <th>Average Accuracy</th>
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
                            </tr>
                            <tr>
                                <th width='50'>Sr.No.</th>
                                <th>Class</th>
                                <th>Topic</th>
                                <th>Subtopic</th>
                                <th>Total Questions Attempted</th>
                                <th>Average Accuracy</th>
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