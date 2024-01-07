<?php 
    require_once("questions.php");
    require_once("questions_idioms.php");

    function routeQuestions($universe){
        $conn = makeConnection();

        $table_name = change_topic("table", $universe);

        if($universe == "words"){
            generateQuestions();
        }
        else{
            generateQuestionsIdioms($universe);
        }

        $sql_next_batch = "SELECT * FROM $table_name WHERE has_question <> 1 LIMIT 10;";
        $result = $conn->query($sql_next_batch);

        if(mysqli_num_rows($result) > 0){
            header("Location: vocab_admin_page.php?universe=$universe");
            exit();
        }
        else{
            echo "Data transfer successful!";
        }
    }
?>