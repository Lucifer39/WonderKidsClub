<?php
include("config/config.php");
include("functions.php");

$url = trim($_SERVER["REQUEST_URI"],"/");
$id = substr($url, strrpos($url, '/'));

$pagesql = mysqli_query($conn, "SELECT body,meta_details FROM other_pages WHERE id=4");
$pagerow = mysqli_fetch_array($pagesql);

include("header.php");
?>
    <main>
        <section class="section pb-0">
            <div class="container">
            <div class="breadcrumbs st-breadcrumbs mb-3">
                                <span><a href="<?php echo $baseurl;?>">Home</a></span>
                                <span><?php echo trim(ucwords(preg_replace("/[^a-zA-Z]+/", " ",$id))); ?></span>
                        </div>
            </div>
        </section>
        <section class="section pt-0">
            <div class="container">
                <div class="text-left">
                    <div class="content">
                        <?php echo $pagerow['body'];?>
                    </div>
                </div>
            </div>

        </section>
<?php include('footer.php'); ?>