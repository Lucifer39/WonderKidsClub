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
                            <?php } elseif($sbtpcrow['id'] == '31' || $sbtpcrow['id'] == '33') { ?>
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
                                <?php } elseif($sbtpcrow['id'] == '34') { ?>
                                <div class="content br-1 text-center p-4 mb-4">
                                    <?php 

                                    $bftaft = rand(1,2);
                                    $_SESSION['shape_1'] = $image_folder = ''.$pgLand.'uploads/money/'.$bftaft.'/';
                                    $image_name = $querow['correct_ans'];
                                    $image_extensions = array('jpg', 'jpeg', 'png', 'gif');
                                    
                                    $numbers = array(1, 2, 5, 10);
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

                                    $_SESSION['shape_2'] = $combinations = $combination;

                                   
                                    foreach ($combinations as $combi) {
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
                                <?php } elseif($sbtpcrow['id'] == '35') { ?>
                                <div class="content br-1 text-center p-4 mb-4">
                                    <?php 

                                    $bftaft = rand(1,2);
                                    $_SESSION['shape_1'] = $image_folder = ''.$pgLand.'uploads/money/'.$bftaft.'/';
                                    $image_name = $querow['correct_ans'];
                                    $image_extensions = array('jpg', 'jpeg', 'png', 'gif');
                                    
                                    $numbers = array(0.5 ,1, 2, 5, 10, 20);
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

                                    $_SESSION['shape_2'] = $combinations = $combination;
                                    
                                    foreach ($combinations as $combi) {
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
                            <?php } ?>