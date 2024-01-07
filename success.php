<?php
// Include configuration file 
require_once 'config/config.php';
require_once 'functions.php';


    $pageview = $_GET['getID']; 
	#$selectproduct =mysqli_query($conn, "select * from products where id = '$pageview' ");
    #$rowproduct =mysqli_fetch_array($selectproduct,MYSQLI_ASSOC); 			
			
    $payment_id = $statusMsg = '';
    $ordStatus = 'error';

    $pkg_qury = mysqli_query($conn, "SELECT id,total_days,name FROM plan WHERE id = '".$pageview."'");
    $pkg_rslt = mysqli_fetch_array($pkg_qury, MYSQLI_ASSOC);

// Check whether stripe checkout session is not empty
if(!empty($_GET['session_id']) && !empty($pkg_rslt['id'])){
    $session_id = $_GET['session_id'];
    
    // Fetch transaction data from the database if already exists
    $sql = "SELECT * FROM orders WHERE checkout_session_id = '".$session_id."'";
    $result = $conn->query($sql);
    
	if ( !empty($result->num_rows) && $result->num_rows > 0) {
        $orderData = $result->fetch_assoc();
        
        $paymentID = $orderData['id'];
        $transactionID = $orderData['txn_id'];
        $paidAmount = $orderData['paid_amount'];
        $paidCurrency = $orderData['paid_amount_currency'];
        $paymentStatus = $orderData['payment_status'];
        
        $ordStatus = 'success';
        $statusMsg = 'Your Payment has been Successful!';
    }else{
        // Include Stripe PHP library 
        require_once 'stripe-php/init.php';
        
        // Set API key
        \Stripe\Stripe::setApiKey(STRIPE_API_KEY);
        
        // Fetch the Checkout Session to display the JSON result on the success page
        try {
            $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
        }catch(Exception $e) { 
            $api_error = $e->getMessage(); 
        }
        
        if(empty($api_error) && $checkout_session){
            // Retrieve the details of a PaymentIntent
            try {
                $intent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $api_error = $e->getMessage();
            }
            
            // Retrieves the details of customer
            /*try {
                // Create the PaymentIntent
                $customer = \Stripe\Customer::retrieve($checkout_session->name);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $api_error = $e->getMessage();
            }*/
            
            if(empty($api_error) && $intent){ 
                // Check whether the charge is successful
                if($intent->status == 'succeeded'){
                    // Customer details
                    $name = $checkout_session->customer_details->name;
                    $email = $checkout_session->customer_details->email;
                    
                    // Transaction details 
                    $transactionID = $intent->id;
                    $paidAmount = $intent->amount;
                    $paidAmount = ($paidAmount/100);
                    $paidCurrency = $intent->currency;
                    $paymentStatus = $intent->status;
                    
					 // Insert transaction data into the database 
                     

                    
					//$sql = "INSERT INTO orders(name,email,item_name,item_number,item_price,item_price_currency,paid_amount,paid_amount_currency,txn_id,payment_status,checkout_session_id,created,modified) VALUES('".$name."','".$email."','".$rowproduct['name']."','".$rowproduct['id']."','".$rowproduct['price']."','".$rowproduct['currency']."','".$paidAmount."','".$paidCurrency."','".$transactionID."','".$paymentStatus."','".$session_id."',NOW(),NOW())"; 
                    $sql = "INSERT INTO orders(userid,name,email,paid_amt,paid_curr,transcation_id,plan,planid,status,checkout_session_id,created,modified)
                    VALUES ('".$_SESSION['id']."','".$name."','".$email."','".$paidAmount."','".$paidCurrency."','".$transactionID."','".$pkg_rslt['name']."','".$pkg_rslt['id']."','".$paymentStatus."','".$session_id."',NOW(),NOW())"; 
					
                    $insert = $conn->query($sql);
                    $paymentID = $conn->insert_id;

                    $_SESSION['generateOTP'] = md5(generateNumericOTP(6));

                    mysqli_query( $conn, "update users Set confirmation_code='".$_SESSION['generateOTP']."' WHERE id='".$_SESSION['id']."'" );



                    //$sql = mysqli_query($conn, "INSERT INTO orders(userid,name,email,paid_amt,paid_curr,transcation_id,status,checkout_session_id,created,modified) 
                    //VALUES ('".$_SESSION['id']."','".$name."','".$email."','".$paidAmount."','".$paidCurrency."','".$transactionID."','".$paymentStatus."','".$session_id."',NOW(),NOW())");
		
                    
						$ordStatus = 'success';
						$statusMsg = 'Your Payment has been Successful!';
                   
                }else{
                    $statusMsg = "Transaction has been failed!";
                }
            }else{
                $statusMsg = "Unable to fetch the transaction details! $api_error"; 
            }
            
            $ordStatus = 'success';
        }else{
            $statusMsg = "Transaction has been failed! $api_error"; 
        }
    }
}else{
	$statusMsg = "Invalid Request!";
}

