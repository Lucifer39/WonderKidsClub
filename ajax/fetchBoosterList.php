<?php 
        include( "../config/config.php" );

        $sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
        $sessionrow = mysqli_fetch_assoc($sessionsql);

        if($sessionrow['isAdmin'] == 1) {
            $sql = "SELECT * FROM boosters";
            
            $result = mysqli_query($conn, $sql);

            $i = 0;
            $data = array();
    
            while($row = mysqli_fetch_assoc($result)) {
                $empRows = array();
                $empRows[] = $row['id'];
                $empRows[] = $row["booster_name"];
                $empRows[] = '<img src="' . $baseurl . 'assets/notification_icons/' . $row['booster_icon'] . '" height="25" width="25">';
                $empRows[] = $row["booster_info"];
                $empRows[] = $row['score_multiplier'];
                $empRows[] = $row['incorrect_score_multiplier'];
                $empRows[] = $row["booster_timer"];
                $empRows[] = $row["minimum_time"];
                $empRows[] = '<a href="'. $baseurl .'controlgear/addBoosterPage?b_id='. $row['id'] .'">Edit</a>';
    
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