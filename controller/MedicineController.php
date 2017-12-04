<?php
namespace timaflu\controller;

use timaflu\core\Controller;
use timaflu\core\SQLBridge;
use timaflu\Core;
use timaflu\models\Medicine;

class MedicineController extends Controller
{
    public function actionIndex(){
        $medicine = Medicine::all('medicine');

        return $this->render("index", ['medicine' => $medicine]);
    }

    public function actionForm(){
        $medicine = new Medicine();

        if(Core::$app->request->post()){
            $data = Core::$app->request->post();

            $medicine->load($data);

            $medicine->save();
        }

        return $this->render("form", ['medicine' => $medicine]);
    }

    public function actionSneaky(){
        return $this->render("sneaky");
    }
}