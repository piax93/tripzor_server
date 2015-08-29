<?php
session_start();
$user = new User();
if($user->selectByEmail($_SESSION['user'])){
	$query = 'SELECT name FROM trip WHERE userId = "' . $user->getUserId() . '"';
	$db = Database::getDbInstance();
	$trips = $db->execQuery($query);
	print_r($trips);
}else{
	ReturnCode::$userNotFound;
}
