<?php
include( "../config/config.php" );
include( "../functions.php" );

if(empty($_SESSION['id']))
	echo header('Location:'.$baseurl.'controlgear/login');

$usersql = mysqli_query($conn, "SELECT isAdmin,type FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($usersql);

if($sessionrow['isAdmin'] == 1 || $sessionrow['type'] == 99) {
?>
<?php include("header.php"); ?>
<div class="breadcrumbs-title-container">
	<div class="container-fluid align-items-center">
		<h5 class="page-title">Dashboard - </h5>
		<div class="breadcrumbs">
			<ul>
				<li>Welcome, <?php echo $headerrow['fullname']; ?></li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<?php if($sessionrow['type'] == 0) { ?>
			<div class="grid bg-white box-shadow-light">
          <?php $verStud = mysqli_query($conn, "SELECT COUNT(*) as students FROM users where type=1 and status=1"); $verYoung = mysqli_query($conn, "SELECT COUNT(*) as teachers FROM users where type=2 and status=1"); $actStud = mysqli_query($conn, "SELECT COUNT(*) as activeStudent FROM users where type=1 and status!=1"); $actYoung = mysqli_query($conn, "SELECT COUNT(*) as activeYoungProfessional FROM users where type=2 and status!=1");
$verStudrow = mysqli_fetch_assoc($verStud); $verYoungrow = mysqli_fetch_assoc($verYoung); $actStudrow = mysqli_fetch_assoc($actStud); $actYoungrow = mysqli_fetch_assoc($actYoung); ?> 
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
  <tbody>
    <tr>
      <td class="bg-light text-dark">&nbsp;</td>
      <td class="bg-light text-dark"><strong>Verified</strong></td>
      <td class="bg-light text-dark"><strong>Unverified</strong></td>
      <td class="bg-light text-dark"><strong>Total</strong></td>
    </tr>
    <tr>
      <td><strong>Students</strong></td>
      <td><?php echo $verStudrow['students']; ?></td>
      <td><?php echo $actStudrow['activeStudent']; ?></td>
      <td><strong><?php echo $verStudrow['students']+$actStudrow['activeStudent']; ?></strong></td>
    </tr>
    <tr>
      <td><strong>Teachers</strong></td>
      <td><?php echo $verYoungrow['teachers']; ?></td>
      <td><?php echo $actYoungrow['activeYoungProfessional']; ?></td>
      <td><strong><?php echo $verYoungrow['teachers']+$actYoungrow['activeYoungProfessional']; ?></strong></td>
    </tr>
    <tr>
      <td class="bg-light text-dark"><strong>Total</strong></td>
      <td class="bg-light text-dark"><strong><?php echo $verStudrow['students']+$verYoungrow['teachers']; ?></strong></td>
      <td class="bg-light text-dark"><strong><?php echo $actStudrow['activeStudent']+$actYoungrow['activeYoungProfessional']; ?></strong></td>
      <td class="bg-light text-dark"><strong><?php echo $verStudrow['students']+$actStudrow['activeStudent']+$verYoungrow['teachers']+$actYoungrow['activeYoungProfessional'];; ?></strong></td>
    </tr>
  </tbody>
</table>
</div>
        <?php } ?>


		</div>	
</div>
</div>
<?php include("left-navigation.php"); ?>
<?php include("footer.php"); ?>
<?php mysqli_close($conn); ?>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>