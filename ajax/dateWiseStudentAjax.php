<?php 
    include("../config/config.php");

    $sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if($sessionrow['isAdmin'] == 1) {
        $sql = "SELECT DATE(created_at) as signup_date, COUNT(*) as signups_count
                FROM users
                GROUP BY signup_date
                ORDER BY signup_date DESC";

        $result = mysqli_query($conn, $sql);
        
        $i = 0;
        $data = array();

        while($row = mysqli_fetch_assoc($result)) {

            $sql_leaderboard = mysqli_query($conn, "SELECT 
                                    COUNT(DISTINCT userid) as unique_user_count,
                                    COUNT(*) as total_questions_attempted
                                FROM 
                                    leaderboard
                                WHERE 
                                    DATE(created_at) = '". $row["signup_date"] ."';");

            $row_leaderboard = mysqli_fetch_assoc($sql_leaderboard);

            $empRows = array();
            $empRows[] = ++$i;
            $empRows[] = $row["signup_date"];
            $empRows[] = $row["signups_count"];
            $empRows[] = $row_leaderboard['unique_user_count'];
            $empRows[] = $row_leaderboard['total_questions_attempted'];

            $data[] = $empRows;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"=>$data
        );
        echo json_encode($results);
    } else {
        header('Location:'.$baseurl.'');
    }
?>