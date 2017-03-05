<?php

class ListTrips implements Module {

    public static function run(){
        session_start();
        $user = new User();
        if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))){
            Logger::log('ListTrips', $user->getEmail());
            $query = 'SELECT tripId, name FROM trip WHERE userId = ?';
            $db = Database::getDbInstance();
            $mytrips = $db->queryFromPreparedStatement($query, array($user->getUserId()), true);
            $query  = 'SELECT t.tripId, t.name FROM participant p, trip t WHERE p.tripId = t.tripId and p.userId = ?';
            $parttrips = $db->queryFromPreparedStatement($query, array($user->getUserId()), true);
            if(!$mytrips) $mytrips = array();
            if(!$parttrips) $parttrips = array();
            return array($mytrips, $parttrips);
        }
        Logger::log('ListTrips', 'User not found');
        return ReturnCode::$userNotFound;
    }

}
