<?php
/**
 * Created by PhpStorm.
 * User: GigaNova
 * Date: 11/8/2016
 * Time: 11:26
 */

namespace timaflu\core;

use timaflu\Core;

class Controller
{
    private $controllerpath;
    private $controllername;

    public function __construct()
    {
        $reflect = new \ReflectionClass($this);
        $this->controllername = strtolower(str_replace("Controller", "", $reflect->getShortName()));
        $this->controllerpath = $_SERVER['DOCUMENT_ROOT'].'/'.Core::$app->basedir.'views/'.$this->controllername.'/';
    }

    public function render($viewfile, $params = [])
    {
        $renderer = new Renderable($this->controllerpath.$viewfile, $params);
        return $renderer->renderView();
    }
}