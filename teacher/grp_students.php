<?php include( "../config/config.php" ); 
include( "../functions.php" );

if(empty($_SESSION['id'])) {
header('Location:'.$baseurl.'');
}

$link = $_SERVER[ 'PHP_SELF' ];
$link_array = explode( '/', $link );
$page = end( $link_array );

$url = trim($_SERVER["REQUEST_URI"],"/");
$id = substr($url, strpos($url, '=') + 1);

$grpSQL = mysqli_query($conn, "SELECT name FROM grpwise WHERE id=".$id."");
$grpROW = mysqli_fetch_array($grpSQL, MYSQLI_ASSOC);

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
<title>Wonderkids :: Group</title>
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
            <li><span>Groups</span></li>
            <li><span>Students List</span></li>
          </ul>
        </div>
        <div class="col-md-12 d-flex align-items-center">
            <h2 class="section-title"><?php echo $grpROW['name']; ?></h2>
            <div class="flex-grow-1 text-end">
              <a href="group" class="btn btn-red custom-btn">Back</a>
            </div>
            </div>
      </div>
    </div>
    </section>
    <section class="section pt-0 ml-1 mr-1">
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="block-widget">
          <div class="mb-2">
        <input class="form-control" id="myInput" type="text" placeholder="Search..">
        </div>
        <div class="table-responsive">
          <table id="myTable" cellpadding="0" cellspacing="0" class="table custom-table">
            <thead>
              <tr>
                <th>Student Name</th>
                <th>Email</th>
                <th>Email (Optional)</th>
                <th>Status</th>
                <th width="90"></th>
</tr>
            </thead>
            <tbody>
              <?php $i=1; $tch_usr_qury = mysqli_query($conn, "SELECT id,name,email,optional,status FROM tch_grp_usr_list WHERE grp_id=".$id."");
              while($tch_usr_row = mysqli_fetch_array($tch_usr_qury, MYSQLI_ASSOC)) { ?>
             <tr><td vaign="middle"><?php echo $tch_usr_row['name']; ?></td>
              <td vaign="middle"><?php echo $tch_usr_row['email']; ?></td>
              <td vaign="middle"><?php echo $tch_usr_row['optional']; ?></td>
              <td width="50"><div class="form-check form-switch custom-switch">
  <input class="form-check-input notselect" name="grpcheck" type="checkbox" data-id="<?php echo $tch_usr_row['id']; ?>" value="<?php echo $tch_usr_row['status'];?>" role="switch" id="flexSwitchCheckDefault_<?php echo $i; ?>" <?php if($tch_usr_row['status'] == '1') { echo "checked"; } else { echo " ";} ?> />
  <label class="form-check-label" for="flexSwitchCheckDefault_<?php echo $i; ?>"></label>
</div></td>
<td><a href="javascript:void(0);" title="Edit" class="edit" data-toggle="modal" data-id="9" data-name="LVIS Noida" data-short="" data-target="#editmodal"><img src="../assets/images/edit-ico.svg"></a> <a href="javascript:void(0);" title="Delete" data-id="<?php echo $tch_usr_row['id'];?>" class="delete"><img src="../assets/images/delete-ico.svg"></a></td>
              </tr>
              <?php $i++; } ?>
            </tbody>
          </table>
        </div>
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