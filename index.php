<?php
header('Content-Type: application/json; charset=UTF-8');
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);

define('MEDIA_FOLDER', 'media/');

include 'ClassLoader.php';

ClassLoader::loadAll();

// POST FILTERING
foreach ($_POST as $key => $value) {
	$value = strip_tags($value);
	// more to come
	$_POST[$key] = $value;
}

if(!empty($_POST)){
    if(isset($_POST['action'])){
        ClassLoader::loadModule($_POST['action']);
    }
}else{
	sleep(1);
	echo json_encode(array('result' => 'SERVER UP AND RUNNING'));
}