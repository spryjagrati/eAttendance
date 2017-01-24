<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;

/**
 * Description of Datalogger
 *
 * @author maverick
 */
class DataLogger{
    
    public static function Login($type, $data){
        $logger = new FileAdapter(APP_PATH . "/app/logs/login.log");
        $logger->$type($data);
    }

    public static function user($type, $data){
        $logger = new FileAdapter(APP_PATH . "/app/logs/user.log");
        $logger->$type($data);
    }

     public static function document($type, $data){
        $logger = new FileAdapter(APP_PATH . "/app/logs/document.log");
        $logger->$type($data);
    }

     public static function education($type, $data){
        $logger = new FileAdapter(APP_PATH . "/app/logs/education.log");
        $logger->$type($data);
    }

     public static function experience($type, $data){
        $logger = new FileAdapter(APP_PATH . "/app/logs/experience.log");
        $logger->$type($data);
    }

    public static function attendance($type, $data){
        $logger = new FileAdapter(APP_PATH . "/app/logs/attendance.log");
        $logger->$type($data);
    }
    
    public static function application($type, $data){
        $logger = new FileAdapter(APP_PATH . "/app/logs/application.log");
        $logger->$type($data);
    }

     public static function profile($type, $data){
        $logger = new FileAdapter(APP_PATH . "/app/logs/profile.log");
        $logger->$type($data);
    }
    
     public static function usermeta($type, $data){
        $logger = new FileAdapter(APP_PATH . "/app/logs/usermeta.log");
        $logger->$type($data);
    }
}