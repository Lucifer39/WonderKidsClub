<?php 
//Compare 3 numbers upto 10, ascending descending
if($sbtpName == '52' || $sbtpName == '53' || $sbtpName == '54' || $sbtpName == '55' || $sbtpName == '56') {
   $bftaft = rand($before,$after);

   if($sbtpName == '52') {
        $asc_desc_value = "0,99";
        $count = 4;
   } elseif($sbtpName == '53') {
        $asc_desc_value = "0,999";
        $count = 4;
    } elseif($sbtpName == '54') {
        $asc_desc_value = "0,9999";
        $count = 4;
    } elseif($sbtpName == '55') {
        $asc_desc_value = "0,99999";
        $count = 4;
    } elseif($sbtpName == '56') {
        $asc_desc_value = "0,999999";
        $count = 4;
    }

//Ascending
if($bftaft == '0') {
    $question = "Which of the following series is in Ascending Order?";
    $correct = implode(', ',generateRandomASCNumbers($asc_desc_value, $count));

    $opt_a = $correct;
    $opt_b = implode(', ',generateRandomDESCNumbers($asc_desc_value, $count));

    if($opt_a != $opt_b) {
        $opt_c_temp = generateRandomASCNumbers($asc_desc_value, $count);
        $counter_value = 0;
        do{
            $first_ind = mt_rand(0, count($opt_c_temp) - 1);
            $second_ind = mt_rand(0, count($opt_c_temp) - 1);
            $counter_value++;
        } while($counter_value <= 100 && $first_ind == $second_ind);
        swapElements($opt_c_temp, $first_ind, $second_ind);
        $opt_c = implode(', ', $opt_c_temp);

    if($opt_a != $opt_c && $opt_b != $opt_c && $counter_value < 100) {
        $opt_d_temp = generateRandomASCNumbers($asc_desc_value, $count);
        $counter_value = 0;
        do{
            $first_ind = mt_rand(0, count($opt_d_temp) - 1);
            $second_ind = mt_rand(0, count($opt_d_temp) - 1);
            $counter_value++;
        } while($counter_value <= 100 && $first_ind == $second_ind);
        swapElements($opt_d_temp, $first_ind, $second_ind);
        $opt_d = implode(', ', $opt_d_temp);

    if($opt_a != $opt_d && $opt_b != $opt_d && $opt_c != $opt_d && $counter_value < 100) {
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
if($bftaft == '1') {
    $question = "Which of the following series is in Descending Order?";
    $correct = implode(', ',generateRandomDESCNumbers($asc_desc_value,$count));

    $opt_a = $correct;
    $opt_b = implode(', ',generateRandomASCNumbers($asc_desc_value,$count));
    
    if($opt_a != $opt_b) {
        $opt_c_temp = generateRandomDESCNumbers($asc_desc_value, $count);
        $counter_value = 0;
        do{
            $first_ind = mt_rand(0, count($opt_c_temp) - 1);
            $second_ind = mt_rand(0, count($opt_c_temp) - 1);
            $counter_value++;
        } while($counter_value <= 100 && $first_ind == $second_ind);
        swapElements($opt_c_temp, $first_ind, $second_ind);
        $opt_c = implode(', ', $opt_c_temp);

    if($opt_a != $opt_c && $opt_b != $opt_c && $counter_value < 100) {

        $opt_d_temp = generateRandomDESCNumbers($asc_desc_value, $count);
        $counter_value = 0;
        do{
            $first_ind = mt_rand(0, count($opt_d_temp) - 1);
            $second_ind = mt_rand(0, count($opt_d_temp) - 1);
            $counter_value++;
        } while($counter_value <= 100 && $first_ind == $second_ind);
        swapElements($opt_d_temp, $first_ind, $second_ind);
        $opt_d = implode(', ', $opt_d_temp);

    if($opt_a != $opt_d && $opt_b != $opt_d && $opt_c != $opt_d && $counter_value < 100) {
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