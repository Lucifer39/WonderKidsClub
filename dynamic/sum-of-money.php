<?php
if(in_array($sbtpName, array('34'))){
    $bftaft = '0';

        $numbers = array(1, 2, 5, 10);
        $random_index = array_rand($numbers);
        $quest = $numbers[$random_index];

        $question = "What is the value of money shown?";
        $correct = $quest;

        $exclude_value = $quest;
        $key = array_search($exclude_value, $quest);
        if ($key !== false) { unset($numbers[$key]); }

        $random_index = array_rand($numbers);
        $random_value = $numbers[$random_index];

        $opt_a = $correct;
        $opt_b = $random_value;
        if($opt_a != $opt_b) {
        $random_index = array_rand($numbers);
        $random_value = $numbers[$random_index];

        $opt_c = $random_value;
        if($opt_a != $opt_c && $opt_b != $opt_c) {

          $random_index = array_rand($numbers);
          $random_value = $numbers[$random_index];

            $opt_d = $random_value;
            
            if($opt_a!= $opt_d && $opt_b != $opt_d && $opt_c != $opt_d) {

                $names = array("$opt_a", "$opt_b", "$opt_c", "$opt_d");

                shuffle($names);
                $chunks = array_chunk($names, 2);
                $rearrange = array_merge($chunks[1], $chunks[0]);

            $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=".$bftaft." and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
            $befrow = mysqli_fetch_assoc($befsql);
            if($befrow['question'] == '') {
                mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type,question,correct_ans,opt_a,opt_b,opt_c,opt_d,created_at,updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$bftaft."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())" );				
            }
        }

        }
    }

    }  
    
 // For Prep
 if($sbtpName == '35' || $sbtpName == '197' || $sbtpName == '198' || $sbtpName == '199' || $sbtpName == '200' || $sbtpName == '201') {
    $bftaft = '0';

        $numbers = array(0.5,1, 2, 5, 10,20);
        $random_index = array_rand($numbers);
        $quest = $numbers[$random_index];

        $question = "What is the value of money shown?";
        $correct = $quest;

        $exclude_value = $quest;
        $key = array_search($exclude_value, $quest);
        if ($key !== false) { unset($numbers[$key]); }

        $random_index = array_rand($numbers);
        $random_value = $numbers[$random_index];

        $opt_a = $correct;
        $opt_b = $random_value;
        if($opt_a != $opt_b) {
        $random_index = array_rand($numbers);
        $random_value = $numbers[$random_index];

        $opt_c = $random_value;
        if($opt_a != $opt_c && $opt_b != $opt_c) {

          $random_index = array_rand($numbers);
          $random_value = $numbers[$random_index];

            $opt_d = $random_value;
            
            if($opt_a!= $opt_d && $opt_b != $opt_d && $opt_c != $opt_d) {

                $names = array("$opt_a", "$opt_b", "$opt_c", "$opt_d");

                shuffle($names);
                $chunks = array_chunk($names, 2);
                $rearrange = array_merge($chunks[1], $chunks[0]);

            $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=".$bftaft." and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
            $befrow = mysqli_fetch_assoc($befsql);
            if($befrow['question'] == '') {
                mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type,question,correct_ans,opt_a,opt_b,opt_c,opt_d,created_at,updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$bftaft."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())" );				
            }
        }

        }
    }

    }     
?>