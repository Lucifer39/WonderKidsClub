<?php 
    include( "../config/config.php" );

    $sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if($sessionrow['isAdmin'] == 1) {
        if(isset($_GET['school_id'])) {
            $sql_part = 'AND u.school = ' . $_GET['school_id'];
        }
        $sql = "SELECT
                    u.fullname AS student_name,
                    u.email,
                    sm.name AS school,
                    s.name AS class,
                    u.id AS user_id,
                    (
                        SELECT COUNT(question)
                        FROM leaderboard
                        WHERE userid = u.id
                    ) AS total_questions_attempted,
                    (
                        SELECT COUNT(question)
                        FROM leaderboard
                        WHERE userid = u.id
                        AND DATE(created_at) = CURDATE()
                    ) AS total_questions_attempted_today,
                    (
                        SELECT COUNT(question)
                        FROM leaderboard
                        WHERE userid = u.id
                        AND DATE(created_at) = CURDATE() - INTERVAL 1 DAY
                    ) AS total_questions_attempted_yesterday,
                    (
                        SELECT COUNT(question)
                        FROM leaderboard
                        WHERE userid = u.id
                        AND DATE(created_at) = CURDATE() - INTERVAL 2 DAY
                    ) AS total_questions_attempted_day_before_yesterday
                FROM
                    users u
                JOIN
                    subject_class s ON u.class = s.id
                JOIN
                    school_management sm ON u.school = sm.id
                LEFT JOIN
                    leaderboard l ON u.id = l.userid
                WHERE 
                    s.type = 2
                AND
                    u.isAdmin = 2
                AND 
                    u.type = 1
                $sql_part
                GROUP BY
                    u.id, s.name
                ORDER BY
                    s.id, student_name;";

        $result = mysqli_query($conn, $sql);

        $i = 0;
        $data = array();

        while($row = mysqli_fetch_assoc($result)) {
            $empRows = array();
            $empRows[] = ++$i;
            $empRows[] = $row['student_name'];
            $empRows[] = $row['email'];
            $empRows[] = $row['school'];
            $empRows[] = $row["class"];
            $empRows[] = $row["total_questions_attempted_today"];
            $empRows[] = $row["total_questions_attempted_yesterday"];
            $empRows[] = $row["total_questions_attempted_day_before_yesterday"];
            $empRows[] = $row["total_questions_attempted"];

            $empRows[] = '<a href="'. $baseurl .'controlgear/studentReports?select-user='. $row['user_id'] .'">View</a>';

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
