<?php 
include("config/config.php");
include("header.php");
?>
<section class="section pt-4 pb-5">
	<div class="container">
	<div class="breadcrumbs st-breadcrumbs mb-md-4 mb-3">
                                <span><a href="<?php echo $baseurl; ?>">Home</a></span>
                                <span>Payment Information</span>
                            </div>
			<div class="row justify-content-center">
				<div class="col-md-8 mt-3">
					<div class="blk-widget-inner p-lg-5 p-md-4 text-center">
                    <h3 class="page-title text-center mt-2 mb-4 me-0">Your transaction was canceled!</h3>
                        <a href="packages" class="link-btn btn-ht-auto">Back to smarty packs</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>   
<?php include("footer.php"); mysqli_close($conn);?>

