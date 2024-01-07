<?php 
    include('../config/config.php');

    $subtopic_id = $_POST['subtopic_id'];

    $leaderboardSQL = "SELECT DISTINCT question FROM leaderboard WHERE subtopic = '$subtopic_id' ORDER BY question;";
    $leaderboardResult = mysqli_query($conn, $leaderboardSQL);

    $lb_question_ids = array();

    while($row = mysqli_fetch_assoc($leaderboardResult)) {
        $lb_question_ids[] = $row['question'];
    }

    $lb_question_ids_str = implode(", ", $lb_question_ids);

    $questionDbSQL = "SELECT id FROM count_quest WHERE subtopic = '$subtopic_ic' AND type2 IS NULL;";
    $questionResult = mysqli_query($conn, $questionDbSQL);

    $question_ids = array();

    while($row = mysqli_fetch_assoc($questionResult)) {
        $question_ids[] = $row["id"];
    }

    $question_ids_str = implode(", ", $question_ids);

    $inactQuestionSQL = "UPDATE count_quest SET status = 0 WHERE id IN ($lb_question_ids_str);";
    $inactQuestionResult = mysqli_query($conn, $inactQuestionSQL);

    $delQuestionSQL = "DELETE FROM count_quest WHERE subtopic = '$subtopic_id' AND type2 IS NULL AND id NOT IN ($lb_question_ids_str)";
    $delQuestionResult = mysqli_query($conn, $delQuestionSQL);

    $delShortlistSQL = "DELETE FROM shortlist_questions WHERE question_id IN ($question_ids_str);";
    $delShortlistResult = mysqli_query($conn, $delShortlistSQL);

?>