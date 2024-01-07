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

    <div class="go-back-button mt-5">
        <a href="index.php"><button>Main Menu</button></a>
      </div>
    <div class="against-friends-quote">
        <p>
            <span style="font-weight:bold;text-shadow: 4px 4px 3px #77f;">You and your friends</span> have been chosen as the <span style="font-weight:bold;text-shadow: 4px 4px 3px #77f;">elite space pilots</span> to take down the evil alien overlord, Zorgon. 
            Your mission is to launch your rocket ship and blast your way through Zorgon's fleet, <span style="font-weight:bold;text-shadow: 4px 4px 3px #77f;">typing out the correct 
            commands</span> to fire your weapons and dodge incoming attacks. With <span style="font-weight:bold;text-shadow: 4px 4px 3px #77f;">each word typed correctly, your ship advances 
            closer</span> to Zorgon's lair, where you will face the ultimate showdown. But be warned, Zorgon's minions are relentless 
            and will do everything in their power to stop you. Can you and your friends work together to defeat Zorgon 
            and save the galaxy from his tyranny?
        </p>
    </div>
    <div class="input-form">
        <input type="text" name="room-code-input" class="shadow" id="room-code-input" placeholder="Enter room code..." style="border-radius:10px">
        <button class="room-button" id="room-button" disabled>Join a room</button>
        <!-- <a href="index.php?page=room_creation_page&rt=<?php echo $room_type; ?>"><button class="room-button">Create a room</button></a> -->
        <button class="room-button" id="create-room-btn">Create a room</button>
    </div>
</div>

<script src="scripts/play_with_friends.js"></script>
<script src="scripts/room_generation_script.js"></script>