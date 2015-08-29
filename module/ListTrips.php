<?php
session_start();
$user = new User();
if($user->selectByEmail($_SESSION['user'])){
	$query = 'SELECT name FROM trip WHERE userId = "' . $user->getUserId() . '"';
	$db = Database::getDbInstance();
	$trips = $db->execQuery($query);
	for($i = 0; $i < count($trips); $i++){
<<<<<<< HEAD
		echo $trips[$i]['name'];
=======
		echo $trips[$i];
>>>>>>> 7658ff617d2add70b768ca9aa3a281ad72415dcc
		if($i != count($trips)-1) echo PHP_EOL;
	}
}else{
	ReturnCode::$userNotFound;
}
