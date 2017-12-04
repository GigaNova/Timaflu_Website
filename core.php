<?php
/**
 * Created by PhpStorm.
 * User: GigaNova
 * Date: 11/8/2016
 * Time: 13:22
 */

namespace timaflu;

class Core
{
    public static $app;
    public static $config;

    public static function setApp($_app, $_config){
        if(empty(self::$app)){
            self::$app = $_app;
            self::$config = $_config;
        }
    }
}