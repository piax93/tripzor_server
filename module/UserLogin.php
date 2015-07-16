<?php
session_start();
$user = new User();
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