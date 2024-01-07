<?php 
    if($sbtpName == '90'){

        $shapes = array("square", "rectangle");
        $randoShape = rand(0, 1);
        $shape = $shapes[$randoShape];
        $length;
        $breadth;
        $area;
        $perimeter;
        $question;
        $answer;
        $options = [];
        $maxLen = 100;
        $minLen = 3;

        $length = getRandomMultipleOfTen();
        $breadth = $shape == "rectangle" ? 0 : $length;

        $area = ((1 + $length / 100) * (1 + $breadth / 100) - 1) * 100;
        $perimeter = 2 * ($length + $breadth);

        $question_objs = array(
            array(
                'question_str' => 'areaInc',
                'type' => 'text',
                'question' => "If the %%statement%% then how much would its area increase by?",
            ),
            array(
                'question_str' => 'perimeterInc',
                'type' => 'text',
                'question' => "If the %%statement%% then how much would its perimeter increase by?",
            ),
            array(
                'question_str' => 'areaDec',
                'type' => 'text',
                'question' => "If the %%statement%% then how much would its area decrease by?",
            ),
            array(
                'question_str' => 'perimeterDec',
                'type' => 'text',
                'question' => "If the %%statement%% then how much would its perimeter decrease by?",
            ),
        );

        $randoQues = rand(0, count($question_objs) - 1);
        $set_question = $question_objs[$randoQues];

        $elements = array("length", "breadth");
        $randomIndex = rand(0, count($elements) - 1);
        $randomElement = $elements[$randomIndex];

        if ($set_question['question_str'] == "areaInc") {
            $temp_statement = $shape == "rectangle"
                ? "$randomElement of a rectangle is increased by $length%"
                : "side of a square is increased by $length%";

            $question = str_replace("%%statement%%", $temp_statement, $set_question['question']);
            $answer = $area;
        } else if ($set_question['question_str'] == "perimeterInc") {
        if ($shape == "square") {
            $answer = $length;
            $temp_statement = "side of a square is increased by $length%";
            $question = str_replace("%%statement%%", $temp_statement, $set_question['question']);
        } else if ($shape == "rectangle") {
            $answer = $length - 1;
            $temp_statement = "$randomElement of a rectangle is increased by $length%";
            $question = str_replace("%%statement%%", $temp_statement, $set_question['question']);
        }
        } else if ($set_question['question_str'] == "areaDec") {
            $temp_statement = $shape == "rectangle"
                ? "$randomElement of a rectangle is decreased by $length%"
                : "side of a square is decreased by $length%";

            $question = str_replace("%%statement%%", $temp_statement, $set_question['question']);

            $answer = $shape == "square" ? $length + 1 : $length;
        } else if ($set_question['question_str'] == "perimeterDec") {
            $temp_statement = $shape == "rectangle"
            ? "$randomElement of a rectangle is decreased by $length%"
            : "side of a square is decreased by $length%";

            $question = str_replace("%%statement%%", $temp_statement, $set_question['question']);

            $answer = $shape == "square" ? $length : $length - 1;
        }

        $temp_options = array(
            array('option' => "$length%", 'isCorrect' => $length == $answer),
            array('option' => "less than $length%", 'isCorrect' => $answer < $length),
            array(
                'option' => "more than $length% but less than " . (2 * $length) . "%",
                'isCorrect' => $answer > $length && $answer < (2 * $length),
            ),
            array('option' => "more than " . (2 * $length) . "%", 'isCorrect' => $answer > (2 * $length)),
        );

        $temp_options = shuffleArray($temp_options);

        $options = array();
        $correctOptionIndex = null;

        foreach ($temp_options as $index => $option_res) {
            $options[] = $option_res['option'];

            if ($option_res['isCorrect']) {
                $correctOptionIndex = $option_res['option'];
            }
        }

        setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $correctOptionIndex);


    }
?>