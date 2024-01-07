<?php 
    if($sbtpName == '87'){
        $shape_array = ["square", "rectangle", "circle"];
        $question_str = [
        ["question" => "What is the area of the shaded region?", "type" => "area"],
        //   ["question" => "What is the perimeter of the shaded region?", "type" => "perimeter"],
        ];

        $randomNum = mt_rand() / mt_getrandmax();
        $randomNum = floor($randomNum * 3);
        $get_shape = $shape_array[$randomNum];
        $max_len = 10;
        $min_len = 3;
        $temp_length = mt_rand($min_len, $max_len);
        $temp_breadth = ($get_shape === "rectangle") ? mt_rand($min_len, $max_len) : $temp_length;

        $total_portion = ($get_shape === "circle") ? $temp_length : $temp_length * $temp_breadth;

        $shaded_portion_1 = mt_rand($min_len, $total_portion - $min_len);

        $shape_info = [
            "shape_type" => $get_shape,
            "shape_length" => $temp_length,
            "shape_breadth" => $temp_breadth,
            "shaded_portion_1" => $shaded_portion_1,
            "shaded_portion_2" => 0,
        ];

        $randomSize = mt_rand(1, 5);

        $randomQues = mt_rand(0, count($question_str) - 1);
        $question = $question_str[$randomQues]['question'] . "Assume each part of area " . $randomSize . " sq. units.";
        $answer = ($question_str[$randomQues]['type'] == "area") ? ($shape_info['shaded_portion_1'] * $randomSize) : 0;

        $shape_info_json = json_encode($shape_info);

        $options = generateIncorrectOptions(strval($answer));

        if($options !== 0){
            setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer, $shape_info_json);
        }

    }
?>