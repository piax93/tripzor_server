<?php
header('Content-Type:text/plain; charset=UTF-8');
include 'ClassLoader.php';
echo 'hi';
// POST FILTERING
foreach ($_POST as $key => $value) {
    $value = strip_tags($value);
    $_POST[$key] = preg_replace('/\s+/', '', $value);
}

ClassLoader::loadAll();
if(!empty($_POST)){
    if(isset($_POST['action'])){
        ModuleLoader::loadModule($_POST['action']);
    }
}
