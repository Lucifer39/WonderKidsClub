<?php 
        include( "../config/config.php" );

        $sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
        $sessionrow = mysqli_fetch_assoc($sessionsql);

        if($sessionrow['isAdmin'] == 1) {
            $sql = "SELECT bc.id, b.booster_name, bc.name, bc.info, b.booster_icon, bc.minimum_day_streak, bc.minimum_questions FROM booster_criteria bc
                    JOIN boosters b
                    ON b.id = bc.booster";
            
            $result = mysqli_query($conn, $sql);

            $i = 0;
            $data = array();
    
            while($row = mysqli_fetch_assoc($result)) {
                $empRows = array();
                $empRows[] = $row['id'];
                $empRows[] = $row["booster_name"];
                $empRows[] = $row["name"];
                $empRows[] = $row['info'];
                $empRows[] = '<img src="' . $baseurl . 'assets/notification_icons/' . $row['booster_icon'] . '" height="25" width="25">';
                $empRows[] = $row["minimum_day_streak"];
                $empRows[] = $row['minimum_questions'];
                $empRows[] = '<a href="'. $baseurl .'controlgear/addBoosterCriteriaPage?b_id='. $row['id'] .'">Edit</a>';
    
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