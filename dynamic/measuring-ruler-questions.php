<?php 
    if(in_array($sbtpName, array('179', '259'))) {
        $question_obj = array(
            array(
                "type" => "ruler_measuring",
                "str" => "What is the length of the rod given?"
            )
        );

        $set_question = $question_obj[0];

        $question;
        $answer;
        $options = array();
        $count = 0;

        if($set_question["type"] == "ruler_measuring") {
            $answer = mt_rand(1, 9);

            $question = $set_question["str"];

            array_push($options, $answer . "cms");
            $count = 0;

            while($count <= 100 && count($options) < 4) {
                $incorrect_temp = mt_rand(1,9);
                $incorrect = (mt_rand(0, 1) == 1) ? $answer + $incorrect_temp : abs($answer - $incorrect_temp);
                $incorrect_opt = $incorrect . "cms";

                if(!in_array($incorrect_opt, $options)) {
                    array_push($options, $incorrect_opt);
                    $count = 0;
                }

                $count++;
            }
        }

        if($count <= 100) {
            setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer . "cms");
        }
    }
?>