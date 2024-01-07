<?php 
    include( "../config/config.php" );

    $question_id = $_POST["question_id"];
    $user_id = $_POST["user_id"];

    $chkSQL = mysqli_query($conn, "SELECT * FROM shortlist_questions WHERE question_id = '$question_id' AND user_id = '$user_id'");
    $chkrow = mysqli_fetch_assoc($chkSQL);

    if(!isset($chkrow["id"])) {
        $insertSQL = mysqli_query($conn, "INSERT INTO shortlist_questions (question_id, user_id) VALUES ('$question_id', '$user_id')");
        mysqli_fetch_assoc($insertSQL);
    }
?>