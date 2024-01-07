<?php 
    if(in_array($sbtpName, array('135', '136', '137'))){
        $question_obj = array(
            array(
                "type" => "ascending",
                "str" => "Arrange the following fractions in ascending order: <br> %%x%%"
            ),
            array(
                "type" => "descending",
                "str" => "Arrange the following fractions in descending order: <br> %%x%%"
            ),
            array(
                "type" => "ascending",
                "str" => "Which of the following is in ascending order?"
            ),
            array(
                "type" => "descending",
                "str" => "Which of the following is in descending order?"
            ),
        );

        shuffle($question_obj);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;

            $fraction_array = array();
            $num_fractions = mt_rand(5, 6);

            // $randomIndex = array_rand($question_obj);
            $set_question = $question_obj[$quest_loop];

            if($sbtpName == '135'){
                $denominator = mt_rand(15, 100);
                for($k = 0; $k < $num_fractions; $k++){
                    $fraction = "";
                    do{
                        $numerator = mt_rand(2, $denominator - 1);
                        $fraction = strval($numerator) . "/" . strval($denominator);
                    }while(in_array($fraction, $fraction_array));
                    array_push($fraction_array, $fraction);
                }
            }

            else{
                for($k = 0; $k < $num_fractions; $k++){

                    $fraction = "";
                    do{
                        $denominator = mt_rand(15, 100);
                        $numerator = mt_rand(1, $denominator - 1);

                        $fraction = strval($numerator) . "/" . strval($denominator);
                    }while(in_array($fraction, $fraction_array));

                    array_push($fraction_array, $fraction);
                }
            }

            // var_dump($fraction_array);



            if($set_question["type"] == "ascending"){
                $answer = sortFractionsAscending($fraction_array);
            }
            else {
                $answer = sortFractionsDescending($fraction_array);
            }

            // var_dump($answer);
            $question_str = implode(',', $fraction_array);
            $question = str_replace("%%x%%", $question_str, $set_question["str"]);

            // var_dump($set_question);

            $temp_answer = $answer;
            $options = array(implode(',', $answer));

            $count = 0;
            while($count <= 100 && count($options) < 4){
                shuffle($temp_answer);
                $temp_str = implode(',', $temp_answer);

                if(!in_array($temp_str, $options)){
                    $count = 0;
                    array_push($options, $temp_str);
                }

                $count++;
            }

            shuffle($options);

            // var_dump($options);

            if($count <= 100)
            $resp = setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], implode(',', $answer));
            // var_dump($resp);
        }   
    }
?>