<?php 
    $dir = __DIR__;
    $parentdir = dirname($dir);
    require_once($parentdir . "/global/navbar.php");
    require_once("functions/getters.php");

    $filter = $_GET["filter"] ?? "";
    $category = $_GET["category"] ?? "";

    $getGuest = getGuest();
    if($getid == "" && $getGuest == ""){
        echo '<script>window.location.href = "'. GLOBAL_URL .'index.php";</script>';
    }


    $data = get_contexts($filter, $category);
    $get_guest_modal = getGuestModal();

    if($getid == "" && !$get_guest_modal){
        require_once("../global/guest_modal.php");
    }
?>

<script>
    var data = <?php echo json_encode($data); ?>;
</script>

<link rel="stylesheet" href="styles.css">

<div class="container">
    <!-- <h1>Vocabulary Context</h1> -->
    <div class="context-search input-group mb-3">
        <span class="input-group-text" id="basic-addon1">
            <i class="bi bi-search"></i>
        </span>
        <input type="text" class="form-control" id="search-input" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
    </div>
    <div class="filter-div">
        <div class="context-categories-div" id="context-categories-div">
                <a href="index.php">
                    <button class="category-btn <?php 
                        if($filter == "" && $category == ""){
                            echo 'pressed';
                        }
                    ?>">All</button>
                </a>
                <?php 
                    $categories = get_context_categories();

                    foreach($categories as $each){
                        $pressed = "";

                        if($each->id == $category){
                            $pressed = "pressed";
                        }

                        echo "<a href='index.php?filter=category&category=". $each->id ."'><button class='category-btn $pressed'>". $each->category ."</button></a>";
                    }
                ?>
            </div>
        <!-- <div class="context-categories-div" id="context-categories-starting-letter">
                    <?php 
                        $alphabets = range('A', 'Z');

                        for($i = 0; $i < count($alphabets); $i++){
                            $pressed = "";

                            if($alphabets[$i] == $category){
                                $pressed = "pressed";
                            }

                            echo "<a href='index.php?filter=starts_with&category=$alphabets[$i]'><button class='category-btn $pressed'>$alphabets[$i]</button></a>";
                        }
                    ?>
        </div> -->
    </div>
    <div class="context-container" id="context-container"></div>

    <div class="context-buttons-navigation">
        <button id="prev-button">Prev</button>
        <button id="next-button">Next</button>
    </div>
</div>

<script src="scripts/context_list.js"></script>