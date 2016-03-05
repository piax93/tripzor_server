<?php
session_start();
$user = new User();
if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))){
	Logger::log('ListTrips', $user->getEmail());
	$query = 'SELECT tripId, name FROM trip WHERE userId = ?';
	$db = Database::getDbInstance();
	$trips = $db->queryFromPreparedStatement($query, array($user->getUserId()), true);
	foreach ($trips as $trip){
		echo '*' . $trip['tripId'] . ':' . $trip['name'] . PHP_EOL;
	}
	$query  = 'SELECT t.tripId, t.name FROM participant p, trip t WHERE p.tripId = t.tripId and p.userId = ?';
	$trips = $db->queryFromPreparedStatement($query, array($user->getUserId()), true);
	foreach ($trips as $trip){
		echo $trip['tripId'] . ':' . $trip['name'] . PHP_EOL;
	}
}else{
	Logger::log('ListTrips', 'User not found');
	echo ReturnCode::$userNotFound;
}
