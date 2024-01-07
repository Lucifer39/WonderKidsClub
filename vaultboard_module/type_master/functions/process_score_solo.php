<?php
    $dir = __DIR__;
    $parent = dirname($dir);
    $parentdir = dirname($parent);

    require_once($parentdir . "/connection/dependencies.php");

    require_once("type_master_functions.php");

    $data = json_decode(file_get_contents("php://input"));
    $points = $data->points;
    $wpm = $data->wpm;
    $accuracy = $data->accuracy;
    $time_taken = $data->timer;

    $student = getCurrentStudent();

    updateScores($student["id"], $points, $time_taken, $accuracy, $wpm);

?>