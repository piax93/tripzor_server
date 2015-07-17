<?php
session_start();
$user = new User();
$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
if($user->selectByEmail($_POST['email'])){
    if($user->login($_POST['password'])){
        echo 'DONE';
        $_SESSION['user'] = $user->getEmail();
    }else{
        echo 'ERROR';
        session_destroy();
    }
}else{
    echo 'USER_NOT_FOUND';
    session_destroy();
}