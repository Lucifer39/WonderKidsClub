<?php 
  $dir = __DIR__;
  require_once($dir . "/functions/type_master_functions.php");
  require_once("functions/main_menu_functions.php");

  $parentdir = dirname(dirname($dir));
    require_once($parentdir ."/connection/dependencies.php");
    require_once($parentdir ."/global/navigation.php");

    $getid = getID();
    // if($getid == ""){
    //     header("Location: ". GLOBAL_URL ."login_page.php");
    // }

  $texts = getSentences(1);
  $texts_script = json_encode($texts);

  if($getid !== "")
  $student = get_student_main_menu() ?? "";
  
?>
<script>
      var texts = <?php echo $texts_script; ?>;
</script>

<!-- <!DOCTYPE html>
<html>
  <head>
    <title>Simple Type Racer</title>
    <link rel="stylesheet" href="style.css">

    
  </head>-->
    <audio id="typing-sound" src="assets/audio/y2mate.com - Keyboard typing sound effect.mp3" preload="auto"></audio>
    <audio id="mistyped-sound" src="assets/audio/y2mate.com - Knock knock klopfen  Sound Effect.mp3" preload="auto"></audio>
    <div class="container">
      <!-- <div class="header">Type Racer</div> -->
      <div class="go-back-button mt-5">
        <a href="index.php"><button>Main Menu</button></a>
      </div>
      <div class="type-tools">
        Sound: 
        <label class="toggle-switch">
          <input type="checkbox" id="sound-icon" checked>
          <span class="slider"></span>
        </label>

      </div>
      <div class="action">
        <div class="actors" id="actors">
          <div id="rocket" class="rocket">
            <span><?php echo explode(" ", $student["name"])[0] ?? "Guest"; ?>(You)</span>
            <img src= "assets/avatars/<?php echo $student['avatar'] ?? 'default-icon.svg'; ?>" alt="rocket" id="rocket-ship" class="rocket-ship">
          </div>
          <div id="zorgon">
            <img src="assets/zorgon_svg.svg" alt="zorgon" id="zorgon-monster" class="zorgon-monster">
          </div>
        </div>
        <div class="track" id="track"></div>
      </div>
      <div class="dynamic-status">
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

      <div class="type-master-buttons-container">
        <button class="type-master-buttons-end" id="main-menu-button-end">Main Menu</button>
        <button class="type-master-buttons-end" id="restart-button">Restart</button>
      </div>
      
      <div id="text" class="shadow"></div>
     
      <div class="input-container mt-4" id="input-container">
        <input class="shadow" type="text" id="input" placeholder="Start typing..." disabled style="border-radius:10px">
        <!-- <div class="buttons">
          <button id="start-button">Start</button>
        </div> -->
      </div>

      <div class="score-container" id="score-container">
        <div class="score-header">
          Your stats
        </div>
        <div id="score" class="score">
            <div class="score-stats">Time: <span class="score-stats-number" id="time">0</span></div>
            <div class="score-stats">Your speed: <span class="score-stats-number" id="wpm-score">0</span></div>
            <div class="score-stats">Accuracy: <span class="score-stats-number" id="accuracy">0</span></div>
            <div class="score-stats">Points: <span class="score-stats-number" id="points">0</span></div>
        </div>
      </div>
      
    </div>
    <script src="scripts/scripts.js"></script>
