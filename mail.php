<?php
$link = $_SERVER[ 'PHP_SELF' ];
$link_array = explode( '/', $link );
$page = end( $link_array );

include('config/mail_config.php');
              
             
if (isset($_POST['register'])) {
    $mail->AddAddress($email);
    $mail->From = "noreply@wonderkids.club";
    $mail->FromName = "Wonderkids";
    $mail->Subject   = "Account Registration Confirmation";
    
    $message = '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, Helvetica, sans-serif; text-align: center; background-color: #fafafa; font-size: 15px; color: #000; "> <tbody> <tr> <td> <table width="500" cellpadding="0" cellspacing="0" border="0" align="center" style="text-align: center;"> <tbody> <tr> <td style="padding-top: 40px; padding-bottom: 30px;"><img src="https://wonderkids.club/assets/images/wonderkids.png"></td> </tr> <tr> <td style="padding-bottom: 10px; font-size: 24px; font-weight: bold;">Account Registration Confirmation</td> </tr> <tr> <td style="padding-top: 20px; padding-bottom: 30px;">Thank you for creating a new account to access Wonderkids. To use the full range of Wonderkids services you will need to verify the email address on your account.</td> </tr> <tr> <td style="padding-top: 30px; padding-bottom: 60px;"><a href="'.$baseurl.'?confirmation='.md5($genrateotp).'" style="background-color: #ffdfea; padding: 12px 25px; border-radius: 10px; font-size: 24px; color: #012d5d; text-decoration: none;">Verify Now</a></td> </tr> </tbody> </table> </td> </tr> </tbody> </table>';
}   

if (isset($_POST['registeredEmailSubmit'])) {
    $mail->AddAddress($emailchk);
    $mail->From = "noreply@wonderkids.club";
    $mail->FromName = "Wonderkids";
    $mail->Subject   = "Password Updation";
    
    $message = '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, Helvetica, sans-serif; text-align: center; background-color: #fafafa; font-size: 15px; color: #000; "> <tbody> <tr> <td> <table width="500" cellpadding="0" cellspacing="0" border="0" align="center" style="text-align: center;"> <tbody> <tr> <td style="padding-top: 40px; padding-bottom: 30px;"><img src="https://wonderkids.club/assets/images/wonderkids.png"></td> </tr> <tr> <td style="padding-bottom: 10px; font-size: 24px; font-weight: bold;">Forgot Password Link</td> </tr> <tr> <td style="padding-top: 20px; padding-bottom: 30px;">Click on the below link to reset your password!</td> </tr> <tr> <td style="padding-top: 30px; padding-bottom: 60px;"><a href="'.$baseurl.'?forgot-pwd-confirmation='.$genrateotpReg.'" style="background-color: #ffdfea; padding: 12px 25px; border-radius: 10px; font-size: 24px; color: #012d5d; text-decoration: none;">Verify Now</a></td> </tr> </tbody> </table> </td> </tr> </tbody> </table>';
}   
               
    if($page == 'success.php')
        {     

    $mail->AddAddress($result['email']);
    $mail->From = "noreply@wonderkids.club";
    $mail->FromName = "Wonderkids";
    
    if($result['status'] == 'succeeded') {
        $mail->Subject   = "Payment Successful";
    } elseif($result['status'] == 'failed') {
        $mail->Subject   = "Payment Failed";
    }
    
    $message = '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, Helvetica, sans-serif; text-align: center; background-color: #fafafa; font-size: 13px; color: #000; "> <tbody> <tr> <td style="padding-top: 40px; padding-bottom: 10px;"><img src="https://wonderkids.club/assets/images/wonderkids.png"></td> </tr> <tr> <td style="padding: 10px; padding-bottom: 40px;"><table width="500" cellpadding="0" cellspacing="0" align="center" border="0" style="background-color: #FFF; text-align:left; border: 1px solid #ddd;"> <tbody> <tr> <td style="padding: 10px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; font-weight: bold;">Transaction ID:</td> <td style="padding: 10px; border-bottom: 1px solid #ddd;">'.$result['transcation_id'].'</td> </tr> <tr> <td style="padding: 10px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; font-weight: bold;">Paid Amount:</td> <td style="padding: 10px; border-bottom: 1px solid #ddd;">'.$result['paid_amt'].' '.strtoupper($result['paid_curr']).'</td> </tr> <tr> <td style="padding: 10px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; font-weight: bold;">Plan:</td> <td style="padding: 10px; border-bottom: 1px solid #ddd;">'.$result ['plan'].'</td> </tr> <tr> <td style="padding: 10px; border-right: 1px solid #ddd; font-weight: bold;">Payment Status:</td> <td style="padding: 10px;">'.ucfirst($result['status']).'</td> </tr> </tbody></table></td></tr><tr><td style="padding-bottom:40px;">If your payment fails, rest assured that your refund will be processed within 5-7 days as per RBI guidelines. We appreciate your understanding.</td></tr></tbody></table>';
}

    $mail->MsgHTML($message );
    $mail->Send();

?>