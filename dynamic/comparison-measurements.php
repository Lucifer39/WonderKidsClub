<?php 
    if(in_array($sbtpName, array('181', '182', '183', '184', '260'))) {
        $question_obj = array(
            array(
                "type" => "two_rulers",
                "str" => "The given figure shows two rods. What is the difference in length in both the rods?"
            ),
            array(
                "type" => "one_sided_weight",
                "str" => "What is the weight of the given object?"
            ),
            array(
                "type" => "two_sided_weight",
                "str" => "What is the weight of the given object?"
            ),
            array(
                "type" => "one_sided_weight_tilted",
                "str" => "Which of the following option is appropriate to define the unknown weight?"
            ),
            array(
                "type" => "two_sided_weight_tilted",
                "str" => "Which of the following option is appropriate to define the unknown weight?"
            )
        );

        shuffle($question_obj);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;

            $set_question = $question_obj[$quest_loop];
            if($sbtpName == '181' || $sbtpName == '260') {
                $question_obj_temp = array( 
                                array(
                                    "type" => "two_rulers",
                                    "str" => "The given figure shows two rods. What is the difference in length in both the rods?"
                                ),
                                array(
                                    "type" => "one_sided_weight",
                                    "str" => "What is the weight of the given object?"
                                )
                            );
                $set_question = $question_obj_temp[$quest_loop % 2];
            }


            $question;
            $answer;
            $count = 0;
            $options = array();

            $shape_info = array();

            if($set_question["type"] == "two_rulers") {
                $rod_1 = mt_rand(10, 100) / 10;
                $rod_2 = mt_rand(10, 100) / 10;

                if($sbtpName == '260' || $sbtpName == '181') {
                    $rod_1 = mt_rand(1, 9);
                    $rod_2 = mt_rand(1, 9);
                }

                $shape_info["type"] = "two_rulers";
                $shape_info["length_1"] = $rod_1;
                $shape_info["length_2"] = $rod_2;

                $answer = abs($rod_1 - $rod_2);
                $question = $set_question["str"];

                array_push($options, $answer . " cms");
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect_temp = mt_rand(0, 9) / 10;

                    if($sbtpName == '260' || $sbtpName == '181') {
                        $incorrect_temp = mt_rand(1,9);
                    }
                    $incorrect = ((mt_rand(0, 1) == 1) ? $answer + $incorrect_temp : abs($answer - $incorrect_temp)) . " cms";

                    if(!in_array($incorrect, $options)) {
                        array_push($options, $incorrect);
                        $count = 0;
                    }

                    $count++;
                }

                $answer .= " cms";
            }
            else if($set_question["type"] == "one_sided_weight") {
                $answer = mt_rand(10, 100);

                $numDivisions = rand(1, 3);

                if($sbtpName == '260' || $sbtpName == '181') {
                    $numDivisions = rand(1, 2);
                }
        
                // Generate random values for each division
                $divisions = array();
                $k = 0;
                $sum = 0;
                for ($k = 0; $k < $numDivisions - 1; $k++) {
                    if($k > 0 && ($sbtpName == '260' || $sbtpName == '181')) {
                        $rando_num = numberWithoutCarry($rando_num);
                    } else {
                        $rando_num = mt_rand(1, intval($answer / 2));
                    }
                    $divisions[$k]["text"] = $rando_num . " kgs";
                    $sum += $rando_num;
                }
                
                // Adjust the last division to ensure the sum is equal to the original number
                $divisions[$k]["text"] = ($answer - $sum) . " kgs";

                $shape_info["type"] = "one_sided_weight";
                $shape_info["weights_right"] = array(array("text" => "?"));
                $shape_info["weights_left"] = $divisions;
                
                $question = $set_question["str"];
                array_push($options, $answer . " kgs");

                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect_temp = mt_rand(1, 5);
                    $incorrect = ((mt_rand(0, 1) == 1) ? $answer + $incorrect_temp : abs($answer - $incorrect_temp)) . " kgs";

                    if(!in_array($incorrect, $options)) {
                        array_push($options, $incorrect);
                        $count = 0;
                    }

                    $count++;
                }

                $answer .= " kgs";
            }
            else if($set_question["type"] == "two_sided_weight") {
                $number = mt_rand(10, 100);

                $numDivisions = rand(1, 3);
        
                // Generate random values for each division
                $divisions = array();
                $k = 0;
                $sum = 0;
                for ($k = 0; $k < $numDivisions - 1; $k++) {
                    $rando_num = mt_rand(1, intval($number / 2));
                    $divisions[$k]["text"] = $rando_num . " kgs";
                    $sum += $rando_num;
                }
                
                // Adjust the last division to ensure the sum is equal to the original number
                $divisions[$k]["text"] = ($number - $sum) . " kgs";

                $numDivisionsRight = mt_rand(1, 2);
                $k = 0;
                $divisionsRight = array();
                $sum = 0;
                for ($k = 0; $k < $numDivisionsRight - 1; $k++) {
                    $rando_num = mt_rand(1, intval($number / 2));
                    $divisionsRight[$k]["text"] = $rando_num . " kgs";
                    $sum += $rando_num;
                }
                array_push($divisionsRight, array("text" => "?"));

                $answer = $number - $sum;

                $shape_info["type"] = "two_sided_weight";
                $shape_info["weights_right"] = $divisionsRight;
                $shape_info["weights_left"] = $divisions;
                
                $question = $set_question["str"];
                array_push($options, $answer . " kgs");

                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect_temp = mt_rand(1, 5);
                    $incorrect = ((mt_rand(0, 1) == 1) ? $answer + $incorrect_temp : abs($answer - $incorrect_temp)) . " kgs";

                    if(!in_array($incorrect, $options)) {
                        array_push($options, $incorrect);
                        $count = 0;
                    }

                    $count++;
                }

                $answer .= " kgs";
            }
            else if($set_question["type"] == "one_sided_weight_tilted") {
                $number = mt_rand(50, 100);

                $weights = array();
                $numWeights = mt_rand(1, 3);

                $sum_weights = 0;
                for($k = 0; $k < $numWeights; $k++) {
                    $weight = mt_rand(5, intval($number));
                    array_push(
                        $weights,
                        array(
                            "text" => strval($weight) . " kgs",
                            "weight" => $weight
                        )
                    );
                    $sum_weights += $weight;
                }

                $options_temp = array(
                    array(
                        "term" => "More than $sum_weights kgs",
                        "isCorrect" => $number > $sum_weights
                    ),
                    array(
                        "term" => "Less than $sum_weights kgs",
                        "isCorrect" => $number < $sum_weights
                    ),
                    array(
                        "term" => "Equal to $sum_weights kgs",
                        "isCorrect" => $number == $sum_weights,
                    ),
                    array(
                        "term" => "cannot be determined",
                        "isCorrect" => false
                    )
                );

                foreach($options_temp as $option) {
                    array_push($options, $option["term"]);

                    if($option["isCorrect"]) {
                        $answer = $option["term"];
                    }
                }

                $shape_info["type"] = "one_sided_weight_tilted";
                $shape_info["weights_right"] = $weights;
                $shape_info["weights_left"] = array(array("text" => "?", "weight" => $number));

                $question = $set_question["str"];

            }

            else if($set_question["type"] == "two_sided_weight_tilted") {
                $number = mt_rand(20, 100);

                $weights_left = array();
                $numWeights_left = mt_rand(1, 3);

                $sum_weights_left = 0;
                for($k = 0; $k < $numWeights_left; $k++) {
                    $weight = mt_rand(intval($number / 3), intval($number));
                    array_push(
                        $weights_left,
                        array(
                            "text" => strval($weight) . " kgs",
                            "weight" => $weight
                        )
                    );
                    $sum_weights_left += $weight;
                }

                $weights_right = array();
                $numWeights_right = mt_rand(1, 2);

                array_push($weights_right, array(
                    "text" => "?",
                    "weight" => $number
                ));

                $sum_weights_right = $number;

                for($k = 0; $k < $numWeights_right; $k++) {
                    $weight = mt_rand(5, intval($number / 3));
                    array_push(
                        $weights_right,
                        array(
                            "text" => strval($weight) . " kgs",
                            "weight" => $weight
                        )
                    );
                    $sum_weights_right += $weight;
                }

                $sum_check = $sum_weights_right - $number;
                $sum_check = abs($sum_check - $sum_weights_left);

                $options_temp = array(
                    array(
                        "term" => "More than $sum_check kgs",
                        "isCorrect" => $number > $sum_check
                    ),
                    array(
                        "term" => "Less than $sum_check kgs",
                        "isCorrect" => $number < $sum_check
                    ),
                    array(
                        "term" => "Equal to $sum_check kgs",
                        "isCorrect" => $number == $sum_check,
                    ),
                    array(
                        "term" => "cannot be determined",
                        "isCorrect" => false
                    )
                );

                foreach($options_temp as $option) {
                    array_push($options, $option["term"]);

                    if($option["isCorrect"]) {
                        $answer = $option["term"];
                    }
                }

                $shape_info["type"] = "two_sided_weight_tilted";
                $shape_info["weights_right"] = $weights_left;
                $shape_info["weights_left"] = $weights_right;

                $question = $set_question["str"];
            }

            if($count <= 100) {
                shuffle($options);
                $shape_info_json = json_encode($shape_info);

                setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer, $shape_info_json);
            }
        }
    }
?>