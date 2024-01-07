<?php 
    require_once("../../config/config.php");

    function generateIncorrectOptionsTime($correctOption) {
        $incorrectOptions = [];
    
        // Add the correct option to the array
        $incorrectOptions[] = [
            'option' => $correctOption,
            'isCorrect' => true
        ];
    
        // Generate three unique incorrect options
        while (count($incorrectOptions) < 4) {
            $incorrectOptionRandom = generateRandomIncorrectOption($correctOption);
            $incorrectOption = $incorrectOptionRandom;
    
            // Ensure the incorrect option is different from the correct option
            foreach ($incorrectOptions as $thisOption) {
                if ($incorrectOption === $thisOption['option']) {
                    $incorrectOption = generateRandomNumber(strlen($correctOption));
                }
            }
    
            if ($incorrectOption != $correctOption) {
                $incorrectOptions[] = [
                    'option' => $incorrectOption,
                    'isCorrect' => false
                ];
            }
        }
    
        // Shuffle the options randomly
        shuffle($incorrectOptions);
    
        return $incorrectOptions;
    }
    
    function generateIncorrectOptionsWithSuffix($correctOption) {
        $incorrectOptions = [];
    
        // Add the correct option to the array
        $incorrectOptions[] = [
            'option' => $correctOption,
            'isCorrect' => true
        ];
    
        // Generate three unique incorrect options
        while (count($incorrectOptions) < 4) {
            $incorrectOptionRandom = generateRandomIncorrectOptionWithSuffix($correctOption);
            $incorrectOption = $incorrectOptionRandom;
    
            // Ensure the incorrect option is different from the correct option
            foreach ($incorrectOptions as $thisOption) {
                if ($incorrectOption === $thisOption['option']) {
                    $incorrectOption = generateRandomNumber(strlen($correctOption));
                }
            }
    
            if ($incorrectOption != $correctOption) {
                $incorrectOptions[] = [
                    'option' => $incorrectOption,
                    'isCorrect' => false
                ];
            }
        }
    
        // Shuffle the options randomly
        shuffle($incorrectOptions);
    
        return $incorrectOptions;
    }
    function generateRandomNumber($length) {
        $min = pow(10, $length - 1);
        $max = pow(10, $length) - 1;
        return mt_rand($min, $max);
    }
    
    function generateRandomIncorrectOption($correctOption) {
        // Get the current time on a 12-hour clock
        $currentTime = date('h:i A');
    
        // Extract hours and minutes from the current time
        list($hours, $minutes, $period) = sscanf($currentTime, '%d:%d %s');
    
        // Generate a random number of minutes to add or subtract (up to 120 minutes)
        $randomMinutes = mt_rand(1, 120);
        
        // Determine whether to add or subtract the random minutes
        $sign = (mt_rand(0, 1) === 0) ? -1 : 1;
        
        // Calculate the new time by adding/subtracting the random minutes
        $newMinutes = ($minutes + $sign * $randomMinutes) % 60;
        if ($newMinutes < 0) {
            $newMinutes += 60;
            $hours -= 1;
        }
        
        $newHours = ($hours + intdiv($minutes + $sign * $randomMinutes, 60) + 12) % 12;
        if ($newHours === 0) {
            $newHours = 12;
        }
        // $newPeriod = ($hours + intdiv($minutes + $sign * $randomMinutes, 60) + 12) >= 12 ? 'PM' : 'AM';
        
        // Format the new time
        $incorrectOption = sprintf("%02d:%02d", $newHours, $newMinutes);
    
        return $incorrectOption;
    }
    function generateRandomIncorrectOptionWithSuffix($correctOption) {
        // Get the current time on a 12-hour clock
        $currentTime = date('h:i A');
    
        // Extract hours and minutes from the current time
        list($hours, $minutes, $period) = sscanf($currentTime, '%d:%d %s');
    
        // Generate a random number of minutes to add or subtract (up to 120 minutes)
        $randomMinutes = mt_rand(1, 120);
    
        // Determine whether to add or subtract the random minutes
        $sign = (mt_rand(0, 1) === 0) ? -1 : 1;
    
        // Calculate the new time by adding/subtracting the random minutes
        $newMinutes = ($minutes + $sign * $randomMinutes) % 60;
        if ($newMinutes < 0) {
            $newMinutes += 60;
            $hours -= 1;
        }
    
        // Calculate the new hours
        $totalHours = ($hours + intdiv($minutes + $sign * $randomMinutes, 60)) % 12;
        if ($totalHours === 0) {
            $totalHours = 12;
        }
    
        // Randomly choose AM or PM
        $newPeriod = (mt_rand(0, 1) === 0) ? 'AM' : 'PM';
    
        // Format the new time with AM or PM
        $incorrectOption = sprintf("%02d:%02d %s", $totalHours, $newMinutes, $newPeriod);
    
        return $incorrectOption;
    }
    
    
    

    $function_name = $_GET["function_name"] ?? "";
    if($function_name == "generateIncorrectOptions"){
        echo json_encode(generateIncorrectOptionsTime($_POST["time"]));
    }
    elseIf($function_name == "generateIncorrectOptionsWithSuffix"){
        echo json_encode(generateIncorrectOptionsWithSuffix($_POST["time"]));
    }
    
    // print_r(generateIncorrectOptionsWithSuffix("2:45PM"));
?>