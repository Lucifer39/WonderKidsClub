
<?php
if($querow['type2'] != 'p1' && $querow['type2'] != 'q1') {
    if($page == 'checkques.php' || $flagimgchk) {
        $imgchk = '../';
    } else {
        $imgchk = '';
    }
if(!empty($_SESSION['quesID'])) {

    if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '38') {                                
        //Objects Img 01
        $obj_1 = "<img class='img-fluid' src='".$baseurl.$_SESSION['obj_img_1']."' width='60' height='60'>";

        //Objects Img 02
        $obj_2 = "<img class='img-fluid' src='".$baseurl.$_SESSION['obj_img_2']."' width='60' height='60'>";

        //Objects Img 03
        $obj_3 = "<img class='img-fluid' src='".$baseurl.$_SESSION['obj_img_3']."' width='60' height='60'>"; 

        //Objects Img 04
        $obj_4 = "<img class='img-fluid' src='".$baseurl.$_SESSION['obj_img_4']."' width='60' height='60'>"; 
        } elseif($sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27') { 
        }

} else {    
if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '38') { 

    $directory = "".$imgchk."uploads/count/"; // Replace with the path to your image directory
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
$obj_1 = "<img class='img-fluid' src='".$baseurl.$_SESSION['obj_img_1']."' width='60' height='60'>"; 

//Objects Img 02
$_SESSION['obj_img_2'] = isset($randomImages[1]) ? $randomImages[1] : ''; // Store the second image in a session variable
$obj_2 = "<img class='img-fluid' src='".$baseurl.$_SESSION['obj_img_2']."' width='60' height='60'>";

//Objects Img 03
$_SESSION['obj_img_3'] = isset($randomImages[2]) ? $randomImages[2] : ''; // Store the third image in a session variable
$obj_3 = "<img class='img-fluid' src='".$baseurl.$_SESSION['obj_img_3']."' width='60' height='60'>"; 

//Objects Img 04
$_SESSION['obj_img_4'] = isset($randomImages[3]) ? $randomImages[3] : ''; // Store the fourth image in a session variable
$obj_4 = "<img class='img-fluid' src='".$baseurl.$_SESSION['obj_img_4']."' width='60' height='60'>"; 
} elseif($sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '18') {

    //Long and Short
    $directory = "".$imgchk."uploads/longest/"; // Replace with the path to your image directory
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
    $directory = "".$imgchk."uploads/tallest/"; // Replace with the path to your image directory
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
    $directory = "".$imgchk."uploads/widest/"; // Replace with the path to your image directory
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
    $directory_1 = "".$imgchk."uploads/weight/".$querow['opt_a']."/";
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
   $directory_2 = "".$imgchk."uploads/weight/".$querow['opt_b']."/";
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
  $directory_3 = "".$imgchk."uploads/weight/".$querow['opt_c']."/";
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
 $directory_4 = "".$imgchk."uploads/weight/".$querow['opt_d']."/";
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
    $dir1 = "".$imgchk."uploads/shapes/".$querow['opt_a']."";
    $dir2 = "".$imgchk."uploads/shapes/".$querow['opt_b']."";
    $dir3 = "".$imgchk."uploads/shapes/".$querow['opt_c']."";
    $dir4 = "".$imgchk."uploads/shapes/".$querow['opt_d']."";

      $_SESSION['shape_1'] = getRandomImage($dir1);
      $_SESSION['shape_2'] = getRandomImage($dir2);
      $_SESSION['shape_3'] = getRandomImage($dir3);
      $_SESSION['shape_4'] = getRandomImage($dir4);
} elseif($sbtpcrow['id'] == '25' || $sbtpcrow['id'] == '29') { 


    $num = array(1,2,3,4);
    $opts = array($querow['opt_a'],$querow['opt_b'],$querow['opt_c'],$querow['opt_d']);

    
    for ($i = 0; $i < 4; $i++) {
        if($querow['correct_ans'] == $opts[$i]) {
                $dir1 = "".$imgchk."uploads/shapes/".$querow['type']."";                                            
                $_SESSION['color_shape_'.$num[$i].''] = getRandomImage($dir1);
        } else {
                $number = range(1,4);
                $exclude = range($querow['type'],$querow['type']);                                            
               
                $othopt = $number[array_rand(array_diff($number,$exclude))];                                             
               
                $dir1 = "".$imgchk."uploads/shapes/".$othopt."";
               
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

                $dir1 = "".$imgchk."uploads/shapes/".$querow['type']."/".$clr.".png";                                            
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
               
                $dir1 = "".$imgchk."uploads/shapes/".$querow['type']."/".$clr.".png"; 
               
                $_SESSION['color_shape_'.$num[$i].''] = $dir1;
        }
    }  

     } elseif(in_array($sbtpcrow['id'], ['36', '37', '202', '203', '204', '205', '206'])) { 
        $bftaft = rand(1,2);
        //$image_folder = 'uploads/money/'.$bftaft.'/';
        //$image_extensions = array('jpg', 'jpeg', 'png', 'gif');
		if($sbtpcrow['id'] == '36') {
            $numbers = array(1, 2, 5, 10, 20);
        } else {
            $numbers = array(0.5 ,1, 2, 5, 10, 20);
        } 

        $opts = array($querow['opt_a'],$querow['opt_b'],$querow['opt_c'],$querow['opt_d']);

       $i = 1;
        foreach ($opts as $opt) { 
        
        if($sbtpcrow['id'] == '36') {
            $numbers = array(1, 2, 5, 10, 20);
        } else {
            $numbers = array(0.5 ,1, 2, 5, 10, 20);
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
        
        if($combi == '0.5') {
           $price_folder = '1';
        } elseif($combi == '20') {
           $price_folder = '2';
        } else {
           $price_folder = $bftaft; 
        }
                                        
        $image_folder = ''.$imgchk.'uploads/money/'.$price_folder.'/';
        $image_extensions = array('jpg', 'jpeg', 'png', 'gif');
        
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
if($sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38' && $querow['type'] == '0' 
    || $sbtpcrow['id'] == '38' && $querow['type'] == '1' || $sbtpcrow['id'] == '43' || $sbtpcrow['id'] == '45' 
    || $sbtpcrow['id'] == '49' || $sbtpcrow['id'] == '50' || $sbtpcrow['id'] == '51' || $sbtpcrow['id'] == '52' 
    || $sbtpcrow['id'] == '53' || $sbtpcrow['id'] == '54' || $sbtpcrow['id'] == '55' || $sbtpcrow['id'] == '56' 
    || $sbtpcrow['id'] == '90' 
    || in_array($sbtpcrow['id'], array('101', '102', '135', '136', '137', '127', '128', '129', '130', '186', '187', '189', '190', '191'))
    || $sbtpcrow['id'] == '202' 
    || $sbtpcrow['id'] == '203' 
    || $sbtpcrow['id'] == '204' 
    || $sbtpcrow['id'] == '205' 
    || $sbtpcrow['id'] == '206'
    || $sbtpcrow['id'] == '243'
    || $sbtpcrow['id'] == '248'
    || $sbtpcrow['id'] == '249'
    || $sbtpcrow['id'] == '244'
    || $sbtpcrow['id'] == '245'
    || $sbtpcrow['id'] == '246'
    || $sbtpcrow['id'] == '253'
    || $sbtpcrow['id'] == '254') { 
    $quesCls = " horizontal-options ";
} 

if ($sbtpcrow['id'] == '7' && $querow['type'] == '2' || $sbtpcrow['id'] == '7' && $querow['type'] == '3' || $sbtpcrow['id'] == '12' && $querow['type'] == '2' || $sbtpcrow['id'] == '12' && $querow['type'] == '3' || $sbtpcrow['id'] == '52' || $sbtpcrow['id'] == '53' || $sbtpcrow['id'] == '54' || $sbtpcrow['id'] == '55' || $sbtpcrow['id'] == '56') { 
    $optCls = " font-md ";
}

//Option Result Class
$crt = trim($resulrow['correct']);
$wrg = trim($resulrow['wrong']);
$crt_ans = trim($querow['correct_ans']);
$opa = trim($querow['opt_a']);
$opb = trim($querow['opt_b']);
$opc = trim($querow['opt_c']);
$opd = trim($querow['opt_d']);

if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38'
|| $sbtpcrow['id'] == '202' 
|| $sbtpcrow['id'] == '203' 
|| $sbtpcrow['id'] == '204' 
|| $sbtpcrow['id'] == '205' 
|| $sbtpcrow['id'] == '206'
|| in_array($sbtpcrow['id'], array('214', '215', '216'))) {
    if($crt == $opa) { $optA = " br-green ";} elseif($wrg == $opa) { $optA = " br-red ";} elseif($crt_ans == $opa) { $optA = " br-green ";}   
} else {
    if($crt == $opa) { $optA = " right-ans";} elseif($wrg == $opa) { $optA = " wrong-ans";} elseif($crt_ans == $opa) { $optA = " right-ans";} 

}

if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38'
|| $sbtpcrow['id'] == '202' 
|| $sbtpcrow['id'] == '203' 
|| $sbtpcrow['id'] == '204' 
|| $sbtpcrow['id'] == '205' 
|| $sbtpcrow['id'] == '206'
|| in_array($sbtpcrow['id'], array('214', '215', '216'))) {
    if($crt == $opb) { $optB = " br-green ";} elseif($wrg == $opb) { $optB = " br-red ";} elseif($crt_ans == $opb) { $optB = " br-green ";}   
} else {
    if($crt == $opb) { $optB = " right-ans";} elseif($wrg == $opb) { $optB = " wrong-ans";} elseif($crt_ans == $opb) { $optB = " right-ans";} 

}

if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38'
|| $sbtpcrow['id'] == '202' 
|| $sbtpcrow['id'] == '203' 
|| $sbtpcrow['id'] == '204' 
|| $sbtpcrow['id'] == '205' 
|| $sbtpcrow['id'] == '206'
|| in_array($sbtpcrow['id'], array('214', '215', '216'))) {
    if($crt == $opc) { $optC = " br-green ";} elseif($wrg == $opc) { $optC = " br-red ";} elseif($crt_ans == $opc) { $optC = " br-green ";}   
} else {
    if($crt == $opc) { $optC = " right-ans";} elseif($wrg == $opc) { $optC = " wrong-ans";} elseif($crt_ans == $opc) { $optC = " right-ans";} 

}

