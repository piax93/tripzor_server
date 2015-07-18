<?php
session_start();
$user = new User();
$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
if($user->selectByEmail($_POST['email'])){
    if($user->login($_POST['password'])){
        echo ReturnCode::$success;
        $_SESSION['user'] = $user->getEmail();
    }else{
        echo ReturnCode::$error;
        session_destroy();
    }
}else{
    echo ReturnCode::$userNotFound;
    session_destroy();
}