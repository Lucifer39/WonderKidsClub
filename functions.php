<?php
//Page Title
function get_page_title(){
    $page = basename($_SERVER['PHP_SELF']); // Get script filename without any path information
    $page = str_replace( array( '.php', '.htm', '.html' ), '', $page ); // Remove extensions
    $page = str_replace( array('-', '_'), ' ', $page); // Change underscores/hyphens to spaces
    $page = ucwords( $page ); // uppercase first letter of every word
    return $page;	
}


//gettoken
function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}
function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}

//Crop Image
function cropAlign($image, $cropWidth, $cropHeight, $horizontalAlign = 'center', $verticalAlign = 'middle') {
    $width = imagesx($image);
    $height = imagesy($image);
    $horizontalAlignPixels = calculatePixelsForAlign($width, $cropWidth, $horizontalAlign);
    $verticalAlignPixels = calculatePixelsForAlign($height, $cropHeight, $verticalAlign);
    return imageCrop($image, [
        'x' => $horizontalAlignPixels[0],
        'y' => $verticalAlignPixels[0],
        'width' => $horizontalAlignPixels[1],
        'height' => $verticalAlignPixels[1]
    ]);
}

function calculatePixelsForAlign($imageSize, $cropSize, $align) {
    switch ($align) {
        case 'left':
        case 'top':
            return [0, min($cropSize, $imageSize)];
        case 'right':
        case 'bottom':
            return [max(0, $imageSize - $cropSize), min($cropSize, $imageSize)];
        case 'center':
        case 'middle':
            return [
                max(0, floor(($imageSize / 2) - ($cropSize / 2))),
                min($cropSize, $imageSize),
            ];
        default: return [0, $imageSize];
    }
}

function correctImageOrientation($filename)
{
    if (function_exists('exif_read_data'))
    {
        $exif = exif_read_data($filename);
        if ($exif && isset($exif['Orientation']))
        {
            $orientation = $exif['Orientation'];
            if ($orientation != 1)
            {
                $img = imagecreatefromjpeg($filename);
                $deg = 0;
                switch ($orientation)
                {
                    case 3:
                        $deg = 180;
                    break;
                    case 6:
                        $deg = 270;
                    break;
                    case 8:
                        $deg = 90;
                    break;
                }
                if ($deg)
                {
                    $img = imagerotate($img, $deg, 0);
                }
                // then rewrite the rotated image back to the disk as $filename
                imagejpeg($img, $filename, 95);
            } // if there is some rotation necessary
            
        } // if have the exif orientation info
        
    } // if function exists
    
}


// Compress image
/**
 * Decrease or increase the quality of an image without resize it.
 * 
 * @param type $source
 * @param type $destination
 * @param type $quality
 * @return type
 */
function compress($source, $destination, $quality) {
    //Get file extension
    $exploding = explode(".",$source);
    $ext = end($exploding);

    switch($ext){
        case "png":
            $src = imagecreatefrompng($source);
        break;
        case "jpeg":
        case "jpg":
            $src = imagecreatefromjpeg($source);
        break;
        case "gif":
            $src = imagecreatefromgif($source);
        break;
        default:
            $src = imagecreatefromjpeg($source);
        break;
    }
    
    switch($ext){
        case "png":
            imagepng($src, $destination, $quality);
        break;
        case "jpeg":
        case "jpg":
            imagejpeg($src, $destination, $quality);
        break;
        case "gif":
            imagegif($src, $destination, $quality);
        break;
        default:
            imagejpeg($src, $destination, $quality);
        break;
    }

    return $destination;
}

function convertImage($originalImage, $outputImage, $quality) {

    switch (exif_imagetype($originalImage)) {
        case IMAGETYPE_PNG:
            $imageTmp=imagecreatefrompng($originalImage);
            break;
        case IMAGETYPE_JPEG:
            $imageTmp=imagecreatefromjpeg($originalImage);
            break;
        case IMAGETYPE_GIF:
            $imageTmp=imagecreatefromgif($originalImage);
            break;
        case IMAGETYPE_BMP:
            $imageTmp=imagecreatefrombmp($originalImage);
            break;
        // Defaults to JPG
        default:
            $imageTmp=imagecreatefromjpeg($originalImage);
            break;
    }

    // quality is a value from 0 (worst) to 100 (best)
    imagejpeg($imageTmp, $outputImage, $quality);
    imagedestroy($imageTmp);

    return 1;
}

//Slug
function slugify($string){
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
}

//Random String
function randString($length) {
    //$char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$char = "0123456789";
    $char = str_shuffle($char);
    for($i = 0, $rand = '', $l = strlen($char) - 1; $i < $length; $i ++) {
        $rand .= $char{mt_rand(0, $l)};
    }
    return $rand;
}


//Timeago
function getTimeDifference($time) {
    //Let's set the current time
    $currentTime = date('Y-m-d H:i:s');
    $toTime = strtotime($currentTime);

    //And the time the notification was set
    $fromTime = strtotime($time);

    //Now calc the difference between the two
    $timeDiff = floor(abs($toTime - $fromTime) / 60);

    //Now we need find out whether or not the time difference needs to be in
    //minutes, hours, or days
    if ($timeDiff < 2) {
        $timeDiff = "Just now";
    } elseif ($timeDiff > 2 && $timeDiff < 60) {
        $timeDiff = floor(abs($timeDiff)) . " minutes ago";
    } elseif ($timeDiff > 60 && $timeDiff < 120) {
        $timeDiff = floor(abs($timeDiff / 60)) . " hour ago";
    } elseif ($timeDiff < 1440) {
        $timeDiff = floor(abs($timeDiff / 60)) . " hours ago";
    } elseif ($timeDiff > 1440 && $timeDiff < 2880) {
        $timeDiff = floor(abs($timeDiff / 1440)) . " day ago";
    } elseif ($timeDiff > 2880) {
        $timeDiff = floor(abs($timeDiff / 1440)) . " days ago";
    }

    return $timeDiff;
}

// Function to generate OTP
function generateNumericOTP($n) {
      
    // Take a generator string which consist of
    // all numeric digits
    $generator = "1357902468";
  
    // Iterate for n-times and pick a single character
    // from generator and append it to $result
      
    // Login for generating a random character from generator
    //     ---generate a random number
    //     ---take modulus of same with length of generator (say i)
    //     ---append the character at place (i) from generator to result
  
    $result = "";
  
    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand()%(strlen($generator))), 1);
    }
  
    // Return result
    return $result;
}

function url(){
  return sprintf(
    "%s://%s%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME'],
    $_SERVER['REQUEST_URI']
  );
}

function isHomepage() {
$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') 
                === FALSE ? 'https' : 'https';
$host     = $_SERVER['HTTP_HOST'];
$script   = $_SERVER['SCRIPT_NAME'];
$params   = $_SERVER['QUERY_STRING'];
 
$currentUrl = $protocol . '://' . $host . $script;
 
return $currentUrl;
}

 function unique_id($l = 8){
  $better_token = md5(uniqid(rand(), true));
      $rem = strlen($better_token)-$l;
  $unique_code = substr($better_token, 0, -$rem);
  $uniqueid = $unique_code;
  return $uniqueid;
  }


  function preg_trim($subject) {
    $regex = "/\s*(\.*)\s*/s";
    if (preg_match ($regex, $subject, $matches)) {
        $subject = $matches[1];
    }
    return $subject;
}

//Random Number with Excluded
function randomNumber($from, $to, array $excluded = [])
{
    $func = function_exists('random_int') ? 'random_int' : 'mt_rand';

    do {
        $number = $func($from, $to);
    } while (in_array($number, $excluded, true));

    return $number;
}


function decode($value){
    if(!$value){return false;}
    $crypttext = $this->safe_b64decode($value); 
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
    return trim($decrypttext);
}


function numberToWord($num) {
    $words = array(
        0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
        5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
        14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
        18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
        80 => 'Eighty', 90 => 'Ninety'
    );

    if (!is_numeric($num)) {
        return false;
    }

    if ($num < 0 || $num > 999999999) {
        return false;
    }

    if ($num < 21) {
        return $words[$num];
    }

    if ($num < 100) {
        return $words[10 * floor($num/10)] . (($num % 10 != 0) ? ' ' . $words[$num % 10] : '');
    }

    if ($num < 1000) {
        return $words[floor($num/100)] . ' Hundred' . (($num % 100 != 0) ? ' ' . numberToWord($num % 100) : '');
    }

    $baseUnits = array('Thousand', 'Million', 'Billion');

    for ($i = count($baseUnits)-1; $i >= 0; $i--) {
        $baseUnit = pow(1000, $i+1);
        if ($num >= $baseUnit) {
            return numberToWord(floor($num/$baseUnit)) . ' ' . $baseUnits[$i] . (($num % $baseUnit != 0) ? ' ' . numberToWord($num % $baseUnit) : '');
        }
    }

    return false;
}


