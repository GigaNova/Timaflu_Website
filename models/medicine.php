<?php
/**
 * Created by PhpStorm.
 * User: GigaNova
 * Date: 11/11/2016
 * Time: 15:15
 */

namespace timaflu\models;

use timaflu\core\Model;

class Medicine extends Model
{
    public function __construct()
    {
        parent::__construct("medicine");
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'ordercode',
            'minimalorderamount',
            'name',
            'price',
            'packagetype',
            'shortdescription',
            'longdescription'
        ]);
    }

    public function attributeNames()
    {
        return array_merge(parent::attributes(), [
            'ordercode' => 'Order Code',
            'minimalorderamount' => 'Minimale order aantal',
            'name' => 'Naam',
            'price' => 'Prijs',
            'packagetype' => 'Verpakkingstype',
            'shortdescription' => 'Korte beschrijving',
            'longdescription' => 'Lange beschrijving'
        ]);
    }

    public function attributeType()
    {
        return array_merge(parent::attributeType(), [
            'ordercode' => 'int',
            'minimalorderamount' => 'int',
            'price' => 'int'
        ]);
    }

    public function foreignKeys(){
        return [
            'packagetype' => ['Packagetype', 'Type']
        ];
    }

}