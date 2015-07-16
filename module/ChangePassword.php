<?php
session_start();
$user = new User();
if($user->selectByEmail($_SESSION['user'])){
    if($user->getPassword() === md5($_POST['oldPassword'])){
        if($_POST['newPassword'] != ''){
            $user->setPassword(md5($_POST['newPassword']));
            if($user->update()){
                echo 'DONE';
                exit();
            }
        }
    }
    echo 'ERROR';
}else{
    echo 'USER_NOT_FOUND';
}

