<?php 
     $dir = __DIR__;
     $parent = dirname($dir);
     $parentdir = dirname($parent);
 
     require_once($parentdir . "/connection/conn.php");
     require_once($parentdir . "/connection/dependencies.php");

     class Leaderboard{
        public $id;
        public $name;
        public $class;
        public $school;
        public $wpm;
        public $accuracy;
        public $points;

        public function __construct($id, $name, $class, $school, $wpm, $accuracy, $points){
            $this->id = $id;
            $this->name = $name;
            $this->class = $class;
            $this->school = $school;
            $this->wpm = $wpm;
            $this->accuracy = $accuracy;
            $this->points = $points;
        }
     }

    function get_student_main_menu(){
        $conn = makeConnection();
        $student = getCurrentStudent();

        $sql = "SELECT u.id, u.fullname AS name, sc.vocab_class AS class, sm.name AS school, ts.wpm, ts.accuracy, ts.points
                FROM type_students ts
                RIGHT JOIN users u
                ON u.id = ts.student_id
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id
                WHERE u.id = ". $student['id'] .";";

        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed in get_student_main_menu: " . $conn->error);
        }

        return $result->fetch_assoc();
    }

    function getLeaderboard($user_id){
        $conn = makeConnection();

        $sql = "SELECT u.id, u.name, sc.vocab_class AS class, sm.name AS school, ts.wpm, ts.accuracy, ts.points, ts.time
                FROM type_students ts 
                INNER JOIN users u
                ON ts.student_id = u.id
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id 
                WHERE u.class = (SELECT sc1.id AS class 
                                FROM users u1 
                                JOIN subject_class sc1 
                                ON u1.class = sc1.id
                                WHERE u1.id = $user_id)
                ORDER BY ts.points DESC, ts.wpm DESC, ts.accuracy DESC, ts.time ASC";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed for getLeaderboard: " . $conn->error);
        }

        $res = array();

        while($row = $result->fetch_assoc()){
            $ele = new Leaderboard($row["id"], $row["name"], $row["class"], $row["school"], $row["wpm"], $row["accuracy"], $row["points"]);
            array_push($res,$ele);
        }

        return $res;
    }
?>