if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38'
|| $sbtpcrow['id'] == '202' 
|| $sbtpcrow['id'] == '203' 
|| $sbtpcrow['id'] == '204' 
|| $sbtpcrow['id'] == '205' 
|| $sbtpcrow['id'] == '206'
|| in_array($sbtpcrow['id'], array('214', '215', '216'))) {
    if($crt == $opd) { $optD = " br-green ";} elseif($wrg == $opd) { $optD = " br-red ";} elseif($crt_ans == $opd) { $optD = " br-green ";}   
} else {
    if($crt == $opd) { $optD = " right-ans";} elseif($wrg == $opd) { $optD = " wrong-ans";} elseif($crt_ans == $opd) { $optD = " right-ans";} 

}

/*if($sbtpcrow['id'] == '43' || $sbtpcrow['id'] == '45' || $sbtpcrow['id'] == '49' || $sbtpcrow['id'] == '50' || $sbtpcrow['id'] == '51') {
    $crt = str_replace(' ', '', $resulrow['correct']);
    $wrg = str_replace(' + ', '', trim($resulrow['wrong']));
    $crt_ans = str_replace(' ', '', $querow['correct_ans']);
    $opa = str_replace(' + ', '', $querow['opt_a']);
    $opb = str_replace(' + ', '', $querow['opt_b']);
    $opc = str_replace(' + ', '', trim($querow['opt_c']));
    $opd = str_replace(' + ', '', $querow['opt_d']);

    echo $wrg = $wrg;
    echo '<br>';
    echo $opc = $opc;
    if($wrg == $opa) {
        echo "A";
    } 
    if($wrg == $opb) {
        echo "A";
    } 
    if($wrg == $opc) {
        echo "A";
    } 
    if($wrg == $opd) {
        echo "A";
    }
    

    if($crt == $opa) { $optA = " right-ans ";} elseif($wrg == $opa) { $optA = " wrong-ans ";} elseif($crt_ans == $opa) { $optA = " right-ans ";}
    if($crt == $opb) { $optB = " right-ans ";} elseif($wrg == $opb) { $optB = " wrong-ans ";} elseif($crt_ans == $opb) { $optB = " right-ans ";}
    if($crt == $opc) { $optC = " right-ans ";} elseif($wrg == $opc) { $optC = " wrong-ans ";} elseif($crt_ans == $opc) { $optC = " right-ans ";}
    if($crt == $opd) { $optD = " right-ans ";} elseif($wrg == $opd) { $optD = " wrong-ans ";} elseif($crt_ans == $opd) { $optD = " right-ans ";}
} */
 
