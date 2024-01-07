<?php 
    include("config/config.php");
    include("functions.php");
    
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $room_id = $_POST['room_code'];
    }

    $getRankingSQL = mysqli_query($conn, "SELECT brp.user_id, brp.score, u.fullname, sm.name AS school, sc.name AS class, u.avatar,
                                        RANK() OVER (ORDER BY brp.score DESC) AS ranking
                                        FROM battle_room_players brp
                                        JOIN users u ON brp.user_id = u.id
                                        JOIN school_management sm ON u.school = sm.id
                                        JOIN subject_class sc ON u.class = sc.id
                                        WHERE room_id = '$room_id' AND left_room = 0
                                        ORDER BY score DESC");
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 p-2">
            <div class="leaderboard-wrapper">
                <div class="mb-3 text-md-start text-center d-flex flex-md-row flex-column align-items-center">
                    <h2 class="section-title flex-1 mb-2">Leaderboard <span class="note ms-1">- Battles</span></h2>
                </div>
                <ul class="leaderboard-list overallwise mb-5">
                    <?php 
                        while($getRankingRow = mysqli_fetch_assoc($getRankingSQL)) {
                            ?>
                                <li class="<?php echo $getRankingRow['user_id'] == $_SESSION['id'] ? "selected" : ""; ?>">
                                                                    <div class="data pe-0">
                                                                        <img class="featured1" src="<?php echo isset($getRankingRow["avatar"]) ? $baseurl . "assets/images/avatars/" . $getRankingRow["avatar"] : "assets/images/profile.jpg" ?>" width="25" height="25" alt="">
                                                                    </div>
                                                                    <div class="data w-100 text-center p-1">
                                                                        <div class="font15"><?php echo $getRankingRow['fullname'] ?? "Test"; ?></div>
                                                                        <!-- <div class="font13 txt-grey"><?php echo $schrow['name'] ?? "BVB Vidya School"; ?></div> -->
                                                                    </div>
                                                                    <div class="data text-center">
                                                                        <div class="font15"><?php echo $getRankingRow['score'] ?? 100; ?></div>
                                                                        <div class="font13 txt-grey">Score</div>
                                                                    </div>
                                                                    <div class="data text-center flex-1">
                                                                        <div class="font15"><?php echo $getRankingRow['ranking'] ?? 1; ?></div>
                                                                        <div class="font13 txt-grey">Rank</div>
                                                                    </div>
                                                                </li>
                            <?php
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div> 