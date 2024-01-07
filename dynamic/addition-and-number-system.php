<?php 
    if(in_array($sbtpName, array('255', '256'))) {
        $question_obj = array(
            array(
                "str" => "What is the value of the following equation?<br>",
                "type" => "calculation"
            ),
            array(
                "str" => "What is the number name for the value of the following equation?<br>",
                "type" => "number_name"
            ),
            array(
                "str" => "What is the place value of the first occurrence of %%digit%% in the value of the following equation?<br>",
                "type" => "place_value"
            )
        );

        $places = array(1, 10, 100, 1000);

        shuffle($question_obj);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;
            $set_question = $question_obj[$quest_loop];

            $num_1;
            $num_2;
            $result;
            $options = array();
            $answer;
            $question;
            $count = 0;
            $equation = "";

            if($sbtpName == '255') {
                $num_1 = mt_rand(10, 100);
                $num_2 = numberWithoutCarry($num_1);
                $result = $num_1 + $num_2;
                $equation = "$num_1 + $num_2";
            } else if($sbtpName == '256') {
                $num_1 = mt_rand(11, 100);
                $num_2 = numberWithoutBorrow($num_1);
                $result = $num_1 - $num_2;
                $equation = "$num_1 - $num_2";
            }

            if($set_question["type"] == "calculation") {
                $answer = $result;
                $count = 0;
                $options[] = $answer;
                while($count <= 100 && count($options) < 4) {
                    $incorrect = mt_rand(10, 200);
                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }
                    $count++;
                }

                $question = $set_question["str"];
            } else if($set_question["type"] == "number_name") {
                $answer = numberToIndianWords($result);
                $options[] = $answer;
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect = numberToIndianWords(mt_rand(10, 200));
                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }
                    $count++;
                }
                $question = $set_question["str"];
            } else if($set_question["type"] == "place_value") {
                $digit = getRandomDigitFromNumber($result);
                $place = findDigitPlace($result, $digit);
                $answer = numberToIndianWords($place);

                $options[] = $answer;
                $count = 0;
                while($count <= 100 && count($options) < 4){
                    $incorrect_temp = $digit * $places[array_rand($places)];
                    $incorrect = numberToIndianWords($incorrect_temp);

                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                }

                $question = str_replace("%%digit%%", $digit, $set_question["str"]);
            }

            $question .= $equation;

            if($count < 100) {
                $resp_check = checkQuestion($question);

                if($resp_check == 0){
                    shuffle($options);
                    setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
                }
            }
        }
    }
?>