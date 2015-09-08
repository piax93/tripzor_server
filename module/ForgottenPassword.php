<?php
$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$user = new User();
if($user->selectByEmail($_POST['email'])){
    $newPassword = uniqid();
    $user->setPassword(md5($newPassword));
    if($user->update()){
    	include '/utilities/values/mailCredentials.php';
    	include 'pear/Mail.php';
        $message = "Dear " . $user->getName() . ",\r\n\r\n"
                . "Your password has been reset.\r\n"
                . "Your new password is: $newPassword.\r\n"
                . "We suggest you to change your password to a more familiar one as soon as possible.\r\n\r\n"
                . "Have a nice day.\r\n"
                . "Tripzor Team";
        $subject = 'Tripzor Password Reset';
        
        $headers['From'] = $mail_user;
        $headers['To'] = $user->getEmail();
        $headers['Subject'] = $subject;
        $headers['Content-type'] = 'text/plain; charset=UTF-8';
        $smtp['host'] = $mail_server;
        $smtp['port'] = $mail_port;
        $smtp['auth'] = true;
        $smtp['username'] = $mail_user;
        $smtp['password'] = $mail_passowrd;
        $mailObj = Mail::factory('smtp', $smtp);
        $mailRes = $mailObj->send($user->getEmail(), $headers, $message);
        
        /*$i = 0;
        while(!mail($user->getEmail(), $subject, $message, $header) && $i < 20){
            $i++;
        }*/
        if(PEAR::isError($mailRes)){
            echo ReturnCode::$mailError;
            echo $mailRes->getMessage();
        }else{
            echo ReturnCode::$success;
        }
    }else{
        echo ReturnCode::$error;
    }
}else{
    echo ReturnCode::$userNotFound;
}
