<?php 
    if(in_array($sbtpName, array('127', '128', '129', '130', '258'))){
        $conversionArray = array(
            array(
                "function_name" => "kmToMeters",
                "str" => "%%x%% kms = ?",
                "type" => "length",
                "direction" => "lower_to_higher"
            ),
            array(
                "function_name" => "metersToKm",
                "str" => "%%x%% m = ?",
                "type" => "length",
                "direction" => "higher_to_lower"
            ),
            array(
                "function_name" => "kgToGrams",
                "str" => "%%x%% kgs = ?",
                "type" => "weight",
                "direction" => "lower_to_higher"
            ),
            array(
                "function_name" => "gramsToKg",
                "str" => "%%x%% grams = ?",
                "type" => "weight",
                "direction" => "higher_to_lower"
            ),
            array(
                "function_name" => "litersToMilliliters",
                "str" => "%%x%% liters = ?",
                "type" => "volume",
                "direction" => "lower_to_higher"
            ),
            array(
                "function_name" => "millilitersToLiters",
                "str" => "%%x%% milliliters = ?",
                "type" => "volume",
                "direction" => "higher_to_lower"
            ),
            array(
                "function_name" => "hoursToMinutes",
                "str" => "%%x%% hours = ?",
                "type" => "time",
                "direction" => "lower_to_higher"
            ),
            array(
                "function_name" => "minutesToHours",
                "str" => "%%x%% minutes = ?",
                "type" => "time",
                "direction" => "higher_to_lower"
            ),
            // Add more conversion entries here...
        );


        
        
        $randomIndex = array_rand($conversionArray);
        $selectedConversion = $conversionArray[$randomIndex];
          // Generate a random number
        $randomNumber = mt_rand(10, 100); // Modify range as needed

        if($sbtpName == '127' || $sbtpName == '258'){
            if($selectedConversion["type"] == "time" && $selectedConversion["direction"] == "higher_to_lower"){
                $randomNumber = mt_rand(1, 9) * 60;
            }
            else if($selectedConversion["type"] !== "time" && $selectedConversion["direction"] == "higher_to_lower") {
                $randomNumber = mt_rand(1, 9) * 1000;
            }
        }

        else if($sbtpName == '128'){
            if($selectedConversion["type"] == "time" && $selectedConversion["direction"] == "higher_to_lower"){
                $randomNumber = mt_rand(1, 99) * 60;
            }
            else if($selectedConversion["type"] !== "time" && $selectedConversion["direction"] == "higher_to_lower") {
                $randomNumber = mt_rand(1, 99) * 1000;
            }
        }

        else {
            if($selectedConversion["type"] == "time" && $selectedConversion["direction"] == "higher_to_lower"){
                $randomNumber = mt_rand(101, 999) * 60;
            }
            else if($selectedConversion["type"] !== "time" && $selectedConversion["direction"] == "higher_to_lower") {
                $randomNumber = mt_rand(1001, 9999);
            }
        }

      

        // Call the corresponding function based on the chosen element
        $answer = call_user_func($selectedConversion['function_name'], $randomNumber);
        var_dump($answer);

        // Replace the placeholder with the random number and the calculated result
        $question = str_replace("%%x%%", $randomNumber, $selectedConversion['str']);
        // $strWithResult = str_replace("___________", $result, $strWithRandomNumber);

        $resp_check = checkQuestion($question);

        if($resp_check == 0){

            $options = array($answer);
            $count = 0;

            while($count <= 100 && count($options) < 4){
                $temp = mt_rand(0, 1) == 1 ? $randomNumber + (mt_rand(2, 5) * 10) : abs($randomNumber - (mt_rand(2, 5) * 10));
                $temp_answer = call_user_func($selectedConversion['function_name'], $temp);

                if(!in_array($temp_answer, $options)) {
                    $count++;
                    array_push($options, $temp_answer);
                }

                $count++;
            }

            if($count <= 100) {
                shuffle($options);

                // var_dump($options);

                setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
            }
        }
        
    }
?>