<?php 
    $dir = __DIR__;
    require_once($dir ."/functions/waiting_room_functions.php");

    $assign_room_res = assign_room($getid, $class_group["group_name"]);
    echo $assign_room_res;

    if($assign_room_res == "No rooms present"){
        echo '<script>window.location.href = "'. GLOBAL_URL .'spellathon/";</script>';
    }

    $room_keeper = get_time_keeper($assign_room_res);
?>

<link rel="stylesheet" href="waiting_room_page.css">

<script>
    var room_id = <?php echo json_encode($assign_room_res) ?>;
    var isTimeKeeper = <?php echo json_encode($room_keeper == $getid); ?>;
</script>

<div class="waiting-room-container">
    <h1 class="waiting-room-header">Waiting Room</h1>

    <div class="waiting-room-content">
        <div class="waiting-room-background">
            <div class="spinner-border text-success" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="time-left-container">Starting in: <span id="time-left">00</span></div>
        </div>
        <div class="waiting-players-container">
            <div class="waiting-players-header">
                Waiting Players
            </div>
            <div class="waiting-players-list" id="waiting-players-list"></div>
        </div>
    </div>
</div>

<script src="scripts/waiting_room_page_script.js"></script>