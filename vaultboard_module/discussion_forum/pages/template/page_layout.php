<?php 
    $dir = __DIR__;
    $parentdir = dirname(dirname(dirname($dir)));
    require_once($parentdir . "/connection/dependencies.php");
    include($parentdir.'/global/navbar.php');

    $page_type = $_GET["pt"] ?? "newsfeed";
    $student = getCurrentStudent();

    $getGuest = getGuest();
    if($getid == "" && $getGuest == ""){
        echo '<script>window.location.href = "'. GLOBAL_URL .'index.php";</script>';
    }

    if($getid == ""){
        require_once("../../global/guest_modal.php");
    }

    // phpinfo();
?>

<script>
    var student = <?php echo json_encode($student); ?>;
</script>

<head>
    <title>Discussion Forum</title>
    <link rel="stylesheet" href="template/page_layout.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <?php 

        if($getid !== ""){
        if(isset($_GET["pt"]) && $_GET["pt"] == "post_page"){
            ?>
                <aside class="back-button-box">
                    <a href="newsfeed.php">
                        <button class="back-button">
                            <img src="../media_bucket/assets/go-back-icon.svg" alt="">
                        </button>
                    </a>
                </aside>

            <?php
        }
    ?>

    <div class="modal-post" id="modal-post">
        <div class="modal-content-discussion">
            <div class="modal-header">
                <div class="modal-user">
                    <img src="../../type_master/assets/avatars/<?php echo $student['avatar'] ? $student['avatar'] : "default-icon.svg"; ?>">
                    <div class="user-profile-name">
                        <?php echo $student["name"]; ?>
                    </div>
                </div>
                <button class="modal-close-btn" id="modal-close-btn">
                    <img src="../media_bucket/assets/close-icon.svg" alt="">
                </button>
            </div>
            <div class="modal-body">
                <textarea id="post-textarea" placeholder="What do you want to discuss about?"></textarea>
                <div class="progressBar" id="progess-bar-discussion" style="display: none;">
                    <div class="progressBarFill" id="progress-bar-fill-discussion"></div>
                </div>
                <div class="modal-media" id="modal-media"></div>
                <div class="modal-options" id="modal-options">
                    <div class="file-upload">
                        <input type="file" id="imageInput" accept="image/*" class="file-input" max="1mb">
                        <label for="imageInput" class="file-label">
                            <i class="bi bi-file-earmark-image"></i>
                        </label>
                    </div>

                    <div class="file-upload">
                        <input type="file" id="videoInput" accept="video/*" class="file-input" max="2mb">
                        <label for="videoInput" class="file-label">
                            <i class="bi bi-camera-reels-fill"></i>
                        </label>
                    </div>

                    <div class="file-upload">
                        <input type="file" id="pdfInput" accept=".pdf" class="file-input" max="1mb">
                        <label for="pdfInput" class="file-label">
                            <i class="bi bi-file-earmark-pdf-fill"></i>
                        </label>
                    </div>
                </div>
                <div class="modal-post-button">
                    <button class="post-button" id="post-button">Post</button>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="container" style="margin-top:70px">

    <?php if($getid !== ""){ ?>
        <aside class="user-profile">
            <div class="user-profile-avatar">
                <img src="../../type_master/assets/avatars/<?php echo $student['avatar'] ? $student['avatar'] : "default-icon.svg"; ?>">
            </div>
            <div class="user-profile-details-box">
                <div class="user-profile-name">
                    <?php echo $student["name"]; ?>
                </div>
                <div class="user-profile-details">
                    <?php echo $student["school"] ." | ". $student["class"]; ?>
                </div>
            </div>
        </aside>
        <?php } ?>
        <main>
            <?php
                if($page_type == "newsfeed"){ ?>
                    <section class="create-post-section">
                        <div class="create-post-box">
                            <img src="../../type_master/assets/avatars/<?php echo $student['avatar'] ?? "default-icon.svg"; ?>">
                            <button <?php if($getid !== "") { ?>
                                id="start-post-btn"
                            <?php } else { ?>
                                data-bs-toggle="modal" data-bs-target="#loginModal" data-card="discussion"
                            <?php } ?>    
                            >Start a post</button>
                        </div>
                    </section>

                    
               <?php } ?>
            <section class="newsfeed-body" id="newsfeed-body">
                No posts to show
            </section>
        </main>

        <?php if($getid !== ""){ ?>
        <aside class="notification-tab">
            <div class="notification-header">
                Notifications <span class="notification-count" id="notification-count"></span>
            </div>
            <div class="notification-list" id="notification-list">
                
            </div>
        </aside>
        <?php } ?>
    </div>
</body>

<script src="template/page_layout.js"></script>

