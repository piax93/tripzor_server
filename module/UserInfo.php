<?php

session_start();
$user = new User();
if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))){
	if($_POST['update'] == 'true'){
		$user->setNickname($_POST['nick']);
		$user->setCellPhone($_POST['phone']);
		$user->setName($_POST['name']);
		$user->setSurname($_POST['surname']);
		if($user->update()){
			echo ReturnCode::$success;
		}else{
			echo ReturnCode::$error;
		}
	}else{	
		echo $user->getNickname() . PHP_EOL;
		echo $user->getName() . PHP_EOL;
		echo $user->getSurname() . PHP_EOL;
		echo $user->getCellPhone();
	}
}else{
	echo ReturnCode::$userNotFound;
}
