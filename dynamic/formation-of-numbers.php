<?php 
    if(in_array($sbtpName, array('70', '71', '72', '73'))){
        $questionArray = array(
            "smallestNDigitNumber",
            "largestNDigitNumber",
            "smallestNDigitEvenNumberFromDigits",
            "smallestNDigitOddNumberFromDigits",
            "largestNDigitEvenNumberFromDigits",
            "largestNDigitOddNumberFromDigits"
        );

        $min_term = 1000;
        $max_term = 9999;
        $num_digits = 3;

        if($sbtpName == '72'){
            $min_term = 10000;
            $max_term = 99999;
            $num_digits = 4;
        }
        else if($sbtpName == '73'){
            $min_term = 100000;
            $max_term = 999999;
            $num_digits = 5;
        }

        $selected_num = mt_rand($min_term, $max_term);

        $randomIndex = array_rand($questionArray);
        $randomElement = $questionArray[$randomIndex];

        $question_statement = generateQuestionStatement($randomElement);

        // echo $question_statement;

        $digitsArray = str_split((string)$selected_num);

        // Join the array elements with a comma to create a comma-separated string
        $commaSeparatedString = implode(',', $digitsArray);

        $question_statement = str_replace("%%n%%", $num_digits, $question_statement);
        $question_statement = str_replace("%%m%%", $commaSeparatedString, $question_statement);

        $hasQuestion = checkQuestion($question_statement);

        if($hasQuestion == 0){
            $answer = $randomElement($commaSeparatedString, $num_digits);

            if($answer != 0) {
                $options = generateIncorrectOptions($answer);

                if($options !== 0) {
                    setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question_statement, $options[0], $options[1], $options[2], $options[3], $answer);
                }
            }
        }
    }
?>