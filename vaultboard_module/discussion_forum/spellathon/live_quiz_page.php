<?php 
    $dir = __DIR__;
    require_once($dir . "/functions/live_quiz_functions.php");

    $room_id = $_GET["ri"] ?? "";

    if($room_id == ""){
        echo '<script>window.location.href = "'. GLOBAL_URL .'index.php";</script>';
    }

    $questions = get_room_questions($room_id);
?>

<link rel="stylesheet" href="live_quiz_page.css">

<script>
    var room_id = <?php echo json_encode($room_id); ?>;
    var data = JSON.parse(<?php echo json_encode($questions); ?>);
</script>

<div class="modal-container" id="modal-container">
    <div class="modal-content">
        <div class="modal-title-live-quiz" id="modal-title-live-quiz">Starting quiz in: </div>
        <div class="modal-body-live-quiz" id="modal-body-live-quiz">5</div>
    </div>
</div>

<div class="practice-page-container">
    <div class="timer-container">Time left: <span id="timer">00 : 00</span></div>
    <div class="question-container" id="question-container"></div>
    <div class="message-container" id="message-container"></div>

    <div class="input-group mb-3" id="input-group">
        <input type="text" class="form-control answer-input" id="answer-input" placeholder="Type you answer here..." aria-label="Recipient's username" aria-describedby="button-addon2">
        <button class="btn btn-success" type="button" id="submit-btn">Submit</button>
    </div>
    <!-- <div class="navigation-buttons">
        <button class="next-btn" id="next-btn">Next <i class="bi bi-arrow-right-short"></i></button>
    </div> -->
</div>

<script src="scripts/live_question_script.js"></script>
