<?php
 if($querow['type2'] != 'p1' && $querow['type2'] != 'q1') {
//more and fewer objects
$baseurl1 = $page !== '' ? $baseurl : "";
if($sbtpcrow['id'] == '263') {
    $sbtpcrow['id'] = $querow['shape_info'];
}
if($sbtpcrow['id'] == '13' && $querow['type'] == '0' || $sbtpcrow['id'] == '13' && $querow['type'] == '1' || $sbtpcrow['id'] == '38' && $querow['type'] == '0' || $sbtpcrow['id'] == '38' && $querow['type'] == '1') { 
    $obj1 = [];
    for($i=0; $i<$querow['opt_a'];$i++){
        $obj1[]= $obj_1;
    } 
echo implode('', $obj1);

//more and fewer shape/objects - given group 
} elseif($sbtpcrow['id'] == '13' && $querow['type'] == '2' || $sbtpcrow['id'] == '13' && $querow['type'] == '3' || $sbtpcrow['id'] == '38' && $querow['type'] == '2' || $sbtpcrow['id'] == '38' && $querow['type'] == '3') { 
    echo $obj1[0];

//Long and Short
} elseif($sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '18' ) { $rndLS = mt_rand(21, 25); $plus = $querow['opt_a']*$rndLS;
    echo "<img class='max-img-width' src='".$baseurl1.$_SESSION['long_short_1']."' style='width:".$plus."px; object-fit: fill'>";
//Tall and Short
} elseif($sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '19' ) { $rndLS = mt_rand(21,25); $plus = $querow['opt_a']*$rndLS;
    echo "<img src='".$baseurl1.$_SESSION['tall_short_1']."' style='width:auto;object-fit: contain;height:".$plus."px'>";
} elseif($sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '20' ) { $plus = $querow['opt_a']*20;
    echo "<img class='max-img-width' src='".$baseurl1.$_SESSION['wide_narrow_1']."' style='height:100px;width:".$plus."px;object-fit: fill;'>";
} elseif($sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '21' ) {
    echo "<img class='max-img-size' src='".$baseurl1.$_SESSION['light_heavy_1']."' style='height:150px;object-fit:contain'>";
} elseif($sbtpcrow['id'] == '22') {
    echo numberToWord($querow['opt_a']);
} elseif($sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27') {
    echo "<img class='max-img-size' src='".$baseurl1.$_SESSION['shape_1']."' style='height:150px;max-width:150px;object-fit:contain'>";
} elseif($sbtpcrow['id'] == '31' 
        || $sbtpcrow['id'] == '33' 
        || $sbtpcrow['id'] == '34' 
        || $sbtpcrow['id'] == '35'
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
    
    $value = $querow['opt_a'];
    $allowedValues = ['1', '2', '5', '10', '20','50','100','200','500'];
    if (in_array($value, $allowedValues)) {
        echo 'Rs '.$value;
    } elseif($value == '0.5') {
        $value = $value*100; 
        echo $value.' paisa';
    }
} elseif($sbtpcrow['id'] == '36' 
        || $sbtpcrow['id'] == '37'
        || $sbtpcrow['id'] == '202' 
        || $sbtpcrow['id'] == '203' 
        || $sbtpcrow['id'] == '204' 
        || $sbtpcrow['id'] == '205' 
        || $sbtpcrow['id'] == '206') {
    foreach ($_SESSION['shape_1'] as $filename) {
        echo '<img src="'.$baseurl.$filename.'" height="90" alt="Image" />';
    }
} else if(in_array($sbtpcrow['id'], array('135', '136', '137', '138', '139', '140', '141', '142', '144', '145', '146', '147', '149', '150','83', '84', '86'))){
    $randomString = generateIDString();
    ?>

        <div class="container-dip">
            <canvas id="fractionCanvas-<?php echo $randomString; ?>" width="<?php echo $width; ?>" height="60"></canvas>
        </div>

        <script>
            var canvas = document.getElementById('fractionCanvas-<?php echo $randomString; ?>');
            var ctx = canvas.getContext('2d');
            var fractionsInput = <?php echo json_encode($querow['opt_a']) ?>;


            drawFractions(canvas, ctx, fractionsInput);

        </script>
    <?php
}
else if(in_array($sbtpcrow['id'], array('214', '215', '216'))) {
    $option_class = $querow["opt_a"];
    $shape_info = json_decode($querow["shape_info"]);
    

    ?>
    
    <img src="<?php echo $baseurl1; ?>/uploads/mirror_image/<?php echo $shape_info->image ?>"
        class="<?php echo $option_class ?> image-mirror-question">
    
    <?php
}
else {
    echo $querow['opt_a'];
} } else {
    echo $querow['opt_a'];
}
?>