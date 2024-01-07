<?php 
    include("../config/config.php");
    if($_GET['power_up']) {
        unset($_SESSION['power-up-timer']);
        unset($_SESSION['destination-timer']);
        unset($_SESSION['minimum-time']);
        unset($_SESSION['score-multiplier']);
        unset($_SESSION['incorrect-score-multiplier']);
        unset($_SESSION['power-up']);
        unset($_SESSION['normal-points']);
        unset($_SESSION['booster-points']);        
    }
?>