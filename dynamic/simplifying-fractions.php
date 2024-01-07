<?php 
    if(in_array($sbtpName, array('141', '142'))){
        $question_str = array("Simplify the fraction: ", "Which of the following is the same as: ");

        $common_multiplier = mt_rand(2, 20);
        $denominator = mt_rand(2, 25);
        $numerator = mt_rand(1, $denominator - 1);

        $ques_numerator = $numerator * $common_multiplier;
        $ques_denominator = $denominator * $common_multiplier;

        $question = $question_str[mt_rand(0, 1)] . " $ques_numerator/$ques_denominator ";
        $answer_frac = reduceFraction($ques_numerator, $ques_denominator);
        $answer = $answer_frac[0] ."/". $answer_frac[1];

        $resp_question = checkQuestion($question);
        if($resp_question == 0) {
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
        
                setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
            }
        }
    }
?>