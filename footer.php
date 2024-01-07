<?php 
if(!isset($_SESSION["id"]) && isset($_COOKIE["user_id"])) {
    $_SESSION["id"] = $_COOKIE["user_id"];

    $sql = mysqli_query($conn, "SELECT id,email,contact, password, status,isAdmin FROM users WHERE id = '".$_SESSION["id"]."'");
    $row = mysqli_fetch_assoc($sql);

    if($row['isAdmin'] == '2') {
        $acptgrpqury = mysqli_query($conn, "SELECT id FROM grpwise WHERE link='".$prts."' and status=1");
        $acptgrprslt = mysqli_fetch_array($acptgrpqury, MYSQLI_ASSOC);

             
        if(!empty($acptgrprslt['id'])) {
        
            header('Location: ' . $_SERVER['REQUEST_URI']);
            echo '<script>location.reload();</script>';
            exit();
        } else {
            $encoded_encrypted_number = "";
            if(SECRET_KEY) {
                $iv = openssl_random_pseudo_bytes(16);
                $encrypted_number = openssl_encrypt($row['id'], 'aes-256-cbc', SECRET_KEY, 0, $iv);
                $encoded_encrypted_number = urlencode(base64_encode($encrypted_number));
            }

            if(isset($_GET["modal"]) && isset($_GET["redirect"])) {
                header('Location: ' . urldecode($_GET["redirect"]) . "?data=" . $encoded_encrypted_number . "&iv=" . urlencode($iv));
            }
            else {
                header('Location: ' . $baseurl . 'dashboard');
            }
        }
    } elseif($row['isAdmin'] == '3') {
        header( 'Location: ' . $baseurl . 'teacher/group' );
    } elseif($row['isAdmin'] == '1') {
        header( 'Location: ' . $baseurl . 'controlgear' );
    }


    
    exit;
}


if(isset($_GET["modal"]) && isset($_GET["redirect"]) && $_GET["modal"] == "login") { ?>
    <script type="text/javascript">
    $(document).ready(function(){$("#loginModal").modal("show");});
    </script>
<?php 
        if(!empty($_SESSION['id']) || !empty($_COOKIE['user_id'])) {
            $encoded_encrypted_number = "";
            $user_id = $_SESSION['id'] ?? $_COOKIE['user_id'];
            if(SECRET_KEY) {
                $iv = openssl_random_pseudo_bytes(16);
                $encrypted_number = openssl_encrypt($user_id, 'aes-256-cbc', SECRET_KEY, 0, $iv);
                $encoded_encrypted_number = urlencode(base64_encode($encrypted_number));
            }

            if(isset($_GET["redirect"])) {
                header('Location: ' . urldecode($_GET["redirect"]) . "?data=" . $encoded_encrypted_number . "&iv=" . urlencode($iv));
            }
        }
} 

if(!isset($_GET["modal"]) && isset($_GET["redirect"])) {
    if(!empty($_SESSION['id']) || !empty($_COOKIE['user_id'])) {
        $encoded_encrypted_number = "";
        $user_id = $_SESSION['id'] ?? $_COOKIE['user_id'];
        if(SECRET_KEY) {
            $iv = openssl_random_pseudo_bytes(16);
            $encrypted_number = openssl_encrypt($user_id, 'aes-256-cbc', SECRET_KEY, 0, $iv);
            $encoded_encrypted_number = urlencode(base64_encode($encrypted_number));
        }

        if(isset($_GET["redirect"])) {
            header('Location: ' . urldecode($_GET["redirect"]) . "?data=" . $encoded_encrypted_number . "&iv=" . urlencode($iv));
        }
    }
    else {
        header('Location: ' . urldecode($_GET["redirect"]) . "?data=0");
    }
}


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['tp_pass'];

    $sql = mysqli_query($conn, "SELECT id,email,contact, password, status,isAdmin FROM users WHERE email = '".$email."'");
    $row = mysqli_fetch_assoc($sql);

    if ($email != $row['email'] ) {
        $errMsg = '<div class="alert-danger p-2 mb-2" role="alert">User <b>' . $email . '</b> not found.</div>';
    } elseif ( $email != $row[ 'email' ] && md5( $password ) != $row[ 'password' ] ) {
        $errMsg = '<div class="alert-danger p-2 mb-2" role="alert">Incorrect Email/Phone or Password.</div>';            
    } elseif ( $email == "" && $password == "" || $email == "" || $password == "" ) {
        $errMsg = '<div class="alert-danger p-2 mb-2" role="alert">Please Enter Email or Password.</div>';
    } elseif ( $row['status'] == 1 ) {
        if ( $row['password'] == md5( $password ) ) {
            $_SESSION[ 'id' ] = $row['id'];
            session_start();
            $_SESSION[ 'id' ];

            $cookie_name = "user_id";
            $cookie_value = $row['id'];
            $expiration_time = time() + 60 * 60 * 24 * 30; // 30 days (in seconds)

            setcookie($cookie_name, $cookie_value, $expiration_time, "/");

           // mysqli_close( $conn );
            session_write_close();
            
            if($row['isAdmin'] == '2') {
                $acptgrpqury = mysqli_query($conn, "SELECT id FROM grpwise WHERE link='".$prts."' and status=1");
                $acptgrprslt = mysqli_fetch_array($acptgrpqury, MYSQLI_ASSOC);

                     
                if(!empty($acptgrprslt['id'])) {
                
                    header('Location: ' . $_SERVER['REQUEST_URI']);
                    echo '<script>location.reload();</script>';
                    exit();
                } else {
                    $encoded_encrypted_number = "";
                    if(SECRET_KEY) {
                        $iv = openssl_random_pseudo_bytes(16);
                        $encrypted_number = openssl_encrypt($row['id'], 'aes-256-cbc', SECRET_KEY, 0, $iv);
                        $encoded_encrypted_number = urlencode(base64_encode($encrypted_number));
                    }

                    if(isset($_GET["modal"]) && isset($_GET["redirect"])) {
                        header('Location: ' . urldecode($_GET["redirect"]) . "?data=" . $encoded_encrypted_number . "&iv=" . urlencode($iv));
                        exit;
                    }
                    else {
                        header('Location: ' . $baseurl . 'dashboard');
                        exit;
                    }
                }
            } elseif($row['isAdmin'] == '3') {
                $isVerfiedSQL = mysqli_query($conn, "SELECT admin_verified FROM verified_teachers WHERE email = '$email'");
                $isVerifiedRow = mysqli_fetch_assoc($isVerfiedSQL);

                if($isVerifiedRow['admin_verified'] == '1') {
                    header( 'Location: ' . $baseurl . 'teacher/group' );
                    exit;
                } else {
                    $errMsg = '<div class="alert-danger p-2 mb-2" role="alert">Teacher email not verified by admin</div>';
                }
            } elseif($row['isAdmin'] == '1') {
                header( 'Location: ' . $baseurl . 'controlgear' );
                exit;
            }

        } else {
            $errMsg = '<div class="alert-danger p-2 mb-2" role="alert">Incorrect email or password</div>';
        }
    } else {
        $errMsg = '<div class="alert-danger w-100 p-2 mb-2">Email has been registered but not verified. <a href="javascript:void(0)" onclick="sendMail(`verification`, `'. $email .'`)">Resend Verfication Link</a></div>';
    }

    if(!empty($errMsg)) { ?>
        <script type="text/javascript">
        $(document).ready(function(){$("#loginModal").modal("show");});
        </script>
   <?php 
   } 
}

