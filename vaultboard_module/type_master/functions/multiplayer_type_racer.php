<?php 

    $dir = __DIR__;
    $parent = dirname($dir);
    $parentdir = dirname($parent);

    require_once($parentdir . "/connection/conn.php");
    require_once($parentdir . "/connection/dependencies.php");

    class Progress{
        public $student_id;
        public $student_name;
        public $student_class;
        public $student_school;
        public $rocket_progress;
        public $wpm;
        public $points;
        public $completed;
        public $accuracy;
        public $time_taken;
        public $student_avatar;
        public function __construct($student_id, $student_name, $student_class, $student_school, $rocket_progress, $completed, $wpm, $points, $accuracy, $time_taken, $student_avatar){
            $this->student_id = $student_id;
            $this->student_name = $student_name;
            $this->student_class = $student_class;
            $this->student_school = $student_school;
            $this->rocket_progress = $rocket_progress;
            $this->completed = $completed;
            $this->wpm = $wpm;
            $this->points = $points;
            $this->accuracy = $accuracy;
            $this->time_taken = $time_taken;
            $this->student_avatar = $student_avatar;
        }
    }

    class Room_sentences{
        public $sentence_id;
        public $sentence;
        public $category;
        public function __construct($sentence_id, $sentence, $category){
            $this->sentence_id = $sentence_id;
            $this->sentence = $sentence;
            $this->category = $category;
        }
    }

    function get_player_progress($room_id, $user_id){
        $conn = makeConnection();

        $sql = "SELECT u.id AS student_id, u.name, sc.name AS class, sm.name AS school, tp.rocket_progress, 
                tp.completed, tp.wpm, tp.points, tp.accuracy, tp.time_taken, tp.student_avatar
                FROM type_players tp
                INNER JOIN users u 
                ON tp.student_id = u.id
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id 
                WHERE room_id = '$room_id' 
                AND tp.left_room <> 1
                ORDER BY (tp.student_id = $user_id) DESC, RAND()
                LIMIT 5;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed in get_player_progress: " . $conn->error);
        }

        $response = array();
        while($row = $result->fetch_array()){
            $res_object = new Progress($row["student_id"], $row["name"], $row["class"], $row["school"], $row["rocket_progress"], $row["completed"], $row["wpm"], $row["points"], $row["accuracy"], $row["time_taken"], $row["student_avatar"]);
            array_push($response, $res_object);
        }

        return json_encode($response);
    }

    function room_leaderboard($room_id){
        $conn = makeConnection();

        $sql = "SELECT u.id AS student_id, u.name, sc.name AS class, sm.name AS school, tp.rocket_progress, 
                tp.completed, tp.wpm, tp.points, tp.accuracy, tp.time_taken, tp.student_avatar
                FROM type_players tp
                INNER JOIN users u  
                ON tp.student_id = u.id
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id  
                WHERE tp.room_id = '". $room_id ."' 
                AND tp.completed = 1 
                ORDER BY tp.points DESC, tp.wpm DESC, tp.accuracy DESC, tp.time_taken ASC;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed in get_player_progress: " . $conn->error);
        }

        $response = array();
        while($row = $result->fetch_array()){
            $res_object = new Progress($row["student_id"], $row["name"], $row["class"], $row["school"], $row["rocket_progress"], $row["completed"], $row["wpm"], $row["points"], $row["accuracy"], $row["time_taken"], $row["student_avatar"]);
            array_push($response, $res_object);
        }

        return json_encode($response);
    }

    function set_player_progress($room_id, $user_id, $progress){
        $conn = makeConnection();

        $pl_progress = ($progress);
        
        $sql = "UPDATE type_players SET ";
        $sql .= "rocket_progress = ". $pl_progress["rocket_progress"] .", ";
        $sql .= "completed = ". $pl_progress["completed"] .", ";
        $sql .= "wpm = ". $pl_progress["wpm"] .", ";
        $sql .= "points = ". $pl_progress["points"] .", ";
        $sql .= "accuracy = ". $pl_progress["accuracy"] .", ";
        $sql .= "time_taken = ". $pl_progress["time_taken"] ." ";
        $sql .= "WHERE room_id = '". $room_id ."' AND student_id = ". $user_id .";";

        $result = $conn->query($sql);
        if(!$result){
            die("Query failed in set_player_progress: " . $conn->error);
        }

        return;
    }

    function get_room_sentences($room_id){
        $conn = makeConnection();

        $sql = "SELECT sentences FROM type_rooms WHERE room_id = '". $room_id ."';";
        $response = $conn->query($sql);

        if(!$response){
            die("Query failed in get_room_sentences: " . $conn->error);
        }

        $res = $response->fetch_assoc();
        $sql_get = "SELECT * FROM type_sentences WHERE id IN (". $res["sentences"] .");";
        $res_get = $conn->query($sql_get);

        if(!$res_get){
            die("Query failed in get_room_sentences: " . $conn->error);
        }

        $res_array = array();
        while($row = $res_get->fetch_assoc()){
            $obj = new Room_sentences($row["id"], $row["sentence"], $row["category"]);
            array_push($res_array, $obj);
        }

        return json_encode($res_array);
    }

    function leave_room($room_id, $user_id){
        $conn = makeConnection();

        check_room_owner_leave($room_id, $user_id);

        $sql = "UPDATE type_players SET left_room = 1 WHERE room_id = '". $room_id ."' AND student_id = ". $user_id .";";

        $response = $conn->query($sql);

        $sql_dec = "UPDATE type_rooms SET player_count = (SELECT COUNT(id) FROM type_players WHERE room_id = '". $room_id ."' AND left_room <> 1) WHERE room_id = '". $room_id ."';";
        $result = $conn->query($sql_dec);

        $sql_complete = "UPDATE type_rooms SET completed = 1 WHERE room_id = '". $room_id ."' AND player_count = 0 AND (type = 'typing_race' OR type = 'live_room');";
        $result_complete = $conn->query($sql_complete);

        if(!$response || !$result || !$result_complete){
            die("Query failed in get_room_sentences: " . $conn->error);
        }

        return;
    }

    function check_room_owner_leave($room_id, $user_id){
        $conn = makeConnection();

        $sql = "SELECT room_owner FROM type_players WHERE room_id = '$room_id' AND student_id = $user_id;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed in check_room_owner_leave: ". $conn->error);
        }

        $res = $result->fetch_assoc();

        if($res["room_owner"] == 0){
            return;
        }

        $sql_update = "UPDATE type_players SET room_owner = 0 WHERE room_id = '". $room_id ."' AND student_id = ". $user_id .";";
        $res_update = $conn->query($sql_update);

        if(!$res_update){
            die("Query failed in check_room_owner_leave: ". $conn->error);
        }

        $sql_update_owner = "UPDATE type_players 
                                SET room_owner = 1 
                                WHERE room_id  = '$room_id'  
                                AND student_id = (
                                    SELECT student_id
                                    FROM (
                                        SELECT student_id 
                                        FROM type_players
                                        WHERE room_id = '$room_id'   
                                        AND student_id <> $user_id
                                        AND left_room = 0
                                        ORDER BY RAND()
                                        LIMIT 1
                                    ) AS subquery
                                )
                                AND id > 0;";

        $result_update_owner = $conn->query($sql_update_owner);

        if(!$result_update_owner){
            die("Query failed in check_room_owner_leave: ". $conn->error);
        }

        return;

    }


    $room_id = $_POST["room_id"]??0;
    $function_name = $_GET["function_name"]??"";
    if($function_name == "get_player_progress"){
        $response = get_player_progress($room_id, $_POST["user_id"]);
        echo $response;
    }
    else if($function_name == "room_leaderboard"){
        $response = room_leaderboard($room_id);
        echo $response;
    }
    else if($function_name == "set_player_progress"){
        $student_id = $_POST["student_id"];
        $progress = $_POST["progress"];
        set_player_progress($room_id, $student_id, $progress);
    }
    else if($function_name == "get_room_sentences"){
        $response = get_room_sentences($room_id);
        echo $response;
    }
    else if($function_name == "leave_room"){
        $student_id = $_POST["student_id"];
        leave_room($room_id, $student_id);
    }
?>