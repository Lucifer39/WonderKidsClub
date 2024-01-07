<?php 
    if(in_array($sbtpName, array('154', '155', '156', '157', '158', '159', '161', '162', '163', '164'))){
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
            ),
        );

        $question_obj_add_sub = array(
            array(
                "type" => "addition",
                "str" => "What is the value of the following equation? <br>",
            ),
            array(
                "type" => "subtraction",
                "str" => "What is the value of the following equation? <br>",
            ),
        );

        shuffle($question_obj);
        shuffle($question_obj_add_sub);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;

            $num_1;
            $num_2;
            $question;
            $answer;

            if($sbtpName == '154'){
                $set_question =  array(
                                        "type" => "addition",
                                        "str" => "What is the value of the following equation? <br>",
                                    );
                $num_1 = mt_rand(2, 99);
                $num_2 = numberWithoutCarry($num_1);

            }
            else if($sbtpName == '155'){
                $set_question = array(
                                        "type" => "subtraction",
                                        "str" => "What is the value of the following equation? <br>",
                                    );
                $num_1 = mt_rand(2, 99);
                $num_2 = numberWithoutBorrow($num_1);
            }
            else if($sbtpName == '156'){
                $set_question = $question_obj_add_sub[$quest_loop % count($question_obj_add_sub)];
                $num_1 = mt_rand(10, 999);
                $num_2 = mt_rand(10, 999);
            }
            else if($sbtpName == "157"){
                $set_question = $question_obj_add_sub[$quest_loop % count($question_obj_add_sub)];
                $num_1 = mt_rand(1005, 9999);
                $num_2 = mt_rand(1000, $num_1 - 1);
            }
            else if($sbtpName == "158"){
                $set_question = $question_obj_add_sub[$quest_loop % count($question_obj_add_sub)];
                $num_1 = mt_rand(10005, 99999);
                $num_2 = mt_rand(10000, $num_1 - 1);
            }
            else if($sbtpName == "161"){
                $set_question = array(
                                        "type" => "multiplication",
                                        "str" => "What is the value of the following equation? <br>",
                                    );
                $num_1 = mt_rand(101, 999);
                $num_2 = mt_rand(2, 999);
            }
            else if($sbtpName == "162" || $sbtpName == '164'){
                $set_question = array(
                                        "type" => "division",
                                        "str" => "What is the value of the following equation? <br>",
                                    );
                $num_2 = mt_rand(2, 99);
                $num_1 = $num_2 * mt_rand(100, 1000);
            }
            else if($sbtpName == "159"){
                $set_question = $question_obj_add_sub[$quest_loop % count($question_obj_add_sub)];
                $num_1 = mt_rand(1000005, 9999999);
                $num_2 = mt_rand(1000000, $num_1 - 1);
            }
            else if($sbtpName == "163"){
                $set_question = array(
                                        "type" => "multiplication",
                                        "str" => "What is the value of the following equation? <br>",
                                    );
                $num_1 = mt_rand(10001, 99999);
                $num_2 = mt_rand(2, 999);
            }



            if($set_question["type"] == "addition") {
                $answer = $num_1 + $num_2;
                $question = $set_question["str"] . "$num_1 + $num_2";
            }
            else if($set_question["type"] == "subtraction") {
                $answer = $num_1 - $num_2;
                $question = $set_question["str"] . "$num_1 - $num_2";
            }
            else if($set_question["type"] == "multiplication") {
                $answer = $num_1 * $num_2;
                $question = $set_question["str"] . "$num_1 × $num_2";
            }
            else if($set_question["type"] == "division") {
                $answer = intval($num_1 / $num_2);
                $question = $set_question["str"] . "$num_1 ÷ $num_2";
            }

            $resp_check = checkQuestion($question);


            if($resp_check == 0){
                $options = generateIncorrectOptions(strval($answer));

                if($options !== 0) {
                    setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
                }
            }
        }
    }
?>