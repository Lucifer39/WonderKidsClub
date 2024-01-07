<?php 
    include('../config/config.php');

    $sql = "UPDATE users 
            SET school = '". $_POST['school_id'] ."' , class = '". $_POST['class_id'] ."'
            WHERE id = '". $_SESSION['id'] . "'";

    $result = mysqli_query($conn, $sql);

    if($result) {
        echo json_encode("success");
    } else {
        echo json_encode("not success");
    }
?>