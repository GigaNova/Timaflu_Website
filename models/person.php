<?php
/**
 * Created by PhpStorm.
 * User: GigaNova
 * Date: 11/11/2016
 * Time: 15:15
 */

namespace timaflu\models;

use timaflu\core\Model;

class Person extends Model
{

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'name',
            'weight',
            'height'
        ]);
    }
}