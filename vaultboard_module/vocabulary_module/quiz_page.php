<?php
    
    $dir = __DIR__;

    require_once($dir . "/functions/quiz_functions.php");

    $parentdir = dirname(dirname($dir));
    require_once($parentdir ."/connection/dependencies.php");
    require_once($parentdir ."/global/navigation.php");

    $getid = getID();
    if($getid == ""){
        header("Location: ". GLOBAL_URL ."login_page.php");
    }
    
    $universe = $_GET["universe"] ?? "words";

    $questions = json_encode(getQuestions($universe));
    $current_student = getCurrentStudent();
?>

<script>
    var quiz = <?php echo $questions; ?>;
    var universe = <?php echo json_encode($universe); ?>;
    var student = <?php echo json_encode($current_student); ?>;
</script>

<head>
	<title>Vocabulary</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="quiz-container">
  <div id="quiz">
    <div class="quiz-stats">
      <div class="timer-container">
          <span class="timer-label">Elapsed Time:</span>
          <span id="timer">00:00</span>
        </div>
        <div class="quiz-header">
          <div id="streak-div">
            Streak <span id="streak">1</span>
          </div>
          <div id="every-score">0</div>
        </div>
    </div>

    <div class="question-container">
      <div id="question"></div>
      <div id="options"></div>
    </div>
  </div>

  <div id="modal">
      <div class="modal-content-quiz">
      <div id="progress-bar">
        <div id="progress"></div>
      </div>
        <div>
          <img id="modal-icon" alt="">
        </div>
        <!-- <div id="modal-title">Congratulations!!<br>You answered correctly!</div> -->
        <div id="modal-score">
          <span id="modal-score-name">John</span>
          <span id="modal-score-number">
            <div id="modal-score-current">11450</div>
            <div id="modal-score-increment">+250</div>
          </span>
        </div>
      </div>
  </div>

  <div id="score">
    <div class="congratulations-display">
      <h1>Your Summary</h1>
    </div>
    <div id="score-display">
      <div class="score-top">
        <div class="accuracy-container">
          <h3>Accuracy:</h3>
          <div id="accuracy"></div>
        </div>
        <div class="result-score-container">
          <h3>Score:</h3>
          <div id="result-score"></div>
        </div>
      </div>
      
      <div class="performance-stats-container">
        <h2>Performance stats</h2>
        <div class="performance-stats-count">
        <div class="correct-answer-container">
          <h3>Correct Answers:</h3>
          <div id="correct-answers-count"></div>
        </div>
        <div class="incorrect-answer-container">
          <h3>Incorrect Answers:</h3>
          <div id="incorrect-answers-count"></div>
        </div>
        <div class="time-taken-container">
          <h3>Time Taken:</h3>
          <div id="time-taken-count"></div>
        </div>
        <div class="longest-streak-container">
          <h3>Longest Streak:</h3>
          <div id="longest-streaks-count"></div>
        </div>
      </div>
      </div>
    </div>
    <hr>
    <div class="result">
      <h2>Evaluation</h2>
      <table id="result-table">
        <thead>
          <tr>
            <th>Question</th>
            <th>Correct Response</th>
            <th>Evaluation</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
    <a href="index.php?universe=<?php echo $universe ?>"><button>Go back to main menu</button>
    </a>
  </div>
  </div>
</body>

<script src = "scripts/quiz_script.js"></script>
