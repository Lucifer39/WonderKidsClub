<?php 
    $dir = __DIR__;
    $parent = dirname($dir);
    $parentdir = dirname($parent);

    require_once($parentdir . "/connection/conn.php");
    require_once($parentdir . "/connection/dependencies.php");
    require_once("type_master_functions.php");

    function generateRoomId(){
        $db = makeConnection();
        $roomId = '';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        // Generate a random room ID and check if it already exists in the database
        do {
            // $unique_id = uniqid();
            // $integer_id = hexdec(substr($unique_id, -6));
            // $roomId = str_pad($integer_id, 6, "0", STR_PAD_LEFT); // Generate a unique ID using the uniqid() function

            $roomId = '';
            $charactersLength = strlen($characters);
            for ($i = 0; $i < 16; $i++) {
                $roomId .= $characters[rand(0, $charactersLength - 1)];
            }

            $stmt = $db->prepare('SELECT * FROM type_rooms WHERE room_id = ?');
            $stmt->bind_param('s', $roomId);
            $stmt->execute();
            $result = $stmt->get_result();
        } while ($result->num_rows > 0);
        
        // Return the unique room ID
        return $roomId;
    }

    function createRoom($relevance, $max_sentences, $type, $created_at){
        $conn = makeConnection();

        $roomId = generateRoomId();

        $sql_sentences = getSentences($max_sentences);
        $id_values = array_column($sql_sentences, 'sentence_id');
        $id_string = implode(',', $id_values);

        $sql_insert = "INSERT INTO type_rooms (room_id, sentences, started, completed, player_count, max_player_count, type) VALUES (?,?,?,?,?,?,?);";
        $stmt = mysqli_prepare($conn, $sql_insert);
        $started = 0;
        $completed = 0;
        $player_count = 0;
        $max_player_count = 5;
        mysqli_stmt_bind_param($stmt, "ssiiiis", $roomId, $id_string, $started, $completed, $player_count, $max_player_count, $type);

        if (mysqli_stmt_execute($stmt)) {
          } else {
            echo "Error: " . mysqli_stmt_error($stmt);
          }

          mysqli_stmt_close($stmt);
          mysqli_close($conn);

         return json_encode($roomId);
    }

    function sendInvites($sender, $reciever, $room_id){
        $conn = makeConnection();

        $sql = "INSERT INTO type_invites (sender, reciever, status, room_id) VALUES (?,?,'pending',?);";
        $stmt = mysqli_prepare($conn, $sql);

        foreach($reciever as $single_rec){
            mysqli_stmt_bind_param($stmt, "iis", $sender, $single_rec, $room_id);
            mysqli_stmt_execute($stmt);
        }

        return;
    }

    $function_name = $_GET["function_name"]??"";

    if($function_name == "createRoom"){
        $max_sentences = $_POST["max_sentences"] ?? 2;
        $type = $_POST["type"];
        $created_at = $_POST["created_at"];
        $relevance = $_POST["relevance"]??0;
        echo createRoom($relevance, $max_sentences, $type, $created_at);
    }
    else if($function_name == "sendInvites"){
        $sender = $_POST["sender"];
        $reciever = $_POST["reciever"];
        $room_id = $_POST["room_id"];

        echo sendInvites($sender, $reciever, $room_id);
    }
?>