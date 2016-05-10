<?php
session_start();
$user = new User();
if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))){
	$ids = explode(',', $_POST['ids']);
	$trip = new Trip();
	$res = true;
	foreach ($ids as $id) {
		$trip->selectById($id);
		if($trip->isOwned($user->getUserId())) $res &= $trip->delete();
		else $res &= $trip->removeParticipant($user->getUserId());
		if(!$res) break;
	}
	if($res) echo ReturnCode::$success;
	else echo ReturnCode::$error;	
}else{
	echo ReturnCode::$userNotFound;
}