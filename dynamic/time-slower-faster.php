<?php 
    if(in_array($sbtpName, array('76', '77'))) {
        $question_obj = array(
            array(
                "type" => "before",
                "str" => "What is the time now if the clock is %%minutes%% minute(s) faster?"
            ),
            array(
                "type" => "after",
                "str" => "What is the time now if the clock is %%minutes%% minute(s) slower?"
            )
        );   
        
        if($sbtpName == '77'){
            $question_obj = array(
                array(
                    "type" => "before",
                    "str" => "What was the time before %%minutes%% minute(s)?",
                ),
                array(
                    "type" => "after",
                    "str" => "What will be the time after %%minutes%% minute(s)?",
                )
            );            
        }


        $randomIndex = array_rand($question_obj);
        $randomQuestion = $question_obj[$randomIndex];

        $randomMinutes = getRandomMinute();
        $getTime = getRandomHour() . ":" . getRandomMinute();

        $answer;
        $question;

        if($randomQuestion["type"] == "before"){
            $answer = getTimeBeforeMinutes($getTime, $randomMinutes);
            $question = str_replace("%%minutes%%", $randomMinutes . "", $randomQuestion["str"]);
        }
        else if($randomQuestion["type"] == "after"){
            $answer = getTimeAfterMinutes($getTime, $randomMinutes);
            $question = str_replace("%%minutes%%", $randomMinutes . "", $randomQuestion["str"]);
        }

        list($hour, $minute) = explode(":", $getTime);

        // Convert hour and minute to string (optional, but can be done for consistency)
        $hour = strval($hour);
        $minute = strval($minute);

        // Create the shape_info array
        $shape_info = array(
            "type" => "clock",
            "hour" => $hour,
            "minute" => $minute
        );

        $shape_info_json = json_encode($shape_info);

        $check_res = checkQuestionTime($question, $shape_info["hour"], $shape_info["minute"]);

        if($check_res == 0) {

            $response = generateIncorrectOptionsTime($answer);

            if($response !== 0) {

                // $response = json_decode($data, true);
                $options = [];
                $correctOptionIndex = null;

                foreach ($response as $key => $element) {
                    $options[] = $element['option'];
                    if ($element['isCorrect']) {
                        $correctOptionIndex = $element['option'];
                    }
                }

                setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $correctOptionIndex, $shape_info_json);
            }
        }
    }
?>