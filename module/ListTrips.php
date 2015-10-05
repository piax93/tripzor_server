<?php
session_start();
$user = new User();
if($user->selectByEmail($_SESSION['user'])){
	$query = 'SELECT tripId, name FROM trip WHERE userId = "' . $user->getUserId() . '"';
	$db = Database::getDbInstance();
	$trips = $db->execQuery($query);
	foreach ($trips as $trip){
		echo '*' . $trip['tripId'] . ':' . $trip['name'];
	}
	$query  = 'SELECT t.tripId, t.name FROM participant p, trip t
					WHERE p.tripId = t.tripId and p.userId = ' . $user->getUserId();
	$trips = $db->execQuery($query);
	foreach ($trips as $trip){
		echo $trip['tripId'] . ':' . $trip['name'];
	}
}else{
	ReturnCode::$userNotFound;
}
