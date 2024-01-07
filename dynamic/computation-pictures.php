<?php 
    if(in_array($sbtpName, array('172'))) {
        $question_obj = array(
            array(
                "type" => "counting_pictures",
                "str" => "How many fruits are present in the basket? <br>"
            )
        );

        $question = $question_obj[0]["str"];

        $num = mt_rand(1, 20);

        $options = array($num);

        $count = 0;
        while($count <= 100 && count($options) < 4) {
            $incorrect = mt_rand(1, 20);

            if(!in_array($incorrect, $options)) {
                array_push($options, $incorrect);
                $count = 0;
            }

            $count++;
        }

        shuffle($options);

        var_dump($options);

        if($count <= 100) {
            echo $num;
            $resp = setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $num);
            echo $resp;
        }
    }
?>