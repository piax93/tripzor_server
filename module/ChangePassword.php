<?php
session_start();
$user = new User();
if($user->selectByEmail($_SESSION['user'])){
    if($user->getPassword() === md5($_POST['oldPassword'])){
        if($_POST['newPassword'] != ''){
            $user->setPassword(md5($_POST['newPassword']));
            if($user->update()){
                echo ReturnCode::$success;
                exit();
            }
        }
    }
    echo ReturnCode::$error;
}else{
    echo ReturnCode::$userNotFound;
}