if(in_array($sbtpcrow['id'], ['14', '15', '16', '17', '18', '19', '20', '21', '24','27'])) {
    $quesCls = ' img-opt ';
}

if(in_array($sbtpcrow['id'], ['153'])) {
    $quesCls = ' horizontal-options-fixed ';
}

if(in_array($sbtpcrow['id'], ['34', '35', '197', '198', '199', '200', '201','66', '67', '68', '69','83', '84', '86', '87','88','98', '99', '100','101', '102', '103','106','107', '112', '113', '114', '115', '116', '117','196','175', '173', '176', '177', '178','181', '182', '183', '184','62','63','64','65'])) {
    $quesCls = ' canvas-ques-auto-height ';
}

if(in_array($sbtpcrow['id'], ['140','142','145','147','150'])) {
    $quesCls = ' canvas-ques ';
}

//Option Class
if($sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38'
|| $sbtpcrow['id'] == '202' 
|| $sbtpcrow['id'] == '203' 
|| $sbtpcrow['id'] == '204' 
|| $sbtpcrow['id'] == '205' 
|| $sbtpcrow['id'] == '206'
|| in_array($sbtpcrow['id'], array('214', '215', '216'))) { 
    $optCls = " ht-200 br-grey ";
}
if($sbtpcrow['id'] == '22' 
|| $sbtpcrow['id'] == '31' 
|| $sbtpcrow['id'] == '33' 
|| $sbtpcrow['id'] == '34' 
|| $sbtpcrow['id'] == '35' 
|| $sbtpcrow['id'] == '43' 
|| $sbtpcrow['id'] == '45' 
|| $sbtpcrow['id'] == '49' 
|| $sbtpcrow['id'] == '50' 
|| $sbtpcrow['id'] == '51'
|| $sbtpcrow['id'] == '90'
|| $sbtpcrow['id'] == '192' 
|| $sbtpcrow['id'] == '193'
|| $sbtpcrow['id'] == '194' 
|| $sbtpcrow['id'] == '195'
|| $sbtpcrow['id'] == '196'
|| $sbtpcrow['id'] == '197' 
|| $sbtpcrow['id'] == '198' 
|| $sbtpcrow['id'] == '199' 
|| $sbtpcrow['id'] == '200' 
|| $sbtpcrow['id'] == '201'
|| $sbtpcrow['id'] == '243'
|| $sbtpcrow['id'] == '248'
|| $sbtpcrow['id'] == '249'
|| $sbtpcrow['id'] == '244'
|| $sbtpcrow['id'] == '245'
|| $sbtpcrow['id'] == '246'
|| $sbtpcrow['id'] == '253'
|| $sbtpcrow['id'] == '254'
|| in_array($sbtpcrow['id'], array('187', '189', '190', '191'))) {
    $optCls = " font-md ";
}

