<?php

class GetMedia implements Module {

	public static function run(){
		session_start();
		$user = new User();
		if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))){
			if(isset($_POST['file'])){
				$pattern = MEDIA_FOLDER . $user->getUserId() . '/' . $_POST['file'] . '.*';
				$tmp = glob($pattern);
				if(count($tmp) > 0 && strncmp(realpath($tmp[0]), realpath(MEDIA_FOLDER), strlen(realpath(MEDIA_FOLDER))) === 0) {
					header('Content-Type: ' . mime_content_type($tmp[0]));
					readfile($tmp[0]);
					exit(0);
				}
			}
			return ReturnCode::$error;
		}
		return ReturnCode::$userNotFound;
	}

}
