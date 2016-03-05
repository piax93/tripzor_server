<?php
session_start();
$user = new User();
if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))){
    $trip = new Trip();
    $trip->fillByAssoc($_POST);
    $trip->setUserId($user->getUserId());
    $trip->setNPart(1);
    $res = $trip->insert();
    if($res){
    	Logger::var_dump_log('AddTrip', $trip->getName());
        echo ReturnCode::$success;
    }else{
    	Logger::log('AddTrip', 'Failed');
        echo ReturnCode::$error;
    }
}else{
    echo ReturnCode::$userNotFound;
}


