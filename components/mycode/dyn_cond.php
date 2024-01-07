<?php
if(!empty($_SESSION['quesID'])) {

    if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '38') {                                
        //Objects Img 01
        $obj_1 = "<img class='m-1' src='".$baseurl.$_SESSION['obj_img_1']."' width='40' height='40'>";

        //Objects Img 02
        $obj_2 = "<img class='m-1' src='".$baseurl.$_SESSION['obj_img_2']."' width='40' height='40'>";

        //Objects Img 03
        $obj_3 = "<img class='m-1' src='".$baseurl.$_SESSION['obj_img_3']."' width='40' height='40'>"; 

        //Objects Img 04
        $obj_4 = "<img class='m-1' src='".$baseurl.$_SESSION['obj_img_4']."' width='40' height='40'>"; 
        } elseif($sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27') { 
        }

} else {    
if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '38') { 

    $directory = "uploads/count/"; // Replace with the path to your image directory
    $images = glob($directory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE); // Get all the JPG files in the directory
    
    $randomImages = array();
$imageCount = count($images);

if ($imageCount >= 4) {
    $randomKeys = array_rand($images, 4); // Get 4 random keys from the array of images
    foreach ($randomKeys as $key) {
        $randomImages[] = $images[$key]; // Add the randomly selected image to the list of random images
    }
}

//Objects Img 01
$_SESSION['obj_img_1'] = isset($randomImages[0]) ? $randomImages[0] : ''; // Store the first image in a session variable
$obj_1 = "<img class='m-1' src='".$baseurl.$_SESSION['obj_img_1']."' width='40' height='40'>"; 

//Objects Img 02
$_SESSION['obj_img_2'] = isset($randomImages[1]) ? $randomImages[1] : ''; // Store the second image in a session variable
$obj_2 = "<img class='m-1' src='".$baseurl.$_SESSION['obj_img_2']."' width='40' height='40'>";

//Objects Img 03
$_SESSION['obj_img_3'] = isset($randomImages[2]) ? $randomImages[2] : ''; // Store the third image in a session variable
$obj_3 = "<img class='m-1' src='".$baseurl.$_SESSION['obj_img_3']."' width='40' height='40'>"; 

//Objects Img 04
$_SESSION['obj_img_4'] = isset($randomImages[3]) ? $randomImages[3] : ''; // Store the fourth image in a session variable
$obj_4 = "<img class='m-1' src='".$baseurl.$_SESSION['obj_img_4']."' width='40' height='40'>"; 
} elseif($sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '18') {

    //Long and Short
    $directory = "uploads/longest/"; // Replace with the path to your image directory
    $images = glob($directory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE); // Get all the JPG files in the directory
    
    $randomImages = array();
    
    while (count($randomImages) < 4) {
        $randomImage = $images[rand(0, count($images) - 1)]; // Pick a random image from the array of images
    
        if (!in_array($randomImage, $randomImages)) {
            $randomImages[] = $randomImage; // Add the image to the list of random images if it hasn't already been added
        }
    }

    //Long and Short Img 01
   $_SESSION['long_short_1'] =  $randomImages[0];

} elseif($sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '19') {

    //tall and Short
    $directory = "uploads/tallest/"; // Replace with the path to your image directory
    $images = glob($directory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE); // Get all the JPG files in the directory
    
    $randomImages = array();
    
    while (count($randomImages) < 4) {
        $randomImage = $images[rand(0, count($images) - 1)]; // Pick a random image from the array of images
    
        if (!in_array($randomImage, $randomImages)) {
            $randomImages[] = $randomImage; // Add the image to the list of random images if it hasn't already been added
        }
    }

    //Long and Short Img 01
   $_SESSION['tall_short_1'] =  $randomImages[0];

} elseif($sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '20') {

    //wide and narrow
    $directory = "uploads/tallest/"; // Replace with the path to your image directory
    $images = glob($directory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE); // Get all the JPG files in the directory
    
    $randomImages = array();
    
    while (count($randomImages) < 4) {
        $randomImage = $images[rand(0, count($images) - 1)]; // Pick a random image from the array of images
    
        if (!in_array($randomImage, $randomImages)) {
            $randomImages[] = $randomImage; // Add the image to the list of random images if it hasn't already been added
        }
    }

    //Long and Short Img 01
   $_SESSION['wide_narrow_1'] =  $randomImages[0];

} elseif($sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '21') {
    //Light and Heavy Img 01
    $directory_1 = "uploads/weight/".$querow['opt_a']."/";
    $images_1 = glob($directory_1 . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    
    $randomImages_1 = array();
    
    while (count($randomImages_1) < 1) {
        $randomImage_1 = $images_1[rand(0, count($images_1) - 1)];
    
        if (!in_array($randomImage_1, $randomImages_1)) {
            $randomImages_1[] = $randomImage_1;
        }
    }

    
   $_SESSION['light_heavy_1'] =  $randomImages_1[0];

   //Light and Heavy Img 02
   $directory_2 = "uploads/weight/".$querow['opt_b']."/";
   $images_2 = glob($directory_2 . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    
    $randomImages_2 = array();
    
    while (count($randomImages_2) < 1) {
        $randomImage_2 = $images_2[rand(0, count($images_2) - 1)];
    
        if (!in_array($randomImage_2, $randomImages_2)) {
            $randomImages_2[] = $randomImage_2;
        }
    }

   
  $_SESSION['light_heavy_2'] =  $randomImages_2[0];

  //Light and Heavy Img 03
  $directory_3 = "uploads/weight/".$querow['opt_c']."/";
   $images_3 = glob($directory_3 . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    
    $randomImages_3 = array();
    
    while (count($randomImages_3) < 1) {
        $randomImage_3 = $images_3[rand(0, count($images_3) - 1)];
    
        if (!in_array($randomImage_3, $randomImages_3)) {
            $randomImages_3[] = $randomImage_3;
        }
    }

  
 $_SESSION['light_heavy_3'] =  $randomImages_3[0];

 //Light and Heavy Img 04
 $directory_4 = "uploads/weight/".$querow['opt_d']."/";
 $images_4 = glob($directory_4 . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    
    $randomImages_4 = array();
    
    while (count($randomImages_4) < 1) {
        $randomImage_4 = $images_4[rand(0, count($images_4) - 1)];
    
        if (!in_array($randomImage_4, $randomImages_4)) {
            $randomImages_4[] = $randomImage_4;
        }
    }

 
$_SESSION['light_heavy_4'] =  $randomImages_4[0];
   
   
} elseif($sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27') { 
    $dir1 = "uploads/shapes/".$querow['opt_a']."";
    $dir2 = "uploads/shapes/".$querow['opt_b']."";
    $dir3 = "uploads/shapes/".$querow['opt_c']."";
    $dir4 = "uploads/shapes/".$querow['opt_d']."";

      $_SESSION['shape_1'] = getRandomImage($dir1);
      $_SESSION['shape_2'] = getRandomImage($dir2);
      $_SESSION['shape_3'] = getRandomImage($dir3);
      $_SESSION['shape_4'] = getRandomImage($dir4);
} elseif($sbtpcrow['id'] == '25' || $sbtpcrow['id'] == '29') { 


    $num = array(1,2,3,4);
    $opts = array($querow['opt_a'],$querow['opt_b'],$querow['opt_c'],$querow['opt_d']);

    
    for ($i = 0; $i < 4; $i++) {
        if($querow['correct_ans'] == $opts[$i]) {
                $dir1 = "uploads/shapes/".$querow['type']."";                                            
                $_SESSION['color_shape_'.$num[$i].''] = getRandomImage($dir1);
        } else {
                $number = range(1,4);
                $exclude = range($querow['type'],$querow['type']);                                            
               
                $othopt = $number[array_rand(array_diff($number,$exclude))];                                             
               
                $dir1 = "uploads/shapes/".$othopt."";
               
                $_SESSION['color_shape_'.$num[$i].''] = getRandomImage($dir1);
        }
    }
} elseif($sbtpcrow['id'] == '26' || $sbtpcrow['id'] == '30') { 

    
    $num = array(1,2,3,4);
    $opts = array($querow['opt_a'],$querow['opt_b'],$querow['opt_c'],$querow['opt_d']);

    for ($i = 0; $i < 4; $i++) {
        if($querow['correct_ans'] == $opts[$i]) {

            if ($querow['type1'] == 1) {
                $clr = "pink";
              } elseif ($querow['type1'] == 2) {
                $clr = "orange";
              } elseif ($querow['type1'] == 3) {
                $clr = "green";
              } elseif ($querow['type1'] == 4) {
                $clr = "yellow";
              } elseif ($querow['type1'] == 5) {
                $clr = "blue";
              } 

                $dir1 = "uploads/shapes/".$querow['type']."/".$clr.".png";                                            
                $_SESSION['color_shape_'.$num[$i].''] = $dir1;
        } else {
                $number = range(1,5);
                $exclude = range($querow['type1'],$querow['type1']);                                            
               
                $othopt = $number[array_rand(array_diff($number,$exclude))]; 
                
                if ($othopt == 1) {
                    $clr = "pink";
                  } elseif ($othopt == 2) {
                    $clr = "orange";
                  } elseif ($othopt == 3) {
                    $clr = "green";
                  } elseif ($othopt == 4) {
                    $clr = "yellow";
                  } elseif ($othopt == 5) {
                    $clr = "blue";
                  } 
               
                $dir1 = "uploads/shapes/".$querow['type']."/".$clr.".png"; 
               
                $_SESSION['color_shape_'.$num[$i].''] = $dir1;
        }
    }  

     } elseif($sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37') { 
        $bftaft = rand(1,2);
        $image_folder = 'uploads/money/'.$bftaft.'/';
        $image_extensions = array('jpg', 'jpeg', 'png', 'gif');

        $opts = array($querow['opt_a'],$querow['opt_b'],$querow['opt_c'],$querow['opt_d']);

       $i = 1;
        foreach ($opts as $opt) {   
        if($sbtpcrow['id'] == '36') {                              
            $numbers = array(1, 2, 5, 10);
        } elseif($sbtpcrow['id'] == '37') { 
            $numbers = array(0.5, 1, 2, 5, 10, 20);
        } 
        $combination = array();
        $total = 0;
        while ($total < $opt) {
            $rand_key = array_rand($numbers);
            $rand_num = $numbers[$rand_key];
            if ($total + $rand_num <= $opt) {
                $combination[] = $rand_num;
                $total += $rand_num;
            }
        }

        $combinations = $combination;
        
        $images = array(); 

        foreach ($combinations as $combi) {
        foreach ($image_extensions as $extension) {
            $filename = $combi . '.' . $extension;
            if (file_exists($image_folder . $filename)) {
                $multi_img = $image_folder.$filename;
                array_push($images, $multi_img);
                break;
            }
            }
        }

       $_SESSION['shape_'.$i.''] = $images;
        $i++;
     }                               
    }
}
// Question Class
if($sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38' && $querow['type'] == '0' || $sbtpcrow['id'] == '38' && $querow['type'] == '1' || $sbtpcrow['id'] == '43' || $sbtpcrow['id'] == '45' || $sbtpcrow['id'] == '49' || $sbtpcrow['id'] == '50' || $sbtpcrow['id'] == '51' || $sbtpcrow['id'] == '52' || $sbtpcrow['id'] == '53' || $sbtpcrow['id'] == '54' || $sbtpcrow['id'] == '55' || $sbtpcrow['id'] == '56') { 
    $quesCls = " horizontal-options ";
} 

if ($sbtpcrow['id'] == '7' && $querow['type'] == '2' || $sbtpcrow['id'] == '7' && $querow['type'] == '3' || $sbtpcrow['id'] == '12' && $querow['type'] == '2' || $sbtpcrow['id'] == '12' && $querow['type'] == '3' || $sbtpcrow['id'] == '52' || $sbtpcrow['id'] == '53' || $sbtpcrow['id'] == '54' || $sbtpcrow['id'] == '55' || $sbtpcrow['id'] == '56') { 
    $optCls = " font-md ";
}

if($querow['type2'] != 'p1' && $querow['type2'] != 'q1') {
//Option Result Class
if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38') {
    if($resulrow['correct'] == $querow['opt_a']) { $optA = " br-green ";} elseif($resulrow['wrong'] == $querow['opt_a']) { $optA = " br-red ";} elseif($querow['correct_ans'] == $querow['opt_a']) { $optA = " br-green ";}   
} else {
    if($resulrow['correct'] == $querow['opt_a']) { $optA = " right-ans";} elseif($resulrow['wrong'] == $querow['opt_a']) { $optA = " wrong-ans";} elseif($querow['correct_ans'] == $querow['opt_a']) { $optA = " right-ans";} 
}

if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38') {
    if($resulrow['correct'] == $querow['opt_b']) { $optA = " br-green ";} elseif($resulrow['wrong'] == $querow['opt_b']) { $optB = " br-red ";} elseif($querow['correct_ans'] == $querow['opt_b']) { $optB = " br-green ";}   
} else {
    if($resulrow['correct'] == $querow['opt_b']) { $optB = " right-ans";} elseif($resulrow['wrong'] == $querow['opt_b']) { $optB = " wrong-ans";} elseif($querow['correct_ans'] == $querow['opt_b']) { $optB = " right-ans";} 

}

if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38') {
    if($resulrow['correct'] == $querow['opt_c']) { $optC = " br-green ";} elseif($resulrow['wrong'] == $querow['opt_c']) { $optC = " br-red ";} elseif($querow['correct_ans'] == $querow['opt_c']) { $optC = " br-green ";}   
} else {
    if($resulrow['correct'] == $querow['opt_c']) { $optC = " right-ans";} elseif($resulrow['wrong'] == $querow['opt_c']) { $optC = " wrong-ans";} elseif($querow['correct_ans'] == $querow['opt_c']) { $optC = " right-ans";} 

}

if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38') {
    if($resulrow['correct'] == $querow['opt_d']) { $optD = " br-green ";} elseif($resulrow['wrong'] == $querow['opt_d']) { $optD = " br-red ";} elseif($querow['correct_ans'] == $querow['opt_d']) { $optD = " br-green ";}   
} else {
    if($resulrow['correct'] == $querow['opt_d']) { $optD = " right-ans";} elseif($resulrow['wrong'] == $querow['opt_d']) { $optD = " wrong-ans";} elseif($querow['correct_ans'] == $querow['opt_d']) { $optD = " right-ans";} 

}

} else {
    if($optstyle_rslt['style_id'] == 3 || $optstyle_rslt['style_id'] == 4) {
    if($querow['correct_ans'] == 1) { $optA = " br-green ";} elseif($querow['correct_ans'] == 2) { $optB = " br-green ";} elseif($querow['correct_ans'] == 3) { $optC = " br-green ";} elseif($querow['correct_ans'] == 4) { $optD = " br-green ";}
    } else {
    if($querow['correct_ans'] == 1) { $optA = " right-ans ";} elseif($querow['correct_ans'] == 2) { $optB = " right-ans ";} elseif($querow['correct_ans'] == 3) { $optC = " right-ans ";} elseif($querow['correct_ans'] == 4) { $optD = " right-ans ";}
} }

//Option Class
if($sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38') { 
    $optCls = " ht-200 br-grey ";
}
if($sbtpcrow['id'] == '22' || $sbtpcrow['id'] == '31' || $sbtpcrow['id'] == '33' || $sbtpcrow['id'] == '34' || $sbtpcrow['id'] == '35' || $sbtpcrow['id'] == '43' || $sbtpcrow['id'] == '45' || $sbtpcrow['id'] == '49' || $sbtpcrow['id'] == '50' || $sbtpcrow['id'] == '51') {
    $optCls = " font-md ";
}

if ($sbtpcrow['id'] == '13' && $querow['type'] == '0' || $sbtpcrow['id'] == '13' && $querow['type'] == '1' || $sbtpcrow['id'] == '13' ) {
    $optCls = "  ht-200 br-grey img-grid ";
} //ht-200

if ($sbtpcrow['id'] == '7' && $querow['type'] == '2' || $sbtpcrow['id'] == '7' && $querow['type'] == '3' || $sbtpcrow['id'] == '12' && $querow['type'] == '2' || $sbtpcrow['id'] == '12' && $querow['type'] == '3') { 
    $quesCls = " font-md ";
}

if($sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '19') {
    $Wt200 = " mw-250 ";
}
?>