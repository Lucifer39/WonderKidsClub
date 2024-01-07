<?php 
    $dir = __DIR__;
    $parentdir = dirname(dirname($dir));
    require_once($parentdir. "/connection/dependencies.php");

    class Context{
        public $id;
        public $name;
        public $banner_img;
        public $context_title;
        public function __construct($obj){
            $this->id = $obj["id"];
            $this->name = $obj["context_name"];
            $this->banner_img = $obj["banner_img"];
            $this->context_title = $obj["context_title"];
        }
    }
    function get_contexts(){
        $conn = makeConnection();
        
        $sql = "SELECT * FROM vocab_context;";

        $result = $conn->query($sql);
        if(!$result){
            die("Query has failed get_contexts: ". $conn->error);
        }

        $res_array = array();

        while($row = $result->fetch_assoc()){
            $obj = new Context($row);
            array_push($res_array, $obj);
        }

        return $res_array;
    }

    function get_context_table(){
        $conn = makeConnection();

        $sql = "SELECT vcd.id as date_id, vcd.context_date, vc.id as context_id, vc.context_name, vc.banner_img, vc.context_title 
                FROM vocab_context_dates vcd
                INNER JOIN vocab_context vc
                ON vcd.context_id = vc.id;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query has failed at get_context_table: ". $conn->error);
        }

        $res_array = array();
        while($row = $result->fetch_assoc()){
            array_push($res_array, $row);
        }

        return $res_array;
    }

    function add_date($context_id, $date){
        $conn = makeConnection();

        $dateObj = new DateTime($date);
        $mysqlDate = $dateObj->format('Y-m-d H:i:s');

        $sql = "INSERT INTO vocab_context_dates (context_id, context_date) VALUES (?,?);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "is", $context_id, $mysqlDate);

        if(mysqli_stmt_execute($stmt)){
            return true;
        }
        else{
            return false;
        }
    }

    $function_name = $_GET["function_name"] ?? "";
    if($function_name == "get_contexts"){
        echo json_encode(get_contexts());
    }
    else if($function_name == "get_context_table"){
        echo json_encode(get_context_table());
    }
    else if($function_name == "add_date"){
        echo json_encode(add_date($_POST["context_id"], $_POST["date"]));
    }
?>