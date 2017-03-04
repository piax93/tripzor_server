<?php

class UserLogin implements Module {

    public static function run() {
        session_start();
        $user = new User();
        $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if($user->selectByEmail($_POST['email'])){
            if($user->login($_POST['password'])){
                Logger::log("UserLogin", $user->getEmail());
                $_SESSION['user'] = Database::sessionEncrypt($user->getEmail());
                return ReturnCode::$success;
            }else{
                Logger::log("UserLogin", 'Fail');
                session_destroy();
                return ReturnCode::$error;
            }
        } else {
            Logger::log("UserLogin", 'Fail');
            session_destroy();
            return ReturnCode::$userNotFound;
        }
    }

}
