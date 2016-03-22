<?php

session_start();
$user = new User();
if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))){
	$trip = new Trip();
	if($trip->selectById($_POST['tripid'])){
		echo json_encode($trip->asArray());		
	}else{
		echo ReturnCode::$tripNotFound;	
	}	
}else{
	echo ReturnCode::$userNotFound;
}