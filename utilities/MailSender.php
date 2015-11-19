<?php

class MailSender {
	
	/**
	 * Simple function to send and e-mail
	 * @param string $dest Mail destination
	 * @param string $title Mail title
	 * @param string $body Mail body
 	 */
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
