<?php 
    include( "../config/config.php" );

    $subtopic_id = $_GET["subtopic_id"];

    $mappingsql = mysqli_query($conn, "SELECT nm.filename, ts.subtopic, sc.pdf_class FROM nomenclature_mapping nm
                                        JOIN topics_subtopics ts
                                        ON nm.subtopic_id = ts.id
                                        JOIN subject_class sc
                                        ON ts.class_id = sc.id
                                        WHERE ts.id = '$subtopic_id'");

    $res_array = array();
    while($mappingrow = mysqli_fetch_assoc($mappingsql)){

        $file_path = "../uploads/practice/" . $mappingrow["pdf_class"] . "/" . $mappingrow["filename"];

        // echo $file_path . "<br>";
        if(file_exists($file_path)){
            $res_array[] = array(
                "filename" => $mappingrow["filename"],
                "subtopic" => $mappingrow["subtopic"],
                "pdf_class" => $mappingrow["pdf_class"]
            );
        }
    }

    echo json_encode($res_array);
?>