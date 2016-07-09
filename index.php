<?php
header('Content-Type:text/plain; charset=UTF-8');
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);

include 'ClassLoader.php';

ClassLoader::loadAll();
Logger::log('index.php', $_SERVER['HTTP_USER_AGENT']);

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
