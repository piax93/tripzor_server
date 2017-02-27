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
                                   if(file_exists($target) && strncmp(realpath($target), getcwd(), strlen(getcwd())) === 0){
                                   require $target;
                                   }
                                   }

                                   public static function loadModule($module){
                                   ClassLoader::loadClass($module, 'module');
                                   $res = array('result' => ReturnCode::$error);
                                   if(class_exists($module) && in_array('Module', class_implements($module))) {
                                   try {
                                   $tmp = $module::run();
                                   if(is_string($tmp)) $res['result'] = $tmp;
                                   else {
                                   $res['result'] = ReturnCode::$success;
                                   $res['data'] = $tmp;
                                   }
                                   } catch (Exception $e) { }
                                   }
                                   echo json_encode($res);
                                   }

                                   }
