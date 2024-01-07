<?php 
    if(in_array($sbtpName, array('75'))){
        $question_str = "What is the time shown on the clock?";

        $random_hour = mt_rand(1, 12);
        $random_minute = mt_rand(0, 59);

        $formattedMinute = str_pad($random_minute, 2, "0", STR_PAD_LEFT);

        $random_time = $random_hour . ":" . $formattedMinute;

        $response = generateIncorrectOptionsTime($random_time);

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

            // $hour = explode(":", $time)[0];
            // $minute = explode(":", $time)[1];

            $shape_info = array(
                "type" => "clock",
                "hour" => $random_hour,
                "minute" => $random_minute,
            );

            $shape_info_json = json_encode($shape_info);
            // print_r($shape_info_json);

            $response_question = setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question_str, $options[0], $options[1], $options[2], $options[3], $correctOptionIndex, $shape_info_json);
            print_r($response_question);
        }
    }
?>