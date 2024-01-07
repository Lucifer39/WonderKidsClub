    <?php 
    if(in_array($sbtpName, array('243', '248', '249', '253', '254'))){
        $question_obj = array(
            array(
                "str" => "What is the number form for the given number name? <br>",
                "type" => "name_to_numeral",
                "system" => "indian"
            ),
            array(
                "str" => "What is the number name for the given number? <br>",
                "type" => "numeral_to_name",
                "system" => "indian"
            ),
            array(
                "str" => "What is the number form for the given number name? <br>",
                "type" => "name_to_numeral",
                "system" => "international"
            ),
            array(
                "str" => "What is the number name for the given number? <br>",
                "type" => "numeral_to_name",
                "system" => "international"
            )
        );

        shuffle($question_obj);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;
            $set_question = $question_obj[$quest_loop];

            if($sbtpName == '253') {
                $question_obj_temp = array(
                    array(
                        "str" => "What is the numeral for the given number name? <br>",
                        "type" => "name_to_numeral",
                        "system" => "indian"
                    ),
                    array(
                        "str" => "What is the number name for the given number numeral? <br>",
                        "type" => "numeral_to_name",
                        "system" => "indian"
                    ),
                );
                $set_question = $question_obj_temp[$quest_loop % 2];
            }

            $options = array();
            $answer;
            $question;
            $count = 0;
            $function_name = $set_question["system"] == "indian" ? "numberToIndianWords" : "numberToWords";

            if($set_question["type"] == "numeral_to_name") {
                $number = mt_rand(100000, 100000000);

                if($sbtpName == '253') {
                    $number = mt_rand(1, 100);
                } else if($sbtpName == '254') {
                    $number = mt_rand(10, 1000000);
                } else if($sbtpName == '248') {
                    $number = mt_rand(1000, 10000000);
                }

                $answer = $function_name($number);
                $options[] = $answer;

                while($count <= 100 && count($options) < 4) {
                    $incorrect_ans = $sbtpName == '253' ? mt_rand(1, 100)  : rearrangeDigits($number);
                    $incorrect = $function_name($incorrect_ans);

                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                }

                $question = $set_question["str"] . $number;
            } else if($set_question["type"] == "name_to_numeral") {
                $answer = mt_rand(100000, 100000000);

                if($sbtpName == '248') {
                    $answer = mt_rand(1000, 10000000);
                } else if($sbtpName == '254') {
                    $answer = mt_rand(1, 100000);
                }

                $quest_str = $function_name($answer);

                $options[] = $answer;

                while($count <= 100 && count($options) < 4) {
                    $incorrect = rearrangeDigits($answer);

                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                }

                $question = $set_question["str"] . $quest_str;
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