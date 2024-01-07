<?php 
    $dir = __DIR__;
    $parentdir = dirname(dirname($dir));
    require_once($parentdir . "/connection/dependencies.php");

    class Context{
        public $context_id;
        public $context_name;
        public $context_subtitle;
        public $context_banner;
        public $context_description;
        public $context_title;
        public function __construct($obj){
            $this->context_id = $obj["id"];
            $this->context_name = $obj["context_name"];
            $this->context_subtitle = $obj["context_subtitle"];
            $this->context_banner = $obj["banner_img"];
            $this->context_description = $obj["context_description"];
            $this->context_title = $obj["context_title"];
        }
    }
    function get_contexts($filter, $category){
        $conn = makeConnection();
        $where = "";

        if($filter == "category"){
            $where = "WHERE vc.category_id = $category";
        }
        else if($filter == "starts_with"){
            $where = "WHERE vc.context_name LIKE '$category%'";
        }

        $sql = "SELECT * FROM vocab_context vc
                $where;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed for get_contexts: ". $conn->error);
        }

        $res_array = array();

        while($row = $result->fetch_assoc()){
            $obj = new Context($row);
            array_push($res_array, $obj);
        }

        return $res_array;
    }

    function get_context($context_id){
        $conn = makeConnection();

        $sql = "SELECT * FROM vocab_context WHERE id = $context_id ;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_context: ". $conn->error);
        }

        return $result->fetch_assoc();
    }

    class ContextWord{
        public $id;
        public $content;
        public $meaning;
        public $example;
        public function __construct($obj){
            $this->id = $obj["id"];
            $this->content = $obj["content"];
            $this->meaning = $obj["meaning"];
            $this->example = $obj["example"];
        }
    }
    function get_context_words($context_id){
        $conn = makeConnection();

        $sql = "SELECT * FROM vocab_context_table WHERE context_id LIKE '%$context_id%';";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_context_words: ". $conn->error);
        }

        $res_array = array();

        while($row = $result->fetch_assoc()){
            $obj = new ContextWord($row);
            array_push($res_array, $obj);
        }

        return $res_array;
    }

    class Categories {
        public $id;
        public $category;
        public function __construct($obj){
            $this->id = $obj["id"];
            $this->category = $obj["category"];
        }
    }

    function get_context_categories(){
        $conn = makeConnection();

        $sql = "SELECT * FROM vocab_context_categories;";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_context_categories: ". $conn->error);
        }

        $res_array = array();

        while($row = $result->fetch_assoc()){
            $obj = new Categories($row);
            array_push($res_array, $obj);
        }

        return $res_array;

    }

    $function_name = $_GET["function_name"] ?? "";
    if($function_name == "get_contexts"){
        echo json_encode(get_contexts($_POST["filter"], $_POST["category"]));
    }
    else if($function_name == "get_context"){
        echo json_encode(get_context($_POST["context_id"]));
    }
    else if($function_name == "get_context_words"){
        echo json_encode(get_context_words($_POST["context_id"]));
    }
    else if($function_name == "get_context_categories"){
        echo json_encode(get_context_categories());
    }
?>