<?php
session_start();
$user = new User();
if($user->selectByEmail($_SESSION['user'])){
	$query = 'SELECT name FROM trip WHERE userId = "' . $user->getUserId() . '"';
	$db = Database::getDbInstance();
	$trips = $db->execQuery($query);
	for($i = 0; $i < count($trips); $i++){
		echo $trips[$i];
		if($i != count($trips)-1) echo PHP_EOL;
	}
}else{
	ReturnCode::$userNotFound;
}
