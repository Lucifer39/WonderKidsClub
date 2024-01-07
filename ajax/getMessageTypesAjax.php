<?php 
    include( "../config/config.php" );

    $user_id = $_POST["user_id"];

    $sql = mysqli_query( $conn,"SELECT
                                    COUNT(*) AS All_Count,
                                    COALESCE(SUM(CASE WHEN subject = 'Feedback/Suggestions' THEN 1 ELSE 0 END), 0) AS Feedback_Suggestions_Count,
                                    COALESCE(SUM(CASE WHEN subject = 'Complaints' THEN 1 ELSE 0 END), 0) AS Complaints_Count,
                                    COALESCE(SUM(CASE WHEN subject = 'Collaborations' THEN 1 ELSE 0 END), 0) AS Collaborations_Count,
                                    COALESCE(SUM(CASE WHEN subject = 'Payment & Refunds' THEN 1 ELSE 0 END), 0) AS Payment_Refunds_Count,
                                    (
										SELECT COUNT(*) FROM report_question WHERE user_id = 7 AND remark IS NOT NULL
                                    ) AS Report_Question,
                                    COALESCE(SUM(CASE WHEN subject = 'Others' THEN 1 ELSE 0 END), 0) AS Others_Count
                                FROM user_queries
                                WHERE user_id = $user_id AND reply IS NOT NULL AND seen = 0");

    $row = mysqli_fetch_array( $sql );
    echo json_encode( $row );
?>