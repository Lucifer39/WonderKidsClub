<?php

    $dir = __DIR__;
    require_once($dir . "/functions/homepage_functions.php");

    $parentdir = dirname(dirname($dir));
    // require_once($parentdir ."/global/navigation.php");
    include($parentdir.'/global/navbar.php');

   $getid = getID();
    $getGuest = getGuest();
    if($getid == "" && $getGuest == ""){
        echo '<script>window.location.href = "'. GLOBAL_URL .'index.php";</script>';
    }

    
    $universe = $_GET["universe"] ?? "words";
    
    

    if($getid !== ""){
        $current_student = getCurrentStudent();
        $student_JSON = json_encode($current_student);

        $leaderboard = getLeaderboard($universe, $current_student["id"]);
        $myJson = json_encode($leaderboard);
    }

    class Li_nav{
        public $link_name;
        public $link;
        public function __construct($link_name, $link){
            $this->link_name = $link_name;
            $this->link = $link;
        }
    }

    $link_name_array = array("Words", "Idioms", "Simile", "Metaphors", "Hyperbole");
    $link_array = array("words", "idioms", "simile", "metaphor", "hyperbole");
    $nav_array = array();

    for($i = 0; $i < count($link_name_array); $i++){
        $obj = new Li_nav($link_name_array[$i], $link_array[$i]);
        array_push($nav_array, $obj);
    }
    
    if($getid !== ""){
?>

<script>
    var leaderboard = <?php echo $myJson; ?>;
    var current_student = <?php echo $student_JSON ?>;
</script>

<?php } ?>

<head>
    <title>Vocabulary Module</title>
    <link rel="stylesheet" href="redesign.css">
    <link rel="stylesheet" href="styles.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
    
    <div class="navbar-wrapper">
            <ul class="nav nav-tabs bg-white justify-content-center border-0" id="myTab" role="tablist">
            <?php                           
                for($i = 0; $i < count($nav_array); $i++){
                    $checked = "";
                    if($universe == $nav_array[$i]->link){
                        $checked = "checked-nav";
                    }
                    echo "<li class='nav-item main-body-nav-li $checked col-sm-2'><img src=".GLOBAL_URL."landing/assets/vocabulary.png alt='' width='32px' class='vocab-sub-nav-img'> <a href='index.php?universe=". $nav_array[$i]->link ."'><b>". $nav_array[$i]->link_name ."</a></li>";
                }
                ?>
            </ul>
        </div>
        
    <main>
        <section class="main-body-vocab">
            <div class="vocab-main-container">
                <?php
                    if(!isset($_GET["page"])){
                        require_once("main_menu.php");
                    }
                    else if($_GET["page"] == "dictionary"){
                        require_once("dictionary_page.php");
                    }
                    else if($_GET["page"] == "quiz"){
                        require_once("quiz_page.php");
                    }
                ?>
            </div>
        </section>
    </main>


<script src="../global/notification_script.js"></script>