<?php 
    include( "../config/config.php" );

    $sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if($sessionrow['isAdmin'] == 1) {
        if(isset($_GET['class_id'])) {
            $sql_part = 'AND u.class = ' . $_GET['class_id'];
        }
        $sql = "SELECT
                    s.id,
                    s.name AS school,
                    COUNT(DISTINCT CASE WHEN DATEDIFF(NOW(), u.created_at) <= 5 THEN u.id END) AS users_registered_last_5_days,
                    COUNT(DISTINCT CASE WHEN DATEDIFF(NOW(), l.created_at) <= 5 THEN l.userid END) AS users_attempted_last_5_days,
                    ROUND(COUNT(l.question) / COUNT(DISTINCT CASE WHEN DATEDIFF(NOW(), l.created_at) <= 5 THEN l.userid END), 2) AS avg_questions_attempted_per_user
                FROM
                    school_management s
                LEFT JOIN
                    users u ON s.id = u.school
                LEFT JOIN
                    leaderboard l ON u.id = l.userid
                LEFT JOIN
                    subject_class sc ON u.class = sc.id
                WHERE
                    s.status = 1
                $sql_part
                GROUP BY
                    s.id;";

        $result = mysqli_query($conn, $sql);

        $i = 0;
        $data = array();

        while($row = mysqli_fetch_assoc($result)) {
            $empRows = array();
            $empRows[] = ++$i;
            $empRows[] = $row["school"];
            $empRows[] = $row["users_registered_last_5_days"];
            $empRows[] = $row["users_attempted_last_5_days"];
            $empRows[] = $row["avg_questions_attempted_per_user"];
            $empRows[] = '<a href="'. $baseurl .'controlgear/schoolReports?select-school='. $row['id'] .'">View</a>';

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
