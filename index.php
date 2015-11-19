<?php
// error_reporting(E_ALL);
header('Content-Type:text/plain; charset=UTF-8');
include 'ClassLoader.php';

// POST FILTERING
foreach ($_POST as $key => $value) {
    $value = strip_tags($value);
    // $_POST[$key] = preg_replace('/\s+/', '', $value);
}

ClassLoader::loadAll();
echo Database::sessionDecrypt('Tzptm2192nSJ1uJZV7ftuWl/Fmep2L6Zs+uxi0Ck6bo=');

if(!empty($_POST)){
    if(isset($_POST['action'])){
        ModuleLoader::loadModule($_POST['action']);
    }
}else{
	//sleep(1);
    echo 'SERVER UP AND RUNNING';
}
