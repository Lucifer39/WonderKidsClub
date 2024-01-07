<?php 

    $dir = __DIR__;
    $parent = dirname($dir);
    $parentdir = dirname($parent);

    require_once($parentdir . "/connection/conn.php");
    require_once($parentdir . "/connection/dependencies.php");

    class Players{
        public $student_id;
        public $student_name;
        public $avatar;
        public $student_class;
        public $student_school;
        public $room_owner;
        public $time_keeper;
        public function __construct($student_id, $student_name, $avatar, $student_class, $student_school, $room_owner, $time_keeper){
            $this->student_id = $student_id;
            $this->student_name = $student_name;
            $this->avatar = $avatar;
            $this->student_class = $student_class;
            $this->student_school = $student_school;
            $this->room_owner = $room_owner;
            $this->time_keeper = $time_keeper;
        }
    }

   

    function get_waiting_players($room_id){
        $conn = makeConnection();

        $sql = "SELECT u.id AS student_id, u.name, sc.name AS class, sm.name AS school, 
                tp.typing_race_time_keeper, tp.room_owner, u.avatar
                FROM type_players tp
                INNER JOIN users u
                ON tp.student_id = u.id 
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id
                WHERE tp.room_id = '". $room_id ."' 
                AND tp.left_room <> 1;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed in get_waiting_players: " . $conn->error);
        }

        $response = array();

        while($row = $result->fetch_assoc()){
            $res_obj = new Players($row["student_id"], $row["name"], $row['avatar'], $row["class"], $row["school"], $row["room_owner"], $row["typing_race_time_keeper"]);
            array_push($response, $res_obj);
        }

        return json_encode($response);
    }

    function get_room_owner($room_id){
        $conn =makeConnection();

        $sql = "SELECT student_id,student_avatar FROM type_players WHERE room_id = '". $room_id ."' AND room_owner = 1;";
        $response = $conn->query($sql);

        if(!$response){
            die("Query failed in get_room_owner: " . $conn->error);
        }

        $res = ($response->fetch_assoc());
        return $res;
    }

    function start_room_game($room_id){
        $conn = makeConnection();

        $sql = "UPDATE type_rooms SET started = 1 WHERE room_id = '". $room_id ."';";
        $response = $conn->query($sql);

        if(!$response){
            die("Query failed in start_room_game: " . $conn->error);
        }

        return;
    }

    function get_start_room_status($room_id){
        $conn = makeConnection();

        $sql = "SELECT started FROM type_rooms WHERE room_id = '". $room_id ."';";
        $response = $conn->query($sql);

        if(!$response){
            die("Query failed in get_start_room_status: " . $conn->error);
        }

        $res = json_encode($response->fetch_assoc());   

        return $res;
    }

    

    
    $function_name = $_GET["function_name"] ?? "";
    $room_id = $_POST["room_id"]??0;


    if($function_name == "get_waiting_players"){
        $response = get_waiting_players($room_id);
        echo $response;
    }
    else if($function_name == "start_room_game"){
        start_room_game($room_id);
    }
    else if($function_name == "get_start_room_status"){
       $response = get_start_room_status($room_id);
       echo $response;
    }
    else if($function_name == "get_room_owner"){
        echo json_encode(get_room_owner($_POST["room_id"]));
    }
  
?>