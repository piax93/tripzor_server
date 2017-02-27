<?php

class GetProfilePicture implements Module {

	public static function run(){
		if(isset($_POST['userId']) && is_numeric($_POST['userId'])){
			$pattern = MEDIA_FOLDER . $_POST['userId'] . '/profile.*';
			$tmp = glob($pattern);
			if(count($tmp) > 0){
				header('Content-Type: ' . mime_content_type($tmp[0]));
				readfile($tmp[0]);
				exit(0);
			}
		}
		return ReturnCode::$error;
	}

}
