<?php
/**
 * Created by PhpStorm.
 * User: GigaNova
 * Date: 11/10/2016
 * Time: 9:30
 */

namespace timaflu\core;

use timaflu\renderer\DefaultRenderer;

abstract class Model
{
    protected $sqlbridge;
    protected $db;
    public $classname;
    public $new;

    public function __construct($_db = null)
    {
        $this->sqlbridge = new SQLBridge($_db);

        if(!empty($_db)){
            $this->db = $_db;
        }

        foreach($this->attributes() as $attribute){
            $this->addAttribute($attribute);
        }

        $reflect = new \ReflectionClass($this);
        $this->classname = $reflect->getShortName();

        $this->new = true;
    }

    public function getDB(){
        return $this->db;
    }

    public function addAttribute($_attribute){
        $this->$_attribute = null;
    }

    public static function all($_db){
        $rawResults = (new SQLBridge())->search()->from($_db)->select()->execute();
        $objects = [];
        foreach($rawResults as $result){
            $object = self::createObject($result);
            $object->new = false;
            array_push($objects, $object);
        }
        return $objects;
    }

    public static function searchFor($_db, $_fields = [], $_conditions = [], $_order = []){
        $rawResults = (new SQLBridge())->search()->from($_db)->select($_fields)->where($_conditions)->orderBy($_order)->execute();
        $objects = [];
        foreach($rawResults as $result){
            $object = self::createObject($result);
            $object->new = false;
            array_push($objects, $object);
        }
        return $objects;
    }

    public function save(){
        $array = [];
        foreach($this->attributes() as $attribute){
            $array[$attribute] = $this->$attribute;
        }

        if($this->new){
            return $this->sqlbridge->create($array);
        }
        return $this->sqlbridge->insert($array);
    }

    public function load($_data){
        if(array_key_exists($this->classname, $_data)) {
            foreach($_data[$this->classname] as $key => $value){
                try{
                    $this->$key = $value;
                }catch(\Exception $e){
                    continue;
                }
            }
        }
    }

    public function delete(){
        $array = [];
        foreach($this->attributes() as $attribute){
            $array[$attribute] = $this->$attribute;
        }

        return $this->sqlbridge->delete($array);
    }

    public function getSQLErrors(){
        return $this->sqlbridge->error;
    }

    private static function createObject($_array){
        $className = get_called_class();
        $object = new $className();
        foreach($_array as $key=>$value){
            $key = strtolower($key);
            $object->$key = $value;
        }
        return $object;
    }

    public function toHTMLForm(DefaultRenderer $_renderer = null, $_exclusion = []){
        $className = get_called_class();
        if(is_null($_renderer)){
            $_renderer = new DefaultRenderer();
        }
        return $_renderer->render($className, $this->attributes(), $_exclusion);
    }

    public function attributes(){
        return [

        ];
    }

    public function attributeNames(){
        return [

        ];
    }

    public function attributeType(){
        return [

        ];
    }

    public function foreignKeys(){
        return [];
    }

    public function getAttributeName($_attribute){
        $attributeNames = $this->attributeNames();
        if(array_key_exists($_attribute, $attributeNames)){
            return $attributeNames[$_attribute];
        }
        return $_attribute;
    }

    public function getAttributeType($_attribute){
        $attributeTypes = $this->attributeType();
        if(array_key_exists($_attribute, $attributeTypes)){
            $attributeType = $attributeTypes[$_attribute];
        }
        else{
            return "text";
        }

        switch($attributeType){
            case "int":
                return "number";
            default:
                return "text";
        }
    }
}