if (isset($_POST['register'])) {
    $user = $_POST['utype'];
	$name = $_POST['fullname'];
	$email = $_POST['email'];
	$contact = $_POST['mobile'];
	$pass = $_POST['password'];
    $cls = $_POST['clsName'];
    $school = $_POST['school'];
    $others = $_POST['others'] ?? "";
    $genrateotp = generateNumericOTP(6);
    $country_code = $_POST['countryCode'];

$emailsql = mysqli_query($conn, "SELECT email, status FROM users WHERE email='".$email."'");
$emailrow = mysqli_fetch_assoc($emailsql);

if($user == '1') {
if(empty($name) || empty($email) || empty($contact) || empty($pass) || empty($school) || empty($cls)) {
    $errMsg2 = '<div class="alert-danger w-100 p-2 mb-2">All fields required.</div>';
}
} elseif($user == '2') {
    if(empty($school)) {
    $errMsg2 = '<div class="alert-danger w-100 p-2 mb-2">All fields required.</div>';
    }
} 

if($emailrow['email'] == $email) {
    if($emailrow['status'] == '1') {
	    $errMsg2 = '<div class="alert-danger w-100 p-2 mb-2">Email already registered.</div>';
    } else {
        $errMsg2 = '<div class="alert-danger w-100 p-2 mb-2">Email has been registered but not verified. <a href="javascript:void(0)" onclick="sendMail(`verification`, `'. $email .'`)">Resend Verfication Link</a></div>';
    }
} else if(empty($errMsg2)) {


    if($school == 'others') {
        $schoolN = '';
    } else {
        $schoolN = $school;
    }

    $isAdmin = $user+1;

    $currentDateTime = date('Y-m-d H:i:s'); 

	mysqli_query( $conn, "INSERT INTO users(fullname,email,contact,password,confirmation_code,status,isAdmin,school,type,class,created_at,updated_at,country_code) 
    VALUES ('".$name."','".$email."','".$contact."','".md5($pass)."','".md5($genrateotp)."','0','".$isAdmin."','".$schoolN."','".$user."','".$cls."','$currentDateTime','$currentDateTime', '". $country_code ."')" );
	
    $usersql = mysqli_query($conn, "SELECT id,isAdmin FROM users WHERE id='".$conn->insert_id."'");
    $userrow = mysqli_fetch_array($usersql, MYSQLI_ASSOC);

    $usercntsql = mysqli_query($conn, "SELECT COUNT(type) as user_count FROM users WHERE type='".$user."'");
    $usercntrow = mysqli_fetch_array($usercntsql, MYSQLI_ASSOC);

    if($school == 'others') {
        mysqli_query( $conn, "INSERT INTO school_management(name,status,userid,created_at,updated_at) VALUES ('".$others."',1,'".$userrow['id']."',NOW(),NOW())" );
        
        $schsql = mysqli_query($conn, "select id from school_management order by id desc");
        $schrow = mysqli_fetch_array($schsql, MYSQLI_ASSOC);

        mysqli_query( $conn, "update users Set school='".$schrow['id']."',updated_at=NOW() WHERE id=".$userrow['id']."" );
    }
    
    if($user == '1') {
        $user = 'STU00'.$usercntrow['user_count'];
    } elseif($user == '2') {
        $user = 'TEC00'.$usercntrow['user_count'];
    }
    
    mysqli_query( $conn, "update users Set userid='".$user."',updated_at=NOW() WHERE id=".$userrow['id']."" );

    //$_SESSION[ 'id' ] = $userrow['id'];
   // session_start();
    //$_SESSION[ 'id' ];
    
    mysqli_close( $conn );
    //session_write_close();  
    
    include('mail.php');

    ?>
        <script>
            $(document).ready(function() {
                console.log("Hello");
                showToast({
                    title: "Email Sent!",
                    content: "An Email has been sent to the registered email id. Please click on the sent link to verify your account!",
                    imgBanner: "notif_mail.svg"
                });
            });
        </script>
    <?php
	
    if($userrow['isAdmin'] == '2') {
        // header('Location: ' . $baseurl . 'dashboard');
        $encoded_encrypted_number = "";
        if(SECRET_KEY) {
            $iv = openssl_random_pseudo_bytes(16);
            $encrypted_number = openssl_encrypt($userrow['id'], 'aes-256-cbc', SECRET_KEY, 0, $iv);
            $encoded_encrypted_number = urlencode(base64_encode($encrypted_number));
        }

        if(isset($_GET["modal"]) && isset($_GET["redirect"])) {
            header('Location: ' . urldecode($_GET["redirect"]) . "?data=" . $encoded_encrypted_number . "&iv=" . urlencode($iv));
        }
        else {
            // header('Location: ' . $baseurl . 'dashboard');
        }
    } elseif($userrow['isAdmin'] == '3') {
       header( 'Location: teacher/group' );
    }	
}
if(!empty($errMsg2)) { ?>
    <script type="text/javascript">
    $(document).ready(function(){
        $("#registerModal").modal("show");
    });
    </script>
<?php }
}

if(isset($_POST["contact"])) {
    $user_id = $_SESSION["id"];
    $subject = $_POST["subject-select"];
    $query_content = $_POST["query-content"];

    $sql = mysqli_query($conn, "INSERT INTO user_queries (user_id, subject, query_content, created_at, updated_at) VALUES ('$user_id', '$subject', '$query_content', NOW(), NOW())");
    if($row = mysqli_fetch_assoc($sql)){

    }
}

if(isset($_SESSION['id'])) {
    $loginDateSQL = mysqli_query($conn, "SELECT login_date FROM login_data WHERE userid = " . $_SESSION['id'] . " AND login_date = CURDATE()");
    $loginDateRow = mysqli_fetch_assoc($loginDateSQL);


    if(mysqli_num_rows($loginDateSQL) == 0) {
        $chkDatesSQL = mysqli_query($conn,"SELECT DISTINCT DATE(created_at) AS unique_dates, userid
                                            FROM leaderboard
                                            WHERE userid = '". $_SESSION['id'] ."'
                                            ORDER BY DATE(created_at) DESC");

        $prevdate = new DateTime(date("Y-m-d"));
        $streak = 1;
        while($streakRow = mysqli_fetch_assoc($chkDatesSQL)){
            $date = new DateTime($streakRow["unique_dates"]);
            $interval = $date->diff($prevdate);
            
            if($interval->days == 1) {
                $streak++;
            } else {
                break;
            }
    
            $prevdate = $date;
        }

        if($streak > 0) {
            $getStreakSQL = mysqli_query($conn,"SELECT b.id, b.score_multiplier, b.booster_icon, bc.minimum_day_streak
                                                FROM booster_criteria bc
                                                JOIN boosters b
                                                ON bc.booster = b.id
                                                WHERE bc.minimum_day_streak = $streak");

            if(mysqli_num_rows($getStreakSQL) > 0) {
                $getStreakRow = mysqli_fetch_assoc($getStreakSQL);

                ?>
                    <script>
                        $(document).ready(function(){
                            $.ajax({
                                type: "post",
                                url: "<?php echo $baseurl ?>ajax/addBooster",
                                data: {
                                    b_id: <?php echo $getStreakRow['id']; ?>
                                },
                                success: function(res) {
                                    var response =JSON.parse(res);

                                    if(response.status == "success") {
                                        setTimeout(() => showToast({ title: 'Daily Streak!', imgBanner: '<?php echo $getStreakRow['booster_icon'] ?>', content: 'You maintained a daily streak of <?php echo $getStreakRow['minimum_day_streak'] ?> days. You get a <?php echo $getStreakRow['score_multiplier'] ?>x booster!' }), 500);
                                        getBoosterCount();

                                    }
                                }
                            })
                        });
                    </script>
                <?php

                $streakClsSQL = mysqli_query($conn, "INSERT INTO login_data (userid, login_date) VALUES (". $_SESSION['id'] .", CURDATE())
                                                    ON DUPLICATE KEY UPDATE login_date = CURDATE()");
            }
        }
        
    }
}

if(isset($_POST['registeredEmailSubmit'])) {
    $emailchk = $_POST['regEmailInput'];

    $chkEmail = mysqli_query($conn, "SELECT confirmation_code FROM users WHERE email = '$emailchk'");

    if(mysqli_num_rows($chkEmail) > 0) {
        $chkEmailRow = mysqli_fetch_assoc($chkEmail);
        $genrateotpReg = $chkEmailRow['confirmation_code'];
        include("mail.php");

        ?>
        <script>
            $(document).ready(function() {
                console.log("Hello");
                showToast({
                    title: "Email Sent!",
                    content: "An Email has been sent to the registered email id. Please click on the sent link to reset your password!",
                    imgBanner: "notif_mail.svg"
                });
            });
        </script>
        <?php
    } else {
        $errMsgEmail = '<div class="alert-danger w-100 p-2 mb-2">No such email registered.</div>';
    }

    if(!empty($errMsgEmail)) { ?>
        <script type="text/javascript">
        $(document).ready(function(){
            $("#registeredEmailModal").modal("show");
        });
        </script>
    <?php }
}

if(isset($_POST['updatePasswordForgotBtn'])) {
    $userid = $_POST['hiddenPwdInput'];
    $pwd = $_POST['newPasswordForgotInput'];
    $pwdReenter = $_POST['newPasswordForgotInputReenter'];

    if($pwd !== $pwdReenter) {
        $errMsgPassword = '<div class="alert-danger w-100 p-2 mb-2">Passwords dont match.</div>';
    } else {
        mysqli_query($conn, "UPDATE users SET password = '". md5($pwd) ."' WHERE id='$userid'");

        ?>
            <script>
            $(document).ready(function() {
                $("#passwordForgotModal").modal("hide");
                showToast({
                    title: "Password Changed!",
                    content: "Your password has been changed!",
                    imgBanner: "notif_mail.svg"
                });
                window.location.href = "<?php echo $baseurl; ?>";
            });
            </script>
        <?php
    }

    if(!empty($errMsgPassword)) { ?>
        <script type="text/javascript">
        $(document).ready(function(){
            $("#passwordForgotModal").modal("show");
        });
        </script>
    <?php }
}

if(isset($_SESSION['id']) && isset($_POST['join-room'])) {
    include(__DIR__ . "/battle_functions.php");
    $room_id = $_POST['room-id-input'];

    $res_join = joinRoom($room_id);

    if($res_join['status'] == 'success') { ?>
        <script>
            window.location.href = "<?php echo $baseurl; ?>waiting_room?room=<?php echo urlencode($room_id); ?>";
        </script>
    <?php } else {
        $errMsgBattles = '<div class="alert-danger w-100 p-2 mb-2">'. $res_join['msg'] .'</div>';
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#battleModal").modal("show");
            });
        </script>
    <?php
    }
}

if(isset($_POST['guest-login'])) {
    $_SESSION['guest-class'] = $_POST['guest-class'];

    ?>
        <script>
            window.location.href = "<?php echo $baseurl; ?>dashboard";
        </script>
    <?php
}
?>
</main>
    <footer>
        <div class="footer pb-4 <?php if($page != 'index.php' && $page != 'dashboard.php' && $page != 'category.php') { echo "mt-4";} ?>">
            <div class="container <?php if($page != 'dashboard.php' && $page != 'category.php' && $page != 'practice.php' && $page != 'quiz.php' && $page != 'fastest.php' && $page != 'shortlist.php' && $link_array[count($link_array) - 2] !== 'chatbot' && $page !== 'game_room.php') { echo "bt-1";} ?>">
                <div class="row justify-content-center pt-4">
                    <?php if($page != 'dashboard.php' && $page != 'practice.php' && $link_array[count($link_array) - 2] !== 'chatbot' && $page != 'paper.php' && $page != 'quiz.php' && $page != 'fastest.php' && $page != 'leaderboard.php' && $page != 'category.php' && $page != 'shortlist.php' && $link_array[count($link_array) - 2] !== 'chatbot' && $page !== 'waiting_room.php' && $page !== 'game_room.php') { ?>
                        <div class="col-lg-5 col-12 pe-lg-5 mt-lg-4 pb-3">
                        <img class="mb-3" src="<?php echo $baseurl; ?>assets/images/wonderkids-logo.svg" width="200" height="22" alt="">
                        <p>We thrive to create values for kids, parents and teachers. Please feel free to write us/reach out to us if you have any queries/feedback/concerns/suggestions. </p>
                        <div class="social">
                            <a href="https://www.linkedin.com/in/wonderkids-club-a139942a3/" class="link" target="_blank"
                                title="LinkedIn"><img src="<?php echo $baseurl; ?>assets/images/linkedin-ico.svg" width="18" height="18" alt=""></a>
                            <a href="https://www.instagram.com/wonderkids54/" class="link"
                                target="_blank" title="Instagram"><img src="<?php echo $baseurl; ?>assets/images/instagram-ico.svg" width="18" height="18" alt=""></a>
                            <a href="https://www.facebook.com/profile.php?id=61554410427561" class="link" target="_blank"
                                title="Facebook"><img src="<?php echo $baseurl; ?>assets/images/facebook-ico.svg" width="18" height="18" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6 mt-md-4 mt-5">
                        <div class="footer-widget">
                            <h3 class="heading text-uppercase mb-3">Browse by Class</h3>
                            <ul class="list">
                            <?php 
                $sclwiseSQL = mysqli_query($conn, "SELECT id,name,slug FROM subject_class WHERE type=2 and status=1 order by id asc");
                while($sclwiseRow = mysqli_fetch_assoc($sclwiseSQL)) { ?>
                    <li>
                    <?php 
                    $topicsql = mysqli_query($conn, "SELECT DISTINCT subject_id FROM topics_subtopics WHERE class_id=".$sclwiseRow['id']." and parent=0 and status=1");
                    while($topicrow = mysqli_fetch_assoc($topicsql)) {

                    $subjectsql = mysqli_query($conn, "SELECT name,slug FROM subject_class WHERE id=".$topicrow['subject_id']." and status=1");
                    $subjectrow = mysqli_fetch_assoc($subjectsql);    

                    $topiCntsql = mysqli_query($conn, "SELECT COUNT(subtopic) as count FROM topics_subtopics WHERE class_id=".$sclwiseRow['id']." and subject_id=".$topicrow['subject_id']." and parent!=0 and status=1");
                    $topiCntrow = mysqli_fetch_assoc($topiCntsql); ?>
                                
                
                        <a href="<?php echo $subjectrow['slug'].'/'.$sclwiseRow['slug']; ?>">
                        <?php echo $sclwiseRow['name']; ?></a></li>
                        <?php } } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6 mt-md-4 mt-5">
                        <div class="footer-widget">
                            <h3 class="heading text-uppercase mb-3">Resources</h3>
                            <ul class="list">
                                <li><a href="<?php echo $baseurl; ?>">Home</a></li>
                                <li><a href="#">About us</a></li>
                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#contactModal">Contact us</a></li>
                                <li><a href="<?php echo $baseurl; ?>privacy-policy">Privacy Policy</a></li>
                                <li><a href="<?php echo $baseurl; ?>terms-and-conditions">Terms & Conditions</a></li>
                                <li><a href="<?php echo $baseurl; ?>disclaimer">Disclaimer</a></li>
                                <li><a href="<?php echo $baseurl; ?>copyright">Copyright</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-md-4 mt-5 mb-4">
                        <div class="footer-widget">
                            <h3 class="heading text-uppercase mb-3">Contact Information</h3>
                            <ul class="list list-flex d-flex flex-column">
                                <li><span class="ico"><img src="<?php echo $baseurl; ?>assets/images/mail.svg" width="20" height="20" alt=""></span><a href="#" data-bs-toggle="modal" data-bs-target="#contactModal"
                                        class="link">Contact Us</a></li>
                                <li>
                                    <span class="ico">
                                        <!-- <img src="<?php echo $baseurl; ?>assets/images/mail.svg" width="20" height="20" alt=""> -->
                                        @
                                    </span>
                                    <span style="min-width: 60px;">Write to </span>"<a href="mailto:support@wonderkids.club">support@wonderkids.club</a>"
                                </li>
                                <li>
                                    (Edtech product of Vaultboard Consulting Pvt Ltd) <br>
                                    980, 1st floor, <br>
                                    Sector-45 <br>
                                    Gurgaon (Hr) 122003
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($page != 'practice.php' && $link_array[count($link_array) - 2] !== 'chatbot' && $page != 'fastest.php' && $page != 'quiz.php' && $page != 'shortlist.php' && $page !== 'game_room.php') { ?>
                    <?php if($page != 'dashboard.php' && $page != 'practice.php' && $link_array[count($link_array) - 2] !== 'chatbot' && $page != 'paper.php' && $page != 'quiz.php' && $page != 'fastest.php' && $page != 'leaderboard.php' && $page != 'category.php') { ?>
                        <div class="col-md-12 mt-lg-5 mt-3">
                    <?php } else { ?>
                        <div class="col-md-12">
                    <?php } ?>
                        <div class="copyright">
                            Copyright &copy; 2023, <a href="<?php echo $baseurl; ?>" class="link">wonderkids.club</a>, all rights
                            reseved.
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </footer>
    </div>

    <div id="pdfDownloadModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="pdfDownloadLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-text">
                    <div class="row login-wrapper p-3">
                        <div class="text-end">
                            <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-lg-12 ps-lg-0">
                            <div class="loginform pb-4">
                                <div class="mb-3 ms-3">
                                    <h2 class="title">
                                        Download PDF 
                                    </h2>
                                </div>
                                <div class="form-signup p-0 mb-2" id="pdf-download-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="infoModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-text">
                    <div class="row login-wrapper p-3">
                        <div class="text-end">
                            <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-lg-12 ps-lg-0">
                            <div class="login-form pb-4">
                                <div class="mb-3 ms-3">
                                    <h2 class="title">Booster Info</h2>
                                </div>
                                <div class="form-signup p-0 mb-2">
                                    <div class="row">
                                        <div class="col-4"></div>
                                        <div class="col-4 text-center">
                                            <h4>Bonus</h4>
                                        </div>
                                        <div class="col-4 text-center">
                                            <h4>Criteria</h4>
                                        </div>
                                    </div>
                                    <div class="row booster-info p-1" id="booster-info">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="boosterModal" class="modal lg-rt-modal fade"  data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-text">
                    <div class="row login-wrapper p-3">
                        <div class="text-end">
                            <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-lg-12 ps-lg-0">
                            <div class="loginform">
                                <div class="mb-3 ms-3 rounded">
                                    <h2 class="title">
                                        Booster Info
                                    </h2>
                                </div>
                                <hr>
                                <div class="form-signup p-0 mb-2">
                                    <input type="hidden" id="hidden-booster-id" name="hidden-booster-id">
                                    <div class="row">
                                        <div class="col-5"></div>
                                        <div class="col-7 text-center">
                                            <h4>Bonus</h4>
                                        </div>
                                    </div>
                                    <div class="row p-2">
                                        <div class="booster-icon-img d-flex justify-content-center align-items-center col-5">
                                            <img height="100" width="100" alt="booster img" class="border p-2 rounded">
                                        </div>
                                        <div class="booster-info-content p-2 col-7"></div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-4"></div>
                                        <div class="booster-modal-btns d-flex justify-content-end align-items-center p-2 col-8">
                                            <button class="btn btn-primary custom-btn" id="booster-activate-btn">Activate</button>
                                            <button class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="battleLeaderboardModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-text">
                    <div class="row login-wrapper p-3">
                        <div class="text-end">
                            <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-lg-12 ps-lg-0">
                            <div class="loginform pb-4">
                                <div class="mb-3 ms-3">
                                    <h2 class="title">
                                        Leaderboard
                                    </h2>
                                </div>
                                <div class="form-signup p-0 mb-2">
                                    <?php 
    $getRankingSQL = mysqli_query($conn, "SELECT brp.user_id, brp.score, u.fullname, sm.name AS school, sc.name AS class, u.avatar,
                                                    RANK() OVER (ORDER BY brp.score DESC) AS ranking
                                            FROM battle_room_players brp
                                            JOIN users u ON brp.user_id = u.id
                                            JOIN school_management sm ON u.school = sm.id
                                            JOIN subject_class sc ON u.class = sc.id
                                            WHERE room_id = '$room_id' AND left_room = 0
                                            ORDER BY score DESC");
?>

<div id="leaderboard-modal-container">
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-12 p-2">
            <div class="leaderboard-wrapper">
                <div class="mb-3 text-md-start text-center d-flex flex-md-row flex-column align-items-center">
                    <h2 class="section-title flex-1 mb-2">Leaderboard <span class="note ms-1">- Battles</span></h2>
                </div>
                <ul class="leaderboard-list overallwise mb-5">
                    <?php 
                        while($getRankingRow = mysqli_fetch_assoc($getRankingSQL)) {
                            ?>
                                <li class="<?php echo $getRankingRow['user_id'] == $_SESSION['id'] ? "selected" : ""; ?>">
                                                                    <div class="data pe-0">
                                                                        <img class="featured1" src="<?php echo isset($getRankingRow["avatar"]) ? $baseurl . "assets/images/avatars/" . $getRankingRow["avatar"] : "assets/images/profile.jpg" ?>" width="25" height="25" alt="">
                                                                    </div>
                                                                    <div class="data w-100 text-center p-1">
                                                                        <div class="font15"><?php echo $getRankingRow['fullname'] ?? "Test"; ?></div>
                                                                        <!-- <div class="font13 txt-grey"><?php echo $schrow['name'] ?? "BVB Vidya School"; ?></div> -->
                                                                    </div>
                                                                    <div class="data text-center">
                                                                        <div class="font15"><?php echo $getRankingRow['score'] ?? 100; ?></div>
                                                                        <div class="font13 txt-grey">Score</div>
                                                                    </div>
                                                                    <div class="data text-center flex-1">
                                                                        <div class="font15"><?php echo $getRankingRow['ranking'] ?? 1; ?></div>
                                                                        <div class="font13 txt-grey">Rank</div>
                                                                    </div>
                                                                </li>
                            <?php
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div> 
</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="withoutLoginModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-text">
                    <div class="row login-wrapper p-3">
                        <div class="text-end">
                            <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-lg-12 ps-lg-0">
                            <div class="loginform pb-4">
                                <div class="form-signup p-2 mb-2">
                                    <h2 class="title">
                                    Register for free / Login to explore this feature
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="messageModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-text">
                    <div class="row login-wrapper p-3">
                        <div class="text-end">
                            <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-lg-12 ps-lg-0">
                            <div class="loginform pb-4">
                                <div class="mb-3 ms-3">
                                    <h2 class="title">
                                        Messages
                                    </h2>
                                </div>
                                <div class="form-signup p-0 mb-2">
                                    <div class="message-types" id="message-types"></div>
                                    <div class="messages" id="messages"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="registeredEmailModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-text">
                    <div class="row login-wrapper p-3">
                        <div class="text-end">
                            <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-lg-12 ps-lg-0">
                            <div class="loginform pb-4">
                                <div class="mb-3 ms-3">
                                    <h2 class="title">
                                        Forgot Password
                                    </h2>
                                </div>
                                <div class="form-signup p-0 mb-2 password-change">
                                    <div class="p-2 rounded" id="reg-email-msg">
                                    <?php if(isset($errMsgEmail)){ echo "".$errMsgEmail.""; } ?>
                                    </div>
                                    <form action="" method="post">
                                        <div class="row p-3">
                                            <label for="regEmailInput" class="form-label">Enter Registered Email</label>
                                            <input type="email" id="regEmailInput" name="regEmailInput" class="form-control" aria-describedby="passwordHelpBlock">
                                        </div>
                                        <div class="p-3 d-flex align-items-center justify-content-center">
                                            <input type="submit" name="registeredEmailSubmit" class="btn btn-primary custom-btn" id="regEmailBtn" value="Send Reset Link">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="passwordForgotModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-text">
                    <div class="row login-wrapper p-3">
                        <div class="text-end">
                            <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-lg-12 ps-lg-0">
                            <div class="loginform pb-4">
                                <div class="mb-3 ms-3">
                                    <h2 class="title">
                                        Update Password
                                    </h2>
                                </div>
                                <div class="form-signup p-0 mb-2 password-change">
                                    <div class="p-2 rounded" id="password-msg">
                                    <?php if(isset($errMsgPassword)){ echo "".$errMsgPassword.""; } ?>
                                    </div>
                                    <form action="<?php echo $baseurl; ?>" method="post">
                                        <input type="hidden" id="hiddenPwdInput" name="hiddenPwdInput">
                                        <div class="row p-3">
                                            <label for="newPasswordInput" class="form-label">Enter New Password</label>
                                            <input type="password" id="newPasswordForgotInput" name="newPasswordForgotInput" class="form-control" aria-describedby="passwordHelpBlock">
                                        </div>
                                        <div class="row p-3">
                                            <label for="newPasswordInputReenter" class="form-label">Re-Enter New Password</label>
                                            <input type="password" id="newPasswordForgotInputReenter" name="newPasswordForgotInputReenter" class="form-control" aria-describedby="passwordHelpBlock">
                                        </div>
                                        <div class="p-3 d-flex align-items-center justify-content-center">
                                            <button type="submit" name="updatePasswordForgotBtn" class="btn btn-primary custom-btn" id="updatePasswordForgotBtn">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="passwordChangeModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-text">
                    <div class="row login-wrapper p-3">
                        <div class="text-end">
                            <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-lg-12 ps-lg-0">
                            <div class="loginform pb-4">
                                <div class="mb-3 ms-3">
                                    <h2 class="title">
                                        Update Password
                                    </h2>
                                </div>
                                <div class="form-signup p-0 mb-2 password-change">
                                    <div class="p-2 rounded" id="password-msg" style="display:none"></div>
                                    <div class="row p-3">
                                        <label for="oldPasswordInput" class="form-label">Enter Old Password</label>
                                        <input type="password" id="oldPasswordInput" class="form-control" aria-describedby="passwordHelpBlock">
                                    </div>
                                    <div class="row p-3">
                                        <label for="newPasswordInput" class="form-label">Enter New Password</label>
                                        <input type="password" id="newPasswordInput" class="form-control" aria-describedby="passwordHelpBlock">
                                    </div>
                                    <div class="row p-3">
                                        <label for="newPasswordInputReenter" class="form-label">Re-Enter New Password</label>
                                        <input type="password" id="newPasswordInputReenter" class="form-control" aria-describedby="passwordHelpBlock">
                                    </div>
                                    <div class="p-3 d-flex align-items-center justify-content-center">
                                        <button class="btn btn-primary custom-btn" id="updatePasswordBtn">Save Changes</button>
                                        <button class="btn btn-primary custom-btn" id="updatePasswordWindowBtn" style="display:none" onclick="location.reload()">Go Back</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="schoolClassUpdateModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-text">
                    <div class="row login-wrapper p-3">
                        <div class="text-end">
                            <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-lg-12 ps-lg-0">
                            <div class="loginform pb-4">
                                <div class="mb-3 ms-3">
                                    <h2 class="title">
                                        Update School / Class
                                    </h2>
                                </div>
                                <div class="form-signup p-0 mb-2 update-class-school">
                                    <div class="msg p-2 rounded" id="password-msg" style="display:none">Succefully updated!</div>
                                    <div class="row p-3">
                                        <label for="updateClass">Select Class</label>
                                        <select id="updateClass" class="form-select"></select>
                                    </div>
                                    <div class="row p-3">
                                        <label for="updateSchool">Enter School Name</label>
                                        <select id="updateSchool" class="form-select"></select>
                                    </div>
                                    <div class="row p-3">
                                        <input type="text" id="updateSchoolOther" placeholder="Type your school name here..." style="display:none">
                                    </div>
                                    <div class="p-3 d-flex align-items-center justify-content-center">
                                        <button class="btn btn-primary custom-btn" id="updateClassSchoolBtn">Save Changes</button>
                                        <button class="btn btn-primary custom-btn" id="updateClassSchoolWindowBtn" style="display:none" onclick="location.reload()">Go Back</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="levelUpModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-text">
                    <div class="row login-wrapper p-3">
                        <div class="text-end">
                            <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-lg-12 ps-lg-0">
                            <div class="loginform pb-4">
                                <div class="mb-3 ms-3">
                                    <h2 class="title">
                                        Level Up
                                    </h2>
                                </div>
                                <div class="form-signup p-0 mb-2">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="<?php echo $baseurl; ?>assets/images/level-up.jpg" class="rounded-circle me-2" height="100" width="100" alt="level up icon">
                                    </div>
                                    <div class="level-container d-flex flex-column align-items-center justify-content-evenly">
                                        <div class="progress-container">
                                            <div class="progress-bar" id="progress"></div>
                                        </div>
                                        <div class="level-text">You have moved up to LEVEL <?php echo $chkLevelRow['level']; ?> out of <?php echo $cntSbtpRow['total_levels']; ?></div>
                                    </div>
                                    <div class="p-2 text-center">
                                        You have become a Number Ninja for this subtopic. You can browse other subtopics now or continue with these questions.
                                    </div>
                                    <div class="d-flex w-100 justify-content-evenly align-items-center p-2">
                                        <a href="../../<?php echo $clsrow['slug']; ?>"><button class="btn btn-primary custom-btn p-2" style="height: auto; width: 100px">Back To <br> Topics</button></a>
                                        <a href="#"><button class="btn btn-primary custom-btn p-2" onclick="window.location.reload()" style="height: auto; width: 100px">Continue <br> Here</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="battleModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-text">
                    <div class="row login-wrapper p-3">
                        <div class="text-end">
                            <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-lg-12 ps-lg-0">
                            <div class="loginform pb-4">
                                <div class="mb-3 ms-3">
                                    <h2 class="title">
                                        Battles
                                    </h2>
                                </div>
                                <div class="p-2 rounded" id="battle-msg">
                                    <?php if(isset($errMsgBattles)){ echo "".$errMsgBattles.""; } ?>
                                </div>
                                <div class="form-signup p-0 mb-2">
                                    <form action="" method="post" class="mb-3">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="room-id-input" id="room-id-input" placeholder="Enter Room ID">
                                        </div>
                                        <div class="input-group mb-3">
                                            <input type="submit" value="Join Room" name="join-room" id="join-room" class="btn btn-primary custom-btn">
                                        </div>
                                    </form>

                                    <hr>

                                    <div class="input-group mb-2 mt-3 d-flex align-items-center justify-content-center">
                                        <a href="createRoom"><button type="button" class="btn btn-primary custom-btn">Create a Room</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="messageModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-text">
                    <div class="row login-wrapper p-3">
                        <div class="text-end">
                            <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-lg-12 ps-lg-0">
                            <div class="loginform pb-4">
                                <div class="mb-3 ms-3">
                                    <h2 class="title">
                                        Messages
                                    </h2>
                                </div>
                                <div class="form-signup p-0 mb-2">
                                    <div class="message-types" id="message-types"></div>
                                    <div class="messages" id="messages"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="contactModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body popup-text">
                    <div class="row login-wrapper p-3">
                        <div class="text-end">
                            <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-lg-12 ps-lg-0">
                            <div class="loginform pb-4">
                                <div class="mb-3 ms-3">
                                    <h2 class="title">
                                        Contact Us
                                    </h2>
                                </div>
                                <div class="form-signup p-0 mb-2">
                                    <form action="" method="post" class="w-100 p-2">
                                        <div class="input-group mb-2" style="height: 30px">
                                            <select name="subject-select" id="form-select" class="w-100">
                                                <option value="" selected disabled>Select Subject</option>
                                                <option value="Feedback/Suggestions">Feedback/Suggestions</option>
                                                <option value="Complaints">Complaints</option>
                                                <option value="Collaborations">Collaborations</option>
                                                <option value="Payment & Refunds">Payment & Refunds</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                        <div class="input-group mb-2">
                                            <textarea name="query-content" id="" class="w-100" cols="30" rows="10" placeholder="Please type your query here"></textarea>
                                        </div>
                                        <div class="m-2 w-100">
                                            <input type="submit" class="btn btn-primary custom-btn" name="contact" value="Submit">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <div id="loginModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body popup-text">
            <div class="row login-wrapper">
                        <div class="col-lg-6 p-0 tab-none">
                            <div class="image-container">
                                <img class="img-fit" src="<?php echo $baseurl; ?>assets/images/login.jpg" width="320" alt="">
                            </div>
                        </div>                        
                        <div class="col-lg-6 ps-lg-0">
                            <div class="p-3">
                            <div class="text-end">
                                <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
</svg>
</button>
                            </div>
                            <div class="loginform pb-4">
                            <div class="mb-3">
                                <h2 class="title">Login</h2>
                            </div>
                                                    <div class="form-signup p-0 mb-2">
                                                    <?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
                        <form action="" method="post">
                            <div class="mb-2">
                                <input type="text" name="email" class="form-control emailtxt" placeholder="Enter Email" required>
                            </div>
                            <div class="mb-2">
                                <div class="input-group input-append">  
                                    <input type="password" name="tp_pass" id="tp_pass" class="form-control tp_pass noSpacesField" autocomplete="off" placeholder="Login Password" required>
                                    <div class="input-group-append">
                                      <button class="btn btn-link eye-off" id="viewButton" type="button"><img src="<?php echo $baseurl; ?>assets/images/eye-off.svg" width="22"></button>
                                    </div>                                   
                                  </div>                                 
                            </div>
                        <div class="mb-2 text-start btn-wrapper mt-3">
                        <input type="submit" name="login" class="btn btn-animated btn-lg" value="Login">
                    </div>
                    </form>
                    
                        </div> 
                        <div class="link text-center">
                            New to Wonderkids? <a class="registerModal" href="#register" data-bs-toggle="modal" data-bs-target="#registerModal">Create account</a>
                        </div>  
                        <div class="link text-center mt-3">
                            <a class="registerModal" href="#register" data-bs-toggle="modal" data-bs-target="#registeredEmailModal">Forgot Password</a>
                        </div>

                        <hr>

                    <form class="mt-2 mb-3" action="" method="post">
                        <h6 class="pb-2">
                            Login As Guest
                        </h6>

                        <div class="input-group mb-3">
                            <?php 
                                $getAllClassesSQL = mysqli_query($conn, "SELECT id, name FROM subject_class WHERE type = 2 AND status = 1");
                            ?>
                            <select name="guest-class" class="form-select">
                                <option value="" selected disabled>Select Class</option>
                                <?php while($getAllClassesRow = mysqli_fetch_assoc($getAllClassesSQL)) { ?>
                                    <option value="<?php echo $getAllClassesRow['id'] ?>"><?php echo $getAllClassesRow['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-2 text-start btn-wrapper mt-2">
                        <input type="submit" name="guest-login" class="btn btn-animated btn-sm" value="Login As Guest">
                    </div>
                    </form>
                    </div> 
                         
                        </div>             
                        </div>
                    </div></div>
            </div>
        </div>
    </div>
</div>
</div>

<div id="registerModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body popup-text">
            <div class="row login-wrapper">
                        <div class="col-md-6 p-0 tab-none">
                            <div class="image-container">
                                <img class="img-fit" src="<?php echo $baseurl; ?>assets/images/registration.jpg" width="320" height="450" alt="">
                            </div>
                        </div>                        
                        <div class="col-lg-6 ps-lg-0">
                            <div class="p-3">
                            <div class="text-end">
                                <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
</svg>
</button>
                            </div>
                            <div class="mb-3">
                                <h2 class="title">Register</h2>
                            </div>
                                                    <div class="form-signup p-0 mb-2">
                                                    <?php if(isset($errMsg2)){ echo $errMsg2; } ?>
                                                    <form id="lsForm" method="post" enctype="multipart/form-data">
                                                        <div class="mb-2 multi-btn userType">
                                                        <div class="check-btn">
                                        <input class="form-check-input" type="radio" name="utype" value="1" id="utype_1" checked>
                                        <div class="label-wrapper">
                                            <label for="utype_1"></label>
                                            <span class="notchecked">Student</span>
                                        </div>
                                    </div>
                                    <div class="check-btn">
                                    <input class="form-check-input" type="radio" name="utype" value="2" id="utype_2">
                                        <div class="label-wrapper">
                                            <label for="utype_2"></label>
                                            <span class="notchecked">Teacher</span>
                                        </div>
                                    </div>
                                                        </div>
                        <div class="mb-2 form-group">
                            <input type="text" name="fullname" class="form-control" placeholder="Student Fullname" value="<?php echo $_REQUEST['fullname']; ?>">
                            <span class="error"></span>
                        </div>
                        <div class="mb-2 form-group">
                            <input type="email" name="email" class="form-control emailtxt" placeholder="Email" value="<?php echo $_REQUEST['email']; ?>" required>
                            <span class="error"></span>
                        </div>
                        <div class="mb-2 form-group">
                              <div class="input-group">
                                <div class="input-group-prepend col-4 p-0 br-rtb">
                                  <select width="30" name="countryCode" id="countryCode" class="form-control">
		<option data-countryCode="DZ" value="213">Algeria (+213)</option>
		<option data-countryCode="AD" value="376">Andorra (+376)</option>
		<option data-countryCode="AO" value="244">Angola (+244)</option>
		<option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
		<option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
		<option data-countryCode="AR" value="54">Argentina (+54)</option>
		<option data-countryCode="AM" value="374">Armenia (+374)</option>
		<option data-countryCode="AW" value="297">Aruba (+297)</option>
		<option data-countryCode="AU" value="61">Australia (+61)</option>
		<option data-countryCode="AT" value="43">Austria (+43)</option>
		<option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
		<option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
		<option data-countryCode="BH" value="973">Bahrain (+973)</option>
		<option data-countryCode="BD" value="880">Bangladesh (+880)</option>
		<option data-countryCode="BB" value="1246">Barbados (+1246)</option>
		<option data-countryCode="BY" value="375">Belarus (+375)</option>
		<option data-countryCode="BE" value="32">Belgium (+32)</option>
		<option data-countryCode="BZ" value="501">Belize (+501)</option>
		<option data-countryCode="BJ" value="229">Benin (+229)</option>
		<option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
		<option data-countryCode="BT" value="975">Bhutan (+975)</option>
		<option data-countryCode="BO" value="591">Bolivia (+591)</option>
		<option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
		<option data-countryCode="BW" value="267">Botswana (+267)</option>
		<option data-countryCode="BR" value="55">Brazil (+55)</option>
		<option data-countryCode="BN" value="673">Brunei (+673)</option>
		<option data-countryCode="BG" value="359">Bulgaria (+359)</option>
		<option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
		<option data-countryCode="BI" value="257">Burundi (+257)</option>
		<option data-countryCode="KH" value="855">Cambodia (+855)</option>
		<option data-countryCode="CM" value="237">Cameroon (+237)</option>
		<option data-countryCode="CA" value="1">Canada (+1)</option>
		<option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
		<option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
		<option data-countryCode="CF" value="236">Central African Republic (+236)</option>
		<option data-countryCode="CL" value="56">Chile (+56)</option>
		<option data-countryCode="CN" value="86">China (+86)</option>
		<option data-countryCode="CO" value="57">Colombia (+57)</option>
		<option data-countryCode="KM" value="269">Comoros (+269)</option>
		<option data-countryCode="CG" value="242">Congo (+242)</option>
		<option data-countryCode="CK" value="682">Cook Islands (+682)</option>
		<option data-countryCode="CR" value="506">Costa Rica (+506)</option>
		<option data-countryCode="HR" value="385">Croatia (+385)</option>
		<option data-countryCode="CU" value="53">Cuba (+53)</option>
		<option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
		<option data-countryCode="CY" value="357">Cyprus South (+357)</option>
		<option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
		<option data-countryCode="DK" value="45">Denmark (+45)</option>
		<option data-countryCode="DJ" value="253">Djibouti (+253)</option>
		<option data-countryCode="DM" value="1809">Dominica (+1809)</option>
		<option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
		<option data-countryCode="EC" value="593">Ecuador (+593)</option>
		<option data-countryCode="EG" value="20">Egypt (+20)</option>
		<option data-countryCode="SV" value="503">El Salvador (+503)</option>
		<option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
		<option data-countryCode="ER" value="291">Eritrea (+291)</option>
		<option data-countryCode="EE" value="372">Estonia (+372)</option>
		<option data-countryCode="ET" value="251">Ethiopia (+251)</option>
		<option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
		<option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
		<option data-countryCode="FJ" value="679">Fiji (+679)</option>
		<option data-countryCode="FI" value="358">Finland (+358)</option>
		<option data-countryCode="FR" value="33">France (+33)</option>
		<option data-countryCode="GF" value="594">French Guiana (+594)</option>
		<option data-countryCode="PF" value="689">French Polynesia (+689)</option>
		<option data-countryCode="GA" value="241">Gabon (+241)</option>
		<option data-countryCode="GM" value="220">Gambia (+220)</option>
		<option data-countryCode="GE" value="7880">Georgia (+7880)</option>
		<option data-countryCode="DE" value="49">Germany (+49)</option>
		<option data-countryCode="GH" value="233">Ghana (+233)</option>
		<option data-countryCode="GI" value="350">Gibraltar (+350)</option>
		<option data-countryCode="GR" value="30">Greece (+30)</option>
		<option data-countryCode="GL" value="299">Greenland (+299)</option>
		<option data-countryCode="GD" value="1473">Grenada (+1473)</option>
		<option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
		<option data-countryCode="GU" value="671">Guam (+671)</option>
		<option data-countryCode="GT" value="502">Guatemala (+502)</option>
		<option data-countryCode="GN" value="224">Guinea (+224)</option>
		<option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
		<option data-countryCode="GY" value="592">Guyana (+592)</option>
		<option data-countryCode="HT" value="509">Haiti (+509)</option>
		<option data-countryCode="HN" value="504">Honduras (+504)</option>
		<option data-countryCode="HK" value="852">Hong Kong (+852)</option>
		<option data-countryCode="HU" value="36">Hungary (+36)</option>
		<option data-countryCode="IS" value="354">Iceland (+354)</option>
		<option data-countryCode="IN" value="91" selected>India (+91)</option>
		<option data-countryCode="ID" value="62">Indonesia (+62)</option>
		<option data-countryCode="IR" value="98">Iran (+98)</option>
		<option data-countryCode="IQ" value="964">Iraq (+964)</option>
		<option data-countryCode="IE" value="353">Ireland (+353)</option>
		<option data-countryCode="IL" value="972">Israel (+972)</option>
		<option data-countryCode="IT" value="39">Italy (+39)</option>
		<option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
		<option data-countryCode="JP" value="81">Japan (+81)</option>
		<option data-countryCode="JO" value="962">Jordan (+962)</option>
		<option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
		<option data-countryCode="KE" value="254">Kenya (+254)</option>
		<option data-countryCode="KI" value="686">Kiribati (+686)</option>
		<option data-countryCode="KP" value="850">Korea North (+850)</option>
		<option data-countryCode="KR" value="82">Korea South (+82)</option>
		<option data-countryCode="KW" value="965">Kuwait (+965)</option>
		<option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
		<option data-countryCode="LA" value="856">Laos (+856)</option>
		<option data-countryCode="LV" value="371">Latvia (+371)</option>
		<option data-countryCode="LB" value="961">Lebanon (+961)</option>
		<option data-countryCode="LS" value="266">Lesotho (+266)</option>
		<option data-countryCode="LR" value="231">Liberia (+231)</option>
		<option data-countryCode="LY" value="218">Libya (+218)</option>
		<option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
		<option data-countryCode="LT" value="370">Lithuania (+370)</option>
		<option data-countryCode="LU" value="352">Luxembourg (+352)</option>
		<option data-countryCode="MO" value="853">Macao (+853)</option>
		<option data-countryCode="MK" value="389">Macedonia (+389)</option>
		<option data-countryCode="MG" value="261">Madagascar (+261)</option>
		<option data-countryCode="MW" value="265">Malawi (+265)</option>
		<option data-countryCode="MY" value="60">Malaysia (+60)</option>
		<option data-countryCode="MV" value="960">Maldives (+960)</option>
		<option data-countryCode="ML" value="223">Mali (+223)</option>
		<option data-countryCode="MT" value="356">Malta (+356)</option>
		<option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
		<option data-countryCode="MQ" value="596">Martinique (+596)</option>
		<option data-countryCode="MR" value="222">Mauritania (+222)</option>
		<option data-countryCode="YT" value="269">Mayotte (+269)</option>
		<option data-countryCode="MX" value="52">Mexico (+52)</option>
		<option data-countryCode="FM" value="691">Micronesia (+691)</option>
		<option data-countryCode="MD" value="373">Moldova (+373)</option>
		<option data-countryCode="MC" value="377">Monaco (+377)</option>
		<option data-countryCode="MN" value="976">Mongolia (+976)</option>
		<option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
		<option data-countryCode="MA" value="212">Morocco (+212)</option>
		<option data-countryCode="MZ" value="258">Mozambique (+258)</option>
		<option data-countryCode="MN" value="95">Myanmar (+95)</option>
		<option data-countryCode="NA" value="264">Namibia (+264)</option>
		<option data-countryCode="NR" value="674">Nauru (+674)</option>
		<option data-countryCode="NP" value="977">Nepal (+977)</option>
		<option data-countryCode="NL" value="31">Netherlands (+31)</option>
		<option data-countryCode="NC" value="687">New Caledonia (+687)</option>
		<option data-countryCode="NZ" value="64">New Zealand (+64)</option>
		<option data-countryCode="NI" value="505">Nicaragua (+505)</option>
		<option data-countryCode="NE" value="227">Niger (+227)</option>
		<option data-countryCode="NG" value="234">Nigeria (+234)</option>
		<option data-countryCode="NU" value="683">Niue (+683)</option>
		<option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
		<option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
		<option data-countryCode="NO" value="47">Norway (+47)</option>
		<option data-countryCode="OM" value="968">Oman (+968)</option>
		<option data-countryCode="PW" value="680">Palau (+680)</option>
		<option data-countryCode="PA" value="507">Panama (+507)</option>
		<option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
		<option data-countryCode="PY" value="595">Paraguay (+595)</option>
		<option data-countryCode="PE" value="51">Peru (+51)</option>
		<option data-countryCode="PH" value="63">Philippines (+63)</option>
		<option data-countryCode="PL" value="48">Poland (+48)</option>
		<option data-countryCode="PT" value="351">Portugal (+351)</option>
		<option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
		<option data-countryCode="QA" value="974">Qatar (+974)</option>
		<option data-countryCode="RE" value="262">Reunion (+262)</option>
		<option data-countryCode="RO" value="40">Romania (+40)</option>
		<option data-countryCode="RU" value="7">Russia (+7)</option>
		<option data-countryCode="RW" value="250">Rwanda (+250)</option>
		<option data-countryCode="SM" value="378">San Marino (+378)</option>
		<option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
		<option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
		<option data-countryCode="SN" value="221">Senegal (+221)</option>
		<option data-countryCode="CS" value="381">Serbia (+381)</option>
		<option data-countryCode="SC" value="248">Seychelles (+248)</option>
		<option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
		<option data-countryCode="SG" value="65">Singapore (+65)</option>
		<option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
		<option data-countryCode="SI" value="386">Slovenia (+386)</option>
		<option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
		<option data-countryCode="SO" value="252">Somalia (+252)</option>
		<option data-countryCode="ZA" value="27">South Africa (+27)</option>
		<option data-countryCode="ES" value="34">Spain (+34)</option>
		<option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
		<option data-countryCode="SH" value="290">St. Helena (+290)</option>
		<option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
		<option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
		<option data-countryCode="SD" value="249">Sudan (+249)</option>
		<option data-countryCode="SR" value="597">Suriname (+597)</option>
		<option data-countryCode="SZ" value="268">Swaziland (+268)</option>
		<option data-countryCode="SE" value="46">Sweden (+46)</option>
		<option data-countryCode="CH" value="41">Switzerland (+41)</option>
		<option data-countryCode="SI" value="963">Syria (+963)</option>
		<option data-countryCode="TW" value="886">Taiwan (+886)</option>
		<option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
		<option data-countryCode="TH" value="66">Thailand (+66)</option>
		<option data-countryCode="TG" value="228">Togo (+228)</option>
		<option data-countryCode="TO" value="676">Tonga (+676)</option>
		<option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
		<option data-countryCode="TN" value="216">Tunisia (+216)</option>
		<option data-countryCode="TR" value="90">Turkey (+90)</option>
		<option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
		<option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
		<option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
		<option data-countryCode="TV" value="688">Tuvalu (+688)</option>
		<option data-countryCode="UG" value="256">Uganda (+256)</option>
		<option data-countryCode="GB" value="44">UK (+44)</option>
		<option data-countryCode="UA" value="380">Ukraine (+380)</option>
		<option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
		<option data-countryCode="UY" value="598">Uruguay (+598)</option>
		<option data-countryCode="US" value="1">USA (+1)</option>
		<option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
		<option data-countryCode="VU" value="678">Vanuatu (+678)</option>
		<option data-countryCode="VA" value="379">Vatican City (+379)</option>
		<option data-countryCode="VE" value="58">Venezuela (+58)</option>
		<option data-countryCode="VN" value="84">Vietnam (+84)</option>
		<option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
		<option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
		<option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
		<option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
		<option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
		<option data-countryCode="ZM" value="260">Zambia (+260)</option>
		<option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
</select>
                                </div>

                                <input type="tel" name="mobile" id="mobile" class="form-control col-8" onBlur="checkMobAvailability()" placeholder="Enter mobile number"
                                    autocomplete="off" value="<?php echo $_REQUEST['mobile']; ?>" >
                                      </div>
                            <span id="user-number-status" class="msg"><?php if(isset($errMsg)){ echo "<label class='error'>".$errMsg."</label>"; } ?></span>
                            <span class="error"></span>
                        </div>
                        <div class="mb-2 form-group">
                            <div class="input-group input-append">  
                                <input type="password" name="password" id="password" class="form-control tp_pass noSpacesField" autocomplete="off" placeholder="Login Password">
                                <div class="input-group-append">
                                  <button class="btn btn-link form-control eye-off" id="viewButton" type="button"><img src="<?php echo $baseurl; ?>assets/images/eye-off.svg" width="22"></button>
                                </div>
                              </div>
                              <span class="error"></span>
                        </div>
                        <div class="mb-2 form-group">
                        <select name="clsName" id="clsName" class="form-select">
                                    <option value="" selected disabled>Select Class</option>
                                    <?php 
                                    $catsql = mysqli_query($conn, "SELECT id,name from subject_class WHERE type=2 and status=1 order by id asc");
                                    while($catrow = mysqli_fetch_array($catsql)) { ?>
                                        <option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['name']; ?></option>
                                    <?php } ?>
                                    </select>  
                                    <span class="error"></span>
                    </div>
                        <div class="mb-2 form-group">
                        <select name="school" id="school" class="form-select">
                                    <option value="" selected disabled>Select School</option>
                                    <option value="others">Others</option>
                                    <?php 
                                    $catsql = mysqli_query($conn, "SELECT id,name,short_form from school_management WHERE status=1 order by name asc");
                                    while($catrow = mysqli_fetch_array($catsql)) { ?>
                                        <option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['name']; ?><?php if(!empty($catrow['short_form'])) { echo ' ('.$catrow['short_form'].')'; } ?></option>
                                    <?php } ?>
                                    </select>
                                    <span class="error" id="error-message"></span>
                        </div>
                        <div class="mb-2 form-group others hide">
                                <input type="text" name="others" class="form-control" placeholder="School Name">
                                <span class="error"></span>
                            </div>
                        <div class="mb-2 text-center btn-wrapper mt-3">
                        <input type="submit" name="register" class="btn btn-animated btn-lg" value="Register">
                    </div>
                    </form>
                        </div> 
                        <div class="link text-center">
                        Already have an account? <a class="loginModal" href="#login" data-bs-toggle="modal" data-bs-target="#loginModal">Sign in</a>
                        </div>               
                        </div>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<?php if($page !== "practice.php" && $link_array[count($link_array) - 2] !== 'chatbot') {
    unset($_SESSION["prev_ques"]);
} ?>
<?php if(isset($_SESSION["id"])) { ?>
    <script>

        $(document).ready(() => {

            $(document).ready(function() {
                $(".dropdown-submenu a.dropdown-item").on("click", function(e) {
                    e.stopPropagation(); // Prevent the default behavior
                    $(this).next('ul').toggle(); // Toggle the submenu
                });
            });

        $('#updatePasswordBtn').on('click', () => {
            if($('#oldPasswordInput').val() == ''
            || $('#newPasswordInput').val() == ''
            || $('#newPasswordInputReenter').val() == '') {
                $('#password-msg').removeClass('msg');
                $('#password-msg').addClass('err-msg');
                $('#password-msg').text("Please Fill all the fields!");
                $('#password-msg').show();
                return;
            }

            $.ajax({
                type: "post",
                url: "<?php echo $baseurl; ?>ajax/validatePasswordAjax",
                data: {
                    old_password: $('#oldPasswordInput').val(),
                    new_password: $('#newPasswordInput').val(),
                    new_password_again: $('#newPasswordInputReenter').val()
                },
                success: function(res) {
                    var response = JSON.parse(res);

                    if(response.status == 200) {
                        $('#password-msg').addClass('msg');
                        $('#password-msg').removeClass('err-msg');

                        $('#updatePasswordBtn').hide();
                        $('#updatePasswordWindowBtn').show();
                    } else {
                        $('#password-msg').removeClass('msg');
                        $('#password-msg').addClass('err-msg');
                    }
                    
                    $('#password-msg').text(response.msg);
                    $('#password-msg').show();

                }
            });
        });

        $('#schoolClassUpdateModal').on('show.bs.modal', function() {
            $.ajax({
                type: "get",
                url: "<?php echo $baseurl; ?>ajax/getModalData?select=class_school",
                success: function(res) {
                    var response = JSON.parse(res);

                    $('#updateClass').empty();

                    $.each(response.classArr, function (index, class_name) {
                        $('#updateClass').append($('<option>', {
                            value: class_name.id,
                            text: class_name.name,
                            selected: class_name.id == response.student_class ? true : false
                        }));
                    });

                    $.each(response.schoolArr, function(index, school_name) {
                        var option = $('<option>', {
                            value: school_name.id,
                            text: school_name.name,
                            selected: school_name.id == response.student_school ? true : false
                        });

                        $('#updateSchool').append(option);
                    });

                    $('#updateSchool').append($('<option>', {
                        value: 0,
                        text: "Other"
                    }));

                    $('#updateSchool').on('change', function(){
                        if($('#updateSchool').val() == 0) {
                            $('#updateSchoolOther').show();
                        }
                    })
                }
            });

            $('#updateClassSchoolBtn').on('click', function() {
                var selClass = $('#updateClass').val();
                var selSchool = $('#updateSchool').val();
                var selOtherSchool = 0;

                if(selSchool == 0) {
                    selOtherSchool = $('#updateSchoolOther').val();
                }
                $.ajax({
                    type: "post",
                    url: "<?php echo $baseurl; ?>ajax/insertOtherSchoolAjax",
                    data: {
                        school_name: selOtherSchool
                    },
                    success: function(res) {
                        var response = JSON.parse(res);

                        if(selSchool == 0) {
                            selSchool = response;
                        }

                        $.ajax({
                            type: "post",
                            url: "<?php echo $baseurl; ?>ajax/updateSchoolClassAjax",
                            data: {
                                class_id: selClass,
                                school_id: selSchool
                            },
                            success: function(res1) {
                                var response1 = JSON.parse(res1);
                                $('.update-class-school .msg').show();
                                if(response1 == 'success') {
                                    $('.update-class-school .msg').text('Succefully Updated!');
                                } else {
                                    $('.update-class-school .msg').text('Error Saving changes!');
                                }

                                $('#updateClassSchoolBtn').hide();
                                $('#updateClassSchoolWindowBtn').show();
                            }
                        });
                    }
                });
            });
        });

        var boosterInfo = document.getElementById('booster-info');

        $.ajax({
            type: "get",
            url: "<?php echo $baseurl; ?>ajax/getBoosterInfo",
            success: function(res) {
                var response = JSON.parse(res);

                response.forEach(booster => {
                    var boosterList = document.createElement('div');
                    boosterList.classList.add('booster-list', 'row', 'mb-3', 'border-bottom', 'p-2', 'm-1');

                    // Create the first column div with classes and append an image element
                    var col1 = document.createElement('div');
                    col1.classList.add('col-4', 'p-1', 'd-flex', 'justify-content-center', 'align-items-center');
                    var img = document.createElement('img');
                    img.src = `<?php echo $baseurl; ?>assets/notification_icons/${booster.booster_icon}`;
                    img.height = '50';
                    img.width = '50';
                    col1.appendChild(img);

                    // Create the second column div with classes and add the Lorem ipsum text
                    var col2 = document.createElement('div');
                    col2.classList.add('col-4');
                    col2.textContent = booster.booster_info;

                    var col3 = document.createElement('div');
                    col3.classList.add('col-4');
                    col3.textContent = booster.info;

                    // Append the columns to the boosterList div
                    boosterList.appendChild(col1);
                    boosterList.appendChild(col2);
                    boosterList.appendChild(col3);

                    boosterInfo.appendChild(boosterList);
                });
            }
        })


        var messageTypeContainer = document.getElementById("message-types");
        var messagesContainer = document.getElementById("messages");
        var data = [];

        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>ajax/getMessagesAjax",
            data: {
                user_id: "<?php echo $_SESSION["id"]; ?>"
            },
            success: function(res) {
                data = JSON.parse(res);
                populateMessages(data);
            }
        });

        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>ajax/getMessageTypesAjax",
            data: {
                user_id: "<?php echo $_SESSION["id"]; ?>"
            },
            success: function(res) {
                var response = JSON.parse(res);

                var types = [
                                {str: "All", type: "All_Count"},
                                { str: "Feedback/Suggestions", type: "Feedback_Suggestions_Count" },
                                { str: "Complaints", type: "Complaints_Count" },
                                { str: "Collaborations", type: "Collaborations_Count" },
                                { str: "Payment & Refunds", type: "Payment_Refunds_Count" },
                                { str: "Report Questions", type: "Report_Question" },
                                { str: "Others", type: "Others_Count" }
                            ];

                types.forEach((mtype) => {

                    // console.log(response);

                    var button = document.createElement("button");
                    button.innerHTML = mtype.str + `<span>${(response[mtype.type]) ? response[mtype.type] : 0}</span>`;

                    if(mtype.str == "All") {
                        button.classList.add("clicked");
                    }

                    button.addEventListener("click", function (event) {

                        clearButtons();

                        button.classList.add("clicked");

                        if(mtype.str == "All") {
                            populateMessages(data);
                        }
                        else {
                            var filtered = data.filter((element) => element.subject == mtype.str);
                            populateMessages(filtered);
                        }
                    });

                    messageTypeContainer.appendChild(button);
                });
            }
        });

        function clearButtons() {
            var buttons = document.querySelectorAll(".message-types button");
            buttons.forEach(button => {
                button.classList.remove('clicked');
            });
        }

        function populateMessages(data) {
            console.log(data);
            messagesContainer.innerHTML = "";
            data.forEach((element) => {
                var messageContent = document.createElement("div");

                var subjectContainer = document.createElement("div");
                subjectContainer.innerHTML = "<span>Subject: </span>" + element.subject;

                var contentContainer =document.createElement("div");
                contentContainer.innerHTML = "<span>Msg: </span>" + element.query_content.substring(0, 50) + "...";

                var messageTextContent = document.createElement("div");
                messageTextContent.innerHTML = "<span>Reply: </span>" + element.reply;

                var timeStampContainer = document.createElement('div');

                var timestamp = new Date(element.updated_at);

                // Current time
                var currentTime = new Date();

                var timezoneOffset = 0; // UTC-5 (for example)

                // Calculate the time difference in milliseconds (adjusted for time zone)
                var timeDifference = Date.now() - timestamp.getTime() - (timezoneOffset * 60 * 1000);

                // Convert milliseconds to seconds, minutes, and days
                var secondsAgo = Math.floor(timeDifference / 1000);
                var minutesAgo = Math.floor(secondsAgo / 60);
                var hoursAgo = Math.floor(minutesAgo / 60);
                var daysAgo = Math.floor(hoursAgo / 24);

                var unit = "seconds";

                if (daysAgo > 0) {
                unit = "days";
                } else if (hoursAgo > 0) {
                unit = "hours";
                } else if (minutesAgo > 0) {
                unit = "minutes";
                }

                var timeAgo = daysAgo || hoursAgo || minutesAgo || secondsAgo;

                timeStampContainer.innerHTML = timeAgo + " " + unit + " ago";

                messageContent.className = "message-content";

                messageContent.appendChild(subjectContainer);
                messageContent.appendChild(contentContainer);
                messageContent.appendChild(messageTextContent);
                messageContent.appendChild(timeStampContainer);

                messagesContainer.appendChild(messageContent);
            });
        }

        var boosterToggle = document.getElementById("booster-toggle");
        var inventoryContainer = document.getElementById('inventory-container');
        var toggleFlag = false;
        boosterToggle.addEventListener("click", () => {
            if(!toggleFlag) {
                inventoryContainer.classList.remove('hidden');
            } else {
                inventoryContainer.classList.add('hidden');
            }


            toggleFlag = !toggleFlag;
        });

        getBoosterCount();

    });
    </script>
<?php } ?>

<?php if(!in_array($page, array('createRoom.php', 'waiting_room.php', 'game_room.php', 'battle_leaderboard.php'))) {
    if(isset($_SESSION['live_room'])) {
        include(__DIR__ . '/battle_functions.php');
        leaveRoom($_SESSION['live_room']);
    }
} ?>

<?php if($page == 'index.php') { ?>
    <div id="assignModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body popup-text">
            <div class="row bg-white login-wrapper align-items-center">
                        <div class="col-md-6 p-0 tab-none">
                            <div class="image-container">
                                <img class="img-fit" src="<?php echo $baseurl; ?>assets/images/practice.jpg" width="320" height="320" alt="">
                            </div>
                        </div>                        
                        <div class="col-md-6 pt-3">
                            <div class="text-end pos-absolute">
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
</svg>
</button>
                            </div>
                            <div class="mb-3">
                                <h2 class="title">Assign by Teacher</h2>
                            </div>
                                                    <div class="form-signup p-1 mb-2">
                                                    <?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
                        <form action="" method="post">
                            <div class="mb-2">
                            <select name="tchusr" id="tchusr" class="form-select">
                                    <option>Select your name</option>
                                    <option value="0">Not in list</option>
                                    <?php 
                                    $grp_qry = mysqli_query($conn, "SELECT id from grpwise WHERE status=1 and link='".$prts."' order by name asc");
                                    $grp_rslt = mysqli_fetch_array($grp_qry);
                                        
                                    $catsql = mysqli_query($conn, "SELECT id,name from tch_grp_usr_list WHERE status=0 and grp_id='".$grp_rslt['id']."' and email = '' order by name asc");
                                    while($catrow = mysqli_fetch_array($catsql)) { ?>
                                        <option value="<?php echo $catrow['id']; ?>"><?php echo $catrow['name']; ?></option>
                                    <?php } ?>
                                    </select>
                                    </div>
                                    <div class="mb-2">
                                <div class="input-group input-append"> 
                                    <input type="hidden" name="subTopid" id="subtopic" value=""> 
                                    <input type="password" name="tp_pass" id="tp_pass" class="form-control tp_pass noSpacesField" autocomplete="off" placeholder="Enter given password" required>
                                    <div class="input-group-append">
                                      <button class="btn btn-link eye-off" id="viewButton" type="button"><img src="<?php echo $baseurl; ?>assets/images/eye-off.svg" width="22"></button>
                                    </div>                                   
                                  </div>                                 
                            </div>
                        <div class="mb-2 text-center btn-wrapper">
                        <input type="submit" name="assigngrp" class="btn custom-btn btn-w-full" value="Submit">
                    </div>
                    </form>
                        </div>               
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php } ?>
<?php if($page == 'practice.php') { ?>
    <div id="reportModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body popup-text">
            <div class="row bg-white login-wrapper align-items-center">                    
                        <div class="col-md-12 pt-3">
                            <div class="text-end pos-absolute">
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
</svg>
</button>
                            </div>
                            <div class="mb-1">
                                <h2 class="title">Report Question</h2>
                            </div>
                                                    <div class="form-signup p-1 mb-2">
                                                    <?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
                        <form action="" method="post" class="reportForm">
                            <div class="mb-md-3 mb-2">
                                <div class="input-group input-append"> 
                                    <input type="hidden" name="subTopid" id="subtopic" value=""> 
                                    <textarea rows="5" name="report" id="report" class="form-control" required></textarea>                                 
                                  </div>                                 
                            </div>
                        <div class="mb-2 text-center btn-wrapper">
                        <input type="submit" name="reportBtn" class="btn btn-pink btn-animated btn-lg mw-200" value="Submit">
                    </div>
                    </form>
                        </div> 
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>


<div id="requestModal" class="modal lg-rt-modal fade" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body popup-text">
            <div class="row bg-white login-wrapper align-items-center">                    
                        <div class="col-md-12 pt-3">
                            <div class="text-end pos-absolute">
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="Close"><svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16.9739 15.1626L23.8989 22.0876V23.9126H22.0739L15.1489 16.9876L8.22393 23.9126H6.39893V22.0876L13.3239 15.1626L6.39893 8.2376V6.4126H8.22393L15.1489 13.3376L22.0739 6.4126H23.8989V8.2376L16.9739 15.1626Z" fill="black"/>
</svg>
</button>
                            </div>
                            <div class="mb-1">
                                <h2 class="title">Request Solution</h2>
                            </div>
                                                    <div class="form-signup p-1 mb-2">
                                                    <?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
                        <form action="" method="post" class="requestForm">
                            <div class="mb-md-3 mb-2">
                                <div class="input-group input-append"> 
                                    <input type="hidden" name="subTopid" id="subtopic" value=""> 
                                    <textarea rows="5" name="request" id="request" class="form-control"></textarea>
                                  </div>                                 
                            </div>
                        <div class="mb-2 text-center btn-wrapper">
                        <input type="submit" name="requestBtn" class="btn btn-pink btn-animated btn-lg mw-200" value="Submit">
                    </div>
                    </form>
                        </div> 
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>








<?php } ?>
</div>
    <script src="<?php echo $baseurl; ?>assets/js/popper.min.js"></script>
    <script src="<?php echo $baseurl; ?>assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $baseurl; ?>assets/js/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <script src="<?php echo $baseurl; ?>assets/js/custom.js"></script>

    <script>

            const $bootstrapModal = $('#withoutLoginModal');

            function showWithoutLoginModal () {
                $bootstrapModal.modal('show');

                // Hide the Bootstrap modal after 2 seconds
                setTimeout(function () {
                    $bootstrapModal.modal('hide');
                }, 2000);
            }

        function sendMail(mailType, email) {
            $.ajax({
                type: "post",
                url: "<?php echo $baseurl ?>ajax/sendMailAjax",
                data: {
                    email_type: mailType,
                    email
                },
                success: function (res) {
                    $('.modal').modal('hide');

                    showToast({
                        title: "Email Sent!",
                        content: "An Email has been sent!",
                        imgBanner: "notif_mail.svg"
                    });
                }
            });
        }

function shakeElement(element, duration) {
            var startTime = Date.now();

            function update() {
                var elapsed = Date.now() - startTime;
                var progress = elapsed / duration;
                var randomX = Math.sin(progress * 30) * 10; // Adjust the multiplier for intensity

                element.style.transform = 'translateX(' + randomX + 'px)';

                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    element.style.transform = 'translateX(0)';
                }
            }

            update();
        }

        $(document).ready(() => {

            $(document).keydown(function(event) {
                // Check if the pressed key is the Escape key
                if (event.key === 'Escape' || event.key === 'Esc') {
                    // Trigger the dismissal of the active modal
                    $('.modal').modal('hide');
                }
            });

            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            });
        });

        function addToast(toastObj) {
            const toastDiv = document.createElement('div');
            toastDiv.classList.add('toast', 'hide');
            toastDiv.setAttribute('role', 'alert');
            toastDiv.setAttribute('aria-live', 'assertive');
            toastDiv.setAttribute('aria-atomic', 'true');
            toastObj?.toastId ? toastDiv.setAttribute('id', toastObj.toastId) : toastDiv.setAttribute('id', 'myToast');
            toastDiv.setAttribute('data-bs-animation', 'true');
            toastObj?.keepOpen && toastDiv.setAttribute('data-bs-autohide', 'false');

            const toastHeaderDiv = document.createElement('div');
            toastHeaderDiv.classList.add('toast-header');

            const img = document.createElement('img');

            if(toastObj?.imgBanner) {
                img.src = `<?php echo $baseurl; ?>assets/notification_icons/${toastObj.imgBanner}`; // Replace 'path_to_image' with the image URL
                img.classList.add('rounded', 'me-2', 'vibrating-div');
                img.setAttribute('width', '30');
                img.setAttribute('height', '30');
                img.alt = 'Notification Img';
                img.style.border = '2px solid #FFD700';
            }


            const strongTitle = document.createElement('strong');

            if(toastObj?.title) {
                strongTitle.classList.add('me-auto');
                strongTitle.setAttribute('id', 'toast-title');
                strongTitle.textContent = toastObj.title;
            }

            var iSpan = document.createElement('span');

            if(toastObj?.info) {
                iSpan.setAttribute('data-bs-toggle', 'popover');
                iSpan.setAttribute('data-bs-trigger', 'hover focus');
                iSpan.setAttribute('data-bs-content', toastObj.info);

                var iButton = document.createElement('button');
                iButton.disabled = true;
                iButton.style.backgroundColor = 'transparent';
                iButton.style.border = 'none';
                iButton.style.outline = 'none';
                
                var iImg = document.createElement('img');
                iImg.src = '<?php echo $baseurl; ?>assets/notification_icons/i-btn.svg';
                iImg.height = "15";
                iImg.width = '15';

                iButton.appendChild(iImg);
                iSpan.appendChild(iButton);
            }


            const toastBodyDiv = document.createElement('div');
            toastBodyDiv.classList.add('toast-body');
            toastBodyDiv.setAttribute('id', 'toast-body');

            var textNode = document.createElement('span');
            textNode.textContent = toastObj.content;

            // Append elements to create the structure
            toastObj?.title && toastHeaderDiv.appendChild(strongTitle);
            toastBodyDiv.appendChild(img);
            toastBodyDiv.appendChild(textNode);
            toastObj?.info && toastBodyDiv.appendChild(iSpan);

            (toastObj?.title) && toastDiv.appendChild(toastHeaderDiv);
            toastDiv.appendChild(toastBodyDiv);

            return toastDiv;
        }

    function showToast(toastObj) {

        var myToast = addToast(toastObj);

        document.getElementById('toast-container').appendChild(myToast);

        var toast = new bootstrap.Toast(myToast);
        // $('#toast').toggleClass('hidden-toast visible-toast');
        toast.show();
    }

    var timerFlag = true;

    function showTimerToast(toastObj) {

        var now = Math.floor(Date.now() / 1000);
        var timeRemaining = toastObj.content - now;

        var hours = Math.floor(timeRemaining / 3600);
        var minutes = Math.floor((timeRemaining % 3600) / 60);
        var seconds = timeRemaining % 60;

        var timerContent = `${(minutes + "").padStart(2, '0')} : ${(seconds + "").padStart(2, '0')}`;

        var myToast = document.querySelectorAll(`#timer-toast-container #${toastObj.toastId}`);
        var toast;

        if(myToast.length == 0){
            myToast = addToast({ content: timerContent, keepOpen: true, toastId: toastObj.toastId, imgBanner: toastObj.imgBanner, info: toastObj.info });
            document.getElementById('timer-toast-container').appendChild(myToast);

            toast = new bootstrap.Toast(myToast);


        } else {
            var toastBodyDec =document.querySelectorAll(`#timer-toast-container #${toastObj.toastId} .toast-body span`);
            toastBodyDec[0].textContent = timerContent;

            toast = new bootstrap.Toast(myToast[0]);

        }
        var destinationTimer = parseInt("<?php echo $_SESSION['destination-timer']; ?>", 10);



        if(timeRemaining > 0 && !(!toastObj.disablePower && !timerFlag)) {
            toast.show();
            // $('#toast').toggleClass('hidden-toast visible-toast');
            setTimeout(() => showTimerToast(toastObj), 1000);
        } else {
            if(toastObj.disablePower) {
                var boosterPoints = <?php echo $_SESSION['booster-points'] ?? 0; ?>;
                var normalPoints = <?php echo $_SESSION['normal-points'] ?? 0; ?>;
                $.ajax({
                    type: "GET",
                    url: "<?php echo $baseurl; ?>ajax/disablePowerUp?power_up=double",
                    success: function(res) {
                        toast.hide();
                        myToast[0].remove();
                        if(boosterPoints != normalPoints) {
                        showToast({ title: 'Booster Time`s Up!', content: 'You have scored <?php echo $_SESSION['booster-points']; ?> points due to the booster instead of the normal <?php echo $_SESSION['normal-points']; ?> points', imgBanner: 'times-up.svg' });
                        } else {
                        showToast({ title: 'Booster Time`s Up!', content: 'You have scored <?php echo $_SESSION['booster-points']; ?> points!', imgBanner: 'times-up.svg' });
                        }

                        hideTimerToast('maximumTimer');
                    }
                });
            } else if(!(!toastObj.disablePower && !timerFlag && destinationTimer > Date.now())) {
                toast.hide();
                myToast[0].remove();
                showToast({ title: 'Oops!', content: 'Maximum timer to get extra points exceeded!', imgBanner: 'times-up.svg' });
            }
        }
    }

    function hideTimerToast(toastId) {
        var myToast =document.querySelectorAll(`#timer-toast-container #${toastId}`);
        if(myToast[0]){
            toast = new bootstrap.Toast(myToast[0]);
            toast.hide();
            myToast[0].remove();
            timerFlag = false;
        }
    }


    function getBoosterCount() {
        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>ajax/getBoosterCount",
            success: function(res) {
                var response =JSON.parse(res);
                populateInventory(response);
            }
        })
    }

    function populateInventory(res) {
        var inventory = document.getElementById('inventory');

        inventory.innerHTML = "";

        if(res.length == 0) {
            inventory.textContent = "No Boosters currently!"
            inventory.style.color = "#fff";
        }

        res.forEach(booster => {
                var boosterDiv = document.createElement('div');
                boosterDiv.href = "#";
                boosterDiv.classList.add('booster');

                var boosterImg = document.createElement('img');
                boosterImg.src = `<?php echo $baseurl; ?>assets/notification_icons/${booster.booster_icon}`;
                boosterImg.height = "50";
                boosterImg.width = "50";
                boosterImg.alt = "booster image";

                var boosterCount = document.createElement('div');
                boosterCount.classList.add('booster-count');

                var boosterSpan = document.createElement('span');
                boosterSpan.classList.add('booster-count-count');
                boosterSpan.textContent = booster.booster_count;

                boosterCount.appendChild(boosterSpan);

                boosterDiv.appendChild(boosterImg);
                boosterDiv.appendChild(boosterCount);

                boosterDiv.addEventListener('click', () => {
                    $('#hidden-booster-id').val(booster.id);
                    $('#boosterModal').modal('show');
                });

                inventory.appendChild(boosterDiv);
        });
    }

    function applyBooster(b_id) {
        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>ajax/applyBooster",
            data: {
                booster_id: b_id
            },
            success: function(res) {
                var response = JSON.parse(res);
                showToast(response)
                setTimeout(() => location.reload(), 1500);
            }
        })
    }

    var boosterModal = document.getElementById('boosterModal');
    boosterModal.addEventListener('show.bs.modal', (event) => {
        var recipient = $('#hidden-booster-id').val();

        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>ajax/getBoosterInfo",
            data: {
                booster_id: recipient
            },
            success: function(res) {
                var response = JSON.parse(res);

                var boosterIcon =boosterModal.querySelector('.booster-icon-img img');
                boosterIcon.src = `<?php echo $baseurl; ?>assets/notification_icons/${response[0].booster_icon}`;

                var boosterInfo = boosterModal.querySelector('.booster-info-content');
                boosterInfo.textContent = response[0].booster_info;

                var boosterActivate = boosterModal.querySelector('#booster-activate-btn');
                boosterActivate.addEventListener('click', () => {
                    $('#boosterModal').modal('hide');
                    applyBooster(recipient);
                });
            }
        });
    });
