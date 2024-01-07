<?php 
    if(in_array($sbtpName, array('237'))) {
        $question_obj = array(
            array(
                "type" => "protractor",
                "str" => "What is the angle measured by the protractor?"
            ),
            array(
                "type" => "determine",
                "str" => "What kind of angle is shown in the figure?"
            ),
            array(
                "type" => "clock_determine",
                "str" => "What angle is shown in the face of the clock?"
            )
        );

        shuffle($question_obj);
        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;
            
            $set_question = $question_obj[$quest_loop];
            $question = $set_question["str"];
            $answer;
            $shape_info = array();
            $options = array();
            $count = 0;

            if($set_question["type"] == "protractor") {
                $answer = mt_rand(0, 180) . "°";
                $shape_info["type"] = "protractor";
                $options[] = $answer;

                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect = mt_rand(0, 180) . "°";

                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count ++;
                }
            } else if($set_question["type"] == "determine") {
                $answer_temp = mt_rand(0, 180);
                $shape_info["type"] = "determine";
                $shape_info["angle"] = $answer_temp;
                $options_temp = array(
                    array("str" => "Right Angle", "isCorrect" => $answer_temp == 90),
                    array("str" => "Acute Angle", "isCorrect" => $answer_temp < 90),
                    array("str" => "Obtuse Angle", "isCorrect" => $answer_temp > 90),
                    array("str" => "Cannot be determined", "isCorrect" => false)
                );

                foreach($options_temp as $option) {
                    $options[] = $option["str"];

                    if($option["isCorrect"]) {
                        $answer = $option["str"];
                    }
                }
            } else if($set_question["type"] == "clock_determine") {
                $hours = mt_rand(1, 12);
                $minutes = mt_rand(0, 59);

                $shape_info["type"] = "clock";
                $shape_info["hours"] = $hours;
                $shape_info["minutes"] = $minutes;

                $angleFormed = getAngleBetweenClockHands($hours, $minutes);

                $options_temp = array(
                    array(
                        "str" => "Acute Angle",
                        "isCorrect" => $angleFormed < 90 && $angleFormed >= 0,
                    ),
                    array(
                        "str" => "Obtuse Angle",
                        "isCorrect" => $angleFormed > 90 && $angleFormed < 180,
                    ),
                    array(
                        "str" => "Straight Angle",
                        "isCorrect" => $angleFormed == 180,
                    ),
                    array(
                        "str" => "Reflex Angle",
                        "isCorrect" => $angleFormed > 180 && $angle <= 359,
                    ),
                );

                foreach($options_temp as $option) {
                    $options[] = $option["str"];

                    if($option["isCorrect"]) {
                        $answer = $option["str"];
                    }
                }
            }

            if($count < 100) {
                $shape_info_json = json_encode($shape_info);
                shuffle($options);
                setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer, $shape_info_json);
            }
        }
    }
?>