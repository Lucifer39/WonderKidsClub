<?php 
    include("../config/config.php");

    if(isset($_POST['room_code'])) {
        $room_code = $_POST['room_code'];

        $sql = mysqli_query($conn, "SELECT u.id, u.fullname, u.avatar, sm.name AS class, sc.name AS school FROM battle_room_players brp
                                    JOIN users u
                                    ON brp.user_id = u.id
                                    JOIN school_management sm
                                    ON u.school = sm.id
                                    JOIN subject_class sc
                                    ON u.class = sc.id
                                    WHERE brp.room_id = '$room_code'
                                    AND brp.left_room = 0
                                    AND brp.started = 0
                                    AND brp.completed = 0");

        $res_array = array();
        while($row = mysqli_fetch_assoc($sql)) {
            $res_array[] = $row;
        }

        echo json_encode($res_array);
    }
?>