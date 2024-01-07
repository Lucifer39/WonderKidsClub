<?php include( "../config/config.php" ); 
include( "../functions.php" );

if(empty($_SESSION['id'])) {
header('Location:'.$baseurl.'');
}

$link = $_SERVER[ 'PHP_SELF' ];
$link_array = explode( '/', $link );
$page = end( $link_array );

$usersql = mysqli_query($conn, "SELECT id,fullname,email,contact,school FROM users WHERE id='".$_SESSION['id']."' and status=1");
$userrow = mysqli_fetch_assoc($usersql);

if (isset($_POST['submitpers'])) {
	$fname = $_POST['name'];
	$mobile = $_POST['contact'];
  $school = $_POST['school'];
	$others = $_POST['others'];

	mysqli_query( $conn, "update users Set fullname='".$fname."',contact='".$mobile."',school='".$school."',updated_at=NOW() WHERE id=".$_SESSION['id']."" );
  
  if($school == 'others') {
    mysqli_query( $conn, "INSERT INTO school_management(name,status,userid,created_at,updated_at) VALUES ('".$others."',0,'".$_SESSION['id']."',NOW(),NOW())" );
    
    $schsql = mysqli_query($conn, "select id from school_management order by id desc");
    $schrow = mysqli_fetch_array($schsql, MYSQLI_ASSOC);

    mysqli_query( $conn, "update users Set school='".$schrow['id']."',updated_at=NOW() WHERE id=".$_SESSION['id']."" );
}



  mysqli_close($conn);	
	header('location:profile');
	exit;	
}

$sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == '3') {
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<meta name="x-ua-compatible" content="IE=edge,chrome=1" http_equiv="X-UA-Compatible">
<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no" >
<meta name="msapplication-tap-highlight" content="no">
<meta name="theme-color" content="#">
<title>Wonderkids :: My Profile</title>
<?php require_once('headpart.php'); ?>
</head>
<body id="teacher-wrapper">
<div class="teacher-wrapper">
<?php require_once('left-navigation.php'); ?>  
    <main>
        <div class="lt-260">    
        <?php require_once('header.php'); ?>
    <section class="section pt-0 pb-3 ml-1 mr-1">
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-4 mb-4">
          <ul class="breadcrumbs">
            <li><a href="group"><span>Home</span></a></li>
            <li><span>My Profile : Personal Information</span></li>
          </ul>
        </div>
      </div>
    </div>
    </section>
    <section class="section pt-0 ml-1 mr-1">
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-2">
        <ul class="linklist mt-4">
          <li><a href="profile" class="active">Personal Information</a></li>
          <li><a href="security">Security and logins</a></li>
        </ul> 
      </div>
      <div class="col-md-10">
        <div class="block-widget p-4">
          <div class="mb-4 mt-2">
          <h2 class="section-title">Personal Information</h2>
          </div>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
            <div class="mb-3">
            <label class="label">Fullname</label>
            <input type="text" name="name" class="form-control custom-control" placeholder="Type your name" value="<?php echo $userrow['fullname']; ?>">
          </div>
          <div class="mb-3">
            <label class="label">Email address</label>
            <input type="email" class="form-control custom-control" placeholder="Type your email address" value="<?php echo $userrow['email']; ?>" readonly disabled>
          </div>
          <div class="mb-3">
            <label class="label">Phone number</label>
            <input type="tel" name="contact" class="form-control custom-control" placeholder="Type your phone number" value="<?php echo $userrow['contact']; ?>">
          </div>
          <div class="mb-3">
            <label class="label">School name</label>
            <select name="school" id="school" class="form-select custom-select custom-control">
                                    <option>Please Select</option>
                                    <option value="0" <?php if($userrow['school'] == '0') { echo "selected";} ?>>Others</option>
                                    <?php 
                                    $catsql = mysqli_query($conn, "SELECT id,name from school_management order by name asc");
                                    while($catrow = mysqli_fetch_array($catsql)) {
                                    
                                    $selschsql = mysqli_query($conn, "SELECT id from users WHERE school='".$catrow['id']."' and id='".$_SESSION['id']."'");
                                    $selschrow = mysqli_fetch_array($selschsql);
                                    if (!empty($selschrow['id'])) { ?>
                                        <option value="<?php echo $catrow['id']; ?>" selected><?php echo $catrow['name']; ?></option>
                                      <?php } else { ?>
                                        <option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['name']; ?></option>
                                      <?php } ?>
                                    <?php } ?>
                                    </select>
                                    
          </div>
          <div class="mb-3 others <?php if($userrow['school'] != '0') { echo "hide";} ?>">
                                <input type="text" name="others" class="form-control custom-control" placeholder="Enter school name" value="<?php echo $userrow['school']; ?>">
                            </div>
          <input type="submit" name="submitpers" class="btn btn-red custom-btn" value="Save">
            </div>
          </div>
        </form>
        </div>
      </div>
      </div>
    </div>
    </section>
    </div>
</main>
<div>  
<?php require_once('footer.php'); ?>    
</body>
</html>
<?php mysqli_close($conn); ?>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>