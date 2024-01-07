<?php 
    $dir = __DIR__;
    $parent = dirname($dir);
    $parentdir = dirname($parent);

    require_once($parentdir . "/connection/conn.php");
    require_once($parentdir . "/connection/dependencies.php");

    function join_room($room_id, $user_id, $room_owner, $type){
        $conn = makeConnection();
        $response = "Can't join room";

         // print_r($player_count);

         $sql_check_owner = "SELECT COUNT(room_owner) AS room_owner_count FROM type_players WHERE room_id = '". $room_id ."';";
         $res_owner = $conn->query($sql_check_owner);

         if(!$res_owner){
            die("Query failed in join_room: ". $conn->error);
         }

         $owner_count = $res_owner->fetch_assoc();
         if($owner_count["room_owner_count"]??0 >= 1){
            $room_owner = 0;
         }

         $flag = false;

         $sql_check_player = "SELECT * FROM type_players WHERE room_id = '". $room_id ."' AND student_id = ". $user_id ." AND completed = 1;";
         $result_player = $conn->query($sql_check_player);

         if(!$result_player){
            die("Query failed in join_room: ". $conn->error);
         }

         if(mysqli_num_rows($result_player) > 0){
            return "leaderboard";
         }

         if($type == "typing_race"){
            $flag = checkTypingRace($room_id);
         }
         else if($type == "live_room"){
            $flag = checkLiveRoom($room_id);
         }
         else if($type == "offline_challenge"){
            $flag = checkOfflineChallenges($room_id);
         }

         if($flag){
            $student_det = getStudent($user_id);

            $sql_select = "SELECT * FROM type_players WHERE room_id = '$room_id' AND student_id = $user_id;";
            $res_select = $conn->query($sql_select);

            if(mysqli_num_rows($res_select) == 0){

               $sql_insert = "INSERT INTO type_players (student_id, student_avatar, room_id, room_owner, left_room) SELECT ?,?,?,?,0 ";
               $sql_insert .= "FROM dual ";
               $sql_insert .= "WHERE NOT EXISTS ";
               $sql_insert .= "( SELECT 1 FROM type_players WHERE room_id = ? AND student_id = ? LIMIT 1 );";
               $stmt = mysqli_prepare($conn, $sql_insert);
               
               // Bind parameters to the prepared statement
               mysqli_stmt_bind_param($stmt, "issisi", $user_id, $student_det["avatar"], $room_id, $room_owner, $room_id, $user_id);

               if (mysqli_stmt_execute($stmt)) {
                  $response = "New record created successfully";
                  $sql_inc = "UPDATE type_rooms SET player_count = (SELECT COUNT(id) FROM type_players WHERE room_id = '". $room_id ."' AND left_room <> 1) WHERE room_id = '". $room_id ."';";
                  $result = $conn->query($sql_inc);
               } else {
                  $response = "Error: " . mysqli_stmt_error($stmt);
               }
            }
            else{
               $sql_update = "UPDATE type_players
                              SET left_room = 0
                              WHERE room_id = ? AND student_id = ? ;";

               $stmt = mysqli_prepare($conn, $sql_update);
               mysqli_stmt_bind_param($stmt, "si", $room_id, $user_id);

               if (mysqli_stmt_execute($stmt)) {
                  $response = "New record created successfully";
                  $sql_inc = "UPDATE type_rooms SET player_count = (SELECT COUNT(id) FROM type_players WHERE room_id = '". $room_id ."' AND left_room <> 1) WHERE room_id = '". $room_id ."';";
                  $result = $conn->query($sql_inc);
               } else {
                  $response = "Error: " . mysqli_stmt_error($stmt);
               }
            }
    
         }

         return $response;
    }

    function checkTypingRace($room_id){
      $conn = makeConnection();
      $flag = false;

      $sql = "SELECT * FROM type_rooms WHERE room_id = '". $room_id ."' AND type = 'typing_race';";
      $result_room = $conn->query($sql);

      if(!$result_room){
         die("Query failed at checkTypingRace: ". $conn->error);
      }

      $res_room = $result_room->fetch_assoc();

      if(mysqli_num_rows($result_room) > 0 && $res_room["player_count"] < $res_room["max_player_count"] && $res_room["started"] == 0){
         $flag = true;
      }

      return $flag;
    }

    function checkLiveRoom($room_id){
      $conn = makeConnection();
      $flag = false;

      $sql = "SELECT * FROM type_rooms WHERE room_id = '". $room_id ."' AND type = 'live_room';";
      $result_room = $conn->query($sql);

      if(!$result_room){
         die("Query failed at checkTypingRace: ". $conn->error);
      }

      $res_room = $result_room->fetch_assoc();

      if(mysqli_num_rows($result_room) > 0 && $res_room["started"] == 0 || ($res_room["started"] == 1 && $res_room["completed"] == 1)){
         $flag = true;
      }

      return $flag;
    }

    function checkOfflineChallenges($room_id){
      $conn = makeConnection();
      $flag = false;

      $sql = "SELECT * FROM type_rooms WHERE room_id = '". $room_id ."' AND type = 'offline_challenge';";
      $result_room = $conn->query($sql);

      if(!$result_room){
         die("Query failed at checkTypingRace: ". $conn->error);
      }

      $res_room = $result_room->fetch_assoc();

      $dateTime = new DateTime($res_room["created_at"]);
      $now = new DateTime();
      $timeElapsed = $now->diff($dateTime);
      $hours_passed = $timeElapsed->h;

      if(mysqli_num_rows($result_room) > 0 && $hours_passed < 24){
         $flag = true;
      }

      return $flag;

    }


    $function_name = $_GET["function_name"] ?? "";

    if($function_name == 'join_room'){
        $room_id = $_POST["room_id"];
        $user_id = $_POST["user_id"];
        $room_owner = $_POST["room_owner"];
        $type = $_POST["type"];

        $response = join_room($room_id, $user_id, $room_owner, $type);
        echo $response;
    }
   
?>