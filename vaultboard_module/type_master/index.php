<?php 
    $dir = __DIR__;
    $parentdir = dirname($dir);
    
    require_once($parentdir . "/connection/dependencies.php");
    require_once($parentdir.'/global/navbar.php');

    $page = $_GET["page"] ?? "main_menu";

    $current_student = getCurrentStudent();

    $getGuest = getGuest();
    if($getid == "" && $getGuest == ""){
        echo '<script>window.location.href = "'. GLOBAL_URL .'index.php";</script>';
    }


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

    $anchor = "../learn_typing/index.php";

    if($getid == ""){
        $anchor = "#";
    }

    $link_name_array = array("Type Master");

    if(getSpecificSection("learn_typing") == 1) {
        $link_name_array[] = "Learn Typing";
    }

    $link_search = array("type_master", "learn_typing");
    $link_array = array("index.php", "../learn_typing/index.php");
    $nav_array = array();

    for($i = 0; $i < count($link_name_array); $i++){
        $obj = new Li_nav($link_name_array[$i], $link_array[$i], $link_search[$i]);
        array_push($nav_array, $obj);
    }
?>

<script>
    var current_student = <?php echo json_encode($current_student); ?>;
</script>

<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="redesign.css">
    <?php 
        $dir1 = __DIR__;
        $parentdir = dirname($dir1);
        require_once($parentdir ."/global/head.php");
    ?>
</head>

<body>
        <div class="navbar-wrapper">
            <ul class="nav nav-tabs bg-white justify-content-center border-0" id="myTab" role="tablist" style="list-style-type: style none;">
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

                        $attr = "";

                        // if($i == 1 && $nav_array[$i]->link == "#"){
                        //     $attr = 'data-bs-toggle="modal" data-bs-target="#loginModal" data-card="typing"';
                        // }
                        // echo "<li class='nav-item main-body-nav-li $checked col-sm-2'><img src=".GLOBAL_URL."landing/assets/typing.png alt='' width='28px'><a href='". $nav_array[$i]->link ."' ". $attr ."><b> ". $nav_array[$i]->link_name ."</a></li>";
                        echo "<li class='nav-item main-body-nav-li $checked col-sm-2'><img src=".GLOBAL_URL."landing/assets/typing.png alt='' width='28px'><a href='". $nav_array[$i]->link ."'><b> ". $nav_array[$i]->link_name ."</a></li>";
                    }
                ?>
            </ul>
        </div>
        <main>
        <section class="main-body-vocab">
            <div class="main-container">
                <?php
                    if($page == "main_menu"){
                        require_once("mainMenu.php"); 
                    }
                    else if($page == "play_with_friends"){
                        require_once("play_with_friends.php");
                    }
                    else if($page == "practice_yourself"){
                        require_once("typeMaster.php");
                    }
                    else if($page == "typing_race_waiting_room_page"){
                        require_once("typing_race_waiting_room_page.php");
                    }
                    else if($page == "multiplayer_room_page"){
                        require_once("multiplayer_room_page.php");
                    }
                    else if($page == "room_creation_page"){
                        require_once("room_creation_page.php");
                    }
                    else if($page == "waiting_room_page"){
                        require_once("waiting_room_page.php");
                    }
                    else if($page == "history"){
                        require_once("history.php");
                    }
                ?>
            </div>
        </section>
    </main>
</body>

<script src="../global/notification_script.js"></script>
