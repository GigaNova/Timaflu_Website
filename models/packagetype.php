<?php
/**
 * Created by PhpStorm.
 * User: GigaNova
 * Date: 11/11/2016
 * Time: 15:15
 */

namespace timaflu\models;

use timaflu\core\Model;

class Packagetype extends Model
{
    public function __construct()
    {
        parent::__construct("packagetype");
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'packagetype'
        ]);
    }

    public function attributeNames()
    {
        return array_merge(parent::attributes(), [
            'packagetype' => 'Verpakkingstype'
        ]);
    }
}