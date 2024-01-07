<?php 
    if(in_array($sbtpName, array('238'))) {
        $question_obj = array(
            array(
                "type" => "total_number", 
                "str" => "In a row of students, %%name_1%% is %%position_11%% from the right and %%name_2%% is %%position_21%% from the left. If they interchange their positions %%name_1%% becomes %%position_22%% from the right. How many students are there in the row?",
                "process" => "interchange"
            ),
            array(
                "type" => "total_number", 
                "str" => "%%name_1%% is %%position_11%% from the right and %%name_2%% is %%position_21%% from the left. If they interchange their positions %%name_1%% becomes %%position_22%% from the right. How many students are there in the row?",
                "process" => "interchange"
            ),
            array(
                "type" => "total_number", 
                "str" => "In a row of students, %%name_1%% is %%position_11%% from the right and %%name_2%% is %%position_21%% from the left. If they interchange their positions %%name_2%% becomes %%position_12%% from the left. How many students are there in the row?",
                "process" => "interchange"
            ),
            array(
                "type" => "total_number", 
                "str" => "%%name_1%% is %%position_11%% from the right and %%name_2%% is %%position_21%% from the left. If they interchange their positions %%name_2%% becomes %%position_12%% from the left. How many students are there in the row?",
                "process" => "interchange"
            ),
            array(
                "type" => "position_from_right",
                "str" => "In a row of students, %%name_1%% is %%position_11%% from the right and %%name_2%% is %%position_21%% from the left. If they interchange their positions %%name_2%% becomes %%position_12%% from the left. What will be the position of %%name_1%% from the right?",
                "process" => "interchange"
            ),
            array(
                "type" => "position_from_right",
                "str" => "%%name_1%% is %%position_11%% from the right and %%name_2%% is %%position_21%% from the left. If they interchange their positions %%name_2%% becomes %%position_12%% from the left. What will be the position of %%name_1%% from the right?",
                "process" => "interchange"
            ),
            array(
                "type" => "position_from_left",
                "str" => "In a row of students, %%name_1%% is %%position_11%% from the right and %%name_2%% is %%position_21%% from the left. If they interchange their positions %%name_1%% becomes %%position_22%% from the right. What will be the position of %%name_2%% from the left?",
                "process" => "interchange"
            ),
            array(
                "type" => "position_from_left",
                "str" => "%%name_1%% is %%position_11%% from the right and %%name_2%% is %%position_21%% from the left. If they interchange their positions %%name_1%% becomes %%position_22%% from the right. What will be the position of %%name_2%% from the left?",
                "process" => "interchange"
            ),
            array(
                "type" => "from_left_shift_to_left_position_left",
                "str" => "In a row of %%student_num%% students, %%name_1%% is %%position_11%% from the left. If %%name_1%% shifts %%shift_11%% to the left. What will be the new position of %%name_1%% from the left?",
                "process" => "shift"
            ),
            array(
                "type" => "from_left_shift_to_left_position_right",
                "str" => "In a row of %%student_num%% students, %%name_1%% is %%position_11%% from the left. If %%name_1%% shifts %%shift_11%% to the left. What will be the new position of %%name_1%% from the right?",
                "process" => "shift"
            ),
            array(
                "type" => "from_left_shift_to_right_position_left",
                "str" => "In a row of %%student_num%% students, %%name_1%% is %%position_11%% from the left. If %%name_1%% shifts %%shift_11%% to the right. What will be the new position of %%name_1%% from the left?",
                "process" => "shift"
            ),
            array(
                "type" => "from_left_shift_to_right_position_right",
                "str" => "In a row of %%student_num%% students, %%name_1%% is %%position_11%% from the left. If %%name_1%% shifts %%shift_11%% to the right. What will be the new position of %%name_1%% from the right?",
                "process" => "shift"
            ),
            array(
                "type" => "from_right_shift_to_left_position_left",
                "str" => "In a row of %%student_num%% students, %%name_1%% is %%position_11%% from the right. If %%name_1%% shifts %%shift_11%% to the left. What will be the new position of %%name_1%% from the left?",
                "process" => "shift"
            ),
            array(
                "type" => "from_right_shift_to_left_position_right",
                "str" => "In a row of %%student_num%% students, %%name_1%% is %%position_11%% from the right. If %%name_1%% shifts %%shift_11%% to the left. What will be the new position of %%name_1%% from the right?",
                "process" => "shift"
            ),
            array(
                "type" => "from_right_shift_to_right_position_left",
                "str" => "In a row of %%student_num%% students, %%name_1%% is %%position_11%% from the right. If %%name_1%% shifts %%shift_11%% to the right. What will be the new position of %%name_1%% from the left?",
                "process" => "shift"
            ),
            array(
                "type" => "from_right_shift_to_right_position_right",
                "str" => "In a row of %%student_num%% students, %%name_1%% is %%position_11%% from the right. If %%name_1%% shifts %%shift_11%% to the right. What will be the new position of %%name_1%% from the right?",
                "process" => "shift"
            ),

        );

        shuffle($question_obj);

        for($quest_loop = 0; $quest_loop < count($question_obj); $quest_loop++) {
            $i++;

            $set_question = $question_obj[$quest_loop];
            $num_students = mt_rand(20, 50);
            $options = array();

            [$name_1, $name_2] = getTwoFirstNames();

            if($set_question["process"] == "interchange") {
                $position_11 = mt_rand(1, $num_students - 1);
                $position_21 = 0;

                do {
                    $position_21 = mt_rand(1, $num_students - 1);
                } while($position_11 == $position_21);

                $position_12 = $num_students - $position_11 + 1;
                $position_22 = $num_students - $position_21 + 1;

                $question = $set_question["str"];
                $question = str_replace("%%name_1%%", $name_1, $question);
                $question = str_replace("%%name_2%%", $name_2, $question);
                $question = str_replace("%%position_11%%", giveReadablePosition($position_11), $question);
                $question = str_replace("%%position_12%%", giveReadablePosition($position_12), $question);
                $question = str_replace("%%position_21%%", giveReadablePosition($position_21), $question);
                $question = str_replace("%%position_22%%", giveReadablePosition($position_22), $question);

                $answer = "";
                $count = 0;
                $options = array();

                if($set_question["type"] == "total_number") {
                    $answer = $num_students;

                    $options[] = $answer;
                    $count = 0;
                    while($count <= 100 && count($options) < 4) {
                        $incorrect = mt_rand(20, 50);

                        if(!in_array($incorrect, $options)) {
                            $options[] = $incorrect;
                            $count = 0;
                        }

                        $count++;
                    }
                } else if($set_question["type"] == "position_from_left") {
                    $answer = giveReadablePosition($position_12);

                    $options[] = $answer;
                    $count = 0;
                    while($count <= 100 && count($options) < 4) {
                        $incorrect = giveReadablePosition(mt_rand(1, $num_students - 1));

                        if(!in_array($incorrect, $options)) {
                            $options[] = $incorrect;
                            $count = 0;
                        }

                        $count++;
                    }
                } else if($set_question["type"] == "position_from_right") {
                    $answer = giveReadablePosition($position_22);

                    $options[] = $answer;
                    $count = 0;
                    while($count <= 100 && count($options) < 4) {
                        $incorrect = giveReadablePosition(mt_rand(1, $num_students - 1));

                        if(!in_array($incorrect, $option)) {
                            $options[] = $incorrect;
                            $count = 0;
                        }

                        $count++;
                    }
                }
            } else if($set_question["process"] == "shift") {
                $position_11 = mt_rand(2, $num_students - 1);
                $shift = 0;

                if($set_question["type"] == "from_left_shift_to_left_position_left" 
                || $set_question["type"] == "from_right_shift_to_right_position_right") {
                    $rem_students = $position_11 - 1;
                    $shift = mt_rand(1, $rem_students);

                    $answer = giveReadablePosition($position_11 - $shift);
                }
                else if($set_question["type"] == "from_left_shift_to_left_position_right" 
                || $set_question["type"] == "from_right_shift_to_right_position_left") {
                    $rem_students = $position_11 - 1;
                    $shift = mt_rand(1, $rem_students);

                    $answer = giveReadablePosition($num_students + 1 - ($position_11 - $shift));
                }
                else if($set_question["type"] == "from_left_shift_to_right_position_left" 
                || $set_question["type"] == "from_right_shift_to_left_position_right") {
                    $rem_students = $num_students - $position_11;
                    $shift = mt_rand(1, $rem_students);

                    $answer = giveReadablePosition($position_11 + $shift);
                }
                else if($set_question["type"] == "from_left_shift_to_right_position_right" 
                || $set_question["type"] == "from_right_shift_to_left_position_left") {
                    $rem_students = $num_students - $position_11;
                    $shift = mt_rand(1, $rem_students);

                    $answer = giveReadablePosition($num_students + 1 - ($position_11 + $shift));
                }

                $options = [];

                $question = $set_question["str"];
                $question = str_replace("%%student_num%%", $num_students, $question);
                $question = str_replace("%%name_1%%", $name_1, $question);
                $question = str_replace("%%position_11%%", giveReadablePosition($position_11), $question);
                $question = str_replace("%%shift_11%%", $shift, $question);

                $options[] = $answer;
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect = giveReadablePosition(mt_rand(1, $num_students));

                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                }
            }

            $check_question = checkQuestion($question);
            if($count < 100 && $check_question == 0) {
                shuffle($options);
                setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
            }
        }
    }
?>