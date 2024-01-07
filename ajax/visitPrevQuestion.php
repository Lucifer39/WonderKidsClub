<?php 
    include("../config/config.php");

    $userid = $_POST["user_id"];
    $class = $_POST["class"];
    $subject = $_POST["subject"];
    $topic = $_POST["topic"];
    $subtopic = $_POST["subtopic"];
    $question = $_POST["question"];

    $sql = mysqli_query($conn, "SELECT question 
                                FROM leaderboard 
                                WHERE userid = '". $userid ."'
                                AND class = '". $class ."' 
                                AND subject = '". $subject ."'
                                AND topic = '". $topic ."'
                                AND subtopic = '". $subtopic ."'
                                AND question < '". $question ."'
                                ORDER BY id DESC
                                LIMIT 1");

    $row = mysqli_fetch_assoc($sql);

    $_SESSION["prev_ques"] = array(
        "class" => $class,
        "subject" => $subject,
        "topic" => $topic,
        "subtopic" => $subtopic,
        "question" => $row["question"]
    );
?>