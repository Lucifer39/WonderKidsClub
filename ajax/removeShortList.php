<?php 
    include( "../config/config.php" );

    $question_id = $_POST["question_id"];
    $user_id = $_POST["user_id"];

    $insertSQL = mysqli_query($conn, "DELETE FROM shortlist_questions WHERE question_id = '$question_id' AND  user_id = '$user_id'");
    mysqli_fetch_assoc($insertSQL);
?>