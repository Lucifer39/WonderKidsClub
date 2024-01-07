<?php 
    $dir = __DIR__;
    $parentdir = dirname(dirname($dir));
    require_once($parentdir . "/connection/dependencies.php");

    function get_leaderboard($room_id){
        $conn = makeConnection();
        $sql = "SELECT u.id, u.name, sm.name AS school , sc.vocab_class AS class, u.avatar, srp.score
                FROM spellathon_room_players srp
                INNER JOIN users u
                ON u.id = srp.student_id
                JOIN subject_class sc
                ON u.class = sc.id
                JOIN school_management sm
                ON u.school = sm.id
                WHERE room_id = $room_id
                AND completed = 1
                ORDER BY score DESC;";

        $result = $conn->query($sql);

        if(!$result){
            die("Query failed at get_leaderboard: ". $conn->error);
        }

        $res_array = array();

        while($row = $result->fetch_assoc()){
            array_push($res_array, $row);
        }

        return $res_array;
    }
?>