<?php

class UserInfo implements Module {
	
	public static function run() {
		session_start();
		$user = new User();
		if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))){
			if($_POST['update'] == 'true'){
				$user->setNickname($_POST['nick']);
				$user->setCellPhone($_POST['phone']);
				$user->setName($_POST['name']);
				$user->setSurname($_POST['surname']);
				if($user->update()) return ReturnCode::$success;
				return ReturnCode::$error;
			} 
			return array($user->getNickname(), $user->getName(), $user->getSurname(), $user->getCellPhone());
		}
		return ReturnCode::$userNotFound;
	}
	
}