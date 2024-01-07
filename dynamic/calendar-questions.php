<?php 
    if(in_array($sbtpName, array('175', '173', '176', '177', '178'))){
        $question_obj = array(
            array(
                "type" => "day_of_week",
                "str" => "Which day is the %%x%% ?"
            ),
            array(
                "type" => "calculate_date",
                "str" => "What date is the %%x%% %%y%% of %%z%% ? "
            ),
            array(
                "type" => "calculate_event_date",
                "str" => "A%%event%% started on %%x%% and continued for %%days%% more day(s). On which date did it end?"
            ),
            array(
                "type" => "calculate_event_day",
                "str" => "A%%event%% started on %%x%% and continued for %%days%% more day(s). On what day of the week did it end?"
            ),
            array(
                "type" => "calculcate_event_date_without_weekends",
                "str" => "A%%event%% started on %%x%% and continued for %%days%% more day(s). If on weekends it was suspended, on which date did it end?"
            ),
            array(
                "type" => "calculate_event_day_without weekends",
                "str" => "A%%event%% started on %%x%% and continued for %%days%% more day(s). If on weekends it was suspended, on what day of the week did it end?"
            )
        );
    
        $events = array(
            " Conference",
            " Workshop",
            " Seminar",
            " Webinar",
            "n Exhibition",
            " Trade Show",
            " Meeting",
            " Symposium",
            " Convention",
            " Product Launch",
            " Panel Discussion",
            " Training Session",
            " Hackathon",
            " Job Fair",
            " Gala Dinner",
            " Charity Auction",
            " Fundraising Event",
            "n Art Exhibition",
            " Music Festival",
            " Sporting Event",
            " Cultural Festival",
            " Food and Wine Tasting",
            " Fashion Show",
            " Comedy Night",
            " Movie Premiere",
            " Book Reading",
            " Science Fair",
            " Tech Conference",
            "n Environmental Summit",
            " Health and Wellness Expo"
        ); 

        $months_all = array(
            "January", 
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        );

        $week_all = array(
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday"
        );

        $multplier_array = array(
            array("place" => "first", "multiplier" => 1),
            array("place" => "second", "multiplier" => 2),
            array("place" => "third", "multiplier" => 3),
            array("place" => "fourth", "multiplier" => 4),
        );

        shuffle($question_obj);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;

            $set_question = $question_obj[$quest_loop];
            $random_month = $months_all[mt_rand(0, count($months_all) - 1)];
            $random_year = mt_rand(1990, 2023);

            $random_day = mt_rand(1, 28);

            $random_event = $events[array_rand($events)];


            $shape_info = array(
                "type" => "calender",
                "month" => "$random_month",
                "year" => "$random_year"
            );

            $question;
            $answer;
            $options = array();
            $count = 0;

            $shape_info_json = json_encode($shape_info);

            if($set_question["type"] == "day_of_week") {
                $answer = ucfirst(getDayOfWeek($random_day, intval(array_search($random_month, $months_all) + 1), $random_year));
                $question = str_replace("%%x%%", "$random_day / $random_month", $set_question["str"]);

                array_push($options, $answer);
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $day = $week_all[mt_rand(0, count($week_all) - 1)];

                    if(!in_array($day, $options)){
                        array_push($options, $day);
                        $count = 0;
                    }

                    $count++;
                }
            }
            else if($set_question["type"] == "calculate_date") {
                $random_offset_index = array_rand($multplier_array);
                $random_offset = $multplier_array[$random_offset_index];
                $random_day_of_week_number = mt_rand(0, count($week_all) - 1);
                $random_day_of_week = $week_all[$random_day_of_week_number];

                $answer = getDateForWeekdayOccurrence($random_year, intval(array_search($random_month, $months_all) + 1), $random_day_of_week_number, $random_offset["multiplier"]);

                $question = str_replace("%%x%%", $random_offset["place"], $set_question["str"]);
                $question = str_replace("%%y%%", $random_day_of_week, $question);
                $question = str_replace("%%z%%", $random_month, $question);

                $correcct_day = intval(explode("/", $answer)[0]);
                array_push($options, $answer);
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect_day = mt_rand(1, 28);
                    // $incorrect_month = mt_rand(1, 12);
                    $desiredLength = 2;    // The total desired length of the padded string

                    $incorrect_date = str_pad($incorrect_day, $desiredLength, "0", STR_PAD_LEFT) . "/" . str_pad(intval(array_search($random_month, $months_all) + 1), $desiredLength, "0", STR_PAD_LEFT);

                    if($incorrect_day !== $correcct_day && !in_array($incorrect_date, $options)){
                        array_push($options, $incorrect_date);
                        $count = 0;
                    }

                    $count++;
                }
            } else if($set_question["type"] == "calculate_event_date" || $set_question["type"] == "calculcate_event_date_without_weekends") {
                $num_days = mt_rand(1, $random_day > 15 ? 30 - $random_day : 16 - $random_day);
                $ans_array = $set_question["type"] == "calculate_event_date" ? calculateFutureDate($random_day, monthNameToNumber($random_month), $random_year, $num_days)
                                                                            : calculateFutureDateWithoutWeekends($random_day, monthNameToNumber($random_month), $random_year, $num_days);
                $answer = $ans_array['date'];
                $options[] = $answer;
                $count = 0;

                if($set_question["type"] == "calculcate_event_date_without_weekends" && isWeekend($random_day, monthNameToNumber($random_month), $random_year)) {
                    $count = 110;
                }

                while($count <= 100 && count($options) < 4) {
                    $incorrect_day = mt_rand(1, 28);
                    // $incorrect_month = mt_rand(1, 12);
                    $desiredLength = 2; // The total desired length of the padded string

                    $incorrect_date = str_pad($incorrect_day, $desiredLength, "0", STR_PAD_LEFT) . "/" . str_pad(intval(array_search($random_month, $months_all) + 1), $desiredLength, "0", STR_PAD_LEFT);
                    if(!in_array($incorrect_date, $options)){
                        $options[] = $incorrect_date;
                        $count = 0;
                    }

                    $count++;
                }

                $question = str_replace("%%event%%", $random_event, $set_question["str"]);
                $question = str_replace("%%x%%", "$random_day / $random_month", $question);
                $question = str_replace("%%days%%", $num_days, $question);

            } else if($set_question["type"] == "calculate_event_day" || $set_question["type"] == "calculate_event_day_without weekends") {
                $num_days = mt_rand(1, $random_day > 15 ? 30 - $random_day : 16 - $random_day);
                $ans_array = $set_question["type"] == "calculate_event_date" ? calculateFutureDate($random_day, monthNameToNumber($random_month), $random_year, $num_days)
                                                                            : calculateFutureDateWithoutWeekends($random_day, monthNameToNumber($random_month), $random_year, $num_days);
                $answer = $ans_array['dayOfWeek'];
                $options[] = $answer;
                $count = 0;

                if($set_question["type"] == "calculate_event_day_without weekends" && isWeekend($random_day, monthNameToNumber($random_month), $random_year)) {
                    $count = 110;
                }

                while($count <= 100 && count($options) < 4) {
                    $incorrect = $week_all[array_rand($week_all)];
                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                }

                $question = str_replace("%%event%%", $random_event, $set_question["str"]);
                $question = str_replace("%%x%%", "$random_day / $random_month", $question);
                $question = str_replace("%%days%%", $num_days, $question);

            }


            shuffle($options);

            if($count <= 100) {
                setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer, $shape_info_json);
            }
        }
    }
?>