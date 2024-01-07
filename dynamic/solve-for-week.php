<?php 
    if(in_array($sbtpName, array('262'))) {
        $question_obj = array(
            array(
                'type'=> 'today',
                'str' => 'If today is %%day%%, what %%result_day%% ?'
            ),
            array(
                'type' => 'yesterday',
                'str' => 'If yesterday was %%day%%, what %%result_day%% ?'
            ),
            array(
                'type' => 'tomorrow',
                'str' => 'If tomorrow is %%day%%, what %%result_day%% ?'
            ),
            array(
                'type' => 'day_before_yesterday',
                'str' => 'If the day before yesterday was %%day%%, what %%result_day%% ?'
            ),
            array(
                'type' => 'day_after_tomorrow',
                'str' => 'If the day after tomorrow is %%day%%, what %%result_day%%?'
            )
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

        $succession = array('before', 'after');
        $day_type = array('yesterday', 'today', 'tomorrow');

        $result_day = array(
            array("type" => "today", "str" => "is today"),
            array("type" => "tomorrow", "str" => "is tomorrow"),
            array("type" => "day_after_tomorrow", "str" => "is the day 2 days after today"),
            array("type" => "day_after_day_after_tomorrow", "str" => "is the day 3 days after today"),
            array("type" => "tomorrow", "str" => "is the 2nd day from today"),
            array("type" => "day_after_tomorrow", "str" => "is the 3rd day from today"),
            array("type" => "day_after_tomorrow", "str" => "is the 2nd day from tomorrow"),
            array("type" => "day_after_day_after_tomorrow", "str" => "is the 3rd day from tomorrow"),
            array("type"=> "day_before_yesterday", "str" => "was the day 2 days before today",),
            array("type" => "day_before_day_before_yesterday", "str" => "was the day 3 days before today"),
        );

        shuffle($question_obj);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++){
            $i++;
            $set_question = $question_obj[$quest_loop];

            $question;
            $answer;
            $options = array();
            $count = 0;

            $today = array_rand($daysOfWeek);
            $tomorrow = ($today + 1) % count($daysOfWeek);
            $yesterday = ($today - 1) < 0 ? count($daysOfWeek) - 1 : $today - 1;
            $day_before_yesterday = ($yesterday - 1) < 0 ? count($daysOfWeek) - 1 : $yesterday - 1;
            $day_after_tomorrow = ($tomorrow + 1) % count($daysOfWeek);
            $day_after_day_after_tomorrow = ($day_after_tomorrow + 1) % count($daysOfWeek);
            $day_before_day_before_yesterday = ($day_before_yesterday - 1) < 0 ? count($daysOfWeek) - 1 : $day_before_yesterday - 1;

            $result_day_filter = array_filter($result_day, function($day) {
                global $set_question;
                return $day["type"] !== $set_question["type"];
            });

            $result_day_rand = $result_day_filter[array_rand($result_day_filter)];

            if($result_day_rand["type"] == "today") {
                $answer = $daysOfWeek[$today];
            } else if($result_day_rand["type"] == "tomorrow") {
                $answer = $daysOfWeek[$tomorrow];
            } else if($result_day_rand["type"] == "yesterday") {
                $answer = $daysOfWeek[$yesterday];
            } else if($result_day_rand["type"] == "day_after_tomorrow") {
                $answer = $daysOfWeek[$day_after_tomorrow];
            } else if($result_day_rand["type"] == "day_after_day_after_tomorrow") {
                $answer = $daysOfWeek[$day_after_day_after_tomorrow];
            } else if($result_day_rand["type"] == "day_before_yesterday") {
                $answer = $daysOfWeek[$day_before_yesterday];
            } else if($result_day_rand["type"] == "day_before_day_before_yesterday") {
                $answer = $daysOfWeek[$day_before_day_before_yesterday];
            }

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

            if($set_question["type"] == "today") {
                $question = str_replace("%%day%%", $daysOfWeek[$today], $set_question["str"]);
            } else if($set_question["type"] == "yesterday") {
                $question = str_replace("%%day%%", $daysOfWeek[$yesterday], $set_question["str"]);
            } else if($set_question["type"] == "tomorrow") {
                $question = str_replace("%%day%%", $daysOfWeek[$tomorrow], $set_question["str"]);
            } else if($set_question["type"] == "day_before_yesterday") {
                $question = str_replace("%%day%%", $daysOfWeek[$day_before_yesterday], $set_question["str"]);
            } else if($set_question["type"] == "day_after_tomorrow") {
                $question = str_replace("%%day%%", $daysOfWeek[$day_after_tomorrow], $set_question["str"]);
            }

            $question = str_replace("%%result_day%%", $result_day_rand["str"], $question);

            if($count < 100) {
                $resp_check = checkQuestion($question);

                if($resp_check == 0){
                    shuffle($options);
                    setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
                }
            }
        }
    }
?>