<?php

class Config
{
    private static $settings = [];

     public static function getSetting($fileName, $key){
        if(self::$settings[$fileName] == null){
            self::$settings[$fileName] = include __DIR__ .'/../configs/'.$fileName.'.php';
        }
         return self::$settings[$fileName][$key];
    }
}