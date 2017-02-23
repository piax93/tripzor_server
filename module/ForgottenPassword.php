<?php

class ForgottenPassword implements Module {
	
	public static function run(){
		$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$user = new User();
		if($user->selectByEmail($_POST['email'])){
			$newPassword = uniqid();
			$user->setPassword(Database::encryptString($newPassword));
			if($user->update()){
				$body = 'Dear ' . $user->getName() . ',' . PHP_EOL . PHP_EOL
						. 'Your password has been reset.' . PHP_EOL
						. 'Your new password is: ' . $newPassword . '.' . PHP_EOL
						. 'We suggest you to change your password to a more familiar one as soon as possible.' . PHP_EOL . PHP_EOL
						. 'Have a nice day.' . PHP_EOL
						. 'Tripzor Team';
				$res = MailSender::sendMail($user->getEmail(), 'Tripzor Password Reset', $body);
				if(!$res) return ReturnCode::$mailError;
				return ReturnCode::$success;
			}
			return ReturnCode::$error;
		}
		return ReturnCode::$userNotFound;
	}
	
}