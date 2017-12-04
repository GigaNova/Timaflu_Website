<?php
/**
 * Created by PhpStorm.
 * User: GigaNova
 * Date: 11/8/2016
 * Time: 10:09
 */

namespace timaflu\core;

use timaflu\Core;
use timaflu\controller;

class Application
{
    public $request;

    private $defaultAction = "Index";
    private $defaultController = "Default";

    public $basedir;

    public function __construct($_config)
    {
        $this->basedir = $_config['basename'].'/';
        Core::setApp($this, $_config);
    }

    public function start(){
        $this->request = new Request();

        $controllerName = $this->defaultController;
        $actionName = $this->defaultAction;

        $sanitize = str_replace($this->basedir, "", $this->request->getRequestUrl());
        $spliturl = self::removeEmptyFromArray(explode("/", $sanitize));
        if(sizeof($spliturl) >= 1){
            $controllerName = ucfirst($spliturl[0]);

            if(sizeof($spliturl) >= 2){
                $actionName = ucfirst($spliturl[1]);
            }
        }
        $controllerClass = '\\timaflu\\controller\\'.$controllerName."Controller";
        $controller = new $controllerClass();

        $actionFunction = "action".$actionName;

        $controller->$actionFunction();
    }

    public function removeEmptyFromArray($array){
        return array_values(array_filter($array, function($value) { return $value !== ''; }));
    }
}