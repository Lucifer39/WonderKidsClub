<?php 
    if(in_array($sbtpName, array('106', '107', '114'))){
        $question_obj = array(
            array(
              "type" => "addition",
              "str" => "Figure out the missing value of P.",
            ),
            array(
              "type" => "substraction",
              "str" => "Figure out the missing value of P.",
            ),
            array(
                "type" => "multiplication",
                "str" => "Figure out the missing value of P.",
              ),
              array(
                "type" => "division",
                "str" => "Figure out the missing value of P.",
              )
          );

          $choose_term;

          if($sbtpName == '106') {$choose_term = 0;}
          else if($sbtpName == '107') {$choose_term = 1;}
          else if($sbtpName == '114') {$choose_term = mt_rand(2,3);}

          $set_question = $question_obj[$choose_term];
            $P;
            $num1;
            $num2;
            $result;
            $shape_info = array();

            $num1 = $sbtpName == '114' ? mt_rand(101, 9999) : mt_rand(11, 99);
            $P = getRandomDigitExcluding($num1, array(0));

            if ($set_question["type"] == "addition") {
                $num2 = rand(11, 99);

                if($sbtpName == '106') {
                  $num2 = numberWithoutCarry($num1);
                }
            
                $result = $num1 + $num2;
            
                $shape_info["type"] = "addition";
            } else if ($set_question["type"] == "substraction") {
                $num2 = rand(1, $num1 - 1) + 1;

                if($sbtpName == 107) {
                  $num2 = numberWithoutBorrow($num1);
                }
            
                $result = $num1 - $num2;
            
                $shape_info["type"] = "substraction";
            } else if ($set_question["type"] == "multiplication") {
                $num2 = rand(2, 9);
                $result = $num1 * $num2;
  
                $shape_info["type"] = "multiplication";
            } else if ($set_question["type"] == "division") {
                $num2 = rand(2, 9);
                $result = floor($num1 / $num2);
  
                $shape_info["type"] = "division";
            }

            $shape_info["num_1"] = $num1;
            $shape_info["num_2"] = $num2;
            $shape_info["pqr"] = $P;

            $question = $set_question["str"];

            $options = generateIncorrectOptions(strval($P));

            $shape_info_json = json_encode($shape_info);

            if($options !== 0)
            $resp = setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $P, $shape_info_json);
    }
?>