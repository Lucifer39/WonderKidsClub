<?php 
    if(in_array($sbtpName, array('151', '152'))){
        $question_obj = array(
            array(
                "type" => "HCF",
                "str" => "What is the HCF of the given numbers? <br>"
            ),
            array(
                "type" => "LCM",
                "str" => "What is the LCM of the given numbers? <br>"
            ),
            array(
                "type" => "HCF",
                "str" => "What is the highest common factor of the given numbers? <br>"
            ),
            array(
                "type" => "LCM",
                "str" => "What is the lowest common multiple of the given numbers? <br>"
            ),
        );

        shuffle($question_obj);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;

            $set_question = $question_obj[$quest_loop];
            $num_array = array();
            $max_nums = $set_question["type"] == "HCF" ? 2 : 3;

            for($k = 0; $k < $max_nums; $k++){
                $rand_num = mt_rand(1, 9) * mt_rand(1, 9);

                if($set_question["type"] == "HCF") {
                    $rand_num = $rand_num * mt_rand(1, 19);
                }

                array_push($num_array, $rand_num);
            }

            $answer;
            $question = $set_question["str"] . implode(", ", $num_array);

            if($set_question["type"] == "HCF"){
                $answer = arrayHCF($num_array);
            }
            else {
                $answer = arrayLCM($num_array);
            }

            $options = generateIncorrectOptions(strval($answer));
            
            if($options !== 0)
            setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
        }
    }
?>