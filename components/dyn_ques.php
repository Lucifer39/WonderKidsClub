
<?php
if($ques == 'practice.php' || $ques == 'fastest.php' || $ques == 'quiz.php') {
    $hmx220 = 'h-mx-220';
    $hmx300 = 'h-mx-300';
} else {
    $hmx220 = '';
    $hmx300 = '';
}
if($querow['type2'] != 'p1' && $querow['type2'] != 'q1') {
    if($page == 'checkques.php' || $flagimgchk) {
        $imgchk = '../';
    } else {
        $imgchk = '';
    }
if($sbtpcrow['id'] == '13' && $querow['type'] == '2' || $sbtpcrow['id'] == '13' && $querow['type'] == '3' || $sbtpcrow['id'] == '38' && $querow['type'] == '2' || $sbtpcrow['id'] == '38' && $querow['type'] == '3') {  ?>
                            <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2">
                                    <div class="aft-heading">
                                <?php 
                                //Objects Img 01
                                $obj1 = [];
                                $obj2 = [];
                                $obj3 = [];
                                $obj4 = [];

                                for($i=0; $i<$querow['opt_a'];$i++) { $obj1[]= $obj_1; }

                                //Objects Img 02
                                for($i=0; $i<$querow['opt_b'];$i++) { $obj2[]= $obj_2; }

                                //Objects Img 03
                                for($i=0; $i<$querow['opt_c'];$i++) { $obj3[]= $obj_3; }

                                //Objects Img 04
                                for($i=0; $i<$querow['opt_d'];$i++) { $obj4[]= $obj_4; }
                                
                                $mergedArray = array_merge($obj1, $obj2, $obj3, $obj4);
                                shuffle($mergedArray);

                                foreach ($mergedArray as $element) { echo $element; }
                                ?>
                            </div>
                            </div>
                            <?php } elseif($sbtpcrow['id'] == '25' || $sbtpcrow['id'] == '26' || $sbtpcrow['id'] == '29' || $sbtpcrow['id'] == '30') { ?>
                                <div class="content aft-heading-wrapper br-1 text-center p-md-4 p-0 mb-mb-4 mb-2">
                                    <div class="aft-heading">
                                <?php 
                                $obj1 = [];
                                $baseurl1 = $page !== '' ? $baseurl : "";
                                //Objects Img 01
                                for($i=0; $i<$querow['opt_a'];$i++) { 
                                    $obj1[]= "<img src='".$baseurl1.$_SESSION['color_shape_1']."' style='height:80px;max-width:80px;object-fit:contain'>";
                                }

                                $obj2 = [];
                                //Objects Img 02
                                for($i=0; $i<$querow['opt_b'];$i++) { 
                                    $obj2[]= "<img src='".$baseurl1.$_SESSION['color_shape_2']."' style='height:80px;max-width:80px;object-fit:contain'>";
                                }

                                $obj3 = [];
                                //Objects Img 03
                                for($i=0; $i<$querow['opt_c'];$i++) { 
                                    $obj3[]= "<img src='".$baseurl1.$_SESSION['color_shape_3']."' style='height:80px;max-width:80px;object-fit:contain'>";
                                }

                                $obj4 = [];
                                //Objects Img 04
                                for($i=0; $i<$querow['opt_d'];$i++) { 
                                    $obj4[]= "<img src='".$baseurl1.$_SESSION['color_shape_4']."' style='height:80px;max-width:80px;object-fit:contain'>";
                                }
                                
                                
                                $mergedArray = array_merge($obj1, $obj2, $obj3, $obj4);
                                shuffle($mergedArray);


                                foreach ($mergedArray as $element) { echo $element; }
                                ?>
                            </div>
                            </div>
                            <?php } elseif(in_array($sbtpcrow['id'], ['31', '33', '192', '193', '194', '195', '196'])) { ?>
                                <div class="content aft-heading-wrapper br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 justify-content-center">
                                <?php 
                                $image_name = $querow['correct_ans'];
                                $allowedValues = ['20', '50','100','200','500'];
                                if($image_name == '0.5') {
                                	$price_folder = '1';
                                } elseif (in_array($image_name, $allowedValues)) {
                                	$price_folder = '2';
                                } else {
                                	$price_folder = $querow['type'];
                                }                                                                                                                        
                                                                                                                        
                                $image_folder = ''.$pgLand.'uploads/money/'.$price_folder.'/'; 
                                $image_extensions = array('jpg', 'jpeg', 'png', 'gif');                                                                                        

                                foreach ($image_extensions as $extension) {
                                $filename = $image_name . '.' . $extension;
                                if (file_exists($imgchk.$image_folder . $filename)) {
                                    // Do something with the image file, e.g. display it:
                                    echo '<img class="mob-ig-ht" src="'.$baseurl.$image_folder.$filename.'" height="130" alt="Image" />';
                                    break; // exit loop if image is found
                                }
                                } ?>
                                </div> 
                                <?php } elseif(in_array($sbtpcrow['id'], ['34', '35', '197', '198', '199', '200', '201'])) { ?>
                                <div class="content aft-heading-wrapper coins-wrapper br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 justify-content-center aft-heading-auto-height">
                                    <?php 
                                    $bftaft = rand(1,2);
                                    $image_name = $querow['correct_ans'];
                                    if($sbtpcrow['id'] == '34') {
                                        $numbers = array(1, 2, 5, 10, 20);
                                    } else {
                                        $numbers = array(0.5 ,1, 2, 5, 10, 20);
                                    }                                 
                                    
                                    $combination = array();
                                    $total = 0;
                                    while ($total < $image_name) {
                                        $rand_key = array_rand($numbers);
                                        $rand_num = $numbers[$rand_key];
                                        if ($total + $rand_num <= $image_name) {
                                            $combination[] = $rand_num;
                                            $total += $rand_num;
                                        }
                                    }

                                    $combinations = $combination;
                                    foreach ($combinations as $combi) {

                                        if($combi == '0.5') {
                                            $price_folder = '1';
                                        } elseif($combi == '20') {
                                            $price_folder = '2';
                                        } else {
                                            $price_folder = $bftaft; 
                                        }
                                        
                                        $image_folder = ''.$pgLand.'uploads/money/'.$price_folder.'/';
                                        $image_extensions = array('jpg', 'jpeg', 'png', 'gif');

                                    foreach ($image_extensions as $extension) {
                                        $filename = $combi . '.' . $extension;
                                        if (file_exists($imgchk.$image_folder . $filename)) {
                                            $baseurl1 = $page !== '' ? $baseurl : "";
                                            echo '<img src="'.$baseurl1.$image_folder.$filename.'" height="130" alt="Image" />';
                                            break;
                                        }
                                        }
                                    }

                                    ?>
                                </div>                                
                            <?php }


                            //dipanjan changes
                            else if($sbtpcrow['id'] == '62' || $sbtpcrow['id'] == '63' || $sbtpcrow['id'] == '64' || $sbtpcrow['id'] == '65' || $sbtpcrow['id'] == '252') {
                                $randomString = generateIDString();
                                ?>
                                <style>
                                        .abacus-container-dip{
                                            display: flex;
                                            flex-direction: column;
                                            justify-content: center;
                                            align-items: center;
                                            page-break-inside:avoid;
                                            /* height: 100vh; */
                                        }
                                      .abacus {
                                        display: flex;
                                        justify-content: center;
                                        align-items: flex-end; /* Updated alignment to bottom */
                                        height: 200px;
                                        border-bottom: 5px solid black;
                                        width: 300px;
                                        padding: 0rem 0 0.55rem 0;
                                        margin-bottom: 2rem;
                                    }

                                    .rod {
                                        display: flex;
                                        flex-direction: column-reverse; /* Reversed the order of beads */
                                        align-items: center;
                                        margin: 0 20px;
                                        height: 105%;
                                        transform: translateY(10px);
                                        background-color: black;
                                        width: 2px;
                                    }

                                    .beads {
                                        width: 17px;
                                        height: 17px;
                                        border-radius: 50%;
                                        background-color: red;
                                        margin: 1px;
                                        transform: translateY(80%); /* Initially slide beads down */
                                        transition: transform 0.3s ease; /* Added transition for smooth sliding */
                                        display: none;
                                    }

                                    .active {
                                        transform: translateY(0%); /* Slide beads up when active */
                                        background-color: red !important;
                                        /* display: block; */
                                    }

                                    .place-values {
                                        display: flex;
                                        justify-content: space-evenly;
                                        width: 300px;
                                        margin-top: -15px;
                                    }
                                </style>

                                <div class="abacus-container-dip content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 aft-heading-auto-height">
                                    <div class="abacus" id="abacus-<?php echo $randomString; ?>"></div>
                                    <div class="place-values" id="place-values-<?php echo $randomString; ?>"></div>
                                </div>

                                    <script>
                                        var abacusContainer = document.getElementById('abacus-<?php echo $randomString; ?>');
                                        var beadsPerRod = 9;
                                        var numberOfRods = 7;

                                        generateAbacus();
                                        generatePlaceValues();

                                        function generatePlaceValues() {
                                                var placeValuesContainer = document.querySelector('#place-values-<?php echo $randomString; ?>');

                                                var placeValueLabels = ['TL', 'L', 'TTh', 'Th', 'H', 'T', 'O'];

                                                for (var i = 0; i < numberOfRods; i++) {
                                                var placeValue = document.createElement('div');
                                                placeValue.className = 'place-value';
                                                placeValue.textContent = placeValueLabels[i];
                                                placeValuesContainer.appendChild(placeValue);
                                            }
                                        }

                                        function generateAbacus() {
                                        for (var i = 0; i < numberOfRods; i++) {
                                            var rod = document.createElement('div');
                                            rod.className = 'rod';
                                            rod.id = `rod-${i}-<?php echo $randomString; ?>`;

                                            for (var j = 0; j < beadsPerRod; j++) {
                                            var bead = document.createElement('div');
                                            bead.className = 'beads';
                                            rod.appendChild(bead);
                                            }

                                            abacusContainer.appendChild(rod);
                                        }
                                        }

                                        var beads = document.querySelectorAll('.beads');
                                        var numberInput = document.getElementById('abacus-input');
                                        // numberInput.type = 'number';
                                        // numberInput.id = 'numberInput';
                                        updateAbacus(<?php echo json_encode($querow['correct_ans']) ?>);
                                        // abacusContainer.prepend(numberInput);

                                        function updateAbacus(numberInput) {
                                            resetAbacus();
                                            var number = parseInt(numberInput);
                                            if (!isNaN(number)) {
                                                moveBeads(number);
                                            }
                                        }

                                        function resetAbacus() {
                                            beads.forEach(bead => {
                                                bead.classList.remove('active');
                                            });
                                        }

                                        function moveBeads(number) {
                                            var ones = number % 10;
                                            var tens = Math.floor((number / 10) % 10);
                                            var hundreds = Math.floor((number / 100) % 10);
                                            var thousands = Math.floor((number / 1000) % 10);
                                            var tenThousands = Math.floor((number / 10000) % 10);
                                            var hundredThousands = Math.floor((number / 100000) % 10);
                                            var millions = Math.floor((number / 1000000) % 10);

                                            moveBeadsInRod('#rod-6-<?php echo $randomString; ?>', ones);
                                            moveBeadsInRod('#rod-5-<?php echo $randomString; ?>', tens);
                                            moveBeadsInRod('#rod-4-<?php echo $randomString; ?>', hundreds);
                                            moveBeadsInRod('#rod-3-<?php echo $randomString; ?>', thousands);
                                            moveBeadsInRod('#rod-2-<?php echo $randomString; ?>', tenThousands);
                                            moveBeadsInRod('#rod-1-<?php echo $randomString; ?>', hundredThousands);
                                            moveBeadsInRod('#rod-0-<?php echo $randomString; ?>', millions);
                                        }                             
                                        function moveBeadsInRod(rodSelector, count) {
                                            var beadsInRod = document.querySelectorAll(rodSelector + ' .beads');
                                            var numBeads = beadsInRod.length;

                                            beadsInRod.forEach(bead => {
                                                bead.style.transform = 'translateY(20%)'; // Move all beads down by default
                                            });

                                            if (count > numBeads) {
                                                // If count is greater than the number of beads, move all beads to the top
                                                beadsInRod.forEach(bead => {
                                                // bead.style.transform = 'translateY(-425%)';
                                                beadsInRod[i].style.display = "block";
                                                bead.classList.add("active");
                                                });
                                            } else {
                                                // Move 'count' number of beads to the top
                                                for (var i = numBeads - 1; i >= numBeads - count; i--) {
                                                beadsInRod[i].style.transform = 'translateY(0%)';
                                                beadsInRod[i].style.display = "block";
                                                beadsInRod[i].classList.add("active");

                                                }
                                            }
                                        }



                                    </script>
                                <?php
                            } 
                            else if(in_array($sbtpcrow['id'], array('66', '67', '68', '69'))){
                                $randomString = generateIDString();
                                ?>

                                <style>
                                    .place-values {
                                        display: flex;
                                        justify-content: space-between;
                                        width: 260px;
                                        margin-left: 10px;
                                    }

                                    .abacus-container-dip{
                                        display: flex;
                                        flex-direction: column;
                                        align-items: center;
                                        justify-content: center;
                                    }
                                </style>

                                <div class="abacus-container-dip content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 aft-heading-auto-height">
                                    <canvas id="canvas-<?php echo $randomString; ?>"></canvas>
                                    <div class="place-values" id="place-values-<?php echo $randomString; ?>"></div>
                                </div>
                                

                               

                                <script>
                                    //Suanpan Abacus

                                    generatePlaceValues();


                                    function generatePlaceValues() {
                                            var placeValuesContainer = document.getElementById('place-values-<?php echo $randomString; ?>');

                                            var placeValueLabels = ['TTh', 'Th', 'H', 'T', 'O'];

                                            for (var i = 0; i < 5; i++) {
                                            var placeValue = document.createElement('div');
                                            placeValue.className = 'place-value';
                                            placeValue.textContent = placeValueLabels[i];
                                            placeValuesContainer.appendChild(placeValue);
                                        }
                                    }

                                var canvas = document.getElementById('canvas-<?php echo $randomString; ?>');
                                var ctx = canvas.getContext('2d');

                                canvas.width=305;
                                canvas.height=250;

                                // Represents beads flipped from top to bottom. 
                                // Not the most clever solution but works for now
                                // 0 = not flipped ; 1 = flipped
                                var displayStates = [
                                    [0, 0,0,0,0],     //0
                                    [0, 1,0,0,0],     //1
                                    [0, 1,1,0,0],     //2
                                    [0, 1,1,1,0],     //3
                                    [0, 1,1,1,1],     //4
                                    [1, 0,0,0,0],     //5
                                    [1, 1,0,0,0],     //6
                                    [1, 1,1,0,0],     //7
                                    [1, 1,1,1,0],     //8
                                    [1, 1,1,1,1],     //9
                                ];

                                //A single column of beads
                                var Column = function(multiplier){
                                    this.position = {x:0, y:0};
                                    this.dimensions = {x:20,y:50}
                                    this.multiplier = multiplier || 1;
                                    this.value = 0;  
                                }
                                Column.prototype = {
                                
                                getState: function(){
                                    return displayStates[this.value];
                                },
                                
                                //Set number for column to represent. Complains if out of range
                                setValue: function(n){
                                    if (n > 15) console.log('Error: column can only represent up to 15');
                                    this.value = n;
                                },
                                    
                                getState: function(){
                                    return displayStates[this.value];
                                },
                                
                                draw: function(x,y1,y2){
                                    
                                    var st = this.getState();
                                    
                                    //Bar
                                    ctx.beginPath();
                                    ctx.lineWidth = 1;
                                    ctx.moveTo(x,y1);
                                    ctx.lineTo(x,y2);
                                    ctx.stroke();
                                    
                                    //Beads
                                    var beadSize = 10.25;
                                    ctx.fillStyle = "red";
                                    for (var i=0; i < st.length; i++){
                                    
                                        var offset;
                                        var d = beadSize * 2.6;
                                        //Top beads
                                        if (i < 1){
                                            offset = (i+1) * d;   
                                            if (st[i]) offset+=47;
                                            ctx.beginPath();
                                            ctx.arc(x,y1 + offset - 10,beadSize,0,2*Math.PI);
                                            ctx.fill();
                                        }
                                        
                                        //Lower beads
                                        else{
                                            offset = (st.length - i + 1) * d ;
                                            if (st[i]) offset += 60;
                                            ctx.beginPath();
                                            ctx.arc(x,y2 - offset + 40,beadSize,0,2*Math.PI);
                                            ctx.fill();
                                        }
                                
                                    }
                                    
                                }

                                }

                                //An abacus (Collection of columns)
                                var Abacus = function(){
                                var numColumns = 5;

                                this.columns = [];
                                this.width= canvas.width,
                                this.height=canvas.height,
                                this.thickness=7,
                                this.stroke="black",
                                this.fill="grey"
                                
                                //Create columns
                                for (var i=0; i < numColumns; i++) {
                                    var place =  Math.pow(10,(numColumns - i - 1));
                                    this.columns.push(new Column(place));
                                }

                                }
                                Abacus.prototype = {
                                
                                //Set Value
                                setValue : function(n){
                                    var sum = n;
                                    for (var i=0; i < this.columns.length; i++){
                                    
                                    var col = this.columns[i], 
                                        m = col.multiplier;
                                    
                                    col.setValue(0);
                                    
                                    if (sum < m){
                                        continue;
                                    }
                                    else{
                                        var remainder = sum % m;
                                        col.setValue( (sum-remainder) / m );
                                        sum = remainder;
                                    }
                                    }
                                    if (sum != 0) {
                                    console.log("Error: Number too large to display");
                                    }
                                },
                                
                                //Get Value
                                getValue : function(){
                                    return this.columns.reduce(function(sum,col){
                                    return sum + (col.value * col.multiplier);
                                    },0);
                                },
                                
                                //Get column display states
                                getState: function(){
                                    var states = [];
                                    for (var i=0; i < this.columns.length; i++){
                                    states.push(this.columns[i].getState());
                                    }
                                    return states;
                                },
                                
                                redraw: function(){
                                    
                                    ctx.clearRect(0,0,canvas.width,canvas.height);

                                    var t = this.thickness,
                                        w = this.width,
                                        h = this.height;

                                    //Draw Columns
                                    var numBars = this.columns.length;
                                    var offset = w / numBars;
                                    
                                    for (var i=0; i< this.columns.length; i++){
                                    var x = i * offset + offset/2;
                                    this.columns[i].draw(x,t,h)
                                    }  
                                    
                                    //Frame
                                    ctx.beginPath();
                                    ctx.lineWidth = t;
                                    ctx.strokeStyle = 'black';
                                    ctx.strokeRect(t,t,w-t,h-t);
                                    
                                    //Horizontal Bar
                                    ctx.beginPath
                                    ctx.moveTo(t,h/3);
                                    ctx.lineTo(w+t/2,h/3);
                                    ctx.stroke();
                                }
                                }

                                var abacus = new Abacus();

                                //Update Input
                                function update(){
                                    var el = <?php echo json_encode($querow['correct_ans']) ?>;
                                    abacus.setValue(Number(el));
                                    console.log(abacus);
                                    abacus.redraw();
                                }

                                update();
                                </script>
                                <?php
                            }

                            else if(in_array($sbtpcrow['id'], array('75', '76', '77'))){
                                // print_r($querow);
                                $randomString = generateIDString();
                                ?>
                                <div class="content br-1 text-center p-0 mb-mb-4 mb-2">
                                    <canvas id="clockCanvas-<?php echo $randomString; ?>" width="200" height="200"></canvas>
                                </div>
                                
                                <script>
                                    var shape_info = <?php echo $querow["shape_info"]; ?>;

                                    function drawClock(hour, minute) {
                                            var canvas = document.getElementById("clockCanvas-<?php echo $randomString; ?>");
                                            var ctx = canvas.getContext("2d");
                                            var radius = canvas.height / 2;
                                            ctx.clearRect(0, 0, canvas.width, canvas.height);
                                    
                                            // Reset the transformation matrix
                                            ctx.setTransform(1, 0, 0, 1, 0, 0);
                                    
                                            ctx.translate(radius, radius);
                                            radius = radius * 0.90;
                                            drawFace(ctx, radius);
                                            drawNumbers(ctx, radius);
                                            drawTime(ctx, radius, hour, minute);

                                            // convertToImg(canvas, 'myImg');
                                    }
                                    
                                    
                                    function drawFace(ctx, radius) {
                                            var grad;
                                            ctx.beginPath();
                                            ctx.arc(0, 0, radius, 0, 2 * Math.PI);
                                            ctx.fillStyle = 'white';
                                            ctx.fill();
                                            grad = ctx.createRadialGradient(0, 0, radius * 0.95, 0, 0, radius * 1.05);
                                            grad.addColorStop(0, '#333');
                                            grad.addColorStop(0.5, 'white');
                                            grad.addColorStop(1, '#333');
                                            ctx.strokeStyle = grad;
                                            ctx.lineWidth = radius * 0.1;
                                            ctx.stroke();
                                            ctx.beginPath();
                                            ctx.arc(0, 0, radius * 0.1, 0, 2 * Math.PI);
                                            ctx.fillStyle = '#333';
                                            ctx.fill();
                                        }
                                    
                                    function drawNumbers(ctx, radius) {
                                        var ang;
                                        var num;
                                        ctx.font = radius * 0.1 + "px arial";
                                        ctx.textBaseline = "middle";
                                        ctx.textAlign = "center";
                                        for (num = 1; num < 61; num++) {
                                            ang = num * Math.PI / 30;
                                            ctx.rotate(ang);
                                            ctx.translate(0, -radius * 0.85);
                                            ctx.rotate(-ang);
                                            if (num % 5 != 0) {
                                                ctx.fillText(".", 0, 0);
                                            }
                                            ctx.rotate(ang);
                                            ctx.translate(0, radius * 0.85);
                                            ctx.rotate(-ang);
                                        }
                                        for (num = 1; num < 13; num++) {
                                            ang = num * Math.PI / 6;
                                            ctx.rotate(ang);
                                            ctx.translate(0, -radius * 0.85);
                                            ctx.rotate(-ang);
                                            ctx.fillText(num.toString(), 0, 0);
                                            ctx.rotate(ang);
                                            ctx.translate(0, radius * 0.85);
                                            ctx.rotate(-ang);
                                
                                        }
                                    }
                                    
                                    function drawTime(ctx, radius, hour, minute) {
                                        hour = hour % 12;
                                        hour = (hour * Math.PI / 6) + (minute * Math.PI / (6 * 60));
                                        drawHand(ctx, hour, radius * 0.5, radius * 0.03);
                                    
                                        minute = (minute * Math.PI / 30);
                                        drawHand(ctx, minute, radius * 0.8, radius * 0.03);
                                    }
                                    
                                    function drawHand(ctx, pos, length, width) {
                                            ctx.beginPath();
                                            ctx.lineWidth = width;
                                            ctx.lineCap = "round";
                                            ctx.moveTo(0, 0);
                                            ctx.rotate(pos);
                                            ctx.lineTo(0, -length);
                                            ctx.stroke();
                                            ctx.rotate(-pos);
                                        }
                                    
                                    function updateClock() {
                                        var hour = parseInt(shape_info.hour);
                                        var minute = parseInt(shape_info.minute);
                                        drawClock(hour, minute);
                                    }
                                    
                                    // Initial drawing of the clock
                                    // drawClock(12, 0);

                                    updateClock();
                            
                                </script>

                                <?php
                            }
                            else if(in_array($sbtpcrow['id'], array('83', '84', '86', '87'))){
                                $shape_info = json_decode($querow["shape_info"]);

                                if($shape_info->shape_type == "square" || $shape_info->shape_type == "rectangle"){
                                    $randomString = generateIDString();
                                    ?>
                                        <style>
                                            .container-rectangle-dip {
                                                width: auto;
                                                height: auto;
                                                display: grid;
                                                page-break-inside:avoid;
                                            }
                                            
                                            .square {
                                            border: 1px solid black;
                                            /* background-color: white; */
                                            }
                                            
                                            .shaded1 {
                                            background-color: #FF2235 !important;
                                            }

                                            .shaded2 {
                                            background-color:#00a1de !important;
                                            }

                                            .content-center{
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;
                                            }
                                        </style>

                                        <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 content-center aft-heading-auto-height">
                                            <div class="container-rectangle-dip" id="squareContainer-<?php echo $randomString; ?>"></div>
                                        </div>

                                        <script>
                                            var shape_info = <?php echo $querow["shape_info"]; ?>;
                                            var container = document.getElementById("squareContainer-<?php echo $randomString; ?>");
                                            var length = parseInt(shape_info.shape_length);
                                            var breadth = parseInt(shape_info.shape_breadth);
                                            var shadedSquares1 = parseInt(shape_info.shaded_portion_1);
                                            var shadedSquares2 = parseInt(shape_info.shaded_portion_2);

                                            var color1 = "";
                                            var color2 = "";

                                            generateRectangle();
                                            
                                            function generateRectangle() {
                                            var squareSize = Math.min(300 / length, 300 / breadth);

                                            container.innerHTML = "";
                                            container.style.gridTemplateColumns = `repeat(${length}, ${squareSize}px)`;
                                            container.style.gridTemplateRows = `repeat(${breadth}, ${squareSize}px)`;

                                            var totalSquares = length * breadth;
                                            var startingIndex = getRandomStartingIndex(totalSquares);
                                            var shadedIndices1 = generateShadedIndices(totalSquares, shadedSquares1, startingIndex);
                                            var shadedIndices2 = generateShadedIndices(totalSquares, shadedSquares2, startingIndex, shadedIndices1);

                                            for (var i = 0; i < totalSquares; i++) {
                                                var square = document.createElement("div");
                                                square.classList.add("square");

                                                if (shadedIndices1.includes(i)) {
                                                square.classList.add("shaded1");
                                                } else if (shadedIndices2.includes(i)) {
                                                square.classList.add("shaded2");
                                                }

                                                container.appendChild(square);
                                            }
                                            }

                                            function generateShadedIndices(totalSquares, shadedSquares, startingIndex, exclusionIndices = []) {
                                            var shadedIndices = [];
                                            var isShaded = Array(totalSquares).fill(false);
                                            var shadedCount = 0;

                                            while (shadedCount < shadedSquares) {
                                                var index = getRandomIndex(totalSquares);

                                                if (
                                                index !== startingIndex &&
                                                !exclusionIndices.includes(index) &&
                                                !shadedIndices.includes(index) &&
                                                !isShaded[index]
                                                ) {
                                                shadedIndices.push(index);
                                                isShaded[index] = true;
                                                shadedCount++;
                                                }
                                            }

                                            return shadedIndices;
                                            }

                                            function getRandomIndex(totalSquares) {
                                                return Math.floor(Math.random() * totalSquares);
                                            }

                                            function getRandomStartingIndex(totalSquares) {
                                                return Math.floor(Math.random() * totalSquares);
                                            }
                                        </script>
                                    <?php
                                } 
                                else if($shape_info->shape_type == "circle"){
                                    $randomString = generateIDString();
                                    ?>
                                     
                                    <style>
                                        #chart-container {
                                            width: 100%;
                                            height: 300px;
                                            position: relative;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        }

                                        #pie-chart {
                                            position: absolute;
                                            top: 0;
                                            left: 0;
                                        }
                                    </style>
                                   

                                    <div id="chart-container" class="content aft-heading-wrapper br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 aft-heading-auto-height">
                                        <canvas id="pie-chart-canvas-<?php echo $randomString; ?>"></canvas>
                                    </div>

                                    <script>
                                        var shape_info = <?php echo ($querow["shape_info"]); ?>;


                                        function generateCircle(){
                                            // Retrieve the input values
                                            var divisions = parseInt(shape_info.shape_length);
                                            var shaded1 = parseInt(shape_info.shaded_portion_1);
                                            var shaded2 = parseInt(shape_info.shaded_portion_2);
                                            
                                            // Check if the sum of shaded regions is valid
                                            if (shaded1 + shaded2 > divisions) {
                                                alert("Sum of shaded regions cannot exceed the total number of divisions.");
                                                return;
                                            }

                                            // Prepare the data for the pie chart
                                            var data = Array.from({ length: divisions }, () => 1);
                                            
                                            // Get the canvas element
                                            var canvas = document.getElementById('pie-chart-canvas-<?php echo $randomString; ?>');
                                            var ctx = canvas.getContext('2d');

                                            // Set the width and height of the canvas
                                            canvas.width = canvas.offsetWidth;
                                            canvas.height = canvas.offsetHeight;

                                            // Calculate the center coordinates
                                            var centerX = canvas.width / 2;
                                            var centerY = canvas.height / 2;

                                            // Calculate the radius based on the smaller dimension of the canvas
                                            var radius = Math.min(canvas.width, canvas.height) / 2;

                                            // Define the colors for shaded and unshaded slices
                                            var shaded1Color = '#FF2235'; // Red color for shaded region 1
                                            var shaded2Color = '#00a1de'; // Blue color for shaded region 2
                                            var unshadedColor = '#ffffff'; // White color for unshaded slices

                                            // Define the border colors for shaded and unshaded slices
                                            var shadedBorderColor = '#ffffff'; // White color for shaded slice borders
                                            var unshadedBorderColor = '#000000'; // Black color for unshaded slice borders

                                            // Calculate the total value from the data array
                                            var total = data.length;

                                            // Start angle for the first division
                                            var startAngle = 0;

                                            // Draw each division of the pie chart
                                            data.forEach((_, index) => {
                                                var sliceAngle = (1 / total) * 2 * Math.PI;
                                                var endAngle = startAngle + sliceAngle;

                                                ctx.beginPath();
                                                ctx.moveTo(centerX, centerY);
                                                ctx.arc(centerX, centerY, radius, startAngle, endAngle);
                                                ctx.closePath();

                                                // Set the fill style based on the index of the slice
                                                if (index < shaded1) {
                                                ctx.fillStyle = shaded1Color;
                                                } else if (index < shaded1 + shaded2) {
                                                ctx.fillStyle = shaded2Color;
                                                } else {
                                                ctx.fillStyle = unshadedColor;
                                                }

                                                ctx.fill();

                                                // Set the border color and width based on the index of the slice
                                                ctx.lineWidth = 2;
                                                if (index < shaded1 || (index >= shaded1 && index < shaded1 + shaded2)) {
                                                ctx.strokeStyle = shadedBorderColor;
                                                } else {
                                                ctx.strokeStyle = unshadedBorderColor;
                                                }

                                                ctx.stroke();

                                                startAngle = endAngle;
                                            });
                                            // convertToImg(canvas, 'myImg');
                                        }

                                        generateCircle();

                                    </script>
                                    

                                    <?php
                                }
                            }

                            else if(in_array($sbtpcrow['id'], array('88'))){
                                $randomString = generateIDString();
                                ?>
                                <style>
                                    .box {
                                        width: 30px;
                                        height: 30px;
                                        border: 2px solid black;
                                        display: inline-block;
                                        /*margin: 0.25px;*/
                                        /* background-color: white; */
                                        page-break-inside:avoid;
                                    }

                                    /* Set the font size to 0 to remove whitespace between inline-block elements */
                                    .matrix-container {
                                        font-size: 0;
                                    }

                                    .bordered-top {
                                        border-top: 2px solid #eabc00;
                                    }

                                    .bordered-bottom {
                                        border-bottom: 2px solid #eabc00;
                                    }

                                    .bordered-left {
                                        border-left: 2px solid #eabc00;
                                    }

                                    .bordered-right {
                                        border-right: 2px solid #eabc00;
                                    }

                                    .matrix{
                                        line-height: 0 !important;
                                        page-break-inside:avoid;
                                    }
                                </style>

                                <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 aft-heading-auto-height">
                                    <div class="matrix-container">
                                        <div id="matrix-<?php echo $randomString; ?>" class="matrix"></div>
                                    </div>
                                </div>
                                <script>
                                    function isShaded(row, col, coords) {
                                        return coords.some(coord => coord.row === row && coord.col === col);
                                    }

                                    function drawMatrixFromCoordinates(coordinateArray) {
                                    var matrixSize = 10;
                                    var matrixDiv = document.getElementById("matrix-<?php echo $randomString; ?>");
                                    matrixDiv.innerHTML = "";

                                    for (var row = 0; row < matrixSize; row++) {
                                        for (var col = 0; col < matrixSize; col++) {
                                            var isShadedCurrent = isShaded(row, col, coordinateArray);
                                            var isShadedTop = isShaded(row - 1, col, coordinateArray);
                                            var isShadedBottom = isShaded(row + 1, col, coordinateArray);
                                            var isShadedLeft = isShaded(row, col - 1, coordinateArray);
                                            var isShadedRight = isShaded(row, col + 1, coordinateArray);

                                            var box = document.createElement("div");
                                            box.classList.add("box");
                                            box.style.backgroundColor = isShadedCurrent ? "#00b971" : "white";

                                            if (isShadedCurrent) {
                                                // Check if there's no shaded cell above and add the top border
                                                if (!isShadedTop) {
                                                    box.classList.add("bordered-top");
                                                }
                                                // Check if there's no shaded cell below and add the bottom border
                                                if (!isShadedBottom) {
                                                    box.classList.add("bordered-bottom");
                                                }
                                                // Check if there's no shaded cell to the left and add the left border
                                                if (!isShadedLeft) {
                                                    box.classList.add("bordered-left");
                                                }
                                                // Check if there's no shaded cell to the right and add the right border
                                                if (!isShadedRight) {
                                                    box.classList.add("bordered-right");
                                                }
                                            }

                                            matrixDiv.appendChild(box);
                                        }

                                        var lineBreak = document.createElement("br");
                                        matrixDiv.appendChild(lineBreak);
                                    }
                                }

                                            var sample = <?php echo ($querow["shape_info"]); ?>;
                                            var sampleCoordinates = sample.coordinates;


                                    // Call the function to draw the matrix with the sample coordinates
                                    drawMatrixFromCoordinates(sampleCoordinates);
                                </script>
                                <?php
                            }
                            else if(in_array($sbtpcrow['id'], array('98', '99', '100', '233', '232'))){
                                $shape_info = json_decode($querow["shape_info"]);
                                $choose_graph = $shape_info->type;

                                if($choose_graph == "bar_graph"){
                                    $randomString = generateIDString();
                                    ?>
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                                        <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 canvas-ques-auto-height <?php echo $hmx300; ?>">

                                            <div style="width: 90%; max-width: 800px; margin: 20px auto;">
                                                <canvas id="barChart-<?php echo $randomString; ?>" style="height: 500px;"></canvas>
                                                <!-- <img id="myImg" width="500"> -->
                                            </div>

                                        </div>

                                        <script>
                                            var shape_info = <?php echo $querow["shape_info"]; ?>;
                                            var month_graph = shape_info.values;

                                            var months = month_graph.map(item => item.month);
                                            var unitsProduced = month_graph.map(item => item.units);

                                            var canvas = document.getElementById("barChart-<?php echo $randomString; ?>");
                                            var ctx = canvas.getContext("2d");
                                            var barChart = new Chart(ctx, {
                                            type: "bar",
                                            data: {
                                                labels: months,
                                                datasets: [{
                                                label: "Units Produced",
                                                data: unitsProduced,
                                                backgroundColor: "rgba(54, 162, 235, 0.5)",
                                                borderColor: "rgba(54, 162, 235, 1)",
                                                borderWidth: 1,
                                                }]
                                            },
                                            options: {
                                                responsive: true,
                                                maintainAspectRatio: false,
                                                animation: {
                                                    duration: 0, // Set animation duration to 0 to disable it
                                                },
                                                scales: {
                                                x: {
                                                    grid: {
                                                    display: true,
                                                    drawBorder: false,
                                                    drawOnChartArea: false,
                                                    }
                                                },
                                                y: {
                                                    beginAtZero: false,
                                                    min: 500,
                                                    max: 5000,
                                                    grid: {
                                                    display: true,
                                                    drawBorder: false,
                                                    drawOnChartArea: true,
                                                    },
                                                    ticks: {
                                                    stepSize: 500,
                                                    callback: function(value, index, values) {
                                                        return value; // Display the actual value on the y-axis
                                                    }
                                                    }
                                                }
                                                },
                                                plugins: {
                                                title: {
                                                    display: true,
                                                    text: "Month-wise Units Produced",
                                                    fontSize: 24,
                                                },
                                                legend: {
                                                    display: true,
                                                    position: "top",
                                                }
                                                }
                                            }
                                            });

                                            // convertToImg(canvas, 'myImg');
                                        </script>

                                    <?php
                                }
                                else if($choose_graph == "horizontal_bar_graph") {
                                    $randomString = generateIDString();

                                    ?>
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                                        <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 canvas-ques-auto-height <?php echo $hmx300; ?>">

                                            <div style="width: 90%; max-width: 800px; margin: 20px auto;">
                                                <canvas id="horizontalBarChart-<?php echo $randomString; ?>" style="height: 500px;"></canvas>
                                                <!-- <img id="myImg" width = "500"> -->
                                            </div>

                                        </div>

                                        <script>
                                            var shape_info = <?php echo $querow["shape_info"]; ?>;
                                            var month_graph = shape_info.values;

                                            var months = month_graph.map(item => item.month);
                                            var unitsProduced = month_graph.map(item => item.units);

                                            var canvas = document.getElementById("horizontalBarChart-<?php echo $randomString; ?>");
                                            var ctx = canvas.getContext("2d");
                                            var horizontalBarChart = new Chart(ctx, {
                                                type: "bar",
                                                data: {
                                                    labels: months,
                                                    datasets: [{
                                                    label: "Units Produced",
                                                    data: unitsProduced,
                                                    backgroundColor: [
                                                        "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40",
                                                        "#FF5733", "#32CD32", "#7B68EE", "#F08080", "#3CB371", "#BA55D3"
                                                    ],
                                                    borderColor: "#000",
                                                    borderWidth: 1,
                                                    }]
                                                },
                                                options: {
                                                    indexAxis: 'y', // Horizontal bar graph with rotated axis ticks
                                                    responsive: true,
                                                    maintainAspectRatio: false,
                                                    animation: {
                                                        duration: 0, // Set animation duration to 0 to disable it
                                                    },
                                                    plugins: {
                                                        title: {
                                                            display: true,
                                                            text: "Month-wise Units Produced",
                                                            fontSize: 24,
                                                        },
                                                        legend: {
                                                            display: false,
                                                        },
                                                        datalabels: {
                                                            anchor: 'end',
                                                            align: 'end',
                                                            color: '#333',
                                                            font: {
                                                                size: 14,
                                                            }
                                                        }
                                                    },
                                                    scales: {
                                                    x: {
                                                        beginAtZero: false,
                                                        min: 500,
                                                        max: 5500,
                                                        grid: {
                                                            display: true,
                                                            drawBorder: false,
                                                            drawOnChartArea: false,
                                                        },
                                                        ticks: {
                                                        stepSize: 500,
                                                            callback: function(value, index, values) {
                                                                return value; // Display the actual value on the x-axis
                                                            }
                                                        }
                                                    },
                                                    },
                                                }
                                            });

                                            // convertToImg(canvas, 'myImg');
                                        </script>
                                    <?php
                                }
                                else if($choose_graph == "line_graph"){
                                    $randomString = generateIDString();

                                    ?>
                                          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                          <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 canvas-ques-auto-height <?php echo $hmx300; ?>">
                                            <div style="width: 90%; max-width: 800px; margin: 20px auto;">
                                                <canvas id="lineChart-<?php echo $randomString; ?>" style="height: 500px;"></canvas>
                                                <!-- <img id="myImg" width = "500"> -->
                                            </div></div>
                                            <script>
                                                var shape_info = <?php echo $querow["shape_info"]; ?>;
                                                var month_graph = shape_info.values;

                                                var months = month_graph.map(item => item.month);
                                                var unitsProduced = month_graph.map(item => item.units);

                                                var canvas = document.getElementById("lineChart-<?php echo $randomString; ?>");
                                                var ctx = canvas.getContext("2d");
                                                var lineChart = new Chart(ctx, {
                                                type: "line",
                                                data: {
                                                    labels: months,
                                                    datasets: [{
                                                    label: "Units Produced",
                                                    data: unitsProduced,
                                                    borderColor: "#FF6384",
                                                    borderWidth: 2,
                                                    pointBackgroundColor: "#FF6384",
                                                    pointRadius: 5,
                                                    fill: false,
                                                    }]
                                                },
                                                options: {
                                                    responsive: true,
                                                    maintainAspectRatio: false,
                                                    animation: {
                                                        duration: 0, // Set animation duration to 0 to disable it
                                                    },
                                                    plugins: {
                                                    title: {
                                                        display: true,
                                                        text: "Month-wise Units Produced",
                                                        fontSize: 24,
                                                    },
                                                    legend: {
                                                        display: true,
                                                        position: "top",
                                                    }
                                                    },
                                                    scales: {
                                                    x: {
                                                        grid: {
                                                        display: true,
                                                        drawBorder: false,
                                                        drawOnChartArea: false,
                                                        }
                                                    },
                                                    y: {
                                                        beginAtZero: false,
                                                        min: 500,
                                                        max: 5500,
                                                        grid: {
                                                        display: true,
                                                        drawBorder: false,
                                                        drawOnChartArea: true,
                                                        },
                                                        ticks: {
                                                        stepSize: 500,
                                                        callback: function(value, index, values) {
                                                            return value; // Display the actual value on the y-axis
                                                        }
                                                        }
                                                    }
                                                    },
                                                }
                                                });

                                                // convertToImg(canvas, 'myImg');

                                            </script>
                                    <?php
                                }
                                else if($choose_graph == "pie_chart"){
                                    $randomString = generateIDString();

                                    ?>
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                        <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 canvas-ques-auto-height <?php echo $hmx300; ?>">
                                          <div style="width: 90%; max-width: 800px; margin: 20px auto;">
                                            <canvas id="pieChart-<?php echo $randomString; ?>" style="height: 500px;"></canvas>
                                        </div>
                                        </div>
                                        <script>
                                            var shape_info = <?php echo $querow["shape_info"]; ?>;
                                            var month_graph = shape_info.values;

                                            var months = month_graph.map(item => item.month + " - " + item.units);
                                            var unitsProduced = month_graph.map(item => item.units);

                                            // Define an array of 12 different colors
                                            var colors = [
                                                "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40",
                                                "#FF5733", "#32CD32", "#7B68EE", "#F08080", "#3CB371", "#BA55D3"
                                            ];

                                            var colorPalette = [];
                                            for (var i = 0; i < months.length; i++) {
                                                colorPalette.push(colors[i]);
                                            }

                                            var canvas = document.getElementById("pieChart-<?php echo $randomString; ?>");
                                            var ctx = canvas.getContext("2d");
                                            var pieChart = new Chart(ctx, {
                                                type: "pie",
                                                data: {
                                                    labels: months,
                                                    datasets: [{
                                                        label: "Units Produced",
                                                        data: unitsProduced,
                                                        backgroundColor: colorPalette,
                                                        borderColor: colorPalette,
                                                        borderWidth: 1,
                                                    }]
                                                },
                                                options: {
                                                    responsive: true,
                                                    maintainAspectRatio: false,
                                                    animation: {
                                                        duration: 0, // Set animation duration to 0 to disable it
                                                    },
                                                    plugins: {
                                                        title: {
                                                            display: true,
                                                            text: "Month-wise Units Produced",
                                                            fontSize: 24,
                                                        },
                                                        legend: {
                                                            display: true,
                                                            position: "top",
                                                        },
                            
                                                    }
                                                }
                                            });

                                        </script>
                                    <?php
                                }
                            }

                            else if(in_array($sbtpcrow['id'], array('101', '102', '103'))) {
                                    $shape_info_que = json_decode($querow["shape_info"]);
                                    $img_file = $shape_info_que[1]->img;

                                    // var_dump($shape_info_que);
                                ?>
                                <style>

                                </style>
                                    <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 canvas-ques-auto-height">
                                        <img src= "<?php echo $page !== '' ? $baseurl : ""; ?>uploads/directions/<?php echo $img_file ; ?>" style='height:300px;width:300px;object-fit:contain' alt="">
                                    </div>
                                <?php
                            }

                            else if(in_array($sbtpcrow['id'], array('106', '107', '112', '113', '114', '115', '116', '117'))){
                                $shape_info_que = json_decode($querow["shape_info"]);
                                $question_type = $shape_info_que->type;

                                if($question_type == "addition"){
                                    $randomString = generateIDString();
                                    $sum_max_len = strlen(($shape_info_que->num_1 + $shape_info_que->num_2) . "") + 1;
                                    ?>
                                    <style>

                                        #grid-container-<?php echo $randomString; ?> {
                                            display: grid;
                                            grid-template-columns: repeat(<?php echo $sum_max_len; ?>, 50px);
                                            grid-template-rows: repeat(3, 50px);
                                            justify-content: center;
                                            margin-top: 20px;
                                            text-align: center;
                                            line-height: 0 !important;
                                            page-break-inside:avoid;
                                        }

                                        .grid-item {
                                            width: 50px;
                                            height: 50px;
                                            border: 1px solid #ccc;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-size: 20px;
                                        }

                                        .grid-border {
                                            border-bottom: 3px solid #000;
                                        }
                                    </style>


                                    <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 aft-heading-auto-height <?php echo $hmx220; ?>">
                                            <div class="grid-container" id="grid-container-<?php echo $randomString; ?>">
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
                                                    for ($j = 0; $j < $sum_max_len; $j++) {
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
                                    <?php
                                }
                                elseif($question_type == "substraction"){
                                    $randomString = generateIDString();
                                    $diff_max_len = max(strlen($shape_info_que->num_1 . ""), strlen($shape_info_que->num_2 . "")) + 1;
                                    ?>
                                        <style>
                                            
                                            #grid-container-subtraction-<?php echo $randomString; ?> {
                                                display: grid;
                                                grid-template-columns: repeat(<?php echo $diff_max_len; ?>, 50px);
                                                grid-template-rows: repeat(3, 50px);
                                                justify-content: center;
                                                margin-top: 20px;
                                                text-align: center;
                                                line-height: 0 !important;
                                                page-break-inside:avoid;
                                            }

                                            .grid-item {
                                                width: 50px;
                                                height: 50px;
                                                border: 1px solid #ccc;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                font-size: 20px;
                                            }

                                            .grid-border {
                                                border-bottom: 3px solid #000;
                                            }
                                        </style>

                                            <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 aft-heading-auto-height <?php echo $hmx220; ?>">
                                                    <div class="grid-container-subtraction" id="grid-container-subtraction-<?php echo $randomString; ?>">
                                                        <?php
                                                        // Assuming $querow["shape_info"] contains the necessary data
                                                        $shape_info = json_decode($querow["shape_info"]);
                                                        // var_dump($shape_info);
                                                        $number1 = (string) "" . $shape_info->num_1;
                                                        $number2 = (string) "" . $shape_info->num_2;
                                                        $number3 = (string) "" . $shape_info->pqr;
                                                        $sum = (string) (intval($number1) - intval($number2));

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
                                                            for ($j = 0; $j < $diff_max_len; $j++) {
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
                                                                    echo ($j === 0) ? '-' : (($j < 1 + count($digits2)) ? $digits2[$j - 1] : '');
                                                                } else {
                                                                    echo ($j !== 0 && $j < 1 + count($sumDigits)) ? $sumDigits[$j - 1] : '';
                                                                }

                                                                echo '</div>';
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    </div>
                                    <?php
                                }
                                else if($question_type == "multiplication"){
                                    $randomString = generateIDString();
                                    $prod_max_len = strlen($shape_info_que->num_1 * $shape_info_que->num_2) + 1;
                                    ?>
                                        <style>
                                            #grid-container-<?php echo $randomString; ?> {
                                                display: grid;
                                                grid-template-columns: repeat(<?php echo $prod_max_len; ?>, 30px);
                                                grid-template-rows: repeat(3, 30px);
                                                justify-content: center;
                                                margin-top: 20px;
                                                text-align: center;
                                                line-height: 0 !important;
                                                page-break-inside:avoid;
                                            }

                                            .grid-item-multiply {
                                                width: 30px;
                                                height: 30px;
                                                border: 1px solid #ccc;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                font-size: 15px;
                                            }

                                            .grid-border-multiply{
                                                border-bottom: 3px solid #000 !important;
                                            }
                                        </style>
                                        
                                        <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 aft-heading-auto-height <?php echo $hmx220; ?>">
                                            <div class="grid-container-multiply" id="grid-container-<?php echo $randomString; ?>"></div>
                                        </div>

                                        <script>
                                        visualizeMultiplication();
                                            function visualizeMultiplication() {
                                            var shape_info = <?php echo $querow["shape_info"]; ?>;
                                            var number1 = shape_info.num_1 + "";
                                            var number2 = shape_info.num_2 + "";
                                            var number3 = shape_info.pqr + "";
                                            var product = (parseInt(number1) * parseInt(number2)) + "";

                                            var gridContainer = document.getElementById("grid-container-<?php echo $randomString; ?>");
                                            gridContainer.innerHTML = '';
                                                
                                            var num2_len = (number2 + "").length;
                                            console.log(num2_len);


                                            var partial_multiplication_1 = (parseInt(number1) * (number2.split("")[2])) + "";
                                            var partial_multiplication_2 = (parseInt(number1) * (number2.split("")[1])) + "x".repeat(Math.max(num2_len - 2, 0));
                                            var partial_multiplication_3 = (parseInt(number1) * (number2.split("")[0])) + "x".repeat(Math.max(num2_len - 1, 0));


                                            var maxLength = Math.max(number1.length, number2.length, product.length);
                                            var paddedNum1 = number1.padStart(maxLength, " ");
                                            var paddedNum2 = ("X" + number2).padStart(maxLength, " ");
                                            var num3_array = ("" + number3).split("");
                                            var padded_partial_1 = partial_multiplication_1.padStart(maxLength, " ");
                                            var padded_partial_2 = (partial_multiplication_2).padStart(maxLength, " ");
                                            var padded_partial_3 = (partial_multiplication_3).padStart(maxLength, " ");

                                            var map_digits = {
                                                P: num3_array[0],
                                                Q: num3_array[1], 
                                                R: num3_array[2],
                                            }
                                        
                                            // Split numbers into digits
                                            var digits1 = paddedNum1.split('').map(digit => map_digits.P == digit ? "P" : digit);
                                            var digits2 = paddedNum2.split('').map(digit => map_digits.Q == digit ? "Q" : digit);
                                            var productDigits = product.toString().split('').map(digit => map_digits.R == digit ? "R" : digit);


                                            // Create a 5x10 grid
                                            for (var i = 0; i <= (num2_len * 2); i++) {
                                                for (var j = 0; j < <?php echo $prod_max_len; ?>; j++) {
                                                    var gridItem = document.createElement("div");
                                                    gridItem.classList.add("grid-item-multiply");

                                                    if (i === 0) {
                                                        if (j === 0) {
                                                        gridItem.textContent = ' '; // Empty box before the first number
                                                        } else {
                                                        gridItem.textContent = j <= digits1.length ? digits1[j - 1] : '';
                                                        }
                                                    } else if (i === 1) {
                                                        gridItem.textContent = j === 0 ? ' ' : (j < 1 + digits2.length ? digits2[j - 1] : '');
                                                        gridItem.classList.add("grid-border-multiply");
                                                    } 
                                                    else if(num2_len > 1 && i == 2){
                                                        var chosen = num2_len == 3 ? padded_partial_1 :padded_partial_2;
                                                        gridItem.textContent = j === 0 ? ' ' : (j < 1 + chosen.length ? chosen[j - 1] : '');
                                                    }
                                                    else if(num2_len > 1 && i == 3){
                                                        var chosen = num2_len == 3 ? padded_partial_2 :padded_partial_3;
                                                        gridItem.textContent = j === 0 ? ' ' : (j < 1 + chosen.length ? chosen[j - 1] : '');
                                                        num2_len == 2 ? gridItem.classList.add("grid-border-multiply") : "";
                                                    }
                                                    else if(num2_len > 2 && i == 4){
                                                        gridItem.textContent = j === 0 ? ' ' : (j < 1 + padded_partial_3.length ? padded_partial_3[j - 1] : '');
                                                        gridItem.classList.add("grid-border-multiply");
                                                    }
                                                    else if(i == (num2_len * 2)) {
                                                        gridItem.textContent = j < 1 + productDigits.length ? productDigits[j - 1] : '';
                                                    }

                                                    gridContainer.appendChild(gridItem);
                                                }
                                            }
                                            }
                                        </script>
                                    <?php
                                }
                                else if($question_type == "division"){
                                    $randomString = generateIDString();
                                    $div_max_len = strlen($shape_info_que->num_1 . "" . $shape_info_que->num_2 . "" . intval($shape_info_que->num_1 / $shape_info_que->num_2)) + 1;
                                    ?>
                                          <style>
                                                #grid-container-<?php echo $randomString; ?> {
                                                    display: grid;
                                                    grid-template-columns: repeat(<?php echo $div_max_len; ?>, 25px);
                                                    grid-template-rows: repeat(3, 25px);
                                                    /* grid-gap: 5px; */
                                                    justify-content: center;
                                                    margin-top: 20px;
                                                    text-align: center;
                                                    line-height: 0 !important;
                                                    page-break-inside:avoid;
                                                }

                                                .grid-item-division {
                                                    width: 25px;
                                                    height: 25px;
                                                    border: 1px solid #ccc;
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    font-size: 15px;
                                                }

                                                .grid-border-top{
                                                    border-top: 3px solid #000 !important;
                                                }

                                                .grid-border-right{
                                                    border-right: 3px solid #000 !important;
                                                }

                                                .grid-border-left{
                                                    border-left: 3px solid #000 !important;
                                                }

                                                .grid-border-bottom{
                                                    border-bottom: 3px solid #000 !important;
                                                }
                                            </style>
                                            <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 aft-heading-auto-height <?php echo $hmx220; ?> d-flex align-items-center justify-content-center">
                                                <div class="grid-container-division" id="grid-container-<?php echo $randomString; ?>"></div>
                                            </div>

                                            <script>
                                                visualizeDivision();
                                                function visualizeDivision() {
                                                    var shape_info = <?php echo $querow["shape_info"]; ?>;
                                                    var number1 = shape_info.num_1 + "";
                                                    var number2 = shape_info.num_2 + "";
                                                    var number3 = shape_info.pqr + "";
                                                    var quotient = Math.floor(parseInt(number1) / parseInt(number2)) + "";
                                                    var remainder = Math.floor(parseInt(number1) % parseInt(number2)) + "";
                                                    var num3_array =(number3 + "").split("");
                                                    console.log(number3);

                                                var gridContainer = document.getElementById("grid-container-<?php echo $randomString; ?>");
                                                gridContainer.innerHTML = '';

                                                var current_divisor = (number2 + "").length;
                                                var divisor_end = (number1 + "").length + (current_divisor - 1);
                                                var quotient_array = (quotient + "").split("");

                                                var map_digits = {
                                                    P: num3_array[0],
                                                    Q: num3_array[1], 
                                                    R: num3_array[2],
                                                }

                                                var digits1 = number1.split('').map(digit => map_digits.P == digit ? "P" : digit).join("");
                                                var digits2 = number2.split('').map(digit => map_digits.Q == digit ? "Q" : digit).join("");
                                                var quotientDigits = quotient.toString().split('').map(digit => map_digits.R == digit ? "R" : digit).join("");

                                                for(var i = 0; i < <?php echo $div_max_len; ?>; i++){
                                                    var gridItem = document.createElement("div");
                                                    gridItem.classList.add("grid-item-division");

                                                    if(i < (number2 + "").length){
                                                        gridItem.textContent = (digits2 + "").split("")[i];
                                                    }

                                                    else if(i >= (number2 + "").length && i < ((number2 + "").length + (number1 + "").length)){
                                                        gridItem.textContent = (digits1 + "").split("")[i - (number2 + "").length];
                                                        i == (number2 + "").length ? gridItem.classList.add("grid-border-left", "grid-border-top") : gridItem.classList.add("grid-border-top");
                                                    }

                                                    else if(i >= ((number2 + "").length + (number1 + "").length) && i < ((number2 + "").length + (number1 + "").length + (quotient + "").length)){
                                                        gridItem.textContent = quotientDigits[i - ((number2 + "").length + (number1 + "").length)];
                                                        i == ((number2 + "").length + (number1 + "").length) ? gridItem.classList.add("grid-border-left") : "";
                                                    }

                                                    gridContainer.appendChild(gridItem);

                                                }

                                                var copy_dividend = "" + number1;
                                                var new_remainder = 0;

                                                


                                                for(var i = 0; i < quotient_array.length; i++){

                                                    var product_div = ((parseInt(number2) * parseInt(quotient[i])) + "").split("");
                                                    var current_divisor_working;

                                                    if(i === 0){
                                                        current_divisor_working = copy_dividend.substring(0, product_div.join("").length);

                                                        if(parseInt(current_divisor_working) < parseInt(product_div.join(""))){
                                                            current_divisor_working = copy_dividend.substring(0, product_div.join("").length + 1);
                                                            product_div = product_div.join("").padStart(current_divisor_working.length, " ").split("");
                                                        }

                                                        copy_dividend = copy_dividend.substring(current_divisor_working.length);
                                                    }
                                                    else {
                                                        current_divisor_working = new_remainder;
                                                        copy_dividend = copy_dividend.substring(1);
                                                        product_div = product_div.join("").padStart(current_divisor_working.length, " ").split("");
                                                    }

                                                    new_remainder = (parseInt(current_divisor_working) - parseInt(product_div.join(""))) + "";
                                                    // new_remainder = new_remainder.padStart(Math.max(current_divisor_working.length, product_div.length), " ");
                                                    new_remainder += (copy_dividend[0] ? copy_dividend[0] : " ") + "";


                                                    //row for substraction
                                                    for(var j = 0; j < <?php echo $div_max_len; ?>; j++){
                                                        var gridItem = document.createElement("div");
                                                        gridItem.classList.add("grid-item-division");

                                                        if(j >= current_divisor){
                                                            gridItem.textContent = (j - current_divisor) <= product_div.length ? product_div[j - current_divisor] : "";
                                                            ((j - current_divisor) <= product_div.length) ? gridItem.classList.add("grid-border-bottom") : "";
                                                        }

                                                        gridContainer.appendChild(gridItem);

                                                    }

                                                    var rem_offset = Math.max(product_div.length - (new_remainder.length - 1), 1);


                                                    if(new_remainder.length - 1 !== product_div.length){current_divisor = current_divisor + rem_offset;}
                                                    console.log(new_remainder.lastIndexOf(" "));


                                                    //row for remainder
                                                    for(var j = 0; j < <?php echo $div_max_len; ?>; j++){
                                                        var gridItem = document.createElement("div");
                                                        gridItem.classList.add("grid-item-division");

                                                        if(j >= current_divisor){
                                                            gridItem.textContent = (j - current_divisor) <= new_remainder.length ? new_remainder[j - current_divisor] : "";
                                                        }

                                                        gridContainer.appendChild(gridItem);
                                                    }
                                                }
                                                }
                                            </script>
                                    <?php
                                }
                            }

                            else if(in_array($sbtpcrow['id'], array('172'))){
                                $randomString = generateIDString();
                                ?>
                                    <style>
                                        #question-img-pictures img {
                                        width: 100px; /* Adjust the width as needed */
                                        height: auto;
                                        margin: 5px;
                                        }
                                    </style>
                                    <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2" id="question-img-pictures-<?php echo $randomString; ?>"></div>
                                    <script>
                                            function showPictures() {
                                                var numPictures = parseInt(<?php echo json_encode($querow["correct_ans"]); ?>);
                                                var pictureContainer = document.getElementById('question-img-pictures-<?php echo $randomString; ?>');
                                                pictureContainer.innerHTML = '';

                                                for (var i = 1; i <= numPictures; i++) {
                                                    var img = document.createElement('img');
                                                    img.src = "<?php echo $baseurl; ?>/uploads/pictureQuestions/1.svg"; // Replace with the actual image path
                                                    img.alt = 'Picture ' + i;
                                                    pictureContainer.appendChild(img);
                                                }
                                            }

                                            showPictures();
                                    </script>
                                <?php
                            }

                            else if(in_array($sbtpcrow['id'], array('175', '173', '176', '177', '178'))){
                                $shape_info = json_decode($querow["shape_info"]);
                                $randomString = generateIDString();

                                if($shape_info->type == "calender"){
                                    ?>
                                        <style>
                                            .calendarCanvas {
                                                border: 1px solid black;
                                            }
                                        </style>
                                        <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 aft-heading-auto-height <?php echo $hmx220; ?>">
                                            <canvas class="calendarCanvas" id="calendarCanvas<?php echo $randomString; ?>" width="400" height="400"></canvas>
                                            <!-- <img id="myImg" width = "600" height="400"> -->
                                        </div>

                                        <script>
                                            var monthNames = [
                                                'January', 'February', 'March', 'April', 'May', 'June',
                                                'July', 'August', 'September', 'October', 'November', 'December'
                                            ];

                                            var canvas = document.getElementById('calendarCanvas<?php echo $randomString; ?>');
                                            var ctx = canvas.getContext('2d');

                                            var shape_info = <?php echo json_encode($shape_info); ?>;
                                            var shape_month = monthNames.indexOf(shape_info.month) + 1; // Specify the month (1-12)
                                            var shape_year = shape_info.year; // Specify the year

                                            var daysInMonth = new Date(shape_year, shape_month, 0).getDate();
                                            var firstDay = new Date(shape_year, shape_month - 1, 1).getDay();

                                            var cellSize = 50;
                                            var headerHeight = 60; // Adjusted header height for better layout

                                            canvas.width = cellSize * 7;
                                            canvas.height = headerHeight + cellSize * Math.ceil((daysInMonth + firstDay) / 7);

                                            // Draw header
                                            ctx.fillStyle = 'lightgray';
                                            ctx.fillRect(0, 0, canvas.width, headerHeight);

                                            ctx.fillStyle = 'black';
                                            ctx.font = '16px Arial';
                                            ctx.textAlign = 'center';

                                            ctx.fillText(`${monthNames[shape_month - 1]} 20XX`, canvas.width / 2, 30); // Adjusted y-coordinate for better layout

                                            // Draw day names
                                            ctx.fillStyle = 'black';
                                            ctx.font = '12px Arial';
                                            ctx.textAlign = 'center';
                                            var dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                                            for (var i = 0; i < 7; i++) {
                                                var x = i * cellSize + cellSize / 2;
                                                var y = headerHeight - 10; // Adjusted y-coordinate for better layout
                                                ctx.fillText(dayNames[i], x, y);
                                            }

                                            // Draw calendar cells
                                            ctx.font = '14px Arial';
                                            ctx.textAlign = 'center';
                                            for (var day = 1; day <= daysInMonth; day++) {
                                                var column = (day + firstDay - 1) % 7;
                                                var row = Math.floor((day + firstDay - 1) / 7);
                                                var x = column * cellSize + cellSize / 2;
                                                var y = headerHeight + row * cellSize + cellSize / 2;

                                                ctx.fillText(day, x, y);
                                            }

                                            // convertToImg(canvas, 'myImg');;
                                            </script>

                                    <?php
                                }
                            }
                            else if(in_array($sbtpcrow['id'], array('179', '259'))){
                                $randomString = generateIDString();
                                ?>
                                    <style>
                                        canvas {
                                            border: 1px solid black;
                                        }
                                    </style>
                                    <div class="content aft-heading-wrapper br-1 text-center p-md-4 p-0 mb-mb-4 mb-2">
                                        <canvas id="myCanvas-<?php echo $randomString; ?>" width="350" height="150"></canvas>
                                        <!-- <img id="myImg" width = "600" height="150"> -->
                                    </div>
                                    <script>
                                        // Get the canvas element and its context
                                        var canvas = document.getElementById("myCanvas-<?php echo $randomString; ?>");
                                        var ctx = canvas.getContext("2d");

                                        // Define the length of the metal rod in cm
                                        var rodLength = <?php echo json_encode($querow["correct_ans"]); ?>.split("cms")[0]; // Change this value as needed
                                        var scaleLength = 10;

                                        var pixelsPerCm = 32;
                                        var cmCoords = [];
                                        // var mmCoords = [];

                                        // Draw the ruler with cm markings and subdivisions
                                        ctx.fillStyle = "black";
                                        ctx.font = "10px Arial";
                                        var x;
                                        ctx.beginPath();
                                        for (var cm = 0; cm <= scaleLength; cm++) {
                                            x = cm * pixelsPerCm;
                                            ctx.moveTo(x + 5, 100);
                                            ctx.lineTo(x + 5, 115);
                                            ctx.fillText(cm, x + 5, 125);

                                            cmCoords.push(x + 5);

                                            for (var sub = 1; sub < 10; sub++) {
                                                var subX = x + sub * (pixelsPerCm / 10);
                                                ctx.moveTo(subX + 5, 100);
                                                ctx.lineTo(subX + 5, 110);

                                                // mmCoords.push(subX + 5);
                                            }
                                        }
                                        ctx.fillText("(cm)", x, 135);
                                        ctx.stroke();

                                        // Draw the metal rod horizontally on top of the ruler
                                        var rodY = 80; // Adjust the vertical position of the rod
                                        var rodWidth = rodLength * pixelsPerCm; // Width of the metal rod
                                        var minRodX = 5;
                                        var maxRodX = (scaleLength * pixelsPerCm) - (rodLength * pixelsPerCm);
                                        var filteredCms = cmCoords.filter(cms => cms <= maxRodX);
                                        // var filteredMms =mmCoords.filter(mms => mms <= maxRodX);

                                        var randomX = getRandomElementFromArray(filteredCms);
                                        // var randomX = minRodX + Math.random() * (maxRodX - minRodX);
                                        ctx.fillStyle = "red";
                                        ctx.fillRect(randomX, rodY, rodWidth, 10);

                                        ctx.setLineDash([2, 2]); // Adjust the values as needed for the desired dash pattern
                                        ctx.strokeStyle = "#FF2235";
                                        // Draw a dotted line from the front of the rod
                                        ctx.beginPath();
                                        ctx.moveTo(randomX, rodY);
                                        ctx.lineTo(randomX, rodY + 30);
                                        ctx.stroke();

                                        // Draw a dotted line from the end of the rod
                                        ctx.beginPath();
                                        ctx.moveTo(randomX + rodLength * pixelsPerCm, rodY );
                                        ctx.lineTo(randomX + rodLength * pixelsPerCm, rodY + 30);
                                        ctx.stroke();

                                        // Reset the line dash pattern to a solid line if needed
                                        ctx.setLineDash([]);

                                        function getRandomElementFromArray(arr) {
                                            const randomIndex = Math.floor(Math.random() * arr.length);
                                            return arr[randomIndex];
                                        }

                                        // convertToImg(canvas, 'myImg');;
                                        </script>
                                    
                                <?php
                            }
                            else if(in_array($sbtpcrow['id'], array('180'))) {
                                $randomString = generateIDString();
                                ?>
                           <style>
                                        canvas {
                                            border: 1px solid black;
                                        }
                                    </style>
                                    <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2">
                                        <canvas id="myCanvas-<?php echo $randomString; ?>" width="350" height="400"></canvas>
                                        <!-- <img id="myImg" width = "600" height="400"> -->
                                    </div>

                                    <script>
                                        var shape_info = <?php echo $querow["shape_info"]; ?>;
                                        var temperature = shape_info.temp; // Set the temperature value
                                        var rangeSelector = Math.floor(temperature / 100) + 1;
                                        temperature = temperature % 100;
                                        
                                        var subDivArray = [2, 5, 10];
                                        // Get the canvas element and its context
                                        var canvas = document.getElementById("myCanvas-<?php echo $randomString; ?>");
                                        var ctx = canvas.getContext("2d");

                                        // Draw the thermometer column
                                        var columnX = 100;
                                        var columnTopY = 20;
                                        var columnBottomY = 380;
                                        ctx.fillStyle = "grey";
                                        ctx.fillRect(columnX - 5, columnTopY, 10, columnBottomY - columnTopY);

                                        // Draw thermometer divisions and subdivisions
                                        ctx.font = "10px Arial";
                                        var numDivisions = 10; // Number of main divisions
                                        var numSubdivisions = shape_info.sub_division; // Number of subdivisions between each division
                                        var divisionHeight = (columnBottomY - columnTopY) / numDivisions;
                                        var subdivisionHeight = divisionHeight / numSubdivisions;
                                        var currentY = columnTopY;

                                        for (var i = 0; i <= numDivisions; i++) {
                                            ctx.beginPath();
                                            ctx.moveTo(columnX - 15, currentY);
                                            ctx.lineTo(columnX + 15, currentY);
                                            ctx.stroke();
                                            ctx.fillText(((numDivisions * rangeSelector) - i) * 10, columnX + 20, currentY + 3);

                                            for (var j = 1; j <= numSubdivisions; j++) {
                                                var subY = currentY + j * subdivisionHeight;
                                                ctx.beginPath();
                                                ctx.moveTo(columnX - 8, subY);
                                                ctx.lineTo(columnX + 8, subY);
                                                ctx.stroke();
                                            }

                                            currentY += divisionHeight;
                                        }

                                        // Draw thermometer bulb
                                        var bulbRadius = 20;
                                        var bulbCenterY = columnBottomY + bulbRadius;
                                        ctx.beginPath();
                                        ctx.arc(columnX, bulbCenterY, bulbRadius, 0, Math.PI, true);
                                        ctx.fillStyle = "red";
                                        ctx.fill();
                                        ctx.stroke();

                                        // Simulate temperature using mercury-like liquid
                                        var mercuryHeight = (temperature / 100) * (columnBottomY - columnTopY);
                                        ctx.fillStyle = "rgba(255, 0, 0, 0.7)";
                                        ctx.fillRect(columnX - 5, bulbCenterY - bulbRadius, 10, -mercuryHeight);

                                        ctx.fillStyle = "black";
                                        ctx.font = "16px Arial";
                                        ctx.fillText(`°${shape_info.unit}`, columnX + 50, 20);
                                        // convertToImg(canvas, 'myImg');;
                                    </script>

                                <?php
                            }

                            else if(in_array($sbtpcrow['id'], array('181', '182', '183', '184', '260'))) {
                                    $shape_info = json_decode($querow["shape_info"]);
                                    if($shape_info->type == "two_rulers"){
                                        $randomString = generateIDString();
                                    ?>
                                        <style>
                                            canvas {
                                                border: 1px solid black;
                                            }
                                        </style>
                                        <div class="content br-1 text-center p-md-4 p-1 mb-mb-4 mb-2 aft-heading-auto-height <?php echo $hmx220; ?>">
                                            <canvas id="myCanvas-<?php echo $randomString; ?>" width="340" height="150"></canvas>
                                        </div>

                                        <script>
                                            var shape_info = <?php echo $querow["shape_info"]; ?>;
                                            // Get the canvas element and its context
                                            var canvas = document.getElementById("myCanvas-<?php echo $randomString; ?>");
                                            var ctx = canvas.getContext("2d");

                                            // Define the lengths of the metal rods in cm
                                            var rodLength1 = shape_info.length_1; // Change these values as needed
                                            var rodLength2 = shape_info.length_2;
                                            var scaleLength = 10;

                                            // Set the scale for the ruler (1 cm = 50 pixels)
                                            var pixelsPerCm = 32;
                                            var mmCoords = [];
                                            var cmCoords = [];

                                            // Draw the ruler with cm markings and subdivisions
                                            ctx.fillStyle = "black";
                                            ctx.font = "10px Arial";
                                            var x;
                                            ctx.beginPath();
                                            for (var cm = 0; cm <= scaleLength; cm++) {
                                                x = cm * pixelsPerCm;
                                                ctx.moveTo(x + 5, 100);
                                                ctx.lineTo(x + 5, 115);
                                                ctx.fillText(cm, x + 5, 125);

                                                cmCoords.push(x + 5);

                                                // Draw subdivisions (0.1 cm)
                                                for (var sub = 1; sub < 10; sub++) {
                                                    var subX = x + sub * (pixelsPerCm / 10);
                                                    ctx.moveTo(subX + 5, 100);
                                                    ctx.lineTo(subX + 5, 110);

                                                    mmCoords.push(subX + 5);
                                                }
                                            }
                                            ctx.fillText("(cm)", x, 135);
                                            ctx.stroke();


                                            // Draw the metal rods horizontally on top of the ruler
                                            var rodY = 65; // Adjust the vertical position of the rods
                                            var rodWidth1 = rodLength1 * pixelsPerCm; // Width of the first metal rod
                                            var rodWidth2 = rodLength2 * pixelsPerCm; // Width of the second metal rod
                                            var minRodX = 5;
                                            var maxRodX1 = (scaleLength * pixelsPerCm) - rodWidth1;
                                            var maxRodX2 = (scaleLength * pixelsPerCm) - rodWidth2;

                                            var filteredCms1 = cmCoords.filter(cms => cms <= (maxRodX1));
                                            filteredCms1.length == 0 ?filteredCms1.push(cmCoords[0]) : '';
                                            var filteredMms1 = mmCoords.filter(mms => mms <= (maxRodX1));
                                            filteredMms1.length == 0 ? filteredMms1.push(mmCoords[0]) : "";

                                            var filteredCms2 = cmCoords.filter(cms => cms <= (maxRodX2));
                                            filteredCms2.length == 0 ? filteredCms2.push(cmCoords[0]) : '';
                                            var filteredMms2 = mmCoords.filter(mms => mms <= (maxRodX2));
                                            filteredMms2.length == 0 ?filteredMms2.push(mmCoords[0]) : '';

                                            <?php if(in_array($sbtpcrow['id'], array('260', '181'))) { ?>
                                            var randomX1 = getRandomElementFromArray(filteredCms1);
                                            var randomX2 = getRandomElementFromArray(filteredCms2);
                                            <?php } else { ?>
                                            var randomX1 = getRandomElementFromArray(filteredMms1);
                                            var randomX2 = getRandomElementFromArray(filteredMms2);
                                            <?php } ?>

                                            ctx.fillStyle = "#ff2235";
                                            ctx.fillRect(randomX1, rodY, rodWidth1, 10); // Draw the first rod

                                            // console.log(ctx);

                                            ctx.fillStyle = "#00a1de";
                                            ctx.fillRect(randomX2, rodY + 20, rodWidth2, 10); // Draw the second rod

                                            // console.log("Hello");

                                            var redRodEndX = 5 + rodWidth1;
                                            var blueRodEndX = 5 + rodWidth2;

                                            ctx.strokeStyle = "#FF2235"; // Color of the line
                                            ctx.setLineDash([2, 2]); // Adjust the values as needed for the desired dash pattern
                                            // Draw a dotted line from the front of the rod
                                            ctx.beginPath();
                                            ctx.moveTo(randomX1, rodY);
                                            ctx.lineTo(randomX1, rodY + 40);
                                            ctx.stroke();

                                            // Draw a dotted line from the end of the rod
                                            ctx.beginPath();
                                            ctx.moveTo(randomX1 + rodWidth1, rodY );
                                            ctx.lineTo(randomX1 + rodWidth1, rodY + 40);
                                            ctx.stroke();

                                            ctx.beginPath();
                                            ctx.moveTo(randomX2, rodY + 20);
                                            ctx.lineTo(randomX2, rodY + 40);
                                            ctx.stroke();

                                            // Draw a dotted line from the end of the rod
                                            ctx.beginPath();
                                            ctx.moveTo(randomX2 + rodWidth2, rodY + 20);
                                            ctx.lineTo(randomX2 + rodWidth2, rodY + 40);
                                            ctx.stroke();

                                            // Reset the line dash pattern to a solid line if needed
                                            ctx.setLineDash([]);

                                            // convertToImg(canvas, 'myImg');;

                                            function getRandomElementFromArray(arr) {
                                                const randomIndex = Math.floor(Math.random() * arr.length);
                                                return arr[randomIndex];
                                            }

                                        </script>

                                    <?php
                                    }

                                    else if($shape_info->type =="one_sided_weight" || $shape_info->type == "two_sided_weight") {
                                        $randomString = generateIDString();
                                        ?>
                                            <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 aft-heading-auto-height <?php echo $hmx220; ?>">
                                              <canvas id="seasawCanvas-<?php echo $randomString; ?>" width="350" height="100"></canvas>
                                              <!-- <img id="myImg" width = "600" height="200"> -->
                                            </div>

                                            <script>
                                                var shape_info = <?php echo $querow["shape_info"]; ?>;
                                                var left = shape_info.weights_left;
                                                var right = shape_info.weights_right;

                                                var canvas = document.getElementById('seasawCanvas-<?php echo $randomString; ?>');
                                                var ctx = canvas.getContext('2d');

                                                var seasawWidth = 300;
                                                var seasawHeight = 10;
                                                var seasawX = (canvas.width - seasawWidth) / 2;
                                                var seasawY = canvas.height - seasawHeight - 30;

                                                var fulcrumWidth = 20;
                                                var fulcrumHeight = 40;
                                                var fulcrumColor = '#888';
                                                var fulcrumX = seasawX + (seasawWidth - fulcrumWidth) / 2;
                                                var fulcrumY = seasawY + seasawHeight;

                                                var fulcrumTriangleSize = 40;

                                                var boxSize = 50;
                                                var boxColor = '#9b7653';
                                                var boxBorderColor = '#63462b';
                                                var boxX = seasawX + seasawWidth - boxSize;
                                                var boxY = seasawY - boxSize;

                                                var weightsLeft_temp = [
                                                    { x: boxX - seasawWidth + 145, y: boxY + 20, size: 30, color: '#ff5b5b', border: '#d63636' },
                                                    { x: boxX - seasawWidth + 100, y: boxY + 20, size: 30, color: '#8ae26a', border: '#60b845' },
                                                    { x: boxX - seasawWidth + 60, y: boxY + 20, size: 30, color: '#ad7cff', border: '#8543ff' }
                                                ];

                                                var weightsRight_temp = [
                                                    { x: boxX + boxSize - 40, y: boxY + 20, size: 30, color: '#68c1e3', border: '#2e98b2' },
                                                    { x: boxX + boxSize - 80, y: boxY + 20, size: 30, color: '#f5a623', border: '#c98216' },
                                                    { x: boxX + boxSize - 120, y: boxY + 20, size: 30, color: '#ffd54f', border: '#e0ab1e' }
                                                ];
                                                var weightsLeft = [];
                                                var weightsRight = [];

                                                for(var z = 0; z < left.length; z++) {
                                                    weightsLeft.push({...weightsLeft_temp[2 - z], ...left[z]});
                                                }

                                                for(var z = 0; z < right.length; z++) {
                                                    weightsRight.push({...weightsRight_temp[z], ...right[z]});
                                                }

                                                function drawSeasaw() {
                                                    // Draw the seasaw platform
                                                    ctx.fillStyle = '#ddd';
                                                    ctx.fillRect(seasawX, seasawY, seasawWidth, seasawHeight);

                                                    // Draw the weights on the left
                                                    for (var weight of weightsLeft) {
                                                        ctx.fillStyle = weight.color;
                                                        ctx.strokeStyle = weight.border;
                                                        ctx.lineWidth = 2;
                                                        ctx.fillRect(weight.x, weight.y, weight.size, weight.size);
                                                        ctx.strokeRect(weight.x, weight.y, weight.size, weight.size);

                                                        ctx.fillStyle = 'black';
                                                        ctx.font = '12px Arial';
                                                        ctx.textAlign = 'center';
                                                        ctx.fontWeight = 'bold';
                                                        ctx.fillText((weight.text.split(" ")[0] ? weight.text.split(" ")[0] : ""), weight.x + weight.size / 2, weight.y + weight.size / 2);
                                                        ctx.fillText((weight.text.split(" ")[1] ? weight.text.split(" ")[1] : ""), weight.x + weight.size / 2, weight.y + weight.size / 2 + 10);
                                                    }


                                                    // Draw the fulcrum triangle
                                                    ctx.beginPath();
                                                    ctx.moveTo(fulcrumX - fulcrumTriangleSize / 2, fulcrumY - fulcrumHeight + 80);
                                                    ctx.lineTo(fulcrumX + fulcrumTriangleSize / 2, fulcrumY - fulcrumHeight + 80);
                                                    ctx.lineTo(fulcrumX, fulcrumY - fulcrumHeight - fulcrumTriangleSize + 80);
                                                    ctx.closePath();
                                                    ctx.fillStyle = fulcrumColor;
                                                    ctx.fill();

                                                    // Draw the weights on the right
                                                    for (var weight of weightsRight) {
                                                        ctx.fillStyle = weight.color;
                                                        ctx.strokeStyle = weight.border;
                                                        ctx.lineWidth = 2;
                                                        ctx.fillRect(weight.x, weight.y, weight.size, weight.size);
                                                        ctx.strokeRect(weight.x, weight.y, weight.size, weight.size);

                                                        ctx.fillStyle = 'black';
                                                        ctx.font = '12px Arial';
                                                        ctx.textAlign = 'center';
                                                        ctx.fontWeight = 'bold';
                                                        ctx.fillText((weight.text.split(" ")[0] ? weight.text.split(" ")[0] : ""), weight.x + weight.size / 2, weight.y + weight.size / 2);
                                                        ctx.fillText((weight.text.split(" ")[1] ? weight.text.split(" ")[1] : ""), weight.x + weight.size / 2, weight.y + weight.size / 2 + 10);
                                                    }
                                                }

                                                drawSeasaw();
                                                // convertToImg(canvas, 'myImg');;
                                            </script>
                                        <?php
                                    }
                                    else if($shape_info->type =="one_sided_weight_tilted" || $shape_info->type == "two_sided_weight_tilted") {
                                        $randomString = generateIDString();
                                        ?>
                                            <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 aft-heading-auto-height <?php echo $hmx220; ?>">
                                                <canvas id="seasawCanvas-<?php echo $randomString; ?>" width="350" height="100"></canvas>
                                                <!-- <img id="myImg" width = "600" height="200"> -->
                                            </div>

                                            <script>
                                                var shape_info = <?php echo $querow["shape_info"]; ?>;;
                                                var left = shape_info.weights_left;
                                                var right = shape_info.weights_right;

                                                var canvas = document.getElementById('seasawCanvas-<?php echo $randomString; ?>');
                                                var ctx = canvas.getContext('2d');

                                                var seasawWidth = 300;
                                                var seasawHeight = 10;
                                                var seasawX = (canvas.width - seasawWidth) / 2;
                                                var seasawY = canvas.height - seasawHeight - 30;

                                                var fulcrumWidth = 10;
                                                var fulcrumHeight = 40;
                                                var fulcrumColor = '#888';
                                                var fulcrumX = seasawX + (seasawWidth - fulcrumWidth) / 2;
                                                var fulcrumY = seasawY + seasawHeight;

                                                var fulcrumTriangleSize = 40;

                                                var boxSize = 50;
                                                var boxColor = '#9b7653';
                                                var boxBorderColor = '#63462b';
                                                var boxX = seasawX + seasawWidth - boxSize;
                                                var boxY = seasawY - boxSize;

                                                var weightsLeft_temp = [
                                                    { x: boxX - seasawWidth + 145, y: boxY + 20, size: 30, color: '#ff5b5b', border: '#d63636' },
                                                    { x: boxX - seasawWidth + 100, y: boxY + 20, size: 30, color: '#8ae26a', border: '#60b845' },
                                                    { x: boxX - seasawWidth + 60, y: boxY + 20, size: 30, color: '#ad7cff', border: '#8543ff' }
                                                ];

                                                var weightsRight_temp = [
                                                    { x: boxX + boxSize - 40, y: boxY + 20, size: 30, color: '#68c1e3', border: '#2e98b2' },
                                                    { x: boxX + boxSize - 80, y: boxY + 20, size: 30, color: '#f5a623', border: '#c98216' },
                                                    { x: boxX + boxSize - 120, y: boxY + 20, size: 30, color: '#ffd54f', border: '#e0ab1e' }
                                                ];

                                                var weightsLeft = [];
                                                var weightsRight = [];

                                                for (var z = 0; z < left.length; z++) {
                                                    weightsLeft.push({ ...weightsLeft_temp[2 - z], ...left[z] });
                                                }

                                                for (var z = 0; z < right.length; z++) {
                                                    weightsRight.push({ ...weightsRight_temp[z], ...right[z] });
                                                }

                                                var tiltFactor = 0.005; // Adjust the tilt factor for a slight tilt

                                                function calculateTilt() {
                                                    var leftWeight = weightsLeft.reduce((sum, weight) => sum + weight.weight, 0);
                                                    var rightWeight = weightsRight.reduce((sum, weight) => sum + weight.weight, 0);

                                                    // Calculate the difference in weights
                                                    var weightDifference = rightWeight - leftWeight;

                                                    // Calculate the tilt offset based on the weight difference
                                                    var tiltOffset = weightDifference * tiltFactor;

                                                    console.log(tiltOffset)

                                                    return tiltOffset > 0 ? 0.1 : tiltOffset == 0 ? 0 : -0.1;
                                                }

                                                function drawSeasaw() {
                                                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                                                    var tiltOffset = calculateTilt();
                                                    var midSeasawX = seasawX + seasawWidth / 2;

                                                    // Draw the seasaw platform with the updated tilt
                                                    ctx.save();
                                                    ctx.translate(midSeasawX, seasawY + seasawHeight / 2);
                                                    ctx.rotate(tiltOffset);
                                                    ctx.fillStyle = '#ddd';
                                                    ctx.fillRect(-seasawWidth / 2, -seasawHeight / 2, seasawWidth, seasawHeight);
                                                    ctx.restore();

                                                    // Draw the fulcrum triangle (unchanged)
                                                    ctx.beginPath();
                                                    ctx.moveTo(fulcrumX - fulcrumTriangleSize / 2, fulcrumY - fulcrumHeight + 80);
                                                    ctx.lineTo(fulcrumX + fulcrumTriangleSize / 2, fulcrumY - fulcrumHeight + 80);
                                                    ctx.lineTo(fulcrumX, fulcrumY - fulcrumHeight - fulcrumTriangleSize + 80);
                                                    ctx.closePath();
                                                    ctx.fillStyle = fulcrumColor;
                                                    ctx.fill();

                                                    // Draw the weights on the left
                                                    for (var weight of weightsLeft) {
                                                        var weightX = weight.x - (seasawX + seasawWidth / 2);
                                                        var weightY = weight.y - (seasawY + seasawHeight / 2);
                                                        var rotatedX = weightX * Math.cos(tiltOffset) - weightY * Math.sin(tiltOffset);
                                                        var rotatedY = weightX * Math.sin(tiltOffset) + weightY * Math.cos(tiltOffset);
                                                        var finalX = midSeasawX + rotatedX;
                                                        var finalY = seasawY + seasawHeight / 2 + rotatedY;

                                                        ctx.fillStyle = weight.color;
                                                        ctx.strokeStyle = weight.border;
                                                        ctx.lineWidth = 2;
                                                        ctx.fillRect(finalX, finalY, weight.size, weight.size);
                                                        ctx.strokeRect(finalX, finalY, weight.size, weight.size);

                                                        ctx.fillStyle = 'black';
                                                        ctx.font = '12px Arial';
                                                        ctx.textAlign = 'center';
                                                        ctx.fontWeight = 'bold';
                                                        ctx.fillText((weight.text.split(" ")[0] ? weight.text.split(" ")[0] : ""), finalX + weight.size / 2, finalY + weight.size / 2);
                                                        ctx.fillText((weight.text.split(" ")[1] ? weight.text.split(" ")[1] : ""), finalX + weight.size / 2, finalY + weight.size / 2 + 10);
                                                    }

                                                    // Draw the weights on the right
                                                    for (var weight of weightsRight) {
                                                        var weightX = weight.x - (seasawX + seasawWidth / 2);
                                                        var weightY = weight.y - (seasawY + seasawHeight / 2);
                                                        var rotatedX = weightX * Math.cos(tiltOffset) - weightY * Math.sin(tiltOffset);
                                                        var rotatedY = weightX * Math.sin(tiltOffset) + weightY * Math.cos(tiltOffset);
                                                        var finalX = midSeasawX + rotatedX;
                                                        var finalY = seasawY + seasawHeight / 2 + rotatedY;

                                                        ctx.fillStyle = weight.color;
                                                        ctx.strokeStyle = weight.border;
                                                        ctx.lineWidth = 2;
                                                        ctx.fillRect(finalX, finalY, weight.size, weight.size);
                                                        ctx.strokeRect(finalX, finalY, weight.size, weight.size);

                                                        ctx.fillStyle = 'black';
                                                        ctx.font = '12px Arial';
                                                        ctx.textAlign = 'center';
                                                        ctx.fontWeight = 'bold';
                                                        ctx.fillText((weight.text.split(" ")[0] ? weight.text.split(" ")[0] : ""), finalX + weight.size / 2, finalY + weight.size / 2 );
                                                        ctx.fillText((weight.text.split(" ")[1] ? weight.text.split(" ")[1] : ""), finalX + weight.size / 2, finalY + weight.size / 2 + 10);
                                                    }
                                                }

                                                drawSeasaw();
                                                // convertToImg(canvas, 'myImg');;
                                            </script>
                                        <?php
                                    }
                            }
                            else if(in_array($sbtpcrow['id'], array('214', '215', '216'))) {
                                $shape_info = json_decode($querow["shape_info"]);

                                ?>

                                <style>
                                    .container-dip{
                                        page-break-inside:avoid;
                                    }
                                </style>
                                
                                <div class="container-dip content aft-heading-wrapper br-1 text-center p-md-2 p-0 mb-mb-4 mb-2 d-flex align-items-center justify-content-center">
                                    <img 
                                        src="<?php echo $baseurl; ?>/uploads/mirror_image/<?php echo $shape_info->image ?>"
                                        style="width: 100px; height: 100px;">
                                </div>
                                
                                <?php
                            }
                            else if(in_array($sbtpcrow['id'], array('237'))) {
                                $shape_info = json_decode($querow["shape_info"]);
                                if($shape_info->type == "protractor") {
                                    $randomString = generateIDString();
                                    ?>
                                        <div class="content br-1 text-center p-0 aft-heading-auto-height <?php echo $hmx220; ?>">
                                            <canvas id="protractorCanvas-<?php echo $randomString; ?>" class="mt-1" width="330" height="150"></canvas>
                                        </div>

                                        <script>
                                            var canvas = document.getElementById('protractorCanvas-<?php echo $randomString; ?>');
                                            var ctx = canvas.getContext('2d');

                                            // Center coordinates of the canvas
                                            var centerX = canvas.width / 2;
                                            var centerY = canvas.height / 1.05;

                                            // Function to draw the protractor
                                            function drawProtractor() {
                                                // Clear the canvas
                                                ctx.clearRect(0, 0, canvas.width, canvas.height);

                                                // Draw the protractor
                                                ctx.strokeStyle = '#000';
                                                ctx.lineWidth = 2;
                                                ctx.beginPath();

                                                // Draw the protractor arc
                                                ctx.arc(centerX, centerY, 120, 0, Math.PI, true); // Use 'true' to draw it upside down
                                                ctx.stroke();

                                                // Draw the center dot
                                                ctx.beginPath();
                                                ctx.arc(centerX, centerY, 5, 0, Math.PI * 2);
                                                ctx.fillStyle = '#000';
                                                ctx.fill();

                                                // Draw angle markings and subdivisions
                                                for (let angle = 0; angle <= 180; angle += 2) {
                                                    var radians = (angle * Math.PI) / 180;
                                                    var radius = 110;
                                                    var x1 = centerX + Math.cos(radians) * radius;
                                                    var y1 = centerY - Math.sin(radians) * radius; // Subtract to make it upright
                                                    var x2 = centerX + Math.cos(radians) * (radius + (angle % 10 === 0 ? 20 : 10));
                                                    var y2 = centerY - Math.sin(radians) * (radius + (angle % 10 === 0 ? 20 : 10)); // Subtract to make it upright

                                                    ctx.beginPath();
                                                    ctx.moveTo(x1, y1);
                                                    ctx.lineTo(x2, y2);
                                                    ctx.stroke();

                                                    if (angle % 10 === 0) {
                                                        ctx.font = '10px Arial';
                                                        ctx.fillStyle = '#000';
                                                        ctx.fillText(`${angle}°`, (x2 * 1.08) - 25, y2);
                                                    } else if (angle % 5 === 0) {
                                                        var x3 = centerX + Math.cos(radians) * (radius + 15); // Adjust the length
                                                        var y3 = centerY - Math.sin(radians) * (radius + 15); // Adjust the length
                                                        ctx.beginPath();
                                                        ctx.moveTo(x1, y1);
                                                        ctx.lineTo(x3, y3);
                                                        ctx.stroke();
                                                    }
                                                }
                                            }

                                            // Function to measure the angle
                                            function measureAngle() {
                                                var inputAngle = <?php echo json_encode($querow["correct_ans"]); ?>.split("°")[0];
                                                if (isNaN(inputAngle) || inputAngle < 0 || inputAngle > 180) {
                                                    alert('Please enter a valid angle between 0 and 180 degrees.');
                                                    return;
                                                }

                                                // Clear previous measurements
                                                ctx.clearRect(0, 0, canvas.width, canvas.height);

                                                // Redraw the protractor
                                                drawProtractor();

                                                // Find the closest division to the input angle
                                                let closestDivision = inputAngle;

                                                // Draw the measured angle
                                                var radians = (closestDivision * Math.PI) / 180;
                                                var x1 = centerX;
                                                var y1 = centerY;
                                                var x2 = centerX + Math.cos(radians) * 120; // Make it touch a division
                                                var y2 = centerY - Math.sin(radians) * 120; // Make it touch a division

                                                ctx.strokeStyle = 'red';
                                                ctx.beginPath();
                                                ctx.moveTo(x1, y1);
                                                ctx.lineTo(x2, y2);
                                                ctx.stroke();

                                                // Calculate the base of the angle
                                                var baseLength = 30; // Adjust the length as needed
                                                var x3 = centerX + Math.cos(radians + Math.PI / 2) * baseLength;
                                                var y3 = centerY - Math.sin(radians + Math.PI / 2) * baseLength;
                                                var x4 = x2 + Math.cos(radians + Math.PI / 2) * baseLength;
                                                var y4 = y2 - Math.sin(radians + Math.PI / 2) * baseLength;

                                                ctx.strokeStyle = 'red';
                                                ctx.beginPath();
                                                ctx.moveTo(centerX, centerY);
                                                ctx.lineTo(centerX + 120, centerY); // Adjust the length as needed
                                                ctx.stroke();

                                            
                                            }

                                            // Initial drawing
                                            drawProtractor();
                                            measureAngle()
                                        </script>
                                    <?php
                                }
                                else if($shape_info->type == "determine") {
                                    $randomString = generateIDString();
                                    ?>
                                    <div class="content br-1 text-center p-md-4 p-0 mb-mb-4 mb-2 aft-heading-auto-height <?php echo $hmx220; ?>">
                                            <canvas id="protractorCanvas-<?php echo $randomString; ?>" width="300" height="100"></canvas>
                                        </div>

                                        <script>
                                            var canvas = document.getElementById('protractorCanvas-<?php echo $randomString; ?>');
                                            var ctx = canvas.getContext('2d');

                                            // Center coordinates of the canvas
                                            var centerX = <?php echo $shape_info->angle; ?> > 90 ? canvas.width /  2 : canvas.width / 3;
                                            var centerY = canvas.height / 1.25;

                                            // Function to measure the angle
                                            function measureAngle() {
                                                var inputAngle = <?php echo $shape_info->angle; ?>;
                                                if (isNaN(inputAngle) || inputAngle < 0 || inputAngle > 180) {
                                                    alert('Please enter a valid angle between 0 and 180 degrees.');
                                                    return;
                                                }

                                                // Clear previous measurements
                                                ctx.clearRect(0, 0, canvas.width, canvas.height);

                                                // Find the closest division to the input angle
                                                let closestDivision = inputAngle;

                                                // Draw the measured angle
                                                var radians = (closestDivision * Math.PI) / 180;
                                                var x1 = centerX;
                                                var y1 = centerY;
                                                var x2 = centerX + Math.cos(radians) * 250; // Make it touch a division
                                                var y2 = centerY - Math.sin(radians) * 250; // Make it touch a division

                                                ctx.strokeStyle = 'red';
                                                ctx.beginPath();
                                                ctx.moveTo(x1, y1);
                                                ctx.lineTo(x2, y2);
                                                ctx.stroke();

                                                // Calculate the base of the angle
                                                var baseLength = 30; // Adjust the length as needed
                                                var x3 = centerX + Math.cos(radians + Math.PI / 2) * baseLength;
                                                var y3 = centerY - Math.sin(radians + Math.PI / 2) * baseLength;
                                                var x4 = x2 + Math.cos(radians + Math.PI / 2) * baseLength;
                                                var y4 = y2 - Math.sin(radians + Math.PI / 2) * baseLength;

                                                ctx.strokeStyle = 'red';
                                                ctx.beginPath();
                                                ctx.moveTo(centerX, centerY);
                                                ctx.lineTo(centerX + 100, centerY); // Adjust the length as needed
                                                ctx.stroke();

                                                var angleArc = <?php echo $shape_info->angle; ?>; // Set the angle in degrees (anticlockwise)

                                                ctx.strokeStyle = 'red';
                                                ctx.lineWidth = 1;
                                                ctx.beginPath();
                                                ctx.arc(x1, y1, 10, 0, (2 * Math.PI) - (angleArc * Math.PI / 180), true); // Set anticlockwise to true
                                                ctx.stroke();
                                            
                                            }
                                            measureAngle()
                                        </script>
                                    <?php
                                } else if($shape_info->type == "clock") {
                                    $randomString = generateIDString();
                                    ?>
                                        <div class="content br-1 text-center p-0 mb-mb-4 mb-2">
                                            <canvas id="clockCanvas-<?php echo $randomString; ?>" width="160" height="165"></canvas>
                                        </div>

                                        <script>
                                            function drawClock(hour, minute) {
                                                var canvas = document.getElementById("clockCanvas-<?php echo $randomString; ?>");
                                                var ctx = canvas.getContext("2d");
                                                var radius = 75;
                                                ctx.clearRect(0, 0, canvas.width, canvas.height);

                                                // Reset the transformation matrix
                                                ctx.setTransform(1, 0, 0, 1, 0, 0);

                                                // ctx.translate(radius, radius);
                                                ctx.translate(canvas.width / 2, canvas.height / 2);
                                                drawFace(ctx, radius);
                                                drawNumbers(ctx, radius);
                                                drawTime(ctx, radius, hour, minute);

                                                // Calculate and mark the angle between the hands
                                                markAngle(ctx, hour, minute, radius);
                                            }

                                            function drawFace(ctx, radius) {
                                                ctx.beginPath();
                                                ctx.arc(0, 0, radius, 0, 2 * Math.PI);
                                                ctx.fillStyle = 'white';
                                                ctx.fill();
                                                ctx.strokeStyle = '#333'; // Adjust the stroke color
                                                ctx.lineWidth = radius * 0.1;
                                                ctx.stroke();
                                                ctx.beginPath();
                                                ctx.fillStyle = '#333';
                                                ctx.fill();
                                            }

                                            function drawNumbers(ctx, radius) {
                                                var ang;
                                                var num;
                                                ctx.font = "12px arial";
                                                ctx.textBaseline = "middle";
                                                ctx.textAlign = "center";
                                                for (num = 1; num < 13; num++) {
                                                    ang = num * Math.PI / 6;
                                                    ctx.rotate(ang);
                                                    ctx.translate(0, -radius * 0.85);
                                                    ctx.rotate(-ang);
                                                    ctx.fillText(num.toString(), 0, 0);
                                                    ctx.rotate(ang);
                                                    ctx.translate(0, radius * 0.85);
                                                    ctx.rotate(-ang);
                                                }
                                            }

                                            function drawTime(ctx, radius, hour, minute) {
                                                hour = hour % 12;
                                                hour = (hour * Math.PI / 6) + (minute * Math.PI / (6 * 60));
                                                drawHand(ctx, hour, radius * 0.5, radius * 0.07);

                                                minute = (minute * Math.PI / 30);
                                                drawHand(ctx, minute, radius * 0.8, radius * 0.07);
                                            }

                                            function drawHand(ctx, pos, length, width) {
                                                ctx.beginPath();
                                                ctx.lineWidth = width / 2;
                                                ctx.lineCap = "round";
                                                ctx.moveTo(0, 0);
                                                ctx.rotate(pos);
                                                ctx.lineTo(0, -length);
                                                ctx.stroke();
                                                ctx.rotate(-pos);
                                            }

                                            function markAngle(ctx, hours, minutes, radius) {
                                                // Calculate angles for the hour and minute hands
                                                const hourAngle = (270 + (hours % 12) * 30 + (minutes / 60) * 30) * (Math.PI / 180); // 360 degrees divided by 12 hours
                                                const minuteAngle = (270 + minutes * 6) * (Math.PI / 180); // 360 degrees divided by 60 minutes

                                                // Calculate the angle between the hour and minute hands
                                                let angleBetweenHands = Math.abs(hourAngle - minuteAngle);
                                                if (angleBetweenHands > Math.PI) {
                                                    angleBetweenHands = 2 * Math.PI - angleBetweenHands; // Ensure the smaller angle is used
                                                }

                                                // for one angle
                                                const minAngle = Math.min(hourAngle, minuteAngle);
                                                
                                                //for other angle
                                                const maxAngle = Math.max(hourAngle, minuteAngle);

                                                // Calculate the starting and ending angles for the arc
                                                //const startAngle = minAngle
                                                //const endAngle = midpointAngle + angleBetweenHands / 2;

                                                // Draw a marker for the angle between the hands
                                                ctx.strokeStyle = "black"; // You can change the marker color
                                                ctx.lineWidth = 3;
                                                ctx.beginPath();
                                                ctx.arc(0, 0, radius * 0.15, minAngle, maxAngle);
                                                ctx.stroke();
                                            }




                                            function updateClock() {
                                                var hour = <?php echo $shape_info->hours; ?>;
                                                var minute = <?php echo $shape_info->minutes; ?>;
                                                drawClock(hour, minute);
                                            }

                                            // Initial drawing of the clock
                                            updateClock();
                                        </script>
                                    <?php
                                }
                            } else if(in_array($sbtpcrow['id'], array('241', '242'))) {
                                $word = $querow['shape_info'];
                                $word_arr = str_split($word);
                                ?>
                                <div class="content br-1 text-center p-4 mb-mb-4 mb-2">
                                    <?php foreach($word_arr as $letter) { ?>
                                        <img src="<?php echo $baseurl ?>uploads/alphabets/<?php echo $letter . ".svg"; ?>" style="max-height: 60px; max-width: 40px; height: 60px; width: 40px; margin: 0;" alt="<?php echo $letter; ?> img">  
                                    <?php } ?>
                                </div>
                                <?php
                            } else if(in_array($sbtpcrow['id'], array('264', '265', '266', '267', '268'))) {
                                $randomString = generateIDString();

                                $shape_info = json_decode($querow['shape_info']);

                                $num_sides = 3;
                                ?>
                                <style>
                                    <?php if($page == '') { ?> 
                                        .p-4 {
                                            padding: 2rem;
                                        }
                                    <?php } ?>
                                </style>
                                <div class="content br-1 text-center p-4 mb-mb-4 mb-2">
                                <?php 
                                    for($num_count = 1; $num_count <= $num_sides; $num_count++) { ?>
                                        <canvas id="triangleCanvas<?php echo $num_count; ?>-<?php echo $randomString; ?>" width="100" height="100"></canvas>
                                <?php } ?>
                                </div>

                                <script>
                                    function drawTriangle(canvasId, vertices, val_index) {
                                        // Get the canvas and its context
                                        var canvas = document.getElementById(canvasId);
                                        var context = canvas.getContext("2d");

                                        // Draw the triangle
                                        context.beginPath();
                                        context.moveTo(vertices[0].x, vertices[0].y);
                                        
                                        for (var i = 1; i < vertices.length; i++) {
                                            context.lineTo(vertices[i].x, vertices[i].y);
                                        }
                                        
                                        context.closePath();
                                        context.stroke();

                                        var values = <?php echo json_encode($shape_info->figures); ?>;

                                        // Label the vertices
                                        context.font = "12px Arial";
                                        context.fillStyle = "#000";
                                        vertices.forEach((vertex, index) => {
                                            context.fillText(values[val_index][index], vertex.x * 1.07 - 11, vertex.y * 1.15 - 2);
                                        });

                                        // Calculate and label the center of the triangle
                                        var centerX = 0;
                                        var centerY = 0;

                                        for (var i = 0; i < vertices.length; i++) {
                                            centerX += vertices[i].x;
                                            centerY += vertices[i].y;
                                        }

                                        centerX /= vertices.length;
                                        centerY /= vertices.length;
                                        context.fillText(values[val_index][vertices.length], centerX - 10, centerY);
                                    }

                                    // Define the vertices for each triangle

                                    <?php if($shape_info->shape == 'triangle') { ?>
                                    var vertices1 = [
                                        { x: 50, y: 10 },
                                        { x: 85, y: 85 },
                                        { x: 15, y: 85 },
                                    ];
                                    <?php } else if($shape_info->shape == 'square') { ?> 
                                        var vertices1 = [
                                        { x: 20, y: 10 },
                                        { x: 85, y: 10 },
                                        { x: 85, y: 85 },
                                        { x: 20, y: 85 },
                                    ];
                                    <?php } ?>

                                    <?php for($num_count = 1; $num_count <= $num_sides; $num_count++) { ?> 
                                        drawTriangle("triangleCanvas<?php echo $num_count; ?>-<?php echo $randomString; ?>", vertices1, <?php echo $num_count - 1; ?>);
                                    <?php } ?>

                                </script>
                                <?php
                            }

                            // -- end dipanjan changes
                        }
                            ?>

                            