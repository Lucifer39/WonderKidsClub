<?php 
    if(in_array($sbtpName, array('131', '132', '133', '134',))){
        $questionArray = array("substractionNumbersQuestion", "additionNumbersQuestion");

        $min_term = 1000;
        $max_term = 9999;
        $num_digits = 3;

        if($sbtpName == '133'){
            $min_term = 10000;
            $max_term = 99999;
            $num_digits = 4;
        }
        else if($sbtpName == '134'){
            $min_term = 100000;
            $max_term = 999999;
            $num_digits = 5;
        }

        $selected_num = mt_rand($min_term, $max_term);
        
        $finalArray = str_split(strval($selected_num));
        $finalArrayStr = implode(",", $finalArray);

        $options = [];
        $answer = "";
        $question = "";
        $randoNum;
        $randoNum = mt_rand() / mt_getrandmax();
        $randoNum = floor($randoNum * count($questionArray));
        $get_question = $questionArray[$randoNum];

        $resp_answer = $get_question($finalArrayStr, $num_digits);

        $resp_answer->question = str_replace("%%n%%", $num_digits, $resp_answer->question);
        $resp_answer->question = str_replace("%%n%%", $num_digits, $resp_answer->question);
        $resp_answer->question = str_replace("%%m%%", $finalArrayStr, $resp_answer->question);

        $question = $resp_answer->question;
        $answer = $resp_answer->answer;

        $resp_check = checkQuestion($question);

        if($resp_check == 0){
            $options = generateIncorrectOptions(strval($answer));

            if($options !== 0){
                setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
            }
        }


    }
?>