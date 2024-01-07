<?php
if($sbtpName == '15' || $sbtpName == '19' || $sbtpName == '263') {
    $bftaft = rand($before,$after);
    //Fewer Objects
    if($bftaft == '0') {
        
        $quest_1 = '2';
        $question = "Which of the following is the shortest?";
        $correct = $quest_1;

        $total = range(2,5);
        $exclude = range(2,$quest_1);

        $opt_a = $correct;
        $opt_b = $total[array_rand(array_diff($total,$exclude))];
        if($opt_a != $opt_b) {
        $opt_c = $total[array_rand(array_diff($total,$exclude))];
        if($opt_a != $opt_c && $opt_b != $opt_c) {
            $opt_d = $total[array_rand(array_diff($total,$exclude))];
            
            if($opt_a!= $opt_d && $opt_b != $opt_d && $opt_c != $opt_d) {

        $names = array("$opt_a", "$opt_b", "$opt_c", "$opt_d");
                shuffle($names);
                $chunks = array_chunk($names, 2);
                $rearrange = array_merge($chunks[1], $chunks[0]);

            $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=0 and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
            $befrow = mysqli_fetch_assoc($befsql);
            if($befrow['question'] == '') {
                if($sbtpName == '263') {
                    $extra = '19';
                } else {
                    $extra = 'none';
                }
                mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type,question,correct_ans,opt_a,opt_b,opt_c,opt_d,created_at,updated_at, shape_info) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$bftaft."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW(), '".$extra."')" );				
            }
        }

        }
    }

    }

    //More Objects
    if($bftaft == '1') {
        
        $quest_1 = '5';
        $question = "Which of the follwing objects is the tallest?";
        $correct = $quest_1;

        $total = range(2,5);
        $exclude = range(5,$quest_1);

        $opt_a = $correct;
        $opt_b = $total[array_rand(array_diff($total,$exclude))];
        if($opt_a != $opt_b) {
        $opt_c = $total[array_rand(array_diff($total,$exclude))];
        if($opt_a != $opt_c && $opt_b != $opt_c) {
            $opt_d = $total[array_rand(array_diff($total,$exclude))];
            
            if($opt_a!= $opt_d && $opt_b != $opt_d && $opt_c != $opt_d) {

        $names = array("$opt_a", "$opt_b", "$opt_c", "$opt_d");

        shuffle($names);
        $chunks = array_chunk($names, 2);
        $rearrange = array_merge($chunks[1], $chunks[0]);

            $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=1 and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
            $befrow = mysqli_fetch_assoc($befsql);
            if($befrow['question'] == '') {
                if($sbtpName == '263') {
                    $extra = '19';
                } else {
                    $extra = 'none';
                }
                mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type,question,correct_ans,opt_a,opt_b,opt_c,opt_d,created_at,updated_at, shape_info) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$bftaft."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW(), '".$extra."')" );				
            }
        }

        }
    }

    }
        
        

    }
?>