<?php 
    include("../config/config.php");

    $boosterid = $_POST["b_id"];
    $userid = $_SESSION['id'];

    $sql_select = "SELECT * FROM booster_inventory WHERE userid = ? AND boosterid = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("ii", $userid, $boosterid);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($result->num_rows > 0) {
        // If the pair exists, update booster_count
        $sql_update = "UPDATE booster_inventory SET booster_count = booster_count + 1 WHERE userid = ? AND boosterid = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ii", $userid, $boosterid);
        $stmt_update->execute();
        $stmt_update->close();
    } else {
        // If the pair doesn't exist, insert a new row
        $sql_insert = "INSERT INTO booster_inventory (userid, boosterid, booster_count) VALUES (?, ?, 1)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ii", $userid, $boosterid);
        $stmt_insert->execute();
        $stmt_insert->close();
    }

    echo json_encode(array("status"=> "success","message"=> "Done"));
?>