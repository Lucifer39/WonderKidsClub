<?php 
    include( "../config/config.php" );

    $user_id = $_POST["user_id"];
    $subject = $_POST["subject"];
    $query_content = $_POST["content"];

    $sql = mysqli_query($conn, "INSERT INTO user_queries (user_id, subject, query_content) VALUES ('$user_id', '$subject', '$query_content')");
    $row = mysqli_fetch_assoc($sql);
?>