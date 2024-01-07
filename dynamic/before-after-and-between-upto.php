<?php 
//Before, after and between upto 10, 20, 100
if($sbtpName == '6' || $sbtpName == '11' || $sbtpName == '40') {
    $bftaft = rand($before,$between);

    if($sbtpName == '6') {
        $numValue = '10';
    } elseif($sbtpName == '11') {
        $numValue = '20';
    } elseif($sbtpName == '40') {
        $numValue = '100';
    }
    //Before - Between
    if($bftaft == '0') {
    
        $quest_1 = rand(2,$numValue);				
        $aftquest_1 = $quest_1-2;
        $quest_2 = rand(0,$aftquest_1);			
        $question = "What comes before ".$quest_1." but after ".$quest_2."?";
        $correct = randomNumber($quest_2,$quest_1,[$quest_2,$quest_1]);

        $total = range(0,$numValue);
        $exclude = range($quest_2,$quest_1);

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

    //After - Between
    if($bftaft == '1') {
    
        $quest_1 = rand(2,$numValue);				
        $aftquest_1 = $quest_1-2;
        $quest_2 = rand(0,$aftquest_1);			
        $question = "What comes after ".$quest_2." but before ".$quest_1."?";
        $correct = randomNumber($quest_2,$quest_1,[$quest_2,$quest_1]);

        $total = range(0,$numValue);
        $exclude = range($quest_2,$quest_1);

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

    //Between
    if($bftaft == '2') {
    
        $quest_1 = rand(2,$numValue);				
        $aftquest_1 = $quest_1-2;
        $quest_2 = rand(0,$aftquest_1);			
        $question = "What comes between ".$quest_2." and ".$quest_1."?";
        $correct = randomNumber($quest_2,$quest_1,[$quest_2,$quest_1]);

        $total = range(0,$numValue);
        $exclude = range($quest_2,$quest_1);

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

            $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=2 and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
            $befrow = mysqli_fetch_assoc($befsql);
            if($befrow['question'] == '') {
                mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type,question,correct_ans,opt_a,opt_b,opt_c,opt_d,created_at,updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$between."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())" );				
            }
        }
    }
        }
    
    } 

}   

/*//Before, after and between upto 20
if($sbtpName == '11') {
    $bftaft = rand($before,$between);
    //Before - Between
    if($bftaft == '0') {
    
        $quest_1 = rand(2,20);				
        $aftquest_1 = $quest_1-2;
        $quest_2 = rand(0,$aftquest_1);			
        $question = "What comes before ".$quest_1." but after ".$quest_2."?";
        $correct = randomNumber($quest_2,$quest_1,[$quest_2,$quest_1]);

        $total = range(0,20);
        $exclude = range($quest_2,$quest_1);

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

    //After - Between
    if($bftaft == '1') {
    
        $quest_1 = rand(2,20);				
        $aftquest_1 = $quest_1-2;
        $quest_2 = rand(0,$aftquest_1);			
        $question = "What comes after ".$quest_2." but before ".$quest_1."?";
        $correct = randomNumber($quest_2,$quest_1,[$quest_2,$quest_1]);

        $total = range(0,20);
        $exclude = range($quest_2,$quest_1);

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

    //Between
    if($bftaft == '2') {
    
        $quest_1 = rand(2,20);				
        $aftquest_1 = $quest_1-2;
        $quest_2 = rand(0,$aftquest_1);			
        $question = "What comes between ".$quest_2." and ".$quest_1."?";
        $correct = randomNumber($quest_2,$quest_1,[$quest_2,$quest_1]);

        $total = range(0,20);
        $exclude = range($quest_2,$quest_1);

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

            $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=2 and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
            $befrow = mysqli_fetch_assoc($befsql);
            if($befrow['question'] == '') {
                mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type,question,correct_ans,opt_a,opt_b,opt_c,opt_d,created_at,updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$between."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())" );				
            }
        }

        }
    }
    
    } 

} 

//Before, after and between upto 20
if($sbtpName == '40') {
    $bftaft = rand($before,$between);
    //Before - Between
    if($bftaft == '0') {
    
        $quest_1 = rand(2,100);				
        $aftquest_1 = $quest_1-2;
        $quest_2 = rand(0,$aftquest_1);			
        $question = "What comes before ".$quest_1." but after ".$quest_2."?";
        $correct = randomNumber($quest_2,$quest_1,[$quest_2,$quest_1]);

        $total = range(0,100);
        $exclude = range($quest_2,$quest_1);

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

    //After - Between
    if($bftaft == '1') {
    
        $quest_1 = rand(2,100);				
        $aftquest_1 = $quest_1-2;
        $quest_2 = rand(0,$aftquest_1);			
        $question = "What comes after ".$quest_2." but before ".$quest_1."?";
        $correct = randomNumber($quest_2,$quest_1,[$quest_2,$quest_1]);

        $total = range(0,100);
        $exclude = range($quest_2,$quest_1);

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

    //Between
    if($bftaft == '2') {
    
        $quest_1 = rand(2,100);				
        $aftquest_1 = $quest_1-2;
        $quest_2 = rand(0,$aftquest_1);			
        $question = "What comes between ".$quest_2." and ".$quest_1."?";
        $correct = randomNumber($quest_2,$quest_1,[$quest_2,$quest_1]);

        $total = range(0,100);
        $exclude = range($quest_2,$quest_1);

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

            $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=2 and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
            $befrow = mysqli_fetch_assoc($befsql);
            if($befrow['question'] == '') {
                mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type,question,correct_ans,opt_a,opt_b,opt_c,opt_d,created_at,updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$between."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())" );				
            }
        }
    }
        }
    
    } 

} */
?>