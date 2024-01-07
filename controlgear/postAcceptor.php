<?php
// Get the current month
// Get the current year
$currentYear = date('Y');

// Get the current month
$currentMonth = date('m');

// Create the folder path
$folderPath = '../uploads/questionBank/';
//mkdir($folderPath, 0777, true);

$imageFolder = $folderPath;
  //$imageFolder = "../uploads/blog/";
  reset ($_FILES);
  $temp = current($_FILES);
  if (is_uploaded_file($temp['tmp_name'])){
   
    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.0 500 Invalid file name.");
        return;
    }
    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png", ".jpeg"))) {
        header("HTTP/1.0 500 Invalid extension.");
        return;
    }
    $filename = md5(date('YmdHis')).'.jpg';
    $file = $imageFolder.$filename;
    move_uploaded_file($temp['tmp_name'], $file);
    echo json_encode(array('location' => $file));
  } else {
    header("HTTP/1.0 500 Server Error");
  }
?>