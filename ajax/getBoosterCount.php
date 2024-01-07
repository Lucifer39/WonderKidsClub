<?php 
    include("../config/config.php");

    $sql = "SELECT bi.booster_count, b.booster_icon, b.id, b.booster_name 
            FROM booster_inventory bi
            JOIN boosters b
            ON b.id = bi.boosterid
            WHERE bi.userid = '" . $_SESSION['id'] . "'
            AND bi.booster_count > 0 ;";

    $result = mysqli_query($conn, $sql);
    $boosters_arr = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $boosters_arr[] = $row;
    }

    echo json_encode($boosters_arr);
?>