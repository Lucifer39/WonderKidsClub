<?php include( "../config/config.php" ); include( "../functions.php" );

if(empty($_SESSION['id'])) {
header('Location:'.$baseurl.'');
}

$usersql = mysqli_query($conn, "SELECT id,fullname FROM users WHERE confirmation_code='".$_GET['email']."'");
$userrow = mysqli_fetch_assoc($usersql);

$sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

if($sessionrow['isAdmin'] == '3') {
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="x-ua-compatible" content="IE=edge,chrome=1" http_equiv="X-UA-Compatible">
<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no" >
<meta name="msapplication-tap-highlight" content="no">
<meta name="theme-color" content="#">
<title>Wonderkids</title>
<?php require_once('headpart.php'); ?>
</head>
<body>
<div class="teacher-wrapper">
<?php require_once('left-navigation.php'); ?>  
    <main>
        <div class="lt-260">    
        <?php require_once('header.php'); ?>
    <div class="container-fluid">
    
    </div>
    </div>
</main>
<div>  
<?php require_once('footer.php'); ?>             
</body>
</html>
<?php } else { ?>
<?php header('Location:'.$baseurl.''); ?>
<?php } ?>