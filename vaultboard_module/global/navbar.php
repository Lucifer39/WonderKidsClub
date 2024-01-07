<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once('head.php');
require_once('navigation.php');
include_once(ROOT_FOLDER.'login_page.php');
require_once("popup.php");
require_once(ROOT_FOLDER. "admin/functions/toggleSectionsFunctions.php");

$getid = getID();
$getGuest = getGuest();
$desc = getCurrentStudent();

if(($getid == "" && $getGuest == "") && !isset($_GET["data"])) {
    ?>
        <script>
            window.location.href = "<?php echo ROOT_DOMAIN_URL; ?>?redirect=<?php echo urlencode(REDIRECT_URL); ?>";
        </script>
    <?php
}

if(isset($_GET["data"]) && isset($_GET["iv"])) {
    $encodedEncryptedNumber = $_GET["data"];
    $data = base64_decode(urldecode($encodedEncryptedNumber));
    $iv = urldecode($_GET["iv"]);
    $encryptedNumber = $data;
    $decryptedNumber = openssl_decrypt($encryptedNumber, 'aes-256-cbc', SECRET_KEY, 0, $iv);
    if ($decryptedNumber !== false) {
        // echo "Decrypted Number: " . $decryptedNumber;
        setID($decryptedNumber);
        setRootID($decryptedNumber);
        setGuest("");

        ?>
            <script>
                var currentURL = window.location.href;
                // Split the URL by "?" to separate the base URL from the query parameters
                var urlParts = currentURL.split("?");
                var baseURL = urlParts[0];

                // Redirect to the base URL without query parameters
                window.location.href = baseURL;
            </script>
        <?php

    } else {
        echo "Decryption failed.";
    }
}


?>

<script>
    var current_student = <?php echo json_encode($desc); ?>;
</script>
<style>
    *{
        font-family:'Crimson Pro';
        letter-spacing: 1px;
    }

    #navbarText a{
        color: black ;
        text-decoration:none;
    }
    .activenav{
        background-color:#34D1BF;
        border-radius:10px;
        color:black !important;
    }
    .navbar-custom{
        background-color:#FEFAE0;
    }
    .nav-icon{
        font-size:0.75rem;
    }
    .notification-badge{
        position: absolute;
        /* top: 0;
        right: 0; */
        transform: translate(50%, -50%);
        background-color: red;
        color: #fff;
        border-radius: 50%;
        font-size: 12px;
        padding: 3px 6px;
        display: none;
    }
    .dropdown-hover {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        right: 0px;
        z-index: 9999;
    }

    .dropdown-hover:hover .dropdown-menu {
        display: block;
    }
    .dropdown-menu a:hover{
        background-color:lightgray
    }

    /*notification*/
.notification-btn {
  position: relative;
  border: none;
  outline: none;
  cursor: pointer;
}

.notification-btn .badge {
  position: absolute;
  top: 0;
  right: 0;
  transform: translate(50%, -50%);
  background-color: red;
  color: #fff;
  border-radius: 50%;
  font-size: 12px;
  padding: 3px 6px;
}

.notification-content {
  position: absolute;
  z-index: 999;
  right: 2rem;
  top: 15px;
  display: none;
  background-color: #fff;
  width: 300px;
  max-height: 500px;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
  padding: 1rem;
  flex-direction: column;
  justify-content: flex-start;
  align-items: center;
  overflow-y: scroll;
}

.notification-content div a {
  color: black;
}

.notification-content div {
  border-bottom: 1px solid gray;
}

.notification-content div.notif-unseen:hover {
  background-color: #eee;
}

.notification-content div.notif-seen a:hover{
    cursor: default;
}

.notif-unseen {
  background-color: #efefef;
  /* color: #f0f0f0; */
}

.notif-seen{
    font-style: italic;
    color: #bbb;
}

.profile-section-nav{
    display: flex;
    align-items: center;
    justify-content: space-evenly;
}

.profile-avatar-nav img{
    height: 2rem;
    width: 2rem;
    border-radius: 50%;
    border: 1px solid black;
    margin-right: 20px;
}

