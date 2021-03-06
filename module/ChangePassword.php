<?php

class ChangePassword implements Module {

    public static function run(){
        session_start();
        $user = new User();
        if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))){
            if($user->login($_POST['oldPassword'])){
                if($_POST['newPassword'] != ''){
                    $user->setPassword(Database::hashString($_POST['newPassword']));
                    if($user->update()) return ReturnCode::$success;
                }
            }
            return ReturnCode::$error;
        }
        return ReturnCode::$userNotFound;
    }

}
