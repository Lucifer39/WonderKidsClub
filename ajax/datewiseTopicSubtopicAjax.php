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
        CONCAT(sc.name, ' / ', ts1.topic, ' / ', ts.subtopic) AS topic_subtopic,
        (
            SELECT COUNT(question)
            FROM leaderboard
            WHERE subtopic = ts.id
            AND leaderboard.userid = u.id
        ) AS total_questions_attempted,
        (
            SELECT COUNT(question)
            FROM leaderboard
            WHERE subtopic = ts.id
            AND DATE(created_at) = CURDATE()
            AND leaderboard.userid = u.id
        ) AS total_questions_attempted_today,
        (
            SELECT COUNT(question)
            FROM leaderboard
            WHERE subtopic = ts.id
            AND DATE(created_at) = CURDATE() - INTERVAL 1 DAY
            AND leaderboard.userid = u.id
        ) AS total_questions_attempted_yesterday,
        (
            SELECT COUNT(question)
            FROM leaderboard
            WHERE subtopic = ts.id
            AND DATE(created_at) = CURDATE() - INTERVAL 2 DAY
            AND leaderboard.userid = u.id
        ) AS total_questions_attempted_day_before_yesterday
    FROM
        topics_subtopics ts
    LEFT JOIN
        leaderboard l ON ts.id = l.subtopic
    LEFT JOIN
        users u ON l.userid = u.id
    LEFT JOIN
        subject_class sc ON ts.class_id = sc.id
    JOIN 
        topics_subtopics ts1 ON ts.parent = ts1.id
    WHERE 
        ts.parent != 0
    AND
        ts.status = 1
    $sql_part
    GROUP BY
        ts.id
    ORDER BY
        sc.id;";

        $result = mysqli_query($conn, $sql);

        $i = 0;
        $data = array();

        while($row = mysqli_fetch_assoc($result)) {
            $empRows = array();
            $empRows[] = ++$i;
            $empRows[] = $row["topic_subtopic"];
            $empRows[] = $row["total_questions_attempted_today"];
            $empRows[] = $row["total_questions_attempted_yesterday"];
            $empRows[] = $row["total_questions_attempted_day_before_yesterday"];
            $empRows[] = $row["total_questions_attempted"];

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
