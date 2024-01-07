<?php 
    include( "../config/config.php" );

    $sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if($sessionrow['isAdmin'] == 1) {
        if(isset($_GET['school_id'])) {
            $sql_part = 'AND u.school = ' . $_GET['school_id'];
        }
        $sql = "SELECT
                    s.id,
                    s.name AS class,
                    COUNT(DISTINCT CASE WHEN DATEDIFF(NOW(), u.created_at) <= 5 THEN u.id END) AS users_registered_last_5_days,
                    COUNT(DISTINCT CASE WHEN DATEDIFF(NOW(), l.created_at) <= 5 THEN l.userid END) AS users_attempted_last_5_days,
                    ROUND(COUNT(l.question) / COUNT(DISTINCT CASE WHEN DATEDIFF(NOW(), l.created_at) <= 5 THEN l.userid END), 2) AS avg_questions_attempted_per_user
                FROM
                    subject_class s
                LEFT JOIN
                    users u ON s.id = u.class
                LEFT JOIN
                    leaderboard l ON u.id = l.userid
                LEFT JOIN
                    school_management sm ON u.school = sm.id
                WHERE
                    s.type = 2
                AND
                    s.status = 1
                AND
                    sm.status = 1
                $sql_part
                GROUP BY
                    s.name, s.id
                ORDER BY
                    s.id";

        $result = mysqli_query($conn, $sql);

        $i = 0;
        $data = array();

        while($row = mysqli_fetch_assoc($result)) {
            $empRows = array();
            $empRows[] = ++$i;
            $empRows[] = $row["class"];
            $empRows[] = $row["users_registered_last_5_days"];
            $empRows[] = $row["users_attempted_last_5_days"];
            $empRows[] = $row["avg_questions_attempted_per_user"];
            $empRows[] = '<a href="'. $baseurl .'controlgear/classReports?select-class='. $row['id'] .'">View</a>';

            $data[] = $empRows;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"=>$data
        );
        echo json_encode($results);
    }else {
        header('Location:'.$baseurl.'');
    }
?>
