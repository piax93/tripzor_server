<?php
header('Content-Type:text/plain; charset=UTF-8');
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);

define('MEDIA_FOLDER', 'media/');

include 'ClassLoader.php';

ClassLoader::loadAll();

// POST FILTERING
foreach ($_POST as $key => $value) {
	$value = strip_tags($value);
	$_POST[$key] = $value;
}

if(!empty($_POST)){
    if(isset($_POST['action'])){
        ModuleLoader::loadModule($_POST['action']);
    }
}else{
	sleep(1);
	echo 'SERVER UP AND RUNNING';
}
