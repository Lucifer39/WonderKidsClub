<?php 
//Compare 3 numbers upto 10, ascending descending
if($sbtpName == '7' || $sbtpName == '12') {
   $bftaft = rand($before,$more);

   if($sbtpName == '7') {
        $smallest = rand(0,7);
        $range = rand(0,10);
        $largest = rand(3,10);
        $num = 10;
        $asc_desc_value = "0,10";
        $count = 4;
   } elseif($sbtpName == '12') {
        $smallest = rand(0,17);
        $range = rand(0,20);
        $largest = rand(3,20);
        $num = 20;
        $asc_desc_value = "0,20";
        $count = 4;
   }

    //smallest
    if($bftaft == '0') {
        
        $quest_1 = $smallest;
        $question = "Which of the following number is the smallest?";
        $correct = $quest_1;

        $total = $range;
        $exclude = range(0,$quest_1);

        $opt_a = $correct;
        $opt_b = array_rand(array_diff($total,$exclude));
        if($opt_a != $opt_b) {
        $opt_c = array_rand(array_diff($total,$exclude));
        if($opt_a != $opt_c && $opt_b != $opt_c) {
            $opt_d = array_rand(array_diff($total,$exclude));
            
            if($opt_a!= $opt_d && $opt_b != $opt_d && $opt_c != $opt_d) {

                $names = array("$opt_a", "$opt_b", "$opt_c", "$opt_d");
                shuffle($names);
                $chunks = array_chunk($names, 2);
                $rearrange = array_merge($chunks[1], $chunks[0]);

            $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=0 and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
            $befrow = mysqli_fetch_assoc($befsql);
            if($befrow['question'] == '') {
                mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type,question,correct_ans,opt_a,opt_b,opt_c,opt_d,created_at,updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$before."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())" );				
            }
        }
    }
        }
        

    }

//Largest
if($bftaft == '1') {
    $quest_1 = $largest;
    $question = "Which of the following number is the largest?";
    $correct = $quest_1;

    $total = $range;
    $exclude = range($quest_1,$num);

    $opt_a = $correct;
    $opt_b = array_rand(array_diff($total,$exclude));
    
    if($opt_a != $opt_b) {
        $opt_c = array_rand(array_diff($total,$exclude));
    
    if($opt_a != $opt_c && $opt_b != $opt_c) {
    $opt_d = array_rand(array_diff($total,$exclude));

    if($opt_a!= $opt_d && $opt_b != $opt_d && $opt_c != $opt_d) {

    $names = array("$opt_a", "$opt_b", "$opt_c", "$opt_d");
    shuffle($names);
    $chunks = array_chunk($names, 2);
    $rearrange = array_merge($chunks[1], $chunks[0]);

    $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=1 and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
    $befrow = mysqli_fetch_assoc($befsql);
    if($befrow['question'] == '') {
    mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type,question,correct_ans,opt_a,opt_b,opt_c,opt_d,created_at,updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$after."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())" );				
    }
    }
    }
    }
}

//Ascending
if($bftaft == '2') {
    $question = "Which series is in Ascending Order?";
    $correct = implode(', ',generateRandomASCNumbers($asc_desc_value, $count));

    $opt_a = $correct;
    $opt_b = implode(', ',generateRandomDESCNumbers($asc_desc_value, $count));

    if($opt_a != $opt_b) {
        $opt_c = implode(', ',generateRandomDESCNumbers($asc_desc_value, $count));

    if($opt_a != $opt_c && $opt_b != $opt_c) {
        $opt_d = implode(', ',generateRandomDESCNumbers($asc_desc_value, $count));

    if($opt_a != $opt_d && $opt_b != $opt_d && $opt_c != $opt_d) {
        $names = array("$opt_a", "$opt_b", "$opt_c", "$opt_d");
        shuffle($names);
        $chunks = array_chunk($names, 2);
        $rearrange = array_merge($chunks[1], $chunks[0]);

        $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type='".$bftaft."' and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
        $befrow = mysqli_fetch_assoc($befsql);            
    if($befrow['question'] == '') {
        mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type,question,correct_ans,opt_a,opt_b,opt_c,opt_d,created_at,updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$bftaft."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())" );				
    }
    }
    }
    }
}

//Descending
if($bftaft == '3') {
    $question = "Which series is in Descending Order?";
    $correct = implode(', ',generateRandomDESCNumbers($asc_desc_value,$count));

    $opt_a = $correct;
    $opt_b = implode(', ',generateRandomASCNumbers($asc_desc_value,$count));
    
    if($opt_a != $opt_b) {
        $opt_c = implode(', ',generateRandomASCNumbers($asc_desc_value,$count));
    
    if($opt_a != $opt_c && $opt_b != $opt_c) {
        $opt_d = implode(', ',generateRandomASCNumbers($asc_desc_value,$count));

    if($opt_a != $opt_d && $opt_b != $opt_d && $opt_c != $opt_d) {
        $names = array("$opt_a", "$opt_b", "$opt_c", "$opt_d");
        shuffle($names);
        $chunks = array_chunk($names, 2);
        $rearrange = array_merge($chunks[1], $chunks[0]);

        $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type='".$bftaft."' and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
        $befrow = mysqli_fetch_assoc($befsql);            
    if($befrow['question'] == '') {
        mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type,question,correct_ans,opt_a,opt_b,opt_c,opt_d,created_at,updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$bftaft."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())" );				
    }
    }
    }
    }
}

}
?>