<?php 
    include("../config/config.php");

    $quizId = $_GET["quiz_id"];

    $nameSQL = mysqli_query($conn, "SELECT 
                                    concat(sc.pdf_class, '_', REPLACE(q.name, ' ', '_'), '_question.pdf') AS question_paper_name, 
                                    concat(sc.pdf_class, '_', REPLACE(q.name, ' ', '_'), '_answer.pdf') AS answer_paper_name 
                                    FROM quiz q
                                    JOIN subject_class sc
                                    ON sc.id = q.class
                                    WHERE q.id ='$quizId'");

    $nameRow = mysqli_fetch_assoc($nameSQL);


    $file_path = "../uploads/offline_practice/";

    if(file_exists($file_path . $nameRow["question_paper_name"]) && file_exists($file_path . $nameRow["answer_paper_name"]))
    echo json_encode(array(
        "question_papername" => $nameRow["question_paper_name"],
        "answer_papername" => $nameRow["answer_paper_name"]
    ));
?>