</script>
<?php if(isset($_SESSION['id'])) { 
    if(isset($_SESSION['power-up']) && isset($_SESSION['destination-timer'])) {    
        ?> 
            <script>

                <?php if($page == 'practice.php') { ?>
                if(window.innerWidth <= 991) {
                    console.log('Hello');
                    document.getElementById('practice-breadcrumbs').style.visibility = "hidden";
                }
                <?php } ?>

                var targetTimestamp = <?php echo $_SESSION['destination-timer']; ?>;
                showTimerToast({ content: targetTimestamp, keepOpen: true, toastId: 'overallTimer', disablePower: true, imgBanner: 'timer.svg', info: 'This is the timer of the power!' });
            </script>
        <?php
    }
} ?>

<?php if($page == 'category.php' || $page == 'dashboard.php') { ?>
<script>$(document).ready(function(){$(".blk-widget-inner a").click(function(){var t=$(this).data("grp");$.ajax({url:"<?php echo $baseurl;?>actajax",type:"POST",data:{assign_grp:t},success:function(t){}})})}),$(document).ready(function(){$(".acpt-grp").on("click",function(t){t.preventDefault();t=$(this).data("id");$("#subtopic").val(t)})}),$(document).ready(function(){$(".blk-widget-inner a").click(function(){$(this).data("id"),$(this).next(".tag").hide()})}),$(document).ready(function(){$(".fastest-topic").click(function(){var t=$(this).data("topic");$.ajax({url:"<?php echo $baseurl;?>actajax",type:"POST",data:{asgn_topic:t},success:function(t){location.reload()}})})});</script>
<script>

    function fetch_pdf(){

        var subtopic_id = event.target.getAttribute("data-id");

        $.ajax({
            type: "get",
            url: `<?php echo $baseurl; ?>ajax/fetch_pdfs?subtopic_id=${subtopic_id}`,
            success: function(res){
                var response = JSON.parse(res);
                var pdf_container = document.getElementById("pdf-download-container");
                pdf_container.innerHTML = "";
                response.forEach((worksheet, index) => {
                    var file_path = "<?php echo $baseurl; ?>uploads/practice/" + worksheet.pdf_class + "/" + worksheet.filename;

                    var rowDiv = document.createElement("div");
                    rowDiv.className = "p-3 d-flex align-items-center justify-content-between w-100 border-bottom";
                    
                    var worksheet_title = document.createElement("h5");
                    worksheet_title.textContent = `Worksheet ${index + 1}`;

                    var downloadButton = document.createElement("button");
                    downloadButton.className = "btn btn-primary custom-btn";
                    downloadButton.textContent = "Download"

                    downloadButton.addEventListener("click", ()=>{

                        // Create an anchor element
                        const anchor = document.createElement('a');
                        document.body.appendChild(anchor);
                        // Set the anchor's href attribute to the PDF file URL
                        anchor.href = file_path;

                        // Set the anchor's download attribute to specify the file name
                        anchor.download = worksheet.filename;

                        // Trigger a click event on the anchor to start the download
                        anchor.click();

                        // Remove the anchor element from the DOM
                        document.body.removeChild(anchor);
                    });

                    rowDiv.appendChild(worksheet_title);
                    rowDiv.appendChild(downloadButton);
                    pdf_container.appendChild(rowDiv);
                    
                });
            }
        });
    }

    function checkFileExistence(filePath) {
        fetch(filePath)
            .then(response => {
                if (response.status === 200) {
                    return true;
                } else {
                    return false;
                }
            })
            .catch(error => {
                console.error('Error checking file existence:', error);
            });
    }
</script>
<?php } ?>
<?php if($page == 'quiz.php' || $page == 'fastest.php') { ?>
<script>$(document).ready(function(){
<?php if($page == 'quiz.php') { ?>    
var o=new Date("<?php echo $createdDateTime; ?>").getTime();
<?php } else { ?>
var o=new Date("<?php echo $createdDateTime; ?>").getTime(); // Initialize 'o' with the current time
<?php } ?>
function e() {
    var currentTime = new Date();
    var elapsedTime = currentTime.getTime() - o;
    var hours = Math.floor(elapsedTime / 3600000);
    var minutes = Math.floor((elapsedTime % 3600000) / 60000);
    var seconds = Math.floor((elapsedTime % 60000) / 1000);

    // Format hours, minutes, and seconds with leading zeros
    var formattedTime = 
        (hours < 10 ? "0" + hours : hours) + ":" +
        (minutes < 10 ? "0" + minutes : minutes) + ":" +
        (seconds < 10 ? "0" + seconds : seconds);

    $("#timer").text(formattedTime);
}

e(); // Call the function once to initialize the timer
setInterval(e, 1000); // Call the function every 1000 milliseconds (1 second) to update the timer

});</script>
<?php } ?>


    <?php if($page == 'index.php') { ?>
<script>
var swiperBanner = new Swiper('.hero-wrapper', {
            slidesPerView: 1,
            spaceBetween: 0,
            freeMode: false,
            speed: 1000,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            loop: true,
            autoplay: {
                delay: 3000,
            },
            navigation: {
            nextEl: '.swiper-next',
            prevEl: '.swiper-prev',
        }
        });
        
/*$(document).ready(function(){
  $("#school").select2();
});*/

$(document).ready(function() {
    $('input[type=radio][name=utype]').change(function() {
        if (this.value == '1') {
            $('#clsName').show();
        }
        else if (this.value == '2') {
            $('#clsName').hide();
        }
    });
});

// Reload the page when the modal is closed
$('#assignModal').on('hidden.bs.modal', function () {
    window.location.href = '<?php echo $baseurl; ?>';
    });
</script>
<?php } ?>
<?php if($page == 'leaderboard.php') { ?>
<style>
    .tooltip {
        display: none;
        position: absolute;
        background-color: #fff;
        border: 1px solid #ccc;
        /*padding: 5px;*/
        z-index: 1000; /* Adjust the z-index as needed */
        box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
        border-radius: 1.5rem;
    }
</style>
<script>
$(document).on('click','.leaderboard-wrapper a[data-overall]',function(){
    $(this).parents('.leaderboard-wrapper').find('a').removeClass('active');
    $(this).addClass('active');
    $(this).parents('.leaderboard-wrapper').children('.schoolwise').hide();
    $(this).parents('.leaderboard-wrapper').children('.overallwise').show();
});

$(document).on('click','.leaderboard-wrapper a[data-school]',function(){
    $(this).parents('.leaderboard-wrapper').find('a').removeClass('active');
    $(this).addClass('active');
    $(this).parents('.leaderboard-wrapper').children('.schoolwise').show();
    $(this).parents('.leaderboard-wrapper').children('.overallwise').hide();
});

// Get all list items with data-id attributes
const listItems = document.querySelectorAll('li[data-id]');

// Get the tooltip and iframe elements
const tooltip = document.querySelector('.tooltip');
const iframeContainer = document.querySelector('.iframe-container');
const iframe = document.querySelector('.iframe-container iframe');

// Detect if the user is using a touch device
function isMobileDevice() {
  return window.matchMedia("(max-width: 641px)").matches;
}

// Attach the appropriate event listener based on the device
listItems.forEach((li) => {
    let timer;
        // On touch devices, use click
        if(isMobileDevice()){
            li.addEventListener('click', (event) => {
                handleItemClick(li, event);
            });
        }
        else {
            li.addEventListener('mouseenter', (event) => {
                handleItemClick(li, event);

                tooltip.addEventListener('mouseenter', (event) => {
                handleItemClick(li, event);
                });

                tooltip.addEventListener('mouseleave', (event) => {
                    if (!tooltip.contains(event.target)) {
                            hideTooltip();
                    }
                });
            });

            

            li.addEventListener('mouseleave', (event) => {
                if (!tooltip.contains(event.target)) {
                    hideTooltip();
                }
            })
        }
});

document.addEventListener('click', (event) => {
            if (!tooltip.contains(event.target)) {
                hideTooltip();
            }
        });

// Function to handle both touch and mouse events
function handleItemClick(li, event) {
    // Get the data-id attribute value
    const dataId = li.getAttribute('data-id');

    // Update the iframe source based on data-id
    iframe.src = `profileTooltip.php?student_id=${dataId}`;
    iframe.width = "345";
    iframe.height = "207";
    iframe.style.padding = "0.25rem";

    // Calculate the tooltip position based on the mouse click or hover
    const liRect = li.getBoundingClientRect();
    tooltip.style.marginLeft = '15px'; // Adjust the offset as needed
    tooltip.style.top = (liRect.top + window.scrollY - 10) + 'px'; // Adjust the offset as needed

    // Show the tooltip and iframe
    tooltip.style.display = 'block';
    tooltip.style.opacity = 1;
    iframeContainer.style.display = 'block';

    // Prevent the click event from bubbling (optional)
    event.stopPropagation();
}

// Function to hide the tooltip and iframe
function hideTooltip() {
    iframe.src = '';
    tooltip.style.display = 'none';
    iframeContainer.style.display = 'none';
}
</script>    
<?php } ?>

