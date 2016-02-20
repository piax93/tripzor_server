<?php
header('Content-Type:text/plain; charset=UTF-8');
include 'ClassLoader.php';

// POST FILTERING
foreach ($_POST as $key => $value) {
    $value = strip_tags($value);
    // $value = preg_replace('/\s+/', '', $value);
    $_POST[$key] = $value;
}

ClassLoader::loadAll();

if(!empty($_POST)){
    if(isset($_POST['action'])){
        ModuleLoader::loadModule($_POST['action']);
    }
}else{
	sleep(1);
	echo 'SERVER UP AND RUNNING';
}
