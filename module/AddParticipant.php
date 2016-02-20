<?php
session_start();
$user = new User();
$participant = new User();
if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user'])) && $participant->selectByEmail($_POST['participant'])){
    $trip = new Trip();
    if($trip->selectById($_POST['tripId'])){
        $query = 'INSERT INTO participant VALUES (' . $participant->getUserId()
                . ', ' . $trip->getTripId() . ')';
        $db = Database::getDbInstance();
        $trip->addParticipant();
        if($db->execQuery($query, false, true) && $trip->update()){
            echo ReturnCode::$success;
        }else{
            echo ReturnCode::$error;
        }
    }else{
        echo ReturnCode::$tripNotFound;
    }
    
}else{
    echo ReturnCode::$userNotFound;
}
