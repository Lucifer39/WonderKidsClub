<?php 
    $dir = __DIR__;
    $parentdir = dirname(dirname($dir));
    require_once($parentdir . "/connection/dependencies.php");

    function create_room($start_date_time, $class_group){
        $conn = makeConnection();

        $question_set = json_encode(get_room_questions($class_group));

        $sql = "INSERT INTO spellathon_live_rooms (start_at, question_set, relevance) 
                SELECT ?,?,?
                FROM dual
                WHERE NOT EXISTS (
                    SELECT 1
                    FROM spellathon_live_rooms
                    WHERE relevance = ?
                    AND start_at = ?
                    AND started = 0
                    AND completed = 0
                )";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssiis", $start_date_time, $question_set, $class_group, $class_group, $start_date_time);

        if(mysqli_stmt_execute($stmt)){
            $rowsInserted = mysqli_affected_rows($conn);
            if ($rowsInserted === 1) {
                return "Room created";
            } else {
                return "Room already exists";
            }
        }
        else {
            return "Room not created";
        }
    }

    class Question {
        public $content;
        public $meaning;
        public $question_type;
        public function __construct($obj, $question_type){
            $this->content = $obj["word"];
            $this->meaning = $obj["meaning"];
            $this->question_type = $question_type;
        }
    }

    function get_room_questions($class_group) {
        $conn = makeConnection();

        $sql = "SELECT * FROM spellathon_words 
                WHERE relevance = $class_group 
                ORDER BY RAND() 
                LIMIT 10;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_room_questions: ". $conn->error);
        }

        $res_array = array();
        $myArray = array("dictation", "jumble");

        while($row = $result->fetch_assoc()){
            $randomKey = array_rand($myArray);
            $randomElement = $myArray[$randomKey];

            if($row["question_type"] == "guess"){
                $randomElement = "guess";
            }

            $obj = new Question($row, $randomElement);

            array_push($res_array, $obj);
        }

        return $res_array;
    }

    function assign_room($student_id, $class_group){
        $conn = makeConnection();

        $sql = "SELECT id FROM spellathon_live_rooms
                WHERE start_at >= NOW() AND start_at <= DATE_ADD(NOW(), INTERVAL 15 MINUTE)
                AND started = 0
                AND completed = 0
                AND relevance = $class_group
                ORDER BY start_at
                LIMIT 1;";

        $result_find = $conn->query($sql);

        if(!$result_find){
            die("Query failed at assign_room: ". $conn->error);
        }

        $res_find = $result_find->fetch_assoc();

        if($res_find["id"] !== ""){
            $sql_insert = "INSERT INTO spellathon_room_players (room_id, student_id) 
                           SELECT ?,? FROM dual
                           WHERE NOT EXISTS (
                            SELECT 1
                            FROM spellathon_room_players
                            WHERE room_id = ?
                            AND student_id = ?
                           );";

            $stmt = mysqli_prepare($conn, $sql_insert);
            mysqli_stmt_bind_param($stmt, "iiii", $res_find["id"], $student_id, $res_find["id"], $student_id);

            if(mysqli_stmt_execute($stmt)){
                $sql_update = "UPDATE spellathon_room_players
                               SET left_room = 0
                               WHERE room_id = ". $res_find["id"] ." 
                               AND student_id = $student_id";

                $result_update = $conn->query($sql_update);

                if(!$result_update){
                    die("Query failed at assign_room: ". $conn->error);
                }

                set_time_keeper($res_find["id"], $student_id);

                return $res_find["id"];
            }
            else{
                return false;
            }
        }
        else{
            return "No rooms present";
        }
    }

    function set_time_keeper($room_id, $student_id){
        $conn = makeConnection();

        $sql = "SELECT id FROM spellathon_room_players 
                WHERE room_id = $room_id
                AND room_time_keeper = 1
                LIMIT 1;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at set_time_keeper: ". $conn->error);
        }

        $res = $result->fetch_assoc();

        if(!$res){
            $sql_set = "UPDATE spellathon_room_players 
                        SET room_time_keeper = 1 
                        WHERE room_id = $room_id
                        AND student_id = $student_id
                        ORDER BY RAND()
                        LIMIT 1;";

            $result_set = $conn->query($sql_set);

            if(!$result_set){
                die("Query failed at set_time_keeper: ". $conn->error);
            }
        }
    }

    function time_keeper_action($room_id){
        $conn = makeConnection();

        $sql_check = "SELECT time_start_seconds 
                      FROM spellathon_live_rooms 
                      WHERE id = $room_id";

        $result_check = $conn->query($sql_check);

        if(!$result_check){
            die("Query failed at time_keeper_action: ". $conn->error);
        }

        $res_check = $result_check->fetch_assoc();
        if(!$res_check["time_start_seconds"] ?? "" == "") {
            set_time_interval($room_id);
        }

        $sql = "UPDATE spellathon_live_rooms
                SET time_start_seconds = time_start_seconds - 1
                WHERE id = $room_id ;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at time_keeper_action: ". $conn->error);
        }

        return;
    }

    function get_time_to_start($room_id){
        $conn = makeConnection();

        $sql = "SELECT time_start_seconds FROM spellathon_live_rooms WHERE id = $room_id ;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_time_to_start: ". $conn->error);
        }

        $res = $result->fetch_assoc();

        return $res["time_start_seconds"] ?? 0;
    }

    function set_time_interval($room_id){
        $conn = makeConnection();
        $sql = "UPDATE spellathon_live_rooms
                SET time_start_seconds = ABS(TIMESTAMPDIFF(SECOND, start_at, CURRENT_TIMESTAMP))
                WHERE id = $room_id ;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at set_time_interval: ". $conn->error);
        }

        return;
    }

    function get_waiting_room_players($room_id) {
        $conn = makeConnection();

        $sql = "SELECT u.id, u.name, sm.name AS school, sc.vocab_class AS class, u.avatar, srp.room_time_keeper 
                FROM spellathon_room_players srp
                INNER JOIN users u
                ON u.id = srp.student_id
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id
                WHERE srp.room_id = $room_id
                AND srp.left_room = 0
                AND srp.started = 0
                AND srp.completed = 0;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_waiting_room_players: ". $conn->error);
        }

        $res_array = array();

        while($row = $result->fetch_assoc()){
            array_push($res_array, $row);
        }

        return $res_array;
    }

    function checkRoom($class_group){
        $conn = makeConnection();
        $sql = "SELECT id FROM spellathon_live_rooms
                WHERE start_at >= NOW() AND start_at <= DATE_ADD(NOW(), INTERVAL 15 MINUTE)
                AND started = 0
                AND completed = 0
                AND relevance = $class_group
                ORDER BY start_at
                LIMIT 1;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at checkRoom: ". $conn->error);
        }

        $res = $result->fetch_assoc();

        return $res["id"] ?? "";
    }

    function leave_room($student_id, $room_id){
        $conn = makeConnection();

        change_time_keeper($student_id, $room_id);
        
        $sql = "UPDATE spellathon_room_players
                SET left_room = 1, room_time_keeper = 0
                WHERE student_id = $student_id
                AND room_id = $room_id ;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at leave_room: ". $conn->error);
        }

        return;
    }

    function change_time_keeper($student_id, $room_id){
        $conn = makeConnection();

        $sql_find = "SELECT room_time_keeper 
                    FROM spellathon_room_players
                    WHERE student_id = $student_id
                    AND room_id = $room_id";

        $result_find = $conn->query($sql_find);

        if(!$result_find){
            die("Query has failed at change_time_keeper: ". $conn->error);
        }

        $res = $result_find->fetch_assoc();

        if($res["room_time_keeper"] == 1){

            $sql = "UPDATE spellathon_room_players
                    SET room_time_keeper = 1
                    WHERE student_id = (
                        SELECT student_id
                        FROM spellathon_room_players
                        WHERE room_id = $room_id
                        AND student_id <> $student_id
                        AND left_room = 0
                        ORDER BY RAND()
                        LIMIT 1
                    );";

            $result = $conn->query($sql);

            if(!$result){
                die("Query has failed at change_time_keeper: ". $conn->error);
            }
        }

        return;
    }

    function get_time_keeper($room_id){
        $conn = makeConnection();

        $sql = "SELECT student_id 
                FROM spellathon_room_players
                WHERE room_time_keeper = 1 
                AND room_id = $room_id 
                LIMIT 1;";

        $result = $conn->query($sql);
        if(!$result){
            die("Query has failed at get_time_keeper: ". $conn->error);
        }

        $res = $result->fetch_assoc();

        return $res["student_id"];
    }

    function start_room($room_id) {
        $conn = makeConnection();

        $sql = "UPDATE spellathon_live_rooms SET started = 1 WHERE id = $room_id ;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at start_room: ". $conn->error);
        }

        $sql_players = "UPDATE spellathon_room_players SET started = 1 WHERE room_id = $room_id ;";
        $result_players = $conn->query($sql_players);

        if(!$result_players){
            die("Query failed at start_room: ". $conn->error);
        }

        return;
    }

    function check_start_room($room_id) {
        $conn = makeConnection();

        $sql = "SELECT started FROM spellathon_live_rooms WHERE id = $room_id ;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at check_start_room: ". $conn->error);
        }

        $res = $result->fetch_assoc();

        return $res["started"] ?? 0;
    }

    function get_rooms() {
        $conn = makeConnection();

        $sql = "SELECT * FROM spellathon_live_rooms 
                WHERE completed = 0
                ORDER BY created_at DESC;";

        $result = $conn->query($sql);
        if(!$result){
            die("Query failed at get_rooms: ". $conn->error);
        }

        $res_array = array();

        while($row = $result->fetch_assoc()){
            array_push($res_array, $row);
        }

        return $res_array;

    }


    $function_name = $_GET["function_name"] ?? "";

    if($function_name == "create_room"){
        echo json_encode(create_room($_POST["start_date_time"], $_POST["class_group"]));
    }
    else if($function_name == "assign_room"){
        echo json_encode(assign_room($_POST["student_id"], $_POST["class_group"]));
    }
    else if($function_name == "get_waiting_room_players"){
        echo json_encode(get_waiting_room_players($_POST["room_id"]));
    }
    else if($function_name == "checkRoom"){
        echo json_encode(checkRoom($_POST["class_group"]));
    }
    else if($function_name == "time_keeper_action"){
        echo json_encode(time_keeper_action($_POST["room_id"]));
    }
    else if($function_name == "leave_room"){
        echo json_encode(leave_room($_POST["student_id"], $_POST["room_id"]));
    }
    else if($function_name == "get_time_to_start"){
        echo json_encode(get_time_to_start($_POST["room_id"]));
    }
    else if($function_name == "start_room"){
        echo json_encode(start_room($_POST["room_id"]));
    }
    else if($function_name == "check_start_room"){
        echo json_encode(check_start_room($_POST["room_id"]));
    }
    else if($function_name == "get_rooms"){
        echo json_encode(get_rooms());
    }
?>