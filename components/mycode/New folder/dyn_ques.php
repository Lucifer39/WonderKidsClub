<script>
    function convertToImg(canvas_func, myImg) {
        const imageDataURL = canvas_func.toDataURL();

        // Create an <img> element and set its src attribute to the data URL
        const imgElement = document.getElementById(myImg);
        imgElement.src = imageDataURL;

        canvas_func.remove();
    }
</script>
<?php 

if($sbtpcrow['id'] == '13' && $querow['type'] == '2' || $sbtpcrow['id'] == '13' && $querow['type'] == '3' || $sbtpcrow['id'] == '38' && $querow['type'] == '2' || $sbtpcrow['id'] == '38' && $querow['type'] == '3') {  ?>
                            <div class="content br-1 text-center p-3 mb-4">
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
                            <?php } elseif($sbtpcrow['id'] == '25' || $sbtpcrow['id'] == '26' || $sbtpcrow['id'] == '29' || $sbtpcrow['id'] == '30') { ?>
                                <div class="content br-1 text-center p-4 mb-4">
                                <?php 
                                $obj1 = [];
                                //Objects Img 01
                                for($i=0; $i<$querow['opt_a'];$i++) { 
                                    $obj1[]= "<img src='".$baseurl.$_SESSION['color_shape_1']."' style='height:80px;max-width:80px;object-fit:contain'>";
                                }

                                $obj2 = [];
                                //Objects Img 02
                                for($i=0; $i<$querow['opt_b'];$i++) { 
                                    $obj2[]= "<img src='".$baseurl.$_SESSION['color_shape_2']."' style='height:80px;max-width:80px;object-fit:contain'>";
                                }

                                $obj3 = [];
                                //Objects Img 03
                                for($i=0; $i<$querow['opt_c'];$i++) { 
                                    $obj3[]= "<img src='".$baseurl.$_SESSION['color_shape_3']."' style='height:80px;max-width:80px;object-fit:contain'>";
                                }

                                $obj4 = [];
                                //Objects Img 04
                                for($i=0; $i<$querow['opt_d'];$i++) { 
                                    $obj4[]= "<img src='".$baseurl.$_SESSION['color_shape_4']."' style='height:80px;max-width:80px;object-fit:contain'>";
                                }
                                
                                
                                $mergedArray = array_merge($obj1, $obj2, $obj3, $obj4);
                                shuffle($mergedArray);


                                foreach ($mergedArray as $element) { echo $element; }
                                ?>
                            </div>
                            <?php } elseif($sbtpcrow['id'] == '31' 
                                        || $sbtpcrow['id'] == '33' 
                                        || $sbtpcrow['id'] == '192' 
                                        || $sbtpcrow['id'] == '193'
                                        || $sbtpcrow['id'] == '194' 
                                        || $sbtpcrow['id'] == '195'
                                        || $sbtpcrow['id'] == '196') { ?>
                                <div class="content br-1 text-center p-4 mb-4">
                                    <?php $image_folder = ''.$pgLand.'uploads/money/'.$querow['type'].'/';
                               $image_name = $querow['correct_ans'];
                               $image_extensions = array('jpg', 'jpeg', 'png', 'gif');

                                foreach ($image_extensions as $extension) {
                                $filename = $image_name . '.' . $extension;
                                if (file_exists($image_folder . $filename)) {
                                    // Do something with the image file, e.g. display it:
                                    echo '<img src="'.$baseurl.$image_folder.$filename.'" height="130" alt="Image" />';
                                    break; // exit loop if image is found
                                }
                                } ?>
                                </div> 
                                <?php } elseif(in_array($sbtpcrow['id'], ['34', '35', '197', '198', '199', '200', '201'])) { ?>
                                <div class="content br-1 text-center p-4 mb-4">
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
                                        if (file_exists($image_folder . $filename)) {
                                            echo '<img src="'.$baseurl.$image_folder.$filename.'" height="130" alt="Image" />';
                                            break;
                                        }
                                        }
                                    }

                                    ?>
                                </div>                                
                            <?php }

                            //dipanjan changes
                            else if($sbtpcrow['id'] == '62' || $sbtpcrow['id'] == '63' || $sbtpcrow['id'] == '64' || $sbtpcrow['id'] == '65') {
                                ?>
                                <style>
                                        .abacus-container-dip{
                                            display: flex;
                                            flex-direction: column;
                                            justify-content: center;
                                            align-items: center;
                                            /* height: 100vh; */
                                        }
                                      .abacus {
                                        display: flex;
                                        justify-content: center;
                                        align-items: flex-end; /* Updated alignment to bottom */
                                        height: 250px;
                                        border: 5px solid black;
                                        width: 300px;
                                        padding: 0rem 0 0.55rem 0;
                                        margin-bottom: 2rem;
                                    }

                                    .rod {
                                        display: flex;
                                        flex-direction: column-reverse; /* Reversed the order of beads */
                                        align-items: center;
                                        margin: 0 20px;
                                        height: 100%;
                                        background-color: black;
                                        width: 1px;
                                    }

                                    .beads {
                                        width: 15px;
                                        height: 15px;
                                        border-radius: 50%;
                                        background-color: red;
                                        margin: 4px;
                                        transform: translateY(100%); /* Initially slide beads down */
                                        transition: transform 0.3s ease; /* Added transition for smooth sliding */
                                    }

                                    .active {
                                        transform: translateY(0%); /* Slide beads up when active */
                                        background-color: red !important;
                                    }

                                    .place-values {
                                        display: flex;
                                        justify-content: space-evenly;
                                        width: 300px;
                                        margin-top: -15px;
                                    }
                                </style>

                                <div class="abacus-container-dip content br-1 text-center p-4 mb-4">
                                    <div class="abacus" id="abacus"></div>
                                    <div class="place-values"></div>
                                </div>

                                    <script>
                                        const abacusContainer = document.getElementById('abacus');
                                        const beadsPerRod = 9;
                                        const numberOfRods = 7;

                                        generateAbacus();
                                        generatePlaceValues();

                                        function generatePlaceValues() {
                                                const placeValuesContainer = document.querySelector('.place-values');

                                                const placeValueLabels = ['TL', 'L', 'TTh', 'Th', 'H', 'T', 'O'];

                                                for (let i = 0; i < numberOfRods; i++) {
                                                const placeValue = document.createElement('div');
                                                placeValue.className = 'place-value';
                                                placeValue.textContent = placeValueLabels[i];
                                                placeValuesContainer.appendChild(placeValue);
                                            }
                                        }

                                        function generateAbacus() {
                                        for (let i = 0; i < numberOfRods; i++) {
                                            const rod = document.createElement('div');
                                            rod.className = 'rod';

                                            for (let j = 0; j < beadsPerRod; j++) {
                                            const bead = document.createElement('div');
                                            bead.className = 'beads';
                                            rod.appendChild(bead);
                                            }

                                            abacusContainer.appendChild(rod);
                                        }
                                        }

                                        const beads = document.querySelectorAll('.beads');
                                        const numberInput = document.getElementById('abacus-input');
                                        // numberInput.type = 'number';
                                        // numberInput.id = 'numberInput';
                                        updateAbacus(<?php echo json_encode($querow['correct_ans']) ?>);
                                        // abacusContainer.prepend(numberInput);

                                        function updateAbacus(numberInput) {
                                            resetAbacus();
                                            const number = parseInt(numberInput);
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
                                            const ones = number % 10;
                                            const tens = Math.floor((number / 10) % 10);
                                            const hundreds = Math.floor((number / 100) % 10);
                                            const thousands = Math.floor((number / 1000) % 10);
                                            const tenThousands = Math.floor((number / 10000) % 10);
                                            const hundredThousands = Math.floor((number / 100000) % 10);
                                            const millions = Math.floor((number / 1000000) % 10);

                                            moveBeadsInRod('.rod:nth-child(7)', ones);
                                            moveBeadsInRod('.rod:nth-child(6)', tens);
                                            moveBeadsInRod('.rod:nth-child(5)', hundreds);
                                            moveBeadsInRod('.rod:nth-child(4)', thousands);
                                            moveBeadsInRod('.rod:nth-child(3)', tenThousands);
                                            moveBeadsInRod('.rod:nth-child(2)', hundredThousands);
                                            moveBeadsInRod('.rod:nth-child(1)', millions);
                                        }


                                        function moveBeadsInRod(rodSelector, count) {
                                            const beadsInRod = document.querySelectorAll(rodSelector + ' .beads');
                                            const numBeads = beadsInRod.length;

                                            beadsInRod.forEach(bead => {
                                                bead.style.transform = 'translateY(100%)'; // Move all beads down by default
                                            });

                                            if (count > numBeads) {
                                                // If count is greater than the number of beads, move all beads to the top
                                                beadsInRod.forEach(bead => {
                                                bead.style.transform = 'translateY(-150%)';
                                                bead.classList.add("active");
                                                });
                                            } else {
                                                // Move 'count' number of beads to the top
                                                for (let i = numBeads - 1; i >= numBeads - count; i--) {
                                                beadsInRod[i].style.transform = 'translateY(-150%)';
                                                beadsInRod[i].classList.add("active");

                                                }
                                            }
                                        }



                                    </script>
                                <?php
                            } 
                            else if(in_array($sbtpcrow['id'], array('66', '67', '68', '69'))){
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

                                <div class="abacus-container-dip content br-1 text-center p-4 mb-4">
                                    <canvas id="canvas"></canvas>
                                    <img id="myImg" width = "305" height="250">
                                    <div class="place-values"></div>
                                </div>
                                

                                <br>

                                <script>
                                    //Suanpan Abacus

                                    generatePlaceValues();


                                    function generatePlaceValues() {
                                            const placeValuesContainer = document.querySelector('.place-values');

                                            const placeValueLabels = ['TTh', 'Th', 'H', 'T', 'O'];

                                            for (let i = 0; i < 5; i++) {
                                            const placeValue = document.createElement('div');
                                            placeValue.className = 'place-value';
                                            placeValue.textContent = placeValueLabels[i];
                                            placeValuesContainer.appendChild(placeValue);
                                        }
                                    }

                                var canvas = document.getElementById('canvas');
                                var ctx = canvas.getContext('2d');

                                canvas.width=305;
                                canvas.height=250;

                                // Represents beads flipped from top to bottom. 
                                // Not the most clever solution but works for now
                                // 0 = not flipped ; 1 = flipped
                                const displayStates = [
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
                                    // [1,1, 0,0,0,0,0],     //10
                                    // [1,1, 1,0,0,0,0],     //11
                                    // [1,1, 1,1,0,0,0],     //12
                                    // [1,1, 1,1,1,0,0],     //13
                                    // [1,1, 1,1,1,1,0],     //14
                                    // [1,1, 1,1,1,1,1]      //15
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
                                    var beadSize = 10;
                                    ctx.fillStyle = "red";
                                    for (var i=0; i < st.length; i++){
                                    
                                        var offset;
                                        var d = beadSize * 2.6;
                                        //Top beads
                                        if (i < 1){
                                            offset = (i+1) * d;   
                                            if (st[i]) offset+=47;
                                            ctx.beginPath();
                                            ctx.arc(x,y1 + offset -10,beadSize,0,2*Math.PI);
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
                                convertToImg(canvas, 'myImg');

                                //Initialize
                                // function init(){
                                //     abacus.setValue(9);
                                //     console.log(abacus.getValue());
                                //     abacus.redraw();
                                // }

                                // init();

                                </script>
                                <?php
                            }

                            else if(in_array($sbtpcrow['id'], array('75', '76', '77'))){
                                // print_r($querow);
                                ?>
                                <div class="content br-1 text-center p-4 mb-4">
                                    <canvas id="clockCanvas" width="300" height="300"></canvas>
                                    <img id="myImg" width = "300" height="300">
                                </div>
                                
                                <script>
                                    var shape_info = <?php echo $querow["shape_info"]; ?>;

                                    function drawClock(hour, minute) {
                                            var canvas = document.getElementById("clockCanvas");
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

                                            convertToImg(canvas, 'myImg');;
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
                                        ctx.font = radius * 0.08 + "px arial";
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
                                        drawHand(ctx, hour, radius * 0.5, radius * 0.07);
                                    
                                        minute = (minute * Math.PI / 30);
                                        drawHand(ctx, minute, radius * 0.8, radius * 0.07);
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
                                    ?>
                                        <style>
                                            .container-rectangle-dip {
                                                width: auto;
                                                height: auto;
                                                display: grid;
                                            }
                                            
                                            .square {
                                            border: 1px solid black;
                                            background-color: white;
                                            }
                                            
                                            .shaded1 {
                                            background-color: red;
                                            }

                                            .shaded2 {
                                            background-color: blue;
                                            }

                                            .content-center{
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;
                                            }
                                        </style>

                                        <div class="content br-1 text-center p-4 mb-4 content-center">
                                            <div class="container-rectangle-dip" id="squareContainer"></div>
                                        </div>

                                        <script>
                                            var shape_info = <?php echo $querow["shape_info"]; ?>;
                                            const container = document.getElementById("squareContainer");
                                            let length = parseInt(shape_info.shape_length);
                                            let breadth = parseInt(shape_info.shape_breadth);
                                            let shadedSquares1 = parseInt(shape_info.shaded_portion_1);
                                            let shadedSquares2 = parseInt(shape_info.shaded_portion_2);

                                            let color1 = "";
                                            let color2 = "";

                                            generateRectangle();
                                            
                                            function generateRectangle() {
                                            const squareSize = Math.min(400 / length, 400 / breadth);

                                            container.innerHTML = "";
                                            container.style.gridTemplateColumns = `repeat(${length}, ${squareSize}px)`;
                                            container.style.gridTemplateRows = `repeat(${breadth}, ${squareSize}px)`;

                                            const totalSquares = length * breadth;
                                            const startingIndex = getRandomStartingIndex(totalSquares);
                                            const shadedIndices1 = generateShadedIndices(totalSquares, shadedSquares1, startingIndex);
                                            const shadedIndices2 = generateShadedIndices(totalSquares, shadedSquares2, startingIndex, shadedIndices1);

                                            for (let i = 0; i < totalSquares; i++) {
                                                const square = document.createElement("div");
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
                                            const shadedIndices = [];
                                            const isShaded = Array(totalSquares).fill(false);
                                            let shadedCount = 0;

                                            while (shadedCount < shadedSquares) {
                                                const index = getRandomIndex(totalSquares);

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
                                   

                                    <div id="chart-container" class="content br-1 text-center p-4 mb-4">
                                        <canvas id="pie-chart-canvas"></canvas>
                                    </div>

                                    <script>
                                        var shape_info = <?php echo ($querow["shape_info"]); ?>;


                                        function generateCircle(){
                                            // Retrieve the input values
                                            const divisions = parseInt(shape_info.shape_length);
                                            const shaded1 = parseInt(shape_info.shaded_portion_1);
                                            const shaded2 = parseInt(shape_info.shaded_portion_2);
                                            
                                            // Check if the sum of shaded regions is valid
                                            if (shaded1 + shaded2 > divisions) {
                                                alert("Sum of shaded regions cannot exceed the total number of divisions.");
                                                return;
                                            }

                                            // Prepare the data for the pie chart
                                            const data = Array.from({ length: divisions }, () => 1);
                                            
                                            // Get the canvas element
                                            const canvas = document.getElementById('pie-chart-canvas');
                                            const ctx = canvas.getContext('2d');

                                            // Set the width and height of the canvas
                                            canvas.width = canvas.offsetWidth;
                                            canvas.height = canvas.offsetHeight;

                                            // Calculate the center coordinates
                                            const centerX = canvas.width / 2;
                                            const centerY = canvas.height / 2;

                                            // Calculate the radius based on the smaller dimension of the canvas
                                            const radius = Math.min(canvas.width, canvas.height) / 2;

                                            // Define the colors for shaded and unshaded slices
                                            const shaded1Color = '#ff0000'; // Red color for shaded region 1
                                            const shaded2Color = '#0000ff'; // Blue color for shaded region 2
                                            const unshadedColor = '#ffffff'; // White color for unshaded slices

                                            // Define the border colors for shaded and unshaded slices
                                            const shadedBorderColor = '#ffffff'; // White color for shaded slice borders
                                            const unshadedBorderColor = '#000000'; // Black color for unshaded slice borders

                                            // Calculate the total value from the data array
                                            const total = data.length;

                                            // Start angle for the first division
                                            let startAngle = 0;

                                            // Draw each division of the pie chart
                                            data.forEach((_, index) => {
                                                const sliceAngle = (1 / total) * 2 * Math.PI;
                                                const endAngle = startAngle + sliceAngle;

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
                                        }

                                        generateCircle();

                                    </script>
                                    

                                    <?php
                                }
                            }

                            else if(in_array($sbtpcrow['id'], array('88'))){
                                ?>
                                <style>
                                    .box {
                                        width: 30px;
                                        height: 30px;
                                        border: 2px solid black;
                                        display: inline-block;
                                        /*margin: 0.25px;*/
                                        background-color: white;
                                    }

                                    /* Set the font size to 0 to remove whitespace between inline-block elements */
                                    #matrix-container {
                                        font-size: 0;
                                    }

                                    .bordered-top {
                                        border-top: 2px solid yellow;
                                    }

                                    .bordered-bottom {
                                        border-bottom: 2px solid yellow;
                                    }

                                    .bordered-left {
                                        border-left: 2px solid yellow;
                                    }

                                    .bordered-right {
                                        border-right: 2px solid yellow;
                                    }

                                    #matrix{
                                        line-height: 0 !important;
                                    }
                                </style>

                                <div class="content br-1 text-center p-4 mb-4">
                                    <div id="matrix-container">
                                        <div id="matrix"></div>
                                    </div>
                                </div>
                                <script>
                                    function isShaded(row, col, coords) {
                                        return coords.some(coord => coord.row === row && coord.col === col);
                                    }

                                    function drawMatrixFromCoordinates(coordinateArray) {
                                    const matrixSize = 10;
                                    const matrixDiv = document.getElementById("matrix");
                                    matrixDiv.innerHTML = "";

                                    for (let row = 0; row < matrixSize; row++) {
                                        for (let col = 0; col < matrixSize; col++) {
                                            const isShadedCurrent = isShaded(row, col, coordinateArray);
                                            const isShadedTop = isShaded(row - 1, col, coordinateArray);
                                            const isShadedBottom = isShaded(row + 1, col, coordinateArray);
                                            const isShadedLeft = isShaded(row, col - 1, coordinateArray);
                                            const isShadedRight = isShaded(row, col + 1, coordinateArray);

                                            const box = document.createElement("div");
                                            box.classList.add("box");
                                            box.style.backgroundColor = isShadedCurrent ? "green" : "white";

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

                                        const lineBreak = document.createElement("br");
                                        matrixDiv.appendChild(lineBreak);
                                    }
                                }

                                            const sample = <?php echo ($querow["shape_info"]); ?>;
                                            const sampleCoordinates = sample.coordinates;


                                    // Call the function to draw the matrix with the sample coordinates
                                    drawMatrixFromCoordinates(sampleCoordinates);
                                </script>
                                <?php
                            }
                            else if(in_array($sbtpcrow['id'], array('98', '99', '100'))){
                                $shape_info = json_decode($querow["shape_info"]);
                                $choose_graph = $shape_info->type;

                                if($choose_graph == "bar_graph"){
                                    ?>
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                                        <div class="content br-1 text-center p-4 mb-4">

                                            <div style="width: 90%; max-width: 800px; margin: 20px auto;">
                                                <canvas id="barChart" style="height: 500px;"></canvas>
                                            </div>

                                        </div>

                                        <script>
                                            var shape_info = <?php echo $querow["shape_info"]; ?>;
                                            var month_graph = shape_info.values;

                                            var months = month_graph.map(item => item.month);
                                            var unitsProduced = month_graph.map(item => item.units);

                                            var ctx = document.getElementById("barChart").getContext("2d");
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
                                        </script>

                                    <?php
                                }
                                else if($choose_graph == "horizontal_bar_graph") {
                                    ?>
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                                        <div class="content br-1 text-center p-4 mb-4">

                                            <div style="width: 90%; max-width: 800px; margin: 20px auto;">
                                                <canvas id="horizontalBarChart" style="height: 500px;"></canvas>
                                            </div>

                                        </div>

                                        <script>
                                            var shape_info = <?php echo $querow["shape_info"]; ?>;
                                            var month_graph = shape_info.values;

                                            var months = month_graph.map(item => item.month);
                                            var unitsProduced = month_graph.map(item => item.units);

                                            var ctx = document.getElementById("horizontalBarChart").getContext("2d");
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
                                        </script>
                                    <?php
                                }
                                else if($choose_graph == "line_graph"){
                                    ?>
                                          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                            <div style="width: 90%; max-width: 800px; margin: 20px auto;">
                                                <canvas id="lineChart" style="height: 500px;"></canvas>
                                            </div>
                                            <script>
                                                var shape_info = <?php echo $querow["shape_info"]; ?>;
                                                var month_graph = shape_info.values;

                                                var months = month_graph.map(item => item.month);
                                                var unitsProduced = month_graph.map(item => item.units);

                                                var ctx = document.getElementById("lineChart").getContext("2d");
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
                                            </script>
                                    <?php
                                }
                                else if($choose_graph == "pie_chart"){
                                    ?>
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                          <div style="width: 90%; max-width: 800px; margin: 20px auto;">
                                            <canvas id="pieChart" style="height: 500px;"></canvas>
                                        </div>

                                        <script>
                                            var shape_info = <?php echo $querow["shape_info"]; ?>;
                                            var month_graph = shape_info.values;

                                            var months = month_graph.map(item => item.month);
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

                                            var ctx = document.getElementById("pieChart").getContext("2d");
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
                                    <div class="content br-1 text-center p-4 mb-4">
                                        <img src= "<?php echo $baseurl; ?>/uploads/directions/<?php echo $img_file ; ?>" style='height:300px;width:300px;object-fit:contain' alt="">
                                    </div>
                                <?php
                            }

                            else if(in_array($sbtpcrow['id'], array('106', '107', '112'.'113', '114', '115', '116', '117'))){
                                $shape_info_que = json_decode($querow["shape_info"]);
                                $question_type = $shape_info_que->type;

                                if($question_type == "addition"){
                                    ?>
                                    <style>

                                        .grid-container {
                                        display: grid;
                                        grid-template-columns: repeat(10, 50px);
                                        grid-template-rows: repeat(3, 50px);
                                        /* grid-gap: 5px; */
                                        justify-content: center;
                                        margin-top: 20px;
                                        text-align: center;
                                        line-height: 0 !important;
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
                                    <div class="content br-1 text-center p-4 mb-4">
                                        <div class="grid-container" id="grid-container"></div>
                                    </div>

                                    <script>
                                        visualizeAddition();
                                        function visualizeAddition() {
                                            const shape_info = <?php echo $querow["shape_info"]; ?>;
                                            const number1 = shape_info.num_1 + "";
                                            const number2 = shape_info.num_2 + "";
                                            const number3 = shape_info.pqr + "";
                                            const sum = (parseInt(number1) + parseInt(number2)) + "";

                                            const gridContainer = document.getElementById("grid-container");
                                            gridContainer.innerHTML = '';

                                            const maxLength = Math.max(number1.length, number2.length, sum.length);
                                            const paddedNum1 = number1.padStart(maxLength, " ");
                                            const paddedNum2 = number2.padStart(maxLength, " ");
                                            const num3_array = ("" + number3).split("");

                                            const map_digits = {
                                                P: num3_array[0],
                                                Q: num3_array[1], 
                                                R: num3_array[2],
                                            }
                                                
                                            // Split numbers into digits
                                            const digits1 = paddedNum1.split('').map(digit => map_digits.P == digit ? "P" : digit);
                                            const digits2 = paddedNum2.split('').map(digit => map_digits.Q == digit ? "Q" : digit);
                                            const sumDigits = sum.toString().padStart(maxLength, "0").split('').map(digit => map_digits.R == digit ? "R" : digit);

                                        // Create a 3x10 grid
                                            for (let i = 0; i < 3; i++) {
                                                for (let j = 0; j < 10; j++) {
                                                const gridItem = document.createElement("div");
                                                gridItem.classList.add("grid-item");

                                                if (i === 0) {
                                                    if (j === 0) {
                                                    gridItem.textContent = ' '; // Empty box before the first number
                                                    } else {
                                                    gridItem.textContent = j <= digits1.length ? digits1[j - 1] : '';
                                                    }
                                                } else if (i === 1) {
                                                    gridItem.textContent = j === 0 ? '+' : (j < 1 + digits2.length ? digits2[j - 1] : '');
                                                    gridItem.classList.add("grid-border");
                                                } else {
                                                    gridItem.textContent = j < 1 + sumDigits.length ? sumDigits[j - 1] : '';
                                                }

                                                gridContainer.appendChild(gridItem);
                                                }
                                            }
                                        }
                                    </script>
                                    <?php
                                }
                                elseif($question_type == "substraction"){
                                    ?>
                                        <style>
                                            
                                            .grid-container {
                                            display: grid;
                                            grid-template-columns: repeat(10, 50px);
                                            grid-template-rows: repeat(3, 50px);
                                            /* grid-gap: 5px; */
                                            justify-content: center;
                                            margin-top: 20px;
                                            text-align: center;
                                            line-height: 0 !important;
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
                                        <div class="content br-1 text-center p-4 mb-4">
                                            <div class="grid-container" id="grid-container"></div>
                                        </div>
                                        <script>
                                            visualizeSubstraction();
                                            function visualizeSubstraction() {
                                            const shape_info = <?php echo $querow["shape_info"]; ?>;
                                            const number1 = shape_info.num_1 + "";
                                            const number2 = shape_info.num_2 + "";
                                            const number3 = shape_info.pqr + "";
 
                                            const difference = (parseInt(number1) - parseInt(number2)) + "";

                                            const gridContainer = document.getElementById("grid-container");
                                            gridContainer.innerHTML = '';

                                            const maxLength = Math.max(number1.length, number2.length, difference.length);
                                                    const paddedNum1 = number1.padStart(maxLength, " ");
                                                    const paddedNum2 = number2.padStart(maxLength, " ");
                                                    const num3_array = ("" + number3).split("");

                                                    // const map_digits = {
                                                    //     [num3_array[0]]: "P",
                                                    //     [num3_array[1]]: "Q",
                                                    //     [num3_array[2]]: "R",
                                                    // }

                                                    const map_digits = {
                                                        P: num3_array[0],
                                                        Q: num3_array[1], 
                                                        R: num3_array[2],
                                                    }
                                                
                                            // Split numbers into digits
                                            const digits1 = paddedNum1.split('').map(digit => map_digits.P == digit ? "P" : digit);
                                            const digits2 = paddedNum2.split('').map(digit => map_digits.Q == digit ? "Q" : digit);
                                            const differenceDigits = difference.toString().padStart(maxLength, "0").split('').map(digit => map_digits.R == digit ? "R" : digit);

                                            // Create a 3x10 grid
                                            for (let i = 0; i < 3; i++) {
                                                for (let j = 0; j < 10; j++) {
                                                const gridItem = document.createElement("div");
                                                gridItem.classList.add("grid-item");

                                                if (i === 0) {
                                                    if (j === 0) {
                                                    gridItem.textContent = ' '; // Empty box before the first number
                                                    } else {
                                                    gridItem.textContent = j <= digits1.length ? digits1[j - 1] : '';
                                                    }
                                                } else if (i === 1) {
                                                    gridItem.textContent = j === 0 ? '-' : (j < 1 + digits2.length ? digits2[j - 1] : '');
                                                    gridItem.classList.add("grid-border");
                                                } else {
                                                    gridItem.textContent = j < 1 + differenceDigits.length ? differenceDigits[j - 1] : '';
                                                }

                                                gridContainer.appendChild(gridItem);
                                                }
                                            }
                                            }
                                        </script>
                                    <?php
                                }
                                else if($question_type == "multiplication"){
                                    ?>
                                        <style>
                                            .grid-container {
                                            display: grid;
                                            grid-template-columns: repeat(10, 50px);
                                            grid-template-rows: repeat(3, 50px);
                                            /* grid-gap: 5px; */
                                            justify-content: center;
                                            margin-top: 20px;
                                            text-align: center;
                                            line-height: 0 !important;
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

                                            .grid-border{
                                            border-bottom: 3px solid #000;
                                            }
                                        </style>
                                        
                                        <div class="content br-1 text-center p-4 mb-4">
                                            <div class="grid-container" id="grid-container"></div>
                                        </div>

                                        <script>
                                        visualizeMultiplication();
                                            function visualizeMultiplication() {
                                            const shape_info = <?php echo $querow["shape_info"]; ?>;
                                            const number1 = shape_info.num_1 + "";
                                            const number2 = shape_info.num_2 + "";
                                            const number3 = shape_info.pqr + "";
                                            const product = (parseInt(number1) * parseInt(number2)) + "";

                                            const gridContainer = document.getElementById("grid-container");
                                            gridContainer.innerHTML = '';



                                                    // const map_digits = {
                                                    //     [num3_array[0]]: "P",
                                                    //     [num3_array[1]]: "Q",
                                                    //     [num3_array[2]]: "R",
                                                    // }

                                                
                                            const num2_len = (number2 + "").length;
                                            console.log(num2_len);


                                            const partial_multiplication_1 = (parseInt(number1) * (number2.split("")[2])) + "";
                                            const partial_multiplication_2 = (parseInt(number1) * (number2.split("")[1])) + "x".repeat(Math.max(num2_len - 2, 0));
                                            const partial_multiplication_3 = (parseInt(number1) * (number2.split("")[0])) + "x".repeat(Math.max(num2_len - 1, 0));


                                            const maxLength = Math.max(number1.length, number2.length, product.length);
                                            const paddedNum1 = number1.padStart(maxLength, " ");
                                            const paddedNum2 = ("X" + number2).padStart(maxLength, " ");
                                            const num3_array = ("" + number3).split("");
                                            const padded_partial_1 = partial_multiplication_1.padStart(maxLength, " ");
                                            const padded_partial_2 = (partial_multiplication_2).padStart(maxLength, " ");
                                            const padded_partial_3 = (partial_multiplication_3).padStart(maxLength, " ");

                                            const map_digits = {
                                                P: num3_array[0],
                                                Q: num3_array[1], 
                                                R: num3_array[2],
                                            }
                                        
                                            // Split numbers into digits
                                            const digits1 = paddedNum1.split('').map(digit => map_digits.P == digit ? "P" : digit);
                                            const digits2 = paddedNum2.split('').map(digit => map_digits.Q == digit ? "Q" : digit);
                                            const productDigits = product.toString().split('').map(digit => map_digits.R == digit ? "R" : digit);


                                            // Create a 5x10 grid
                                            for (let i = 0; i <= (num2_len * 2); i++) {
                                                for (let j = 0; j < 10; j++) {
                                                const gridItem = document.createElement("div");
                                                gridItem.classList.add("grid-item");

                                                if (i === 0) {
                                                    if (j === 0) {
                                                    gridItem.textContent = ' '; // Empty box before the first number
                                                    } else {
                                                    gridItem.textContent = j <= digits1.length ? digits1[j - 1] : '';
                                                    }
                                                } else if (i === 1) {
                                                    gridItem.textContent = j === 0 ? ' ' : (j < 1 + digits2.length ? digits2[j - 1] : '');
                                                    gridItem.classList.add("grid-border");
                                                } 
                                                else if(num2_len > 1 && i == 2){
                                                    let chosen = num2_len == 3 ? padded_partial_1 :padded_partial_2;
                                                    gridItem.textContent = j === 0 ? ' ' : (j < 1 + chosen.length ? chosen[j - 1] : '');
                                                }
                                                else if(num2_len > 1 && i == 3){
                                                    let chosen = num2_len == 3 ? padded_partial_2 :padded_partial_3;
                                                    gridItem.textContent = j === 0 ? ' ' : (j < 1 + chosen.length ? chosen[j - 1] : '');
                                                    num2_len == 2 ? gridItem.classList.add("grid-border") : "";
                                                }
                                                else if(num2_len > 2 && i == 4){
                                                    gridItem.textContent = j === 0 ? ' ' : (j < 1 + padded_partial_3.length ? padded_partial_3[j - 1] : '');
                                                    gridItem.classList.add("grid-border");
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
                                    ?>
                                          <style>
                                                .grid-container {
                                                display: grid;
                                                grid-template-columns: repeat(12, 50px);
                                                grid-template-rows: repeat(3, 50px);
                                                /* grid-gap: 5px; */
                                                justify-content: center;
                                                margin-top: 20px;
                                                text-align: center;
                                                line-height: 0 !important;
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

                                                .grid-border-top{
                                                border-top: 3px solid #000;
                                                }

                                                .grid-border-right{
                                                border-right: 3px solid #000;
                                                }

                                                .grid-border-left{
                                                border-left: 3px solid #000;
                                                }

                                                .grid-border-bottom{
                                                border-bottom: 3px solid #000;
                                                }
                                            </style>
                                            <div class="content br-1 text-center p-4 mb-4">
                                                <div class="grid-container" id="grid-container"></div>
                                            </div>

                                            <script>
                                                visualizeDivision();
                                                function visualizeDivision() {
                                                    const shape_info = <?php echo $querow["shape_info"]; ?>;
                                                    const number1 = shape_info.num_1 + "";
                                                    const number2 = shape_info.num_2 + "";
                                                    const number3 = shape_info.pqr + "";
                                                const quotient = Math.floor(parseInt(number1) / parseInt(number2)) + "";
                                                const remainder = Math.floor(parseInt(number1) % parseInt(number2)) + "";
                                                var num3_array =(number3 + "").split("");
                                                console.log(number3);

                                                const gridContainer = document.getElementById("grid-container");
                                                gridContainer.innerHTML = '';

                                                var current_divisor = (number2 + "").length;
                                                const divisor_end = (number1 + "").length + (current_divisor - 1);
                                                const quotient_array = (quotient + "").split("");

                                                const map_digits = {
                                                    P: num3_array[0],
                                                    Q: num3_array[1], 
                                                    R: num3_array[2],
                                                }

                                                const digits1 = number1.split('').map(digit => map_digits.P == digit ? "P" : digit).join("");
                                                const digits2 = number2.split('').map(digit => map_digits.Q == digit ? "Q" : digit).join("");
                                                const quotientDigits = quotient.toString().split('').map(digit => map_digits.R == digit ? "R" : digit).join("");

                                                for(var i = 0; i < 12; i++){
                                                    const gridItem = document.createElement("div");
                                                    gridItem.classList.add("grid-item");

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
                                                    for(var j = 0; j < 12; j++){
                                                    const gridItem = document.createElement("div");
                                                    gridItem.classList.add("grid-item");

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
                                                    for(var j = 0; j < 12; j++){
                                                    const gridItem = document.createElement("div");
                                                    gridItem.classList.add("grid-item");

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
                                ?>
                                    <style>
                                        #question-img-pictures img {
                                        width: 100px; /* Adjust the width as needed */
                                        height: auto;
                                        margin: 5px;
                                        }
                                    </style>
                                    <div class="content br-1 text-center p-4 mb-4" id="question-img-pictures"></div>
                                    <script>
                                            function showPictures() {
                                                var numPictures = parseInt(<?php echo json_encode($querow["correct_ans"]); ?>);
                                                var pictureContainer = document.getElementById('question-img-pictures');
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

                                if($shape_info->type == "calender"){
                                    ?>
                                        <style>
                                            #calendarCanvas {
                                                border: 1px solid black;
                                            }
                                        </style>
                                        <div class="content br-1 text-center p-4 mb-4">
                                            <canvas id="calendarCanvas" width="400" height="400"></canvas>
                                            <img id="myImg" width = "600" height="400">
                                        </div>

                                        <script>
                                            const monthNames = [
                                                'January', 'February', 'March', 'April', 'May', 'June',
                                                'July', 'August', 'September', 'October', 'November', 'December'
                                            ];

                                            const canvas = document.getElementById('calendarCanvas');
                                            const ctx = canvas.getContext('2d');

                                            const shape_info = <?php echo json_encode($shape_info); ?>;
                                            const shape_month = monthNames.indexOf(shape_info.month) + 1; // Specify the month (1-12)
                                            const shape_year = shape_info.year; // Specify the year

                                            const daysInMonth = new Date(shape_year, shape_month, 0).getDate();
                                            const firstDay = new Date(shape_year, shape_month - 1, 1).getDay();

                                            const cellSize = 50;
                                            const headerHeight = 60; // Adjusted header height for better layout

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
                                            const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                                            for (let i = 0; i < 7; i++) {
                                                const x = i * cellSize + cellSize / 2;
                                                const y = headerHeight - 10; // Adjusted y-coordinate for better layout
                                                ctx.fillText(dayNames[i], x, y);
                                            }

                                            // Draw calendar cells
                                            ctx.font = '14px Arial';
                                            ctx.textAlign = 'center';
                                            for (let day = 1; day <= daysInMonth; day++) {
                                                const column = (day + firstDay - 1) % 7;
                                                const row = Math.floor((day + firstDay - 1) / 7);
                                                const x = column * cellSize + cellSize / 2;
                                                const y = headerHeight + row * cellSize + cellSize / 2;

                                                ctx.fillText(day, x, y);
                                            }

                                            convertToImg(canvas, 'myImg');;
                                            </script>

                                    <?php
                                }
                            }
                            else if(in_array($sbtpcrow['id'], array('179'))){
                                ?>
                                    <style>
                                        canvas {
                                            border: 1px solid black;
                                        }
                                    </style>
                                    <div class="content br-1 text-center p-4 mb-4">
                                        <canvas id="myCanvas" width="600" height="150"></canvas>
                                        <img id="myImg" width = "600" height="150">
                                    </div>
                                    <script>
                                        // Get the canvas element and its context
                                        var canvas = document.getElementById("myCanvas");
                                        var ctx = canvas.getContext("2d");

                                        // Define the length of the metal rod in cm
                                        var rodLength = <?php echo json_encode($querow["correct_ans"]); ?>.split("cms")[0]; // Change this value as needed
                                        var scaleLength = 10;

                                        // Set the scale for the ruler (1 cm = 50 pixels)
                                        var pixelsPerCm = 50;

                                        // Draw the ruler with cm markings and subdivisions
                                        ctx.fillStyle = "black";
                                        ctx.font = "10px Arial";
                                        var x;
                                        ctx.beginPath();
                                        for (var cm = 0; cm <= scaleLength; cm++) {
                                            x = cm * pixelsPerCm;
                                            ctx.moveTo(x + 15, 100);
                                            ctx.lineTo(x + 15, 115);
                                            ctx.fillText(cm, x + 15, 125);

                                            // Draw subdivisions (0.1 cm)
                                            for (var sub = 1; sub < 10; sub++) {
                                                var subX = x + sub * (pixelsPerCm / 10);
                                                ctx.moveTo(subX + 15, 100);
                                                ctx.lineTo(subX + 15, 110);
                                            }
                                        }
                                        ctx.fillText("(cm)", x + 35, 120);
                                        ctx.stroke();

                                        // Draw the metal rod horizontally on top of the ruler
                                        var rodY = 80; // Adjust the vertical position of the rod
                                        var rodWidth = rodLength * pixelsPerCm; // Width of the metal rod
                                        ctx.fillStyle = "red";
                                        ctx.fillRect(15, rodY, rodWidth, 10);

                                        convertToImg(canvas, 'myImg');;
                                        </script>
                                    
                                <?php
                            }
                            else if(in_array($sbtpcrow['id'], array('180'))) {
                                ?>
                                    <style>
                                        canvas {
                                            border: 1px solid black;
                                        }
                                    </style>
                                    <div class="content br-1 text-center p-4 mb-4">
                                        <canvas id="myCanvas" width="600" height="400"></canvas>
                                        <img id="myImg" width = "600" height="400">
                                    </div>

                                    <script>
                                        var shape_info = <?php echo $querow["shape_info"]; ?>;
                                        // Get the canvas element and its context
                                        var canvas = document.getElementById("myCanvas");
                                        var ctx = canvas.getContext("2d");

                                        // Draw the thermometer column
                                        var columnX = 100;
                                        var columnTopY = 20;
                                        var columnBottomY = 380;
                                        ctx.fillStyle = "black";
                                        ctx.fillRect(columnX - 5, columnTopY, 10, columnBottomY - columnTopY);

                                        // Draw thermometer divisions and subdivisions
                                        ctx.font = "10px Arial";
                                        var numDivisions = 10; // Number of main divisions
                                        var numSubdivisions = 10; // Number of subdivisions between each division
                                        var divisionHeight = (columnBottomY - columnTopY) / numDivisions;
                                        var subdivisionHeight = divisionHeight / numSubdivisions;
                                        var currentY = columnTopY;

                                        for (var i = 0; i <= numDivisions; i++) {
                                            ctx.beginPath();
                                            ctx.moveTo(columnX - 15, currentY);
                                            ctx.lineTo(columnX + 15, currentY);
                                            ctx.stroke();
                                            ctx.fillText((numDivisions - i) * 10, columnX + 20, currentY + 3);

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
                                        var temperature = shape_info.temp; // Set the temperature value
                                        var mercuryHeight = (temperature / 100) * (columnBottomY - columnTopY);
                                        ctx.fillStyle = "rgba(255, 0, 0, 0.7)";
                                        ctx.fillRect(columnX - 5, bulbCenterY - bulbRadius, 10, -mercuryHeight);

                                        convertToImg(canvas, 'myImg');;
                                    </script>

                                <?php
                            }

                            else if(in_array($sbtpcrow['id'], array('181', '182', '183', '184'))) {
                                    $shape_info = json_decode($querow["shape_info"]);
                                    if($shape_info->type == "two_rulers"){
                                    ?>
                                        <style>
                                            canvas {
                                                border: 1px solid black;
                                            }
                                        </style>
                                        <div class="content br-1 text-center p-4 mb-4">
                                            <canvas id="myCanvas" width="600" height="150"></canvas>
                                            <img id="myImg" width = "600" height="150">
                                        </div>

                                        <script>
                                            var shape_info = <?php echo $querow["shape_info"]; ?>;
                                            // Get the canvas element and its context
                                            var canvas = document.getElementById("myCanvas");
                                            var ctx = canvas.getContext("2d");

                                            // Define the lengths of the metal rods in cm
                                            var rodLength1 = shape_info.length_1; // Change these values as needed
                                            var rodLength2 = shape_info.length_2;
                                            var scaleLength = 10;

                                            // Set the scale for the ruler (1 cm = 50 pixels)
                                            var pixelsPerCm = 50;

                                            // Draw the ruler with cm markings and subdivisions
                                            ctx.fillStyle = "black";
                                            ctx.font = "10px Arial";
                                            var x;
                                            ctx.beginPath();
                                            for (var cm = 0; cm <= scaleLength; cm++) {
                                                x = cm * pixelsPerCm;
                                                ctx.moveTo(x + 15, 100);
                                                ctx.lineTo(x + 15, 115);
                                                ctx.fillText(cm, x + 15, 125);

                                                // Draw subdivisions (0.1 cm)
                                                for (var sub = 1; sub < 10; sub++) {
                                                    var subX = x + sub * (pixelsPerCm / 10);
                                                    ctx.moveTo(subX + 15, 100);
                                                    ctx.lineTo(subX + 15, 110);
                                                }
                                            }
                                            ctx.fillText("(cm)", x + 35, 120);
                                            ctx.stroke();

                                            // Draw the metal rods horizontally on top of the ruler
                                            var rodY = 65; // Adjust the vertical position of the rods
                                            var rodWidth1 = rodLength1 * pixelsPerCm; // Width of the first metal rod
                                            var rodWidth2 = rodLength2 * pixelsPerCm; // Width of the second metal rod
                                            ctx.fillStyle = "red";
                                            ctx.fillRect(15, rodY, rodWidth1, 10); // Draw the first rod
                                            ctx.fillStyle = "blue";
                                            ctx.fillRect(15, rodY + 20, rodWidth2, 10); // Draw the second rod

                                            convertToImg(canvas, 'myImg');;

                                        </script>

                                    <?php
                                    }

                                    else if($shape_info->type =="one_sided_weight" || $shape_info->type == "two_sided_weight") {
                                        ?>
                                            <div class="content br-1 text-center p-4 mb-4">
                                              <canvas id="seasawCanvas" width="600" height="200"></canvas>
                                              <img id="myImg" width = "600" height="200">
                                            </div>

                                            <script>
                                                const shape_info = <?php echo $querow["shape_info"]; ?>;
                                                const left = shape_info.weights_left;
                                                const right = shape_info.weights_right;

                                                const canvas = document.getElementById('seasawCanvas');
                                                const ctx = canvas.getContext('2d');

                                                const seasawWidth = 500;
                                                const seasawHeight = 10;
                                                const seasawX = (canvas.width - seasawWidth) / 2;
                                                const seasawY = canvas.height - seasawHeight - 30;

                                                const fulcrumWidth = 20;
                                                const fulcrumHeight = 40;
                                                const fulcrumColor = '#888';
                                                const fulcrumX = seasawX + (seasawWidth - fulcrumWidth) / 2;
                                                const fulcrumY = seasawY + seasawHeight;

                                                const fulcrumTriangleSize = 40;

                                                const boxSize = 50;
                                                const boxColor = '#9b7653';
                                                const boxBorderColor = '#63462b';
                                                const boxX = seasawX + seasawWidth - boxSize;
                                                const boxY = seasawY - boxSize;

                                                const weightsLeft_temp = [
                                                    { x: boxX - seasawWidth + 165, y: boxY + 20, size: 30, color: '#ff5b5b', border: '#d63636'},
                                                    { x: boxX - seasawWidth + 120, y: boxY + 10, size: 40, color: '#8ae26a', border: '#60b845'},
                                                    { x: boxX - seasawWidth + 60, y: boxY, size: 50, color: '#ad7cff', border: '#8543ff'}
                                                ];

                                                const weightsRight_temp = [
                                                    { x: boxX + boxSize - 30, y: boxY + 20, size: 30, color: '#68c1e3', border: '#2e98b2'},
                                                    { x: boxX + boxSize - 70, y: boxY + 10, size: 40, color: '#f5a623', border: '#c98216'},
                                                    { x: boxX + boxSize - 120, y: boxY, size: 50, color: '#ffd54f', border: '#e0ab1e'}
                                                ];

                                                var weightsLeft = [];
                                                var weightsRight = [];

                                                for(var z = 0; z < left.length; z++) {
                                                    weightsLeft.push({...weightsLeft_temp[2 - z], ...left[z]});
                                                }

                                                for(var z = 0; z < right.length; z++) {
                                                    weightsRight.push({...weightsRight_temp[2 - z], ...right[z]});
                                                }

                                                function drawSeasaw() {
                                                    // Draw the seasaw platform
                                                    ctx.fillStyle = '#ddd';
                                                    ctx.fillRect(seasawX, seasawY, seasawWidth, seasawHeight);

                                                    // Draw the weights on the left
                                                    for (const weight of weightsLeft) {
                                                        ctx.fillStyle = weight.color;
                                                        ctx.strokeStyle = weight.border;
                                                        ctx.lineWidth = 2;
                                                        ctx.fillRect(weight.x, weight.y, weight.size, weight.size);
                                                        ctx.strokeRect(weight.x, weight.y, weight.size, weight.size);

                                                        ctx.fillStyle = 'black';
                                                        ctx.font = '12px Arial';
                                                        ctx.textAlign = 'center';
                                                        ctx.fontWeight = 'bold';
                                                        ctx.fillText(weight.text, weight.x + weight.size / 2, weight.y + weight.size / 2 + 4);
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
                                                    for (const weight of weightsRight) {
                                                        ctx.fillStyle = weight.color;
                                                        ctx.strokeStyle = weight.border;
                                                        ctx.lineWidth = 2;
                                                        ctx.fillRect(weight.x, weight.y, weight.size, weight.size);
                                                        ctx.strokeRect(weight.x, weight.y, weight.size, weight.size);

                                                        ctx.fillStyle = 'black';
                                                        ctx.font = '12px Arial';
                                                        ctx.textAlign = 'center';
                                                        ctx.fontWeight = 'bold';
                                                        ctx.fillText(weight.text, weight.x + weight.size / 2, weight.y + weight.size / 2 + 4);
                                                    }
                                                }

                                                drawSeasaw();
                                                convertToImg(canvas, 'myImg');;
                                            </script>
                                        <?php
                                    }
                                    else if($shape_info->type =="one_sided_weight_tilted" || $shape_info->type == "two_sided_weight_tilted") {
                                        ?>
                                            <div class="content br-1 text-center p-4 mb-4">
                                                <canvas id="seasawCanvas" width="600" height="200"></canvas>
                                                <img id="myImg" width = "600" height="200">
                                            </div>

                                            <script>
                                                const shape_info = <?php echo $querow["shape_info"]; ?>;;
                                                const left = shape_info.weights_left;
                                                const right = shape_info.weights_right;

                                                const canvas = document.getElementById('seasawCanvas');
                                                const ctx = canvas.getContext('2d');

                                                const seasawWidth = 500;
                                                const seasawHeight = 10;
                                                const seasawX = (canvas.width - seasawWidth) / 2;
                                                const seasawY = canvas.height - seasawHeight - 30;

                                                const fulcrumWidth = 20;
                                                const fulcrumHeight = 40;
                                                const fulcrumColor = '#888';
                                                const fulcrumX = seasawX + (seasawWidth - fulcrumWidth) / 2;
                                                const fulcrumY = seasawY + seasawHeight;

                                                const fulcrumTriangleSize = 40;

                                                const boxSize = 50;
                                                const boxColor = '#9b7653';
                                                const boxBorderColor = '#63462b';
                                                const boxX = seasawX + seasawWidth - boxSize;
                                                const boxY = seasawY - boxSize;

                                                const weightsLeft_temp = [
                                                    { x: boxX - seasawWidth + 165, y: boxY + 20, size: 30, color: '#ff5b5b', border: '#d63636' },
                                                    { x: boxX - seasawWidth + 120, y: boxY + 10, size: 40, color: '#8ae26a', border: '#60b845' },
                                                    { x: boxX - seasawWidth + 60, y: boxY, size: 50, color: '#ad7cff', border: '#8543ff' }
                                                ];

                                                const weightsRight_temp = [
                                                    { x: boxX + boxSize - 30, y: boxY + 20, size: 30, color: '#68c1e3', border: '#2e98b2' },
                                                    { x: boxX + boxSize - 70, y: boxY + 10, size: 40, color: '#f5a623', border: '#c98216' },
                                                    { x: boxX + boxSize - 120, y: boxY, size: 50, color: '#ffd54f', border: '#e0ab1e' }
                                                ];

                                                var weightsLeft = [];
                                                var weightsRight = [];

                                                for (var z = 0; z < left.length; z++) {
                                                    weightsLeft.push({ ...weightsLeft_temp[2 - z], ...left[z] });
                                                }

                                                for (var z = 0; z < right.length; z++) {
                                                    weightsRight.push({ ...weightsRight_temp[2 - z], ...right[z] });
                                                }

                                                const tiltFactor = 0.003; // Adjust the tilt factor for a slight tilt

                                                function calculateTilt() {
                                                    const leftWeight = weightsLeft.reduce((sum, weight) => sum + weight.weight, 0);
                                                    const rightWeight = weightsRight.reduce((sum, weight) => sum + weight.weight, 0);

                                                    // Calculate the difference in weights
                                                    const weightDifference = rightWeight - leftWeight;

                                                    // Calculate the tilt offset based on the weight difference
                                                    const tiltOffset = weightDifference * tiltFactor;

                                                    return tiltOffset;
                                                }

                                                function drawSeasaw() {
                                                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                                                    const tiltOffset = calculateTilt();
                                                    const midSeasawX = seasawX + seasawWidth / 2;

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
                                                    for (const weight of weightsLeft) {
                                                        const weightX = weight.x - (seasawX + seasawWidth / 2);
                                                        const weightY = weight.y - (seasawY + seasawHeight / 2);
                                                        const rotatedX = weightX * Math.cos(tiltOffset) - weightY * Math.sin(tiltOffset);
                                                        const rotatedY = weightX * Math.sin(tiltOffset) + weightY * Math.cos(tiltOffset);
                                                        const finalX = midSeasawX + rotatedX;
                                                        const finalY = seasawY + seasawHeight / 2 + rotatedY;

                                                        ctx.fillStyle = weight.color;
                                                        ctx.strokeStyle = weight.border;
                                                        ctx.lineWidth = 2;
                                                        ctx.fillRect(finalX, finalY, weight.size, weight.size);
                                                        ctx.strokeRect(finalX, finalY, weight.size, weight.size);

                                                        ctx.fillStyle = 'black';
                                                        ctx.font = '12px Arial';
                                                        ctx.textAlign = 'center';
                                                        ctx.fontWeight = 'bold';
                                                        ctx.fillText(weight.text, finalX + weight.size / 2, finalY + weight.size / 2 + 4);
                                                    }

                                                    // Draw the weights on the right
                                                    for (const weight of weightsRight) {
                                                        const weightX = weight.x - (seasawX + seasawWidth / 2);
                                                        const weightY = weight.y - (seasawY + seasawHeight / 2);
                                                        const rotatedX = weightX * Math.cos(tiltOffset) - weightY * Math.sin(tiltOffset);
                                                        const rotatedY = weightX * Math.sin(tiltOffset) + weightY * Math.cos(tiltOffset);
                                                        const finalX = midSeasawX + rotatedX;
                                                        const finalY = seasawY + seasawHeight / 2 + rotatedY;

                                                        ctx.fillStyle = weight.color;
                                                        ctx.strokeStyle = weight.border;
                                                        ctx.lineWidth = 2;
                                                        ctx.fillRect(finalX, finalY, weight.size, weight.size);
                                                        ctx.strokeRect(finalX, finalY, weight.size, weight.size);

                                                        ctx.fillStyle = 'black';
                                                        ctx.font = '12px Arial';
                                                        ctx.textAlign = 'center';
                                                        ctx.fontWeight = 'bold';
                                                        ctx.fillText(weight.text, finalX + weight.size / 2, finalY + weight.size / 2 + 4);
                                                    }
                                                }

                                                drawSeasaw();
                                                convertToImg(canvas, 'myImg');;
                                            </script>
                                        <?php
                                    }
                            }
                            else if(in_array($sbtpcrow['id'], array('214', '215', '216'))) {
                                $shape_info = json_decode($querow["shape_info"]);

                                ?>
                                
                                <div class="content br-1 text-center p-4 mb-4">
                                    <img 
                                        src="<?php echo $baseurl; ?>/uploads/mirror_image/<?php echo $shape_info->image ?>"
                                        style="width: 100px; height: 100px;">
                                </div>
                                
                                <?php
                            }
                            // -- end dipanjan changes
                            ?>

                            