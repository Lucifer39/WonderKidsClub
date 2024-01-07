<?php 
    require_once("../../config/config.php"); // Include the connection file

    function insertShapeInformation($shape_type, $length, $breadth, $shaded_portion_1, $shaded_portion_2, $question_id){
        global $conn; // Access the global $conn object
        
        try {
            $query = "INSERT INTO test_dummy_shapes_info (shape_type, shape_length, shape_breadth, shaded_portion_1, shaded_portion_2, question_id)
                      VALUES ('$shape_type', $length, $breadth, $shaded_portion_1, $shaded_portion_2, $question_id);";
            
            $result = mysqli_query($conn, $query);
            
            // Check if the query was successful
            if ($result) {
                return true; // Insertion successful
            } else {
                return false; // Insertion failed
            }
            
        } catch (Exception $e) {
            echo $e;
            exit('Database error.');
        }
    } 

    function setQuestionsShape($user_id, $class, $subject, $topic, $subtopic, $question, $opt_1, $opt_2, $opt_3, $opt_4, $correct_opt, $shape_info)
    {
        global $conn; // Access the global $conn object
        $shape_info_json = json_encode($shape_info);
        
        try {
            $query = "INSERT INTO count_quest (user_id, class, subject, topic, subtopic, question, opt_a, opt_b, opt_c, opt_d, correct_ans, shape_info) 
                    VALUES ($user_id, $class, $subject, $topic, $subtopic, '$question', '$opt_1', '$opt_2', '$opt_3', '$opt_4', '$correct_opt', '$shape_info')";
            
            $result = mysqli_query($conn, $query);
            
            // Check if the query was successful
            if ($result) {
                return true; // Insertion successful
            } else {
                return false; // Insertion failed
            }
            
        } catch (Exception $e) {
            echo $e;
            exit('Database error.');
        }
    }

    function getOptionArray($correct_opt) {
        $options = array();
        $total_options = 4;
    
        // Add the correct option
        $options[] = array(
            'option' => $correct_opt,
            'isCorrect' => true
        );
    
        // Generate unique random options
        while (count($options) < $total_options) {
            $random_option = random_fraction_string();
            if (!in_array($random_option, array_column($options, 'option'))) {
                $option = array(
                    'option' => $random_option,
                    'isCorrect' => false
                );
                $options[] = $option;
            }
        }
    
        // Shuffle the options array
        shuffle($options);
    
        return $options;
    }

    function random_fraction_string($fraction) {
        $numerator_temp = explode("/", $fraction)[0];
        $denominator_temp = explode("/", $fraction)[1];
        $numerator = mt_rand(pow(10, strlen($numerator_temp) - 1), pow(10, strlen($numerator_temp)));
        $denominator = mt_rand(pow(10, strlen($denominator_temp) - 1), pow(10, strlen($denominator_temp)));
        $fraction_string = $numerator . '/' . $denominator;
        return $fraction_string;
    }

    $function_name = $_GET["function_name"] ?? "";
    if($function_name == "setQuestionsShape"){
        $user_id = $_POST["user_id"]; 
        $class = $_POST["classData"];
        $subject = $_POST["subject"];
        $topic = $_POST["topic"];
        $subtopic = $_POST["subtopic"];
        $question = $_POST['question'];
        $opt_1 = $_POST['opt_1'];
        $opt_2 = $_POST['opt_2'];
        $opt_3 = $_POST['opt_3'];
        $opt_4 = $_POST['opt_4'];
        $correct_opt = $_POST['correct_opt'];
        $shape_info = $_POST['shape_info'];

        echo json_encode(
            setQuestionsShape($user_id, $class, $subject, $topic, $subtopic, $question, $opt_1, $opt_2, $opt_3, $opt_4, $correct_opt, $shape_info)
        );
    }
    else if($function_name == "getOptionArray"){
        echo json_encode(getOptionArray($_POST["correct_opt"]));
    }
?>
