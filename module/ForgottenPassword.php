<?php
$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$user = new User();
if($user->selectByEmail($_POST['email'])){
    $newPassword = uniqid();
    $user->setPassword(md5($newPassword));
    if($user->update()){
    	include '../utilities/values/mailCredentials.php';
        $message = "Dear " . $user->getName() . ",\r\n\r\n"
                . "Your password has been reset.\r\n"
                . "Your new password is: $newPassword.\r\n"
                . "We suggest you to change your password to a more familiar one as soon as possible.\r\n\r\n"
                . "Have a nice day.\r\n"
                . "Tripzor Team";
        $subject = 'Tripzor Password Reset';
        $header = 'Content-type:text/plain; charset=UTF-8';
        
        $i = 0;
        while(!mail($user->getEmail(), $subject, $message, $header) && $i < 20){
            $i++;
        }
        if($i === 20){
            echo ReturnCode::$mailError;
        }else{
            echo ReturnCode::$success;
        }
    }else{
        echo ReturnCode::$error;
    }
}else{
    echo ReturnCode::$userNotFound;
}