<script>

    $(document).ready(() => {
        $(document).on('click','.teacherRegister',function(){
        $('#utype_2').prop('checked', true);
        $('#clsName').hide();
    });

    $(document).on('click','.studentRegister',function(){
        $('#utype_1').prop('checked', true);
        $('#clsName').show();
    });

    $(document).ready(function() {
    $('.emailtxt').on('input', function() {
        $(this).val($(this).val().toLowerCase());
    });
    });

    $(document).on('click','.eye-off', function () {
        $(this).children('img').attr('src', '<?php echo $baseurl; ?>assets/images/eye.svg');
        $(this).addClass('eye-on');
        $(".tp_pass").attr('type','text'); 
    });
    $(document).on('click','.eye-on', function () {
        $(this).children('img').attr('src', '<?php echo $baseurl; ?>assets/images/eye-off.svg');
        $(this).removeClass('eye-on');
        $(".tp_pass").attr('type','password');  
    });


    $(document).on('click','.loginModal',function(){
        $("#registerModal").modal("hide");
    });

    $(document).on('click','.registerModal',function(){
        $("#loginModal").modal("hide");
    });

    $(document).on('click','.teacherRegister',function(){
        $("#registerModal").modal("hide");
    });



    $(document).on('click','.dropdown-item',function(){
        if ($("button.form-select").attr("data-dselect-text") === "Others") {
        $('.others').removeClass('hide');
        } else {
        $('.others').addClass('hide');
        }
    });


    var select_box_element = document.querySelector('#school');

        dselect(select_box_element, {
            search: true
        });

        var select_box_element = document.querySelector('#tchusr');

    dselect(select_box_element, {
        search: true
    });  


    });

