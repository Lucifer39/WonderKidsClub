<?php 
    include("../config/config.php");

    $subtopic_id = $_POST["subtopic_id"];
    $deleteSQL = mysqli_query($conn, "DELETE FROM count_quest WHERE subtopic = '$subtopic_id' AND type2 IS NULL");
    $deleterow = mysqli_fetch_assoc($deleteSQL);

    echo "success";
?>