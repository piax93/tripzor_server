<?php
$user = new User();
if($user->selectByEmail($_POST['email'])){
    if($user->login($_POST['password'])){
        echo 'DONE';
    }else{
        echo 'ERROR';
    }
}else{
    echo 'USER_NOT_REGISTERED';
}

