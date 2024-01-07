<?php
    $dir = __DIR__;
    $parentdir = dirname(dirname($dir));

    require_once($parentdir. "/vocabulary_module/functions/questions.php");
    require_once($parentdir. "/vocabulary_module/functions/flag.php");
    function insertCSVDataToDB($data, $uni){
        $conn = makeConnection();
        global $universe;
        $universe = $uni;
        $table_name = change_topic( "table", $universe);
        $main_col = change_topic("main_table_col", $universe);

        foreach($data as $row){
            $sql_find = "SELECT id FROM $table_name WHERE $main_col = '". $row->word ."' LIMIT 1;";
            $result_find = $conn->query($sql_find);
            if(!$result_find){
                die("Query failed at insertCSVDataToDB: " . $conn->error);
            }

            if(mysqli_num_rows($result_find) == 0){
                continue;
            }

            $res_find = $result_find->fetch_assoc();

            $options = getOptions($res_find["id"], "antonyms");
            $answer = $row->answer;
            array_push($options, $answer);
            $final_options = randomizeOptions($options);
            sqlInsert($res_find["id"], $row->question, $final_options, $answer);
        }
    }

    $function_name = $_GET["function_name"] ?? "";
    if($function_name == "insertCSVDataToDB"){
        echo json_encode(insertCSVDataToDB(json_decode($_POST["data"]), $_POST["universe"]));
    }


?>