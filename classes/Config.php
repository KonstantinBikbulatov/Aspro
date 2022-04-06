<?php

class Config
{
    private static $settings = [];

     protected function getSetting($key, $fileName){
        if(self::$settings[$fileName] == null){
            self::$settings[$fileName] = include __DIR__ .'/../configs/'.$fileName.'.php';
        }
         return self::$settings[$fileName][$key];
    }
}