function getRandomImage($dir) {
    $files = glob("$dir/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
    $random_file = $files[array_rand($files)];
    return $random_file;
}

function get_combinations($arr, $target, $prefix = []) {
    $result = [];
    
    for ($i = 0; $i < count($arr); $i++) {
        $new_prefix = array_merge($prefix, [$arr[$i]]);
        $new_target = $target - $arr[$i];
        
        if ($new_target == 0) {
            $result[] = $new_prefix;
        } elseif ($new_target > 0) {
            $combinations = get_combinations(array_slice($arr, $i), $new_target, $new_prefix);
            $result = array_merge($result, $combinations);
        }
    }
    
    return $result;
}

/*//function to generate an array of random numbers
function generateRandomNumbers($count, $min, $max, $sorted) {
    $numbers = array();
    for ($i = 0; $i < $count; $i++) {
        $numbers[] = rand($min, $max);
    }
    if ($sorted) {
        sort($numbers);
    }
    return $numbers;
}

//function to generate an array of random numbers
function generateDescRandomNumbers($count, $min, $max, $sorted) {
    $numbers = array();
    for ($i = 0; $i < $count; $i++) {
        $numbers[] = rand($min, $max);
    }
    if ($sorted) {
        rsort($numbers);
    }
    return $numbers;
}*/

//Generate Unique Number
// Function to generate ascending random numbers
function generateRandomASCNumbers($asc_value, $count) {
    $numbers = array_map('intval', explode(',', $asc_value));
    sort($numbers);
    $min = $numbers[0];
    $max = $numbers[count($numbers) - 1];
    return generateRandomNumbers($count, $min, $max, true);
}

// Function to generate descending random numbers
function generateRandomDESCNumbers($desc_value, $count) {
    $numbers = array_map('intval', explode(',', $desc_value));
    rsort($numbers);
    $min = $numbers[count($numbers) - 1];
    $max = $numbers[0]; // Corrected: Swap min and max to get descending order
    return generateRandomNumbers($count, $min, $max, false);
}

// Function to generate unique random numbers in the specified range
function generateRandomNumbers($count, $min, $max, $sorted) {
    if ($max - $min + 1 < $count) {
        return false;
    }

    $numbers = range($min, $max);
    shuffle($numbers);

    if (!$sorted) {
        $numbers = array_reverse($numbers);
    }

    $numbers = array_slice($numbers, 0, $count);

    if ($sorted) {
        sort($numbers);
    } else {
        rsort($numbers);
    }

    return $numbers;
}


// Generate Random URL
function generateRandomURL($length = 8) {
    // Define characters to use in the random URL
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    $url = '';
    $characterCount = strlen($characters);

    // Generate random characters for the URL
    for ($i = 0; $i < $length; $i++) {
        $url .= $characters[rand(0, $characterCount - 1)];
    }

    // Add a timestamp or unique identifier to ensure uniqueness
    $url .= time(); // You can replace this with any unique identifier you prefer

    return $url;
}

//Multiplication Tables
/*function multiplication_table($number) {
    for ($i = 1; $i <= 10; $i++) {
      echo "$number x $i = " . $number * $i . "\n";
    }
  }*/

  function multiplication_table($number) {
    for ($i = 1; $i <= 10; $i++) {
      echo $number * $i;
  
      if ($i != 10) {
        echo ", ";
      }
    }
  }

  //Random Number Array
  function getRandomNumberFromArray($numbers) {
    $randomNumberKey = array_rand($numbers);
    $randomNumber = $numbers[$randomNumberKey];
    return $randomNumber;
}

//Expanded Form
function expandedForm($number) {
    $digits = str_split(strval($number));
    $expanded = [];
  
    foreach ($digits as $key => $digit) {
      if ($digit !== '0') {
        $expanded[] = $digit . str_repeat('0', count($digits) - $key - 1);
      }
    }
  
    return implode(' + ', $expanded);
  }

//Expanded Form with space
function expandedFormwithoutspace($number) {
    $digits = str_split(strval($number));
    $expanded = [];
  
    foreach ($digits as $key => $digit) {
      if ($digit !== '0') {
        $expanded[] = $digit . str_repeat('0', count($digits) - $key - 1);
      }
    }
  
    return implode('+', $expanded);
  }

//Middle Digits random
function randomizeMiddleDigits($number) {
    $numberString = (string)$number;
    $length = strlen($numberString);

    if ($length === 4) {
        $firstDigit = $numberString[0];
        $lastDigit = $numberString[3];

        // Generate 2 random digits for the middle
        $randomMiddleDigits = mt_rand(10, 99);

        // Combine the digits to form the new number
        $newNumber = $firstDigit . $randomMiddleDigits . $lastDigit;

        return (int)$newNumber;
    } elseif ($length > 4) {
        $firstTwoDigits = substr($numberString, 0, 2);
        $lastTwoDigits = substr($numberString, -2);

        // Generate random digits for the middle, considering the length of the number
        $numRandomDigits = $length - 4;
        $randomMiddleDigits = '';
        for ($i = 0; $i < $numRandomDigits; $i++) {
            $randomMiddleDigits .= mt_rand(0, 9);
        }

        // Combine the digits to form the new number
        $newNumber = $firstTwoDigits . $randomMiddleDigits . $lastTwoDigits;

        return (int)$newNumber;
    } else {
        // Number with less than 4 digits, return as is
        return $number;
    }
}


//Place Value International
function placeValueInternationalNumber($number) {
    $numberString = (string) $number;
    $result = [];
    
    $placeValueWords = array(
        0 => 'Ones',
        1 => 'Tens',
        2 => 'Hundreds',
        3 => 'Thousands',
        4 => 'Ten Thousands',
        5 => 'Hundred Thousands',
        6 => 'Millions',
        7 => 'Ten Millions',
        8 => 'Hundred Millions',
        9 => 'Billions'
    );

    for ($i = 0; $i < strlen($numberString); $i++) {
        $digit = (int) $numberString[$i];
        if ($digit !== 0) {
            $placeValue = $digit * pow(10, strlen($numberString) - $i - 1);
            $powerOfTen = (strlen($numberString) - $i - 1);
            if (isset($placeValueWords[$powerOfTen])) {
                $result[] = $placeValue . " " . $placeValueWords[$powerOfTen];
            }
        }
    }

    return implode(", ", $result);
}

//Place Value Indian
function placeValueIndianNumber($number) {
    $numberString = (string) $number;
    $result = [];
    
    $placeValueWords = array(
        0 => 'Ones',
        1 => 'Tens',
        2 => 'Hundreds',
        3 => 'Thousands',
        4 => 'Ten Thousands',
        5 => 'Lakhs',
        6 => 'Ten Lakhs',
        7 => 'Crores',
        8 => 'Ten Crores',
    );

    for ($i = 0; $i < strlen($numberString); $i++) {
        $digit = (int) $numberString[$i];
        if ($digit !== 0) {
            $placeValue = $digit * pow(10, strlen($numberString) - $i - 1);
            $powerOfTen = (strlen($numberString) - $i - 1);
            if (isset($placeValueWords[$powerOfTen])) {
                $result[] = $placeValue . " " . $placeValueWords[$powerOfTen];
            }
        }
    }

    return implode(", ", $result);
}

function getPlaceValue($index) {
    $placeValues = array(
        "Ones", "Tens", "Hundreds", "Thousands", "Ten Thousands", "Lakh", "Ten Lakhs", "Crore"
    );

    return $placeValues[$index];
}

function numberToPlaceValueArray($number) {
    $number = strval($number);
    $placeValueArray = array();

    // Loop through each digit of the number
    for ($i = 0; $i < strlen($number); $i++) {
        // Get the digit at the current position
        $digit = intval($number[$i]);

        // Calculate the index of the place value array
        $placeValueIndex = strlen($number) - $i - 1;

        // Append the place value word to the result array
        $placeValueArray[] = getPlaceValue($placeValueIndex);
    }

    return $placeValueArray;
}

function removeWordsAfterDigit($value) {

    // Remove the words after the digit value
    $words_to_remove = [" Tens, ", " Ones"];
    foreach ($words_to_remove as $word) {
      $value = str_replace($word, "", $value);
    }
  
    // Separate the value with comma
    $value = explode(" ", $value);
    $value = implode(",", $value);
  
    return $value;
  }

 

  // dipanjan changes

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
              return mysqli_error($conn); // Insertion failed
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

//   function generateIncorrectOptions($correctOption) {
//       $incorrectOptions = [];

//         // Add the correct option to the array
//       $incorrectOptions[] = [
//           'option' => $correctOption,
//           'isCorrect' => true
//       ];
  
//       // Generate three unique incorrect options
//       while (count($incorrectOptions) < 4) {
//           $incorrectOptionRandom = generateRandomIncorrectOption($correctOption);
//           $incorrectOption = $incorrectOptionRandom;
//           // Ensure the incorrect option is different from the correct option

//           foreach($incorrectOptions as $thisOption){
//               if ($incorrectOption === $thisOption['option']) {
//                   $incorrectOption = generateRandomNumber(strlen($correctOption));
//               }
//           }
//           // while(in_array($incorrectOption, $incorrectOptions)){
//           //     $incorrectOption = generateRandomNumber(strlen($correctOption));
//           // }

//           if ($incorrectOption != $correctOption) {
                  
//               $incorrectOptions[] = [
//                   'option' => ltrim($incorrectOption, '0'),
//                   'isCorrect' => false
//               ];
//           }
//       }
  
    
  
//       // Shuffle the options randomly
//       shuffle($incorrectOptions);
  
//       return $incorrectOptions;
//   }

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
    else {
        return 0;
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
  
      return strval(intval($incorrectOption));
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

  function checkQuestion($question)
  {
      global $conn; // Access the global $conn object
      
      try {
          $query = "SELECT * FROM count_quest 
                    WHERE question = '$question';";
          
          $result = mysqli_query($conn, $query);
          if (!$result) {
              exit('Database error: ' . mysqli_error($conn));
          }
          
          return mysqli_num_rows($result);
          
      } catch (Exception $e) {
          echo $e;
          exit('Database error.');
      }
  }

  function checkQuestionAll($question, $correct_ans, $opt_a, $opt_b, $opt_c, $opt_d, $subtopic) {
    global $conn; // Access the global $conn object
      
      try {
          $query = "SELECT * FROM count_quest 
                    WHERE question = '$question'
                    AND correct_ans = '$correct_ans'
                    AND opt_a = '$opt_a'
                    AND opt_b = '$opt_b'
                    AND opt_c = '$opt_c'
                    AND opt_d = '$opt_d'
                    AND subtopic = '$subtopic';";
          
          $result = mysqli_query($conn, $query);
          if (!$result) {
              exit('Database error: ' . mysqli_error($conn));
          }
          
          return mysqli_num_rows($result);
          
      } catch (Exception $e) {
          echo $e;
          exit('Database error.');
      }
  }

  function checkQuestionAllShape($question, $correct_ans, $opt_a, $opt_b, $opt_c, $opt_d, $shape_info, $subtopic) {
    global $conn; // Access the global $conn object
      
      try {
          $query = "SELECT * FROM count_quest 
                    WHERE question = '$question'
                    AND correct_ans = '$correct_ans'
                    AND opt_a = '$opt_a'
                    AND opt_b = '$opt_b'
                    AND opt_c = '$opt_c'
                    AND opt_d = '$opt_d'
                    AND shape_info = '$shape_info'
                    AND subtopic = '$subtopic';";
          
          $result = mysqli_query($conn, $query);
          if (!$result) {
              exit('Database error: ' . mysqli_error($conn));
          }
          
          return mysqli_num_rows($result);
          
      } catch (Exception $e) {
          echo $e;
          exit('Database error.');
      }
  }

  function checkQuestionTime($question, $hour, $minute){
      global $conn;

      try{
          $query = "SELECT * FROM count_quest 
                      WHERE question = '$question'
                      AND shape_info LIKE '%\"hour\":\"$hour\"%'
                      AND shape_info LIKE '%\"minute\":\"$minute\"%'";

          $result = mysqli_query($conn, $query);
          if (!$result) {
              exit('Database error: ' . mysqli_error($conn));
          }

          return mysqli_num_rows($result);
          
      } catch (Exception $e) {
          echo $e;
          exit('Database error.');
      }
  }

  function checkQuestionPerimeter($st_id, $coordinates){
      global $conn;
      
      try{
          $query = "SELECT * FROM count_quest
                    WHERE subtopic = $st_id
                    AND shape_info LIKE '%$coordinates%'";

          $result = mysqli_query($conn, $query);
          if (!$result) {
              exit('Database error: ' . mysqli_error($conn));
          }

          return mysqli_num_rows($result);
      }
      catch (Exception $e) {
          echo $e;
          exit('Database error.');
      }
  }

  function countQuestions($st_id){
      global $conn;
      
      try {
          $query = "SELECT * FROM count_quest WHERE subtopic = '$st_id';";
          
          $result = mysqli_query($conn, $query);
          if (!$result) {
              exit('Database error: ' . mysqli_error($conn));
          }

          return mysqli_num_rows($result);
          
      } catch (Exception $e) {
          echo $e;
          exit('Database error.');
      }
  }

  function generateIncorrectOptionsTime($correctOption) {
    $incorrectOptions = [];

    // Add the correct option to the array
    $incorrectOptions[] = [
        'option' => $correctOption,
        'isCorrect' => true
    ];

    $count = 0;
    // Generate three unique incorrect options
    while ($count <= 100 && count($incorrectOptions) < 4) {
        $incorrectOptionRandom = generateRandomIncorrectOptionTime($correctOption);
        $incorrectOption = $incorrectOptionRandom;

        // Ensure the incorrect option is different from the correct option
        //foreach ($incorrectOptions as $thisOption) {
         //   if ($incorrectOption === $thisOption['option']) {
         //       $incorrectOption = generateRandomNumberTime(strlen($correctOption));
         //   }
       // }

       if (!in_array($incorrectOption, array_column($incorrectOptions, "option")) && $incorrectOption != $correctOption) {
        $incorrectOptions[] = [
            'option' => $incorrectOption,
            'isCorrect' => false
        ];

        $count = 0;
    }

    $count++;
}

if($count >= 100){
    return 0;
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

    $count = 0;
    // Generate three unique incorrect options
    while ($count <= 100 && count($incorrectOptions) < 4) {
        $incorrectOptionRandom = generateRandomIncorrectOptionWithSuffix($correctOption);
        $incorrectOption = $incorrectOptionRandom;

        // Ensure the incorrect option is different from the correct option
        // foreach ($incorrectOptions as $thisOption) {
        //     if ($incorrectOption === $thisOption['option']) {
        //         $incorrectOption = generateRandomNumberTime(strlen($correctOption));
        //     }
        // }

        if (!in_array($incorrectOption, $incorrectOptions) && $incorrectOption != $correctOption) {
            $incorrectOptions[] = [
                'option' => $incorrectOption,
                'isCorrect' => false
            ];

            $count = 0;
         } 
        //else {
        //     $incorrectOption = generateRandomNumberTime(strlen($correctOption));

        //     if (!in_array($incorrectOption, $incorrectOptions) && $incorrectOption != $correctOption) {
        //         $incorrectOptions[] = [
        //             'option' => $incorrectOption,
        //             'isCorrect' => false
        //         ];
    
        //         $count = 0;
        //     }
        // }

        $count++;
    }

    if($count >= 100){
        return 0;
    }

    // Shuffle the options randomly
    shuffle($incorrectOptions);

    return $incorrectOptions;
}
function generateRandomNumberTime($length) {
    $min = pow(10, $length - 1);
    $max = pow(10, $length) - 1;
    return mt_rand($min, $max);
}

function generateRandomIncorrectOptionTime($correctOption) {
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

function setQuestionsShape($user_id, $class, $subject, $topic, $subtopic, $question, $opt_1, $opt_2, $opt_3, $opt_4, $correct_opt, $shape_info)
    {
        global $conn; // Access the global $conn object
        $shape_info_json = json_encode($shape_info);
        
        try {
            $query = "INSERT INTO count_quest (userid, class, subject, topic, subtopic, question, opt_a, opt_b, opt_c, opt_d, correct_ans, shape_info) 
                    VALUES ($user_id, $class, $subject, $topic, $subtopic, '$question', '$opt_1', '$opt_2', '$opt_3', '$opt_4', '$correct_opt', '$shape_info')";
            
            $result = mysqli_query($conn, $query);
            
            // Check if the query was successful
            if ($result) {
                return true; // Insertion successful
            } else {
                return mysqli_error($conn); // Insertion failed
            }
            
        } catch (Exception $e) {
            echo $e;
            exit('Database error.');
        }
    }

    function getOptionArray($correct_opt) {
        $options = array();
        $total_options = 4;
    
        // Add the correct option
        $options[] = array(
            'option' => $correct_opt,
            'isCorrect' => true
        );

        $count = 0;
    
        // Generate unique random options
        while ($count <= 100 && count($options) < $total_options) {
            $random_option = random_fraction_string($correct_opt);
            if (!in_array($random_option, array_column($options, 'option'))) {
                $option = array(
                    'option' => $random_option,
                    'isCorrect' => false
                );
                $options[] = $option;
                $count = 0;
            }

            $count++;
        }
    
        // Shuffle the options array
        shuffle($options);
    
        if($count < 100)
        return $options;

        else
        return 0;
    }

    function random_fraction_string($fraction) {
        $numerator_temp = explode("/", $fraction)[0];
        $denominator_temp = explode("/", $fraction)[1];
        $numerator = mt_rand(pow(10, strlen($numerator_temp) - 1), $denominator_temp);

        $fraction_string = $numerator . '/' . $denominator_temp;
        return $fraction_string;
    }

    function getTimeBeforeMinutes($currentTime, $minutesToSubtract) {
        // Convert the current time to minutes since midnight
        list($hours, $minutes) = array_map('intval', explode(":", $currentTime));
        $totalMinutes = $hours * 60 + $minutes;
      
        // Calculate the new time in minutes
        $newTotalMinutes = ($totalMinutes - $minutesToSubtract + 720) % 720;
      
        // Convert the new total minutes back to hours and minutes
        $newHours = floor($newTotalMinutes / 60);
        $newMinutes = $newTotalMinutes % 60;
      
        // Format the new time as "hh:mm"
        $formattedHours = (($newHours % 12 === 0) ? 12 : $newHours % 12);
        $formattedHours = str_pad($formattedHours, 2, "0", STR_PAD_LEFT);
        $formattedMinutes = str_pad($newMinutes, 2, "0", STR_PAD_LEFT);
      
        return "{$formattedHours}:{$formattedMinutes}";
      }
      
      function getTimeAfterMinutes($currentTime, $minutesToAdd) {
        // Convert the current time to minutes since midnight
        list($hours, $minutes) = array_map('intval', explode(":", $currentTime));
        $totalMinutes = $hours * 60 + $minutes;
      
        // Calculate the new time in minutes
        $newTotalMinutes = ($totalMinutes + $minutesToAdd) % 720;
      
        // Convert the new total minutes back to hours and minutes
        $newHours = floor($newTotalMinutes / 60);
        $newMinutes = $newTotalMinutes % 60;
      
        // Format the new time as "hh:mm"
        $formattedHours = (($newHours % 12 === 0) ? 12 : $newHours % 12);
        $formattedHours = str_pad($formattedHours, 2, "0", STR_PAD_LEFT);
        $formattedMinutes = str_pad($newMinutes, 2, "0", STR_PAD_LEFT);
      
        return "{$formattedHours}:{$formattedMinutes}";
      }

      function getRandomHour() {
        return rand(1, 12);
      }
      
      function getRandomMinute() {
        return rand(0, 59);
      }
      
      function getRandomMultipleOfTen() {
        $number = 0;

        while ($number < 1 || $number > 100 || $number % 10 !== 0) {
            $number = mt_rand(1, 9) * 10;
        }

        return $number;
    }

    function shuffleArray($array) {
    // Create a copy of the original array
        $shuffledArray = $array;

        // Iterate over the array from the end to the beginning
        for ($i = count($shuffledArray) - 1; $i > 0; $i--) {
            // Generate a random index between 0 and i
            $randomIndex = mt_rand(0, $i);

            // Swap the elements at randomIndex and i
            $temp = $shuffledArray[$randomIndex];
            $shuffledArray[$randomIndex] = $shuffledArray[$i];
            $shuffledArray[$i] = $temp;
        }

        return $shuffledArray;
    }

    function addShadedBoxCoordinate($row, $col) {
        global $shadedBoxCoordinates;
        // echo "added";
        $shadedBoxCoordinates[] = array('row' => $row, 'col' => $col);
    }

    function isUnboundedGap($row, $col, $matrixSize, &$visited) {
        global $shadedBoxCoordinates;
       
        if($row < 0 || $row >= $matrixSize || $col < 0 || $col >= $matrixSize) {
            return true;
        }

        foreach($shadedBoxCoordinates as $coords) {
            if($coords["row"] == $row && $coords["col"] == $col) {
                return false;
            }
        }

        foreach($visited as $node) {
            if($node["row"] == $row && $node["col"] == $col) {
                return false;
            }
        }

        $visited[] = array(
            "row" => $row,
            "col" => $col
        ); 

        

        return    (isUnboundedGap($row - 1, $col, $matrixSize, $visited) 
                || isUnboundedGap($row + 1, $col, $matrixSize, $visited)
                || isUnboundedGap($row, $col - 1, $matrixSize, $visited)
                || isUnboundedGap($row, $col + 1, $matrixSize, $visited)); 
    }
  
    function shadeAdjacent($boxIndex, $matrixSize, $shadedBoxes) {
        global $shadedBoxCoordinates;
        // global $shadedCount;
        $visited = array();

        shadeRandomAdjacent($boxIndex, $matrixSize, $shadedBoxes, $visited);

        // var_dump($shadedBoxCoordinates);

        for($i = 0; $i < $matrixSize; $i++) {
            for($j = 0; $j < $matrixSize; $j++) {
                $flag = true;

                $visited_1 = array();

                foreach($shadedBoxCoordinates as $coord) {
                    if($coord["row"] == $i && $coord["col"] == $j) {
                        $flag = false;
                        break;
                    }
                }

                if($flag && !isUnboundedGap($i, $j, $matrixSize, $visited_1)) {
                    addShadedBoxCoordinate($i, $j);
                }
            }
        }

        
        // var_dump($shadedBoxCoordinates);

        return;
    }
  
      function shadeRandomAdjacent($index, $matrixSize, $shadedBoxes, &$visited) {
        global $shadedCount;
  
        if ($shadedCount >= $shadedBoxes || in_array($index, $visited)) {
          return;
        }
  
        $visited[] = $index;
        $shadedCount++;
        $row = floor($index / $matrixSize);
        $col = $index % $matrixSize;
        addShadedBoxCoordinate($row, $col);
  
        $adjIndices = array(
          $index - $matrixSize, // Top
          $index + $matrixSize, // Bottom
          $index - 1, // Left
          $index + 1 // Right
        );
  
        shuffle($adjIndices); // Randomize the adjacent indices
  
        foreach ($adjIndices as $adjIndex) {
          $adjRow = floor($adjIndex / $matrixSize);
          $adjCol = $adjIndex % $matrixSize;
  
          if (
            $adjRow >= 0 &&
            $adjRow < $matrixSize &&
            $adjCol >= 0 &&
            $adjCol < $matrixSize &&
            abs($adjRow - floor($index / $matrixSize)) +
              abs($adjCol - ($index % $matrixSize)) ==
              1
          ) {
  
            // echo "if enter";
            shadeRandomAdjacent($adjIndex, $matrixSize, $shadedBoxes, $visited);
          }
        }
      }
  
      function getPerimeter($coords) {
        $perimeter = 0;
        $directions = array(
            array(0, 1),
            array(1, 0),
            array(0, -1),
            array(-1, 0),
        );
  
        foreach ($coords as $coord) {
            $row = $coord['row'];
            $col = $coord['col'];
  
            foreach ($directions as $direction) {
                $dx = $direction[0];
                $dy = $direction[1];
                $newRow = $row + $dx;
                $newCol = $col + $dy;
  
                $adjacentCoord = findAdjacentCoord($coords, $newRow, $newCol);
  
                if (!$adjacentCoord) {
                    $perimeter++;
                }
            }
        }
  
        return $perimeter;
      }
  
      // Helper function to find an adjacent coordinate in the $coords array
      function findAdjacentCoord($coords, $row, $col) {
        foreach ($coords as $coord) {
            if ($coord['row'] == $row && $coord['col'] == $col) {
                return $coord;
            }
        }
        return null;
      }
  
      function calculatePerimeter($shadedBoxCoordinates) {
        // global $shadedBoxCoordinates;
        
        $perimeter = getPerimeter($shadedBoxCoordinates);
        echo "Perimeter: " . $perimeter . PHP_EOL;
        return $perimeter;
      }
  
  
  
      function generateCoordinates() {
        global $shadedBoxCoordinates, $matrixSize;
        $shadedBoxCoordinates = array();
        $max_shaded = 80;
        $min_shaded = 15;
        $randomShaded = mt_rand($min_shaded, $max_shaded);
        $shadedBoxes = intval($randomShaded);
  
        $randomBoxIndex = mt_rand(0, 99); // Assuming a 10x10 matrix, so 100 elements in total
        shadeAdjacent($randomBoxIndex, $matrixSize, $shadedBoxes);

        // var_dump($shadedBoxCoordinates);
        // Assuming the calculatePerimeter() function is defined elsewhere in your PHP code
        $perimeter = calculatePerimeter($shadedBoxCoordinates);
        return array('perimeter' => $perimeter, 'coordinates' => $shadedBoxCoordinates);
      }

      function getRandomUnits() {
        return rand(2, 10) * 500; // Random number between 1000 and 5000 (inclusive) and is a multiple of 500
      }
      
      
      function fillArrayWithRandomUnits(&$monthsArray) {
        
        foreach ($monthsArray as &$month) {
          $units = array_column($monthsArray, 'units');

          do{
            $randomVar = getRandomUnits();
          }while(in_array($randomVar, $units));

          if(!in_array($randomVar, $units)) {
            $month["units"] = $randomVar;
          }
        }

        return $monthsArray;
      }
      
      function getMonthWithMaxUnits($monthsArray) {
        $maxUnitsMonth = $monthsArray[0];
        foreach ($monthsArray as $month) {
          if ($month["units"] > $maxUnitsMonth["units"]) {
            $maxUnitsMonth = $month;
          }
        }
        return $maxUnitsMonth;
      }
      
      function getMonthWithMinUnits($monthsArray) {
        $minUnitsMonth = $monthsArray[0];
        foreach ($monthsArray as $month) {
          if ($month["units"] < $minUnitsMonth["units"]) {
            $minUnitsMonth = $month;
          }
        }
        return $minUnitsMonth;
      }
      
      function generateOptions($correctMonth, $allMonths) {

        // Remove the correct month from the array of all months
        $incorrectOptions = array_filter($allMonths, function ($month) use ($correctMonth) {
          return $month !== $correctMonth;
        });
      
        // Shuffle the incorrect options
        shuffle($incorrectOptions);
      
        // Take the first 3 incorrect options and add the correct option to create the final options array
        $options = array_slice($incorrectOptions, 0, 3);
        $options[] = $correctMonth;
      
        // Shuffle the options again to randomize the position of the correct option
        shuffle($options);
      
        // Get the correct month index (position) in the options array
        // $correctIndex = array_search($correctMonth, $options) + 1;
      
        return array(
          "options" => $options,
          "correctIndex" => $correctMonth,
        );
      }

    function gcd($a, $b) {
        return $b == 0 ? $a : gcd($b, $a % $b);
    }

    function reduceFraction($numerator, $denominator) {
        if ($denominator == 0) {
            throw new Exception("Denominator cannot be zero.");
        }
    
        $commonDivisor = gcd($numerator, $denominator);
        $reducedNumerator = $numerator / $commonDivisor;
        $reducedDenominator = $denominator / $commonDivisor;
    
        return [$reducedNumerator, $reducedDenominator];
    }
    
    function getFinalDirection($initialDirection, $turnDirection, $turnFraction) {
        $directions = [
            "North",
            "Northeast",
            "East",
            "Southeast",
            "South",
            "Southwest",
            "West",
            "Northwest",
        ];
        $totalDirections = count($directions);
    
        $initialIndex = array_search($initialDirection, $directions);
        if ($initialIndex === false) {
            throw new Exception("Invalid initial direction.");
        }
    
        $turns = explode("/", $turnFraction);
        if (count($turns) !== 2) {
            throw new Exception("Invalid turn fraction.");
        }
    
        $numerator = intval($turns[0], 10);
        $denominator = intval($turns[1], 10);
        if (is_nan($numerator) || is_nan($denominator) || $denominator === 0) {
            throw new Exception("Invalid turn fraction.");
        }
    
        $commonDivisor = gcd($numerator, $denominator);
        $normalizedNumerator = $numerator / $commonDivisor;
        $normalizedDenominator = $denominator / $commonDivisor;
    
        $normalizedTurnUnits = $normalizedNumerator / $normalizedDenominator;
        $totalTurns = ($turnDirection === "clockwise" || $turnDirection === "right")
            ? $normalizedTurnUnits
            : 1 - $normalizedTurnUnits;
    
        $finalIndex = ($initialIndex + round($totalTurns * $totalDirections) + $totalDirections) % $totalDirections;
        return $directions[$finalIndex];
    }

    function getInverseTurn($initialDirection, $finalDirection) {
        $directions = [
            "North",
            "Northeast",
            "East",
            "Southeast",
            "South",
            "Southwest",
            "West",
            "Northwest",
        ];
        $totalDirections = count($directions);
    
        $initialIndex = array_search($initialDirection, $directions);
        if ($initialIndex === false) {
            throw new Exception("Invalid initial direction.");
        }
    
        $finalIndex = array_search($finalDirection, $directions);
        if ($finalIndex === false) {
            throw new Exception("Invalid final direction.");
        }
    
        $clockwiseTurns = ($finalIndex - $initialIndex + $totalDirections) % $totalDirections;
        $anticlockwiseTurns = ($initialIndex - $finalIndex + $totalDirections) % $totalDirections;
    
        $totalTurns = $clockwiseTurns <= $anticlockwiseTurns ? $clockwiseTurns : -$anticlockwiseTurns;
        $commonDivisor = gcd(abs($totalTurns), $totalDirections);
        $turnsNumerator = abs($totalTurns) / $commonDivisor;
        $turnsDenominator = $totalDirections / $commonDivisor;
    
        $turnsFraction = "{$turnsNumerator}/{$turnsDenominator}";
        $turnDirection =
            $totalTurns <= 0
                ? (rand(0, 1) ? "anticlockwise" : "left")
                : (rand(0, 1) ? "clockwise" : "right");
    
        return [
            "turnsFraction" => $turnsFraction,
            "turnDirection" => $turnDirection,
        ];
    }

    function generateRandomOptionsDirection($correctOption) {
        global $turnsArray;
        global $turnsDirection;

        $alternate_terms = array(
            "anticlockwise" => "left",
            "clockwise" => "right",
            "right" => "clockwise",
            "left" => "anticlockwise",
        );

        $options = [];
        $alternate_options = [];
        $noTurn = explode(" ", $correctOption);

        $options[] = $correctOption;
        $alternate_options[] = $noTurn[0] . " " . $alternate_terms[$noTurn[1]];

        $count = 0;
        while ($count <= 100 && count($options) < 4) {
                $randomArrayIndex = rand(0, count($turnsArray) - 1);
                $randomDirectionIndex = rand(0, count($turnsDirection) - 1);
                $randomOption = $turnsArray[$randomArrayIndex] . " " . $turnsDirection[$randomDirectionIndex];
    
                $alt_incorrect = $turnsArray[$randomArrayIndex] . " " . $alternate_terms[$turnsDirection[$randomDirectionIndex]];
                if (!in_array($randomOption, $options) 
                && !in_array($alt_incorrect, $alternate_options) 
                && !in_array($alt_incorrect, $options) 
                && !in_array($randomOption, $alternate_options)) {
                    $options[] = $randomOption;
                    $alternate_options[] = $alt_incorrect;
                    $count = 0;
                }

                $count++;
        }

        if($count >= 100) {
            return 0;
        }

        shuffle($options);
    
        return ["options" => $options, "correctIndex" => $correctOption];
    }

    function getRandomElement($array) {
        return $array[array_rand($array)];
    }
    
    function getRandomDigitExcluding($number, $exclusionList) {
        $numberString = strval($number);
        $availableDigits = array_filter(str_split($numberString), function ($digit) use ($exclusionList) {
            return !in_array(intval($digit), $exclusionList);
        });
    
        if (count($availableDigits) === 0) {
            return null; // Return null if all digits are in the exclusion list or if exclusionList is empty
        }
    
        $randomIndex = array_rand($availableDigits);
        $randomDigit = intval($availableDigits[$randomIndex]);
    
        return $randomDigit;
    }

    function getRandomMathExpression($P, $Q, $R, $maxAttempts = 100) {
        $operators = array("+", "-", "*", "/");
        $operator1 = null;
        $operator2 = null;
    
        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            $operator1 = $operators[rand(0, count($operators) - 1)];
            do{
            if ($P === 0 || $Q === 0 || $R === 0) {
                $operator2 = array_filter($operators, function ($op) {
                    return $op !== "/";
                });
                $operator2 = $operator2[array_rand($operator2)];
            } else {
                $operator2 = $operators[rand(0, count($operators) - 1)];
            }
            $attempt++;
            }while($attempt <= $maxAttempts && $operator1 == $operator2);
    
            $expression = "{$P} {$operator1} {$Q} {$operator2} {$R}";
            $expression_result = "P {$operator1} Q {$operator2} R";
            $result = intval(round(eval("return {$expression};")));
    
            if ($result >= 0 && $attempt <= $maxAttempts) {
                return array("expression_result" => $expression_result, "result" => $result);
            }
        }
    
        // Return null or an error message if a valid expression is not found within the maximum attempts.
        return null;
    }
    
    function subtractMinutesFromTime($timeString, $minutesToSubtract) {
        // Parse the timeString to extract hours, minutes, and AM/PM
        list($time, $ampm) = explode(" ", $timeString);
        list($hours, $minutes) = array_map("intval", explode(":", $time));
        $isPM = strtoupper($ampm) === "PM";
    
        // Convert hours to 24-hour format
        $hours24 = $hours % 12;
        if ($isPM) {
            $hours24 += 12;
        }
    
        // Subtract the minutes
        $totalMinutes = $hours24 * 60 + $minutes - $minutesToSubtract;
    
        // Handle minute underflow
        $totalMinutes = ($totalMinutes + 1440) % 1440;
    
        // Convert back to 12-hour format
        $resultHours = (int) ($totalMinutes / 60);
        $resultMinutes = $totalMinutes % 60;
        $resultAMPM = $resultHours < 12 ? "AM" : "PM";
    
        // Convert hours to 12-hour format
        $resultHours = $resultHours % 12 === 0 ? 12 : $resultHours % 12;
    
        // Format hours and minutes to two digits with leading zeros
        $formattedHours = str_pad($resultHours, 2, "0", STR_PAD_LEFT);
        $formattedMinutes = str_pad($resultMinutes, 2, "0", STR_PAD_LEFT);
    
        // Combine all parts to get the final time string
        return "$formattedHours:$formattedMinutes $resultAMPM";
    }

    function addMinutesToTime($timeString, $minutesToAdd) {
        // Parse the timeString to extract hours, minutes, and AM/PM
        list($time, $ampm) = explode(" ", $timeString);
        list($hours, $minutes) = array_map("intval", explode(":", $time));
        $isPM = strtoupper($ampm) === "PM";
    
        // Convert hours to 24-hour format
        $hours24 = $hours % 12;
        if ($isPM) {
            $hours24 += 12;
        }
    
        // Add the minutes
        $totalMinutes = $hours24 * 60 + $minutes + $minutesToAdd;
    
        // Handle minute overflow
        $totalMinutes = ($totalMinutes + 1440) % 1440;
    
        // Convert back to 12-hour format
        $resultHours = (int) ($totalMinutes / 60);
        $resultMinutes = $totalMinutes % 60;
        $resultAMPM = $resultHours < 12 ? "AM" : "PM";
    
        // Convert hours to 12-hour format
        $resultHours = $resultHours % 12 === 0 ? 12 : $resultHours % 12;
    
        // Format hours and minutes to two digits with leading zeros
        $formattedHours = str_pad($resultHours, 2, "0", STR_PAD_LEFT);
        $formattedMinutes = str_pad($resultMinutes, 2, "0", STR_PAD_LEFT);
    
        // Combine all parts to get the final time string
        return "$formattedHours:$formattedMinutes $resultAMPM";
    }

    function getRandomMultipleOf5() {
        return rand(0, 11) * 5; // Generates 0, 5, 10, 15, ..., 55, or 60
    }

    function getRandomMultipleOf15() {
        return rand(0, 3) * 15; // Generates 0, 15, 30, or 45
    }

    //conversion
    // Kilometers to meters
    function kmToMeters($km) {
        return $km * 1000 . " metres";
    }

    // Meters to kilometers
    function metersToKm($meters) {
        return (intval(floor($meters / 1000))) . " kms " . (($meters % 1000) == 0 ? "" : ($meters % 1000) ." metres");
    }

    // Feet to inches
    function feetToInches($feet) {
        return ($feet * 12) . " inches";
    }

    // Inches to feet
    function inchesToFeet($inches) {
        return (intval(floor($inches / 12))) . " feet " . (($inches % 12) == 0 ? "" : ($inches % 12) . " inches");
    }
    // Kilograms to grams
    function kgToGrams($kg) {
        return ($kg * 1000) . " gms";
    }

    // Grams to kilograms
    function gramsToKg($grams) {
        return (intval(floor($grams / 1000))) . " kgs " . (($grams % 1000) == 0 ? "" : ($grams % 1000) . " gms");
    }

    // Kilograms to pounds
    function kgToPounds($kg) {
        return $kg * 2.20462;
    }

    // Pounds to kilograms
    function poundsToKg($pounds) {
        return $pounds / 2.20462;
    }

    // Liters to milliliters
    function litersToMilliliters($liters) {
        return ($liters * 1000) . " ml";
    }

    // Milliliters to liters
    function millilitersToLiters($milliliters) {
        return (intval(floor($milliliters / 1000))) . " litres " . (($milliliters % 1000) == 0 ? "" : ($milliliters % 1000) . " ml");
    }

    // Liters to cubic meters
    function litersToCubicMeters($liters) {
        return $liters / 1000;
    }

    // Cubic meters to liters
    function cubicMetersToLiters($cubicMeters) {
        return $cubicMeters * 1000;
    }
    // Hours to minutes
    function hoursToMinutes($hours) {
        return ($hours * 60) . " mins";
    }

    // Minutes to hours
    function minutesToHours($minutes) {
        return (intval(floor($minutes / 60))) . " hrs " . (($minutes % 60) == 0 ? "" : ($minutes % 60) . " mins");
    }

    // Hours to seconds
    function hoursToSeconds($hours) {
        return $hours * 3600;
    }

    // Seconds to hours
    function secondsToHours($seconds) {
        return (intval(floor($seconds / 3600))) . " hrs " . (($seconds % 3600) == 0 ? "" : ($seconds % 3600) . " mins");
    }

    function compareFractions($fraction1, $fraction2) {
        list($numerator1, $denominator1) = explode('/', $fraction1);
        list($numerator2, $denominator2) = explode('/', $fraction2);
        
        $value1 = $numerator1 / $denominator1;
        $value2 = $numerator2 / $denominator2;
        
        if ($value1 == $value2) {
            return 0;
        }
        
        return ($value1 < $value2) ? -1 : 1;
    }
    
    function sortFractionsAscending($fractions) {
        usort($fractions, 'compareFractions');
        return $fractions;
    }
    
    function sortFractionsDescending($fractions) {
        usort($fractions, function($a, $b) {
            return -compareFractions($a, $b);
        });
        return $fractions;
    }

    function addFractions($fractions) {
        $resultNumerator = 0;
        $resultDenominator = 1;
    
        foreach ($fractions as $fraction) {
            list($numerator, $denominator) = explode('/', $fraction);
            $gcd = gcd($resultDenominator, $denominator);
            $resultNumerator = ($resultNumerator * ($denominator / $gcd)) + ($numerator * ($resultDenominator / $gcd));
            $resultDenominator *= ($denominator / $gcd);
        }
    
        $gcd = gcd($resultNumerator, $resultDenominator);
        $resultNumerator /= $gcd;
        $resultDenominator /= $gcd;
    
        return "$resultNumerator/$resultDenominator";
    }
    
    function subtractFractions($fractions) {
        $resultNumerator = 0;
        $resultDenominator = 1;
    
        foreach ($fractions as $fraction) {
            list($numerator, $denominator) = explode('/', $fraction);
    
            // Calculate the least common multiple of the denominators.
            $lcm = lcm($resultDenominator, $denominator);
    
            // Adjust the numerators based on the common denominator.
            $adjustedNumerator = abs(($resultNumerator * ($lcm / $resultDenominator)) - ($numerator * ($lcm / $denominator)));
    
            // Update the result numerator and denominator.
            $resultNumerator = $adjustedNumerator;
            $resultDenominator = $lcm;
        }
    
        // Simplify the result.
        $gcd = gcd($resultNumerator, $resultDenominator);
        $resultNumerator /= $gcd;
        $resultDenominator /= $gcd;
    
        // Return the result.
        return abs($resultNumerator) . '/' . abs($resultDenominator);
    }
      
    function multiplyFractions($fractions) {
        $resultNumerator = 1;
        $resultDenominator = 1;
    
        foreach ($fractions as $fraction) {
            list($numerator, $denominator) = explode('/', $fraction);
            $resultNumerator *= $numerator;
            $resultDenominator *= $denominator;
        }
    
        $gcd = gcd($resultNumerator, $resultDenominator);
        $resultNumerator /= $gcd;
        $resultDenominator /= $gcd;
    
        // Return the result.
        return abs($resultNumerator) . '/' . abs($resultDenominator);
    }
    
    function divideFractions(array $fractions): string {
        if (count($fractions) !== 2) {
            return "Invalid input. Please provide exactly two fractions.";
        }
    
        list($numerator1, $denominator1) = explode('/', $fractions[0]);
        list($numerator2, $denominator2) = explode('/', $fractions[1]);
    
        $resultNumerator = (int) $numerator1 * $denominator2;
        $resultDenominator = (int) $denominator1 * $numerator2;
    
        $gcd = gcd($resultNumerator, $resultDenominator);
        $resultNumerator /= $gcd;
        $resultDenominator /= $gcd;
    
        // Return the result.
        return abs($resultNumerator) . '/' . abs($resultDenominator);
    }

    function generateEquivalentFractions($fraction) {
        list($numerator, $denominator) = explode('/', $fraction);
        $commonFactor = rand(2, 10);
    
        $newNumerator = $numerator * $commonFactor;
        $newDenominator = $denominator * $commonFactor;
    
        // $gcd = gcd($newNumerator, $newDenominator);
        // $newNumerator /= $gcd;
        // $newDenominator /= $gcd;
    
        return "{$newNumerator}/{$newDenominator}";
    }

    function generateNonEquivalentFraction($fraction) {
        list($numerator, $denominator) = explode('/', $fraction);
    
        do {
            $newNumerator = rand(1, $numerator + 10);
            $newDenominator = rand(1, $denominator + 10);
        } while ($newNumerator == $numerator || $newDenominator == $denominator);
    
        $gcd = gcd($newNumerator, $newDenominator);
        $newNumerator /= $gcd;
        $newDenominator /= $gcd;
    
        return "{$newNumerator}/{$newDenominator}";
    }

    function roundToNearest($number, $nearest) {
        return round($number / $nearest) * $nearest;
    }

    function roundDecimalsToNearest($number, $places) {
        $multiplier = pow(10, $places);
        return round($number * $multiplier) / $multiplier;
    }

    function randomFloat($min, $max, $decimalPlaces = 2) {
        $multiplier = pow(10, $decimalPlaces);
        $randomInt = mt_rand($min * $multiplier, $max * $multiplier);
    
        return $randomInt / $multiplier;
    }

    function improperToMixedFraction($fraction) {
        list($numerator, $denominator) = explode("/", $fraction);
        $wholePart = intval($numerator / $denominator);
        $remainingNumerator = $numerator % $denominator;
        
        if ($remainingNumerator === 0) {
            return "$wholePart";
        }
        
        return "$wholePart" . "_$remainingNumerator/$denominator";
    }

    function mixedToImproperFraction($mixedFraction) {
        $parts = explode("_", $mixedFraction);
        $wholePart = isset($parts[0]) ? intval($parts[0]) : 0;
        $fractionPart = isset($parts[1]) ? $parts[1] : "0/1";
        
        list($numerator, $denominator) = explode("/", $fractionPart);
        $improperNumerator = ($wholePart * $denominator) + $numerator;
        
        return "$improperNumerator/$denominator";
    }

    // Function to calculate the Least Common Multiple (LCM) of two numbers
    function lcm($a, $b) {
        return ($a * $b) / gcd($a, $b);
    }
    
    // Function to calculate the LCM of an array of numbers
    function arrayLCM($numbers) {
        $result = 1;
        foreach ($numbers as $number) {
            $result = lcm($result, $number);
        }
        return $result;
    }
    
    // Function to calculate the Highest Common Factor (HCF) of an array of numbers
    function arrayHCF($numbers) {
        $result = $numbers[0];
        for ($i = 1; $i < count($numbers); $i++) {
            $result = gcd($result, $numbers[$i]);
        }
        return $result;
    }

    function intToRoman($num) {
        $romanNumerals = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        );
    
        $roman = '';
        foreach ($romanNumerals as $symbol => $value) {
            while ($num >= $value) {
                $roman .= $symbol;
                $num -= $value;
            }
        }
    
        return $roman;
    }

    function getDayOfWeek($day, $month, $year) {
        $dateString = "$year-$month-$day";
        $dateTime = new DateTime($dateString);
        return $dateTime->format('l');
    }

    function getDateForWeekdayOccurrence($year, $month, $weekday, $occurrence) {
        $firstDayOfMonth = new DateTime("$year-$month-01");
        $dayOfWeek = ($firstDayOfMonth->format('N') + 6) % 7;
        
        $daysToAdd = ($weekday - $dayOfWeek + 7) % 7 + ($occurrence - 1) * 7;
        
        $date = clone $firstDayOfMonth;
        $date->add(new DateInterval("P{$daysToAdd}D"));
        
        return $date->format('d/m');
    }

    // Celsius to Fahrenheit
    function celsiusToFahrenheit($celsius) {
        return ($celsius * 9/5) + 32;
    }

    // Fahrenheit to Celsius
    function fahrenheitToCelsius($fahrenheit) {
        return ($fahrenheit - 32) * 5/9;
    }

    function generateRandomWord($length = 5, $startingLetter = '') {
        $words = [
            "a",
            "able",
            "about",
            "absolute",
            "accept",
            "account",
            "achieve",
            "across",
            "act",
            "active",
            "actual",
            "add",
            "address",
            "admit",
            "advertise",
            "affect",
            "afford",
            "after",
            "afternoon",
            "again",
            "against",
            "age",
            "agent",
            "ago",
            "agree",
            "air",
            "all",
            "allow",
            "almost",
            "along",
            "already",
            "alright",
            "also",
            "although",
            "always",
            "america",
            "amount",
            "and",
            "another",
            "answer",
            "any",
            "apart",
            "apparent",
            "appear",
            "apply",
            "appoint",
            "approach",
            "appropriate",
            "area",
            "argue",
            "arm",
            "around",
            "arrange",
            "art",
            "as",
            "ask",
            "associate",
            "assume",
            "at",
            "attend",
            "authority",
            "available",
            "aware",
            "away",
            "awful",
            "baby",
            "back",
            "bad",
            "bag",
            "balance",
            "ball",
            "bank",
            "bar",
            "base",
            "basis",
            "be",
            "bear",
            "beat",
            "beauty",
            "because",
            "become",
            "bed",
            "before",
            "begin",
            "behind",
            "believe",
            "benefit",
            "best",
            "bet",
            "between",
            "big",
            "bill",
            "birth",
            "bit",
            "black",
            "bloke",
            "blood",
            "blow",
            "blue",
            "board",
            "boat",
            "body",
            "book",
            "both",
            "bother",
            "bottle",
            "bottom",
            "box",
            "boy",
            "break",
            "brief",
            "brilliant",
            "bring",
            "britain",
            "brother",
            "budget",
            "build",
            "bus",
            "business",
            "busy",
            "but",
            "buy",
            "by",
            "cake",
            "call",
            "can",
            "car",
            "card",
            "care",
            "carry",
            "case",
            "cat",
            "catch",
            "cause",
            "cent",
            "centre",
            "certain",
            "chair",
            "chairman",
            "chance",
            "change",
            "chap",
            "character",
            "charge",
            "cheap",
            "check",
            "child",
            "choice",
            "choose",
            "Christ",
            "Christmas",
            "church",
            "city",
            "claim",
            "class",
            "clean",
            "clear",
            "client",
            "clock",
            "close",
            "closes",
            "clothe",
            "club",
            "coffee",
            "cold",
            "colleague",
            "collect",
            "college",
            "colour",
            "come",
            "comment",
            "commit",
            "committee",
            "common",
            "community",
            "company",
            "compare",
            "complete",
            "compute",
            "concern",
            "condition",
            "confer",
            "consider",
            "consult",
            "contact",
            "continue",
            "contract",
            "control",
            "converse",
            "cook",
            "copy",
            "corner",
            "correct",
            "cost",
            "could",
            "council",
            "count",
            "country",
            "county",
            "couple",
            "course",
            "court",
            "cover",
            "create",
            "cross",
            "cup",
            "current",
            "cut",
            "dad",
            "danger",
            "date",
            "day",
            "dead",
            "deal",
            "dear",
            "debate",
            "decide",
            "decision",
            "deep",
            "definite",
            "degree",
            "department",
            "depend",
            "describe",
            "design",
            "detail",
            "develop",
            "die",
            "difference",
            "difficult",
            "dinner",
            "direct",
            "discuss",
            "district",
            "divide",
            "do",
            "doctor",
            "document",
            "dog",
            "door",
            "double",
            "doubt",
            "down",
            "draw",
            "dress",
            "drink",
            "drive",
            "drop",
            "dry",
            "due",
            "during",
            "each",
            "early",
            "east",
            "easy",
            "eat",
            "economy",
            "educate",
            "effect",
            "egg",
            "eight",
            "either",
            "elect",
            "electric",
            "eleven",
            "else",
            "employ",
            "encourage",
            "end",
            "engine",
            "english",
            "enjoy",
            "enough",
            "enter",
            "environment",
            "equal",
            "especial",
            "europe",
            "even",
            "evening",
            "ever",
            "every",
            "evidence",
            "exact",
            "example",
            "except",
            "excuse",
            "exercise",
            "exist",
            "expect",
            "expense",
            "experience",
            "explain",
            "express",
            "extra",
            "eye",
            "face",
            "fact",
            "fair",
            "fall",
            "family",
            "far",
            "farm",
            "fast",
            "father",
            "favour",
            "feed",
            "feel",
            "few",
            "field",
            "fight",
            "figure",
            "file",
            "fill",
            "film",
            "final",
            "finance",
            "find",
            "fine",
            "finish",
            "fire",
            "first",
            "fish",
            "fit",
            "five",
            "flat",
            "floor",
            "fly",
            "follow",
            "food",
            "foot",
            "for",
            "force",
            "forget",
            "form",
            "fortune",
            "forward",
            "four",
            "france",
            "free",
            "friday",
            "friend",
            "from",
            "front",
            "full",
            "fun",
            "function",
            "fund",
            "further",
            "future",
            "game",
            "garden",
            "gas",
            "general",
            "germany",
            "get",
            "girl",
            "give",
            "glass",
            "go",
            "god",
            "good",
            "goodbye",
            "govern",
            "grand",
            "grant",
            "great",
            "green",
            "ground",
            "group",
            "grow",
            "guess",
            "guy",
            "hair",
            "half",
            "hall",
            "hand",
            "hang",
            "happen",
            "happy",
            "hard",
            "hate",
            "have",
            "he",
            "head",
            "health",
            "hear",
            "heart",
            "heat",
            "heavy",
            "hell",
            "help",
            "here",
            "high",
            "history",
            "hit",
            "hold",
            "holiday",
            "home",
            "honest",
            "hope",
            "horse",
            "hospital",
            "hot",
            "hour",
            "house",
            "how",
            "however",
            "hullo",
            "hundred",
            "husband",
            "idea",
            "identify",
            "if",
            "imagine",
            "important",
            "improve",
            "in",
            "include",
            "income",
            "increase",
            "indeed",
            "individual",
            "industry",
            "inform",
            "inside",
            "instead",
            "insure",
            "interest",
            "into",
            "introduce",
            "invest",
            "involve",
            "issue",
            "it",
            "item",
            "jesus",
            "job",
            "join",
            "judge",
            "jump",
            "just",
            "keep",
            "key",
            "kid",
            "kill",
            "kind",
            "king",
            "kitchen",
            "knock",
            "know",
            "labour",
            "lad",
            "lady",
            "land",
            "language",
            "large",
            "last",
            "late",
            "laugh",
            "law",
            "lay",
            "lead",
            "learn",
            "leave",
            "left",
            "leg",
            "less",
            "let",
            "letter",
            "level",
            "lie",
            "life",
            "light",
            "like",
            "likely",
            "limit",
            "line",
            "link",
            "list",
            "listen",
            "little",
            "live",
            "load",
            "local",
            "lock",
            "london",
            "long",
            "look",
            "lord",
            "lose",
            "lot",
            "love",
            "low",
            "luck",
            "lunch",
            "machine",
            "main",
            "major",
            "make",
            "man",
            "manage",
            "many",
            "mark",
            "market",
            "marry",
            "match",
            "matter",
            "may",
            "maybe",
            "mean",
            "meaning",
            "measure",
            "meet",
            "member",
            "mention",
            "middle",
            "might",
            "mile",
            "milk",
            "million",
            "mind",
            "minister",
            "minus",
            "minute",
            "miss",
            "mister",
            "moment",
            "monday",
            "money",
            "month",
            "more",
            "morning",
            "most",
            "mother",
            "motion",
            "move",
            "mrs",
            "much",
            "music",
            "must",
            "name",
            "nation",
            "nature",
            "near",
            "necessary",
            "need",
            "never",
            "new",
            "news",
            "next",
            "nice",
            "night",
            "nine",
            "no",
            "non",
            "none",
            "normal",
            "north",
            "not",
            "note",
            "notice",
            "now",
            "number",
            "obvious",
            "occasion",
            "odd",
            "of",
            "off",
            "offer",
            "office",
            "often",
            "okay",
            "old",
            "on",
            "once",
            "one",
            "only",
            "open",
            "operate",
            "opportunity",
            "oppose",
            "or",
            "order",
            "organize",
            "original",
            "other",
            "otherwise",
            "ought",
            "out",
            "over",
            "own",
            "pack",
            "page",
            "paint",
            "pair",
            "paper",
            "paragraph",
            "pardon",
            "parent",
            "park",
            "part",
            "particular",
            "party",
            "pass",
            "past",
            "pay",
            "pence",
            "pension",
            "people",
            "per",
            "percent",
            "perfect",
            "perhaps",
            "period",
            "person",
            "photograph",
            "pick",
            "picture",
            "piece",
            "place",
            "plan",
            "play",
            "please",
            "plus",
            "point",
            "police",
            "policy",
            "politic",
            "poor",
            "position",
            "positive",
            "possible",
            "post",
            "pound",
            "power",
            "practise",
            "prepare",
            "present",
            "press",
            "pressure",
            "presume",
            "pretty",
            "previous",
            "price",
            "print",
            "private",
            "probable",
            "problem",
            "proceed",
            "process",
            "produce",
            "product",
            "programme",
            "project",
            "proper",
            "propose",
            "protect",
            "provide",
            "public",
            "pull",
            "purpose",
            "push",
            "put",
            "quality",
            "quarter",
            "question",
            "quick",
            "quid",
            "quiet",
            "quite",
            "radio",
            "rail",
            "raise",
            "range",
            "rate",
            "rather",
            "read",
            "ready",
            "real",
            "realise",
            "really",
            "reason",
            "receive",
            "recent",
            "reckon",
            "recognize",
            "recommend",
            "record",
            "red",
            "reduce",
            "refer",
            "regard",
            "region",
            "relation",
            "remember",
            "report",
            "represent",
            "require",
            "research",
            "resource",
            "respect",
            "responsible",
            "rest",
            "result",
            "return",
            "rid",
            "right",
            "ring",
            "rise",
            "road",
            "role",
            "roll",
            "room",
            "round",
            "rule",
            "run",
            "safe",
            "sale",
            "same",
            "saturday",
            "save",
            "say",
            "scheme",
            "school",
            "science",
            "score",
            "scotland",
            "seat",
            "second",
            "secretary",
            "section",
            "secure",
            "see",
            "seem",
            "self",
            "sell",
            "send",
            "sense",
            "separate",
            "serious",
            "serve",
            "service",
            "set",
            "settle",
            "seven",
            "sex",
            "shall",
            "share",
            "she",
            "sheet",
            "shoe",
            "shoot",
            "shop",
            "short",
            "should",
            "show",
            "shut",
            "sick",
            "side",
            "sign",
            "similar",
            "simple",
            "since",
            "sing",
            "single",
            "sir",
            "sister",
            "sit",
            "site",
            "situate",
            "six",
            "size",
            "sleep",
            "slight",
            "slow",
            "small",
            "smoke",
            "so",
            "social",
            "society",
            "some",
            "son",
            "soon",
            "sorry",
            "sort",
            "sound",
            "south",
            "space",
            "speak",
            "special",
            "specific",
            "speed",
            "spell",
            "spend",
            "square",
            "staff",
            "stage",
            "stairs",
            "stand",
            "standard",
            "start",
            "state",
            "station",
            "stay",
            "step",
            "stick",
            "still",
            "stop",
            "story",
            "straight",
            "strategy",
            "street",
            "strike",
            "strong",
            "structure",
            "student",
            "study",
            "stuff",
            "stupid",
            "subject",
            "succeed",
            "such",
            "sudden",
            "suggest",
            "suit",
            "summer",
            "sun",
            "sunday",
            "supply",
            "support",
            "suppose",
            "sure",
            "surprise",
            "switch",
            "system",
            "table",
            "take",
            "talk",
            "tape",
            "tax",
            "tea",
            "teach",
            "team",
            "telephone",
            "television",
            "tell",
            "ten",
            "tend",
            "term",
            "terrible",
            "test",
            "than",
            "thank",
            "the",
            "then",
            "there",
            "therefore",
            "they",
            "thing",
            "think",
            "thirteen",
            "thirty",
            "this",
            "thou",
            "though",
            "thousand",
            "three",
            "through",
            "throw",
            "thursday",
            "tie",
            "time",
            "to",
            "today",
            "together",
            "tomorrow",
            "tonight",
            "too",
            "top",
            "total",
            "touch",
            "toward",
            "town",
            "trade",
            "traffic",
            "train",
            "transport",
            "travel",
            "treat",
            "tree",
            "trouble",
            "true",
            "trust",
            "try",
            "tuesday",
            "turn",
            "twelve",
            "twenty",
            "two",
            "type",
            "under",
            "understand",
            "union",
            "unit",
            "unite",
            "university",
            "unless",
            "until",
            "up",
            "upon",
            "use",
            "usual",
            "value",
            "various",
            "very",
            "video",
            "view",
            "village",
            "visit",
            "vote",
            "wage",
            "wait",
            "walk",
            "wall",
            "want",
            "war",
            "warm",
            "wash",
            "waste",
            "watch",
            "water",
            "way",
            "we",
            "wear",
            "wednesday",
            "wee",
            "week",
            "weigh",
            "welcome",
            "well",
            "west",
            "what",
            "when",
            "where",
            "whether",
            "which",
            "while",
            "white",
            "who",
            "whole",
            "why",
            "wide",
            "wife",
            "will",
            "win",
            "wind",
            "window",
            "wish",
            "with",
            "within",
            "without",
            "woman",
            "wonder",
            "wood",
            "word",
            "work",
            "world",
            "worry",
            "worse",
            "worth",
            "would",
            "write",
            "wrong",
            "year",
            "yes",
            "yesterday",
            "yet",
            "you",
            "young"
          ];
    
        $matchingWords = array_filter($words, function ($word) use ($length, $startingLetter) {
            return (strlen($word) === $length && ($startingLetter == '' || stripos($word, $startingLetter) === 0));
        });
    
        if (!empty($matchingWords)) {
            return $matchingWords[array_rand($matchingWords)];
        } else {
            return 'fallback';
        }
    }

    function caesarEncrypt($text, $shift) {
        $result = '';
    
        $text = strtolower($text); // Convert text to lowercase
        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        $alphabetLength = strlen($alphabet);
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            
            if (strpos($alphabet, $char) !== false) {
                $position = strpos($alphabet, $char);
                
                // Handle both positive and negative shifts
                $newPos = ($position + $shift + $alphabetLength) % $alphabetLength;
                
                $result .= $alphabet[$newPos];
            } else {
                $result .= $char; // Keep non-alphabet characters unchanged
            }
        }
        
        return $result;
    }
    
    function caesarDecrypt($text, $shift) {
        return caesarEncrypt($text, -$shift); // Decrypt is just encrypting with the inverse shift
    }

    function generateIDString() {
        $length = 10; // Change this to the desired length of your random string
        $randomBytes = random_bytes($length);
        $randomString = bin2hex($randomBytes);

        return $randomString;
    }

    function checkNumReplacement($num1, $num2, $num3, $str) {
        $num_rep_1 = str_replace($str[0], "P", $num1);
        $num_rep_2 = str_replace($str[1], "Q", $num2);
        $num_rep_3 = str_replace($str[2], "R", $num3);

        $max_len = max(strlen($num_rep_1), strlen($num_rep_2), strlen($num_rep_3));
        $num_rep_1 = str_pad($num_rep_1, $max_len, "0", STR_PAD_LEFT);
        $num_rep_2 = str_pad($num_rep_2, $max_len, "0", STR_PAD_LEFT);
        $num_rep_3 = str_pad($num_rep_3, $max_len, "0", STR_PAD_LEFT);

        for($i = 0; $i < $max_len; $i++) {
            if(($num_rep_1[$i] == "P" && $num_rep_2[$i] == "Q") ||
            ($num_rep_1[$i] == "P" && $num_rep_3[$i] == "R") ||
            ($num_rep_2[$i] == "Q" && $num_rep_3[$i] == "R") ||
            ($num_rep_1[$i] == "P" && $num_rep_2[$i] == "Q" && $num_rep_3[$i] == "R")) {
                return false;
            }
        }
    
        return true;
    }

    function containsZero($number) {
        // Convert the number to a string
        $numberStr = (string)$number;
        
        // Use strpos to check if the string contains '0'
        if (strpos($numberStr, '0') !== false) {
            return true; // The number contains 0
        } else {
            return false; // The number does not contain 0
        }
    }

    function countFactors($number) {
        $count = 0;
        for ($i = 1; $i <= $number; $i++) {
            if ($number % $i == 0) {
                $count++;
            }
        }
        return $count;
    }

    function sumFactors($number) {
        $sum = 0;
        for ($i = 1; $i <= $number; $i++) {
            if ($number % $i == 0) {
                $sum += $i;
            }
        }
        return $sum;
    }

    function giveReadablePosition($num) {
        if($num % 10 == 1 && ($num / 10) % 10 !== 1) {
            return $num . "st";
        }
        else if($num % 10 == 2 && ($num / 10) % 10 !== 1) {
            return $num . "nd";
        }
        else if($num % 10 == 3 && ($num / 10) % 10 !== 1) {
            return $num . "rd";
        }
        
        return $num . "th";
    }

    function getTwoFirstNames() {
        $indianFirstNames = [
            "Aarav",
            "Aadi",
            "Aahana",
            "Aaliyah",
            "Aarushi",
            "Aashish",
            "Aayush",
            "Abhinav",
            "Aditi",
            "Advait",
            "Aishwarya",
            "Akshay",
            "Amit",
            "Amrita",
            "Ananya",
            "Anika",
            "Anjali",
            "Arjun",
            "Aryan",
            "Bhavya",
            "Chaitanya",
            "Dhruv",
            "Diya",
            "Eesha",
            "Gaurav",
            "Ishaan",
            "Jyoti",
            "Kabir",
            "Kavya",
            "Krishna",
            "Mira",
            "Neha",
            "Nikita",
            "Nisha",
            "Pranav",
            "Rahul",
            "Rajesh",
            "Riya",
            "Rohan",
            "Sakshi",
            "Sarika",
            "Shreya",
            "Siddharth",
            "Tanvi",
            "Uma",
            "Vikram",
            "Yash",
            "Zara",
        ];

        shuffle($indianFirstNames);

        return array($indianFirstNames[0], $indianFirstNames[1]);
    }

    function getAngleBetweenClockHands($hours, $minutes) {
        // Calculate angles for the hour and minute hands in radians
        $hourAngle = (270 + ($hours % 12) * 30 + ($minutes / 60) * 30) * (pi() / 180); // 360 degrees divided by 12 hours
        $minuteAngle = (270 + $minutes * 6) * (pi() / 180); // 360 degrees divided by 60 minutes
      
        // Calculate the angle between the hour and minute hands in radians
        $angleBetweenHands = abs($hourAngle - $minuteAngle);
      
        // Convert the angle to degrees
        $angleDegrees = $angleBetweenHands * (180 / pi());
        
        return $angleDegrees;
      }

      function numberToWords($number) {
        $words = array(
            0 => 'Zero',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
        );
        
        $tens = array(
            2 => 'Twenty',
            3 => 'Thirty',
            4 => 'Forty',
            5 => 'Fifty',
            6 => 'Sixty',
            7 => 'Seventy',
            8 => 'Eighty',
            9 => 'Ninety',
        );
        
        $suffixes = array(
            0 => '', // No suffix for the first group
            1 => 'Thousand',
            2 => 'Million',
            3 => 'Billion',
        );
    
        if ($number == 0) {
            return $words[0];
        }
    
        $chunks = array();
    
        // Split the number into 3-digit chunks
        while ($number > 0) {
            array_push($chunks, $number % 1000);
            $number = (int)($number / 1000);
        }
    
        $chunkCount = count($chunks);
        $wordsArray = array();
    
        for ($i = 0; $i < $chunkCount; $i++) {
            $chunk = $chunks[$i];
            $chunkWords = array();
    
            $hundreds = (int)($chunk / 100);
            $tensAndOnes = $chunk % 100;
    
            if ($hundreds > 0) {
                $chunkWords[] = $words[$hundreds] . ' hundred';
            }
    
            if ($tensAndOnes > 0) {
                if ($tensAndOnes < 20) {
                    $chunkWords[] = $words[$tensAndOnes];
                } else {
                    $ten = (int)($tensAndOnes / 10);
                    $ones = $tensAndOnes % 10;
                    $chunkWords[] = $ten > 0 ? $tens[$ten] : '';
                    $chunkWords[] = $ones > 0 ? $words[$ones] : '';
                }
            }
    
            if (!empty($chunkWords)) {
                $wordsArray[] = implode(' ', $chunkWords) . ' ' . $suffixes[$i];
            }
        }
    
        return implode(', ', array_reverse($wordsArray));
    }

    function numberToIndianWords(float $number)
    {
        $temp_num = $number;
        $number_after_decimal = round($number - ($num = floor($number)), 2) * 100;
    
        // Check if there is any number after the decimal
        $amt_hundred = null;
        $count_length = strlen($num);
        $x = 0;
        $string = array();
        $change_words = array(
            0 => 'Zero', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );
        $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($x < $count_length) {
            $get_divider = ($x == 2) ? 10 : 100;
            $number = floor($num % $get_divider);
            $num = floor($num / $get_divider);
            $x += $get_divider == 10 ? 1 : 2;
            if ($number) {
                $add_plural = (($counter = count($string)) && $number >= 0 && $num >= 0) ? '' : null;
    
                if ($number < 21) {
                    $string[] = $change_words[$number] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
                } else {
                    $string[] = $change_words[floor($number / 10) * 10] . ' ' . $change_words[$number % 10] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
                }
            } else {
                $string[] = null;
            }
        }
    
        $implode_to_Words = implode('', array_reverse($string));
        $check_arr = explode(' ', trim($implode_to_Words));
        $check_arr = array_filter($check_arr, function ($word) {
            return $word !== 'Zero';
        });
        
        if ($temp_num > 0 && empty($check_arr)) {
            // If the number is non-zero and the result is empty, it should be "Zero"
            return 'Zero';
        }
        
        return implode(' ', $check_arr);
    }
        
    function rearrangeDigits($number) {
        // Convert the integer to a string
        $numberStr = (string)$number;
        
        // Split the string into an array of individual digits
        $digits = str_split($numberStr);
        $count = 0;
    
        do {
            // Shuffle the digits to rearrange them (random order)
            shuffle($digits);
        
            // Reconstruct the shuffled digits as a string
            $shuffledStr = implode('', $digits);
        
            // Convert the string back to an integer
            $shuffledNumber = (int)$shuffledStr;
            $count++;
        }while($count <= 100 && $shuffledNumber == $number);
    
        return $shuffledNumber;
    }

    function findDigitPlace($number, $digit, $position = "first", $direction = "left") {
        $numberStr = strval($number);
        $digitPosition = false;
    
        if ($position === "first") {
            $digitPosition = ($direction === "left") ? strpos($numberStr, strval($digit)) : strrpos($numberStr, strval($digit));
        } elseif ($position === "last") {
            $digitPosition = ($direction === "left") ? strrpos($numberStr, strval($digit)) : strpos($numberStr, strval($digit));
        }
    
        if ($digitPosition === false) {
            return "Digit $digit not found in the number.";
        }
    
        $places = array(1, 10, 100, 1000, 10000, 100000, 1000000, 10000000, 100000000, 1000000000);
    
        $digitPosition = strlen($numberStr) - $digitPosition;
    
        return $digit * $places[$digitPosition - 1];
    }

    function getRandomDigitFromNumber($number) {
        $numberStr = strval($number);
        $strLength = strlen($numberStr);
    
        // Generate a random index within the length of the string
        $randomIndex = mt_rand(0, $strLength - 1);
    
        // Extract the digit at the random index
        $randomDigit = $numberStr[$randomIndex];
    
        return intval($randomDigit);
    }

    function numberWithoutCarry($num_1) {
        if($num_1 < 9) {
            $num_2 = mt_rand(0, 9 - $num_1);
        } else {
            $num_1_str = "$num_1";
            $num_1_arr = str_split($num_1_str);

            $num_2_0 =  rand(0, 9 - (int)($num_1_arr[1]));
            $num_2_1 = rand(0, 9 - (int)($num_1_arr[0]));

            $num_2 = (int)(($num_2_1  * 10) + $num_2_0);
        }

        return $num_2;
    }

    function numberWithoutBorrow($num_1) {
        if($num_1 < 9) {
            $num_2 = mt_rand(0, $num_1);
        } else {
            $num_1_str = "$num_1";
            $num_1_arr = str_split($num_1_str);

            $num_2_0 =  rand(0, (int)($num_1_arr[1]));
            $num_2_1 = rand(0, (int)($num_1_arr[0]));

            $num_2 = (int)(($num_2_1  * 10) + $num_2_0);
        }

        return $num_2;
    }

    function calculateFutureDate($day, $month, $year, $numDays) {
        $inputDate = new DateTime("$year-$month-$day");
        $inputDate->add(new DateInterval("P" . $numDays . "D"));
        
        $futureDate = $inputDate->format('d/m');
        $dayOfWeek = $inputDate->format('l'); // Get the day of the week
        
        return array('date' => $futureDate, 'dayOfWeek' => $dayOfWeek);
    }

    function calculateFutureDateWithoutWeekends($day, $month, $year, $numDays) {
        $inputDate = new DateTime("$year-$month-$day");
    
        while ($numDays > 0) {
            $inputDate->add(new DateInterval('P1D'));
            if ($inputDate->format('N') < 6) { // Check if it's not Saturday (6) or Sunday (7)
                $numDays--;
            }
        }
    
        $futureDate = $inputDate->format('d/m');
        $dayOfWeek = $inputDate->format('l'); // Get the day of the week
    
        return array('date' => $futureDate, 'dayOfWeek' => $dayOfWeek);
    }

    function monthNameToNumber($monthName) {
        $monthName = strtolower($monthName); // Convert to lowercase for case-insensitivity
        $months = [
            'january' => 1,
            'february' => 2,
            'march' => 3,
            'april' => 4,
            'may' => 5,
            'june' => 6,
            'july' => 7,
            'august' => 8,
            'september' => 9,
            'october' => 10,
            'november' => 11,
            'december' => 12,
        ];
    
        if (array_key_exists($monthName, $months)) {
            return $months[$monthName];
        } else {
            return false; // Return false for invalid month names
        }
    }

    function evaluateExpressionNumberRelation($numbers, $expression) {
        // Replace indexed placeholders with the actual values from the array
        foreach ($numbers as $index => $value) {
            $placeholder = "#$index";
            $expression = str_replace($placeholder, $value, $expression);
        }
    
        // Evaluate the expression and return the result
        $result = eval("return $expression;");
    
        return $result;
    }

    function swapElements(&$array, $index1, $index2) {
    $temp = $array[$index1];
    $array[$index1] = $array[$index2];
    $array[$index2] = $temp;
}

function isWeekend($day, $month, $year) {
    // Create a date string in the format "YYYY-MM-DD"
    $dateString = sprintf("%04d-%02d-%02d", $year, $month, $day);

    // Get the day of the week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
    $dayOfWeek = date('w', strtotime($dateString));

    // Check if the day of the week is Saturday (6) or Sunday (0)
    return ($dayOfWeek == 0 || $dayOfWeek == 6);
}
    
// --end dipanjan changes
  