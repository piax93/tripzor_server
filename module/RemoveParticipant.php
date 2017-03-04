<?php

class RemoveParticipant implements Module {

    public static function run(){
        session_start();
        $user = new User();
        $participant = new User();
        if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user'])) && $participant->selectByEmail($_POST['participant'])){
            $trip = new Trip();
            if($trip->selectById($_POST['tripId'])){
                if($trip->removeParticipant($participant->getUserId())) return ReturnCode::$success;
                return ReturnCode::$error;
            }
            return ReturnCode::$tripNotFound;
        }
        return ReturnCode::$userNotFound;
    }

}
