<?php 
    include( "../config/config.php" );

    $sessionsql = mysqli_query($conn, "SELECT isAdmin FROM users WHERE id='".$_SESSION['id']."'");
    $sessionrow = mysqli_fetch_assoc($sessionsql);

    if($sessionrow['isAdmin'] == 1) {
        $sql = "SELECT id,user_id,subject,query_content,status FROM user_queries order by created_at desc";
        $resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));

        $i=0;
        $data = array();

        while($row = mysqli_fetch_assoc($resultset)) {
            $status1 = $status2 = $status3 = '';
            if($row['status'] == 1) {$status1 = 'selected';}
            else if($row['status'] == 2) {$status2 = 'selected';}
            else if($row['status'] == 3) {$status3 = 'selected';}
            $empRows = array();
            $empRows[] = $row['id'];
            $empRows[] = $row['user_id'];
            $empRows[] = $row['subject'];
            $empRows[] = $row['query_content'];
            $empRows[] = '<select data-id='. $row['id'] .' class="status-select">
                            <option value=1 '. $status1 .'>Open</option>
                            <option value=2 '. $status2 .'>In Progress</option>
                            <option value=3 '. $status3 .'>Closed</option>
                          </select>';
            $empRows[] = '<button class="btn btn-primary custom-btn" data-id="'. $row['id'] .'">Reply</button>';
            $data[] = $empRows;
            $i++;
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