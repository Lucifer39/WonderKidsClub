<?php 
    $dir = __DIR__;
    $parentdir = dirname($dir);
    $top_list = array(array("Vocabulary", $parentdir . "/index.php"), array("Typing Master", "#"));
?>

<div class="top-nav">
    <?php
        foreach($top_list as $button){
            echo "<a href='". $button[1] ."'><button class='top-nav-buttons'>". $button[0] ."</button></a>";
        }
    ?>
</div>