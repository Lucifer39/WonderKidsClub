<?php 
        $dir = __DIR__;
        require_once($dir ."/functions/room_joining.php");
        require_once($dir ."/waiting_room_function.php");
        require_once($dir . "/main_menu_functions.php");

        $parentdir = dirname(dirname($dir));
        require_once($parentdir ."/connection/dependencies.php");
        require_once($parentdir ."/global/navigation.php");

        $getid = getID();
        if($getid == ""){
            header("Location: ". GLOBAL_URL ."login_page.php");
        }
    
        $student = get_student_main_menu();
        $student_js = json_encode($student);
        $room_code = $_GET["rc"];
        $room_type = $_GET["rt"] ?? "";

        $room_join_res = join_room($room_code, $student["id"], 0, "typing_race");
        // echo $room_join_res;
    ?>

    <script>
        var room_code = <?php echo json_encode($room_code); ?>;
        var student = <?php echo $student_js; ?>;
    </script>

<div class="container-main-menu">
        <div class="go-back-button mt-4">
            <a href="index.php"><button>Main Menu</button></a>
        </div>

<?php 
    if($room_join_res == "New record created successfully"){
?>      
    <div class="d-flex justify-content-between mt-4">
        <img src="./assets/waiting.gif" width="450" height="350" style="border-radius:20%"/>
        <div>
            <div class="room-info-heading mt-4" style="margin-left:80px">
                <h2>Waiting Room</h2>
                <h3>Room starts in: <span id="room-start-timer"></span></h3>
                <h3 id="room-message"></h3>
            </div>
            <div class="waiting-room-content">
                <div class="left-col-wait">
                    <div class="left-col-header text-dark">
                        Guest List
                    </div>
                    <div class="guest-list" id="guest-list">
                    
                    </div>
                </div>
                <!-- <div class="right-col-wait">
                    Room game starts in: <span id="countdown"></span>
                </div> -->
            </div>
        </div>
    </div>

<?php 
    }

    else{
        ?>
            <div class="room-info-heading">
                <h2><?php echo($room_join_res); ?></h2>
                <a href="play_with_friends.php?rt=<?php echo $room_type; ?>"><button>Go back</button></a>
            </div>
        <?php
    }
?>

</div>

<script src="scripts/typing_race_waiting_room.js"></script>