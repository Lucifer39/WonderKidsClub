<?php 
    if(in_array($sbtpName, array('186', '187', '189', '190', '191'))) {
        $question_obj = array(
            array(
                "type" => "class_1_money_needed",
                 "str" => "You want to buy a %%x%% which costs ₹ %%y%%. You have ₹ %%z%%. How much more money do you need to buy it?"
            ),
            array(
                "type"=> "class_1_money_returned",
                "str" => "You want to buy a %%x%% which costs ₹ %%y%%. You have ₹ %%z%%. How much money would the shopkeeper return as change?"
            ),
            array(
                "type" => "class_2_simple_add",
                "str" => "There are items on the shelf which are: %%x%%. If you spend ₹ %%y%% to buy 2 of those items. Which items did you buy?"
            ),
            array(
                "type" => "shopping_list",
                "str" => "You have a budget of ₹ %%x%%. You bought %%y%%. How much money would be left or needed after the purchase?"
            )
        );

        $kidsItems = array(
            "Toy Car",
            "Board Game",
            "Coloring Book",
            "Building Blocks",
            "Stuffed Animal",
            "Puzzle",
            "Bicycle",
            "Doll",
            "Remote Control Helicopter",
            "Art Supplies",
            "Action Figure",
            "Play-Doh Set",
            "Scooter",
            "Crayons",
            "Science Kit",
            "Jump Rope",
            "LEGO Set",
            "Teddy Bear",
            "Kite",
            "Watercolor Paint Set"
        );

        if($sbtpName == '186') {
            $question_ind = mt_rand(0, 1);
        }
        else if($sbtpName == '187') {
            $question_ind = mt_rand(0 , 2);
        }
        else {
            $question_ind = array_rand($question_obj);
        }

        $set_question = $question_obj[$question_ind];

        $question;
        $answer;
        $count = 0;
        $options = array();

        if($set_question["type"] == "class_1_money_needed") {
            $item_ind = array_rand($kidsItems);
            $item = $kidsItems[$item_ind];

            $price = mt_rand(2, 9) * 5;
            $budget = mt_rand(1, ($price / 5) - 1) * 5;

            $answer = "₹ " . ($price - $budget);

            $question = str_replace("%%x%%", $item, $set_question["str"]);
            $question = str_replace("%%y%%", $price, $question);
            $question = str_replace("%%z%%", $budget, $question);

            array_push($options, $answer);
            $count = 0;
            while($count <= 100 && count($options) < 4) {
                $incorrect = "₹ " . (mt_rand(1, 9) * 5);

                if(!in_array($incorrect, $options)) {
                    array_push($options, $incorrect);
                    $count = 0;
                }

                $count++;
            }
        }

        else if($set_question['type'] == "class_1_money_returned") {
            $item_ind = array_rand($kidsItems);
            $item = $kidsItems[$item_ind];

            $price = mt_rand(6, 9) * 5;

            if($price >= 50) {
                $budget = 100;
            } else {
                $budget = mt_rand(0, 1) == 1 ? 50 : 100;
            }

            $answer = "₹ " . ($budget - $price);

            $question = str_replace("%%x%%", $item, $set_question["str"]);
            $question = str_replace("%%y%%", $price, $question);
            $question = str_replace("%%z%%", $budget, $question);

            array_push($options, $answer);
            $count = 0;
            while($count <= 100 && count($options) < 4) {
                $incorrect = "₹ " . (mt_rand(1, 9) * 5);

                if(!in_array($incorrect, $options)) {
                    array_push($options, $incorrect);
                    $count = 0;
                }

                $count++;
            }
        }

        else if($set_question["type"] == "class_2_simple_add") {
            $requiredSum = mt_rand(2, 5) * 10; // Change this to your desired sum
            $numberOfItems = 5;
            $randomItems = array();
            
            // Shuffle the items array for randomness
            shuffle($kidsItems);
            
            $selectedIndices = array_rand($kidsItems, 2); // Select two random indices for items that add up to the sum
            $selectedItems = array($kidsItems[$selectedIndices[0]], $kidsItems[$selectedIndices[1]]);
            
            // Generate prices for selected items that add up to the sum
            $totalPriceWithSum = 0;
            foreach ($selectedItems as $item) {
                $price = rand(5, intval($requiredSum / 2));

                if($totalPriceWithSum !== 0) {
                    $price = $requiredSum - $totalPriceWithSum;
                }

                $randomItems[] = array(
                    "item" => $item,
                    "price" => $price
                );
                $totalPriceWithSum += $price;
            }
            
            // Generate prices for the rest of the items
            $remainingItems = array_diff_assoc($kidsItems, $selectedItems);
            // var_dump($remainingItems);
            for ($k = count($randomItems); $k < $numberOfItems; $k++) {
                $item = $remainingItems[$k - count($selectedItems) + 1];
                $price = rand(5, 50);

                $randomItems[] = array(
                    "item" => $item,
                    "price" => $price
                );
            }

            // var_dump($randomItems);
            
            shuffle($randomItems);

            $answer = $selectedItems[0] . " and " . $selectedItems[1];
            
            $str_arr = array();
            foreach($randomItems as $item) {
                $str_arr[] = " ". $item["item"] . " for ₹ " . $item["price"]; 
            }

            $str = implode(", ", $str_arr);

            $question = str_replace("%%x%%", $str, $set_question["str"]);
            $question = str_replace("%%y%%", $requiredSum, $question);

            array_push($options, $answer);
            $count = 0;

          
            while($count <= 100 && count($options) < 4) {
                $incorrect_temp_1 = $randomItems[array_rand($randomItems)];
                $incorrect_temp_2 = $randomItems[array_rand($randomItems)];
                $incorrect_1 = $incorrect_temp_1["item"];
                $incorrect_2 = $incorrect_temp_2['item'];
                $incorrect = $incorrect_1 . " and " . $incorrect_2;
                $incorrect_inv = $incorrect_2 . " and " . $incorrect_1;

                $inc_price = $incorrect_temp_1['price'] + $incorrect_temp_2['price'];

                if($incorrect_1 !== $incorrect_2 && !in_array($incorrect, $options) && !in_array($incorrect_inv, $options) && $inc_price !== $totalPriceWithSum) {
                    array_push($options, $incorrect);
                    $count = 0;
                }

                $count++;
            }

            // var_dump($options);
        }

        else if($set_question["type"] == "shopping_list") { 
            $budget = mt_rand(5, 15) * 5;
            $numberOfItems = mt_rand(1, 5);

            shuffle($kidsItems);

            $selectedIndices = array_rand($kidsItems, $numberOfItems);
            $selectedItems = array();
            $str = "";
            $sum = 0;
            for($k = 0; $k < $numberOfItems; $k++){
                $price = mt_rand(1, 5) * 5;
                $selectedIndex = $selectedIndices[$k];
                if($numberOfItems == 1) {
                    $selectedIndex = $selectedIndices;
                }
                $str .= " ". $kidsItems[$selectedIndex] . " for ₹ " . $price;
                $sum += $price; 
            }

            $answer = "₹ " . (abs($sum - $budget));
            array_push($options, $answer);
            $count = 0;

            $question = str_replace("%%x%%", $budget, $set_question["str"]);
            $question = str_replace("%%y%%", $str, $question);

            while($count <= 100 && count($options) < 4) {
                $incorrect = "₹ " . (mt_rand(5, 9) * 10);

                if(!in_array($incorrect, $options)) {
                    array_push($options, $incorrect);
                    $count = 0;
                }

                $count++;
            }
        }

        shuffle($options);
            // var_dump($question);
            // var_dump($options);
            // var_dump($answer);

            // echo "hello";

        if($count <= 100) {
            setQuestions($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $answer);
        }
    }
?>