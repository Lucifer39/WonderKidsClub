<?php 
    $dir = __DIR__;
    require_once($dir . "/functions/dictionary_functions.php");
    
    $week_select = $_GET["week_select"] ?? "current";
    #TODO: convert to '1' to 'N'
    $words = json_encode(getWords($universe, 'N', $week_select));
    $words_select = json_encode(array());
    $flag = false;
    $day_array = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $select = $_POST["day-select"] ?? "";
   

?>

<div class="container container-dictionary">
    <div class="dictionary-action">
    <div class="week-select-container">
        <?php if($getid !== "") { ?>
            <a href="index.php?page=dictionary&universe=<?php echo $universe ; ?>&week_select=prev">
        <?php } else {?>
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-card="vocabulary_module">
        <?php } ?>
            <button <?php if($week_select == "prev") echo "disabled"; ?>>Previous Week <?php if($getid==""){ ?> <i class="bi bi-lock-fill"></i> <?php } ?></button>
        </a>
        <a href="index.php?page=dictionary&universe=<?php echo $universe ; ?>&week_select=current"><button <?php if($week_select == "current") echo "disabled"; ?>>Current Week</button></a>
    </div>    
    <!-- <h1 id="dictionary-header"></h1> -->
    <form method="post" class="day-select-form">
        <label class="dictionary-form-label">
            Words on  
        </label>

        <select name="day-select" class="day-select">
            <?php 
                $day_of_week = $week_select == "prev" ? date('7') : date('N');

                for($i = 1; $i <= $day_of_week; $i++){
                    $selected_flag = "";

                    if($select == $i || ($select == "" && date('N') == $i)){
                        $selected_flag = "selected";
                    }
                    echo "<option value='$i' $selected_flag>". $day_array[$i - 1] ."</option><br>";
                }
            ?>
        </select>

        <input type="submit" class="word-days-btn" name="word-days-btn" value="Go">
    </form>

    <?php if(isset($_POST["word-days-btn"])){
        $select = $_POST["day-select"];
        // $week_select = $_GET["week_select"];
        // echo $select;
        $words_select = json_encode(getWords($universe, $select, $week_select));
        $flag = true;
    } ?>
    </div>
    <div class="dictionary-container">
        <div id="dictionary-word"></div>
        <div class="dictionary-word-content">
            <!-- <div class="dictionary-word-left-panel"></div> -->
            <div class="dictionary-word-right-panel">
                <div class="dictionary-word-meaning">
                    <div id="dictionary-word-definition"></div>
                    <div id="dictionary-word-example"></div>
                </div>
                <?php if($universe == "words"){ ?>
                    <div class="dictionary-word-others">
                        <div id="dictionary-word-synonyms-box">
                            <div id="dictionary-word-synonym-title">Synonyms: </div>
                            <div id="dictionary-word-synonyms"></div>
                        </div>
                        <div id="dictionary-word-antonyms-box">
                            <div id="dictionary-word-antonym-title">Antonyms: </div>
                            <div id="dictionary-word-antonyms"></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="dictionary-footer">
        <div class="dictionary-footer-nav">
            <button id="prev">Prev</button>
            <button id="next">Next</button>
        </div>
        <!-- <div class="dictionary-footer-main-menu">
            <a href="index.php?universe=<?php echo $universe; ?>"><button>Main Menu</button></a>
        </div> -->
    </div>
</div>

<script>
    var words = <?php echo !$flag ? $words : $words_select; ?>;
    var heading = <?php echo ($week_select == "prev" ? json_encode("Last Week") : json_encode("This Week")) ?> + " " + <?php echo (!$flag ? json_encode("Today") : json_encode($day_array[intval($select) - 1])); ?> + "'s Words"; 
    var universe = <?php echo json_encode($universe); ?>;

    // document.getElementById("dictionary-header").textContent = heading;
</script>

<script src="scripts\dictionary_script.js"></script>
