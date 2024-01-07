<?php 
    include("../config/config.php");

    $school = $_POST["school"];
    $duplicates = $_POST["duplicates"];

    $duplicate_str = implode(",", $duplicates);

    // echo "UPDATE users SET school = '". $school ."' WHERE school IN (". $duplicate_str .")";
    $sql = mysqli_query($conn, "UPDATE users SET school = '". $school ."' WHERE school IN (". $duplicate_str .")") or die(mysqli_error($conn));

    if($sql) {
        $sql_del = mysqli_query($conn,"DELETE FROM school_management WHERE id IN (". $duplicate_str .")") or die(mysqli_error($conn));
    }
?>