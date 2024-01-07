<?php 
    include( "../config/config.php" );

    $sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if($sessionrow['isAdmin'] == 1) {
        if(isset($_GET['class_id'])) {
            $sql_part = 'AND u.class = ' . $_GET['class_id'];
        }
        $sql = "SELECT
                    s.id AS school_id,
                    s.name AS school,
                    COUNT(DISTINCT u.id) AS registrations,
                    COUNT(DISTINCT l.userid) AS visitors,
                    IFNULL(ROUND(SUM(l.correct) / (SUM(l.correct) + SUM(l.wrong)) * 100, 2), 0) AS average_accuracy
                FROM
                    school_management s
                LEFT JOIN
                    users u ON s.id = u.school
                LEFT JOIN
                    leaderboard l ON u.id = l.userid
                WHERE 
                    s.status = 1
                $sql_part
                GROUP BY
                    s.id";

        $result = mysqli_query($conn, $sql);

        $i = 0;
        $data = array();

        while($row = mysqli_fetch_assoc($result)) {
            $empRows = array();
            $empRows[] = ++$i;
            $empRows[] = $row["school"];
            $empRows[] = $row["registrations"];
            $empRows[] = $row["visitors"];
            $empRows[] = $row["average_accuracy"];
            $empRows[] = '<a href="'. $baseurl .'controlgear/schoolReports?select-school='. $row['school_id'] .'">View</a>';

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