<?php if($page == 'createRoom.php') { ?> 
    // JavaScript to handle time input
    const hourSelect = document.getElementById('hour');
    const minuteSelect = document.getElementById('minute');

    const defOptHr = document.createElement('option');
    defOptHr.textContent = "Select Hour";
    defOptHr.selected = true;
    defOptHr.disabled = true;
    hourSelect.appendChild(defOptHr);

    const defOptMin = document.createElement('option');
    defOptMin.textContent = "Select Minute";
    defOptMin.selected = true;
    defOptMin.disabled = true;
    minuteSelect.appendChild(defOptMin);

    // Populate hours and minutes
    for (let i = 0; i < 24; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = i < 10 ? '0' + i : i;
        hourSelect.appendChild(option);
    }

    for (let i = 0; i < 60; i += 5) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = i < 10 ? '0' + i : i;
        minuteSelect.appendChild(option);
    }
    
<?php } ?>

<?php if($page == 'waiting_room.php') { ?> 

    var room_code = "<?php echo $_GET['room']; ?>";

    function populateWaitingList(data) {
        const playerListElement = document.getElementById("waiting-list-ul");
        playerListElement.innerHTML = "";

        data.forEach(player => {
            const listItem = document.createElement("li");

            listItem.innerHTML = `
                <img src="<?php echo $baseurl ?>assets/images/avatars/${player.avatar}" alt="${player.fullname}" width="25" height="25">
                <div class="details">
                    <div class="name">${player.fullname}</div>
                    <div class="school">${player.school}</div>
                    <div class="class">${player.class}</div>
                </div>
            `;

            playerListElement.appendChild(listItem);
        });
    }

    function getWaitingList() {
        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>ajax/getWaitingListAjax",
            data: {
                room_code 
            },
            success: function (res) {
                var response = JSON.parse(res);
                populateWaitingList(response);
            }
        });
    }

    setInterval(getWaitingList, 2000);

    function getStartingTime() {
        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>ajax/getRoomStartTimeAjax",
            data: {
                room_code
            },
            success: function (res) {
                var response = JSON.parse(res);

                populateTimer(response.scheduled_on);
            }
        });
    }

    getStartingTime();

    function populateTimer(targetTimestamp) {
        var timerContainer = document.getElementById("timer");

        targetTimestamp = new Date(targetTimestamp).getTime();
        console.log(targetTimestamp);
        // Calculate the remaining time in milliseconds
        var now = new Date().getTime();
        var remainingTime = targetTimestamp - now;

        // Calculate hours, minutes, and seconds
        var hours = Math.floor(remainingTime / (1000 * 60 * 60));
        var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

        // Display the time in the timerContainer
        timerContainer.textContent = remainingTime > 0 ? formatTime(hours) + " : " + formatTime(minutes) + " : " + formatTime(seconds) : "00 : 00 : 00";

        if(remainingTime > 0) {
            setTimeout(() => populateTimer(targetTimestamp), 1000);
        } else {
            $.ajax({
                type: "post",
                url: "<?php echo $baseurl; ?>ajax/startBattleAjax",
                data: {
                    room_code,
                    user_id: "<?php echo $_SESSION['id']; ?>"
                },
                success: function (res) {
                    var response = JSON.parse(res);

                    if(response) {
                        setTimeout(() => window.location.href = `<?php echo $baseurl ?>game_room?room=${room_code}`, 1500);
                    }
                }
            });
        }
    }

    // Helper function to format time units (add leading zero if needed)
    function formatTime(timeUnit) {
        return timeUnit < 10 ? "0" + timeUnit : timeUnit;
    }

