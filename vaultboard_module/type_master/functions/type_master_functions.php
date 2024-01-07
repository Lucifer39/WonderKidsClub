<?php 
     $dir = __DIR__;
     $parent = dirname($dir);
     $parentdir = dirname($parent);
 
     require_once($parentdir . "/connection/conn.php");
     require_once($parentdir . "/connection/dependencies.php");

     class Sentences{

      public $sentence_id;
      public $sentence;
      public $category;

      public function __construct($sentence_id, $sentence, $category){
         $this->sentence_id = $sentence_id;
         $this->sentence = $sentence;
         $this->category = $category;
      }
     }

     function getSentences($question_count){
        $conn = makeConnection();
        $getclass = getCurrentStudent();
        $guestClass = getGuest();
        $student_class = $getclass["class"] ?? $guestClass;
        
        $sql = "SELECT * FROM type_sentences WHERE relevance LIKE '%". $student_class ."%' ORDER BY RAND() LIMIT ". $question_count .";";

        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed in get_sentences: " . $conn->error);
         }

         $res_array = array();

         while($row = $result->fetch_assoc()){

            $res_obj = new Sentences($row["id"], $row["sentence"], $row["category"]);
            array_push($res_array, $res_obj);
         }

         return $res_array;
     }

     function updateScores($student_id, $points, $time, $accuracy, $wpm){
         $conn = makeConnection();

         $timestamp = new DateTime();
         $sql_timestamp = $timestamp->format('Y-m-d H:i:s');
 
         $sql = "INSERT INTO type_students (student_id, wpm, points, time, accuracy, last_played) ";
         $sql .= "VALUES (". $student_id .", ". $wpm .", ". $points .", ". $time .",". $accuracy .",'". $sql_timestamp ."') ";
         $sql .= "ON DUPLICATE KEY UPDATE "; 
         $sql .= "wpm = CASE WHEN wpm < VALUES(wpm) THEN VALUES(wpm) ELSE wpm END,
         points = CASE WHEN points < VALUES(points) THEN VALUES(points) ELSE points END,
         time = CASE WHEN time < VALUES(time) THEN VALUES(time) ELSE time END,
         accuracy = CASE WHEN accuracy < VALUES(accuracy) THEN VALUES(accuracy) ELSE accuracy END,
         last_played = CASE WHEN last_played < VALUES(last_played) THEN VALUES(last_played) ELSE last_played END;";
        $result = $conn->query($sql);
 
         if($result !== true){
             die("Query failed for updateScores: " . $conn->error);
         }
 
         return;
     }
?>