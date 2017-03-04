<?php

class UserRegistration implements Module {

    public static function run(){
        $user = new User();
        $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $res = $user->selectByEmail($_POST['email']);
        if($res !== false) {
            return ReturnCode::$userPresent;
        } else {
            $_POST['password'] = Database::encryptString($_POST['password']);
            $user->fillByAssoc($_POST);
            $res = $user->insert();
            if($res !== false){
                $body = 'Dear ' . $user->getName() . ',' . PHP_EOL . PHP_EOL .
                    'Thanks for registering to our service, we wish you a happy user experience.';
                MailSender::sendMail($_POST['email'], 'Welcome to Trizor', $body);
                return ReturnCode::$success;
            }
            return ReturnCode::$error;
        }
    }

}
