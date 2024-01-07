<head>
    <link rel="stylesheet" href="newsfeed.css">
    <link rel="stylesheet" href="post_page.css">
</head>
<?php 
    require_once("template/page_layout.php");

    $post_id = $_GET["post_id"] ?? "";
?>

<script>
    var post_id = <?php echo json_encode($post_id); ?>;
</script>

<script src="../scripts/post_page_script.js"></script>

<!-- <div class="comment-section">
    <div class="each-comment">
        <div class="comment-avatar">
            <img src="#" alt="">
        </div>
        <div class="comment-content">
            <div class="comment-header">
                <div class="comment-username">
                    John
                </div>
                <div class="comment-user-det">
                    VMS | 2
                </div>
            </div>
            <div class="comment-body">
                lorem ipsum
            </div>
            <div class="comment-vote">
                <button class="like-button">Upvote</button>
            </div>
        </div>
    </div>
    <div class="each-comment">
        <div class="comment-avatar">
            <img src="#" alt="">
        </div>
        <div class="comment-content">
            <div class="comment-header">
                <div class="comment-username">
                    John
                </div>
                <div class="comment-user-det">
                    VMS | 2
                </div>
            </div>
            <div class="comment-body">
                lorem ipsum
            </div>
            <div class="comment-vote">
                <button class="like-button">Upvote</button>
            </div>
        </div>
    </div>
</div> -->