<?php
        $dir = __DIR__;
        $parent = dirname($dir);
        $parentdir = dirname($parent);
    
        require_once($parentdir . "/connection/conn.php");
        require_once($parentdir . "/connection/dependencies.php");
        require_once("flag.php");

    class Leaderboard{
        public $id;
        public $name;
        public $school;
        public $class;
        public $last_week_score;
        public $time_taken;

        public function __construct($id, $name,  $school, $score, $class, $time_taken){
            $this->id = $id;
            $this->name = $name;
            $this->school = $school;
            $this->last_week_score = $score;
            $this->class = $class;
            $this->time_taken = $time_taken;
        }
    }
    function getLeaderboard($universe, $user_id){
        $conn = makeConnection();

        $table = change_topic("student_table", $universe);

        $sql = "SELECT * FROM $table t
                JOIN users u
                ON t.student_id = u.id
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id
                WHERE u.class = (SELECT class FROM users  WHERE id = $user_id)
                ORDER BY t.score DESC, t.time_taken ASC";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed for getLeaderboard: " . $conn->error);
        }

        $res = array();

        while($row = $result->fetch_assoc()){
            $student = getStudent($row["student_id"]);
            $ele = new Leaderboard($student["id"], $student["name"], $student["school"], $row["score"], $student["class"], $row["time_taken"]);
            array_push($res,$ele);
        }

        return $res;

    }

    function checkQuizTaken($universe){
        $conn = makeConnection();

        $student = getCurrentStudent();
        $student_table = change_topic("student_table", $universe);

        $sql = "SELECT quiz_taken FROM ". $student_table ." WHERE student_id = '". $student["id"] ."';";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed for checkQuizTaken: " . $conn->error);
        }

        $res = $result->fetch_assoc();

        if(!$res){
            return 0;
        }
        else{
            return $res["quiz_taken"];
        }
    }

?>