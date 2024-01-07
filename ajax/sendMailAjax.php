<?php 
    include("../config/config.php");

    include("../config/mail_config.php");

    if(isset($_POST["email_type"])) {

        if($_POST["email_type"] == "verification") {

            $sql = mysqli_query($conn, "SELECT email, confirmation_code FROM users WHERE email = '". $_POST['email'] . "'");
            $res = mysqli_fetch_assoc($sql);

            var_dump($res);

            $mail->AddAddress($res['email']);
            $mail->From = "noreply@wonderkids.club";
            $mail->FromName = "Wonderkids";
            $mail->Subject   = "Account Registration Confirmation";

            $message = '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, Helvetica, sans-serif; text-align: center; background-color: #fafafa; font-size: 15px; color: #000; "> <tbody> <tr> <td> <table width="500" cellpadding="0" cellspacing="0" border="0" align="center" style="text-align: center;"> <tbody> <tr> <td style="padding-top: 40px; padding-bottom: 30px;"><img src="https://wonderkids.club/assets/images/wonderkids.png"></td> </tr> <tr> <td style="padding-bottom: 10px; font-size: 24px; font-weight: bold;">Account Registration Confirmation</td> </tr> <tr> <td style="padding-top: 20px; padding-bottom: 30px;">Thank you for creating a new account to access Wonderkids. To use the full range of Wonderkids services you will need to verify the email address on your account.</td> </tr> <tr> <td style="padding-top: 30px; padding-bottom: 60px;"><a href="'.$baseurl.'?confirmation='.$res['confirmation_code'].'" style="background-color: #ffdfea; padding: 12px 25px; border-radius: 10px; font-size: 24px; color: #012d5d; text-decoration: none;">Verify Now</a></td> </tr> </tbody> </table> </td> </tr> </tbody> </table>';

        }

        $mail->MsgHTML($message );
        $mail->Send();

    }
?>