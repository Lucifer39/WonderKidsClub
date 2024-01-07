<?php 
    if(in_array($sbtpName, array('165', '167', '168', '169'))){
        $question_obj = array(
            array(
                "type" => "addition",
                "str" => "What is the value of the following equation after rounding them off to the nearest %%x%% place? <br>",
            ),
            array(
                "type" => "subtraction",
                "str" => "What is the value of the following equation after rounding them off to the nearest %%x%% place? <br>",
            ),
            array(
                "type" => "multiplication",
                "str" => "What is the value of the following equation after rounding them off to the nearest %%x%% place? <br>",
            ),
            array(
                "type" => "division",
                "str" => "What is the value of the following equation after rounding them off to the nearest %%x%% place? <br>",
            ),
        );

        $question_obj_add_sub = array(
            array(
                "type" => "addition",
                "str" => "What is the value of the following equation after rounding them off to the nearest %%x%% place? <br>",
            ),
            array(
                "type" => "subtraction",
                "str" => "What is the value of the following equation after rounding them off to the nearest %%x%% place? <br>",
            )
        );

        $places_array = array(
            array(
                "type" => "tens",
                "round_off" => 10
            ), 
            array(
                "type" => "hundreds",
                "round_off" => 100
            )
        );

        shuffle($question_obj);
        shuffle($question_obj_add_sub);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;

            $randomIndex = array_rand($places_array);
            $random_rounded = $places_array[$randomIndex];

            $num_1;
            $num_2;
            $question;
            $answer;

            if($sbtpName == '165') {
                $set_question = $question_obj_add_sub[$quest_loop % count($question_obj_add_sub)];
                $num_1 = mt_rand(1005, 9999);
                $num_2 = mt_rand(1000, $num_1 - 1);
            }
            else if($sbtpName == '167') {
                $set_question = array(
                    "type" => "multiplication",
                    "str" => "What is the value of the following equation after rounding them off to the nearest %%x%% place? <br>",
                );
                $num_1 = mt_rand(101, 999);
                $num_2 = mt_rand(2, 999);

                if($num_2 < 100) {
                    $random_rounded = $places_array[0];
                }
            }
            else if($sbtpName == '169') {
                $set_question = array(
                    "type" => "division",
                    "str" => "What is the value of the following equation after rounding them off to the nearest %%x%% place? <br>",
                );
                $num_2 = mt_rand(5, 99);
                $num_1 = $num_2 * mt_rand(100, 1000);
                $random_rounded = $places_array[0];
            }
            else if($sbtpName == '168'){
                $set_question = $question_obj[$quest_loop];

                if($set_question["type"] == "addition" || $set_question == "subtraction") {
                    $num_1 = mt_rand(1000005, 9999999);
                    $num_2 = mt_rand(1000000, $num_1 - 1);
                }
                else if($set_question["type"] == "multiplication"){
                    $num_1 = mt_rand(10001, 99999);
                    $num_2 = mt_rand(2, 999);

                    if($num_2 < 100) {
                        $random_rounded = $places_array[0];
                    }
                }
                else {
                    $num_2 = mt_rand(5, 99);
                    $num_1 = $num_2 * mt_rand(100, 1000);
                    $random_rounded = $places_array[0];
                }
            }
            
            
            $rounded_num_1 = roundToNearest($num_1, $random_rounded["round_off"]);
            $rounded_num_2 = roundToNearest($num_2, $random_rounded["round_off"]);
            

            if($set_question["type"] == "addition") {
                $answer = $rounded_num_1 + $rounded_num_2;
                $question = str_replace("%%x%%", $random_rounded["type"], $set_question["str"]) . "$num_1 + $num_2";
            }
            else if($set_question["type"] == "subtraction") {
                $answer = $rounded_num_1 - $rounded_num_2;
                $question = str_replace("%%x%%", $random_rounded["type"], $set_question["str"]) . "$num_1 - $num_2";
            }
            else if($set_question["type"] == "multiplication") {
                $answer = $rounded_num_1 * $rounded_num_2;
                $question = str_replace("%%x%%", $random_rounded["type"], $set_question["str"]) . "$num_1 × $num_2";
            }
            else if($set_question["type"] == "division") {
                $answer = intval($rounded_num_1 / $rounded_num_2);
                $question = str_replace("%%x%%", $random_rounded["type"], $set_question["str"]) . "$num_1 ÷ $num_2";
            }

            $resp_check = checkQuestion($question);


            if($resp_check == 0){
                $options = generateIncorrectOptions(strval($answer));

                if($options !== 0){
                    setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
                }
            }
        }
    }
?>