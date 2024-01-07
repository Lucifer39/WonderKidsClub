<?php 
    include("../config/config.php");

    if($_GET['select'] == 'class_school') {
        $class_sql = mysqli_query($conn, "SELECT id, name FROM subject_class WHERE type = 2 AND status = 1");
        $classArr = array();

        while($row = mysqli_fetch_assoc($class_sql)) {
            $classArr[] = array(
                "id" => $row['id'],
                'name' => $row['name']
            );
        }

        $school_sql = mysqli_query($conn, "SELECT id, name FROM school_management WHERE status = 1");
        $schoolArr = array();

        while($row = mysqli_fetch_assoc($school_sql)){
            $schoolArr[] = array(
                'id' => $row['id'],
                'name' => $row['name']
            );
        }

        $student_sql = mysqli_query($conn, "SELECT class, school FROM users WHERE id = '". $_SESSION['id'] ."'");
        $student_row = mysqli_fetch_assoc($student_sql);

        echo json_encode(array(
            "classArr" => $classArr,
            "schoolArr" => $schoolArr,
            "student_class" => $student_row['class'],
            "student_school" => $student_row['school']
        ));
    }
?>