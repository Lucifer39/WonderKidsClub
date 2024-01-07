<?php 
    if(in_array($sbtpName, array('83'))){
        $shape_array = array("square", "rectangle", "circle");
        $question_str = "What is the proportion of shaded region?";

        $randomIndex = array_rand($shape_array);
        $get_shape = $shape_array[$randomIndex];

        $max_len = 10;
        $min_len = 3;
        $temp_length = rand(3, 12); // rand() generates a random integer between 3 and 12 (inclusive)

        if ($get_shape === "rectangle") {
            $temp_breadth = rand(3, 12); // Random breadth between 3 and 12 (inclusive) for rectangles
        } else {
            $temp_breadth = $temp_length; // For circles, breadth is set to the same as length
        }

        if ($get_shape === "circle") {
            $total_portion = $temp_length; // For circles, total portion is equal to the length
        } else {
            $total_portion = $temp_length * $temp_breadth; // For rectangles, total portion is length * breadth
        }

        $shaded_portion_1 = rand($min_len, $total_portion); // Random shaded portion between min_len and total_portion

        $shape_info = array(
            "shape_type" => $get_shape,
            "shape_length" => $temp_length,
            "shape_breadth" => $temp_breadth,
            "shaded_portion_1" => $shaded_portion_1,
            "shaded_portion_2" => 0,
        );

        $shape_info_json = json_encode($shape_info);

        $answer = $shaded_portion_1 . "/" . $total_portion;

        $response = getOptionArray($answer);

        if($response !== 0) {
            $options = [];
            $correctOptionIndex = null;

            foreach ($response as $key => $element) {
                $options[] = $element['option'];
                if ($element['isCorrect']) {
                    $correctOptionIndex = $element['option'];
                }
            }

            setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question_str, $options[0], $options[1], $options[2], $options[3], $correctOptionIndex, $shape_info_json);
        }
    }
?>