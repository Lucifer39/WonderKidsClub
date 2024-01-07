<?php 
if($sbtpName == '43' || $sbtpName == '45' || $sbtpName == '49' || $sbtpName == '50' || $sbtpName == '51') {
    $bftaft = rand($before,$after);

    if($sbtpName == '43') {
         $number = rand(10,99);
         $divideby = 100;
    } elseif($sbtpName == '45') {
        $number = rand(110,999);
        $divideby = 1000;
    } elseif($sbtpName == '49') {
        $number = rand(1110,9999);
        $divideby = 10000;
    } elseif($sbtpName == '50') {
        $number = rand(111110,999999);
        $divideby = 100000;
    } elseif($sbtpName == '51') {
        $number = rand(1111110,9999999);
        $divideby = 1000000;
    } 

    if($bftaft == '0') {

        $operation_obj = array(
            "normal",
            "addition",
            "subtraction",
        );

        $temp = $number;
        $operation = $operation_obj[array_rand($operation_obj)];
        
        if($operation == "addition") {
            $nu = mt_rand(5, $number - 1);
            $temp = $nu . " + " . ($number - $nu);
        }
        else if($operation == "subtraction") {
            $nu = mt_rand($number + 1, 2 * $number);
            $temp = $nu . " - " . ($nu - $number);
        }

	$question = "What is the expanded form of the number ".$temp."?";
    
    $correct = expandedForm($number);
    $opt_a = $correct;

    //opt_b



    // //opt_c
    // $numberArray = str_split($number);
    // $expandedForm = [];
    // $firstDigit = $numberArray[0] * pow(10, count($numberArray) - 1);
    // $expandedForm[] = $firstDigit;

    // for ($j = 1; $j < count($numberArray); $j++) {
    //     $expandedForm[] = $numberArray[$j];
    // }

    // $formattedNumber = implode(' + ', $expandedForm);
    // $opt_c = $formattedNumber;

    // //opt_d
    // $numbers = explode(' + ', $correct);
    // $firstNumber = intval($numbers[0]) / $divideby;
    // $modifiedNumber = $firstNumber . ' + ' . implode(' + ', array_slice($numbers, 1));
    // $opt_d = $modifiedNumber . "\n";

    if($sbtpName == '43'){

        $numberString = (string)$number;
        $separatedNumber = implode(' + ', str_split($numberString));
        $opt_b = $separatedNumber;

        // echo $number;
        $temp_opt = rearrangeDigits($number);
        // echo $temp_opt;
        $opt_c = expandedForm($temp_opt);

        $opt_d = implode(" + ", (str_split("$temp_opt")));
    } else {

        $temp = rearrangeDigits($number);
        $opt_b = expandedForm($temp);

        $temp_opt = rearrangeDigits($temp);
        // echo $temp_opt;
        $opt_c = expandedForm($temp_opt);

        $temp_opt_temp = rearrangeDigits($temp_opt);

        $opt_d = expandedForm("$temp_opt_temp");
    }

    $names = [];
    $names = array("$opt_a", "$opt_b", "$opt_c", "$opt_d");
    shuffle($names);
    $chunks = array_chunk($names, 2);
    $rearrange = array_merge($chunks[1], $chunks[0]);

    $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=0 and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
    $befrow = mysqli_fetch_assoc($befsql);

    // var_dump($names);

    if ($befrow['question'] == '' 
        && $opt_a !== $opt_b 
        && $opt_b !== $opt_c 
        && $opt_c !== $opt_d 
        && $opt_a !== $opt_c 
        && $opt_a !== $opt_d 
        && $opt_b !== $opt_d
        && $number % ($divideby / 10) !== 0) {
        $question = $conn->real_escape_string($question);
        mysqli_query($conn, "INSERT INTO count_quest(userid, class, subject, topic, subtopic, type, question, correct_ans, opt_a, opt_b, opt_c, opt_d, created_at, updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$before."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())");
    }
    }

if($bftaft == '1') {

    $question = "What is the standard form of the number ".expandedForm($number)."?";

    $correct = $number;
    $opt_a = $correct;

    //opt_b
    if($sbtpName == '43' || $sbtpName == '45') {
        $opt_b = rearrangeDigits($number);
    } else {
        $opt_b = randomizeMiddleDigits($opt_a);
    }

    if($opt_a != $opt_b) {
    //opt_c    
    if($sbtpName == '43' || $sbtpName == '45') {
        $opt_c = mt_rand(0, 1) == 1 ? $number + mt_rand(1, 5) : abs($number - mt_rand(1, 5));
    } else {
        $opt_c = randomizeMiddleDigits($opt_a);
    }
    
    if($opt_a != $opt_c && $opt_b != $opt_c) {
    //opt_d
    if($sbtpName == '43' || $sbtpName == '45') {
        $opt_d = mt_rand(0, 1) == 1 ? $number + mt_rand(1, 5) : abs($number - mt_rand(1, 5));
    } else {
        $opt_d = randomizeMiddleDigits($opt_a);
    }

    if($opt_a!= $opt_d && $opt_b != $opt_d && $opt_c != $opt_d) {
        $names = [];
        $names = array("$opt_a", "$opt_b", "$opt_c", "$opt_d");
        shuffle($names);
        $chunks = array_chunk($names, 2);
        $rearrange = array_merge($chunks[1], $chunks[0]);

        $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=1 and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
        $befrow = mysqli_fetch_assoc($befsql);
    
        if ($befrow['question'] == '') {
            $question = $conn->real_escape_string($question);
            mysqli_query($conn, "INSERT INTO count_quest(userid, class, subject, topic, subtopic, type, question, correct_ans, opt_a, opt_b, opt_c, opt_d, created_at, updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$after."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())");
        }
    }
}
}
        }
}   //exit();
?>