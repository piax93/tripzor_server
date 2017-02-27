<?php

class TripDetail implements Module {

	public static function run() {
		session_start();
		$user = new User();
		if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))){
			$trip = new Trip();
			if($trip->selectById($_POST['tripid'])) return $trip->asArray();
			return ReturnCode::$tripNotFound;
		}
		return ReturnCode::$userNotFound;
	}

}
