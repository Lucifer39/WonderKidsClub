<?php 
    if(in_array($sbtpName, array('180'))) {
        $question_obj = array(
            array(
                "type" => "thermometer_celcius",
                "str" => "What is the temperature shown in the thermometer in °C?"
            ),
            array(
                "type" => "thermometer_farenheit",
                "str" => "What is the temperature shown in the thermometer in °F?"
            )
            // array(
            //     "type" => "CToF",
            //     "str" => "What would be the temperature shown in °F ?"
            // )
        );

        $set_question = $question_obj[mt_rand(0, count($question_obj) - 1)];

        $answer;
        $options = array();
        $question;
        $count = 0;

        $subdivision_array = [2, 5, 10];
        $randomSubDiv = $subdivision_array[array_rand($subdivision_array)];

        $shape_info = array(
            "type" => "thermometer",
            "temp" => 0,
            "unit" => "C",
            "sub_division" => $randomSubDiv
        );

        // if($set_question["type"] == "thermometer") {
            $answer = mt_rand(10, 1000);
            $question = $set_question["str"];
            $shape_info["temp"] = $answer;

            if($set_question["type"] == "thermometer_farenheit") {
                $shape_info["unit"] = "F";
            }

            $answer = $answer . "°" . $shape_info["unit"];
            array_push($options, $answer);
            $count = 0;
            while($count <= 100 && count($options) < 4) {
                $incorrect_temp = mt_rand(1, 5);
                $incorrect = (mt_rand(0, 1) == 1 ? $answer + $incorrect_temp : abs($answer - $incorrect_temp)) . "°" . $shape_info["unit"];

                if(!in_array($incorrect, $options)) {
                    array_push($options, $incorrect);
                    $count = 0;
                }

                $count++;
            }
        // }
        // else if($set_question["type"] == "CToF") {
        //     $answer_temp = mt_rand(10, 100);
        //     $question = $set_question["str"];
        //     $shape_info["temp"] = $answer_temp;

        //     $answer = celsiusToFahrenheit($answer_temp);

        //     array_push($options, $answer);
        //     $count = 0;
        //     while($count <= 100 && count($options) < 4) {
        //         $incorrect_temp = mt_rand(1, 5);
        //         $incorrect = mt_rand(0, 1) == 1 ? $answer + $incorrect_temp : $answer - $incorrect_temp;

        //         if(!in_array($incorrect, $options)) {
        //             array_push($options, $incorrect);
        //             $count = 0;
        //         }

        //         $count++;
        //     }
        // }

        if($count <= 100) {
            shuffle($options);
            $shape_info_json = json_encode($shape_info);

            setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer, $shape_info_json);
        }
    }
?>