.progressBar {
      width: 100%;
      height: 10px;
      background-color: #f1f1f1;
      border-radius: 2rem;
    }
    
    .progressBarFill {
      height: 100%;
      background-color: #3498db;
      width: 0;
      transition: width 0.5s ease-in-out;
      border-radius: 2rem;
    }

    .glowing-dot {
  position: relative;
  background-color: #000;
  animation: bounce 0.25s infinite alternate;

}

.glowing-dot::before {
  content: "";
  position: absolute;
  top: -1px;
  left: -0.5px;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: red;
}

.navbar-toggler{
    box-shadow: none;
}


@media screen and (max-width: 768px) {
    .navbar-buffer{
        width: 20%;
    }

    .custom-navbar-mobile{
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .dropdown-menu{
        right: -50%
    }

    .nav-icon{
        padding: 1rem !important
    }
}

@media screen and (max-width: 360px) {
    .navbar-buffer {
        width: 15%;
    }
}

@media screen and (max-width: 280px) {
    .navbar-buffer {
        width: 5%;
    }
}

@keyframes bounce {
  0% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(-5px);
  }
}


</style>

<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid">

        <a class="navbar-brand text-black" href="<?php echo GLOBAL_URL ?>"><img src="<?php echo GLOBAL_URL ?>/global/images/wonderkids-logo.svg"></a>
        <div class="navbar-buffer"></div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse custom-navbar-mobile" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                <a href="<?php echo ROOT_DOMAIN_URL; ?>" class="nav-icon navbar-text p-2 ms-3">
                    <span>
                        <img src="<?php echo GLOBAL_URL ?>landing/assets/vocabulary.png" width="20"/>
                        <b>WONDERKIDS</b>
                    </span>
                </a>
                <?php
                    if(getSpecificSection("spellathon") == 1) {
                        if($getid == "" && $getGuest == ""){ ?>
                            <a href="#" class="nav-icon navbar-text p-2 ms-3" data-bs-toggle="modal" data-bs-target="#loginModal" data-card="spellathon">
                        <?php }else{ ?>
                            <a class="navbar-text p-2 ms-3" href="<?php echo GLOBAL_URL ?>spellathon/">
                        <?php } ?>
                            <span>
                                <img src="<?php echo GLOBAL_URL ?>landing/assets/vocabulary.png" width="20"/><b> SPELLATHON </b>
                            </span>
                        </a>
                        <?php 
                    }

                    if(getSpecificSection("vocab") == 1) {
                        if($getid == "" && $getGuest == ""){ ?>
                            <a href="#" class="nav-icon navbar-text p-2 ms-3" data-bs-toggle="modal" data-bs-target="#loginModal" data-card="vocabulary_module">
                        <?php }else{ ?>
                            <a class="nav-icon navbar-text p-2 nav-icon ms-3" href="<?php echo GLOBAL_URL ?>vocabulary_module/">
                        <?php } ?>
                            <span>
                                <img src="<?php echo GLOBAL_URL ?>landing/assets/vocabulary.png" width="20"/><b> VOCABULARY</b>
                            </span>
                        </a>
                        <?php 
                    }

                    if(getSpecificSection("context_vocab") == 1) {
                        if($getid == "" && $getGuest == ""){ ?>
                            <a href="#" class="navbar-text p-2 ms-3 nav-icon" data-bs-toggle="modal" data-bs-target="#loginModal" style="font-size: 0.75rem;" data-card="vocabulary_context">
                        <?php }else{ ?>
                            <a class="navbar-text p-2 ms-3 nav-icon" style="font-size: 0.75rem;" href="<?php echo GLOBAL_URL ?>vocabulary_context/">
                        <?php } ?>
                            <span>
                                <img src="<?php echo GLOBAL_URL ?>landing/assets/conversation.png" width="20"/> <b>SPECIAL VOCABULARY</b>
                                <span class="notification-badge" id="notification-disc"></span>
                            </span>
                        </a>
                        <?php 
                    }

                    if(getSpecificSection("type_master") == 1) {
                        if($getid == "" && $getGuest == ""){ ?>
                            <a href="#" class="navbar-text p-2 ms-3 nav-icon" data-bs-toggle="modal" data-bs-target="#loginModal" data-card="type_master">
                        <?php }else{ ?>
                            <a class="navbar-text p-2 ms-3 nav-icon" href="<?php echo GLOBAL_URL ?>type_master/">
                        <?php } ?>
                            <span>
                                <img src="<?php echo GLOBAL_URL ?>landing/assets/typing.png" width="20"/><b> TYPING</b>
                            </span>
                        </a>
                        <?php 
                    }
                    if(getSpecificSection("discussion") == 1) {
                        if($getid == "" && $getGuest == ""){ ?>
                            <a href="#" class="navbar-text p-2 ms-3 nav-icon" data-bs-toggle="modal" data-bs-target="#loginModal" data-card="discussion_forum/pages/newsfeed.php">
                        <?php }else{ ?>
                            <a class="navbar-text p-2 ms-3 nav-icon" href="<?php echo GLOBAL_URL ?>discussion_forum/pages/newsfeed.php">
                        <?php } ?>
                            <span>
                                <img src="<?php echo GLOBAL_URL ?>landing/assets/conversation.png" width="20"/> <b>DISCUSSION</b>
                                <span class="notification-badge" id="notification-disc"></span>
                            </span>
                        </a>
                    <?php } 
                    if(getSpecificSection("competitions") == 1) {
                            ?>
                        <a class="navbar-text p-2 ms-3 nav-icon" href="<?php echo GLOBAL_URL ?>competitions/">
                            <span>
                                <img src="<?php echo GLOBAL_URL ?>landing/assets/participate.png" width="20"/> <b>PARTICIPATE</b>
                            </span> 
                        </a> 
                        <?php
                    }
                if($getid == ""){ ?>
                    <span class="ms-3">
                        <button type="button" class="btn btn-outline-dark shadow" data-bs-toggle="modal" data-bs-target="#loginModal">SignIn / SignUp</button>
                    </span>
                <?php }else{ ?>
                    <span class="dropdown ms-3">
                        <h5 class="mt-2 ms-4 me-2 dropdown-toggle dropdown-hover">
                            <!-- <b> -->
                                <?php 
                                if(check_about()){
                                    ?>
                                        <div class="glowing-dot"></div>
                                    <?php
                                }
                                ?>
                                <img src="<?php echo GLOBAL_URL ?>type_master/assets/avatars/<?php echo $desc['avatar'] ? $desc['avatar'] : "default-icon.svg"; ?>" width="24" class="dropdown-img" />
                                <?php echo $desc['name']; ?>
                            <!-- </b> -->
                            <ul class="dropdown-menu">
                                <!-- <li>
                                    <a class="dropdown-item" href="#"><b>Class:</b> <?php echo $desc['class']; ?></a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"><b>School:</b> <?php echo $desc['school']; ?></a>
                                </li> -->
                                <li>
                                    <a class="dropdown-item" href="<?php echo GLOBAL_URL; ?>user_profile/">
                                        <div class="profile-section-nav">
                                            <div class="profile-avatar-nav">
                                                <img src="<?php echo GLOBAL_URL ?>type_master/assets/avatars/<?php echo $desc['avatar'] ? $desc['avatar'] : "default-icon.svg" ?>" />
                                            </div>
                                            <div class="profile-details-nav">
                                                <b><?php echo explode(" ", $desc["name"])[0]; ?></b>
                                                <div class="profile-class-school-nav">
                                                    <?php echo $desc["school"] . " | " . $desc["class"]; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <div id="progressBar" class="progressBar">
                                        <div id="progressBarFill" class="progressBarFill"></div>
                                    </div>
                                    Profile Completed: <?php 
                                        if($getid !== ""){
                                            echo get_profile_completion() ."%";
                                            ?>
                                                <script>
                                                    var profile_progression = <?php echo json_encode(get_profile_completion()) ?>;
                                                </script>
                                            <?php
                                        }
                                    ?>
                                </li>
                                
                                            <li>
                                            <?php 
                                    if(check_about()){
                                        ?>
                                                <div class="glowing-dot"></div>
                                                <?php
                                    }    
                                 ?>
    
                                                <a class="dropdown-item" href="<?php echo GLOBAL_URL ?>chatbot">
                                                    <b>About <i class="bi bi-info-circle"></i><b>
                                                </a>
                                            </li>
                                       
                                <li>
                                    <a class="dropdown-item" href="<?php echo ROOT_DOMAIN_URL; ?>"><b>Wonderkids</b></a>
                                </li>            
                                <li>
                                    <a class="dropdown-item" href="<?php echo GLOBAL_URL ?>connection/logout.php"><b>Logout</b></a>
                                </li>
                            </ul>
                        </h5>
                    </span>
                    <span class="notification-btn" id="notification-btn">
                        <i class="bi bi-bell-fill text-warning" style="font-size:20px"></i>
                        <span class="badge" id="badge"></span>
                    </span>
                    <div class="notification-content" id="notification-content"></div>
                <?php } ?>
        </div>
    </div>
