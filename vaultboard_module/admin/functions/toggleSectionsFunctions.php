<?php 
    $dir = __DIR__;
    $parentdir = dirname(dirname($dir));
    require_once($parentdir. "/connection/dependencies.php");

    function getSections() {
        $conn = makeConnection();

        $sql = "SELECT * FROM toggle_section_config;";
        $result = $conn->query($sql);

        if(!$result) {
            die("Query failed at getSections: ". $conn->error);
        }

        $fin_array = array();

        while($row = $result->fetch_assoc()) {
            $fin_array[] = $row;
        }

        return $fin_array;
    }

    function setToggle($id, $enable) {
        $conn = makeConnection();

        $sql = "UPDATE toggle_section_config
                SET enable = $enable
                WHERE id = $id ;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at setToggle: ". $conn->error);
        }

        return true;
    }

    function getSpecificSection($section) {
        $conn = makeConnection();

        $sql = "SELECT enable FROM toggle_section_config WHERE section = '$section';";
        $result = $conn->query($sql);

        if(!$result) {
            die("Query failed at getSpecificSection: ". $conn->error);
        }

        $ans = $result->fetch_assoc();
        return $ans["enable"];
    }

    $function_name = $_GET["function_name"] ?? "";
    if($function_name == "setToggle") {
        echo json_encode(setToggle($_POST["id"], $_POST["enable"]));
    }
?>