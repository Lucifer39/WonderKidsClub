<?php 
    if(in_array($sbtpName, array('148'))){
        $question_str = "Round off the following number to its nearest %%x%% place : <br>";
        $places_array = array(
            array(
                "rounded_to"=> "tens",
                "param"=> 10,
                "replace_rounded_to" => "tenths",
                "replaced_param" => 1
            ),
            array(
                "rounded_to"=> "hundreds",
                "param"=> 100,
                "replace_rounded_to" => "hundredths",
                "replaced_param" => 2
            ),
            array(
                "rounded_to"=> "thousands",
                "param"=> 1000,
                "replace_rounded_to" => "thousandths",
                "replaced_param" => 3
            ),
            array(
                "rounded_to"=> "tenths",
                "param"=> 1,
                "replace_rounded_to" => "tens",
                "replaced_param" => 10
            ),
            array(
                "rounded_to"=> "hundredths",
                "param"=> 2,
                "replace_rounded_to" => "hundreds",
                "replaced_param" => 100
            ),
            array(
                "rounded_to"=> "thousandths",
                "param"=> 3,
                "replace_rounded_to" => "thousands",
                "replaced_param" => 1000
            )
        );

        $max = 1000;
        $min = 10000;
        $decimalPlaces = mt_rand(3, 5);
        $randomNumber = randomFloat($min, $max, $decimalPlaces);

        $randomIndex = array_rand($places_array);
        $set_question = $places_array[$randomIndex];

        $get_num = randomFloat($max, $min, $decimalPlaces);
        $answer;
        $incorrect_array;

        $question = str_replace("%%x%%", $set_question["rounded_to"], $question_str) . " $get_num";
        $options = array();

        if(in_array($set_question["rounded_to"], array("tenths", "hundredths", "thousandths"))){
            $answer = roundDecimalsToNearest($get_num, $set_question["param"]);

            $incorrect_array = array_filter($places_array, function($value) {
                global $set_question;
                return $value["rounded_to"] !== $set_question["rounded_to"] 
                        && $value["rounded_to"] !== $set_question["replace_rounded_to"];
            });

            array_push($options, $answer);
            array_push($options, roundToNearest($get_num, $set_question["replaced_param"]));
        }
        else {
            $answer = roundToNearest($get_num, $set_question["param"]);

            $incorrect_array = array_filter($places_array, function($value) {
                global $set_question;
                return $value["rounded_to"] !== $set_question["rounded_to"] 
                        && $value["rounded_to"] !== $set_question["replace_rounded_to"];
            });

            array_push($options, $answer);
            array_push($options, roundDecimalsToNearest($get_num, $set_question["replaced_param"]));
        }

        $counter;
        $count = 0;
        while($count <= 100 && count($options) < 4){
            $temp_rand = array_rand($incorrect_array);
            $temp_varr = $incorrect_array[$temp_rand];

            $temp_answer;
            if(in_array($temp_varr["rounded_to"], array("tenths", "hundredths", "thousandths"))){
                $temp_answer = roundDecimalsToNearest($get_num, $temp_varr["param"]);
            }
            else{
                $temp_answer = roundToNearest($get_num, $temp_varr["param"]);
            }

            $counter = 0;

            while($counter <= 10 && in_array($temp_answer, $options)){
                $temp_rand = array_rand($incorrect_array);
                $temp_varr = $incorrect_array[$temp_rand];

                if(in_array($temp_varr["rounded_to"], array("tenths", "hundredths", "thousandths"))){
                    $temp_answer = roundDecimalsToNearest($get_num, $temp_varr["param"]);
                }
                else{
                    $temp_answer = roundToNearest($get_num, $temp_varr["param"]);
                }

                $count++;
            }

            if($counter > 10){
                break;
            }

            if(!in_array($temp_answer, $options)){
                array_push($options, $temp_answer);
                $count = 0;
            }

            $count++;
        }

        shuffle($options);

        if($counter < 10 && $count < 100){
            setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
        }
    }
?>