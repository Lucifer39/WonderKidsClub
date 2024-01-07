<?php 
    include("../config/config.php");
    
    $status = $_POST["status"];
    $id = $_POST["id"];

    $sql = mysqli_query($conn, "UPDATE user_queries SET status = $status, updated_at = NOW() WHERE id = $id");
    mysqli_fetch_assoc($sql);
?>