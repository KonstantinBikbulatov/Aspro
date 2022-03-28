<?php

class Config
{
    private static $settings = [];

     static function getSetting($key, $fileName){
        if(!self::$settings[$key]){
            include __DIR__ . '/../configs/' .$fileName .'.php';

            return constant($key);
        }
        else{
            return self::$settings[$key];
        }
    }
}