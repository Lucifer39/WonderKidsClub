<?php
if(!empty($_SESSION['quesID'])) {

    if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '38') {                                
        //Objects Img 01
        $obj_1 = "<img src='".$baseurl.$_SESSION['obj_img_1']."' width='60' height='60'>";

        //Objects Img 02
        $obj_2 = "<img src='".$baseurl.$_SESSION['obj_img_2']."' width='60' height='60'>";

        //Objects Img 03
        $obj_3 = "<img src='".$baseurl.$_SESSION['obj_img_3']."' width='60' height='60'>"; 

        //Objects Img 04
        $obj_4 = "<img src='".$baseurl.$_SESSION['obj_img_4']."' width='60' height='60'>"; 
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
$obj_1 = "<img src='".$baseurl.$_SESSION['obj_img_1']."' width='60' height='60'>"; 

//Objects Img 02
$_SESSION['obj_img_2'] = isset($randomImages[1]) ? $randomImages[1] : ''; // Store the second image in a session variable
$obj_2 = "<img src='".$baseurl.$_SESSION['obj_img_2']."' width='60' height='60'>";

//Objects Img 03
$_SESSION['obj_img_3'] = isset($randomImages[2]) ? $randomImages[2] : ''; // Store the third image in a session variable
$obj_3 = "<img src='".$baseurl.$_SESSION['obj_img_3']."' width='60' height='60'>"; 

//Objects Img 04
$_SESSION['obj_img_4'] = isset($randomImages[3]) ? $randomImages[3] : ''; // Store the fourth image in a session variable
$obj_4 = "<img src='".$baseurl.$_SESSION['obj_img_4']."' width='60' height='60'>"; 
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

     } elseif($sbtpcrow['id'] == '36' 
            || $sbtpcrow['id'] == '37'
            || $sbtpcrow['id'] == '202' 
            || $sbtpcrow['id'] == '203' 
            || $sbtpcrow['id'] == '204' 
            || $sbtpcrow['id'] == '205' 
            || $sbtpcrow['id'] == '206') { 
        $bftaft = rand(1,2);
        $image_folder = 'uploads/money/'.$bftaft.'/';
        $image_extensions = array('jpg', 'jpeg', 'png', 'gif');

        $opts = array($querow['opt_a'],$querow['opt_b'],$querow['opt_c'],$querow['opt_d']);

       $i = 1;
        foreach ($opts as $opt) {   
        if($sbtpcrow['id'] == '36') {                              
            $numbers = array(1, 2, 5, 10);
        } elseif($sbtpcrow['id'] == '37'
        || $sbtpcrow['id'] == '202' 
        || $sbtpcrow['id'] == '203' 
        || $sbtpcrow['id'] == '204' 
        || $sbtpcrow['id'] == '205' 
        || $sbtpcrow['id'] == '206') { 
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
if($sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38' && $querow['type'] == '0' 
    || $sbtpcrow['id'] == '38' && $querow['type'] == '1' || $sbtpcrow['id'] == '43' || $sbtpcrow['id'] == '45' 
    || $sbtpcrow['id'] == '49' || $sbtpcrow['id'] == '50' || $sbtpcrow['id'] == '51' || $sbtpcrow['id'] == '52' 
    || $sbtpcrow['id'] == '53' || $sbtpcrow['id'] == '54' || $sbtpcrow['id'] == '55' || $sbtpcrow['id'] == '56' 
    || $sbtpcrow['id'] == '90' 
    || in_array($sbtpcrow['id'], array('101', '102', '103', '135', '136', '137', '127', '128', '129', '130'))
    || $sbtpcrow['id'] == '202' 
    || $sbtpcrow['id'] == '203' 
    || $sbtpcrow['id'] == '204' 
    || $sbtpcrow['id'] == '205' 
    || $sbtpcrow['id'] == '206') { 
    $quesCls = " horizontal-options ";
} 

if ($sbtpcrow['id'] == '7' && $querow['type'] == '2' || $sbtpcrow['id'] == '7' && $querow['type'] == '3' || $sbtpcrow['id'] == '12' && $querow['type'] == '2' || $sbtpcrow['id'] == '12' && $querow['type'] == '3' || $sbtpcrow['id'] == '52' || $sbtpcrow['id'] == '53' || $sbtpcrow['id'] == '54' || $sbtpcrow['id'] == '55' || $sbtpcrow['id'] == '56') { 
    $optCls = " font-md ";
}

//Option Result Class
if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38'
|| $sbtpcrow['id'] == '202' 
|| $sbtpcrow['id'] == '203' 
|| $sbtpcrow['id'] == '204' 
|| $sbtpcrow['id'] == '205' 
|| $sbtpcrow['id'] == '206'
|| in_array($sbtpcrow['id'], array('214', '215', '216'))) {
    if($resulrow['correct'] == $querow['opt_a']) { $optA = " br-green ";} elseif($resulrow['wrong'] == $querow['opt_a']) { $optA = " br-red ";} elseif($querow['correct_ans'] == $querow['opt_a']) { $optA = " br-green ";}   
} else {
    if($resulrow['correct'] == $querow['opt_a']) { $optA = " right-ans";} elseif($resulrow['wrong'] == $querow['opt_a']) { $optA = " wrong-ans";} elseif($querow['correct_ans'] == $querow['opt_a']) { $optA = " right-ans";} 

}

if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38'
|| $sbtpcrow['id'] == '202' 
|| $sbtpcrow['id'] == '203' 
|| $sbtpcrow['id'] == '204' 
|| $sbtpcrow['id'] == '205' 
|| $sbtpcrow['id'] == '206'
|| in_array($sbtpcrow['id'], array('214', '215', '216'))) {
    if($resulrow['correct'] == $querow['opt_b']) { $optB = " br-green ";} elseif($resulrow['wrong'] == $querow['opt_b']) { $optB = " br-red ";} elseif($querow['correct_ans'] == $querow['opt_b']) { $optB = " br-green ";}   
} else {
    if($resulrow['correct'] == $querow['opt_b']) { $optB = " right-ans";} elseif($resulrow['wrong'] == $querow['opt_b']) { $optB = " wrong-ans";} elseif($querow['correct_ans'] == $querow['opt_b']) { $optB = " right-ans";} 

}

if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38'
|| $sbtpcrow['id'] == '202' 
|| $sbtpcrow['id'] == '203' 
|| $sbtpcrow['id'] == '204' 
|| $sbtpcrow['id'] == '205' 
|| $sbtpcrow['id'] == '206'
|| in_array($sbtpcrow['id'], array('214', '215', '216'))) {
    if($resulrow['correct'] == $querow['opt_c']) { $optC = " br-green ";} elseif($resulrow['wrong'] == $querow['opt_c']) { $optC = " br-red ";} elseif($querow['correct_ans'] == $querow['opt_c']) { $optC = " br-green ";}   
} else {
    if($resulrow['correct'] == $querow['opt_c']) { $optC = " right-ans";} elseif($resulrow['wrong'] == $querow['opt_c']) { $optC = " wrong-ans";} elseif($querow['correct_ans'] == $querow['opt_c']) { $optC = " right-ans";} 

}

