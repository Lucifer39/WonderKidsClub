<?php

    $dir = __DIR__;
    $parent = dirname($dir);
    $parentdir = dirname($parent);

    require_once($parentdir . "/connection/conn.php");
    require_once($parentdir . "/connection/dependencies.php");
    require_once("constants.php");
    require_once("flag.php");

    class Question{
        public $question;
        public $options;
        public $answer;

        public function __construct($question, $options, $answer){
            $this->question = $question;
            $this->options = explode(",", $options);
            $this->answer = $answer;
        }
    }

    function getQuestions($universe){
        $conn = makeConnection();
        $question_table = change_topic("questions", $universe);
        $wordset_table = change_topic("wordset", $universe);
        $uni_id = change_topic("id", $universe);

        $getclass = getCurrentStudent();
        $relevance = $getclass["class"];

        $sql = "SELECT word_array FROM ". $wordset_table ." WHERE relevance LIKE '%". $relevance ."%' ORDER BY timestamp DESC LIMIT 1";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed for getQuestions: " . $conn->error);
        }

        $res = $result->fetch_assoc();

        $res_array = explode(",", $res["word_array"]);

        $rand_index = array_rand($res_array, get_num_questions());

        $quiz_set = array();

        for($i = 0; $i < count($rand_index); $i++){
            $selected_id = $res_array[$rand_index[$i]];

            $sql_get = "SELECT * FROM ". $question_table ." WHERE ". $uni_id ." = ". $selected_id . " ORDER BY RAND() LIMIT 1;";
            $res = $conn->query($sql_get);

            if(!$res){
                die("Query failed for getQuestions: " . $conn->error);
            }

            $res_1 = $res->fetch_assoc();
            $question_obj = new Question($res_1["question"], $res_1["options"], $res_1["answer"]);

            array_push($quiz_set, $question_obj);
        }
        return $quiz_set;
    }

    function updateScore($student_id, $score, $time_taken, $universe){
        $conn = makeConnection();

        $timestamp = new DateTime();
        $sql_timestamp = $timestamp->format('Y-m-d H:i:s');

        $student_table = change_topic("student_table", $universe);

        $sql = "INSERT INTO ". $student_table ." (student_id, quiz_taken, score, time_taken, timestamp) ";
        $sql .= "VALUES (". $student_id .", 1, ". $score .", ". $time_taken .",'". $sql_timestamp ."') ";
        $sql .= "ON DUPLICATE KEY UPDATE quiz_taken = 1, score = ". $score .", time_taken = ". $time_taken .", timestamp = '". $sql_timestamp ."';";
        $result = $conn->query($sql);

        if($result !== true){
            die("Query failed for updateScore: " . $conn->error);
        }

        return;
    }
?>