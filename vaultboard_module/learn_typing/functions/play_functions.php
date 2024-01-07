<?php 
    $dir = __DIR__;
    $parent = dirname($dir);
    $parentdir = dirname($parent);

    require_once($parentdir . "/connection/conn.php");
    require_once($parentdir . "/connection/dependencies.php");
     function make_ongoing($user_id, $group_id){
        $conn = makeConnection();

        $sql_ins = "INSERT INTO learn_typing_progress (student_id, group_id, completed) ";
        $sql_ins .= "SELECT ?, ?, 0 ";
        $sql_ins .= "FROM dual ";
        $sql_ins .= "WHERE NOT EXISTS ";
        $sql_ins .= "( SELECT 1 FROM learn_typing_progress WHERE student_id = ? AND group_id = ? )";

        $stmt = mysqli_prepare($conn, $sql_ins);
        mysqli_stmt_bind_param($stmt, "iiii", $user_id, $group_id, $user_id, $group_id);

        $response = "not success";

        if(mysqli_stmt_execute($stmt)){
            $sql_upd = "UPDATE learn_typing_progress 
                        SET completed = 1 
                        WHERE student_id = ? 
                        AND group_id <> ? 
                        AND completed = 0;";
            $stmt_1 = mysqli_prepare($conn, $sql_upd);
            mysqli_stmt_bind_param($stmt_1, "ii", $user_id, $group_id);
            if(mysqli_stmt_execute($stmt_1)){
                $response = "success";
            }
        }
        else{
            $response = "not success";
        }

        return json_encode($response);
    }

    function make_complete($user_id, $group_id){
        $conn = makeConnection();
        $response = "not success";

        $sql_upd = "UPDATE learn_typing_progress SET completed = 1 WHERE student_id = ? AND group_id = ? AND completed = 0;";
        $stmt_1 = mysqli_prepare($conn, $sql_upd);
        mysqli_stmt_bind_param($stmt_1, "ii", $user_id, $group_id);
        if(mysqli_stmt_execute($stmt_1)){
            $response = get_group_id($user_id, "not started");
        }

        return json_encode($response);
    }

    function get_group_id($user_id, $status){
        $conn = makeConnection();

        $sql = "SELECT g.id AS group_id ";
        $sql .= "FROM learn_typing_groups g ";
        $sql .= "JOIN learn_typing_skills s ON g.skill_id = s.id ";
        $sql .= "JOIN learn_typing_levels l ON s.level_id = l.id ";
        $sql .= "LEFT JOIN learn_typing_progress p ON p.group_id = g.id AND p.student_id = ". $user_id ." ";
        $sql .= "WHERE (CASE WHEN p.completed = 1 THEN 'completed' ";
        $sql .= "WHEN p.completed = 0 THEN 'ongoing' ";
        $sql .= "ELSE 'not started' ";
        $sql .= "END) = '". $status ."' ";
        $sql .= "ORDER BY l.level_order, s.skill_order, g.group_order ";
        $sql .= "LIMIT 1;";

        $result = $conn->query($sql);
        if(!$result){
            die("Query failed at get_next_group_id: ". $conn->error);
        }

        $res = $result->fetch_assoc();

        return $res["group_id"] ?? "";
    }

    function check_started_journey($user_id){
        $conn = makeConnection();

        $sql = "SELECT count(*) AS result FROM learn_typing_progress WHERE student_id =". $user_id;
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at check_started_journey: ". $conn->error);
        }

        $res = $result->fetch_assoc();

        return $res["result"];
    }

    function check_valid_group($user_id, $group_id){
        $conn = makeConnection();

        $sql = "WITH group_progress AS (
            SELECT g.id AS group_id, 
                   g.group_name, 
                   s.id AS skill_id, 
                   s.skill_name, 
                   l.id AS level_id, 
                   l.level_name,
                   CASE 
                     WHEN p.completed = 1 THEN 'completed'
                     WHEN p.completed = 0 THEN 'ongoing'
                     ELSE 'not started'
                   END AS status
            FROM learn_typing_groups g
            JOIN learn_typing_skills s ON g.skill_id = s.id
            JOIN learn_typing_levels l ON s.level_id = l.id
            LEFT JOIN learn_typing_progress p ON p.group_id = g.id AND p.student_id = ". $user_id ."
            ORDER BY l.level_order, s.skill_order, g.group_order
          )
          SELECT status
          FROM group_progress
          WHERE group_id = ". $group_id ." ;";

         $result = $conn->query($sql);
         if(!$result){
            die("Query failed at check_valid_group: ". $conn->error);
         }

         $res = $result->fetch_assoc();
         return $res["status"];
          
    }

    $function_name = $_GET["function_name"] ?? "";

    if($function_name == "make_ongoing"){
        $user_id = $_POST["student_id"];
        $group_id = $_POST["group_id"];

        echo make_ongoing($user_id, $group_id);
    }
    else if($function_name == "make_complete"){
        $user_id = $_POST["student_id"];
        $group_id = $_POST["group_id"];

        echo make_complete($user_id, $group_id);
    }
?>