if($sbtpcrow['id'] == '13' || $sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '18' || $sbtpcrow['id'] == '19' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '21' || $sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27' || $sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37' || $sbtpcrow['id'] == '38'
|| $sbtpcrow['id'] == '202' 
|| $sbtpcrow['id'] == '203' 
|| $sbtpcrow['id'] == '204' 
|| $sbtpcrow['id'] == '205' 
|| $sbtpcrow['id'] == '206'
|| in_array($sbtpcrow['id'], array('214', '215', '216'))) {
    if($resulrow['correct'] == $querow['opt_d']) { $optD = " br-green ";} elseif($resulrow['wrong'] == $querow['opt_d']) { $optD = " br-red ";} elseif($querow['correct_ans'] == $querow['opt_d']) { $optD = " br-green ";}   
} else {
    if($resulrow['correct'] == $querow['opt_d']) { $optD = " right-ans";} elseif($resulrow['wrong'] == $querow['opt_d']) { $optD = " wrong-ans";} elseif($querow['correct_ans'] == $querow['opt_d']) { $optD = " right-ans";} 

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
|| $sbtpcrow['id'] == '192' 
|| $sbtpcrow['id'] == '193'
|| $sbtpcrow['id'] == '194' 
|| $sbtpcrow['id'] == '195'
|| $sbtpcrow['id'] == '196'
|| $sbtpcrow['id'] == '197' 
|| $sbtpcrow['id'] == '198' 
|| $sbtpcrow['id'] == '199' 
|| $sbtpcrow['id'] == '200' 
|| $sbtpcrow['id'] == '201') {
    $optCls = " font-md ";
}

if ($sbtpcrow['id'] == '13' && $querow['type'] == '0' || $sbtpcrow['id'] == '13' && $querow['type'] == '1' || $sbtpcrow['id'] == '13' ) {
    $optCls = " ht-200 br-grey img-grid ";
}

if ($sbtpcrow['id'] == '7' && $querow['type'] == '2' || $sbtpcrow['id'] == '7' && $querow['type'] == '3' || $sbtpcrow['id'] == '12' && $querow['type'] == '2' || $sbtpcrow['id'] == '12' && $querow['type'] == '3') { 
    $quesCls = " font-md ";
}

if($sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '20' || $sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '19' || in_array($sbtpcrow['id'], array('214', '215', '216'))) {
    $Wt200 = " mw-250 ";
}

if(in_array($sbtpcrow['id'], array('135', '136', '137', '138', '139', '140', '141', '142', '144', '145', '146', '147', '149', '150'))){
    
    $width = 350;
    if(in_array($sbtpcrow["id"] , array('138', '139', '141', '144', '146', '140', '142', '145', '147'))){
        $width = 100;
    }
    
    ?>
        <style>
            .container-dip{
                width:100%
            }
        </style>

        <script>

            function drawFraction(x, y, fraction, ctx) {
                if(fraction.split("_").length == 1)
                fraction = "_" + fraction;
                
                const whole_parts = fraction.split('_');
                const parts = whole_parts[1].split('/');
                console.log(whole_parts, parts);
                let whole = 0;
                let numerator = 0;
                let denominator = 1;

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

                const fractions = fractionsInput.split(',');

                let x = 50;
                const y = canvas_abs.height / 2;

                for (let i = 0; i < fractions.length; i++) {
                    drawFraction(x, y, fractions[i], ctx);
                    const parts = fractions[i].split('/');
                    const fractionLength = parts.length === 2 ? 1 : 2;
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
?>