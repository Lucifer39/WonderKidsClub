<?php 
    if(in_array($sbtpName, array('235', '234'))){
        $question_obj = array(
            // array(
            //     "type" => "single-factor",
            //     "str" => "Which one of the following is a factor of %%x%% ?"
            // ),
            // array(
            //     "type" => "single-factor",
            //     "str" => "Which of the following options is a factor of %%x%% ?"
            // ),
            // array(
            //     "type" => "single-factor-not",
            //     "str" => "Which one of the following is not a factor of %%x%% ?"
            // ),
            // array(
            //     "type" => "double-factor",
            //     "str" => "Which one of the following is a common factor of %%x%% and %%y%% ?"
            // ),
            // array(
            //     "type" => "single-multiple",
            //     "str" => "Which one of the following is the %%w%% multiple of %%x%% ?"
            // ),
            // array(
            //     "type" => "double-multiple",
            //     "str" => "Which one of the following is the product of the %%w%% multiples of %%x%% and %%y%% ?"
            // ),
            array(
                "type" => "number-of-factors",
                "str" => "Count how many factors does %%x%% have."
            ),
            array(
                "type" => "number-of-factors",
                "str" => "How many factors does %%x%% have?"
            ),
            array(
                "type" => "number-of-factors",
                "str" => "Count the number of factors of %%x%%."
            ),
            array(
                "type" => "sum-of-factors",
                "str" => "What is the sum of the factors of %%x%%?"
            ),
            array(
                "type" => "sum-of-factors",
                "str" => "Calculate the sum of the factors of %%x%%?"
            ),
        );

        $multplier_array = array(
            array("place" => "first", "multiplier" => 1),
            array("place" => "second", "multiplier" => 2),
            array("place" => "third", "multiplier" => 3),
            array("place" => "fourth", "multiplier" => 4),
            array("place" => "fifth", "multiplier" => 5),
            array("place" => "sixth", "multiplier" => 6),
            array("place" => "seventh", "multiplier" => 7),
            array("place" => "eighth", "multiplier" => 8),
            array("place" => "ninth", "multiplier" => 9),
            array("place" => "tenth", "multiplier" => 10)
        );

        $set_question = $question_obj[mt_rand(0, count($question_obj) - 1)];
        $options = array();
        $answer = 1;
        $count = 0;

        if($set_question["type"] == "single-factor") {
            $answer = mt_rand(2, 25);
            $num = mt_rand(5, 25) * $answer;

            array_push($options, $answer);
            while($count <= 100 && count($options) < 4){
                $incorrect = mt_rand(2, intval($num / 2));

                if($incorrect !== 0 && ($num % $incorrect !== 0) && !in_array($incorrect, $options)){
                    $count = 0;
                    array_push($options, $incorrect);
                }

                $count++;
            }

            $question = str_replace("%%x%%", $num, $set_question["str"]);

        }
        else if($set_question["type"] == "single-factor-not") {
            $num = mt_rand(10, 100);
            
            $count = 0;
            do{
                $answer = mt_rand(2, 100);
                $count++;
            }while($count <= 100 && $num % $answer == 0);

            if($count <= 100){
                array_push($options, $answer);
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect = mt_rand(2, intval($num / 2));

                    if($incorrect !== 0 && ($num % $incorrect == 0) && !in_array($incorrect, $options)){
                        $count = 0;
                        array_push($options, $incorrect);
                    }
    
                    $count++;
                }
            }

            $question = str_replace("%%x%%", $num, $set_question["str"]);
        }
        else if($set_question["type"] == "double-factor") {
            $answer = mt_rand(2, 25);
            $multiplier_1 = mt_rand(2, 25) * $answer;
            $multiplier_2 = mt_rand($answer, $multiplier_1 - 1) * $answer;

            array_push($options, $answer);
            $count = 0;

            while($count <= 100 && count($options) < 4) {
                $incorrect = mt_rand(2, intval(min($multiplier_1, $multiplier_2) / 2));

                if($incorrect !== 0 && ($multiplier_1 % $incorrect !== 0 && $multiplier_2 % $incorrect !== 0) && !in_array($incorrect, $options)){
                    $count = 0;
                    array_push($options, $incorrect);
                }

                $count++;
            } 

            $question = str_replace("%%x%%", $multiplier_1, $set_question["str"]);
            $question = str_replace("%%y%%", $multiplier_2, $question);
        }
        else if($set_question["type"] == "single-multiple") {
            $random_multiple = $multplier_array[mt_rand(0, count($multplier_array) - 1)];
            $num = mt_rand(2, 50);
            $answer = $num * $random_multiple["multiplier"];

            array_push($options, $answer);
            $count = 0;

            while($count <= 100 && count($options) < 4) {
                $incorrect_place = $multplier_array[mt_rand(0, count($multplier_array) - 1)];
                $incorrect = $num * $incorrect_place["multiplier"];

                if(($incorrect_place["place"] !== $random_multiple["place"] && !in_array($incorrect, $options))) {
                    $count = 0;
                    array_push($options, $incorrect);
                }

                $count++;
            }

            $question = str_replace("%%x%%", $num, $set_question["str"]);
            $question = str_replace("%%w%%", $random_multiple["place"], $question);
        }
        else if($set_question["type"] == "double-multiple") {
            $num_1 = mt_rand(2, 12);
            $num_2 = mt_rand($num_1 + 1, 25);

            $random_multiple = $multplier_array[mt_rand(0, count($multplier_array) - 1)];

            $multiple_1 = $num_1 * $random_multiple["multiplier"];
            $multiple_2 = $num_2 * $random_multiple["multiplier"];

            $answer = $multiple_1 * $multiple_2;

            array_push($options, $answer);
            $count = 0;

            while($count <= 100 && count($options) < 4) {
                $incorrect_place = $multplier_array[mt_rand(0, count($multplier_array) - 1)];
                $multiple_1 = $num_1 * $incorrect_place["multiplier"];
                $multiple_2 = $num_2 * $incorrect_place["multiplier"];

                $incorrect = $multiple_1 * $multiple_2;

                if(($answer !== $incorrect) && !in_array($incorrect, $options)) {
                    $count = 0;
                    array_push($options, $incorrect);
                }

                $count++;
            }

            $question = str_replace("%%x%%", $num_1, $set_question["str"]);
            $question = str_replace("%%y%%", $num_2, $question);
            $question = str_replace("%%w%%", $random_multiple["place"], $question);
        }
        else if($set_question["type"] == "number-of-factors") {
            $num = mt_rand(2, 12) * mt_rand(2, 12);
            $answer = countFactors($num);
            $options = array($answer);

            $count = 0;
            while($count <= 100 && count($options) < 4) {
                $incorrect = mt_rand(0, 1) == 1 ? $answer + mt_rand(1, 5) : abs($answer - mt_rand(1, 5));

                if(!in_array($incorrect, $options)) {
                    $options[] = $incorrect;
                    $count = 0;
                }

                $count++;
            }

            $question = str_replace("%%x%%", $num, $set_question["str"]);
        }
        else if($set_question["type"] == "sum-of-factors") {
            $num = mt_rand(2, 12) * mt_rand(2, 12);
            $answer = sumFactors($num);
            $options = array($answer);

            $count = 0;
            while($count <= 100 && count($options) < 4) {
                $incorrect = mt_rand(0, 1) == 1 ? $answer + mt_rand(1, 5) : abs($answer - mt_rand(1, 5));

                if(!in_array($incorrect, $options)) {
                    $options[] = $incorrect;
                    $count = 0;
                }

                $count++;
            }

            $question = str_replace("%%x%%", $num, $set_question["str"]);
        }

        if($count < 100) {
            $resp_check = checkQuestion($question);

            if($resp_check == 0){
                shuffle($options);
                setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
            }
        }
    }
?>