<?php } ?>

<?php if($page == 'game_room.php') { ?> 

    var room_code = "<?php echo $_GET['room']; ?>";
    var socket = new WebSocket("<?php echo WEBSOCKET_URL; ?>?room=" + room_code );

    socket.addEventListener('open', function (event) {
        console.log('WebSocket connection opened:', event);
    });

    socket.addEventListener('message', function (event) {
        var message = event.data;

        // Display the received message in the chat box
        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>battle_leaderboard_html",
            data: {
                room_code
            },
            success: function(response) {
                $('#battle-leaderboard').html(response);
                $('#leaderboard-modal-container').html(response);
            }
        });

    });

    // Connection closed
    socket.addEventListener('close', function (event) {
        console.log('WebSocket connection closed:', event);
    });

    // Handle errors
    socket.addEventListener('error', function (event) {
        console.error('WebSocket error:', event);
    });

    function checkSelection() {
        var radioButtons = document.querySelectorAll('input[type="radio"][name="opt"]');
        var submitButton = document.getElementById("submitButton");

        for (var i = 0; i < radioButtons.length; i++) {
            if (radioButtons[i].checked) {
                submitButton.removeAttribute("disabled");
                return;
            }
        }

        submitButton.setAttribute("disabled", "true");
    }

    function submitForm(clicked_button) {
        clicked_button.disabled = true;
        $.ajax({
            method: "POST",
            url: "<?php echo $baseurl;?>game_room_rslt",
            data: $('#myForm').serialize(),
            success: function(response) {
                $('#result').html(response);

                $.ajax({
                    type: "post",
                    url: "<?php echo $baseurl; ?>battle_leaderboard_html",
                    data: {
                        room_code
                    },
                    success: function(response) {
                        $('#battle-leaderboard').html(response);
                        $('#leaderboard-modal-container').html(response);
                    }
                });
            }
        });
    }

    function showNotification(text) {
        alert(text);
    }

    var questionEndTime = "<?php echo $getQuesEndTimeRes['end_time']; ?>";
    populateTimer(questionEndTime);

    function populateTimer(targetTimestamp) {
        var timerContainer = document.getElementById("timer");

        targetTimestamp = new Date(targetTimestamp).getTime();
        // Calculate the remaining time in milliseconds
        var now = new Date().getTime();
        var remainingTime = targetTimestamp - now;

        // Calculate hours, minutes, and seconds
        var hours = Math.floor(remainingTime / (1000 * 60 * 60));
        var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

        // Display the time in the timerContainer
        timerContainer.textContent = remainingTime > 0 ? formatTime(hours) + " : " + formatTime(minutes) + " : " + formatTime(seconds) : "00 : 00 : 00";

        if(remainingTime > 0) {
            setTimeout(() => populateTimer(targetTimestamp), 1000);
        } else {
            timerContainer.style.visibility = "hidden";
            window.location.reload();
        }
    }

    // Helper function to format time units (add leading zero if needed)
    function formatTime(timeUnit) {
        return timeUnit < 10 ? "0" + timeUnit : timeUnit;
    }
