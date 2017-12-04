<?php
/**
 * Created by PhpStorm.
 * User: GigaNova
 * Date: 11/8/2016
 * Time: 11:07
 */

namespace timaflu\core;

use timaflu\Core;

class Renderable
{
    private $params;
    private $viewfile;

    public function __construct($viewfile, $params)
    {
        $this->params = $params;
        $this->viewfile = $viewfile.'.php';
}

public function renderView()
{
    ob_start();
    ob_implicit_flush(false);
    extract($this->params, EXTR_OVERWRITE);

    if(!file_exists($this->viewfile)){
        throw new \Exception("View not found: ".$this->viewfile);
    }

    $header = $_SERVER['DOCUMENT_ROOT'].'/'.Core::$app->basedir.'core/headers.php';
    $body = $this->viewfile;
    require('views/layout/default.php');

    return true;
}
}