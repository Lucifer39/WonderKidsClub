<?php 
    include("../config/config.php");

    $sql_part = "";

    if(isset($_POST["booster_id"])){
        $sql_part = "WHERE b.id = ". $_POST['booster_id'];
    }

    $sql = "SELECT b.booster_info, b.booster_icon , bc.info
            FROM booster_criteria bc
            JOIN boosters b 
            ON bc.booster = b.id
            $sql_part;";
    $result = mysqli_query($conn, $sql);

    $arr = array();
    while($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
    }

    echo json_encode($arr);
?>