<?php
session_start();
$user = new User();
$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
if($user->selectByEmail($_POST['email'])){
    if($user->login($_POST['password'])){
    	Logger::log("UserLogin", $user->getEmail());
    	$_SESSION['user'] = Database::sessionEncrypt($user->getEmail());    	
    	echo ReturnCode::$success;       
    }else{
    	Logger::log("UserLogin", 'Fail');
        echo ReturnCode::$error;
        session_destroy();
    }
}else{
	Logger::log("UserLogin", 'Fail');
    echo ReturnCode::$userNotFound;
    session_destroy();
}