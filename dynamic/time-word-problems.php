<?php 
    if(in_array($sbtpName, array('122', '123', '124', '125'))){
        $question_obj = [
            [
                'type' => 'startingTime',
                'str' => 'A car takes %%hours%% hours and %%minutes%% minutes to reach a target, but because of road condition it took %%wastage_minutes%% min %%wastage_condition%%. If the car started at %%time%%, when will it reach the destination?',
            ],
            [
                'type' => 'reachingTime',
                'str' => 'A car takes %%hours%% hours and %%minutes%% minutes to reach a target, but because of road condition it took %%wastage_minutes%% min %%wastage_condition%%. If car reaches at %%time%% when did it start?',
            ],
            [
                'type' => 'reachingTimeSimple',
                'str' => 'A car takes %%hours%% hours and %%minutes%% minutes to reach a target. If car reaches at %%time%%, when did it start?',
            ],
            [
                'type' => 'startingTimeSimple',
                'str' => 'A car takes %%hours%% hours and %%minutes%% minutes to reach a target. If the car started at %%time%%, when will it reach the destination?',
            ],
        ];
        
        $wastage_condition = ['more', 'less'];
        $time_suffix = ['AM', 'PM'];

        $getHours = getRandomHour();
        $getMinutes = getRandomMinute();
        $wastageMinutes = getRandomMinute();
        $randomMinutes = getRandomMinute();
        $set_question = $question_obj[rand(0, count($question_obj) - 1)];

        if(in_array($sbtpName, array('122', '123'))){
            $getMinutes = getRandomMultipleOf15();
            $wastageMinutes = getRandomMultipleOf15();
            $randomMinutes = getRandomMultipleOf15();
            $set_question = $question_obj[mt_rand(2, 3)];
        }
        else if($sbtpName == '124') {
            $getMinutes = getRandomMultipleOf5();
            $wastageMinutes = getRandomMultipleOf5();
            $randomMinutes = getRandomMultipleOf5();
            $set_question = $question_obj[mt_rand(0, 1)];
        }

        $getTime = getRandomHour() . ":" . str_pad($randomMinutes, 2, "0", STR_PAD_LEFT) . " " . $time_suffix[rand(0, 1)];

        $wastage_random = $wastage_condition[rand(0, count($wastage_condition) - 1)];

        // Replace placeholders in the question string
        $question = str_replace("%%hours%%", $getHours, $set_question['str']);
        $question = str_replace("%%minutes%%", $getMinutes, $question);
        $question = str_replace("%%wastage_minutes%%", $wastageMinutes, $question);
        $question = str_replace("%%wastage_condition%%", $wastage_random, $question);
        $question = str_replace("%%time%%", $getTime, $question);

        // Calculate and store the answer
        if ($set_question['type'] == "startingTime") {
            if ($wastage_random == "more") {
                $wastageMinutes += $getHours * 60 + $getMinutes;
                $answer = addMinutesToTime($getTime, $wastageMinutes);
            } else if ($wastage_random == "less") {
                $wastageMinutes = abs($wastageMinutes - ($getHours * 60 + $getMinutes));
                $answer = addMinutesToTime($getTime, $wastageMinutes);
            }
        } else if ($set_question['type'] == "reachingTime") {
            if ($wastage_random == "more") {
                $wastageMinutes += $getHours * 60 + $getMinutes;
                $answer = subtractMinutesFromTime($getTime, $wastageMinutes);
            } else if ($wastage_random == "less") {
                $wastageMinutes = abs($wastageMinutes - ($getHours * 60 + $getMinutes));
                $answer = subtractMinutesFromTime($getTime, $wastageMinutes);
            }
        } else if ($set_question['type'] == "startingTimeSimple") {
            $wastageMinutes = $getHours * 60 + $getMinutes;
            $answer = addMinutesToTime($getTime, $wastageMinutes);
        } else if ($set_question['type'] == "reachingTimeSimple") {
            $wastageMinutes = $getHours * 60 + $getMinutes;
            $answer = subtractMinutesFromTime($getTime, $wastageMinutes);
        }

        $resp_check = checkQuestion($question);

        if($resp_check == 0) {
            $response = generateIncorrectOptionsWithSuffix($answer);

            if($response !== 0) {
                $options = array();
                $correctOptionIndex = null;

                // Loop through the $response array and build the options array and find the correct option index
                foreach ($response as $index => $element) {
                    $options[] = $element['option'];

                    if ($element['isCorrect']) {
                        $correctOptionIndex = $element['option'];
                    }
                }

                setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $correctOptionIndex);
        
            }

        }
    }
?>