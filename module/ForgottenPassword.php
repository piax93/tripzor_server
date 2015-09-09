<?php
require_once 'vendor/autoload.php';

$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$user = new User();
if($user->selectByEmail($_POST['email'])){
    $newPassword = uniqid();
    $user->setPassword(md5($newPassword));
    if($user->update()){
    	include '/utilities/values/mailCredentials.php';
    	$mail = new PHPMailer();    	
    	$body = "Dear " . $user->getName() . ",\r\n\r\n"
                . "Your password has been reset.\r\n"
                . "Your new password is: $newPassword.\r\n"
                . "We suggest you to change your password to a more familiar one as soon as possible.\r\n\r\n"
                . "Have a nice day.\r\n"
                . "Tripzor Team";
    	
    	$mail->IsSMTP();
    	$mail->ContentType = 'text/plain';
    	$mail->IsHTML(false);
    	$mail->SMTPDebug  = 0; // 1 = errors and messages 2 = messages only
    	$mail->SMTPAuth   = true;                  
    	$mail->SMTPSecure = "tls";                 
    	$mail->Host       = $mail_server;      
    	$mail->Port       = $mail_port;                   
    	$mail->Username   = $mail_user;
    	$mail->Password   = $mail_password;
    	$mail->Body = $body;
    	$mail->SetFrom($mail_user, 'Tripzor');    	
    	$mail->Subject    = 'Tripzor Password Reset';
    	$mail->AddAddress($user->getEmail(), $user->getNickname());
    	
    	if(!$mail->Send()) {
    		echo ReturnCode::$mailError;
    	} else {
    		echo ReturnCode::$success;
    	}
    	
    }else{
        echo ReturnCode::$error;
    }
}else{
    echo ReturnCode::$userNotFound;
}
