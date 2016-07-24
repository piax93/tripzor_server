<?php

session_start();
$user = new User();
if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))){
	
	$query = 'SELECT userId, nickname, name, surname, email FROM user
				WHERE (userId NOT IN ( SELECT userId FROM participant WHERE tripId = ? ) 
						AND userId != ?) 
						AND (nickname LIKE ? OR name LIKE ? OR surname LIKE ?);';
	
	$key = '%' . $_POST['key'] . '%';
	// Logger::var_dump_log('SearchUser', $_POST);
	
	echo json_encode(Database::getDbInstance()->queryFromPreparedStatement($query, 
			array($_POST['tripId'], $user->getUserId(), $key, $key, $key), true));
	
}else{
	echo ReturnCode::$userNotFound;
}
