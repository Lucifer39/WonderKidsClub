<?php 
    $dir = __DIR__;
    $parentdir = dirname(dirname($dir));
    require_once($parentdir . "/connection/dependencies.php");

    function get_room_questions($room_id) {
        $conn = makeConnection();
        $sql = "SELECT question_set FROM spellathon_live_rooms WHERE id = $room_id ;";

        $result = $conn->query($sql);

        if(!$result) {
            die("Query failed at get_room_questions: ". $conn->error);
        }

        $res = $result->fetch_assoc();
        return $res["question_set"];
    }

    function set_score($room_id, $student_id, $score){
        $conn = makeConnection();
        $sql = "UPDATE spellathon_room_players 
                SET score = $score, completed = 1
                WHERE student_id = $student_id
                AND room_id = $room_id";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at set_score: ". $conn->error);
        }

        complete_room($room_id);

        return;
    }

    function complete_room($room_id){
        $conn = makeConnection();

        $sql = "UPDATE spellathon_live_rooms
                SET completed = 1
                WHERE id = $room_id;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at complete_room: ". $conn->error);
        }

        return;
    }

    $function_name = $_GET["function_name"] ?? "";
    if($function_name == "get_room_questions"){
        echo json_encode(get_room_questions($_POST["room_id"]));
    }
    else if($function_name == "set_score"){
        echo json_encode(set_score($_POST["room_id"], $_POST["student_id"], $_POST["score"]));
    }
?>