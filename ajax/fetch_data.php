<?php
ini_set('memory_limit ', '-1');
include("../config/config.php");

// Fetch and process the necessary data
$data = $_GET['id'];  // Retrieve the data using your own logic

$qury = mysqli_query($conn, "SELECT ts.parent,ts.subtopic,ts.class_id,nm.filename 
                            FROM topics_subtopics ts
                            JOIN nomenclature_mapping nm
                            ON nm.subtopic_id = ts.id
                            WHERE ts.id='".str_replace('"', '', $data)."'");
$result = mysqli_fetch_assoc($qury);

$topicQury = mysqli_query($conn, "SELECT topic FROM topics_subtopics WHERE id='". $result["parent"] ."'");
$topic = mysqli_fetch_assoc($topicQury);

$classQury = mysqli_query($conn, "SELECT name FROM subject_class WHERE id = '". $result['class_id'] ."'");
$class_name = mysqli_fetch_assoc($classQury);

$paperQuery = mysqli_query($conn, "SELECT 
                                    concat(sc.pdf_class, '_', REPLACE(q.name, ' ', '_'), '_question.pdf') AS question_paper_name, 
                                    concat(sc.pdf_class, '_', REPLACE(q.name, ' ', '_'), '_answer.pdf') AS answer_paper_name 
                                    FROM quiz q
                                    JOIN subject_class sc
                                    ON sc.id = q.class
                                    WHERE q.id ='".str_replace('"', '', $data)."'");
$paperRow = mysqli_fetch_assoc($paperQuery);

// var_dump($result);

// Encode the data as JSON and send it back to the client
echo json_encode(
    array(
        "data" => $data,
        "subtopic" => $result["subtopic"] ?? "",
        "topic" => $topic["topic"] ?? "",
        "class" => $class_name["name"] ?? "",
        "filename" => $result["filename"] ?? "",
        "question_papername" => $paperRow["question_paper_name"] ?? "",
        "answer_papername" => $paperRow["answer_paper_name"] ?? ""
    )
);
?>