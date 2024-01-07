<?php 
include("config/config.php");

include("header.php");

$currentDateTime = strtotime(date('Y-m-d H:i:s'));
$subscribeTime = strtotime($chkplan_rslt['subscribe_at']);

?>
<script src="https://js.stripe.com/v3/"></script>
<section class="section pt-4 pb-5">
	<div class="container">
	<div class="breadcrumbs st-breadcrumbs mb-md-4 mb-3">
                                <span><a href="<?php echo $baseurl; ?>">Home</a></span>
                                <span>Smarty Packs (Packages)</span>
                            </div>
							<div class="mb-2">
            <h1 class="page-title txt-navy">Smarty Packs (Packages)</h1>
            <p class="lead">Welcome to the world of learning and discovery for students.</p>
        </div>
		<div id="paymentResponse"></div>
<?php if($subscribeTime > $currentDateTime && $chkplan_rslt['plan'] !=0) { ?>
			<div class="blk-widget mt-4 mb-4 p-4 text-center">
		<h3 class="page-title text-center mb-0 me-0">	
		Your plan is active till <?php echo date("F j, Y", strtotime($chkplan_rslt['subscribe_at']));?>.
		</h3>
		</div>
		<?php } elseif($chkplan_rslt['plan'] !=0) { ?>
			<div class="blk-widget mt-4 mb-4 p-4 text-center">
		<h3 class="page-title text-center mb-0 me-0">
			Your plan is inactive.
			</h3>
		</div>
		<?php } ?>

			<div class="row">

			<?php $pkg=0; $pkg_qury = mysqli_query($conn, "SELECT id,name,description,ROUND((price * (1 - (discount / 100))), 2) AS price, price AS original_price,discount FROM plan WHERE status=1 order by id asc");
				  while($pkg_rslt = mysqli_fetch_assoc($pkg_qury)) { ?>
				<div class="col-md-4 mt-4">
					<div class="blk-widget-inner p-4 text-center">
						<h3 class="page-title text-center mb-2 me-0"><?php echo $pkg_rslt['name'];?></h3>
						<p><?php echo $pkg_rslt['description'];?></p>
						<button class="btn btn-animated btn-lg ps-5 pe-5 mt-2 paybtn d-flex flex-column" id="paybtn<?php echo $pkg+1;?>" style="height: auto"> Buy Now
							<?php 
								if($pkg_rslt['discount'] == 0){
									echo "<br> ₹" . $pkg_rslt['price'];
								} else {
									echo "<div class='original-price' style='text-decoration: line-through;'>₹". $pkg_rslt['original_price'] ."</div><div class='discount-price'> ₹". $pkg_rslt['price'] ."(Save ". $pkg_rslt['discount'] ."%)</div>";
								}
							?>
						</button>
						<!-- <button class="btn btn-animated btn-lg ps-5 pe-5 mt-2 paybtn d-flex flex-column phonepe-btn" data-plan="<?php echo $pkg_rslt['id'];?>"> <div> Buy Now - ₹<?php echo $pkg_rslt['price'];?> </div> <div> With Phone Pe </div> </button> -->
					</div>
				</div>
				<?php $pkg++; } ?>
			</div>
		</div>
</section>
<section class="section pt-2 pb-5">
	<div class="container">
							<div class="mb-2">
            <h1 class="page-title txt-navy">Transaction History</h1>
            <p class="lead">Welcome to the world of learning and discovery for students.</p>
        </div>
		<div id="paymentResponse"></div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>Plan</th>
							<th>Price</th>
							<th>Purchase Date</th>
							<th>Transaction ID<th>
						</tr>
					</thead>
					<tbody>
					<?php $pkg=0; $pkg_qury = mysqli_query($conn, "SELECT * FROM orders WHERE userid='".$_SESSION['id']."' order by id desc");
				  	while($pkg_rslt = mysqli_fetch_assoc($pkg_qury)) { 
					?>
					<tr>
						<td><?php echo $pkg_rslt['plan']; ?></td>
						<td class="text-uppercase"><?php echo $pkg_rslt['paid_amt'].' '.$pkg_rslt['paid_curr']; ?></td>
						<td><?php echo $pkg_rslt['created']; ?></td>
						<td><?php echo $pkg_rslt['transcation_id']; ?></td>
					</tr>
					<?php $pkg++; } ?>
				  </tbody>
				</table>
			</div>
			</div>
			</div>
		</div>
</section>
<?php include("footer.php"); mysqli_close($conn);?>
    