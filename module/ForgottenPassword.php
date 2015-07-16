<?php
$user = new User();
if($user->selectByEmail($_POST['email'])){
    $newPassword = uniqid();
    
}else{
    echo 'USER_NOT_FOUND';
}
