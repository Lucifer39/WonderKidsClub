<link rel="stylesheet" href="main_menu.css">

<div class="main-menu-container">
    <div class="main-menu-buttons-container">
        <div class="main-menu-logo-text">
            <img src="./assets/Spellathon.png" alt="">
        </div>
        <div class="main-menu-buttons">
            <a href="./?page=practice_page"><button class="main-menu-button">Practice Yourself</button></a>

            <?php if($getid !== ""){ ?>
            <button class="main-menu-button" id="live-quiz-btn">Live Quiz</button>
            <?php  } ?>
        </div>
    </div>
    <div class="main-menu-logo">
        <img src="./assets/main_menu_logo.svg" alt="">
    </div>
</div>

<script src="scripts/main_menu_script.js"></script>