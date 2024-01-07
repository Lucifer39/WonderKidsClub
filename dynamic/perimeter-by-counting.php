<?php
if($sbtpName == '88'){
    
    $question_str = "What is the perimeter of the shaded region? Assume each part is of length %%number%% unit(s).";

    $shadedBoxCoordinates = array();
    $matrixSize = 10;
    $shadedCount = 0;

    $generatedCoordinates = generateCoordinates();
    $perimeter = $generatedCoordinates['perimeter'];
    $coordinates = $generatedCoordinates['coordinates'];
    $matrixSize = 10; // You might need to define this variable if not already defined

    $shape_info = array(
        'type' => 'square',
        'length' => $matrixSize,
        'breadth' => $matrixSize,
        'coordinates' => $coordinates
    );

    $rando_ques = rand(1, 10);
    $question = str_replace("%%number%%", $rando_ques, $question_str);

    $resp_check = checkQuestionPerimeter($sbtpName, json_encode($shape_info["coordinates"]));

    if($resp_check == 0){
      $answer = $perimeter * $rando_ques;
      $options = generateIncorrectOptions(strval($answer));

      $shape_info_json = json_encode($shape_info);

      if($options !== 0)
      $resp = setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer, $shape_info_json);
      // var_dump($resp);
    }


}
?>
