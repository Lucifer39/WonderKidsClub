<?php 
    $dir = __DIR__;
    $parent = dirname($dir);
    $parentdir = dirname($parent);

    require_once($parentdir . "/connection/conn.php");
    require_once($parentdir . "/connection/dependencies.php");
    require_once("room_joining.php");
    require_once("room_generation.php");

    function assign_room($user_id){
        $flag = false;
        $conn = makeConnection();

        $sql = "SELECT * FROM type_rooms WHERE player_count < max_player_count AND type_rooms.type = 'typing_race' AND type_rooms.started = 0 AND type_rooms.completed <> 1 LIMIT 1";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed in assign_room: " . $conn->error);
        }

        $res = $result->fetch_assoc();

        $result_check = 0;

        if(mysqli_num_rows($result) > 0){
            $sql_check = "SELECT * FROM type_players WHERE room_id = '". $res["room_id"] ."' AND student_id = ". $user_id ." AND left_room = 1;";
            $result_check = $conn->query($sql_check);
        }


        $room_id = 0;

        if(mysqli_num_rows($result) == 0){
            $currentDateTime = date('Y-m-d H:i:s');
            $room_id = json_decode(createRoom(0, 2, "typing_race", $currentDateTime));
            $flag = true;
        }
        else{
            $room_id = $res["room_id"];
        }

        join_room($room_id, $user_id, 0, "typing_race");

        if($flag){
            $sql_time_keeper = "UPDATE type_players SET typing_race_time_keeper = 1 WHERE student_id = ". $user_id ." AND room_id = '". $room_id ."';";
            $result = $conn->query($sql_time_keeper);

            if(!$result){
                die("Query failed in assign_room time_keeper: " . $conn->error);
            }
        }

        return json_encode($room_id);
    }  

    function get_player_count($room_id){
        $conn = makeConnection();

        $sql = "SELECT player_count FROM type_rooms WHERE room_id = '". $room_id ."';";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed in get_player_count: " . $conn->error);
        }

        $res = $result->fetch_assoc();
        return $res["player_count"];
    }

    function set_room_time($room_id){
        $conn = makeConnection();

        $sql = "UPDATE type_rooms SET room_timer = room_timer - 1 WHERE room_id = '". $room_id ."';";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed in set_room_time: " . $conn->error);
        }

        return;
    }

    function get_room_time($room_id){
        $conn = makeConnection();

        $sql = "SELECT room_timer FROM type_rooms WHERE room_id = '". $room_id ."';";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed in get_room_time: " . $conn->error);
        }

        $res = $result->fetch_assoc();

        get_time_keeper($room_id);

        return json_encode($res["room_timer"]);

    }

    function get_time_keeper($room_id){
        $conn = makeConnection();

        $sql = "SELECT student_id FROM type_players WHERE room_id = '". $room_id ."' AND typing_race_time_keeper = 1 AND left_room <> 1;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed in get_time_keeper: " . $conn->error);
        }

        $res = $result->fetch_assoc();

        if(mysqli_num_rows($result) == 0){
            set_time_keeper($room_id);
        }
    }

    function set_time_keeper($room_id){
        $conn = makeConnection();

        $sql = "UPDATE type_players SET typing_race_time_keeper = 1 WHERE student_id = (SELECT * FROM type_players WHERE room_id = '". $room_id ."' ORDER BY RAND() LIMIT 1);";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed in set_time_keeper: " . $conn->error);
        }
    }

   
    $function_name = $_GET["function_name"] ?? "";

    if($function_name == "assign_room"){
        $user_id = $_POST["user_id"];
        $response = assign_room($user_id);
        echo $response;
    }
    else if($function_name == "get_player_count"){
        $room_id = $_POST["room_id"];
        $response = get_player_count($room_id);
        echo $response;
    }
    else if($function_name == "set_room_time"){
        $room_id = $_POST["room_id"];
        set_room_time($room_id);
    }
    else if($function_name == "get_room_time"){
        $room_id = $_POST["room_id"];
        echo get_room_time($room_id);
    }
    
?>