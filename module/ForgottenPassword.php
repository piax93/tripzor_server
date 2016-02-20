<?php

$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$user = new User();
if($user->selectByEmail($_POST['email'])){
    $newPassword = uniqid();
    $user->setPassword(Database::encryptString($newPassword));
    if($user->update()){
    	$body = "Dear " . $user->getName() . ",\r\n\r\n"
                . "Your password has been reset.\r\n"
                . "Your new password is: $newPassword.\r\n"
                . "We suggest you to change your password to a more familiar one as soon as possible.\r\n\r\n"
                . "Have a nice day.\r\n"
                . "Tripzor Team";    	
    	$res = MailSender::sendMail($user->getEmail(), 'Tripzor Password Reset', $body);  	
    	if(!$res) {
    		echo ReturnCode::$mailError;
    	} else {
    		echo ReturnCode::$success;
    	}
    	echo $mail->ErrorInfo;
    }else{
        echo ReturnCode::$error;
    }
}else{
    echo ReturnCode::$userNotFound;
}