</nav>
<script>
    $(document).ready(function() {
        // Add click event handler to each navbar text span
        $(".navbar-text").click(function() {
            // Remove "activenav" class from all spans
            $(".navbar-text").removeClass("activenav");
            
            // Add "activenav" class to the clicked span
            $(this).addClass("activenav");
        });

        var currentURL = window.location.href;

        // Check each navbar link and add "activenav" class if the URL matches
        $(".navbar-text").each(function() {
        var linkURL = $(this).attr("href");

        if ((currentURL.indexOf(linkURL) !== -1) 
            || (linkURL.indexOf("type_master") !== -1 
                && currentURL.indexOf("learn_typing") !== -1)) {
                    $(this).addClass("activenav");
            }
        });

        // Store the selected card ID in the hidden input field
        $("a").click(function() {
            var cardId = $(this).data("card");
            $("#selectedCard").val(cardId);
        });
    });

    function updateProgressBar(progress) {
      const progressBarFill = document.getElementById("progressBarFill");
      progressBarFill.style.width = progress + "%";
    }

    updateProgressBar(profile_progression);
</script>

<?php if($getid !== "") { ?>

<script>
    var global_url = <?php echo json_encode(GLOBAL_URL); ?>;
</script>

<script src="<?php echo GLOBAL_URL ?>/global/notification_script.js"></script>

<script>
    var notif_cont = document.getElementById("notification-content");
    var notif_count = 0;


    function populateNotifications() {
    $.ajax({
        type: "POST",
        url: "<?php echo GLOBAL_URL; ?>type_master/functions/handle_invitations.php?function_name=getNotifications",
        data: {
            student_id: current_student.id,
        },
        success: function (res) {
            var notifs = JSON.parse(res);
            notif_cont.innerHTML = "";
            notif_count = 0;

            notifs.forEach((element) => {
                var anchor = document.createElement("a");
                var div = document.createElement("div");
                anchor.href = element.status == "pending" ? `<?php echo GLOBAL_URL ?>type_master/index.php?page=waiting_room_page&rc=${element.room_id}&ro=0&rt=${element.room_type}` : "#";
                anchor.textContent = `${element.sender} has invited you to a typing race room.` + (element.status !== "pending" ? "(Expired)" : "");

                div.appendChild(anchor);
                

                if (element.seen_notification == 0) {
                    notif_count++;
                    div.classList.add("notif-unseen");
                }
                else{
                    div.classList.add("notif-seen");
                }

                notif_cont.appendChild(div);
            });

            document.getElementById("badge").innerText = notif_count > 0 ? notif_count : "";
            },
        });
    }

    setInterval(populateNotifications, 3000);



    document.getElementById("notification-btn").addEventListener("mouseover", () => {
        // if(notif_count > 0){
            notif_cont.style.display = "flex";

            $.ajax({
                type: "POST",
                url: "../type_master/functions/handle_invitations.php?function_name=seenNotification",
                data: {
                    user_id: current_student.id
                }
            })
        // }
    });

    notif_cont.addEventListener("mouseover", () => {
        notif_cont.style.display = "flex";
    });

    document.getElementById("notification-btn").addEventListener("mouseout", () => {
        notif_cont.style.display = "none";
    });

    notif_cont.addEventListener("mouseout", () => {
        notif_cont.style.display = "none";
    });

</script>

<?php } ?>