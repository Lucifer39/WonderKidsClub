<?php 
    if(in_array($sbtpName, array('101', '102', '103'))){

        $choose_img = mt_rand(1, 3);
        $directionsAndDestinations;

        if($choose_img == 1){
            $directionsAndDestinations = [
                ["direction" => "North", "destination" => "Restaurant"],
                ["direction" => "Northeast", "destination" => "Pond"],
                ["direction" => "East", "destination" => "Mountains"],
                ["direction" => "Southeast", "destination" => "Park"],
                ["direction" => "South", "destination" => "Temple"],
                ["direction" => "Southwest", "destination" => "School"],
                ["direction" => "West", "destination" => "Post-office"],
                ["direction" => "Northwest", "destination" => "Book store"],
            ];
        }
        else if($choose_img == 2){
            $directionsAndDestinations = [
                ["direction" => "North", "destination" => "Beach"],
                ["direction" => "Northeast", "destination" => "Lake"],
                ["direction" => "East", "destination" => "Amusement Park"],
                ["direction" => "Southeast", "destination" => "Zoo"],
                ["direction" => "South", "destination" => "Garden"],
                ["direction" => "Southwest", "destination" => "Waterfall"],
                ["direction" => "West", "destination" => "Shopping Mall"],
                ["direction" => "Northwest", "destination" => "Movie Theater"],
            ];
        }
        else if($choose_img == 3){
            $directionsAndDestinations = [
                ["direction" => "North", "destination" => "Museum"],
                ["direction" => "Northeast", "destination" => "Historical Site"],
                ["direction" => "East", "destination" => "Library"],
                ["direction" => "Southeast", "destination" => "Water Park"],
                ["direction" => "South", "destination" => "Concert Hall"],
                ["direction" => "Southwest", "destination" => "Art Gallery"],
                ["direction" => "West", "destination" => "Botanical Garden"],
                ["direction" => "Northwest", "destination" => "Science Center"],
            ];
        }
        
        $indianNames = [
            "Aarav", "Aarya", "Aditi", "Advait", "Akash", "Amaya", "Anika", "Aaradhya",
            "Amit", "Aarush", "Bhavya", "Chaitanya", "Dhruv", "Diya", "Esha", "Eeshaan",
            "Firoz", "Fatima", "Gauri", "Ganesh", "Hritika", "Hari", "Ishaan", "Ishani",
            "Jai", "Jyoti", "Kabir", "Kavya", "Krish", "Kiran", "Lakshmi", "Lalita", "Mira",
            "Manoj", "Neha", "Nakul", "Nisha", "Om", "Omkar", "Prisha", "Pranav", "Pari",
            "Qamar", "Qasim", "Riya", "Rahul", "Rohan", "Sia", "Samar", "Shreya", "Shiv",
            "Sneha", "Tanvi", "Tarun", "Uma", "Utkarsh", "Vidya", "Vikram", "Vandana",
            "Vishal", "Wahid", "Wafa", "Yash", "Yamini", "Zara", "Zubin",
        ];
        
        $directions = [
            "North", "Northeast", "East", "Southeast", "South", "Southwest", "West", "Northwest",
        ];

        $turnsArray;

        if($sbtpName == '101'){
            $turnsArray = ["1/4", "1/2", "3/4"];
        }
        else {
            $turnsArray = ["1/8", "1/4", "3/8", "1/2", "5/8", "3/4", "7/8"];
        }


        $turnsDirection = ["clockwise", "anticlockwise", "left", "right"];

        $random_name = getRandomElement($indianNames);
        $initial_direction = getRandomElement($directionsAndDestinations);
        $final_direction = getRandomElement($directionsAndDestinations);

        $question = "$random_name is facing towards " . $initial_direction['destination'] . ".";
        $maxTurns = rand(1, 3);
        $current_direction = $initial_direction['direction'];

        for ($j = 1; $j <= $maxTurns; $j++) {
            $turn_fraction = getRandomElement($turnsArray);
            $turn_direction = getRandomElement($turnsDirection);

            $question .= " They then make a turn $turn_fraction to their $turn_direction direction.";
            $current_direction = getFinalDirection($current_direction, $turn_direction, $turn_fraction);
        }

        $question .= " Now if they want to face towards the " . $final_direction['destination'] . ", then what turn will he make from the given options?";
        $inverseTurn = getInverseTurn($current_direction, $final_direction['direction']);
        $inverseTurnString = $inverseTurn['turnsFraction'] . " " . $inverseTurn['turnDirection'];
        $optionsData = generateRandomOptionsDirection($inverseTurnString);

        if($optionsData !== 0) {
            $options = $optionsData['options'];
            $correctIndex = $optionsData['correctIndex'];

            $resp_question = checkQuestion($question);

            $shape_info = array(
                array("type" => "directions"),
                array("img" => "$choose_img.png")
            );

            $shape_info_json = json_encode($shape_info);

            if($resp_question == 0){
                setQuestionsShape($sessionrow['id'], $clsName, $subjName, $tpName, $sbtpName, $question, $options[0], $options[1], $options[2], $options[3], $correctIndex, $shape_info_json);
            }
        }
    }
?>