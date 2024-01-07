<?php 
    $dir = __DIR__;
    $parentdir = dirname($dir);
    require_once($parentdir . "/connection/dependencies.php");

    function get_typing_notifications($user_id){
        $conn = makeConnection();

        $sql = "SELECT COUNT(*) as notification_count ";
        $sql .= "FROM type_invites t ";
        $sql .= "JOIN users s1 ON t.sender = s1.id ";
        $sql .= "JOIN users s2 ON t.receiver = s2.id ";
        $sql .= "WHERE receiver = ". $user_id ." ";
        $sql .= "AND status = 'pending' ;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed in get_typing_notifications: " . $conn->error);
        }

        $res = $result->fetch_assoc();

        return $res["notification_count"] ?? 0;
    }

    function get_discussion_notifications($user_id){
        $conn = makeConnection();

        $sql = "SELECT COUNT(*) as notification_count
                FROM notifications n
                JOIN users u ON u.id = n.user_id
                JOIN comments c ON c.comment_id = n.comment_id
                JOIN posts p ON p.post_id = n.post_id
                WHERE p.user_id = $user_id ;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_discussion_notifications: ". $conn->error);
        }

        $res = $result->fetch_assoc();

        return $res["notification_count"] ?? 0;
    }

    $function_name = $_GET["function_name"] ?? "";

    if($function_name == "get_typing_notifications"){
        echo json_encode(get_typing_notifications($_POST["user_id"]));
    }
    else if($function_name == "get_discussion_notifications"){
        echo json_encode(get_discussion_notifications($_POST["user_id"]));
    }
?>