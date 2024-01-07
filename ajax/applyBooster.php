<?php 
    include("../config/config.php");

    if(isset($_POST["booster_id"]) && !isset($_SESSION['power-up'])){ 
        $sql = "SELECT * FROM boosters WHERE id = '" . $_POST['booster_id'] . "'" ;
        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_assoc($result);

        $_SESSION['power-up-timer'] = intval($row['booster_timer']);
        $_SESSION['destination-timer'] = time() + intval($row['booster_timer']);
        $_SESSION['minimum-time'] = intval($row['minimum_time']);
        $_SESSION['score-multiplier'] = floatval($row['score_multiplier']);
        $_SESSION['incorrect-score-multiplier'] = floatval($row['incorrect_score_multiplier']);
        $_SESSION['power-up'] = $row['id'];
        $_SESSION['booster-points'] = 0;
        $_SESSION['normal-points'] = 0;

        $countSQL = "UPDATE booster_inventory 
                    SET booster_count = booster_count - 1
                    WHERE userid = '". $_SESSION["id"] . "' 
                    AND boosterid = '" . $_POST['booster_id'] . "'";
        
        $countResult = mysqli_query($conn, $countSQL);

        echo json_encode(array('content'=> 'You are using ' . $row['booster_name'], 'imgBanner' => $row['booster_icon']));
    }
?>