<?php 
    include( "../config/config.php" );

    $user_id = $_POST["user_id"];

    $sql = mysqli_query($conn, "SELECT subject, reply, seen, updated_at, query_content FROM user_queries WHERE reply IS NOT NULL AND user_id = $user_id order by updated_at desc");
    
    $arr = array();
    while($row = mysqli_fetch_assoc($sql)) {
        $arr[] = $row;
    }

    $sql_report = mysqli_query($conn,"SELECT 'Report Questions' AS subject, remark AS reply, updated_at, report AS query_content FROM report_question WHERE remark IS NOT NULL AND user_id = $user_id ORDER BY updated_at DESC");
    while( $row = mysqli_fetch_assoc($sql_report)) {
        $arr[] = $row;
    }
    echo json_encode($arr);
?>