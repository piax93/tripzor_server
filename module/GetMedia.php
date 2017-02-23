<?php

class GetMedia implements Module {
	
	public static function run(){
		session_start();
		$user = new User();
		if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))){
			if(isset($_POST['file'])){
				$pattern = MEDIA_FOLDER . $user->getUserId() . '/' . $_POST['file'] . '.*';
				$tmp = glob($pattern);
				if(count($tmp) > 0){
					$ext = pathinfo($tmp[0], PATHINFO_EXTENSION);
					header('Content-Type:image/' . $ext);
					readfile($tmp[0]);
					exit(0);
				}
			}
			return ReturnCode::$error;
		}
		return ReturnCode::$userNotFound;
	}
	
}