if (($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '38') && ($querow['type'] == '1' || $querow['type'] == '0')) {
    $quesCls = "img-grid-options img-opt";
} elseif (($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '38') && ($querow['type'] == '2' || $querow['type'] == '3')) {
    $quesCls = "img-grid-options img-opt img-opt-ht-fixed";
} elseif ($sbtpcrow['id'] == '216' || $sbtpcrow['id'] == '215' || $sbtpcrow['id'] == '214') {
    // $quesCls = " img-grid-options img-opt img-opt-ht-fixed img-ht-14 mir-img ";
}

if ($sbtpcrow['id'] == '13' && $querow['type'] == '0' || $sbtpcrow['id'] == '13' && $querow['type'] == '1' || $sbtpcrow['id'] == '13' ) {
    $optCls = " ht-200 br-grey img-grid ";
}

if ($sbtpcrow['id'] == '7' && $querow['type'] == '2' || $sbtpcrow['id'] == '7' && $querow['type'] == '3' || $sbtpcrow['id'] == '12' && $querow['type'] == '2' || $sbtpcrow['id'] == '12' && $querow['type'] == '3') { 
    $quesCls = " font-md font-size-options ";
}

if($sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '19' || in_array($sbtpcrow['id'], array('214', '215', '216'))) {
    $Wt200 = " mw-250 ";
}

