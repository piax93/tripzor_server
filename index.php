<?php
    header('Content-Type:text/plain; charset=UTF-8');
    include 'ClassLoader.php';

    ClassLoader::loadAll();
    if(!empty($_POST)){
        if(isset($_POST['action'])){
            ModuleLoader::loadModule($_POST['action']);
        }
    }
