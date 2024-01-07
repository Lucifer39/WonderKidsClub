<?php
     $dir = __DIR__;
     $parent = dirname($dir);
     $parentdir = dirname($parent);
 
     require_once($parentdir . "/connection/dependencies.php");

    class Post{
        public $post_id;
        public $student_name;
        public $student_class;
        public $student_school;
        public $student_avatar;
        public $post_content;
        public $post_media_info;
        public $post_created_at;
        public $post_comment_count;
        public function __construct($obj){
            $this->post_id = $obj["post_id"];
            $this->student_name = $obj["fullname"];
            $this->student_class = $obj["class"];
            $this->student_school = $obj["school"];
            $this->student_avatar = $obj["avatar"];
            $this->post_content = $obj["content"];
            $this->post_media_info = $obj["media_info"];
            $this->post_created_at = $obj["created_at"];
            $this->post_comment_count = $obj["comment_count"];
        }
    }
    function get_posts($offset){
        $conn = makeConnection();

        $batch_size = 10;
        $offset_size = $batch_size * $offset;

        $sql = "SELECT
                    posts.post_id,
                    u.fullname,
                    sc.vocab_class AS class,
                    sm.name AS school,
                    u.avatar,
                    posts.content,
                    GROUP_CONCAT(DISTINCT CONCAT(media_files.media_url, '|', media_files.file_type)) AS media_info,
                    posts.created_at,
                    COUNT(comments.comment_id) AS comment_count
                FROM
                    posts
                JOIN users u ON posts.user_id = u.id
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id
                LEFT JOIN media_files ON posts.post_id = media_files.post_id
                LEFT JOIN comments ON posts.post_id = comments.post_id
                GROUP BY
                    posts.post_id,
                    u.fullname,
                    sc.vocab_class,
                    sm.name,
                    u.avatar,
                    posts.content,
                    posts.created_at
                ORDER BY
                    posts.created_at DESC
                LIMIT $batch_size OFFSET $offset_size;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_posts: ". $conn->error);
        }

        $post_array = array();

        while($row = $result->fetch_assoc()){
            $obj = new Post($row);
            array_push($post_array, $obj);
        }

        return json_encode($post_array);
    }

    class Comment{
        public $comment_id;
        public $student_name; 
        public $student_class;
        public $student_school;
        public $student_avatar;
        public $comment_content;
        public $comment_created_at;
        public $comment_vote_value;

        public function __construct($obj){
            $this->comment_id = $obj["comment_id"];
            $this->student_name = $obj["fullname"];
            $this->student_class = $obj["class"];
            $this->student_school = $obj["school"];
            $this->student_avatar = $obj["avatar"];
            $this->comment_content = $obj["content"];
            $this->comment_vote_value = $obj["vote_value"];
        }
    }
    function get_comments($post_id, $limit){
        $conn = makeConnection();

        $sql = "SELECT comments.comment_id, u.fullname, sc.vocab_class AS class, sm.name AS school, u.avatar, comments.content, comments.created_at, votes.vote_value
                FROM comments
                JOIN users u 
                ON comments.user_id = u.id
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id
                LEFT JOIN votes ON comments.comment_id = votes.comment_id
                WHERE comments.post_id = $post_id
                GROUP BY comments.comment_id, u.name, comments.content, votes.vote_value, comments.created_at
                ORDER BY votes.vote_value DESC
                LIMIT $limit;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_comments: ". $conn->error);
        }

        $comment_array = array();

        while($row = $result->fetch_assoc()){
            $obj = new Comment($row);
            array_push($comment_array, $obj);
        }

        return json_encode($comment_array);

    }

    class Notification{
        public $notification_id;
        public $student_id;
        public $student_name;
        public $comment_id;
        public $comment_content;
        public $post_id;
        public $post_content;
        public $student_avatar;
        public $seen_comment;
        public function __construct($obj){
            $this->notification_id = $obj["notification_id"];
            $this->student_id = $obj["id"];
            $this->student_name = $obj["user_name"];
            $this->comment_id = $obj["comment_id"];
            $this->comment_content = $obj["comment_content"];
            $this->post_id = $obj["post_id"];
            $this->post_content = $obj["post_content"];
            $this->student_avatar = $obj["avatar"];
            $this->seen_comment = $obj["seen_comment"];
        }
    }
    function get_notifications($user_id){
        $conn = makeConnection();

        $sql = "SELECT n.notification_id, n.seen_comment, u.id, u.avatar, u.name AS user_name, c.comment_id, c.content AS comment_content, p.post_id, p.content AS post_content
                FROM notifications n
                JOIN users u ON u.id = n.user_id
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id
                JOIN comments c ON c.comment_id = n.comment_id
                JOIN posts p ON p.post_id = n.post_id
                WHERE p.user_id = $user_id
                ORDER BY n.created_at DESC;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_notifications: ". $conn->error);
        }

        $notification_array = array();

        while($row = $result->fetch_assoc()){
            $obj = new Notification($row);
            array_push($notification_array, $obj);
        }

        return json_encode($notification_array);
    }

    function get_single_post($post_id){
        $conn = makeConnection();

        $sql = "SELECT
                    posts.post_id,
                    u.fullname,
                    sc.vocab_class AS class,
                    sm.name AS school,
                    u.avatar,
                    posts.content,
                    GROUP_CONCAT(DISTINCT CONCAT(media_files.media_url, '|', media_files.file_type)) AS media_info,
                    posts.created_at,
                    COUNT(comments.comment_id) AS comment_count
                FROM
                    posts
                JOIN users u ON posts.user_id = u.id
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id
                LEFT JOIN media_files ON posts.post_id = media_files.post_id
                LEFT JOIN comments ON posts.post_id = comments.post_id
                WHERE
                    posts.post_id = $post_id
                GROUP BY
                    posts.post_id,
                    u.fullname,
                    sc.vocab_class,
                    sm.name,
                    u.avatar,
                    posts.content,
                    posts.created_at
                ORDER BY
                    posts.created_at DESC";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_single_post: ". $conn->error);
        }

        return json_encode(new Post($result->fetch_assoc()));
    }

    function check_upvote($comment_id, $user_id){
        $conn = makeConnection();

        $sql = "SELECT * FROM votes WHERE comment_id = $comment_id AND user_id = $user_id";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at check_upvote: ". $conn->error);
        }

        if(mysqli_num_rows($result) == 0){
            return json_encode("not voted");
        }
        else{
            return json_encode("voted");
        }
    }

    $function_name = $_GET["function_name"] ?? "";

    if($function_name == "get_posts"){
        $offset = $_POST["offset"] ?? 0;
        echo get_posts($offset);
    }
    else if($function_name == "get_comments"){
        $post_id = $_POST["post_id"];
        $limit = $_POST["limit"] ?? 1000;
        echo get_comments($post_id, $limit);
    }

    else if($function_name == "get_notifications"){
        $user_id = $_POST["user_id"];
        echo get_notifications($user_id);
    }

    else if($function_name == "get_single_post"){
        $post_id = $_POST["post_id"];
        echo get_single_post($post_id);
    }

   else if($function_name == "check_upvote"){
        echo check_upvote($_POST["comment_id"], $_POST["user_id"] ?? 0);
   }
?>

