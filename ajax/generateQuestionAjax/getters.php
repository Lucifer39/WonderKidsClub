<?php 
    $dir = __DIR__;
    $parentdir = dirname(dirname($dir));
    require_once($parentdir ."/config/config.php"); // Include the connection file

    function checkQuestion($question)
    {
        global $conn; // Access the global $conn object
        
        try {
            $query = "SELECT * FROM count_quest WHERE question = '$question';";
            
            $result = mysqli_query($conn, $query);
            if (!$result) {
                exit('Database error: ' . mysqli_error($conn));
            }
            
            return mysqli_num_rows($result);
            
        } catch (Exception $e) {
            echo $e;
            exit('Database error.');
        }
    }

    function checkQuestionTime($question, $hour, $minute){
        global $conn;

        try{
            $query = "SELECT * FROM count_quest 
                        WHERE question = '$question'
                        AND shape_info LIKE '%\"hour\":\"$hour\"%'
                        AND shape_info LIKE '%\"minute\":\"$minute\"%'";

            $result = mysqli_query($conn, $query);
            if (!$result) {
                exit('Database error: ' . mysqli_error($conn));
            }

            return mysqli_num_rows($result);
            
        } catch (Exception $e) {
            echo $e;
            exit('Database error.');
        }
    }

    function checkQuestionPerimeter($st_id, $coordinates){
        global $conn;
        
        try{
            $query = "SELECT * FROM count_quest
                      WHERE subtopic = $st_id
                      AND shape_info LIKE '%$coordinates%'";

            $result = mysqli_query($conn, $query);
            if (!$result) {
                exit('Database error: ' . mysqli_error($conn));
            }

            return mysqli_num_rows($result);
        }
        catch (Exception $e) {
            echo $e;
            exit('Database error.');
        }
    }

    function countQuestions($st_id){
        global $conn;
        
        try {
            $query = "SELECT * FROM count_quest WHERE subtopic = '$st_id';";
            
            $result = mysqli_query($conn, $query);
            if (!$result) {
                exit('Database error: ' . mysqli_error($conn));
            }

            return mysqli_num_rows($result);
            
        } catch (Exception $e) {
            echo $e;
            exit('Database error.');
        }
    }

    $function_name = $_GET["function_name"] ?? "";
    if($function_name == "checkQuestion"){
        echo json_encode(checkQuestion($_POST["question"]));
    }
    else if($function_name == "checkQuestionTime"){
        echo json_encode(checkQuestionTime($_POST["question"], $_POST["hour"], $_POST["minute"]));
    }
    else if($function_name == "checkQuestionPerimeter"){
        echo json_encode(checkQuestionPerimeter($_POST["st_id"], $_POST["coordinates"]));
    }

    // echo countQuestions(24);

?>
