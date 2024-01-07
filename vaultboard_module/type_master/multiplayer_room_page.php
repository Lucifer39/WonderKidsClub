<?php 
    $dir = __DIR__;
    require_once($dir ."/functions/multiplayer_type_racer.php");
    require_once($dir ."/main_menu_functions.php");

    $parentdir = dirname(dirname($dir));
    require_once($parentdir ."/connection/dependencies.php");
    require_once($parentdir ."/global/navigation.php");

    $getid = getID();
    if($getid == ""){
        header("Location: ". GLOBAL_URL ."login_page.php");
    }
        
    $room_code = $_GET["rc"];
    // echo $room_code;
    $room_code_js = json_encode($room_code);

    $sentences = get_room_sentences($room_code);
    // print_r($sentences);
    $sentences_js = json_encode($sentences);

    $student = get_student_main_menu();
    $student_js = json_encode($student);
?>

<script>
    var room_code = <?php echo $room_code_js; ?>;
    var texts = JSON.parse(<?php echo $sentences_js; ?>);
    var student = <?php echo $student_js; ?>;
</script>

<div class="container-main-menu mt-5">
    <audio id="typing-sound" src="assets/audio/y2mate.com - Keyboard typing sound effect.mp3" preload="auto"></audio>
    <audio id="mistyped-sound" src="assets/audio/y2mate.com - Knock knock klopfen  Sound Effect.mp3" preload="auto"></audio>

    <div class="type-tools mt-5 me-5">
        Sound: 
        <label class="toggle-switch">
          <input type="checkbox" id="sound-icon" checked>
          <span class="slider"></span>
        </label>
    </div>
    <div class="action" id="action"></div>
      <div class="dynamic-status ms-5 me-5" id="dynamic-status">
        <div class="timer-container">
          Elapsed Time: <span id="timer">0:00</span>
        </div>
        <div class="sentences-left-container" id="sentences-left-container" style="display: none">
          Sentence: <span id="sentences-left"></span>
        </div>
        <div class="countdown-container" id="countdown">
          <label>Match starts in</label>
          <span id="countdown-timer">5</span>
        </div>
        <div class="wpm-container">
          WPM: <span id="wpm">0</span>
        </div>
      </div>

      <div id="text" class="shadow mt-4"></div>
     
      <div class="input-container mt-4" id="input-container">
        <input type="text" id="input" placeholder="Start typing..." disabled style="border-radius:10px" class="shadow">
        <!-- <div class="buttons">
          <button id="start-button">Start</button>
        </div> -->
      </div>

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
          <button class="leave-room" id="leave-room">Leave Room</button>
      </div>
</div>

<script src="scripts/multiplayer_room.js"></script>