<?php
$user = new User();
if($user->selectByEmail($_POST['email'])){
    $newPassword = uniqid();
    $user->setPassword(md5($newPassword));
    if($user->update()){
        $message = "Dear " . $user->getName() . ",\r\n\r\n"
                . "Your password has been reset.\r\n"
                . "Your new password is: $newPassword.\r\n"
                . "We suggest you to change your password to a more familiar one as soon as possible.\r\n\r\n"
                . "Have a nice day.\r\n"
                . "Tripzor Team";
        $i = 0;
        while(!mail($user->getEmail(), 'Tripzor Password Reset', $message, 'Content-type:text/plain; charset=UTF-8') && $i < 20){
            $i++;
        }
        if($i === 20){
            echo 'MAIL_NOT_SENT';
        }else{
            echo 'DONE';
        }
    }else{
        echo 'ERROR';
    }
}else{
    echo 'USER_NOT_FOUND';
}
