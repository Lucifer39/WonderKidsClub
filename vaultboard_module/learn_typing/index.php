<?php 
    $dir = __DIR__;
    require_once($dir ."/functions/level_functions.php");
    require_once("main_menu.php");

    
    $page = $_GET["page"] ?? "levels_page";

    $dir = __DIR__;
    $parentdir = dirname($dir);

    require_once($parentdir.'/global/navbar.php');

    $current_student = getCurrentStudent();

     class Li_nav{
        public $link_name;
        public $link;
        public $link_search;
        public function __construct($link_name, $link, $link_search){
            $this->link_name = $link_name;
            $this->link = $link;
            $this->link_search = $link_search;
        }
    }

    $link_name_array = array("Type Master", "Learn Typing");
    $link_search = array("type_master", "learn_typing");
    $link_array = array( "../type_master/index.php", "index.php");
    $nav_array = array();

    for($i = 0; $i < count($link_name_array); $i++){
        $obj = new Li_nav($link_name_array[$i], $link_array[$i], $link_search[$i]);
        array_push($nav_array, $obj);
    }

?>

<head>
    <title>Simple Type Racer</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="redesign.css">
    <?php 
        $dir1 = __DIR__;
        $parentdir = dirname($dir1);
        require_once($parentdir ."/global/head.php");
    ?>
</head>

<script>
    var current_student = <?php echo json_encode($current_student); ?>;
</script>
<style>
    /* .bgimg{
        /* background-color:#2F474E */
        /* background-image: url('./images/bg.jpg');
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
    } */
    .scrolled-up {
        display: none;
    }
</style>
<body class="bgimg">
    <div class="navbar-wrapper mt-2">
        <ul class="nav nav-tabs bg-white justify-content-center border-0" id="myTab" role="tablist">
            <?php                           
                for($i = 0; $i < count($nav_array); $i++){
                    $checked = "";
                    
                    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
                    $host = $_SERVER['HTTP_HOST'];
                    $uri = $_SERVER['REQUEST_URI'];

                    $path = $protocol . $host . $uri;
                    
                    // $path = $_SERVER['HTTP_REFERER'];

                    $segments = explode('/', $path);

                    // print_r($segments);

                    // Find the index of "type_master" or "learn_typing" segment
                    $typeMasterKey = array_search($nav_array[$i]->link_search, $segments);

                    if($typeMasterKey !== false){
                        $checked = "checked-nav";
                    }
                    echo "<li class='nav-item main-body-nav-li $checked col-sm-2'><img src=".GLOBAL_URL."landing/assets/typing.png alt='' width='28px'><a href='". $nav_array[$i]->link ."'><b> ". $nav_array[$i]->link_name ."</a></li>";
                }
            ?>
        </ul>
    </div>
    <main>
        <section class="main-body-vocab">
            <div class="main-container p-3">
                <?php
                    if($page == "levels_page"){
                        require_once("levels_page.php");
                    }
                    else if($page == "play"){
                        require_once("play.php");
                    }
                ?>
            </div>
        </section>
    </main>
</body>
<script>
    $(document).ready(function() {
        // Check if the modal has already been shown
        var modalShown = sessionStorage.getItem('modalShown');

        if (!modalShown) {
            // Show the modal
            $("#welcomeTyping").modal('show');

            // Set the flag in local storage to indicate that the modal has been shown
            sessionStorage.setItem('modalShown', true);
        }
    });
    $(document).ready(function() {
        // Add scroll event listener
        $(window).scroll(function() {
            // Check if the page has been scrolled
            if ($(this).scrollTop() > 0) {
                // Add a class to the navbar to hide it
                $('.navbar-wrapper').addClass('scrolled-up');
            } else {
                // Remove the class to show the navbar again
                $('.navbar-wrapper').removeClass('scrolled-up');
            }
        });
    });
</script>

<script src="../global/notification_script.js"></script>
