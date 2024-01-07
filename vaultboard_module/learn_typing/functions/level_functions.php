<?php
        $dir = __DIR__;
        $parent = dirname($dir);
        // $parentdir = dirname($parent);
    
        // require_once($parentdir . "/connection/dependencies.php");
        require_once("functions/play_functions.php");

        class Progress{
            public $group_id;
            public $group_name;
            public $para;
            public $skill_id;
            public $skill_name;
            public $level_id;
            public $level_name;
            public $status;
            public $alphabets;

            public function __construct($obj){
                $this->group_id = $obj["group_id"];
                $this->group_name = $obj["group_name"];
                $this->para = $obj["para"];
                $this->skill_id = $obj["skill_id"];
                $this->skill_name = $obj["skill_name"];
                $this->level_id = $obj["level_id"];
                $this->level_name = $obj["level_name"];
                $this->status = $obj["status"];
                $this->alphabets = $obj["alphabets"];
            }
        }
        function get_progress($user_id){
            $conn = makeConnection();

            $sql = "SELECT g.id AS group_id, g.group_name, g.p_text as para, g.alphabets, s.id AS skill_id, s.skill_name, l.id AS level_id, l.level_name, ";
            $sql .= "CASE WHEN p.completed = 1 THEN 'completed' ";
            $sql .= "WHEN p.completed = 0 THEN 'ongoing' ";
            $sql .= "ELSE 'not started' ";
            $sql .= "END AS status ";
            $sql .= "FROM learn_typing_groups g ";
            $sql .= "JOIN learn_typing_skills s ON g.skill_id = s.id ";
            $sql .= "JOIN learn_typing_levels l ON s.level_id = l.id ";
            $sql .= "LEFT JOIN learn_typing_progress p ON p.group_id = g.id AND p.student_id = ". $user_id ." ";
            $sql .= "ORDER BY l.level_order, s.skill_order, g.group_order;";

            $result = $conn->query($sql);

            if(!$result){
                die("Query failed at get_progress: ". $conn->error);
            }

            $res_array = array();

            while($row = $result->fetch_assoc()){
                $obj = new Progress($row);
                array_push($res_array, $obj);
            }

            // print_r($res_array);
            // Assuming you have received the array in the variable $data
            $statusExists = false;

            foreach ($res_array as $item) {
                if ($item->status === 'ongoing') {
                    $statusExists = true;
                    break;
                }
            }

            if (!$statusExists) {
                make_ongoing($user_id, 1);
                $res_array[0]->status = "ongoing";
            }


            return $res_array;
        }

        function get_exercise($user_id){
            $conn = makeConnection();

            $sql = "SELECT g.id as group_id, g.group_name, g.alphabets,g.p_text as para,s.skill_name,s.id as skill_id,l.level_name,l.id as level_id, CASE WHEN p.completed = 1 THEN 'completed' 
            WHEN p.completed = 0 THEN 'ongoing' ELSE 'not started' END AS status
            FROM learn_typing_groups as g,learn_typing_skills as s,learn_typing_levels as l,learn_typing_progress as p 
            WHERE s.level_id = l.id and g.skill_id = s.id and g.id = '".$user_id."' LIMIT 1";

            $result = $conn->query($sql);

            if(!$result){
                die("Query failed at get_progress: ". $conn->error);
            }

            $res_array = array();

            while($row = $result->fetch_assoc()){
                $obj = new Progress($row);
                array_push($res_array, $obj);
            }

            return $res_array;
        }

        class Group{
            public $group_id;
            public $group_name;
            public $skill_name;
            public $p_text;
            public $alphabets;
            public $combinations;
            public function __construct($obj){
                $this->group_id = $obj["group_id"];
                $this->group_name = $obj["group_name"];
                $this->skill_name = $obj["skill_name"];
                $this->p_text = $obj["p_text"];
                $this->alphabets = $obj["alphabets"];
                $this->combinations = $obj["combinations"];
            }

        }

       function get_group_desc($group_id){
            $conn = makeConnection();

            $sql = "SELECT *, g.id as group_id FROM learn_typing_groups g ";
            $sql .= "INNER JOIN learn_typing_skills s ";
            $sql .= "ON g.skill_id = s.id ";
            $sql .= "WHERE g.id = ". $group_id;

            $result = $conn->query($sql);

            if(!$result){
                die("Query failed at get_group_desc: ". $conn->error);
            }

            $res = $result->fetch_assoc();
            $obj = new Group($res);

            return $obj;
       }

       $function_name = $_GET["function_name"] ?? "";

       if($function_name == "get_progress"){
            echo json_encode(get_progress($_POST["user_id"]));
       }
?>