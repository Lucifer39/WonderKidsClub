<?php 
    $dir = __DIR__;
    $parentdir = dirname($dir);
    require_once($parentdir ."/connection/dependencies.php");
    require_once($parentdir ."/global/navigation.php");

    $getid = getID();
    if($getid == ""){
        header("Location: ". GLOBAL_URL ."login_page.php");
    }

    $room_type = $_GET["rt"];
?>

<script>
    var type = <?php echo json_encode($room_type); ?>;
</script>



<div class="container-main-menu">
    <div class="room-info-heading">
        <h2>Room Info</h2>
    </div>
    <p>
            Welcome to the exhilarating world of Type Racing! Prepare to showcase your typing prowess and challenge your 
            friends to epic typing duels. Create your own racing room, invite your pals, and get ready for the ultimate 
            test of speed and accuracy. Zoom through captivating race tracks, typing out words and sentences as fast as 
            you can to cross the finish line first. With real-time multiplayer action and thrilling power-ups, 
            Type Racing guarantees heart-pounding excitement and friendly competition. Are you up for the challenge? 
            It's time to prove your typing skills and claim victory in the most thrilling typing game around! 🚀🏁
        </p>
    <div class="input-form">
        <!-- <label for="sentence-count">Max Sentence count: </label> -->
        <input type="hidden" min="2" max="10" id="sentence-count-input" placeholder="Upto 10" value=2>
        <button class="room-button" id="create-room-btn">Create a room</button>
    </div>
</div>

<script src="scripts/room_generation_script.js"></script>