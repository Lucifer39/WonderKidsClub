<?php 

    $dir = __DIR__;
    $parent = dirname($dir);
    $parentdir = dirname($parent);

    require_once($parentdir . "/connection/conn.php");
    require_once($parentdir . "/connection/dependencies.php");


    class Notification{
        public $sender;
        public $receiver;
        public $status;
        public $room_id;
        public $seen_notification;
        public $created_at;
        public $module;
        public $room_type;
        public function __construct($sender, $receiver, $status, $room_id, $seen_notification, $created_at, $module, $room_type){
            $this->sender = $sender;
            $this->receiver = $receiver;
            $this->status = $status;
            $this->room_id = $room_id;
            $this->seen_notification = $seen_notification;
            $this->created_at = $created_at;
            $this->module = $module;
            $this->room_type = $room_type;
        }
    }

    function getNotifications($student_id){
        $conn = makeConnection();

        $sql = "SELECT t.id, s1.name as sender_name, s2.name as receiver_name, t.status, t.room_id, t.seen_notification, t.created_at, t.module, t.room_type ";
        $sql .= "FROM type_invites t ";
        $sql .= "JOIN users s1 ON t.sender = s1.id ";
        $sql .= "JOIN users s2 ON t.receiver = s2.id ";
        $sql .= "WHERE receiver = ". $student_id ." ";
        // $sql .= "AND status = 'pending' ";
        $sql .="ORDER BY created_at DESC ";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed in getNotifications: " . $conn->error);
        }

        $notif_array = array();
        
        while($row = $result->fetch_assoc()){
            $obj = new Notification($row["sender_name"], $row["receiver_name"], $row["status"], $row["room_id"], $row["seen_notification"], $row["created_at"], $row["module"], $row["room_type"]);
            array_push($notif_array, $obj);
        }

        return json_encode($notif_array);
    }

    function createInvite($sender, $receiver, $room_id, $module, $created_at, $room_type){
        $conn = makeConnection();

        $sql = "INSERT INTO type_invites (sender, receiver, status, room_id, seen_notification, module, created_at, room_type) ";
        $sql .= "SELECT ?,?,'pending',?,0,?,?,? ";
        $sql .= "FROM dual ";
        $sql .= "WHERE NOT EXISTS ";
        $sql .= "( SELECT 1 FROM type_invites WHERE room_id = ? AND sender = ? AND receiver = ? LIMIT 1 );";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "iisssssii", $sender, $receiver, $room_id, $module, $created_at, $room_type, $room_id, $sender, $receiver);

        if (mysqli_stmt_execute($stmt)) {
            $response = "New record created successfully";
        } else {
            $response = "Error: " . mysqli_stmt_error($stmt);
        }

        return;
    }

    class Invitees{
        public $id;
        public $name;
        public $class;
        public $school;
        public function __construct($student_id, $student_name, $student_class, $student_school){
            $this->id = $student_id;
            $this->name = $student_name;
            $this->class = $student_class;
            $this->school = $student_school;
        }
    }

    function getInvitees($room_id, $user_id){
        $conn = makeConnection();

        $sql = "SELECT u.id, u.name, sm.name AS school, sc.vocab_class AS class, u.avatar
                FROM users u
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id
                WHERE NOT EXISTS (
                    SELECT 1
                    FROM type_invites ti
                    WHERE ti.room_id = '$room_id'
                    AND ti.receiver = u.id
                )
                AND NOT EXISTS (
                    SELECT 1
                    FROM type_players tp
                    WHERE tp.room_id = '$room_id'
                    AND tp.student_id = u.id
                )
                AND u.avatar IS NOT NULL
                AND u.name IS NOT NULL;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at getInvitees: ". $conn->error);
        }

        $res_array = array();
        while($row = $result->fetch_assoc()){
            $res_obj = new Invitees($row["id"], $row["name"], $row["class"], $row["school"]);
            array_push($res_array, $res_obj);
        }

        return json_encode($res_array);
    }

    function checkInvite($user_id, $room_id){
        $conn = makeConnection();

        $sql = "SELECT 1 FROM type_invites WHERE receiver = ". $user_id ." AND room_id = '". $room_id ."';";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at checkInvites: ". $conn->error);
        }

        if(mysqli_num_rows($result) > 0){
            return true;
        }
        else {
            return false;
        }
    }

    function changeStatus($user_id, $room_id){
        $conn = makeConnection();

        $sql = "UPDATE type_invites SET status = 'accepted' WHERE receiver = ". $user_id ." AND room_id = '". $room_id ."';";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at changeStatus: ". $conn->error);
        }

        return;
    }

    function seenNotification($user_id){
        $conn = makeConnection();

        $sql = "UPDATE type_invites SET seen_notification = 1 WHERE receiver = ". $user_id .";";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at seenNotification: ". $conn->error);
        }

        return;
    }

    $function_name = $_GET["function_name"] ?? "";
    if($function_name == "getNotifications"){
        $student_id = $_POST["student_id"];
        echo getNotifications($student_id);
    }
    else if($function_name == "createInvite"){
        $sender = $_POST["sender"];
        $receiver = $_POST["receiver"];
        $room_id = $_POST["room_id"];
        $module = $_POST["module"];
        $created_at = $_POST["created_at"];
        $room_type = $_POST["room_type"];

        createInvite($sender, $receiver, $room_id, $module, $created_at, $room_type);
    }
    else if($function_name == "getInvitees"){
        $room_id = $_POST["room_id"];
        $user_id = $_POST["user_id"];
        echo getInvitees($room_id, $user_id);
    }
    else if($function_name == "checkInvite"){
        $room_id = $_POST["room_id"];
        $user_id = $_POST["user_id"];
        echo checkInvite($user_id, $room_id);
    }
    else if($function_name == "changeStatus"){
        $room_id = $_POST["room_id"];
        $user_id = $_POST["user_id"];
        echo changeStatus($user_id, $room_id);
    }
    else if($function_name == "seenNotification"){
        $user_id = $_POST["user_id"];
        seenNotification($user_id);
    }
?>