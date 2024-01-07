<?php
ini_set('memory_limit ', '-1');
include("../config/config.php");
include("../functions.php");

$sessionsql = mysqli_query($conn, "SELECT isAdmin,fullname,school,class FROM users WHERE id='".$_SESSION['id']."'");
$sessionrow = mysqli_fetch_assoc($sessionsql);

// Retrieve the data from the POST request
$jsonData = json_decode(file_get_contents('php://input'), true);

// Extract the data
$data = $jsonData['data'];
$qury = mysqli_query($conn, "SELECT id,slug FROM quiz WHERE id='".str_replace('"', '', $data)."'");
$result = mysqli_fetch_assoc($qury);

$html = '';

include('../components/offline_ans.php');

echo $html;
?>