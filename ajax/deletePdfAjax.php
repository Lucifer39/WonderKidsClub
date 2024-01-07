<?php 
    include( "../config/config.php" );

    $sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if($sessionrow['isAdmin'] == 1) {
        $sql = "SELECT nm.filename, sc.pdf_class FROM nomenclature_mapping nm
                JOIN subject_class sc
                ON sc.name = nm.class_name
                WHERE nm.subtopic_id = '". $_POST['subtopic_id'] . "'";

        $res = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($res)) {
            $file = '../uploads/practice/'. $row['pdf_class'] .'/'. $row['filename'];
            if(is_file($file)) {
                unlink($file);
            }
        }
    } else {
        header('Location:'.$baseurl.'');
    }
?>