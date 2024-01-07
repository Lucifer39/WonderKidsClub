<?php
     $dir = __DIR__;
     $parent = dirname($dir);
     $parentdir = dirname($parent);
 
     require_once($parentdir . "/connection/conn.php");
     require_once($parentdir . "/connection/dependencies.php");


    function generateQuestions(){
        $conn = makeConnection();
        $question_set = array("What is the meaning of * ?", "What is the antonym of * ?", "What is the synonym of * ?");

        $sql = "SELECT * FROM dictionary WHERE has_question <> 1 LIMIT 500;";
        $result_words = $conn->query($sql);

        if(!$result_words){
            die("Query failed for generateQuestions: " . $conn->error);
        }

        while($row = $result_words->fetch_assoc()){
            $questions = constructQuestions($question_set, $row["word"]);

            //meaning
            $options = getOptions($row["id"], "word_definition");
            $answer = explode(",", $row["word_definition"]);
            array_push($options, $answer[0]);
            $final_options = randomizeOptions($options);
            sqlInsert($row["id"], $questions[0], $final_options, $answer[0]);

            //antonyms
            $options = getOptions($row["id"], "antonyms");
            $res = explode(",", $row["antonyms"]);
            $get_option = getOptionFromArray($res);
            array_push($options, $get_option);
            $final_options = randomizeOptions($options);
            sqlInsert($row["id"], $questions[1], $final_options, $get_option);
            
            //synonyms
            $options = getOptions($row["id"], "synonyms");
            $res = explode(",", $row["synonyms"]);
            $get_option = getOptionFromArray($res);
            array_push($options, $get_option);
            $final_options = randomizeOptions($options);
            sqlInsert($row["id"], $questions[2], $final_options, $get_option);
        }
    }

    function getOptions($id, $option_type){
        $conn = makeConnection();

        $sql = "SELECT ". $option_type ." FROM dictionary WHERE id <> ". $id ." ORDER BY RAND() LIMIT 3;";

        $result = $conn->query($sql);

        $response = array();

        if(!$result){
            die("Query failed for getOptions: " . $conn->error);
        }

        while($row = $result->fetch_assoc()){
            array_push($response, $row[$option_type]);
        }

        if($option_type !== "word_definition"){

            $answers = array();

           for($i = 0; $i < count($response); $i++){
            $res = explode(",", $response[$i]);
            $res_1 = getOptionFromArray($res);

            array_push($answers, $res_1);
           }

           return $answers;
        }

        else{

            $meaning_res = array();

            foreach($response as $meaning){
                $abc = explode(",", $meaning);
                array_push($meaning_res, $abc[0]);
            }

            return $meaning_res;
        }

    }

    function randomizeOptions($option_array){
        shuffle($option_array);
        $res = implode(",", $option_array);
        return $res;
    }

    function getOptionFromArray($array_words){
        $random_key = array_rand($array_words);
        return $array_words[$random_key];
    }

    function constructQuestions($question_set, $word){
        $questions = array();
        for($i = 0; $i < count($question_set); $i++){
            array_push($questions, str_replace("*", $word, $question_set[$i]));
        }

        return $questions;
    }

    function sqlInsert($word_id, $question, $options, $answer){
        $conn = makeConnection();
        $sql = "INSERT INTO questions (word_id, question, options, answer) VALUES (?,?,?,?);";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isss", $word_id, $question, $options, $answer);

        // echo "Inserted<br>";

        if (mysqli_stmt_execute($stmt)) {
            $sql_update = "UPDATE dictionary SET has_question = 1 WHERE id = $word_id";
            $result = $conn->query($sql_update);

            if(!$result){
                die("Query failed at sqlInsert: ". $conn->error);
            }

        } else {
          echo "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        return;

    }

    // generateQuestions();

    //phpinfo();
?>