<?php 
        $dir = __DIR__;
        require_once($dir ."/functions/room_joining.php");
        require_once($dir ."/waiting_room_function.php");
        require_once($dir ."/main_menu_functions.php");
        require_once($dir ."/handle_invitations.php");

        $parentdir = dirname(dirname($dir));
        require_once($parentdir ."/connection/dependencies.php");
        require_once($parentdir ."/global/navigation.php");

        $getid = getID();

        $current_url = 'http';
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
            $current_url .= "s";  
        $current_url .= "://";  
        if($_SERVER['SERVER_PORT'] != '80' && $_SERVER['SERVER_PORT'] != '443')
        {
            $current_url .= $_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
        }
        else
        {
            $current_url .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        }
        
        if($getid == ""){
            header("Location: ". GLOBAL_URL ."login_page.php?redirect=".$current_url);
        }
    
        $student = get_student_main_menu();
        $student_js = json_encode($student);
        $room_code = $_GET["rc"];
        $room_owner = $_GET["ro"] ?? 0;
        $room_type = $_GET["rt"] ?? "";

        if(checkInvite($student["id"], $room_code)){
            changeStatus($student["id"], $room_code);
        }

        $room_join_res = join_room($room_code, $student["id"], $room_owner, $room_type);
        $room_owner_id = get_room_owner($room_code);


    ?>

    <script>
        var room_code = <?php echo json_encode($room_code); ?>;
        var room_join_res = <?php echo json_encode($room_join_res); ?>;
        var type = <?php echo json_encode($room_type); ?>;
        var global_url = <?php echo json_encode(GLOBAL_URL); ?>;
        var student = <?php echo $student_js; ?>;
        var room_type = <?php echo json_encode($room_type); ?>;
    </script>

<div class="container-main-menu">
        <!-- <div class="go-back-button">
         
      </div> -->

<?php 
    if($room_join_res == "New record created successfully"){
?>

        <div class="room-info-heading-waiting mt-5">
            <h1>Waiting Room</h1>
        </div>

        <div class="right-col-wait">
                <label class="room-code-copy-label">
                    Room Code:
                </label>
                <input type="text" value=<?php echo $room_code; ?> id="room-code-copy" disabled>
                <button class="copy-code" id="copy-code">
                    <i class="bi bi-clipboard"></i>
                </button>
                <!-- <button id="copy-url">Copy url</button> -->
                <div id="myTooltip" style="visibility: hidden;">Copied!</div>
                <?php 
                    if($room_owner_id["student_id"] == $student["id"]){
                        ?>
                        <?php
                    }
                ?>
                <button id="start-game-btn" style="display: none;">Start Game</button>


        </div>
        <div class="waiting-room-content">
            <div class="left-col-wait">
                <div class="left-col-header text-dark">
                    Guest List
                </div>
                <div class="guest-list" id="guest-list"></div>
            </div>
            
            <div class="invitation-container">
                <h2>Invite People</h2>
                
                <div class="table-container-invite">
                    <!-- <div class="input-group mb-3 invite-input">
                        <input type="text" id="invite-list-filter" placeholder="Search Username...">
                    </div> -->
                    <table class="table table-dark table-striped" id="invitation">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>School</th>
                                <th>Invitation</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider"></tbody>
                    </table>
                </div>
            </div>
        </div>

        
        
       
<?php 
    }

    else if($room_join_res == "leaderboard"){

        echo "Leaderboard";
        ?>
            <div class="leaderboard">
            <div id="score-container-multiplayer" class="score-container-multiplayer">
                    <div class="table-container">
                        <table class="table table-dark table-striped" id="leaderboard-multiplayer">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>School</th>
                                    <th>Speed</th>
                                    <th>Accuracy</th>
                                    <th>Score</th>
                                    <th>Time Taken</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider"></tbody>
                        </table>
                    </div>
                    <div class="leaderboard-waiting-buttons">
                        Take a breather and wait for everyone to wrap things up,
                        or you can leave this room and compete in a new race: 
                        <br>
                        <a href="index.php"><button class="leave-room" id="leave-room">Leave Room</button></a>
                    </div>
             </div>
            </div>
        <?php
    }

    else{
        ?>
            <div class="room-info-heading">
                <h2><?php echo($room_join_res); ?></h2>
                <a href="index.php?page=play_with_friends&rt=<?php echo $room_type; ?>"><button>Go back</button></a>
            </div>
        <?php
    }
?>

</div>

<script src="scripts/waiting_room.js"></script>