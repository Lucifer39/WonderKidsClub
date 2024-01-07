<?php 
    $dir = __DIR__;
    $parent = dirname($dir);
    $parentdir = dirname($parent);

    require_once($parentdir . "/connection/dependencies.php");

    function set_seen_notification($notification_id){
        $conn = makeConnection();

        $sql = "UPDATE notifications SET seen_comment = 1 WHERE notification_id = $notification_id;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at set_seen_notification: ". $conn->error);
        }

        return;
    }

    function create_comment($post_id, $user_id, $content){
        $conn = makeConnection();

        $sql = "INSERT INTO comments (post_id, user_id, content) VALUES (?,?,?);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iis", $post_id, $user_id, $content);

        if (mysqli_stmt_execute($stmt)) {
            $comment_id = mysqli_insert_id($conn);
            $sql_notif = "INSERT INTO notifications (user_id, post_id, comment_id, seen_comment) VALUES (?,?,?,0);";
            $stmt_notif = mysqli_prepare($conn, $sql_notif);
            mysqli_stmt_bind_param($stmt_notif, "iii", $user_id, $post_id, $comment_id);

            if(mysqli_stmt_execute($stmt_notif)){
                return json_encode("ok");
            }
            
        } else {
          return json_encode(mysqli_stmt_error($stmt));
        }
    }

    function create_upvote($comment_id, $user_id){
        $conn = makeConnection();

        $sql = "INSERT INTO votes (comment_id, user_id, vote_value) VALUES (?,?,1);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $comment_id, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            return json_encode("ok");
        } else {
          return json_encode(mysqli_stmt_error($stmt));
        }
    }

    $function_name = $_GET["function_name"] ?? "";

    if($function_name == "set_seen_notification"){
        $notification_id = $_POST["notification_id"];
        echo set_seen_notification($notification_id);
    }

    else if($function_name == "create_comment"){
        echo create_comment($_POST["post_id"], $_POST["user_id"], $_POST["content"] ?? "");
    }

    else if($function_name == "create_upvote"){
        echo create_upvote($_POST["comment_id"], $_POST["user_id"]);
    }
?>