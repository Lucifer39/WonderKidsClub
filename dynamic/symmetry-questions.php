<?php 
    if(in_array($sbtpName, array('242', '241'))) {

        $question_obj =array( 
            array(
                "type" => "count_slanting",
                "str" => "How many slanting lines are there in the given figure?",
            ),
            array(
                "type" => "count_standing",
                "str" => "How many standing lines are there in the given figure?",
            ),
            array(
                "type" => "count_symmetry",
                "str" => "Considering each alphabet individually, how many total lines of symmetry are there?",
            ),
            array(
                "type" => "count_sleeping",
                "str" => "How many sleeping lines are there in the given figure?",
            ),
            array(
                "type" => "atleast_one",
                "str" => "How many of the following letters have atleast one line of symmetry?",
            ),
        );

        shuffle($question_obj);
        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++){
            $i++;
            $set_question = $question_obj[$quest_loop];

            $question = "";
            $answer = 0;
            $options = array();
            $count = 0;

            $word = strtoupper(generateRandomWord(mt_rand(5, 7), ''));
            $word_sept = str_split($word);

            if($set_question["type"] == "count_slanting") {
                $answer = 0;
                foreach($word_sept as $letter) {
                    $sql = "SELECT slanting_lines FROM symmetry_mapping WHERE imgName = '$letter'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $answer += $row["slanting_lines"];
                }

                $options[] = $answer;
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect = abs(mt_rand($answer - 4, $answer + 4));
                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                }

                $question = $set_question["str"];
            } else if($set_question["type"] == "count_standing") {
                $answer = 0;
                foreach($word_sept as $letter) {
                    $sql = "SELECT standing_lines FROM symmetry_mapping WHERE imgName = '$letter'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $answer += $row["standing_lines"];
                }

                $options[] = $answer;
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect = abs(mt_rand($answer - 4, $answer + 4));
                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                }

                $question = $set_question["str"];
            } else if($set_question["type"] == "count_symmetry") {
                $answer = 0;
                foreach($word_sept as $letter) {
                    $sql = "SELECT lines_of_symmetry FROM symmetry_mapping WHERE imgName = '$letter'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $answer += $row["lines_of_symmetry"];
                }

                $options[] = $answer;
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect = abs(mt_rand($answer - 4, $answer + 4));
                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                }

                $question = $set_question["str"];
            } else if($set_question["type"] == "count_sleeping") {
                $answer = 0;
                foreach($word_sept as $letter) {
                    $sql = "SELECT sleeping_lines FROM symmetry_mapping WHERE imgName = '$letter'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $answer += $row["sleeping_lines"];
                }

                $options[] = $answer;
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect = abs(mt_rand($answer - 4, $answer + 4));
                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                }

                $question = $set_question["str"];
            } else if($set_question["type"] == "atleast_one") {
                $answer = 0;
                foreach($word_sept as $letter) {
                    $sql = "SELECT lines_of_symmetry FROM symmetry_mapping WHERE imgName = '$letter'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);

                    if($row["lines_of_symmetry"] > 0)
                    $answer++;
                }

                $options[] = $answer;
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect = abs(mt_rand($answer - 4, $answer + 4));
                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                }

                $question = $set_question["str"];
            }
            
            shuffle($options);
            setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer, $word);

        }
        
    }
?>