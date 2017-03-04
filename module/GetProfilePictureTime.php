<?php

class GetProfilePictureTime implements Module {

    public static function run(){
        session_start();
        $user = new User();
        if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))){
            if(isset($_POST['userId']) && is_numeric($_POST['userId'])){
                $pattern = MEDIA_FOLDER . $_POST['userId'] . '/profile.*';
                $tmp = glob($pattern);
                if(count($tmp) > 0) return filemtime($tmp[0]);
            }
            return ReturnCode::$error;
        }
        return ReturnCode::$userNotFound;
    }

}
