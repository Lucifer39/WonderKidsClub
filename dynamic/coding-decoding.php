<?php 
    if(in_array($sbtpName, array('217', '218', '219', '220', '221'))){
        $question_obj = array(
            array(
                "type" => "coding",
                "str" => "If %%word%% is written as %%coded_word%%, what would %%second_word%% be written as?",
            ),
            array(
                "type" => "decoding",
                "str" => "If %%word%% is written as %%coded_word%%, what word would become %%second_coded_word%% ?"
            )
        );

        // $randomIndex = array_rand($question_obj);
        
        shuffle($question_obj);
        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;

            $set_question = $question_obj[$quest_loop];

            $question;
            $answer;
            $options = array();
            $count = 0;
            $shift;
            do{
                $shift = mt_rand(-25, 25);
            }while($shift == 0);
            $word_length = mt_rand(4, 5);

            if($sbtpName == '217') {
                $shift = mt_rand(1, 25);
            }


            if($set_question["type"] == "coding") {
                $word = generateRandomWord();
            
                $coded_word = caesarEncrypt($word, $shift);

                $second_word = generateRandomWord($word_length);
                $answer = caesarEncrypt($second_word, $shift);

                $options[] = strtoupper($answer);

                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $temp_shift = mt_rand(0, 1) ? $shift - mt_rand(1, 5) : $shift + mt_rand(1, 5);
                    $incorrect = strtoupper(caesarEncrypt($second_word, $temp_shift));

                    if(!in_array($incorrect, $options)) {
                        $options[] = strtoupper($incorrect);
                        $count = 0;
                    }

                    $count++;
                }

                $question = str_replace("%%word%%", strtoupper($word), $set_question["str"]);
                $question = str_replace("%%coded_word%%", strtoupper($coded_word), $question);
                $question = str_replace("%%second_word%%", strtoupper($second_word), $question);
            }
            else if($set_question["type"] == "decoding") {
                $word = generateRandomWord();

                $coded_word = caesarEncrypt($word, $shift);

                $answer = generateRandomWord($word_length);
                $second_coded_word = caesarEncrypt($answer, $shift);

                $options[] = strtoupper($answer);
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect = strtoupper(generateRandomWord($word_length, substr($answer, 0, 1)));

                    if(!in_array($incorrect, $options)) {
                        $options[] = strtoupper($incorrect);
                        $count = 0;
                    }

                    $count++;
                }

                $question = str_replace("%%word%%", strtoupper($word), $set_question["str"]);
                $question = str_replace("%%coded_word%%", strtoupper($coded_word), $question);
                $question = str_replace("%%second_coded_word%%", strtoupper($second_coded_word), $question);
            }

            if($count < 100) {
                shuffle($options);
                setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], strtoupper($answer));
            }
        }
    }
?>