<?php } ?>

<?php if($page == 'practice.php') { ?>
    var currentDate = new Date();

// Get the current date components
var year = currentDate.getFullYear();
var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
var day = ('0' + currentDate.getDate()).slice(-2);

// Get the current time components
var hours = ('0' + currentDate.getHours()).slice(-2);
var minutes = ('0' + currentDate.getMinutes()).slice(-2);
var seconds = ('0' + currentDate.getSeconds()).slice(-2);

// Create the formatted datetime string
var formattedDatetime = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
  
$(document).on("click",".reportques",function(){
    $('#subtopic').val($(this).data('id'));
});
/*$(document).on("click",".reportques",function(){var a=$(this).data("id");$.ajax({url:'<?php echo $baseurl;?>actajax',method:'POST',data:{'reportQues':a,'datetime':formattedDatetime},success:function(response){$('.submitReport').text('Thanks');},
      error: function(xhr, status, error) {
        // Handle any errors that occur during the AJAX request
        console.log(error);
      }})});*/



    $(window).on('load', function() {
        $('#limitModal').modal('show');
    });

    function checkSelection() {
    var radioButtons = document.querySelectorAll('input[type="radio"][name="opt"]');
    var submitButton = document.getElementById("submitButton");

    for (var i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            submitButton.removeAttribute("disabled");
            return;
        }
    }

    submitButton.setAttribute("disabled", "true");
}

    function submitForm(clicked_button) {
            clicked_button.disabled = true;
            $.ajax({
                method: "POST",
                url: "<?php echo $baseurl;?>practice_rslt",
                data: $('#myForm').serialize(),
                success: function(response) {
                    $('#result').html(response);
                    // resizeTextInContainers();
                    
                                $.ajax({
                method: "POST",
                url: "<?php echo $baseurl;?>performance_meter",
                data: $('#myForm').serialize(),
                success: function(response) {
                    $('#performance').html(response);
                    // resizeTextInContainers();
                    hideTimerToast('maximumTimer');
                }
            });
                }
            });


        }

        function showNotification(text) {
        alert(text);
    }

    function setShortlist(event) {
        event.preventDefault();
        var clicker = event.currentTarget;
        var quesId = clicker.getAttribute("data-id");

        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>ajax/setShortList",
            data: {
                question_id: quesId,
                user_id: <?php echo json_encode($_SESSION["id"]); ?>
            },
            success: function(res) {
                clicker.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
</svg><span class="note">Shortlisted This Question</span>`;
            }
        });
    };

    function setShortlistMobile(event) {
        event.preventDefault();
        var clicker = event.currentTarget;
        var quesId = clicker.getAttribute("data-id");

        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>ajax/setShortList",
            data: {
                question_id: quesId,
                user_id: <?php echo json_encode($_SESSION["id"]); ?>
            },
            success: function(res) {
                clicker.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
</svg>`;
            }
        });
    };


    function removeShortlist(event) {
        event.preventDefault();
        var clicker = event.currentTarget;
        var quesId = clicker.getAttribute("data-id");

        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>ajax/removeShortList",
            data: {
                question_id: quesId,
                user_id: <?php echo json_encode($_SESSION["id"]); ?>
            },
            success: function(res) {
                clicker.innerHTML = ` <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg><span class="note">Shortlist This Question</span>`;
            }
        });
    }

    function removeShortlistMobile(event) {
        event.preventDefault();
        var clicker = event.currentTarget;
        var quesId = clicker.getAttribute("data-id");

        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>ajax/removeShortList",
            data: {
                question_id: quesId,
                user_id: <?php echo json_encode($_SESSION["id"]); ?>
            },
            success: function(res) {
                clicker.innerHTML = ` <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>`;
            }
        });
    }


    function goToPrevQuestion(event) {
        event.preventDefault();
        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>ajax/visitPrevQuestion",
            data: {
                user_id: "<?php echo $_SESSION['id']; ?>",
                class: <?php echo $clsrow['id']; ?>,
                subject: <?php echo $sbjrow['id']; ?>,
                topic: <?php echo $tpcrow['id']; ?>,
                subtopic: "<?php echo $sbtpcrow['id']; ?>",
                question: <?php echo $querow['id']; ?>
            },
            success: function(res) {
                window.location.reload();
            }
        })
    }

    function goToNextQuestion(event) {
        event.preventDefault();
        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>ajax/visitNextQuestion",
            data: {
                user_id: "<?php echo $_SESSION['id']; ?>",
                class: <?php echo $clsrow['id']; ?>,
                subject: <?php echo $sbjrow['id']; ?>,
                topic: <?php echo $tpcrow['id']; ?>,
                subtopic: "<?php echo $sbtpcrow['id']; ?>",
                question: <?php echo $querow['id']; ?>,
            },
            success: function(res) {
                window.location.reload();
            }
        })
    }
