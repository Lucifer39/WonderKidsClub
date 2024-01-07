<?php 
                                            //more and fewer objects
                                            if($sbtpcrow['id'] == '13' && $querow['type'] == '0' || $sbtpcrow['id'] == '13' && $querow['type'] == '1' || $sbtpcrow['id'] == '38' && $querow['type'] == '0' || $sbtpcrow['id'] == '38' && $querow['type'] == '1') { 
                                                $obj4 = [];
                                                for($i=0; $i<$querow['opt_d'];$i++){
                                                $obj4[]= $obj_4;
                                            } 
                                            echo implode('', $obj4);
                                            
                                            //more and fewer shape/objects - given group 
                                            } elseif($sbtpcrow['id'] == '13' && $querow['type'] == '2' || $sbtpcrow['id'] == '13' && $querow['type'] == '3' || $sbtpcrow['id'] == '38' && $querow['type'] == '2' || $sbtpcrow['id'] == '38' && $querow['type'] == '3') { 
                                                echo $obj4[0];

                                            //Long and Short
                                            } elseif($sbtpcrow['id'] == '14' || $sbtpcrow['id'] == '18') { $plus = $querow['opt_d']*40;
                                                echo "<img src='".$baseurl.$_SESSION['long_short_1']."' style='width:100px;height:".$plus."px'>";
                                            //Tall and Short
                                            } elseif($sbtpcrow['id'] == '15' || $sbtpcrow['id'] == '19') { $plus = $querow['opt_d']*40;
                                                echo "<img src='".$baseurl.$_SESSION['tall_short_1']."' style='width:100px;height:".$plus."px'>";
                                            } elseif($sbtpcrow['id'] == '16' || $sbtpcrow['id'] == '20') { $plus = $querow['opt_d']*20;
                                                echo "<img class='max-img-width' src='".$baseurl.$_SESSION['wide_narrow_1']."' style='height:200px;width:".$plus."%;object-fit: fill;'>";
                                            } elseif($sbtpcrow['id'] == '17' || $sbtpcrow['id'] == '21') {
                                                echo "<img class='max-img-size' src='".$baseurl.$_SESSION['light_heavy_4']."' style='height:150px;max-width:250px;object-fit:contain'>";
                                            } elseif($sbtpcrow['id'] == '22') {
                                                echo numberToWord($querow['opt_d']);
                                            //Name the shape    
                                            } elseif($sbtpcrow['id'] == '24' || $sbtpcrow['id'] == '27') {
                                                echo "<img class='max-img-size' src='".$baseurl.$_SESSION['shape_4']."' style='height:150px;max-width:150px;object-fit:contain'>";
                                            } elseif($sbtpcrow['id'] == '31' || $sbtpcrow['id'] == '33' || $sbtpcrow['id'] == '34' || $sbtpcrow['id'] == '35') {
                                                
                                                $value = $querow['opt_d'];
                                                if($value == '1' || $value == '2' || $value == '5' || $value == '10' || $value == '20') {
                                                    echo 'Rs '.$value;
                                                } elseif($value == '0.5') {
                                                    $value = $value*100; 
                                                    echo $value.' paisa';
                                                }
                                            } elseif($sbtpcrow['id'] == '36' || $sbtpcrow['id'] == '37') {
                                                foreach ($_SESSION['shape_4'] as $filename) {
                                                    echo '<img src="'.$baseurl.$filename.'" height="90" alt="Image" />';
                                                }
                                            } else {
                                                echo $querow['opt_d'];
                                            } ?>