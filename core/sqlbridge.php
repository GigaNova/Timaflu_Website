<?php
/**
 * Created by PhpStorm.
 * User: GigaNova
 * Date: 11/11/2016
 * Time: 9:10
 */

namespace timaflu\core;

use timaflu\Core;

class SQLBridge
{

    private $dbstring;
    private $db;
    private $pdo;
    private $query;
    private $cansearch;
    public $error;
    public $haserror;

    public function __construct($db = null)
    {
        $dbstring = Core::$config['db'];
        $this->dbstring = $dbstring;
        $this->db = (empty($db)) ? Core::$config['defaultdb'] : $db;
        $this->pdo = new \PDO($this->dbstring, "root");
        $this->cansearch = false;
        $this->haserror = false;
    }

    public function search(){
        $this->query = "";
        $this->cansearch = true;
        $this->haserror = false;
        return $this;
    }

    public function raw($_sql){
        $this->query = $_sql;
        return $this;
    }

    public function from($_db){
        $this->query = " FROM ".$_db." ".$this->query;
        return $this;
    }

    public function select($_array = []){
        if(empty($_array)){
            $this->query = "SELECT *".$this->query;
            return $this;
        }
        $this->query = "SELECT ".implode(", ", $_array).$this->query;
        return $this;
    }

    public function where($_array){
        if(empty($_array)) return $this;
        $amount = 0;
        $string = "WHERE";
        foreach($_array as $sub){
            if($amount > 0){
                $string .= " AND";
            }
            $value = is_string($sub[2]) ? "'".$sub[2]."'" : $sub[2];
            $string .= " ".$sub[0]." ".$sub[1]." ".$value;
            ++$amount;
        }
        $this->query .= " ".$string;
        return $this;
    }

    public function showquery(){
        return $this->query;
    }

    public function insert($_attributes){
        $query = '';
        $where = 'WHERE incr = '.$_attributes['incr'];
        $set = ' SET ';

        $i = 0;
        foreach($_attributes as $key=>$value){

            if(!is_numeric($value)){
                $value = "'".$value."'";
            }

            if(sizeof($_attributes) !== $i + 1){
                $set .= $key.' = '.$value.', ';
            }else{
                $set .= $key.' = '.$value;
            }

            ++$i;
        }

        $set .= ' ';
        $query .= "UPDATE ".$this->db." ".$set.$where;

        $prep = $this->pdo->prepare($query);
        $prep->execute();
        $this->error = $prep->errorInfo();

        if(!empty($this->error)){
            $this->haserror = true;
            return $this->error;
        }

        return true;
    }

    public function create($_attributes){
        $query = '';
        $fields = '(';
        $values = ' VALUES (';

        unset($_attributes['incr']);

        $i = 0;
        foreach($_attributes as $key=>$value){

            if(!is_numeric($value)){
                $value = "'".$value."'";
            }

            if(sizeof($_attributes) !== $i + 1){
                $fields .= $key.',';
                $values .= $value.',';
            }else{
                $fields .= $key;
                $values .= $value;
            }

            ++$i;
        }
        $values .= ')';
        $query .= "INSERT INTO ".$this->db." ".$fields.')'.$values;

        $prep = $this->pdo->prepare($query);
        $prep->execute();
        $this->error = $prep->errorInfo();

        if(!empty($this->error)){
            $this->haserror = true;
            return false;
        }

        return true;
    }

    public function delete($_attributes){
        $delete = 'DELETE FROM '.$this->db.' WHERE ';
        $i = 0;
        foreach($_attributes as $key=>$value){

            if(!is_numeric($value)){
                $value = "'".$value."'";
            }

            if(sizeof($_attributes) !== $i + 1){
                $delete .= $key.' = '.$value.' AND ';
            }else{
                $delete .= $key;
            }

            ++$i;
        }
        $prep = $this->pdo->prepare($delete);
        $prep->execute();
        $this->error = $prep->errorInfo();

        if(!empty($this->error)){
            $this->haserror = true;
            return false;
        }

        return true;
    }

    public function orderBy($_conditions){
        if(empty($_conditions)){
            return $this;
        }

        $order = ' ORDER BY ';
		$i = 0;
        foreach($_conditions as $condition) {
            if(is_array($condition) && sizeof($condition) >= 2){
                $order .= $condition[0].' '.$condition[1];
            }
            else{
                $order .= $condition[0];
            }
			
			if(sizeof($_conditions) !== $i + 1){
				$order .= ',';
			}
			++$i;
        }
        $order .= ' ';

        $this->query .= $order;

        return $this;
    }

    public function setQuery($_query){
        $this->query = $_query;
    }

    public function execute(){
        $prep = $this->pdo->prepare($this->query);
        $prep->execute();
        $this->error = $prep->errorInfo();

        if(!$this->cansearch) {
            throw new \Exception("You need to call search() first.");
        }

        if(!empty($this->error)){
            $this->haserror = true;
        }

        $this->cansearch = false;
        return $prep->fetchAll(\PDO::FETCH_ASSOC);
    }

}