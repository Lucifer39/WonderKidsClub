<?php 
        include( "../config/config.php" );
        include( "../functions.php" );
    
        if(empty($_SESSION['id']))
            header('Location:'.$baseurl.'');
    
        $sessionsql = mysqli_query($conn, "SELECT id, isAdmin FROM users WHERE id='".$_SESSION['id']."'");
        $sessionrow = mysqli_fetch_assoc($sessionsql);
?>

<?php if($sessionrow['isAdmin'] == 1) { ?>
    <?php include("header.php"); ?>
    <div class="breadcrumbs-title-container">
		<div class="container-fluid">
			<h5 class="page-title">Boosters</h5>
			<div class="breadcrumbs">
				<ul>
					<li><a href="<?php echo $baseurl; ?>controlgear/dashboard/"><i class="fa fa-home"></i></a>
					</li>
					<li>Boosters</li>
				</ul>
			</div>
		</div>
	</div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="grid bg-white box-shadow-light">
                    <h5 class="heading">Booster List</h5>
                    <table id="datalist" class="table table-hover table-sm custom-table">
                        <thead>
                            <tr>
                                <th width='25'>ID</th>
                                <th>Name</th>
                                <th>Icon</th>
                                <th>Info</th>
                                <th width='30'>Score Multiplier</th>
                                <th width='30'>Incorrect Multiplier</th>
                                <th>Timer (in secs)</th>
                                <th>Minimum Answer Time (in secs)</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
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