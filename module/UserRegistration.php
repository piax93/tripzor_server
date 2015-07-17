<?php
$user = new User();
$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$res = $user->selectByEmail($_POST['email']);
if($res !== false){
    echo 'USER_ALREADY_PRESENT';
}else{
    $_POST['password'] = md5($_POST['password']);
    $user->fillByAssoc($_POST);
    $res = $user->insert();
    if($res !== false){
        echo 'ERROR';
    }else{
        echo 'DONE';
    }
}