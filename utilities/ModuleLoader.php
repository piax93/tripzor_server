<?php

class ModuleLoader extends ClassLoader {
    
    public static function  loadModule($module){
        parent::loadClass($module, 'module');
    }
    
}
