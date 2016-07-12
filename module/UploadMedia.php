<?php

session_start ();
$user = new User ();
if ($user->selectByEmail ( Database::sessionDecrypt ( $_SESSION ['user'] ) )) {
	$userdir = MEDIA_FOLDER . $user->getUserId ();
	if (! is_dir ( $userdir )) {
		mkdir ( $userdir );
		chmod ( $userdir, 0777 );
	}
	if (count ( $_FILES ) != 0) {
		$file_id = array_keys ( $_FILES ) [0];
		if (strncmp ( $_FILES [$file_id] ['type'], 'image', 5 ) == 0) {
			$ext = pathinfo ( $_FILES [$file_id] ['name'], PATHINFO_EXTENSION );
			$target_file = $userdir . '/' . $file_id . '.' . $ext;
			if (move_uploaded_file ( $_FILES [$file_id] ['tmp_name'], $target_file )) {
				chmod ( $target_file, 0666 );
				echo ReturnCode::$success;
				exit ( 0 );
			}
		}
	}
	echo ReturnCode::$error;
} else {
	echo ReturnCode::$userNotFound;
}
