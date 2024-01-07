<?php
include('global/navbar.php');
require_once("./user_profile/functions/user_profile_functions.php");

$getid = getID();

$getModal = getGuestModal();
if($getid == "" && !$getModal && $getGuest !== ""){
    require_once("global/guest_modal.php");
}
function convertStringToInt($string) {
    if ($string === '') {
        return 0;
    } else {
        return intval($string);
    }
}

$achievements = get_achievements(convertStringToInt($getid));

// phpinfo();

?>
<head>
    <link rel="stylesheet" href="landing/homepage.css">	
    <!-- <link rel='stylesheet' type='text/css' href='./style.css' /> -->
    <style>

        body {
            background-image: url("./landing_banner.svg");
            background-size: 250%;
            background-repeat: no-repeat;
        }

        .carousel-indicators {
            display: flex;
            justify-content: center;
            top:0;
            position: relative;
        }

        .indicator-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: grey;
            margin: 0 6px;
            cursor: pointer;
        }

        .indicator-dot.active {
            background-color: white;
        }

        .index-banner-text{
            width: 25%;
        }

        .homepage-banner{
            margin-top: 50px; 
            padding-left: 5rem;
        }

        .carousel-title{
            text-decoration: underline;
        }

        @media screen and (max-width: 768px) {

            body {
                background-size: 500%;
            }

            .homepage-banner{
                flex-direction: column;
                padding-left: 0;
            }

            .index-pictures{
                display:none;
            }

            .index-banner-text{
                width: 70%;
                text-align: center;
                margin: auto;
            }

            .index-banner-text h2{
                font-size: 2rem;
            }

            .index-banner-text h6{
                font-size: 1rem;
            }

            .index-banner-text a{
                display: none;
            }
        }

    </style>
</head>
<body style="background-color:#71A9F7">
    <div class="carousel"></div>
    <div class="d-flex justify-content-center align-items-center w-100 homepage-banner">
        <div class="index-banner-text" style="margin-top:50px">
            <h1 class="mt-5 text-white">Hello, Brain Builder</h1><br/>
            <h6 class="text-white">Wonder Kids will add learning to your child’s life with various fun learning activities.</h6>
            <a href="#features" class="btn btn-outline-light mt-3 col-6"><b>EXPLORE</b></a>
        </div>
        <div class="index-pictures" style="margin-top:50px; margin-left: 50px; width: 50%">
            <?php 
                if($getid == "" || count($achievements) == 0){
            ?>
            <img src="./global/images/homepage.gif" width="500px" style="border-radius:20px"/>
            <?php 
                }
                else{
            ?>
                    <div id="carouselExampleInterval" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            foreach($achievements as $achievement){
                                ?>
                                    <div class="carousel-item active">
                                        <img src="<?php echo "./user_profile/media_bucket/achievements/img/".$achievement->file_name ?>" class="d-block w-100" width="550px" height="300px" alt="...">
                                    </div>
                                <?php
                            }
                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
    <h3 id="features" class="text-center text-white" style="padding-top:100px;"><b>OUR FEATURES</b></h3>
    <div class="carousel-container mt-5">
        <?php if(getSpecificSection("competitions") == 1) { ?>
            <div class="carousel-card" id="far-left">
                    <a href="competitions/index.php">
                        <img src="landing/assets/competition.png" alt="">
                        <h3 class="carousel-title mt-2">Competition</h3>
                    </a>
                    <p class="carousel-text">Compete, Thrive, and Rise to the Challenge: Unleash Your Potential in Exciting Competitions.</p>
            </div>
        <?php }
        if(getSpecificSection("type_master") == 1) {
        ?>
            <div class="carousel-card" id="left">
                <?php if($getid == "" && $getGuest == ""){ ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-card="typing">
                <?php }else{ ?>
                    <a href="type_master/index.php">
                <?php } ?>
                    <img src="landing/assets/typing.png" alt="">

                    <h3 class="carousel-title mt-2">Type Master</h3>
                </a>
                    <p class="carousel-text">Master the Art of Typing: Improve Speed and Accuracy.</p>
            </div>
        <?php }
         if(getSpecificSection("vocab") == 1) {
        ?>
            <div class="carousel-card" id="center">
                <?php if($getid == "" && $getGuest == ""){ ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-card="vocabulary">
                <?php }else{ ?>
                    <a href="vocabulary_module/index.php">
                <?php } ?>
                    <img src="landing/assets/vocabulary.png" alt="">

                    <h3 class="carousel-title mt-2" style="color: #34d1bf;">Vocabulary</h3>
                </a>
                    <p class="carousel-text">Expand Your Vocabulary: Learn, Practice, and Grow.</p>
            </div>
        <?php }
        
        if(getSpecificSection("discussion") == 1) {
        ?>
            <div class="carousel-card" id="right">
                <?php if($getid == "" && $getGuest == ""){ ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-card="discussion">
                <?php }else{ ?>
                    <a href="discussion_forum/pages/newsfeed.php">
                <?php } ?>
                    <img src="landing/assets/conversation.png" alt="">

                    <h3 class="carousel-title mt-2">Discussion</h3>
                </a>
                    <p class="carousel-text">Engage, Connect, and Share: Join the Discussion Forum Community.</p>
            </div>
        <?php }
        ?>
    </div>
    <!-- Indicator Dots -->
    <!-- <div class="carousel-indicators mt-3">
        <span class="indicator-dot active"></span>
        <span class="indicator-dot"></span>
        <span class="indicator-dot"></span>
        <span class="indicator-dot"></span>
        <span class="indicator-dot"></span>
    </div> -->
    <br/><br/><br/><br/>

</body>
<script src="landing/homepage.js"></script>
<script>
    
    $(document).ready(function() {
        // Store the selected card ID in the hidden input field
        $(".carousel-card a").click(function() {
            var cardId = $(this).data("card");
            $("#selectedCard").val(cardId);
        });

    });
</script>

<script>
    if (navigator.cookieEnabled) {
        console.log("Cookies are enabled.");
    } else {
        console.log("Cookies are disabled. Please enable cookies in your browser settings to use this website.");
    }
</script>