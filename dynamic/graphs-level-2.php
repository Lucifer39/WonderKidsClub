<?php 
    if(in_array($sbtpName, array('99', '100'))){
        $question_str = array(
            array(
                "type" => "less",
                "str" => "How many less units were produced in %%month%% than the remaining months altogether?",
            ),
            array(
                "type" => "less",
                "str" => "_______ less units were produced in %%month%% than remaining months altogether.",
            ),
            array(
                "type" => "total",
                "str" => "Total number of units produced in %%month_1%% and %%month_2%% are:",
            ),
            array(
                "type" => "difference",
                "str" => "What is the difference of the maximum number of units produced and the minimum number of units produced?"
            )
        );

        shuffle($question_str);

        for($quest_loop = 0; $quest_loop < count($question_str); $quest_loop++) {
            $i++;

            $set_question = $question_str[$quest_loop];
        
            $month_graph_all = array(
                array("month" => "January", "units" => 0),
                array("month" => "February", "units" => 0),
                array("month" => "March", "units" => 0),
                array("month" => "April", "units" => 0),
                array("month" => "May", "units" => 0),
                array("month" => "June", "units" => 0),
                array("month" => "July", "units" => 0),
                array("month" => "August", "units" => 0),
                array("month" => "September", "units" => 0),
                array("month" => "October", "units" => 0),
                array("month" => "November", "units" => 0),
                array("month" => "December", "units" => 0),
            );

            $numberOfElements = mt_rand(4, 5);

            // Get random keys from the array
            $randomKeys = array_rand($month_graph_all, $numberOfElements);

            // Initialize an empty array to hold the selected elements
            $selectedElements = [];
            $selectedMonths = array();

            // If $randomKeys is not an array, convert it to an array
            if (!is_array($randomKeys)) {
                $randomKeys = [$randomKeys];
            }

            // Loop through the random keys and populate the selected elements array
            foreach ($randomKeys as $key) {
                $selectedElements[] = $month_graph_all[$key];
                $selectedMonths[] = $month_graph_all[$key]["month"];
            }

            $month_graph = fillArrayWithRandomUnits($selectedElements);

            $graphs = array("bar_graph", "horizontal_bar_graph", "line_graph", "pie_chart",);
            $graph_rand = mt_rand(0, count($graphs) - 1);

            fillArrayWithRandomUnits($month_graph);
            $answer;
            $question;

            if ($set_question["type"] == "less") {
                $random_month = $month_graph[rand(0, count($month_graph) - 1)];
                $rem_total = array_reduce($month_graph, function ($total, $item) use ($random_month) {
                    if ($item["month"] !== $random_month["month"]) {
                        $total += $item["units"];
                    }
                    return $total;
                }, 0);

                $answer = $rem_total - $random_month["units"];
                $question = str_replace("%%month%%", $random_month["month"], $set_question["str"]);
            } elseif ($set_question["type"] == "total") {
                $random_month_1 = $month_graph[mt_rand(0, count($month_graph) - 1)];
                // $rem_months = array_filter($month_graph, function ($current_month) use ($random_month_1) {
                //     return $current_month["month"] !== $random_month_1["month"];
                // });

                $random_month_2;

                $count = 0;
                do {
                    $random_month_2 = $month_graph[mt_rand(0, count($month_graph) - 1)];
                } while($random_month_2 == $random_month_1);

                $answer = $random_month_1["units"] + $random_month_2["units"];

                $question = str_replace("%%month_1%%", $random_month_1["month"], $set_question["str"]);
                $question = str_replace("%%month_2%%", $random_month_2["month"], $question);
            } else if($set_question["type"] == "difference") {
                $max_month = getMonthWithMaxUnits($month_graph);
                $min_month = getMonthWithMinUnits($month_graph);

                $answer = $max_month["units"] - $min_month["units"];
                $question = $set_question["str"];
            }

            $shape_info = array(
                "type" => $graphs[$graph_rand],
                "values" => $month_graph,
            );

            $shape_info_json = json_encode($shape_info);


            $count = 0;
            $options = array($answer);
            while($count <= 100 && count($options) < 4) {
                $incorrect = getRandomUnits();

                if(!in_array($incorrect, $options)) {
                    $options[] = $incorrect;
                    $count = 0;
                }

                $count++;
            }
            // $options = generateIncorrectOptions($answer);

            if($count < 100){
                shuffle($options);
                setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer, $shape_info_json);
            }
        }
    }
?>