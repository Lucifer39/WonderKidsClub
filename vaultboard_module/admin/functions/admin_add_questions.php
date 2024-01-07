<?php 
    $dir = __DIR__;
    $parentdir = dirname(dirname($dir));

    require_once($parentdir . "/connection/dependencies.php");
    require_once($parentdir . "/vocabulary_module/functions/flag.php");

    class DataList{
        public $id;
        public $option;
        public function __construct($obj){
            $this->id = $obj["id"];
            $this->option = $obj["option_name"];
        }
    }

    function get_datalist_options($universe, $subst){
        $conn = makeConnection();
        $table = change_topic("table", $universe);
        $col = change_topic("main_table_col", $universe);

        $sql = "SELECT id, $col as option_name FROM $table WHERE $col LIKE '$subst%'";
        // echo $sql;
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_datalist_options: ". $conn->error);
        }

        $res_array = array();

        while($row = $result->fetch_assoc()){
            $obj = new DataList($row);
            array_push($res_array, $obj);
        }

        return $res_array;
    }

    function insert_questions($universe, $id, $question, $options, $answer){
        $conn = makeConnection();

        $table = change_topic("questions", $universe);
        $id_col = change_topic("id", $universe);

        $sql = "INSERT INTO $table ($id_col, question, options, answer) VALUES (?,?,?,?);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isss", $id, $question, $options, $answer);

        if(mysqli_stmt_execute($stmt)){
            return true;
        }
        else{
            return $conn->error;
        }
    }

    $function_name = $_GET["function_name"] ?? "";
    if($function_name == "insert_questions"){
        echo json_encode(insert_questions($_POST["universe"], $_POST["id"], $_POST["question"], $_POST["options"], $_POST["answer"]));
    }
    else if($function_name == "get_datalist_options"){
        echo json_encode(get_datalist_options($_POST["universe"], $_POST["subst"]));
    }
?>