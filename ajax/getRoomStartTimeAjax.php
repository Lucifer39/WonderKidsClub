<?php 
    include("../config/config.php");

    if(isset($_POST['room_code'])) {
        $sql = mysqli_query($conn, "SELECT scheduled_on FROM battle_rooms WHERE id = '". $_POST['room_code'] ."'");
        $res = mysqli_fetch_assoc($sql);

        echo json_encode($res);
    }
?>