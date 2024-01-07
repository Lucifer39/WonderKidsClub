<div class="content br-1 text-center p-4 mb-4">
        <div class="grid-container">
            <?php
            // Assuming $querow["shape_info"] contains the necessary data
            $shape_info = json_decode($querow["shape_info"]);
            // var_dump($shape_info);
            $number1 = (string) "" . $shape_info->num_1;
            $number2 = (string) "" . $shape_info->num_2;
            $number3 = (string) "" . $shape_info->pqr;
            $sum = (string) (intval($number1) + intval($number2));

            $maxLength = max(strlen($number1), strlen($number2), strlen($sum));
            $paddedNum1 = str_pad($number1, $maxLength, " ", STR_PAD_LEFT);
            $paddedNum2 = str_pad($number2, $maxLength, " ", STR_PAD_LEFT);
            $num3_array = str_split($number3);

            // Define a mapping of characters
            $map_digits = [
                'P' => $num3_array[0],
                'Q' => $num3_array[1],
                'R' => $num3_array[2],
            ];

            // Split numbers into digits
            $digits1 = str_split(str_replace($num3_array[0], 'P' ,$paddedNum1));
            $digits2 = str_split(str_replace($num3_array[1], 'Q', $paddedNum2));
            $sumDigits = str_split(str_pad(str_replace($num3_array[2], 'R', $sum), $maxLength, "0", STR_PAD_LEFT));

            // Create a 3x10 grid
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 10; $j++) {
                    echo '<div class="grid-item ';

                    if ($i === 0) {
                        if ($j === 0) {
                            echo ' empty-cell'; // Add a class for the empty box before the first number
                        }
                    } elseif ($i === 1) {
                        echo ' grid-border';
                    }

                    echo '">';

                    if ($i === 0) {
                        echo ($j !== 0 && $j <= count($digits1)) ? $digits1[$j - 1] : '';
                    } elseif ($i === 1) {
                        echo ($j === 0) ? '+' : (($j < 1 + count($digits2)) ? $digits2[$j - 1] : '');
                    } else {
                        echo ($j !== 0 && $j < 1 + count($sumDigits)) ? $sumDigits[$j - 1] : '';
                    }

                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>