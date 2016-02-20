<?php

class ModuleLoader extends ClassLoader {
    
	/**
	 * Loads and executes selected module
	 * @param string $module Module name 
	 */
    public static function  loadModule($module){
        parent::loadClass($module, 'module');
    }
    
}
