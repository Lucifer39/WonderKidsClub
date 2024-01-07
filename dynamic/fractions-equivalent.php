<?php 
    if(in_array($sbtpName, array('146', '147'))){
        $question_obj = array(
            array(
                "type" => "present",
                "str" => "Which of the following is an equivalent fraction of: %%x%% ?"
            ),
            array(
                "type" => "present",
                "str" => "%%x%% is the same as ________"
            ),
            array(
                "type" => "not_present",
                "str" => "Which of the following is NOT an equivalent fraction of: %%x%% ?"
            ),
            array(
                "type" => "simplify",
                "str" => "Simplify the fraction: "
            ),
            array(
                "type" => "simplify",
                "str" => "Which of the following is the simplest form of: "
            )
        );

        shuffle($question_obj);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;

            $set_question = $question_obj[$quest_loop];
            $denominator = mt_rand(2, 25);
            $numerator = mt_rand(1, $denominator - 1);
            $fraction = "$numerator/$denominator";

            $options = array();
            $answer;
            $count = 0;

            if($set_question["type"] == "present"){
                $answer = generateEquivalentFractions($fraction);
                array_push($options, $answer);

                while($count <= 100 && count($options) < 4){
                    $incorrect = generateNonEquivalentFraction($fraction);

                    if(!in_array($incorrect, $options)) {
                        array_push($options, $incorrect);
                        $count = 0;
                    }

                    $count++;
                }
                $question = str_replace("%%x%%", $fraction, $set_question["str"]);

            }

            else if($set_question["type"] == "not_present") {
                $answer = generateNonEquivalentFraction($fraction);
                array_push($options, $answer);

                $count = 0;
                while($count <= 100 && count($options) < 4){
                    $incorrect = generateEquivalentFractions($fraction);

                    if(!in_array($incorrect, $options)) {
                        array_push($options, $incorrect);
                        $count = 0;
                    }

                    $count++;
                }
                $question = str_replace("%%x%%", $fraction, $set_question["str"]);

            }

            else if($set_question["type"] == "simplify") {
                $common_multiplier = mt_rand(2, 20);
                $ques_numerator = $numerator * $common_multiplier;
                $ques_denominator = $denominator * $common_multiplier;

                $question = $set_question["str"] . " $ques_numerator/$ques_denominator ";
                $answer_frac = reduceFraction($ques_numerator, $ques_denominator);
                $answer = $answer_frac[0] ."/". $answer_frac[1];

                $response = getOptionArray($answer);
                if($response !== 0) {
                    $options = [];
                    $correctOptionIndex = null;
            
                    foreach ($response as $key => $element) {
                        $options[] = $element['option'];
                        if ($element['isCorrect']) {
                            $correctOptionIndex = $element['option'];
                        }
                    }
            
                } else {
                    $count = 1001;
                }
            }

            // var_dump($options);

            shuffle($options);

            if($count < 100)
            setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
        }
    }
?>