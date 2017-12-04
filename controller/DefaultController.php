<?php
namespace timaflu\controller;

use timaflu\core\Controller;
use timaflu\core\SQLBridge;
use timaflu\Core;
use timaflu\models\Person;

class DefaultController extends Controller
{
    public function actionIndex(){
        return $this->render("index");
    }
}