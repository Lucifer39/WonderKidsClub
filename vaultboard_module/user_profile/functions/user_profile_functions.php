<?php 
    $dir = __DIR__;
    $parentdir = dirname(dirname($dir));

    require_once($parentdir . "/connection/dependencies.php");

    function get_user_details($user_id){
        $conn = makeConnection();

        $sql = "SELECT s.id, s.name, s.fullname, sm.name AS school, sc.vocab_class AS class , s.avatar, s.email, sa.bio, sa.adjectives 
                FROM users s
                JOIN school_management sm
                ON sm.id = s.school
                JOIN subject_class sc
                ON sc.id = s.class
                LEFT JOIN student_about sa ON sa.student_id = s.id
                WHERE s.id =  $user_id;" ;

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_user_details: ". $conn->error);
        }

        return $result->fetch_assoc();
    }

    function saveFile($file, $file_type) {
        $dir = __DIR__;
        $parentdir = dirname($dir);

        $targetDir = $parentdir ."/media_bucket/achievements/$file_type/"; // Specify the target folder where you want to save the files
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION); // Get the file extension
        $fileName = uniqid('', true) . '.' . $extension; // Generate a unique file name using the current timestamp and random string
        $targetPath = $targetDir . $fileName; // Concatenate the target directory and the file name
      
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
          return json_encode($fileName); // Return the complete file name with the extension if the file is successfully saved
        } else {
          return json_encode(false); // Return false if there was an error in saving the file
        }
      }

      function save_achievement($student_id, $file_name, $file_type){
        $conn = makeConnection();

        $sql = "INSERT INTO student_achievements (student_id, file_name, file_type) VALUES (?,?,?);";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "iss", $student_id, $file_name, $file_type);

        if(mysqli_stmt_execute($stmt)){
            return true;
        }
        else{
            return false;
        }
      }

      class Achievement{
        public $student_id;
        public $file_name;
        public $file_type;
        public function __construct($obj){
            $this->student_id = $obj["student_id"];
            $this->file_name = $obj["file_name"];
            $this->file_type = $obj["file_type"];
        }
      }

      function get_achievements($student_id){
        $conn = makeConnection();

        $sql = "SELECT * FROM student_achievements WHERE student_id = $student_id;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_achievements: ". $conn->error);
        }

        $res_array = array();

        while($row = $result->fetch_assoc()){
            $obj = new Achievement($row);
            array_push($res_array, $obj);
        }


        return $res_array;
      }

      function get_score_across_modules($user_id){
        $conn = makeConnection();

        $sql = "SELECT s.id, s.name, vs.score as words_score, vi.score as idioms_score, 
                vsi.score as simile_score, vm.score as metaphor_score, vh.score as hyperbole_score, 
                ts.points as type_score
                FROM users s
                LEFT JOIN vocab_students vs
                ON vs.student_id = s.id
                LEFT JOIN vocab_students_idioms vi
                ON vi.student_id = s.id
                LEFT JOIN vocab_students_simile vsi
                ON vsi.student_id = s.id
                LEFT JOIN vocab_students_metaphor vm
                ON vm.student_id = s.id
                LEFT JOIN vocab_students_hyperbole vh
                ON vh.student_id = s.id
                LEFT JOIN type_students ts
                ON ts.student_id = s.id
                WHERE s.id = $user_id;";

        $result = $conn->query($sql);

        if(!$result){
          die("Query failed at get_scores_modules: ". $conn->error);
        }

        return $result->fetch_assoc();
      }

      $function_name = $_GET["function_name"] ?? "";

      if($function_name == "save_file"){
        echo saveFile($_FILES["file"], $_POST["file_type"]);
      }

      else if($function_name == "save_achievement"){
        echo json_encode(save_achievement($_POST["student_id"], $_POST["file_name"], $_POST["file_type"]));
      }

      else if($function_name == "get_achievement"){
        echo json_encode(get_achievements($_POST["student_id"]));
      }
      
      else if($function_name == "get_scores_across_modules"){
        echo json_encode(get_score_across_modules($_POST["user_id"]));
      }
?>