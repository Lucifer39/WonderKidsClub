
<?php 
    if(in_array($sbtpName, array('62', '63', '64', '65', '66', '67', '68', '69', '252'))){
        $max_term = 99;
        $minterm = 1;

        if($sbtpName == '252') {
            $minterm = 2;
            $max_term = 99;
        }
        else if(in_array($sbtpName, array('62', '63', '66', '67'))) {
            $minterm = 100;
            $max_term = 999;
        }
        else if($sbtpName == '64' || $sbtpName == '68') {
            $minterm = 1000;
            $max_term = 9999;
        }
        else if($sbtpName == '65' || $sbtpName == '69') {
            $minterm = 10000;
            $max_term = 99999;
        }

        // Call the function with your provided values
        // $numQuestions = $_POST['loopval'];
        $question_str = "What is the number shown in the figure?";
        
        // for ($i = 1; $i <= $numQuestions; $i++) {
            $answer = mt_rand($minterm, $max_term);
            // makeAjaxRequest($question_str, $randomNumber);
            $options = generateIncorrectOptions(strval($answer));

            if($options !== 0)
            setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question_str, $options[0], $options[1], $options[2], $options[3], $answer);
        // }
        
        
        
    }
?>