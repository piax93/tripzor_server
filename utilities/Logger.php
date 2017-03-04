<?php

class Logger {

    private static $logFile = 'log.log';
    private static $enabled = true;

    public static function log($module, $message){
        if(!self::$enabled) return;
        $time = date(DATE_RSS, time());
        $line = $module . '(' . $time . '): ' . $message . PHP_EOL;
        file_put_contents(self::$logFile, $line, FILE_APPEND);
    }

    public static function var_dump_log($module, $var){
        if(!self::$enabled) return;
        ob_start();
        var_dump($var);
        $message = ob_get_contents();
        ob_end_clean();
        self::log($module, str_replace(PHP_EOL, ' ', $message));
    }

}
