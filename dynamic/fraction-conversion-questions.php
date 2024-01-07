<?php 
    if(in_array($sbtpName, array('149', '150'))){
        $question_obj = array(
            array(
                "function_name" => "improperToMixedFraction",
                "str" => "Convert the given improper fraction into mixed fraction: <br>"
            ),
            array(
                "function_name" => "mixedToImproperFraction",
                "str" => "Convert the given mixed fraction into improper fractions: <br>"
            )
        );
    
        $random_numerator = mt_rand(5, 96);
        $random_whole_number = "";
        $random_denominator;

        $randomIndex = array_rand($question_obj);
        $set_question = $question_obj[$randomIndex];

        if($set_question["function_name"] == "mixedToImproperFraction") {
            $random_denominator = 1;
            do{
                $random_denominator = mt_rand($random_numerator + 1, 98);
            }while($random_numerator % $random_denominator == 0);
            $random_whole_number = mt_rand(1, 99) . "_";
        }
        else { 
            $random_denominator = 1;
            do{
                $random_denominator = mt_rand(2, $random_numerator - 1);
            }while($random_numerator % $random_denominator == 0);
        }

        $fraction = $random_whole_number . $random_numerator . "/" . $random_denominator;

        $answer = call_user_func($set_question["function_name"], $fraction);
        $question = $set_question["str"] . str_replace("_", " ", $fraction);

        $options = array();
        array_push($options, $answer);
        $count = 0;
        $temp_numerator;

        for($k = 0; $k < 3; $k++){
            $temp_answer;

            $count = 0;
            do{
                if($set_question["function_name"] !== "mixedToImproperFraction"){
                    do {
                        $temp_numerator = mt_rand($random_denominator + 1, 100);
                        $temp_fraction = "$temp_numerator/$random_denominator";
                    }while($temp_numerator % $random_denominator == 0);
                    $temp_answer = call_user_func($set_question["function_name"], $temp_fraction);
                }
                else{
                    $temp_numerator = mt_rand($random_denominator + 1, 9999);
                    $temp_answer = "$temp_numerator/$random_denominator";
                }
                $count++;
            }while($count <= 100 && in_array($temp_answer, $options));

            if($count > 100){
                break;
            }

            array_push($options, $temp_answer);
        }


        if($count < 100){
            shuffle($options);
            setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
        }
    }
?>