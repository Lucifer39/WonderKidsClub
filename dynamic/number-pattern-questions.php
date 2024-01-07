<?php 
    if(in_array($sbtpName, array('209', '210', '211', '212', '213'))) {
        $question_obj = array(
            array(
                "type" => "number_pattern",
                "str" => "What should be next term of the given series? "
            ),
            array(
                "type" => "number_pattern_decreasing",
                "str" => "What should be next term of the given series? "
            ),
            array(
                "type" => "ap_series",
                "str" => "What should be next term of the given series? ",
            ),
            // array(
            //     "type" => "gp_series",
            //     "str" => "What should be the next term of the given series? gp"
            // ),
            // array(
            //     "type" => "complex",
            //     "str" => "What should be the next term of the given series? complex"
            // )
        );

        $answer;
        $question;
        $options = array();
        $count = 0;
        $set_question = $question_obj[array_rand($question_obj)];

        if($sbtpName == '209') {
            $set_question = $question_obj[mt_rand(0, 1)];
        }

        if($set_question["type"] == "number_pattern") {
            $progression = 1;
            $starting_number = mt_rand(15, 100);

            if($sbtpName == '209') {
                $starting_number = mt_rand(1, 9) * mt_rand(1, 5);
                $arr = array(2, 3, 4, 5, 10);
                $progression = $arr[array_rand($arr)];
            }
            else if($sbtpName == '210') {
                $progression = mt_rand(2, 9);
            }
            else if($sbtpName == '211') {
                $starting_number = mt_rand(60, 100);
                $progression = mt_rand(1, 10);
            }
            else {
                $progression = mt_rand(1, 15);
            }

            $sequence = array();

            for($k = 1; $k <= 6; $k++) {
                $sequence[] = $starting_number;
                $starting_number += $progression;
            }

            $answer = $starting_number;
            $question = $set_question["str"] . " " . implode(", ", $sequence);

            $options[] = $answer;
            $count = 0;
            while($count <= 100 && count($options) < 4){
                $incorrect = mt_rand(0, 1) ? $answer + mt_rand(1, 5) : $answer - mt_rand(1, 5);

                if(!in_array($incorrect, $options)) {
                    $options[] = $incorrect;
                    $count = 0;
                }

                $count++;
            }
        } else if($set_question["type"] == "number_pattern_decreasing") {
            $progression = 1;
            $starting_number = mt_rand(15, 100);

            if($sbtpName == '209') {
                $starting_number = mt_rand(1, 9) * mt_rand(1, 5);
                $arr = array(2, 3, 4, 5, 10);
                $progression = $arr[array_rand($arr)];
            }
            else if($sbtpName == '210') {
                $progression = mt_rand(2, 9);
            }
            else if($sbtpName == '211') {
                $starting_number = mt_rand(60, 100);
                $progression = mt_rand(1, 10);
            }
            else {
                $progression = mt_rand(1, 15);
            }

            $sequence = array();

            for($k = 1; $k <= 7; $k++) {
                $sequence[] = $starting_number;
                $starting_number += $progression;
            }

            $arr_rev = array_reverse($sequence);
            $answer = array_pop($arr_rev);

            $question = $set_question["str"] . " " . implode(", ", $arr_rev);

            $options[] = $answer;
            $count = 0;
            while($count <= 100 && count($options) < 4){
                $incorrect = mt_rand(0, 1) ? $answer + mt_rand(1, 5) : $answer - mt_rand(1, 5);

                if(!in_array($incorrect, $options)) {
                    $options[] = $incorrect;
                    $count = 0;
                }

                $count++;
            }
        } else if($set_question["type"] == "ap_series") {
            $progression_array = array();
            $starting_progression = 1;
            $progression_progress = mt_rand(2, 10);
            $starting_number = 1;

            if($sbtpName == '209') {
                $starting_number = mt_rand(1, 9) * 5;
            }
            else if($sbtpName == '210') {
                $progression_progress = mt_rand(2, 10);
                $starting_number = mt_rand(2, 10);
            }
            else if($sbtpName == '211') {
                $starting_number = mt_rand(60, 100);
                $progression_progress = mt_rand(0, 10);
                $starting_progression = mt_rand(1, 10);
            }
            else {
                $starting_number = mt_rand(60, 100);
                $progression_progress = mt_rand(0, 15);
                $starting_progression = mt_rand(1, 30);
            }

            for($k = 1; $k <= 6; $k++) {
                $progression_array[] = $starting_progression;
                $starting_progression += $progression_progress;
            }

            $sequence = array();

            for($k = 0; $k < 6; $k++) {
                $sequence[] = $starting_number;
                $starting_number += $progression_array[$k];
            }

            $answer = $starting_number;
            $question = $set_question["str"] . " " . implode(", ", $sequence);

            $options[] = $answer;
            $count = 0;
            while($count <= 100 && count($options) < 4){
                $incorrect = mt_rand(0, 1) ? $answer + mt_rand(1, 5) : $answer - mt_rand(1, 5);

                if(!in_array($incorrect, $options)) {
                    $options[] = $incorrect;
                    $count = 0;
                }

                $count++;
            }
        } else if($set_question["type"] == "gp_series") {
            $progression_array = array();
            $starting_progression = 1;
            $progression_progress = mt_rand(2, 3);
            $starting_number = 1;

            if($sbtpName == '209') {
                $starting_number = mt_rand(1, 9) * 5;
            }
            else if($sbtpName == '210') {
                $progression_progress = mt_rand(2, 5);
                $starting_number = mt_rand(2, 10);
            }
            else if($sbtpName == '211') {
                $starting_number = mt_rand(2, 10);
                $progression_progress = mt_rand(1, 3);
                $starting_progression = mt_rand(1, 5);
            }
            else {
                $starting_number = mt_rand(2, 20);
                $progression_progress = mt_rand(1, 5);
                $starting_progression = mt_rand(1, 5);
            }

            for($k = 1; $k <= 5; $k++) {
                $progression_array[] = $starting_progression;
                $starting_progression += $progression_progress;
            }

            $sequence = array();

            for($k = 0; $k < 4; $k++) {
                $sequence[] = $starting_number;
                $starting_number *= $progression_array[$k];
            }

            $answer = $starting_number;
            $question = $set_question["str"] . " " . implode(", ", $sequence);

            $options[] = $answer;
            $count = 0;
            while($count <= 100 && count($options) < 4){
                $incorrect = mt_rand(0, 1) ? $answer + mt_rand(1, 5) : $answer - mt_rand(1, 5);

                if(!in_array($incorrect, $options)) {
                    $options[] = $incorrect;
                    $count = 0;
                }

                $count++;
            }
        }

        else if($set_question["type"] == "complex") {
            $offset = 1;
            $multiplier = 1;
            $starting_number = 1;

            if($sbtpName == '209') {
                $offset = mt_rand(1, 3);
                $multiplier = mt_rand(1, 3);
                $starting_number = mt_rand(1, 3);
            }
            else if($sbtpName == '210') {
                $offset = mt_rand(1, 5);
                $multiplier = mt_rand(1, 5);
                $starting_number = mt_rand(1, 5);
            }
            else if($sbtpName == '211') {
                $offset = mt_rand(-5, -5);
                $multiplier = mt_rand(1, 5);
                $starting_number = mt_rand(1, 5);
            }
            else {
                $offset = mt_rand(1, 20);
                $multiplier = mt_rand(1, 5);
                $starting_number = mt_rand(1, 7);
            }

            $sequence = array();
            for($k = 1; $k <= 6; $k++) {
                $sequence[] = $starting_number;
                $starting_number = $offset + ($starting_number * $multiplier);
            }

            $answer = $starting_number;
            $question = $set_question["str"] . " " . implode(", ", $sequence);

            $options[] = $answer;
            $count = 0;
            while($count <= 100 && count($options) < 4){
                $incorrect = mt_rand(0, 1) ? $answer + mt_rand(1, 5) : $answer - mt_rand(1, 5);

                if(!in_array($incorrect, $options)) {
                    $options[] = $incorrect;
                    $count = 0;
                }

                $count++;
            }
        }

        if($count <= 100) {
            shuffle($options);
            setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
        }
    }
?>