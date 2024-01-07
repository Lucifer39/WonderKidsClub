<?php 
    if(in_array($sbtpName, array('153'))){
        $question_obj = array(
            array(
                "type" => "addition",
                "str" => "What is the value of the following equation? <br>",
            ),
            array(
                "type" => "subtraction",
                "str" => "What is the value of the following equation? <br>",
            ),
            array(
                "type" => "multiplication",
                "str" => "What is the value of the following equation? <br>",
            ),
            array(
                "type" => "division",
                "str" => "What is the value of the following equation? <br>",
            )
        );

        // $randomIndex = array_rand($question_obj);
        // $set_question = $question_obj[$randomIndex];

        shuffle($question_obj);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;
        
            $set_question = $question_obj[$quest_loop];
            $num1 = mt_rand(3, 100);
            $answer;

            if($set_question["type"] == "addition"){
                $num2 = mt_rand(2, 100);
                $answer = ($num1 + $num2);
                $sign = " + ";
            }
            else if($set_question["type"] == "subtraction"){
                $num2 = mt_rand(1, $num1 - 1);
                $answer = ($num1 - $num2);
                $sign = " - ";
            }
            else if($set_question["type"] == "multiplication"){
                $num2 = mt_rand(2, 99);
                $answer = ($num1 * $num2);
                $sign = " × ";
            }
            else if($set_question["type"] == "division") {
                $num2 = mt_rand(3, 100);
                $num1 = mt_rand(1, 25) * $num2;
                $answer = (intval($num1 / $num2));
                $sign = " ÷ ";
            }

            $question = $set_question["str"] . " " .  implode($sign, array(intToRoman($num1), intToRoman($num2)));

            $options = generateIncorrectOptions(strval($answer));


            if($options !== 0) {
                setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, intToRoman($options[0]), intToRoman($options[1]), intToRoman($options[2]), intToRoman($options[3]), intToRoman($answer));
            }
        }
    }
?>
