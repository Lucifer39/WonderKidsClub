<?php 
    if(in_array($sbtpName, array('138', '139', '140', '144', '145'))){
        $question_obj = array(
            array(
                "type" => "addition",
                "str" => "What is the sum of the following fractions? <br>",
            ),
            array(
                "type" => "subtraction",
                "str" => "What is the difference of the following fractions? <br>",
            ),
            array(
                "type" => "multiplication",
                "str" => "What is the product of the following fractions? <br>",
            ),
            array(
                "type" => "division",
                "str" => "What is the division of the following fractions? <br>",
            )
        );

        $fraction_array = array();
        $num_fractions = 2;

        if($sbtpName == '138'){
            $denominator = mt_rand(2, 100);
            for($k = 0; $k < $num_fractions; $k++){
                $numerator = mt_rand(2, $denominator - 1);
                array_push($fraction_array, strval($numerator) . "/" . strval($denominator));
            }
        }

        else{
            for($k = 0; $k < $num_fractions; $k++){
                $denominator = mt_rand(2, 100);
                $numerator = mt_rand(1, $denominator - 1);
                array_push($fraction_array, strval($numerator) . "/" . strval($denominator));
            }
        }


        // $randomIndex = array_rand($question_obj);

        $randomIndex;
        if(in_array($sbtpName, array('138', '139', '140'))){
            $randomIndex = mt_rand(0, 1);
        }
        else if(in_array($sbtpName, array('144', '145'))){
            $randomIndex = mt_rand(2, 3);
        }

        $set_question = $question_obj[$randomIndex];
        $sign;


        if($set_question["type"] == "addition"){
            $answer = addFractions($fraction_array);
            $sign = " + ";
        }
        else if($set_question["type"] == "subtraction"){
            $answer = subtractFractions($fraction_array);
            $sign = " , ";
        }
        else if($set_question["type"] == "multiplication"){
            $answer = multiplyFractions($fraction_array);
            $sign = " × ";
        }
        else if($set_question["type"] == "division") {
            $answer = divideFractions($fraction_array);
            $sign = " ÷ ";
        }

        

        $question = $set_question["str"] . " " .  implode($sign, $fraction_array);

        $response = getOptionArray($answer);

        if($response != 0) {
            $options = [];
            $correctOptionIndex = null;

            foreach ($response as $key => $element) {
                $options[] = $element['option'];
                if ($element['isCorrect']) {
                    $correctOptionIndex = $element['option'];
                }
            }

            $resp = setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
        }
    }
?>