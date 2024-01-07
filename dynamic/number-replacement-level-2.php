<?php 
    if(in_array($sbtpName, array('112', '113', '115', '116', '117'))){
        // echo "Hello";
        $question_obj = array(
            array(
              "type" => "addition",
              "str" => "Figure out the values for P, Q, and R and solve the following expression: %%expression%% <br> Round off the answer to its nearest whole number.",
            ),
            array(
              "type" => "substraction",
              "str" => "Figure out the values for P, Q, and R and solve the following expression: %%expression%% <br> Round off the answer to its nearest whole number.",
            ),
            array(
              "type" => "multiplication",
              "str" => "Figure out the values for P, Q, and R and solve the following expression: %%expression%% <br> Round off the answer to its nearest whole number.",
            ),
            array(
              "type" => "division",
              "str" => "Figure out the values for P, Q, and R and solve the following expression: %%expression%% <br> Round off the answer to its nearest whole number.",
            ),
          );

        $question_obj_add_sub = array(
          array(
            "type" => "addition",
            "str" => "Figure out the values for P, Q, and R and solve the following expression: %%expression%% <br> Round off the answer to its nearest whole number.",
          ),
          array(
            "type" => "substraction",
            "str" => "Figure out the values for P, Q, and R and solve the following expression: %%expression%% <br> Round off the answer to its nearest whole number.",
          ),
        );

        $question_obj_mult_div = array(
          array(
            "type" => "multiplication",
            "str" => "Figure out the values for P, Q, and R and solve the following expression: %%expression%% <br> Round off the answer to its nearest whole number.",
          ),
          array(
            "type" => "division",
            "str" => "Figure out the values for P, Q, and R and solve the following expression: %%expression%% <br> Round off the answer to its nearest whole number.",
          ),
        );

        shuffle($question_obj);
        shuffle($question_obj_add_sub);
        shuffle($question_obj_mult_div);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
          $i++;
        
          $set_question;
          $max_term;
          $min_term;
          $second_max_term;
          $second_min_term;

          if($sbtpName == '112'){
            $set_question = $question_obj_add_sub[$quest_loop % count($question_obj_add_sub)];
            $max_term = 999;
            $min_term = 11;
          }
          else if($sbtpName == '113'){
            $set_question = $question_obj_add_sub[$quest_loop % count($question_obj_add_sub)];
            $max_term = 999;
            $min_term = 11;
          }
          else if($sbtpName == '115'){
            $set_question = $question_obj_add_sub[$quest_loop % count($question_obj_add_sub)];
            $max_term = 9999;
            $min_term = 1001;
          }
          else if($sbtpName == '116'){
            $set_question = $question_obj_mult_div[$quest_loop % count($question_obj_mult_div)];
            $max_term = 9999;
            $min_term = 101;
            $second_max_term = 99;
            $second_min_term = 2;
          }
          else if($sbtpName == '117'){
            $set_question = $question_obj[$quest_loop];
            $max_term = 99999;
            $min_term = 1001;
            $second_max_term = 99999;
            $second_min_term = 2;
          }
          

          $P;
          $Q;
          $R;
          $num1;
          $num2;
          $result;
          $shape_info = array();
          $deactivate = false;
          
          $num1 = mt_rand($min_term, $max_term);
          $P = getRandomDigitExcluding($num1, array(0));
          
          if ($set_question["type"] == "addition") {
              $num2 = mt_rand($min_term, $max_term);
              $result = $num1 + $num2;

              if($sbtpName !== '114'){
                $Q = getRandomDigitExcluding($num2, array(0, $P));
                $R = getRandomDigitExcluding($result, array(0, $P, $Q));
              }

              if((!$P || !$Q || !$R) || (!checkNumReplacement(strval($num1), strval($num2), strval($num1 + $num2), "$P$Q$R"))) {
                $deactivate = true;
              }
          
              $shape_info["type"] = "addition";
          } else if ($set_question["type"] == "substraction") {
              $num2 = mt_rand($min_term, $num1 - 1);
              $result = $num1 - $num2;

              if($sbtpName !== '114'){
                $Q = getRandomDigitExcluding($num2, array(0, $P));
                $R = getRandomDigitExcluding($result, array(0, $P, $Q));
              }

              if((!$P || !$Q || !$R) || (!checkNumReplacement(strval($num1), strval($num2), strval($num1 - $num2), "$P$Q$R"))) {
                $deactivate = true;
              }
          
              $shape_info["type"] = "substraction";
          } else if ($set_question["type"] == "multiplication") {
              $num2 = mt_rand(2, 99);
              $result = $num1 * $num2;

              if($sbtpName !== '114'){
                $Q = getRandomDigitExcluding($num2, array(0, $P));
                $R = getRandomDigitExcluding($result, array(0, $P, $Q));
              }

              if(!$P || !$Q || !$R || containsZero($num2)) {
                $deactivate = true;
              }

              $shape_info["type"] = "multiplication";
          } else if ($set_question["type"] == "division") {
              $num2 = mt_rand(2, 99);
              $result = floor($num1 / $num2);

              if($sbtpName !== '114'){
                $Q = getRandomDigitExcluding($num2, array(0, $P));
                $R = getRandomDigitExcluding($result, array(0, $P, $Q));
              }

              if(!$P || !$Q || !$R || containsZero($num2)) {
                $deactivate = true;
              }
          
              $shape_info["type"] = "division";
          }

        if(!$deactivate) {
         
          $shape_info["num_1"] = $num1;
          $shape_info["num_2"] = $num2;
          $shape_info["pqr"] = $P . "" . ($Q ?? "") . "" . ($R ?? "");
          
          // Assuming you have defined and implemented the getRandomMathExpression() function in PHP.
          $problem_expression = getRandomMathExpression($P, $Q, $R);
          // $question = $set_question["str"] . " " . $problem_expression["expression_result"];
          $question = str_replace("%%expression%%", $problem_expression["expression_result"], $set_question["str"]);

          $answer = $problem_expression["result"];

          $options = generateIncorrectOptions(strval($answer));

            $shape_info_json = json_encode($shape_info);

            $resp = setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer, $shape_info_json);
            // echo $resp;
        }
      }
    }
?>