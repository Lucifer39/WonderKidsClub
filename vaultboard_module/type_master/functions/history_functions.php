<?php 
    $dir = __DIR__;
    $parentdir = dirname(dirname($dir));
    require_once($parentdir . "/connection/dependencies.php");

    class History{
        public $room_id;
        public $student_id;
        public $room_type;
        public $created_at;
        public function __construct($obj){
            $this->room_id = $obj["room_id"];
            $this->student_id = $obj["student_id"];
            $this->room_type = $obj["type"];
            $this->created_at = $obj["created_at"];
        }
    }
    function get_history($user_id){
        $conn = makeConnection();

        $sql = "SELECT tr.room_id, tp.student_id, tr.type, tr.created_at FROM type_rooms tr
                JOIN type_players tp
                ON tr.room_id = tp.room_id
                WHERE tp.student_id = $user_id
                AND tp.completed = 1
                ORDER BY tr.created_at DESC;";

        $result = $conn->query($sql);
        if(!$result){
            die("Query has failed at get_history: ". $conn->error);
        }

        $res_array = array();

        while($row = $result->fetch_assoc()){
            $obj = new History($row);
            array_push($res_array, $obj);
        }

        return $res_array;
    }

    $function_name = $_GET["function_name"] ?? "";
    if($function_name == "get_history"){
        echo json_encode(get_history($_POST["user_id"]));
    }
?>