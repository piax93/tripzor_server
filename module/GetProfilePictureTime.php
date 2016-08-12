<?php

session_start();
$user = new User();
if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))){
	if(isset($_POST['userId'])){
		$pattern = MEDIA_FOLDER . $_POST['userId'] . '/' . 'profile.*';
		$tmp = glob($pattern);
		if(count($tmp) > 0){
			echo filemtime($tmp[0]);
			exit();
		}
	}
	echo ReturnCode::$error;
}else{
	echo ReturnCode::$userNotFound;
}
