<?php 
  $dir = __DIR__;
  $parent = dirname($dir);
  $parentdir = dirname($parent);

  require_once($parentdir . "/connection/conn.php");
  require_once($parentdir . "/connection/dependencies.php");
  require_once("flag.php");
  
  $universe;
  function generateQuestionsIdioms($uni){
    global $universe;
    $universe = $uni;
    $table = change_topic("table", $universe);

    $conn = makeConnection();
    $question_set = array("What is the meaning of * ?");

    $sql = "SELECT * FROM $table WHERE has_question <> 1 LIMIT 500;";
    $result_words = $conn->query($sql);

    if(!$result_words){
        die("Query failed for generateQuestionsIdioms: " . $conn->error);
    }

    while($row = $result_words->fetch_assoc()){
        $questions = constructQuestionsUniverse($question_set, $row);

        //meaning
        $options = getOptionsUniverse($row["id"], "meaning");
        $answer = explode(",", $row["meaning"]);
        array_push($options, $answer[0]);
        $final_options = randomizeOptionsUniverse($options);
        sqlInsertUniverse($row["id"], $questions[0], $final_options, $answer[0]);
    }
  }

  function getOptionsUniverse($id, $option_type){
    global $universe;
    $table = change_topic("table", $universe);
    $conn = makeConnection();

    $sql = "SELECT ". $option_type ." FROM $table WHERE id <> ". $id ." ORDER BY RAND() LIMIT 3;";
    $result = $conn->query($sql);
    $response = array();

    if(!$result){
        die("Query failed for getOptionsUniverse: " . $conn->error);
    }

    while($row = $result->fetch_assoc()){
        array_push($response, $row[$option_type]);
    }

    return $response;
  }

  function randomizeOptionsUniverse($option_array){
    shuffle($option_array);
    $res = implode(",", $option_array);
    return $res;
 }

  function constructQuestionsUniverse($question_set, $data){
    global $universe;
    $questions = array();

    $array_idx = $universe == "idioms" ? "idiom" : $universe;

    $meaning_ques = str_replace("*", $data[$universe],$question_set[0]);
    array_push($questions, $meaning_ques);

    return $questions;
  }

  function sqlInsertUniverse($idiom_id, $question, $options, $answer){
    global $universe;
    $question_table = change_topic("questions", $universe);
    $id_name = change_topic("id", $universe);
    $conn = makeConnection();
    $sql = "INSERT INTO $question_table ($id_name, question, options, answer) VALUES (?,?,?,?);";

    $stmt = $conn->prepare($sql);

    // Bind the parameters to the prepared statement
    $stmt->bind_param("isss", $idiom_id, $question, $options, $answer);

    // Execute the prepared statement
    $result = $stmt->execute();

    // Check if the insert was successful
    if ($result) {
      $sql_update = "UPDATE dictionary SET has_question = 1 WHERE id = $idiom_id";
      $result_1 = $conn->query($sql_update);

      if(!$result_1){
          die("Query failed at sqlInsertUniverse: ". $conn->error);
      }
      // echo "Data inserted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }


    return;

 }

//  generateQuestionsIdioms();
?>