<?php

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
    
}