<?php } ?>

<?php if($page == 'shortlist.php') {
    ?>

    function removeShortlist(event) {
        event.preventDefault();
        var clicker = event.currentTarget;
        var quesId = clicker.getAttribute("data-id");

        $.ajax({
            type: "post",
            url: "<?php echo $baseurl; ?>ajax/removeShortList",
            data: {
                question_id: quesId,
                user_id: <?php echo json_encode($_SESSION["id"]); ?>
            },
            success: function(res) {
                window.location.reload();
            }
        });
    }

     function checkSelection() {
    var radioButtons = document.querySelectorAll('input[type="radio"][name="opt"]');
    var submitButton = document.getElementById("submitButton");

    for (var i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            submitButton.removeAttribute("disabled");
            return;
        }
    }

    submitButton.setAttribute("disabled", "true");
}
           function submitForm() {
            $.ajax({
                method: "POST",
                url: "<?php echo $baseurl;?>practice_rslt_shortlist",
                data: $('#myForm').serialize(),
                success: function(response) {
                    $('#result').html(response);
                }
            });
        }
    <?php
} ?>

<?php if($page == 'paper.php') { ?>

    function runQuery() {
         var dataId = event.target.getAttribute("data-id");

         $.ajax({
            type: "get",
            url: `ajax/fetchQuizPaper?quiz_id=${dataId}`,
            success: function(res) {
                var response = JSON.parse(res);

                // Create an anchor element
                const anchor = document.createElement('a');
                document.body.appendChild(anchor);
                // Set the anchor's href attribute to the PDF file URL
                anchor.href = "<?php echo $baseurl; ?>uploads/offline_practice/" + response.question_papername;

                // Set the anchor's download attribute to specify the file name
                anchor.download = response.question_papername;

                // Trigger a click event on the anchor to start the download
                anchor.click();

                // Remove the anchor element from the DOM
                document.body.removeChild(anchor);
            }
         })
    }

    function runDQuery() {
        var dataId = event.target.getAttribute("data-id");

        $.ajax({
           type: "get",
           url: `ajax/fetchQuizPaper?quiz_id=${dataId}`,
           success: function(res) {
               var response = JSON.parse(res);

               // Create an anchor element
               const anchor = document.createElement('a');
               document.body.appendChild(anchor);
               // Set the anchor's href attribute to the PDF file URL
               anchor.href = "<?php echo $baseurl; ?>uploads/offline_practice/" + response.answer_papername;

               // Set the anchor's download attribute to specify the file name
               anchor.download = response.answer_papername;

               // Trigger a click event on the anchor to start the download
               anchor.click();

               // Remove the anchor element from the DOM
               document.body.removeChild(anchor);
           }
        })
   }
<?php } ?>

<?php 
 if($page == 'category.php' || $page == 'dashboard.php') { ?>
    window.jsPDF = window.jspdf.jsPDF;
    function runQuery() {
        // Get the data-id attribute value
        var dataId = event.target.getAttribute("data-id");
        // Create an AJAX request
        var xhr = new XMLHttpRequest();
        // Get the data-id attribute value
        var dataId = event.target.getAttribute("data-id");
        // Create an AJAX request
        var xhr = new XMLHttpRequest();

        // Set up the request
        xhr.open("POST", "../ajax/fetch_data.php?id="+ dataId, true);

        // Set the callback function to handle the response
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
            // Process the response here if needed
            generatePDFFromData(xhr.responseText);
        }
        };

        // Send the request
        xhr.send();
}

async function generatePDFFromData(resp) {
  var responseParent = JSON.parse(resp);
  var file_name = (responseParent.subtopic + responseParent.topic).replace(/ /g, "_");
  console.log(file_name);

  // Send data to the server to render HTML content
  fetch('../offline_ppr', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ data: responseParent.data })
  })
  .then(response => response.text())
  .then(async(html) => {

        var tempDiv = document.createElement('div');
        // Insert the received HTML into the temporary div

        tempDiv.innerHTML = html;

        console.log(tempDiv);
        
        let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=100');

        mywindow.document.write(`<html><head><title>${file_name}</title>`);
        mywindow.document.write('</head><body >');
        mywindow.document.write(tempDiv.innerHTML);
        mywindow.document.write('</body></html>');

        // Add a delay before printing to allow time for the charts to render
        setTimeout(function () {
            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10
            mywindow.print();
            mywindow.close();
        }, 5000); // Adjust the delay as needed

        // mywindow.document.title = file_name;

        return true;
    })
    .catch(error => console.error('promise_error: ', error));
}
<?php } if($page == 'dashboard.php' || $page == 'practice.php') { ?> 
    function updateProgress(current, total) {
        const progress = document.getElementById('progress');
        const percentage = (current / total) * 100;

        progress.style.width = percentage + '%';
    }

    updateProgress(<?php echo $chkLevelRow['level'] ?? 0; ?>, <?php echo $cntSbtpRow['total_levels'] ?? 0; ?>);
<?php } ?>
</script>
<?php if($page=='dashboard.php' || $page=='leaderboard.php' || $page=='practice.php' || $page == 'category.php') { ?>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
    </script>
<?php } ?>
<?php if($page == 'packages.php') { ?>
    <script>

//var buyBtn2 = document.getElementById('payButton2');
//var buyBtn3 = document.getElementById('payButton3');

function initializeSubscription(sessid,planid, btnId, plan, price, description) {
    var buyBtn = document.getElementById(btnId);
    var responseContainer = document.getElementById('paymentResponse');

    var createCheckoutSession = function (stripe) {
        return fetch("stripe_charge.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                checkoutSession: sessid,
                Name: plan,
                ID: planid,
                Price: price,
                Description: description,
                Currency: "inr",
            }),
        }).then(function (result) {
            return result.json();
        });
    };

    var handleResult = function (result) {
        if (result.error) {
            responseContainer.innerHTML = '<p>' + result.error.message + '</p>';
        }
        buyBtn.disabled = false;
        buyBtn.textContent = 'Buy Now';
    };

    var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

    buyBtn.addEventListener("click", function () {
        buyBtn.disabled = true;
        buyBtn.textContent = 'Please wait...';
        createCheckoutSession(stripe).then(function (data) {
            if (data.sessionId) {
                stripe.redirectToCheckout({
                    sessionId: data.sessionId,
                }).then(handleResult);
            } else {
                handleResult(data);
            }
        });
    });
}

<?php $pkg=0; $pkg_qury = mysqli_query($conn, "SELECT id,name,description,ROUND((price * (1 - (discount / 100))), 2) AS price,discount FROM plan WHERE status=1 order by id asc");
while($pkg_rslt = mysqli_fetch_assoc($pkg_qury)) { ?>
initializeSubscription('<?php echo 'wk00'.$pkg_rslt['id'];?>','<?php echo $pkg_rslt['id'];?>','paybtn<?php echo $pkg+1;?>', '<?php echo $pkg_rslt['name'];?>', '<?php echo $pkg_rslt['price'];?>', '<?php echo $pkg_rslt['description'];?>');
<?php $pkg++; } ?>

    $('.phonepe-btn').on('click', function () {
        var dataPlan = $(this).attr('data-plan');

        $.ajax({
            type: "post",
            url: "phone_pe-charge",
            data: {
                plan_id: dataPlan
            },
            success: function(res) {
                var response = JSON.parse(res);

                if(response !== '') {
                    window.location.href = response;
                } else {
                    alert("Invalid response!");
                }
            }
        });
    });
</script>
<?php } ?>

<script>
    $(document).ready(function () {
    $.validator.addMethod("alpha", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z ]+$/);
});

$.validator.addMethod("selectSchool", function(value, element) {
      return value !== "Select School";
    }, "Please select a school.");
    
$('#lsForm').validate({
    rules: {
        fullname: {
            required: true,
            alpha: true
        },
        mobile: {
            required: true,
            number: true,
            rangelength: function() {
                // Check the selected country code
                var countryCode = $("#countryCode option:selected").data("countrycode");

                // If the country code is "IN" (India), enforce a length of 10 characters
                if (countryCode === "IN") {
                    return [10, 10];
                }

                // If no country code is selected or if it's a different country, allow any length
                return;
            }
        },
        email: {
            required: true,
            email: true
        },
        password: {
            required: true,
            minlength: 8
        },
        clsName: {
            required: true,
        },
        school: {
            selectSchool: true,
        },
        others: {
            required: true,
        },
    },
    messages: {
        fullname: 'Please enter fullname.',
        mobile: {
          required: 'Please enter Contact.',
          rangelength: 'Contact should be 10 digit number'
        },
        email: {
          required: 'Please enter Email Address',
          email: 'Please enter a valid Email Address',
        },  
        password: {
          required: 'Please enter Password.',
          equalTo: 'Confirm Password do not match with Password.',
        },
        clsName: {
          required: 'Please select class.',
        },
        school: {
          selectSchool: 'Please select school.',
        },
        others: {
          required: 'Please enter school name.',
        },
    },
    errorPlacement: function (error, element) {
        element.parents(".form-group").find(".error").append(error);
    },
    submitHandler: function (form) {
        form.submit();
    }

});

  // Prevent form submission when the "Select School" is not chosen
    $("#lsForm").submit(function (e) {
        if ($(".dselect-placeholder").text() === "Select School") {
            e.preventDefault();
            $("#error-message").text("Please select school.");
        }
    });

    // Update the selected school when an option is clicked
    $(".dropdown-content a").on("click", function () {
        $("#error-message").text(""); // Clear the error message when a school is selected
        $(".dselect-placeholder").text($(this).text());
    });
});
</script>
</body>
</html>