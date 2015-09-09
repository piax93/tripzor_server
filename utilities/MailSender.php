<?php

class MailSender {
	
	public static function sendMail($dest, $title, $body){
		require_once 'vendor/autoload.php';
		include 'values/mailCredentials.php';
		
		$sendgrid = new SendGrid($mail_user, $mail_password);
		$email    = new SendGrid\Email();
		
		$email->addTo($dest)
		->setFrom('tripzor.noreply@tripzor.org')
		->setSubject($title)
		->setText($body);
		
		$response = $sendgrid->send($email);
		return ($response->getCode() == 200);
	}

}
