<?php 
    $dir = __DIR__;
    $parentdir = dirname(dirname($dir));
    include($parentdir . "/config/config.php");
    function create_bio_about($student_id, $content, $type){
        global $conn;

        $sql = "INSERT INTO student_about (student_id, $type)
                VALUES (?,?)
                ON DUPLICATE KEY UPDATE student_id = VALUES(student_id), $type = VALUES($type);";

        // echo $sql;

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "is", $student_id, $content);


        if(mysqli_stmt_execute($stmt) && $type == "adjectives"){
            $sql_delete = "DELETE FROM incomplete_adjectives WHERE student_id = $student_id;";
            $result = $conn->query($sql_delete);
            if(!$result){
                die("Query failed at create_bio_about: ". $conn->error);
            }
            return true;
        }
        else{
            return $conn->error;
        }
    }

    function updateIncompleteAdjectives($student_id, $adjectives){
        global $conn;
        $stmt = $conn->prepare("INSERT INTO incomplete_adjectives (student_id, adjectives)
                          VALUES (?, ?)
                          ON DUPLICATE KEY UPDATE student_id = VALUES(student_id), adjectives = VALUES(adjectives)");

        $stmt->bind_param("ss", $student_id, $adjectives);
        if($stmt->execute()){
            return true;
        }

        return false;
    }
    function getIncompleteAdjectives($student_id){
        global $conn;
        $sql = "SELECT adjectives FROM incomplete_adjectives WHERE student_id = $student_id;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at getIncompleteAdjectives: ". $conn->error);
        }

        return $result->fetch_assoc();
    }

    class Adjective{
        public $alphabet;
        public $word;
        public $example;
        public function __construct($obj){
            $this->alphabet = $obj["alphabet"];
            $this->word = $obj["word"];
            $this->example = $obj["example"];
        }
    }

    function get_adjectives($alphabet){
        global $conn;

        $sql = "SELECT * FROM adjectives WHERE alphabet = '$alphabet' ;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed get_adjectives: ". $conn->error);
        }

        $res_array = array();
        while($row = $result->fetch_assoc()){
            $obj = new Adjective($row);
            array_push($res_array, $obj);
        }

        return $res_array;
    }

    function get_user_profile_progress($user_id){
        global $conn;
        $sql = "SELECT bio, adjectives FROM student_about WHERE student_id = $user_id;";

        $result = $conn->query($sql);
        if(!$result){
            die("Query failed at get_user_profile_progress: ". $conn->error);
        }

        return $result->fetch_assoc();
    }

    function get_avatars() {
        $directory = "../../assets/images/avatars/"; // Replace with the path to your directory

        // Check if the directory exists
        if (is_dir($directory)) {
            $imageExtensions = ["jpg", "jpeg", "png", "gif", "svg"]; // Add any other image file extensions you want to include

            $imageFiles = [];
            
            // Scan the directory for files
            $files = scandir($directory);
            
            foreach ($files as $file) {
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                
                // Check if the file has a valid image extension
                if (in_array(strtolower($extension), $imageExtensions)) {
                    $filePath = $directory . '/' . $file; // Full file path
                    $imageFiles[] = [
                        'filename' => $file,
                        'filepath' => $filePath,
                    ];
                }
            }
            
            // Now $imageFiles contains an array of arrays, each with 'filename' and 'filepath' keys
            return $imageFiles;
        } else {
            echo "The specified directory does not exist.";
        }
    }

    function set_avatar($user_id, $avatar) {
        global $conn;

        $sql = "UPDATE users SET avatar = '$avatar' WHERE id = $user_id";
        $result = $conn->query($sql);

        if(!$result) {
            die("Query failed at set_avatar: " . $conn->error);
        }

        return true;
    }

    function get_user_avatar($user_id) {
        global $conn;

        $sql = "SELECT avatar FROM users WHERE id = $user_id;";
        $result = $conn->query($sql);

        if(!$result) {
            die("Query failed at get_user_avatar: " . $conn->error);
        }

        return $result->fetch_assoc();
    }

    $function_name = $_GET["function_name"] ?? "";

    if($function_name == "get_adjectives"){
        echo json_encode(get_adjectives($_POST["alphabet"]));
    }
    else if($function_name == "create_bio_about"){
        echo json_encode(create_bio_about($_POST["student_id"], $_POST["content"] ?? "", $_POST["type"]));
    }
    else if($function_name == "get_user_profile_progress"){
        echo json_encode(get_user_profile_progress($_POST["user_id"]));
    }
    else if($function_name == "updateIncompleteAdjectives"){
        echo json_encode(updateIncompleteAdjectives($_POST["student_id"], $_POST["adjectives"]));
    }
    else if($function_name == "getIncompleteAdjectives"){
        echo json_encode(getIncompleteAdjectives($_POST["student_id"]));
    }
    else if($function_name == "get_avatars"){
        echo json_encode(get_avatars());
    }
    else if($function_name == "set_avatar") {
        echo json_encode(set_avatar($_POST["user_id"], $_POST["avatar"]));
    }
    else if($function_name == "get_user_avatar") {
        echo json_encode(get_user_avatar($_POST["user_id"]));
    }
?>