if(in_array($sbtpcrow['id'], array('135', '136', '137', '138', '139', '140', '141', '142', '144', '145', '146', '147', '149', '150', '186', '187', '189', '190', '191','83', '84', '86'))){
    
    $width = 350;
    if(in_array($sbtpcrow["id"] , array('138', '139', '141', '144', '146', '140', '142', '145', '147', '149', '150','83', '84', '86'))){
        $width = 100;
    }
    
    ?>
        <style>
            .container-dip{
                width:100%;
            }
        </style>

        <script>

            function drawFraction(x, y, fraction, ctx) {
                if(fraction.split("_").length == 1)
                fraction = "_" + fraction;
                
                var whole_parts = fraction.split('_');
                var parts = whole_parts[1].split('/');
                console.log(whole_parts, parts);
                var whole = 0;
                var numerator = 0;
                var denominator = 1;

                if (whole_parts[0] === "") {
                    numerator = parseInt(parts[0]);
                    denominator = parseInt(parts[1]);
                } else if (whole_parts[0] !== "") {
                    whole = parseInt(whole_parts[0]);
                    numerator = parseInt(parts[0]);
                    denominator = parseInt(parts[1]);
                } else {
                    return; // Invalid fraction format
                }

                ctx.font = '20px Arial';
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';

                if (whole !== 0) {
                    x-=40;
                    ctx.fillText(whole, x, y);
                    x += 40;
                    y -= 10;
                }

                ctx.fillText(numerator, x, y);

                if(denominator) {
                    ctx.beginPath();
                    ctx.moveTo(x - 20, y + 7);
                    ctx.lineTo(x + 20, y + 7);
                    ctx.lineWidth = 2;
                    ctx.stroke();
                    ctx.fillText(denominator, x, y + 28);
                }
            }

            function drawFractions(canvas_abs, ctx, fractionsInput) {
                ctx.clearRect(0, 0, canvas_abs.width, canvas_abs.height);

                var fractions = fractionsInput.split(',');

                var x = 50;
                var y = canvas_abs.height / 2;

                for (var i = 0; i < fractions.length; i++) {
                    drawFraction(x, y, fractions[i], ctx);
                    var parts = fractions[i].split('/');
                    var fractionLength = parts.length === 2 ? 1 : 2;
                    x += 50 * fractionLength;

                    if (i !== fractions.length - 1) {
                        ctx.fillText(' ,', x - 30, y + 10);
                    }
                }
            }


        </script>
    <?php
}

else if(in_array($sbtpcrow['id'], array('214', '215', '216'))) {
    $shape_info = json_decode($querow["shape_info"]);

    ?>
    
    <style>
        .image-mirror-question {
            width: 100px;
            height: 100px;
        }

        .horizontal-flip {
        transform: scaleX(-1);
        }

        .vertical-flip {
        transform: scaleY(-1);
        }

        .rotate-45 {
        transform: rotate(45deg);
        }

        .rotate-180 {
        transform: rotate(180deg);
        }

        .combine-transforms {
        transform: scaleX(-1) rotate(30deg);
        }

        .rotate-30 {
        transform: rotate(30deg);
        }

        .rotate-60 {
        transform: rotate(60deg);
        }

        .rotate-90 {
        transform: rotate(90deg);
        }

        .rotate-120 {
        transform: rotate(120deg);
        }

        .rotate-150 {
        transform: rotate(150deg);
        }

        .rotate-210 {
        transform: rotate(210deg);
        }

        .rotate-240 {
        transform: rotate(240deg);
        }

        .rotate-270 {
        transform: rotate(270deg);
        }

        /* .rotate-30-flip {
        transform: rotate(30deg) scaleX(-1);
        } */

        .rotate-45-flip {
        transform: rotate(45deg) scaleY(-1);
        }

        .rotate-60-flip {
        transform: rotate(60deg) scaleX(-1);
        }

        .rotate-120-flip {
        transform: rotate(120deg) scaleY(-1);
        }

    </style>
    


    <?php
}
} else {
    $optstyle_qury = mysqli_query($conn, "SELECT style_id FROM opt_style WHERE quest_id=".$querow['id']."");
$optstyle_rslt = mysqli_fetch_array($optstyle_qury);

if($optstyle_rslt['style_id'] == 1) {
    $stloptCls = ' font-md ';
} elseif($optstyle_rslt['style_id'] == 2) {
    $stlCls = ' horizontal-options ';
    $stloptCls = ' font-md ';
} elseif($optstyle_rslt['style_id'] == 3) {
    $stlCls = ' horizontal-options ';
    $stloptCls = ' ht-200 br-grey img-grid';
} elseif($optstyle_rslt['style_id'] == 4) {
    $stloptCls = ' ht-200 br-grey ';
}
}
?>