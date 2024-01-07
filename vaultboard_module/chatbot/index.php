<?php 
    $dir = __DIR__;
    $parentdir = dirname($dir);
    require_once($parentdir . "/connection/dependencies.php");
    require_once("functions/chatbot_functions.php");

    require_once($parentdir. "/global/navbar.php");

    $current_student = getCurrentStudent();
    $student_progress = get_user_profile_progress($current_student["id"]);
    $incompleteAdjectives = getIncompleteAdjectives($current_student["id"]);
?>

<script>
    var current_student = <?php echo json_encode($current_student); ?>;
    var student_progress = <?php echo json_encode($student_progress); ?>;
    var adjective_array_php = <?php echo json_encode($incompleteAdjectives); ?>?.adjectives.split(",");
</script>

<script>
    var current_student = <?php echo json_encode($current_student); ?>;
    var student_progress = <?php echo json_encode($student_progress); ?>;
    var adjective_array_php = <?php echo json_encode($incompleteAdjectives); ?>?.adjectives.split(",");
</script>

<script src="<?php echo $baseurl; ?>assets/js/popper.min.js"></script>
    <script src="<?php echo $baseurl; ?>assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>


<style>

:root{
    --chatbot-container-color: #9D3C72;
    --bot-message: #FFBABA;
    --user-message: #C85C8E;
    --send-button: #7B2869;
    --white: #fff;
    --blue: #4169E1;
}

.chatbot-container {
  /* height: vh; */
  width: 100vw;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  /* margin-top: 50px; */
}

.chatbot-content {
  height: 450px;
  width: 50rem;
  background-color: var(--chatbot-container-color);
  padding: 2rem;
  padding-top: 1rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  border-radius: 1rem;
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}

.chatbot-messages {
  height: 100%;
  width: auto;
  background-color: white;
  overflow-y: auto;
  padding: 1rem;
  display: grid;
  /* grid-template-rows: 70px; */
}

.message {
  /* padding: 1rem; */
  margin-bottom: -1rem;
  border-radius: 1rem;
  width: fit-content;
  height: fit-content;
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  opacity: 0;
  transform: translateY(100%); 
  animation: slideInAnimation 0.5s forwards; 
  line-height: 1rem;
}

.bot {
  justify-self: flex-start;
}

.bot .message-content{
    background-color: var(--bot-message);
}

.user .message-content{
    background-color: var(--user-message);
}

.user {
  justify-self: flex-end;
}

.message-avatar img {
    width: 2rem;
    border-radius: 50%;
}

.message-content{
    padding: 1rem;
    margin: 0.75rem;
    border-radius: 2rem;
    font-size: 0.75rem;
}

.chatbot-input-box{
    display: none;
    align-items: center;
    justify-content: space-evenly;
    padding: 0.5rem;
    width: 100%;
    /* animation: slideInAnimation 0.5s forwards;  */
}

.chatbot-send:hover{
    cursor: pointer;
}

input[type="text"] {
  width: 100%;
  padding: 0.5rem;
  border-radius: 0.5rem;
  border: none;
  margin: 1rem;
}

.chatbot-send{
    background-color: green;
    padding: 10px;
    border-radius: 50%;
    border: none;
    display: flex;
    justify-content: center;
    align-items: center;
}

.adjective-btn-chatbot img {
    height: 30px;
    width: 30px;
}

.avatar-message-img{
    height: 30px;
    width: 30px;
}

/* Smoother animation using cubic-bezier easing function */
@keyframes slideInAnimation {
  0% {
    opacity: 0;
    transform: translateY(100%);
  }
  100% {
    opacity: 1;
    transform: translateY(0%);
  }
  /* Use cubic-bezier for easing */
  /* animation-timing-function: cubic-bezier(0.645, 0.045, 0.355, 1); */
}


.chatbot-input-buttons{
  display: grid;
  grid-template-columns: repeat(6, 1fr);
  gap: 1rem;
  display: none;
}

.chatbot-input{
    width: 100%;
    display: flex;
    flex-direction: column;
    padding: 1rem;
}

.chatbot-input-buttons button{
    background-color: var(--white);
    border-radius: 1rem;
    border: 2px solid var(--blue);
    color: var(--blue);
    padding: 0.5rem;
    animation: slideInAnimation 0.5s forwards;
    font-size: 0.75rem;
}

.chatbot-input-buttons button:hover{
    cursor: pointer;
    background-color: var(--blue);
    color: var(--white);
}

.chatbot-navigation-buttons{
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 0.75rem;
    display: none;
}

.chatbot-navigation-buttons button{
    color: var(--white);
    background-color: var(--user-message);
    border-radius: 0.75rem;
    border: none;
    outline: none;
    padding: 0.75rem;
}

.chatbot-whole-container{
    position: absolute;
    top: 70px;
}

.chatbot-footer{
  width: 50%;
  align-items: center;
  flex-direction: column;
  display: none;
  text-align: right;
  color: #fff;
}

.profile-parent-container{
    width: 200px;
    background-color: #fff;
    border-radius: 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-evenly;
    padding: 0.25rem;
    overflow-y: auto;
}

.profile-header-container{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 2px solid rgb(255, 89, 148);
    border-radius: 1rem;
    padding: 1rem;
    width: 100%;
    font-size: 10px;
    text-align: center;
}

.profile-header-container h6{
    font-size: 0.75rem !important;
    margin-top: 1rem;
}

.profile-pic-header{
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 3px solid rgb(255, 89, 148);
    padding: 0.05rem;
}

@media screen and (max-width: 768px) {
    .chatbot-content {
        width: 100%;
        height: 650px;
    }

    .chatbot-input-buttons{
        grid-template-columns: repeat(3, 1fr);
    }

    .chatbot-footer{
        width: 100%;
    }
}
</style>

<div class="chatbot-whole-container">
<div class="chatbot-container">
    <div class="chatbot-content" id="chatbot-container">
        <div class="chatbot-messages" id="chatbot-messages"></div>
        <div class="chatbot-footer" id="chatbot-footer">ⓘ Click once for meaning, twice to select</div>
        <div class="chatbot-input" id="chatbot-input">
            <div class="chatbot-input-buttons" id="chatbot-input-buttons">
            </div>
            <div class="chatbot-input-box" id="chatbot-input-box">
                <input type="text" id="chatbot-input-text">
                <button class="chatbot-send" id="chatbot-send"><img src="assets/send-icon.svg"></button>
            </div>
        </div>
    </div>
</div>
</div>

<script src="chatbot.js"></script>

