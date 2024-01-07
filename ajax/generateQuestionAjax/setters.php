<?php 
    require_once("../../config/config.php");

    function setQuestions($user_id, $class, $subject, $topic, $subtopic, $question, $opt_1, $opt_2, $opt_3, $opt_4, $correct_opt)
    {
        global $conn; // Access the global $conn object
        
        try {
            $query = "INSERT INTO count_quest (userid, class, subject, topic, subtopic, question, opt_a, opt_b, opt_c, opt_d, correct_ans) 
                    VALUES ($user_id, $class, $subject, $topic, $subtopic, '$question', '$opt_1', '$opt_2', '$opt_3', '$opt_4', '$correct_opt')";
            
            $result = mysqli_query($conn, $query);
            
            // Check if the query was successful
            if ($result) {
                return true; // Insertion successful
            } else {
                return false; // Insertion failed
            }
            
        } catch (Exception $e) {
            echo $e;
            exit('Database error.');
        }
    }

    function smallestNDigitEvenNumberFromDigits($digitsArray, $len) {
        $minEven = 10;
        $digits = explode(",", $digitsArray);

        if(!hasEvenDigits($digits)){
            return 0;
        }
    
        sort($digits);
        $finalResult = array_slice($digits, 0, $len - 1);
        $checkArray = array_slice($digits, $len - 1);
    
        foreach ($checkArray as $element) {
            if ($element % 2 == 0) {
                $minEven = min($minEven, $element);
            }
        }
    
        if ($minEven == 10) {
            $finalResult = array_slice($digits, 0, $len);
            $finalString = "";
            $finalChar = "";
            $flag = false;
    
            for ($i = count($finalResult) - 1; $i >= 0; $i--) {
                if (!$flag && $finalResult[$i] % 2 == 0) {
                    $finalChar = $finalResult[$i];
                    $flag = true;
                    continue;
                }
    
                $finalString = $finalResult[$i] . $finalString;
            }
    
            return moveZeroes($finalString . $finalChar);
        }
    
        $finalResult[] = $minEven;
    
        return moveZeroes(implode("", $finalResult));
    }

    function moveZeroes($numberString) {
        // Find the index of the first non-zero digit
        $nonZeroIndex = strpos($numberString, strpbrk($numberString, '123456789'));
    
        // Check if there are any preceding zeroes
        if ($nonZeroIndex > 0) {
            // Extract the leading zeroes
            $leadingZeroes = substr($numberString, 0, $nonZeroIndex);
    
            // Extract the remaining digits
            $remainingDigits = substr($numberString, $nonZeroIndex);
    
            // Combine the parts with the leading zeroes in the second position
            $result = substr($remainingDigits, 0, 1) . $leadingZeroes . substr($remainingDigits, 1);
    
            // Return the result
            return $result;
        } else {
            // No preceding zeroes, return the original number
            return $numberString;
        }
    }

    function largestNDigitNumber($digits, $n) {
        // Validate input
        if ($n <= 0) {
            throw new Exception("n must be greater than or equal to 0");
        }
    
        // Convert the comma-separated string of digits to an array
        $digitsArray = explode(",", $digits);
    
        // Sort the array in descending order
        rsort($digitsArray);
    
        // Create a string of the largest n digits from the array
        $largestNDigitNumber = "";
        for ($i = 0; $i < $n; $i++) {
            $largestNDigitNumber .= $digitsArray[$i];
        }
    
        // Return the largest n-digit number
        return $largestNDigitNumber;
    }

    function smallestNDigitNumber($digits, $n) {
        // Validate input
        if ($n <= 0) {
            throw new Exception("n must be greater than or equal to 0");
        }
    
        // Convert the comma-separated string of digits to an array
        $digitsArray = explode(",", $digits);
    
        // Sort the array in ascending order
        sort($digitsArray);
    
        // Create a string of the smallest n digits from the array
        $smallestNDigitNumber = "";
        for ($i = 0; $i < $n; $i++) {
            $smallestNDigitNumber .= $digitsArray[$i];
        }
    
        // Return the smallest n-digit number
        return moveZeroes($smallestNDigitNumber);
    }

    function largestNDigitEvenNumberFromDigits($digitsArray, $len) {
        $minEven = -1;
        $digits = explode(",", $digitsArray);

        if(!hasEvenDigits(($digits))){
            return 0;
        }
    
        sort($digits);
        $digits = array_reverse($digits);
        $finalResult = array_slice($digits, 0, $len - 1);
        $checkArray = array_slice($digits, $len - 1);
    
        $finalString = "";
        $finalChar = "";
        $flag = false;
    
        foreach ($checkArray as $element) {
            if ($element % 2 == 0) {
                $minEven = max($minEven, $element);
            }
        }
    
        if ($minEven == -1) {
            $finalResult = array_slice($digits, 0, $len);
    
            for ($i = count($finalResult) - 1; $i >= 0; $i--) {
                if (!$flag && $finalResult[$i] % 2 == 0) {
                    $finalChar = $finalResult[$i];
                    $flag = true;
                    continue;
                }
    
                $finalString = $finalResult[$i] . $finalString;
            }
    
            return $finalString . $finalChar;
        }
    
        $finalResult[] = $minEven;
    
        return implode("", $finalResult);
    }

    function smallestNDigitOddNumberFromDigits($digitsArray, $len) {
        $minOdd = 10;
        $digits = explode(",", $digitsArray);

        if(!hasOddDigits($digits)){
            return 0;
        }
    
        sort($digits);
        $finalResult = array_slice($digits, 0, $len - 1);
        $checkArray = array_slice($digits, $len - 1);
    
        $finalString = "";
        $finalChar = "";
        $flag = false;
    
        foreach ($checkArray as $element) {
            if ($element % 2 !== 0) {
                $minOdd = min($minOdd, $element);
            }
        }
    
        if ($minOdd == 10) {
            $finalResult = array_slice($digits, 0, $len);
    
            for ($i = count($finalResult) - 1; $i >= 0; $i--) {
                if (!$flag && $finalResult[$i] % 2 !== 0) {
                    $finalChar = $finalResult[$i];
                    $flag = true;
                    continue;
                }
    
                $finalString = $finalResult[$i] . $finalString;
            }
    
            return moveZeroes($finalString . $finalChar);
        }
    
        $finalResult[] = $minOdd;
    
        return moveZeroes(implode("", $finalResult));
    }
    
    function largestNDigitOddNumberFromDigits($digitsArray, $len) {
        $minOdd = -1;
        $digits = explode(",", $digitsArray);

        if(!hasOddDigits($digits)){
            return 0;
        }
    
        sort($digits);
        $digits = array_reverse($digits);
        $finalResult = array_slice($digits, 0, $len - 1);
        $checkArray = array_slice($digits, $len - 1);
    
        $finalString = "";
        $finalChar = "";
        $flag = false;
    
        foreach ($checkArray as $element) {
            if ($element % 2 !== 0) {
                $minOdd = max($minOdd, $element);
            }
        }
    
        if ($minOdd == -1) {
            $finalResult = array_slice($digits, 0, $len);
    
            for ($i = count($finalResult) - 1; $i >= 0; $i--) {
                if (!$flag && $finalResult[$i] % 2 !== 0) {
                    $finalChar = $finalResult[$i];
                    $flag = true;
                    continue;
                }
    
                $finalString = $finalResult[$i] . $finalString;
            }
    
            return $finalString . $finalChar;
        }
    
        $finalResult[] = $minOdd;
    
        return implode("", $finalResult);
    }

    // function generateIncorrectOptions($correctOption) {
    //     $incorrectOptions = [];

    //       // Add the correct option to the array
    //     $incorrectOptions[] = [
    //         'option' => $correctOption,
    //         'isCorrect' => true
    //     ];
    //     $count = 0;
    
    //     // Generate three unique incorrect options
    //     while (count($incorrectOptions) < 4) {
    //         $incorrectOptionRandom = generateRandomIncorrectOption($correctOption);
    //         $incorrectOption = $incorrectOptionRandom;
    //         // Ensure the incorrect option is different from the correct option

    //         $count = 0;
    //         foreach($incorrectOptions as $thisOption){
    //             while ($count <= 100 && $incorrectOption === $thisOption['option']) {
    //                 $incorrectOption = generateRandomNumber(strlen($correctOption));
    //                 $count++;
    //             }

    //             if($count == 100) {
    //                 break;
    //             }
    //         }
    //         // while(in_array($incorrectOption, $incorrectOptions)){
    //         //     $incorrectOption = generateRandomNumber(strlen($correctOption));
    //         // }

    //         if ($incorrectOption != $correctOption) {
                    
    //             $incorrectOptions[] = [
    //                 'option' => $incorrectOption,
    //                 'isCorrect' => false
    //             ];
    //         }
    //     }
    
      
    
    //     // Shuffle the options randomly
    //     shuffle($incorrectOptions);
    
    //     return $incorrectOptions;
    // }

    function generateIncorrectOptions($correctOption) {
        $options = array();
        $options[] = $correctOption;

        $count = 0;

        while($count <= 100 && count($options) < 4) {
            $incorrect = generateRandomIncorrectOption($correctOption);

            if(!in_array($incorrect, $options)) {
                $options[] = $incorrect;
                $count = 0;
            }
            else {
                $incorrect = generateRandomNumber(strlen($correctOption));
                if(!in_array($incorrect, $options)) {
                    $options[] = $incorrect;
                    $count = 0;
                }
            }

            $count++;
        }

        if($count < 100) {
            shuffle($options);
            return $options;
        }
    }

    function generateRandomNumber($length) {
        $min = pow(10, $length - 1);
        $max = pow(10, $length) - 1;
        return mt_rand($min, $max);
    }
    
    function generateRandomIncorrectOption($correctOption) {
        // Rearrange the digits of the correct option
        $digits = str_split($correctOption);
        shuffle($digits);
        $incorrectOption = implode('', $digits);
    
        return $incorrectOption;
    }


    function generateQuestionStatement($question_opt){
        $mapping_question = [
            'smallestNDigitNumber' => 'Create the smallest %%n%% digit number from the given digits: %%m%%',
            'largestNDigitNumber' => 'Create the largest %%n%% digit number from the given digits: %%m%%',
            'smallestNDigitEvenNumberFromDigits' => 'Create the smallest %%n%% digit even number from the given digits: %%m%%',
            'smallestNDigitOddNumberFromDigits' => 'Create the smallest %%n%% digit odd number from the given digits: %%m%%',
            'largestNDigitEvenNumberFromDigits' => 'Create the largest %%n%% digit even number from the given digits: %%m%%',
            'largestNDigitOddNumberFromDigits' => 'Create the largest %%n%% digit odd number from the given digits: %%m%%',
        ];

        return $mapping_question[$question_opt];
    }

    function hasEvenDigits($array)
    {
        foreach ($array as $element) {
            if ($element % 2 === 0) {
                return true; // Found an even digit, return true
            }
        }
        
        return false; // No even digits found
    }

    function hasOddDigits($array)
    {
        foreach ($array as $element) {
            if ($element % 2 !== 0) {
                return true; // Found an even digit, return true
            }
        }
        
        return false; // No even digits found
    }

    class QuestionAnswer{
        public $question;
        public $answer;
        public function __construct($question, $answer){
            $this->question = $question;
            $this->answer = $answer;
        }
    }

    $functions_map = array(
        "smallestNDigitNumber" => "smallest %%n%% digit number", 
        "largestNDigitNumber" => "largest %%n%% digit number", 
        "smallestNDigitEvenNumberFromDigits" => "smallest %%n%% digit even number", 
        "largestNDigitEvenNumberFromDigits" => "largest %%n%% digit even number", 
        "smallestNDigitOddNumberFromDigits" => "smallest %%n%% digit odd number",
        "largestNDigitOddNumberFromDigits" => "largest %%n%% digit odd number"
    );
    function additionNumbersQuestion($digits ,$len){
        global $functions_map;

        $functions = array_keys($functions_map);

        $randomFunction1 = $functions[array_rand($functions)];
        $randomFunction2 = $functions[array_rand($functions)];

        while ($randomFunction1 === $randomFunction2) {
            $randomFunction2 = $functions[array_rand($functions)];
        }

        $answer = (int)$randomFunction1($digits, $len) + (int)$randomFunction2($digits, $len);
        $question = "Give the sum of the ". $functions_map[$randomFunction1] ." and the ". $functions_map[$randomFunction2]. " using the given digits: %%m%%";

        $return_obj = new QuestionAnswer($question, strval($answer));

        return $return_obj;

    }
    function substractionNumbersQuestion($digits, $len){
        global $functions_map;

        $function_keys = array_keys($functions_map);
        $odd_keys = array();
        $even_keys = array();

        for($i = 0; $i < count($function_keys); $i++){
            if($i % 2 == 0){
                array_push($even_keys, $function_keys[$i]);
            }
            else{
                array_push($odd_keys, $function_keys[$i]);
            }
        }

        $largestFunction = $odd_keys[array_rand($odd_keys)];
        $smallestFunction = $even_keys[array_rand($even_keys)];

        $answer = (int)$largestFunction($digits, $len) - (int)$smallestFunction($digits, $len);
        $question = "Give the difference of the ". $functions_map[$largestFunction] ." and the ". $functions_map[$smallestFunction]. " using the given digits: %%m%%";

        $return_obj = new QuestionAnswer($question, strval($answer));

        return $return_obj;

    }
    
    $function_name = $_GET["function_name"] ?? "";
    if($function_name == "setQuestions"){
        $user_id = $_POST["user_id"]; 
        $class = $_POST["classData"];
        $subject = $_POST["subject"];
        $topic = $_POST["topic"];
        $subtopic = $_POST["subtopic"];
        echo json_encode(setQuestions($user_id, $class, $subject, $topic, $subtopic, $_POST["question"], $_POST["opt_1"], $_POST["opt_2"], $_POST["opt_3"], $_POST["opt_4"], $_POST["correct_opt"]));
    }
    else if($function_name == "smallestNDigitNumber"){
        echo json_encode(smallestNDigitNumber($_POST["digits"], $_POST["len"]));
    }
    else if($function_name == "largestNDigitNumber"){
        echo json_encode(largestNDigitNumber($_POST["digits"], $_POST["len"]));
    }
    else if($function_name == "smallestNDigitEvenNumberFromDigits"){
        echo json_encode(smallestNDigitEvenNumberFromDigits($_POST["digits"], $_POST["len"]));
    }
    else if($function_name == "largestNDigitEvenNumberFromDigits"){
        echo json_encode(largestNDigitEvenNumberFromDigits($_POST["digits"], $_POST["len"]));
    }
    else if($function_name == "smallestNDigitOddNumberFromDigits"){
        echo json_encode(smallestNDigitOddNumberFromDigits($_POST["digits"], $_POST["len"]));
    }
    else if($function_name == "largestNDigitOddNumberFromDigits"){
        echo json_encode(largestNDigitOddNumberFromDigits($_POST["digits"], $_POST["len"]));
    }
    else if($function_name == "generateIncorrectOptions"){
        echo json_encode(generateIncorrectOptions($_POST["correct_opt"]));
    }
    else if($function_name == "generateQuestionStatement"){
        echo json_encode(generateQuestionStatement($_POST["question_opt"]));
    }
    else if($function_name == "additionNumbersQuestion"){
        echo json_encode(additionNumbersQuestion($_POST["digits"], $_POST["len"]));
    }
    else if($function_name == "substractionNumbersQuestion"){
        echo json_encode(substractionNumbersQuestion($_POST["digits"], $_POST["len"]));
    }

    // echo largestNDigitNumber("2,6,4,3,8", 3);

    // print_r(generateIncorrectOptions(36));
?>