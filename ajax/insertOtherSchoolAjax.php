<?php 
    include('../config/config.php');

    if($_POST['school_name'] == 0) {
        echo json_encode("");
    } else {
        $sql = "INSERT INTO school_management (userid, name, status, created_at, updated_at) VALUES ('". $_SESSION['id'] ."', '". $_POST['school_name'] ."', 1, NOW(), NOW())";
        $result = mysqli_query($conn, $sql);

        if($result) {
            echo json_encode(mysqli_insert_id($conn));
            // echo "Hello";
        } else {
            echo "not helo";
        }
    }
?>