<?php

class AddTrip implements Module {

    public static function run(){
        session_start();
        $user = new User();
        if ($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))) {
            $trip = new Trip();
            $trip->fillByAssoc($_POST);
            $trip->setUserId($user->getUserId());
            $trip->setNPart(1);
            if (Util::compareDate($trip->getStartDate(), $trip->getEndDate())) {
                $res = $trip->insert();
                if ($res) {
                    Logger::log('AddTrip', $trip->getName());
                    return ReturnCode::$success;
                } else {
                    Logger::log('AddTrip', 'Failed');
                    return ReturnCode::$error;
                }
            }
            return ReturnCode::$error;
        }
        return ReturnCode::$userNotFound;
    }

}
