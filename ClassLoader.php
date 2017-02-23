<?php

interface Module {
	public static function run();
}

/**
 * Class Loader
 */
class ClassLoader {
    
    private static $folders = array('utilities', 'entity');
    
    public static function loadAll(){
        foreach (self::$folders as $folder) {
            $classes = glob($folder . '/*.php');
            foreach ($classes as $class) {
                require $class;
            }
        }
    }
    
    public static function loadClass($classname, $path){
        $target = $path . '/' . $classname . '.php';
        if(file_exists($target)){
            require $target;
        }
    }
    
    public static function loadModule($module){
    	ClassLoader::loadClass($module, 'module');
    	$res = ReturnCode::$error;
    	if(class_exists($module) && in_array('Module', class_implements($module))) $res = $module::run();
    	echo json_encode($res);
    }
    
}
