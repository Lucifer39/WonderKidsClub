
<?php 
    $dir = __DIR__;
    $parent = dirname($dir);
    $parentdir = dirname($parent);

    require_once($parentdir . "/connection/conn.php");
    require_once($parentdir . "/connection/dependencies.php");
    require_once("constants.php");
    require_once("flag.php");


    function getWords($universe, $day_of_week, $week){
        $conn = makeConnection();

        $getclass = getCurrentStudent();
        $getGuestClass = getGuest();
        $student_class = $getclass["class"] ?? $getGuestClass;
        $num_words = num_daily_words();

        date_default_timezone_set("Asia/Kolkata");

        $day_of_the_week = date($day_of_week);
        $table_name = change_topic("table", $universe);
        $wordset_table = change_topic("wordset", $universe);

        $sql = "SELECT word_array FROM ". $wordset_table ." WHERE relevance LIKE '%". $student_class ."%' ORDER BY timestamp DESC LIMIT 1";

        if($week == "prev"){
            $sql .= ",1";
        }
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed for getWords: " . $conn->error);
        }

        $index = 0;
        $count = 0;
        $res = $result->fetch_assoc();
        $res_array = explode(",", $res["word_array"]);

        // print_r($res_array);

        $response = array();
        // print_r(($day_of_the_week - 1) * $num_words);


        while($index < count($res_array)){
            if(($index >= ($day_of_the_week - 1) * $num_words) && $count <= $num_words){
                // echo "gotcha";
                $sql_get_word = "SELECT * FROM ". $table_name ." WHERE id = '" .$res_array[$index]. "';";
                $word_res = $conn->query($sql_get_word);

                $word = $word_res->fetch_assoc();

                array_push($response, $word);
                $count++;

                // print_r($response);
            }
            else if($count >= $num_words){
                return $response;
            }

            $index++;
        }

        return $response;
    }
?>