<?php 
    $dir = __DIR__;
    $parentdir = dirname($dir);

    include($parentdir . "/class.phpmailer.php");
    $mail = new PHPMailer();
    $mail->isSMTP();                          // Set mailer to use SMTP
        $mail->Host = 'smtp.hostinger.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                       // Enable SMTP authentication
        $mail->Username = 'noreply@wonderkids.club';                 // SMTP username
        $mail->Password = 'Dipanjan@1@#';                           // SMTP password
        $mail->SMTPSecure = 'tls';    // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; 
?>