<?php 
    include( "../config/config.php" );

    $sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if($sessionrow['isAdmin'] == 1) {
        if(isset($_GET['school_id'])) {
            $sql_part = 'AND u.school = ' . $_GET['school_id'];
        }
        $sql = "SELECT
                    s.id AS class_id,
                    s.name AS class,
                    COUNT(DISTINCT u.id) AS registrations,
                    COUNT(DISTINCT l.userid) AS visitors,
                    IFNULL(ROUND(SUM(l.correct) / (SUM(l.correct) + SUM(l.wrong)) * 100, 2), 0) AS average_accuracy
                FROM
                    subject_class s
                LEFT JOIN
                    users u ON s.id = u.class
                LEFT JOIN
                    leaderboard l ON u.id = l.userid
                WHERE 
                    s.status = 1
                AND
                    s.id <= 7
                $sql_part
                GROUP BY
                    s.id";

        $result = mysqli_query($conn, $sql);

        $i = 0;
        $data = array();

        while($row = mysqli_fetch_assoc($result)) {
            $empRows = array();
            $empRows[] = ++$i;
            $empRows[] = $row["class"];
            $empRows[] = $row["registrations"];
            $empRows[] = $row["visitors"];
            $empRows[] = $row["average_accuracy"];
            $empRows[] = '<a href="'. $baseurl .'controlgear/classReports?select-class='. $row['class_id'] .'">View</a>';

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