require_once("header.php");

$sbs_qury = mysqli_query($conn, "SELECT subscribe_at,plan FROM users WHERE id='".$_SESSION['id']."' and confirmation_code='".$_SESSION['generateOTP']."'");
$sbs_rslt = mysqli_fetch_array($sbs_qury, MYSQLI_ASSOC);

if($ordStatus = 'success' && $sbs_rslt['subscribe_at']) {


    unset($_SESSION['generateOTP']);

    if($sbs_rslt['plan'] == '0') {
        $currentDateTime = date('Y-m-d H:i:s');
    } else {
        $currentDateTime = $sbs_rslt['subscribe_at'];
    }
    $currentDateTime = date('Y-m-d H:i:s', strtotime($currentDateTime . ' + '.$pkg_rslt['total_days'].' days'));
    mysqli_query( $conn, "update users Set subscribe_at='".$currentDateTime."',confirmation_code='".md5(generateNumericOTP(6))."',plan='".$pageview."' WHERE id='".$_SESSION['id']."'" );
} else {

}

$sql = mysqli_query($conn, "SELECT * FROM orders WHERE checkout_session_id = '".$session_id."' and userid='".$_SESSION['id']."'");
$result = mysqli_fetch_array($sql, MYSQLI_ASSOC);

include('mail.php');
?>
<section class="section pt-4 pb-5">
	<div class="container">
	<div class="breadcrumbs st-breadcrumbs mb-md-4 mb-3">
                                <span><a href="<?php echo $baseurl; ?>">Home</a></span>
                                <span>Success</span>
                            </div>
		<div id="paymentResponse"></div>
			<div class="row justify-content-center">
				<div class="col-md-8 mt-3">
					<div class="blk-widget-inner p-4 text-center">
                    <h3 class="page-title text-center mt-2 mb-4 me-0"><?php if(!empty($statusMsg)) { echo $statusMsg; } else { echo 'Payment Status'; } ?></h3>
                        <table class="table borderless cc-table">
                            <tbody>
                                <tr>
                                    <td align="right" width="35%"><b>Transaction ID:</b></td>
                                    <td align="left" width="65%"><?php echo $result['transcation_id']; ?></td>
                                </tr>
                                <tr>
                                    <td align="right"><b>Paid Amount:</b></td>
                                    <td align="left" class="text-uppercase"><?php echo $result['paid_amt'].' '.$result['paid_curr']; ?></td>
                                </tr>
                                <tr>
                                    <td align="right"><b>Plan:</b></td>
                                    <td align="left"><?php echo $result ['plan']; ?></td>
                                </tr>
                                <tr>
                                    <td align="right"><b>Payment Status:</b></td>
                                    <td align="left"><?php echo $result['status']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="packages" class="link-btn btn-ht-auto mt-4">Back to smarty packs</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>    
<?php include("footer.php"); mysqli_close($conn);?>
