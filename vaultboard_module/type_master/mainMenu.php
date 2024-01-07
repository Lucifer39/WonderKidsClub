<?php 
    $dir = __DIR__;
    
    require_once($dir ."/functions/main_menu_functions.php");

    $parentdir = dirname(dirname($dir));
    require_once($parentdir ."/connection/dependencies.php");
    require_once($parentdir ."/global/navigation.php");

    $getid = getID();
    // $getGuest = getGuest();
    // if($getid == "" && $getGuest == ""){
    //     header("Location: ". GLOBAL_URL ."index.php");
    // }
    $get_guest_modal = getGuestModal();

    if($getid == "" && !$get_guest_modal){
        require_once("../global/guest_modal.php");
    }

    if($getid !== ""){
        $student = get_student_main_menu();
        $student_js = json_encode($student);

        $leaderboard = getLeaderboard($student["id"]);
        $leaderboard_js = json_encode($leaderboard);
    }
?>

<script>
    var user_det = <?php echo $student_js ?? "{}"; ?>;
    var leaderboard = <?php echo $leaderboard_js ?? "[]"; ?>;

    leaderboard.forEach((element, index) => {
        element.rank = index + 1;
    });

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>


<div class="container-main-menu">
    
    <div class="main-menu-content">
        <div class="right-col">
            <?php 
                $attr = "id='typing-race-btn'";

                if($getid == ""){
                    $attr = 'data-bs-toggle="modal" data-bs-target="#loginModal" data-card="typing"';
                }
            ?>
            <button <?php echo $attr; ?> class="main-menu-button mainmenubtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Compete against random friends">
                Enter a typing race <?php if($getid==""){ ?> <i class="bi bi-lock-fill"></i> <?php } ?>
            </button>
            <a href="index.php?page=practice_yourself" data-bs-toggle="tooltip" data-bs-placement="top" title="Practice by yourself in offline mode">
                <button class="main-menu-button mainmenubtn">Practice Yourself</button>
            </a>
            <?php if($getid !== "") { ?>
                <a class="mainmenubtn" href="index.php?page=play_with_friends&rt=live_room" data-bs-toggle="tooltip" data-bs-placement="top" title="Invite your friends and race against them">
            <?php } else {?>
                    <a href="#" class="mainmenubtn" data-bs-toggle="modal" data-bs-target="#loginModal" data-card="typing" data-bs-toggle="tooltip" data-bs-placement="top" title="Invite your friends and race against them">
            <?php } ?>
                <button class="main-menu-button mainmenubtn">Friendly Race <?php if($getid==""){ ?> <i class="bi bi-lock-fill"></i> <?php } ?> </button>
            </a>
            <?php if($getid !== "") { ?>
                <a class="mainmenubtn" href="index.php?page=play_with_friends&rt=offline_challenge" data-bs-toggle="tooltip" data-bs-placement="top" title="Create a room which stay open for 24hours">
            <?php } else {?>
                    <a class="mainmenubtn" href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-card="typing" data-bs-toggle="tooltip" data-bs-placement="top" title="Invite your friends and race against them">
            <?php } ?>
                <button class="main-menu-button mainmenubtn">Challenges <?php if($getid==""){ ?> <i class="bi bi-lock-fill"></i> <?php } ?></button>
            </a>
            <?php if($getid !== "") { ?>
                <a class="mainmenubtn" href="index.php?page=history" data-bs-toggle="tooltip" data-bs-placement="top" title="View your racing history">
            <?php } else {?>
                    <a class="mainmenubtn" href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-card="typing" data-bs-toggle="tooltip" data-bs-placement="top" title="Invite your friends and race against them">
            <?php } ?>
                <button class="main-menu-button mainmenubtn">History <?php if($getid==""){ ?> <i class="bi bi-lock-fill"></i> <?php } ?></button>
            </a>            
        </div>
        <div class="redesign-container">
            <div class="left-col">
                <div class="main-menu-screen"> 
                    <div id="loader">
                        <div class="loading-text">
                            <span class="loading-text-words">Loading</span>
                            <div class="loading-text-dots">
                            <span class="loading-text-dot"></span>
                            <span class="loading-text-dot"></span>
                            <span class="loading-text-dot"></span>
                            </div>
                        </div>
                    </div>

                    <span id="user-details"></span>
                    <span class="cursor"></span>

                </div>
            </div>
            <p class="main-menu-story p-4">Welcome, <span style="font-weight:bold;text-shadow: 4px 4px 3px #77f;">space cadets!</span> The fate of the galaxy is in your hands! 
                    The evil <span style="font-weight:bold;text-shadow: 4px 4px 3px #77f;">Zorgon Empire</span> has launched an attack on our peaceful planets and we need your help to save them. 
                    But fear not, for your <span style="font-weight:bold;text-shadow: 4px 4px 3px #77f;">typing skills</span> are the key to victory! 
                    By <span style="font-weight:bold;text-shadow: 4px 4px 3px #77f;">practising on our website</span>, you can practice your <span style="font-weight:bold;text-shadow: 4px 4px 3px #77f;">typing speed and accuracy, and become a master of the keyboard</span>. 
                    With your lightning-fast fingers, you can help us <span style="font-weight:bold;text-shadow: 4px 4px 3px #77f;">send messages to our allies </span>and <span style="font-weight:bold;text-shadow: 4px 4px 3px #77f;">coordinate our counter-attack</span>. 
                    Every word you type brings us one step <span style="font-weight:bold;text-shadow: 4px 4px 3px #77f;">closer to victory!</span> 
                    So, put on your space helmets and let's save the galaxy together!
            </p>
        </div>

        <?php 
            if($getid !== ""){
        ?>
        <div class="leaderboard-container">
            <div class="leaderboard-header">
                <div class="leaderboard-button-container">
                    <button class="leaderboard-buttons" id="everyone-button">Everyone</button>
                    <!-- <button class="leaderboard-buttons" id="same-class-button">Your Class</button> -->
                    <button class="leaderboard-buttons" id="same-class-same-school-button">Your School</button>
                </div>
                <div class="search-leaderboard input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" id="search-username" placeholder="Search Username..." aria-label="Search" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="table-container">
                <table class="table table-dark" id="leaderboard">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>School</th>
                            <th>Speed</th>
                            <th>Accuracy</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider"></tbody>
                </table>
            </div>
        </div>

        <?php } ?>
    </div>
</div>

<script src="scripts/main_menu_script.js"></script>