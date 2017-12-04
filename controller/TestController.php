<?php
namespace timaflu\controller;

use timaflu\core\Controller;
use timaflu\core\SQLBridge;
use timaflu\Core;
use timaflu\models\Person;

class TestController extends Controller
{
    public function actionIndex(){
        //$query = $sql->search()->from('people')->select(['name'])->where([['height', '>', 1.80]])->execute();
        $people = Person::searchFor('people', ['*'], [['height', '<', 2.00]], [['weight', 'ASC']]);

        return $this->render("index", ['people' => $people]);
    }

    public function actionForm(){

        if(Core::$app->request->post()){
            $data = Core::$app->request->post();

            $person = new Person();
            $person->load($data);

            $person->save();
        }

        return $this->render("form");
    }

    public function actionSneaky(){
        return $this->render("sneaky");
    }
}