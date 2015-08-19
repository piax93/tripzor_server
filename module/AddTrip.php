<?php
session_start();
$user = new User();
if($user->selectByEmail($_SESSION['user'])){
    $trip = new Trip();
    $trip->fillByAssoc($_POST);
    $trip->setUserId($user->getUserId());
    $trip->setNPart(1);
    $res = $trip->insert();
    if($res){
        echo ReturnCode::$success;
    }else{
        echo ReturnCode::$error;
    }
}else{
    echo ReturnCode::$userNotFound;
}


