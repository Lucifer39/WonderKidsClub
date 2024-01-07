<?php 
    if(in_array($sbtpName, array('98'))){
        $question_str = array(
            array(
              "type" => "maximumPoint",
              "str" => "Which month has seen the maximum point?",
            ),
            array(
              "type" => "minimumPoint",
              "str" => "Which month has seen the minimum point?",
            ),
          );
          
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

        $graphs = array("bar_graph", "horizontal_bar_graph");
        $graph_rand = mt_rand(0, 1);

        // Generate a random question
        $randomQues = rand(0, count($question_str) - 1);
        $set_question = $question_str[$randomQues];
        $shape_info = array(
            "type" => $graphs[$graph_rand],
            "values" => $month_graph,
        );

        if ($set_question["type"] == "maximumPoint") {
            $answer = getMonthWithMaxUnits($month_graph);
        } elseif ($set_question["type"] == "minimumPoint") {
            $answer = getMonthWithMinUnits($month_graph);
        }

        // Generate options for the question
        $optionsData = generateOptions($answer["month"], $selectedMonths);
        $options = $optionsData["options"];
        $correctIndex = $optionsData["correctIndex"];

        $shape_info_json = json_encode($shape_info);

        setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $set_question["str"], $options[0], $options[1], $options[2], $options[3], $correctIndex, $shape_info_json);

    }
?>