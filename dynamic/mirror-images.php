<?php 
    if(in_array($sbtpName, array('214', '215', '216'))) {
        $question_obj = array(
            array(
                "type" => "mirror_image",
                "str" => "What would be the mirror image of the given figure?"
            ),
            array(
                "type" => "water_image",
                "str" => "What would be the water image of the given figure?"
            )
        );

        $randomIndex = array_rand($question_obj);
        $set_question = $question_obj[$randomIndex];

        $select_img = mt_rand(1, 10);
        $question;
        $answer;
        $options = array();
        $shape_info = array();

        if($set_question["type"] == "mirror_image") {
            $answer = "horizontal-flip";
            $transformation_types = array(
                'vertical-flip',
                'rotate-45',
                'rotate-180',
                'combine-transforms',
                'rotate-30',
                'rotate-60',
                'rotate-90',
                'rotate-120',
                'rotate-150',
                'rotate-210',
                'rotate-240',
                'rotate-270',
                'rotate-45-flip',
                'rotate-60-flip',
                'rotate-120-flip'
            );

            $temp_ind = array_rand($transformation_types, 3);
            $selected_transform = array(
                    $transformation_types[$temp_ind[0]], 
                    $transformation_types[$temp_ind[1]], 
                    $transformation_types[$temp_ind[2]]
                );

            $options[] = $answer;

            foreach($selected_transform as $option) {
                $options[] = $option;
            }

            $question = $set_question["str"];
            $shape_info["type"] = "mirror_image";
            $shape_info["image"] = "$select_img.png";
        }
        else if($set_question["type"] == "water_image") {
            $answer = "vertical-flip";
            $transformation_types = array(
                'horizontal-flip',
                'rotate-45',
                'rotate-180',
                'combine-transforms',
                'rotate-30',
                'rotate-60',
                'rotate-90',
                'rotate-120',
                'rotate-150',
                'rotate-210',
                'rotate-240',
                'rotate-270',
                'rotate-45-flip',
                'rotate-60-flip',
                'rotate-120-flip'
            );

            $temp_ind = array_rand($transformation_types, 3);
            $selected_transform = array(
                    $transformation_types[$temp_ind[0]], 
                    $transformation_types[$temp_ind[1]], 
                    $transformation_types[$temp_ind[2]]
                );

            $options[] = $answer;

            foreach($selected_transform as $option) {
                $options[] = $option;
            }

            $question = $set_question["str"];
            $shape_info["type"] = "mirror_image";
            $shape_info["image"] = "$select_img.png";
        }

        shuffle($options);
        $shape_info_json = json_encode($shape_info);
        $check_question = checkQuestionAllShape($question, $answer, $options[0], $options[1], $options[2], $options[3], $shape_info_json, $sbtpName);

        if($check_question == 0) {
            setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer, $shape_info_json);
        }
    }
?>