<?php 
    if(in_array($sbtpName, array('84', '86'))){
        $shape_array = ["square", "rectangle", "circle"];
        $question_objs = [
            ["question" => "What is the proportion of shaded region?", "type" => "level1", "process" => "red-total"],
            ["question" => "What is the proportion of the blue region to the total (red + blue + unshaded) region?", "type" => "level2", "process" => "blue-total"],
            ["question" => "What is the proportion of the blue region to the red region?", "type" => "level2", "process" => "blue-red"],
            ["question" => "What is the proportion of the blue region to the total shaded region?", "type" => "level2", "process" => "blue-shaded"]
        ];

        shuffle($question_objs);

        for($quest_loop = 0; $quest_loop < count($question_objs); $quest_loop++) {
            $i++;

            $get_question = $question_objs[$quest_loop];
            // Generate random index to select shape from $shape_array
            $randomShapeIndex = rand(0, count($shape_array) - 1);
            $get_shape = $shape_array[$randomShapeIndex];



            $max_len = 10;
            $min_len = 5;

            $temp_length = rand($min_len, $max_len);
            $temp_breadth = ($get_shape === "rectangle") ? rand($min_len, $max_len) : $temp_length;

            $total_portion = ($get_shape === "circle") ? $temp_length : ($temp_length * $temp_breadth);

            $shaded_portion_1 = rand($min_len, intval($total_portion / 2));

            $shaded_portion_2 = 0;
            if ($get_question["type"] === "level2") {
                $remaining = $total_portion - $shaded_portion_1;
                do{
                    $shaded_portion_2 = $remaining > 0 ? rand(1, intval($remaining / 2)) : 0;
                }while($shaded_portion_2 == $shaded_portion_1);
            }

            $shape_info = [
                "shape_type" => $get_shape,
                "shape_length" => $temp_length,
                "shape_breadth" => $temp_breadth,
                "shaded_portion_1" => $shaded_portion_1,
                "shaded_portion_2" => $shaded_portion_2,
            ];

            $question_str = $get_question["question"];
            $flag_level1 = false;
            $answer = "";

            if ($get_question["type"] === "level1") {
                $answer = $shape_info["shaded_portion_1"] . "/" . $total_portion;
                $flag_level1 = true;
            } else if ($get_question["type"] === "level2") {
                if ($get_question["process"] === "blue-red") {
                    $answer = $shape_info["shaded_portion_2"] . "/" . $shape_info["shaded_portion_1"];
                } else if($get_question["process"] === "blue-total") {
                    $answer = $shape_info["shaded_portion_2"] . "/" . $total_portion;
                } else if($get_question["process"] === "blue-shaded") {
                    $answer = $shape_info["shaded_portion_2"] . "/" . ($shape_info["shaded_portion_1"] + $shape_info["shaded_portion_2"]);
                }

                $flag_level1 = false;

                $options = array(
                        $shape_info["shaded_portion_1"] . "/" . $total_portion, 
                        $shape_info["shaded_portion_2"] . "/" . $shape_info["shaded_portion_1"],
                        $shape_info["shaded_portion_2"] . "/" . $total_portion,
                        $shape_info["shaded_portion_2"] . "/" . ($shape_info["shaded_portion_1"] + $shape_info["shaded_portion_2"])
                    );
            }

            $shape_info_json = json_encode($shape_info);

            // $answer = $shaded_portion_1 . "/" . $total_portion;

            $response = array();
            if($flag_level1)
            $response = getOptionArray($answer);

            if($response != 0) {
                if($flag_level1) {
                    $options = [];
                    $correctOptionIndex = null;

                    foreach ($response as $key => $element) {
                        $options[] = $element['option'];
                        if ($element['isCorrect']) {
                            $correctOptionIndex = $element['option'];
                        }
                    }
                }

                shuffle($options);

                setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question_str, $options[0], $options[1], $options[2], $options[3], $answer, $shape_info_json);
            }
        }
    }
?>