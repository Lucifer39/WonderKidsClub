<?php 
    include( "../config/config.php" );
    include( "../functions.php" );

    if(empty($_SESSION['id']))
	    header('Location:'.$baseurl.'');

    $sessionsql = mysqli_query($conn, "SELECT id, isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if(isset($_GET['select-class'])) {
        $class_id = $_GET['select-class'];
        ?>
            <script>
                var class_id = <?php echo json_encode($class_id); ?>;
            </script>
        <?php
    }
?>
<?php if($sessionrow['isAdmin'] == 1) { ?>
    <?php include("header.php"); ?>
    <div class="breadcrumbs-title-container">
		<div class="container-fluid">
			<h5 class="page-title">Class Reports</h5>
			<div class="breadcrumbs">
				<ul>
					<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
					</li>
					<li>Class Reports</li>
				</ul>
			</div>
		</div>
	</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="grid bg-white box-shadow-light">
                    <h5 class="heading">Select Class</h5>

                    <form action="" method="get">
                            <div class="row">
                                <div class="input-group">
                                    <select name="select-class" id="" class="form-select">
                                        <option disabled <?php echo $class_id ? "" : "selected"; ?>>Select Class</option>
                                        <?php 
                                            $sql = 'SELECT id, name FROM subject_class WHERE status = 1 AND type = 2'; 
                                            $result = mysqli_query($conn, $sql);
                                            
                                            while($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo $class_id && $class_id == $row['id'] ? "selected" : ""; ?>><?php echo $row['name']; ?></option>
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

    <?php if(isset($_GET['select-class'])) { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="grid bg-white box-shadow-light">
                    <h5 class="heading">
                        School Wise
                    </h5>

                    <table id="datalist-school" class="table table-hover table-sm custom-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th><input type="text" id="schools" class="form-control"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th width='50'>Sr.No.</th>
                                <th>School</th>
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
                    <h5 class="heading">School Registration (Last 5 Days)</h5>

                    <table id="datalist-datewise-school" class="table table-hover table-sm custom-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th><input type="text" id="datewise_schools" class="form-control"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th width='50'>Sr.No.</th>
                                <th>School</th>
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