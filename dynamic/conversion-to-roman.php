<?php 
    if(in_array($sbtpName, array('244', '245', '246'))) {
        $question_obj = array(
            array(
                "type" => "number_to_roman",
                "str" => "What is this number in roman numerals? <br>"
            ),
            array(
                "type" => "roman_to_number",
                "str" => "What is this roman numeral in decimal number? <br>"
            ),
        );

        shuffle($question_obj);
        
        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;

            $number = mt_rand(1, 10000);
            $set_question = $question_obj[$quest_loop];
            $answer;
            $question;
            $options = [];
            $count = 0;

            if($set_question["type"] == "number_to_roman") {
                $answer = intToRoman($number);
                $options[] = $answer;

                while($count <= 100 && count($options) < 4) {
                    $incorrect_ans = mt_rand(0, 1) == 1 ? $number + mt_rand(1, 5) : abs($number - mt_rand(1, 5));
                    $incorrect = intToRoman($incorrect_ans);

                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                } 

                $question = $set_question["str"] . $number;
            } else if($set_question["type"] == "roman_to_number") {
                $answer = $number;

                $options[] = $answer;

                while($count <= 100 && count($options) < 4) {
                    $incorrect = mt_rand(0, 1) == 1 ? $number + mt_rand(1, 5) : abs($number - mt_rand(1, 5));

                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                } 

                $question = $set_question["str"] . intToRoman($number);
            }

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