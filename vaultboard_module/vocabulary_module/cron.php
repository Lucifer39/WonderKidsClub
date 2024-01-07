<?php
    $dir = __DIR__;
    $parentdir = dirname($dir);

    require_once($parentdir ."/connection/conn.php");
    require_once($dir ."/functions/constants.php");
    require_once($dir. "/functions/flag.php");

    $universes = array("words", "idioms", "simile", "metaphor", "hyperbole");

    foreach($universes as $universe) {
        generateWordSet($universe);
        updateLeaderboard($universe);

        echo "Updated $universe <br>";
    }

    function generateWordSet($universe){
        $conn = makeConnection();
        $wordset_length = num_daily_words() * 7;

        $table_name = change_topic("table", $universe);
        $wordset_table = change_topic("wordset", $universe);
        $classes = array("1 class", "2 class", "3 class", "4 class", "5 class", "Prep Class");

        foreach($classes as $i){
            $sql_get_words = "SELECT id FROM ". $table_name ." WHERE relevance LIKE '%". $i ."%' ORDER BY rand() LIMIT ". $wordset_length .";";
            $result = $conn->query($sql_get_words);

            if(!$result){
                die("Query failed for generateWordSet: " . $conn->error);
            }

            $response_array = array();

            while($row = $result->fetch_assoc()){
                array_push($response_array,$row["id"]);
            }

            $worsdset = implode(",",$response_array);
            $timestamp = new DateTime();
            $sql_timestamp = $timestamp->format('Y-m-d H:i:s');

            $sql_insert_wordset = "INSERT INTO ". $wordset_table ." (word_array, relevance, timestamp) VALUES ('". $worsdset ."', '" .$i. "', '". $sql_timestamp ."');";

            $result_wordset = $conn->query($sql_insert_wordset);

            if($result_wordset !== true){
                die("Query failed for generateWordSet: " . $conn->error);
            }
        }
    }

    function updateLeaderboard($universe){
        $conn = makeConnection();

        $leaderboard = change_topic("leaderboard", $universe);
        $student_table = change_topic("student_table", $universe);

        $sql = "INSERT INTO ". $leaderboard ." (student_id, last_week_score, time_taken) ";
        $sql .= "SELECT student_id, score, time_taken FROM ". $student_table ." ";
        $sql .= "AS new_values ";
        $sql .= "ON DUPLICATE KEY ";
        $sql .= "UPDATE last_week_score = new_values.score, time_taken = new_values.time_taken;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed for updateLeaderboard: " . $conn->error);
        }

        $sql_update = "UPDATE ". $student_table ." SET score = 0, quiz_taken = 0, time_taken = 0;";

        $res = $conn->query($sql_update);

        if(!$res){
            die("Query failed for updateLeaderboard: " . $conn->error);
        }
    }
?>