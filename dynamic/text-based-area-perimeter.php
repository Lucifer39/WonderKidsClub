<?php

    if($sbtpName == '85' || $sbtpName == '89'){
        $question_objs = [
            [
                "question_str" => "findArea",
                "type" => "text",
                "question" => "Find the area of ",
            ],
            [
                "question_str" => "findPerimeter",
                "type" => "text",
                "question" => "Find the perimeter of ",
            ],
            [
                "question_str" => "findLengthFromArea",
                "type" => "text",
                "question" => "Find the length of ",
            ],
            [
                "question_str" => "findLengthFromPerimeter",
                "type" => "text",
                "question" => "Find the length of ",
            ],
        ];

        shuffle($question_objs);

        for($quest_loop = 0; $quest_loop < count($question_objs); $quest_loop++) {
            $i++;

            $set_question = $question_objs[$quest_loop];

            $shapes = ["square", "rectangle"];
            $randoShape = mt_rand(0, 1);
            $shape = $shapes[$randoShape];

            $maxLen = 100;
            $minLen = 3;

            $length = mt_rand($minLen, $maxLen);
            if ($shape == "rectangle") {
                $breadth = mt_rand($minLen, $maxLen);
            } else {
                $breadth = $length;
            }

            $area = $length * $breadth;
            $perimeter = 2 * ($length + $breadth);

            $answer;
            $question;

            if ($set_question["question_str"] == "findArea") {
                $answer = $area;
                $question =
                $set_question["question"] .
                "a $shape of " .
                ($shape == "square" ? "side of length $length units " : "length of $length units and breadth of $breadth units");
            } else if ($set_question["question_str"] == "findPerimeter") {
                $answer = $perimeter;
                $question =
                $set_question["question"] .
                "a $shape of " .
                ($shape == "square" ? "side of length $length units " : "length of $length units and breadth of $breadth units");
            } else if ($set_question["question_str"] == "findLengthFromArea") {
                $answer = $length;
                $question =
                $set_question["question"] .
                "a $shape of area $area sq. units" .
                ($shape == "rectangle" ? " and breadth of $breadth units." : ".");
            } else if ($set_question["question_str"] == "findLengthFromPerimeter") {
                $answer = $length;
                $question =
                $set_question["question"] .
                "a $shape of perimeter $perimeter units" .
                ($shape == "rectangle" ? " and breadth of $breadth units." : ".");
            }

            // print_r($answer)

            $check_question = checkQuestion($question);
            // var_dump($check_question);

                $options = generateIncorrectOptions(strval($answer));
        
                if($options !== 0)
                $respons_set = setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
        }
    }
?>
