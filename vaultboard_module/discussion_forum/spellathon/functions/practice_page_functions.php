<?php 
    $dir = __DIR__;
    $parentdir = dirname(dirname($dir));
    require_once($parentdir . "/connection/dependencies.php");

    class Word{
        public $content;
        public $meaning;
        public $question_type;
        public function __construct($obj){
            $this->content = $obj["word"];
            $this->meaning = $obj["meaning"];
            $this->question_type = $obj["question_type"];
        }
    }

    function get_questions(){
        $conn = makeConnection();
        $student_group = getClassGroup();

        $sql = "SELECT * 
                FROM spellathon_words 
                WHERE relevance = ". $student_group["group_name"] ." 
                ORDER BY RAND() 
                LIMIT 10;";
                
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed get_questions: ". $conn->error);
        }

        $array_res =array();

        while($row = $result->fetch_assoc()){
            $word_obj = new Word($row);
            array_push($array_res, $word_obj);
        }

        return $array_res;
    }

    $function_name = $_GET["function_name"] ?? "";
    if($function_name == "get_questions"){
        echo json_encode(get_questions());
    }
?>