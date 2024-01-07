<?php 
    if(in_array($sbtpName, array('261'))) {
        $months = array(
            array("month" => "January", "days" => 31),
            array("month" => "February", "days" => 28),
            array("month" => "March", "days" => 31),
            array("month" => "April", "days" => 30),
            array("month" => "May", "days" => 31),
            array("month" => "June", "days" => 30),
            array("month" => "July", "days" => 31),
            array("month" => "August", "days" => 31),
            array("month" => "September", "days" => 30),
            array("month" => "October", "days" => 31),
            array("month" => "November", "days" => 30),
            array("month" => "December", "days" => 31)
        );

        $daysOfWeek = array(
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday"
        );

        $succession = array("before", "after");
        $days_of_months = array(28, 30, 31);

        $question_obj = array(
            array(
                "type" => "month_days",
                "str" => "Which of the following month has %%num_days%% days ?"
            ),
            array(
                "type" => "inv_month_days",
                "str" => "Which of the following month does not have %%num_days%% days ?"
            ),
            array(
                "type" => "before_after_month",
                "str" => "Which month comes immediately %%succession%% %%month%% ?"
            ),
            array(
                "type" => "before_after_week",
                "str" => "Which day of the week comes immediately %%succession%% %%day%% ?"
            )
        );

        shuffle($question_obj);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;

            $set_question = $question_obj[$quest_loop];

            $question;
            $answer;
            $count = 0;
            $options = array();

            if($set_question["type"] == "month_days") {
                $rand_day = $days_of_months[array_rand($days_of_months)];
                $ans_arr = array_filter($months, function($month){
                    global $rand_day;
                    return $month["days"] == $rand_day;
                });

                $inv_arr = array_filter($months, function($month){
                    global $rand_day;
                    return $month["days"] !== $rand_day;
                });

                $answer = $ans_arr[array_rand($ans_arr)]["month"];
                $options[] = $answer;
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect = $inv_arr[array_rand($inv_arr)]["month"];
                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }
                    $count++;
                }
                $question = str_replace("%%num_days%%", $rand_day,$set_question["str"]);
            } else if($set_question["type"] == "inv_month_days") {
                $rand_day = $days_of_months[array_rand($days_of_months)];
                $ans_arr = array_filter($months, function($month){
                    global $rand_day;
                    return $month["days"] == $rand_day;
                });

                $inv_arr = array_filter($months, function($month){
                    global $rand_day;
                    return $month["days"] !== $rand_day;
                });

                $answer = $inv_arr[array_rand($inv_arr)]["month"];
                $options[] = $answer;
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect = $ans_arr[array_rand($ans_arr)]["month"];
                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }
                    $count++;
                }
                $question = str_replace("%%num_days%%", $rand_day,$set_question["str"]);
            } else if($set_question["type"] == "before_after_month") {
                $monthNames = array_column($months, "month");
                $rand_succ = $succession[array_rand($succession)];
                $rand_month_index = array_rand($monthNames);

                if($rand_succ == "before") {
                    $ans_month_index = ($rand_month_index - 1) % count($monthNames);
                    if ($ans_month_index < 0) {
                        $ans_month_index = count($monthNames) - 1; // Wrap around to the last index
                    }
                } else {
                    $ans_month_index = ($rand_month_index + 1) % count($monthNames);
                    if ($ans_month_index >= count($monthNames)) {
                        $ans_month_index = 0; // Wrap around to the first index
                    }
                }

                $answer = $monthNames[$ans_month_index];
                $options[] = $answer;
                $count = 0;

                while($count <= 100 && count($options) < 4) {
                    $incorrect = $monthNames[array_rand($monthNames)];
                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                }

                $question = str_replace("%%month%%", $monthNames[$rand_month_index], $set_question["str"]);
                $question = str_replace("%%succession%%", $rand_succ, $question);
            } else if($set_question["type"] == "before_after_week") {
                $rand_succ = $succession[array_rand($succession)];
                $rand_day_index = array_rand($daysOfWeek);

                if($rand_succ == "before") {
                    $ans_day_index = ($rand_day_index - 1) % count($daysOfWeek);
                } else {
                    $ans_day_index = ($rand_day_index + 1) % count($daysOfWeek);
                }

                $answer = $daysOfWeek[$ans_day_index];
                $options[] = $answer;
                $count = 0;

                while($count <= 100 && count($options) < 4) {
                    $incorrect = $daysOfWeek[array_rand($daysOfWeek)];
                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                }

                $question = str_replace("%%succession%%", $rand_succ, $set_question["str"]);
                $question = str_replace("%%day%%", $daysOfWeek[$rand_day_index], $question);
            }

            if($count < 100) {
                // $resp_check = checkQuestion($question);

                // if($resp_check == 0){
                    shuffle($options);
                    setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
                // }
            }
        }
    }
?>