<?php
$user = new User();
$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$res = $user->selectByEmail($_POST['email']);
if($res !== false){
    echo ReturnCode::$userPresent;
}else{
    $_POST['password'] = Database::encryptString($_POST['password']);
    $user->fillByAssoc($_POST);
    $res = $user->insert();
    if($res !== false){
        echo ReturnCode::$success;
    }else{
        echo ReturnCode::$error;
    }
}
