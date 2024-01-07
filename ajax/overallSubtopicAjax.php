<?php 
    include( "../config/config.php" );

    $sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if($sessionrow['isAdmin'] == 1) {
        $sql_part = "";
        if(isset($_GET['school_id'])) {
            $sql_part .= ' AND u.school = ' . $_GET['school_id'];
        }

        if(isset($_GET['user_id'])) {
            $sql_part .= ' AND u.id = ' . $_GET['user_id'];
        }

        $sql = "SELECT
                    sc.name AS class,
                    ts1.topic,
                    ts.subtopic,
                    COUNT(DISTINCT l.id) AS total_questions_attempted,
                    IFNULL(ROUND(SUM(l.correct) / (SUM(l.correct) + SUM(l.wrong)) * 100, 2), 0) AS average_accuracy,
                    COUNT(DISTINCT l.userid) AS distinct_users
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
                    sc.id";

        $result = mysqli_query($conn, $sql);

        $i = 0;
        $data = array();

        while($row = mysqli_fetch_assoc($result)) {
            $empRows = array();
            $empRows[] = ++$i;
            $empRows[] = $row["class"];
            $empRows[] = $row["topic"];
            $empRows[] = $row["subtopic"];
            $empRows[] = $row["total_questions_attempted"];
            $empRows[] = $row["average_accuracy"];
            $empRows[] = $row["distinct_users"];

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
