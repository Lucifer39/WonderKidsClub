<?php 
    require_once("../global/navbar.php");

    $getid = getID();
    $getGuest = getGuest();
    if($getid == "" && $getGuest == ""){
        echo '<script>window.location.href = "'. GLOBAL_URL .'index.php";</script>';
    }

    $page = $_GET["page"] ?? "main_menu";
    $class_group = getClassGroup();
?>

<script>
    var classGroup = <?php echo json_encode($class_group["group_name"]); ?>;
</script>

<link rel="stylesheet" href="index.css">

<div class="container">
    <?php
        if($page == "main_menu"){
            require_once("main_menu.php");
        }
        else if($page == "practice_page"){
            require_once("practice_page.php");
        }
        else if($page == "waiting_room_page"){
            require_once("waiting_room_page.php");
        }
        else if($page == "live_quiz_page"){
            require_once("live_quiz_page.php");
        }
        else if($page == "leaderboard_page"){
            require_once("leaderboard_page.php");
        }
    ?>
</div>