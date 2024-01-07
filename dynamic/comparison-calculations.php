<?php 
    if(in_array($sbtpName, array('222', '223', '224'))) {
        $question_str = "Which of the following option correctly define the relationship given below? <br>";

        $signs = array("+", "-", "*", "/");
        $sign_1 = $signs[array_rand($signs)];
        $sign_2 = $signs[array_rand($signs)];

        $num_11 = mt_rand(100, 999);
        $num_21 = mt_rand(100, 999);

        $num_12 = mt_rand(100, 999);
        $num_22 = mt_rand(100, 999);

        if($sbtpName == "223") {
            $num_11 = mt_rand(1000, 9999);
            $num_21 = mt_rand(1000, 9999);
            $num_12 = mt_rand(1000, 9999);
            $num_22 = mt_rand(1000, 9999);
        }
        else if($sbtpName == "224") {
            $num_11 = mt_rand(10000, 99999);
            $num_21 = mt_rand(10000, 99999);
            $num_12 = mt_rand(10000, 99999);
            $num_22 = mt_rand(10000, 99999);
        }

        $first_value_num = 0;
        $second_value_num = 0;

        //first round
        if($sign_1 == "+") {
            $first_value_num = $num_11 + $num_12;
        }
        else if($sign_1 == "-") {
            $num_12 = mt_rand(100, $num_11 - 10);
            $first_value_num = $num_11 - $num_12;
        }
        else if($sign_1 == "*") {
            $num_12 = mt_rand(2, 99);

            if($sbtpName == "224") {
                $num_12 = mt_rand(2, 999);
            }

            $first_value_num = $num_11 * $num_12;
        }
        else if($sign_1 == "/") {
            $num_12 = mt_rand(2, 99);
            $first_value_num = $num_11 / $num_12;
        }

        //second round
        if($sign_2 == "+") {
            $second_value_num = $num_21 + $num_22;
        }
        else if($sign_2 == "-") {
            $num_22 = mt_rand(100, $num_21 - 10);
            $second_value_num = $num_21 - $num_22;
        }
        else if($sign_2 == "*") {
            $num_22 = mt_rand(2, 99);

            if($sbtpName == "224") {
                $num_22 = mt_rand(2, 999);
            }

            $second_value_num = $num_21 * $num_22;
        }
        else if($sign_2 == "/") {
            $num_22 = mt_rand(2, 99);
            $second_value_num = $num_21 / $num_22;
        }

        $first_value = $num_11 . " " . $sign_1 . " " . $num_12;
        $second_value = $num_21 . " " . $sign_2 . " " . $num_22;

        $question_str .= $first_value . " " . "____" . " " . $second_value;

        $options = array(
            array(
                "content" => ">",
                "isCorrect" => $first_value_num > $second_value_num
            ),
            array(
                "content" => "<",
                "isCorrect" => $first_value_num < $second_value_num
            ),
            array(
                "content" => "=",
                "isCorrect" => $first_value_num == $second_value_num
            ),
            array(
                "content" => "Cannot be determined",
                "isCorrect" => false
            )
        );

        $answer = "";
        foreach($options as $option) {
            if($option["isCorrect"]) {
                $answer = $option["content"];
            }
        }

        shuffle($options);

        $resp_check = checkQuestion($question_str);

        if($resp_check == 0) {
            setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question_str, $options[0]["content"], $options[1]["content"], $options[2]["content"], $options[3]["content"], $answer);
        }
    }
?>