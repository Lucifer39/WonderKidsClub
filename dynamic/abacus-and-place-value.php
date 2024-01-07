<?php 
//Abacus and Place value
if (in_array($sbtpName, ['57', '58', '59', '60', '61'])) {
   $bftaft = rand($before,$after);

   if($sbtpName == '57') {
        $number = rand(0,100);
        $place_val = placeValueIndianNumber($number);
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

//Place Value
if($bftaft == '0') {
    echo $question = "What is the place value representation of the number ".$number."?";
    $correct = $place_val;

    $opt_a = $correct;

    $resultArray = numberToPlaceValueArray($number);

$randomKey = array_rand($resultArray);

// Access the random element using the random key/index
$randomValue = $resultArray[$randomKey];

$value = removeWordsAfterDigit($correct);

// Declare an array to store the parts of the value
$parts = [];

// Loop through the value and split it by the comma
foreach (explode(", ", $value) as $part) {
  // Add the part to the array
  $parts[] = $part;
}

 echo implode(", ", $parts);
    
    $opt_b = implode(', ',generateRandomDESCNumbers($asc_desc_value, $count));
    die();
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

}
?>