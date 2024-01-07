<?php 
if($sbtpName == '41' || $sbtpName == '42') {
    $bftaft = rand($before,$after);

    if ($sbtpName == '41') {
        $mathnumbers = array(2,3,5,10);
        $mathrandomNumberKey = array_rand($mathnumbers);
        echo $mathrandomNumber = $mathnumbers[$mathrandomNumberKey];
    } elseif ($sbtpName == '42') {
        $mathrandomNumber = 2;   
    }

            $numbers = array();
            for ($j = 1; $j <= 10; $j++) {
            $numbers[] = $mathrandomNumber * $j;
    }

    $randomNumberKey = array_rand($numbers);
    $randomNumber = $numbers[$randomNumberKey];

    if($bftaft == '0') {
     
    $quest_1 = $randomNumber;				
    echo $question = "Which of the following number appears in skip counting of ".$mathrandomNumber."?";

    do {
        $randomNumberKey = array_rand($numbers);
        $correct = $numbers[$randomNumberKey];
    } while ($correct == $quest_1);

    $total = range(0, $mathrandomNumber * 10);
    $exclude = $numbers;

    $opt_a = $correct;
    $opt_b = array_rand(array_diff($total, $exclude));

    if ($opt_a != $opt_b) {
        $opt_c = array_rand(array_diff($total, $exclude));

        if ($opt_a != $opt_c && $opt_b != $opt_c) {
            $opt_d = array_rand(array_diff($total, $exclude));

            if ($opt_a != $opt_d && $opt_b != $opt_d && $opt_c != $opt_d && $opt_a != 0 && $opt_b != 0 && $opt_c != 0 && $opt_d != 0) {
                $names = [];
                $names = array("$opt_a", "$opt_b", "$opt_c", "$opt_d");
                shuffle($names);
                $chunks = array_chunk($names, 2);
                $rearrange = array_merge($chunks[1], $chunks[0]);

                $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=0 and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
                $befrow = mysqli_fetch_assoc($befsql);

                if ($befrow['question'] == '') {
                    $question = $conn->real_escape_string($question);
                    mysqli_query($conn, "INSERT INTO count_quest(userid, class, subject, topic, subtopic, type, question, correct_ans, opt_a, opt_b, opt_c, opt_d, created_at, updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$before."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())");
                }
            }
        }
    }
    }

   if($bftaft == '1') {

        $quest_1 = $randomNumber;		
        $question = "Which of the following number doesn't appear in skip counting of ".$mathrandomNumber."?";
        
        $total = range(0,$mathrandomNumber*10);
        $correct = array_rand(array_diff($total,$numbers));
 

        $total = $numbers;
        $exclude = range($correct,$correct);

        $opt_a = $correct;
        $opt_b = $total[array_rand($total)];

        if($opt_a != $opt_b) {
        $opt_c = $total[array_rand($total)];
        if($opt_a != $opt_c && $opt_b != $opt_c) {
            $opt_d = $total[array_rand($total)];
            
            if($opt_a!= $opt_d && $opt_b != $opt_d && $opt_c != $opt_d && $opt_a != 0 && $opt_b != 0 && $opt_c != 0 && $opt_d != 0) {

                $names = array("$opt_a", "$opt_b", "$opt_c", "$opt_d");

                shuffle($names);
                $chunks = array_chunk($names, 2);
                $rearrange = array_merge($chunks[1], $chunks[0]);

            $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=1 and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
            $befrow = mysqli_fetch_assoc($befsql);
            if($befrow['question'] == '') {
                $question = $conn->real_escape_string($question);
                mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type,question,correct_ans,opt_a,opt_b,opt_c,opt_d,created_at,updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$after."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())" );			
            }
        }
    }
        }
    
    } 

}   //exit();
?>