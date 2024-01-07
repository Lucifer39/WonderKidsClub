<?php
if($sbtpName == '26') {
    $bftaft = rand(1,4);

    //if($bftaft == '1') {
        
        if ($bftaft == 1) {
            $ques = "Circles";
          } elseif ($bftaft == 2) {
            $ques = "Rectangles";
          } elseif ($bftaft == 3) {
            $ques = "Triangles";
          } elseif ($bftaft == 4) {
            $ques = "Squares";
          }

          $color = rand(1,5);
          
          if ($color == 1) {
            $clr = "pink";
          } elseif ($color == 2) {
            $clr = "orange";
          } elseif ($color == 3) {
            $clr = "green";
          } elseif ($color == 4) {
            $clr = "yellow";
          } elseif ($color == 5) {
            $clr = "blue";
          } 

        $quest = rand(1,10);
        $question = "How many ".$clr." ".$ques." are there?";
        $correct = $quest;

        $total = range(1,10);
        $exclude = range($correct,$correct);

        $opt_a = $correct;
        $opt_b = $total[array_rand(array_diff($total,$exclude))];
        if($opt_a != $opt_b) {
        $opt_c = $total[array_rand(array_diff($total,$exclude))];
        if($opt_a != $opt_c && $opt_b != $opt_c) {
            $opt_d = $total[array_rand(array_diff($total,$exclude))];
            
            if($opt_a!= $opt_d && $opt_b != $opt_d && $opt_c != $opt_d) {

                $names = array("$opt_a", "$opt_b", "$opt_c", "$opt_d");
                shuffle($names);
                $chunks = array_chunk($names, 2);
                $rearrange = array_merge($chunks[1], $chunks[0]);

            $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=".$bftaft." and type1=".$color." and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
            $befrow = mysqli_fetch_assoc($befsql);
            if($befrow['question'] == '') {
                mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type,type1,question,correct_ans,opt_a,opt_b,opt_c,opt_d,created_at,updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$bftaft."','".$color."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())" );				
            }
        }

        }
    }

    }        

//count color shape upto 20
if($sbtpName == '30') {
  $bftaft = rand(1,4);

  //if($bftaft == '1') {
      
      if ($bftaft == 1) {
          $ques = "Circles";
        } elseif ($bftaft == 2) {
          $ques = "Rectangles";
        } elseif ($bftaft == 3) {
          $ques = "Triangles";
        } elseif ($bftaft == 4) {
          $ques = "Squares";
        }

        $color = rand(1,5);
        
        if ($color == 1) {
          $clr = "pink";
        } elseif ($color == 2) {
          $clr = "orange";
        } elseif ($color == 3) {
          $clr = "green";
        } elseif ($color == 4) {
          $clr = "yellow";
        } elseif ($color == 5) {
          $clr = "blue";
        } 

      $quest = rand(1,20);
      $question = "How many ".$clr." ".$ques." are there?";
      $correct = $quest;

      $total = range(1,20);
      $exclude = range($correct,$correct);

      $opt_a = $correct;
      $opt_b = $total[array_rand(array_diff($total,$exclude))];
      if($opt_a != $opt_b) {
      $opt_c = $total[array_rand(array_diff($total,$exclude))];
      if($opt_a != $opt_c && $opt_b != $opt_c) {
          $opt_d = $total[array_rand(array_diff($total,$exclude))];
          
          if($opt_a!= $opt_d && $opt_b != $opt_d && $opt_c != $opt_d) {

              $names = array("$opt_a", "$opt_b", "$opt_c", "$opt_d");
              shuffle($names);
              $chunks = array_chunk($names, 2);
              $rearrange = array_merge($chunks[1], $chunks[0]);

          $befsql = mysqli_query($conn, "SELECT question FROM count_quest WHERE subtopic='".$sbtpName."' and type=".$bftaft." and type1=".$color." and question='".$question."' and opt_a='".$rearrange[0]."' and opt_b='".$rearrange[1]."' and opt_c='".$rearrange[2]."' and opt_d='".$rearrange[3]."'");
          $befrow = mysqli_fetch_assoc($befsql);
          if($befrow['question'] == '') {
              mysqli_query( $conn, "INSERT INTO count_quest(userid,class,subject,topic,subtopic,type,type1,question,correct_ans,opt_a,opt_b,opt_c,opt_d,created_at,updated_at) VALUES ('".$sessionrow['id']."','".$clsName."','".$subjName."','".$tpName."','".$sbtpName."','".$bftaft."','".$color."','".$question."','".$correct."','".$rearrange[0]."','".$rearrange[1]."','".$rearrange[2]."','".$rearrange[3]."',NOW(),NOW())" );				
          }
      }

      }
  }

  }
?>