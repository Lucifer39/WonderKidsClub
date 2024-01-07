<?php 
    if(in_array($sbtpName, array('247', '250', '251', '253', '254'))) {
        $question_obj = array(
            array(
                "type" => "indian",
                "str" => "What is the place value of the %%occ%% occurrence of %%x%% from the %%dir%% in the number %%y%% ?"
            ),
            array(
                "type" => "international",
                "str" => "What is the place value of the %%occ%% occurrence of %%x%% from the %%dir%% in the number %%y%% ?"
            )
        );

        $occurence = ["first", "last"];
        $direction = ['left', 'right'];

        shuffle($question_obj);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;
            $set_question = $question_obj[$quest_loop];
            $rand_occ = $occurence[array_rand($occurence)];
            $rand_dir = $direction[array_rand($direction)];

            $places = array(1, 10, 100, 1000, 10000, 100000, 1000000, 10000000, 100000000);

            $number = mt_rand(100, 100000000);

            if($sbtpName == '253') {
                $set_question = array(
                                    "type" => "indian",
                                    "str" => "What is the place value of the first occurrence of %%x%% from the left in the number %%y%% ?"
                                );
                $number = mt_rand(1, 100);
            } else if ($sbtpName == '254') {
                $number = mt_rand(1, 999);
            }

            $digit = getRandomDigitFromNumber($number);
            $place = findDigitPlace($number, $digit, $rand_occ, $rand_dir);
            $answer = $set_question["type"] == 'indian' ? numberToIndianWords($place) : numberToWords($place);

            $options = [];
            $options[] = $answer;
            $count = 0;

            while($count <= 100 && count($options) < 4) {
                $incorrect_temp = $digit * $places[array_rand($places)];
                $incorrect = $set_question["type"] == 'indian' ? numberToIndianWords($incorrect_temp) : numberToWords($incorrect_temp); 

                if(!in_array($incorrect, $options)) {
                    $options[] = $incorrect;
                    $count = 0;
                }

                $count++;
            }

            $question = str_replace("%%x%%", $digit, $set_question["str"]);
            $question = str_replace("%%y%%", $number, $question);
            $question = str_replace('%%occ%%', $rand_occ, $question);
            $question = str_replace('%%dir%%', $rand_dir, $question);

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