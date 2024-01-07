<?php

use JetBrains\PhpStorm\Deprecated;

    require_once("conn.php");

    session_start();

    $id_of_student = isset($_SESSION["student_id"]) ? $_SESSION["student_id"] : "";
    $guest_class = isset($_SESSION["guest_class"]) ? $_SESSION["guest_class"] : "";
    $guest_modal = isset($_COOKIE["guest_modal"]) ? $_COOKIE["guest_modal"] : false;

    // echo $id_of_student;

    function setID($student_id){
        $_SESSION["student_id"] = $student_id;
        // echo $_SESSION["student_id"];
        return true;
    }

    function setRootID($student_id){
        $_SESSION["id"] = $student_id;
        // echo  $_SESSION["id"];
        return true;
    }

    function getID() {
        $id_of_student = isset($_SESSION["student_id"]) ? $_SESSION["student_id"] : "";
        return $id_of_student;
    }

    function setGuest($guest_class){
        $_SESSION["guest_class"] = $guest_class;
        return true;
    }

    function getGuest() {
        $guest_class = isset($_SESSION["guest_class"]) ? $_SESSION["guest_class"] : "";
        return $guest_class;
    }

    function getGuestModal(){
        global $guest_modal;
        return $guest_modal;
    }

    function setGuestModal(){
        $expiry = time() + 3600;

        // Set the cookie value
        $cookieValue = true;

        // Set the cookie
        setcookie('guest_modal', $cookieValue, $expiry, '/');
    }

    function getClassGroup(){
        $conn = makeConnection();
        $student = getCurrentStudent();

        if(!$student){
            $guestClass = getGuest();
            $sql = "SELECT group_name FROM class_group WHERE class_collection LIKE '%". $guestClass ."%' LIMIT 1";

            $result = $conn->query($sql);

            if(!$result){
                die("Query failed in getClassGroup: ". $conn->error);
            }

        return $result->fetch_assoc();
        }

        $sql = "SELECT group_name FROM class_group WHERE class_collection LIKE '%". $student["class"] ."%' LIMIT 1";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed in getClassGroup: ". $conn->error);
        }

        return $result->fetch_assoc();
    }


    function getStudent($student_id){
        $conn = makeConnection();

        $sql = "SELECT u.id, u.fullname AS name, u.email, u.contact, sc.vocab_class AS class, u.avatar, sm.name AS school 
                FROM users u
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id
                WHERE u.id = '$student_id';";

        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed in getStudent: " . $conn->error);
        }

        return $result->fetch_assoc();
    }

    function getCurrentStudent(){
        $conn = makeConnection();
        $id_of_student = getID();

        $sql = "SELECT u.id, u.fullname AS name, u.email, u.contact, sc.vocab_class AS class, u.avatar, sm.name AS school 
                FROM users u
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id
                WHERE u.id = '$id_of_student';";

        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed in getCurrentStudent: " . $conn->error);
        }

        return $result->fetch_assoc();

    }
    function getCurrentAdmin(){
        $conn = makeConnection();
        $id_of_student = getID();

        $sql = "SELECT u.fullname, u.isAdmin 
                FROM users u
                WHERE u.id = '$id_of_student';";

        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed in getCurrentStudent: " . $conn->error);
        }

        return $result->fetch_assoc();

    }
    function getCompetitionParents(){
        $conn = makeConnection();

        $sql = "SELECT * FROM parentsshare";

        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed in getCurrentStudent: " . $conn->error);
        }

        $fin_array = array();

        while($row = $result->fetch_assoc()) {
            $fin_array[] = $row;
        }

        return $fin_array;

    }
    function getCompetitionOrg(){
        $conn = makeConnection();

        $sql = "SELECT * FROM organizationshare";

        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed in getCurrentStudent: " . $conn->error);
        }

        $fin_array = array();

        while($row = $result->fetch_assoc()) {
            $fin_array[] = $row;
        }

        return $fin_array;

    }

    function getCompetitionAdmin(){
        $conn = makeConnection();

        $sql = "SELECT * FROM displaydetails";

        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed in getCurrentStudent: " . $conn->error);
        }

        $fin_array = array();

        while($row = $result->fetch_assoc()) {
            $fin_array[] = $row;
        }

        return $fin_array;
    }

    class Student{
        public $id;
        public $name;
        public $class;
        public $email;
        public $school;
        public $avatar;

        public function __construct($id, $name, $class, $email, $school, $avatar){
            $this->id = $id;
            $this->name = $name;
            $this->class = $class;
            $this->email = $email;
            $this->school = $school;
            $this->avatar = $avatar;
        }
    }

    function getStudents(){
        $conn = makeConnection();

        $sql = "SELECT u.id, u.fullname AS name, u.email, u.contact, sc.vocab_class AS class, u.avatar, u.name, sm.name AS school 
                FROM users u
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id;";

        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed in getStudents: " . $conn->error);
        }

        $student_array = array();

        while($row = $result->fetch_assoc()){
            $obj = new Student($row["id"], $row["name"], $row["class"], $row["email"], $row["school"], $row["avatar"]);
            array_push($student_array, $obj);
        }

        return $student_array;
    }

    function register($name, $first_name, $last_name, $school, $class, $age, $avatar, $password, $email){
        $conn = makeConnection();

        $sql = "INSERT INTO students (name, first_name, last_name, school, class, age, avatar, password, email) VALUES (?,?,?,?,?,?,?,?,?);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssisss", $name, $first_name, $last_name, $school, $class, $age, $avatar, $password, $email);

        if(mysqli_stmt_execute($stmt)){
            return true;
        }
        else{
            die("Query failed at register: ". mysqli_stmt_error($stmt));
        }
    }

    function getSchools(){
        $conn = makeConnection();

        $sql = "SELECT school FROM students GROUP BY school;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at getSchools: ". $conn->error);
        }

        $res_array = array();

        while($row = $result->fetch_assoc()){
            array_push($res_array, $row["school"]);
        }

        return $res_array;
    }

    function getClasses(){
        $conn = makeConnection();

        $sql = "SELECT class FROM students GROUP BY class;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at getClasses: ". $conn->error);
        }

        $res_array = array();

        while($row = $result->fetch_assoc()){
            array_push($res_array, $row["class"]);
        }

        return $res_array;
    }

    function getUsername($username){
        $conn = makeConnection();

        $sql = "SELECT name FROM students WHERE name = '$username' ;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at getUsername: ". $conn->error);
        }

        if(mysqli_num_rows($result) == 0){
            return true;
        }
        else{
            return false;
        }
    }

    function login($username, $password){
        $conn = makeConnection();

        $sql = "SELECT id FROM students WHERE name = '$username' AND password = '$password';";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at login: ". $conn->error);
        }

        if(mysqli_num_rows($result) == 1){
            $res = $result->fetch_assoc();
            setID($res["id"]);
            setRootID($res["id"]);
            setGuest("");
            return true;
        }
        else {
            return false;
        }
    }
    function loginadmin($username, $password){
        $conn = makeConnection();

        $sql = "SELECT id FROM admin WHERE username = '$username' AND password = '$password';";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at login: ". $conn->error);
        }

        if(mysqli_num_rows($result) == 1){
            $res = $result->fetch_assoc();
            setID($res["id"]);
            return true;
        }
        else {
            return false;
        }
    }

    function check_about(){
        $student_id = getID();
        $conn = makeConnection();

        $sql = "SELECT bio, adjectives FROM student_about WHERE student_id = $student_id ;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed check_about: ". $conn->error);
        }

        $res = $result->fetch_assoc();

        if(mysqli_num_rows($result) == 0){
            return true;
        }
        else {
            if($res && ($res["bio"] == null || $res["adjectives"] == null)){
                return true;
            }
            return false;
        }
    }

    function get_profile_completion() {
        $student_id = getID();
        $conn = makeConnection();
    
        $sql = "SELECT bio, adjectives FROM student_about WHERE student_id = $student_id ;";
        $result = $conn->query($sql);
    
        if (!$result) {
            die("Query failed get_profile_completed: " . $conn->error);
        }
    
        $res = $result->fetch_assoc();
    
        if (!$res) {
            return 0; // No results, so completion is 0%
        }
    
        $total = 0;
        $completed = 0;
    
        // print_r($res);
    
        foreach ($res as $check) {
            $total++;
            if ($check !== null) {
                $completed++;
            }
        }
    
        // Calculate the percentage only if there are fields to count
        if ($total > 0) {
            return ($completed / $total) * 100;
        }
    
        return 0; // Default to 0 if there are no fields
    }

    function setAvatarUsername($avatar, $username) {
        $conn = makeConnection();
        $student_id = getID();

        $sql = "UPDATE users 
                SET avatar = '$avatar', name = '$username' 
                WHERE id = $student_id";

        $result = $conn->query($sql);
        if(!$result) {
            die("Query failed at setAvatarUsername: " . $conn->error);
        }

        return true;
    }


    $function_name = $_GET["function_name"] ?? "";

    if($function_name == "getUsername"){
        echo json_encode(getUsername($_POST["username"] ?? ""));
    }
    else if($function_name == "register"){
        echo json_encode(register($_POST["username"], $_POST["firstName"], $_POST["lastName"], $_POST["school"], $_POST["classValue"], $_POST["age"], $_POST["avatar"], $_POST["password"], $_POST["email"]));
    }
    else if($function_name == "login"){
        echo json_encode(login($_POST["username"] ?? "", $_POST["password"] ?? ""));
    }
    else if($function_name == "loginadmin"){
        echo json_encode(loginadmin($_POST["username"] ?? "", $_POST["password"] ?? ""));
    }
    else if($function_name == "setGuest"){
        echo json_encode(setGuest($_POST["guestClass"]));
    }
    else if($function_name == "setGuestModal"){
        setGuestModal();
    }
    else if($function_name == "setAvatarUsername") {
        echo json_encode(setAvatarUsername($_POST["avatar"], $_POST["username"]));
    }

    // if($function_name == "logout"){
    //     $student_id = $_POST["student_id"];
    //     logout($student_id);
    // }
?>