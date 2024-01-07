<?php 
    require_once("../../config/db-config.php");

    function findArea($length, $breadth){
        return $length * $breadth;
    }

    function findPerimeter($length, $breadth){
        return 2 * ($length + $breadth);
    }

    function findLengthFromArea($breadth, $area){
        return intval($area / $breadth);
    }

    function findLengthFromPerimeter($perimeter, $length){
        return intval($perimeter / 2) - $length;
    }
?>