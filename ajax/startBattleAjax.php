<?php 
    include("../config/config.php");

    function startRoom($room_id) {
        global $conn;

        $sql = mysqli_query($conn, "UPDATE battle_rooms SET started = 1 WHERE id = '$room_id'");

        if($sql) {
            return true;
        } else {
            return false;
        }
    }

    function startRoomPlayer($room_id, $user_id) {
        global $conn;

        $sql = mysqli_query($conn, "UPDATE battle_room_players SET started = 1 WHERE room_id = '$room_id' AND user_id = '$user_id'");

        if($sql) {
            return true;
        } else {
            return false;
        }
    }

    if(isset($_POST['room_code']) && isset($_POST['user_id'])) {
        echo json_encode(startRoom($_POST['room_code']) && startRoomPlayer($_POST['room_code'], $_POST['user_id']));
    }
?>