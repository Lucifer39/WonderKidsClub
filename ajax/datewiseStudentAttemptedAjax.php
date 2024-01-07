<?php 
    include( "../config/config.php" );

    $sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if($sessionrow['isAdmin'] == 1) {
        $sql_part = "";
        if(isset($_GET['user_id'])) {
            $sql_part .= ' AND u.id = ' . $_GET['user_id'];
        }

        if(isset($_GET['user_id'])) {
            $sql_part .= ' AND u.id = ' . $_GET['user_id'];
        }

        $sql = "SELECT
        u.id,
        u.fullname,
        u.email,
        COUNT(l.question) AS total_questions_attempted,
        COUNT(CASE WHEN DATE(l.created_at) = CURDATE() THEN 1 END) AS total_questions_attempted_today,
        COUNT(CASE WHEN DATE(l.created_at) = CURDATE() - INTERVAL 1 DAY THEN 1 END) AS total_questions_attempted_yesterday,
        COUNT(CASE WHEN DATE(l.created_at) = CURDATE() - INTERVAL 2 DAY THEN 1 END) AS total_questions_attempted_day_before_yesterday
    FROM
        users u
    LEFT JOIN
        leaderboard l ON u.id = l.userid
    WHERE
        u.isAdmin = 2
    GROUP BY
        u.id, u.fullname, u.email
    ORDER BY
        u.id";

        $result = mysqli_query($conn, $sql);

        $i = 0;
        $data = array();

        while($row = mysqli_fetch_assoc($result)) {
            $empRows = array();
            $empRows[] = ++$i;
            $empRows[] = $row["fullname"];
            $empRows[] = $row["email"];
            $empRows[] = $row["total_questions_attempted_today"];
            $empRows[] = $row["total_questions_attempted_yesterday"];
            $empRows[] = $row["total_questions_attempted_day_before_yesterday"];
            $empRows[] = $row["total_questions_attempted"];
            $empRows[] = '<a href="'. $baseurl .'controlgear/studentReports?select-user='. $row['id'] .'">View</a>';

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
