<?php 
    $getModal = getGuestModal();
    if($getid == "" && !$getModal && $getGuest !== ""){
        require_once("../global/guest_modal.php");
    }

    if($getid !== ""){
?>
<script>
    var leaderboard = <?php echo $myJson; ?>;

    leaderboard.forEach((object, index) => {
        // Assign rank to the "rank" property
        object.rank = index + 1;
    });

    var current_student = <?php echo $student_JSON ?>;
</script>

<?php } ?>

    <div class="container p-4" style="text-align:center;">
        <h2 class="p-1 header-title-mainmenu"><b>Know Your <?php echo $universe; ?></b></h2><br/>
        <div class="row gy-1 justify-content-center">
            <div class="col-sm-6 main-menu-words-button">
                <a href="index.php?page=dictionary&universe=<?php echo $universe; ?>">
                    <button class="index-buttons">
                        <img src="assets/idiom.svg" alt=""><br/><br/>
                        Today's <?php echo $universe; ?>
                    </button>
                </a>
            </div>
            <div class="col-sm-6">
                <?php if($getid !== "") { ?>
                    <form method="post" class="leaderboard-button">
                <?php } else {?>
                    <a href="#" class="leaderboard-button" data-bs-toggle="modal" data-bs-target="#loginModal" data-card="vocabulary_module">
                <?php } ?>
                    <button type="submit" name="show-leaderboard" value="Last week's leaderboard" class="index-buttons">
                        <img src="assets/leaderboard.svg" alt=""><br/><br/>
                        Leaderboard <?php if($getid==""){ ?> <i class="bi bi-lock-fill"></i> <?php } ?>
                    </button>
                    
                <?php if($getid !== "") { ?>
                    </form>
                <?php } else {?>
                    </a>
                <?php } ?>
            </div>
            <div class="col-sm-6">
                <?php if($getid !== "") { ?>
                    <a href="index.php?page=quiz&universe=<?php echo $universe; ?>">
                <?php } else {?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-card="vocabulary_module">
                <?php } ?>
                    <button <?php if($getid !== "" && checkQuizTaken($universe) == 1) echo "disabled" ?> class="index-buttons">
                        <img src="assets/quiz.svg" alt=""><br/>
                        This week's quiz <?php if($getid==""){ ?> <i class="bi bi-lock-fill"></i> <?php } ?>
                    </button>
                </a>
            </div>
        </div>
    </div>
    
    <div class="container">
        <?php if(isset($_POST["show-leaderboard"])){ ?>
            <div class="leaderboard-container-box">
                <div class="homepage-leaderboard">
                    <form method="post">
                        <input type="submit" name="close-leaderboard" value="&times;" class="close-leaderboard">
                    </form>
                    <h2>Leaderboard</h2>

                    <?php if(!isset($_POST["close-leaderboard"])){ ?>
                        <div>
                            <div class="search-filter">
                                <input type="text" id="search" placeholder="Search...">
                                <div class="leaderboard-buttons-container">
                                    <button class="leaderboard-filter-buttons" id="all-button">Everyone</button>
                                    <button class="leaderboard-filter-buttons" id="same-school-button">Your School</button>
                                </div>
                            </div>
                        <div class="leaderboard-container">
                            <table class="table" id="leaderboard">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Name</th>
                                        <th>Score</th>
                                        <th>Time Taken</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } } ?>
    </div>

    <?php if($getid !== ""){ ?>
        <script src="scripts\homepage_script.js"></script>
    <?php } ?>
