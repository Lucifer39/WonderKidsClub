<?php 
    if(in_array($sbtpName, array('264', '265', '266', '267', '268'))) {
        $question = "Find the missing number if the same rule is followed in all the three figures.";

        $shapes = array(
            array(
                "shape" => "triangle",
                "num_sides" => 3
            ),
            array(
                "shape" => "square",
                "num_sides" => 4
            )
        );

        $set_shape = $shapes[array_rand($shapes)];

        if($set_shape['shape'] == 'triangle') {

            if(in_array($sbtpName, array('264'))) {
                $expression_list = array(
                    "#0 + #1 + #2"
                );
            } else if(in_array($sbtpName, array('265', '266'))) {
                $expression_list = array(
                    "#0 + #1 + #2",
                    "#0 + #1 - #2",
                    "#0 - #1 + #2"
                );
            } else {
                $expression_list = array(
                    "#0 + #1 + #2",
                    "#0 * #1 * #2",
                    "#0 + #1 - #2",
                    "#0 * #1 + #2",
                    "#0 * #1 - #2",
                    "#0 - #1 + #2"
                );
            }
        } else if($set_shape['shape'] == 'square') {

            if(in_array($sbtpName, array('264'))) {
                $expression_list = array(
                    "#0 + #1 + #2 + #3"
                );
            } else if(in_array($sbtpName, array('265', '266'))) {
                $expression_list = array(
                    "#0 + #1 + #2 + #3", 
                    "#0 + #1 - #2 - #3",
                    "#0 + #1 + #2 - #3",
                );
            } else {
                $expression_list = array(
                    "#0 + #1 + #2 + #3", 
                    "#0 + #1 - #2 - #3",
                    "#0 + #1 + #2 - #3",
                    "#0 * #2 + #1 * #3",
                    "#0 * #2 - #1 * #3",
                    "#0 * #1 + #2 * #3",
                    "#0 * #1 - #2 * #3",
                );
            }
        }

        shuffle($expression_list);

        for($count_quest = 0; $count_quest < count($expression_list); $count_quest++) {
            $i++;
            $shape_info = array();
            $shape_info['shape'] = $set_shape['shape'];

            $num_figs = 3;
            $rand_exp = $expression_list[$count_quest];
            $answer;
            $options = array();
            $count = 0;
            $fig_arr = array();

            for($nums = 0; $nums < $num_figs; $nums++) {
                $num_arr = array();
                $count = 0;
                do{

                    for($count_num = 0; $count_num < $set_shape['num_sides']; $count_num++) {
                        if($sbtpName == '264' || $sbtpName == '265') {
                            $num_arr[] = mt_rand(1, 9);
                        } else if($sbtpName == '266') {
                            $num_arr[] = mt_rand(1, 20);
                        } else if ($sbtpName == '267') {
                            if(strpos($rand_exp, "*")) {
                                $num_arr[] = mt_rand(1, 9);
                            } else {
                                $num_arr[] = mt_rand(1, 20);
                            }
                        } else if($sbtpName == '268') {
                            if(strpos($rand_exp, "*")) {
                                $num_arr[] = mt_rand(1, 9);
                            } else {
                                $num_arr[] = mt_rand(1, 30);
                            }
                        }
                    }

                    $res = evaluateExpressionNumberRelation($num_arr, $rand_exp);
                    $count++;
                } while($count <= 100 && ($res <= 0 || $res >= 9999));

                if($count >= 100) { 
                    break;
                }

                if($nums == $num_figs - 1) {
                    $num_arr[] = "?";
                    $answer = $res;
                } else {
                    $num_arr[] = $res;
                }

                $fig_arr[] = $num_arr;
            }

            if($count < 100) {
                $shape_info["figures"] = $fig_arr;

                $options[] = $answer;
                $count = 0;
                while($count <= 100 && count($options) < 4) {
                    $incorrect = mt_rand(0, 1) == 1 ? $answer + mt_rand(1, 5) : abs($answer - mt_rand(1, 5));

                    if(!in_array($incorrect, $options)) {
                        $options[] = $incorrect;
                        $count = 0;
                    }

                    $count++;
                }

                if($count < 100) {
                    $shape_info_json = json_encode($shape_info);
                    setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer, $shape_info_json);
                }
            }
        }
    }
?>