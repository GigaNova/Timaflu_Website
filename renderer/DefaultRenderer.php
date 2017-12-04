<?php

/**
 * Created by PhpStorm.
 * User: Styn
 * Date: 23-11-2017
 * Time: 17:05
 */
namespace timaflu\renderer;

use timaflu\Core;

class DefaultRenderer
{
    public function render($_classname, $_attributes, $_exclusion){
        $class = new $_classname();
        $className = (substr($_classname, strrpos($_classname, '\\') + 1));
        $foreignkeys = $class->foreignKeys();
        $html = "<form method=\"post\" id=\"".$className."Form\"><div class=\"form-group\">";
        foreach($_attributes as $attribute){
            if(!in_array($attribute, $_exclusion)){
                $name = $class->getAttributeName($attribute);
                $type = $class->getAttributeType($attribute);
                if(array_key_exists($attribute, $foreignkeys)){
                    $foreignClass = $foreignkeys[$attribute][0];
                    $foreignAttr = $foreignkeys[$attribute][1];

                    $foreignClass = "\\timaflu\\models\\".$foreignClass;
                    $newForeignClass = new $foreignClass();
                    $results = $newForeignClass::all($newForeignClass->getDB());

                    $html .= '<label for="'.$className.'['.$attribute.']">'.$name.':</label>';
                    $html .= '<select class="form-control" name='.$className.'['.$attribute.'] id='.$className.'['.$attribute.'] form="'.$className.'Form">';

                    foreach($results as $result){
                        $html .= '<option value="'.$result->$foreignAttr.'">'.$result->$foreignAttr.'</option>';
                    }

                    $html .= '</select>';
                }
                else{
                    $html .= '<label for="'.$className.'['.$attribute.']">'.$name.':</label>';
                    $html .= "<input class=\"form-control\" type=\"".$type."\" name=\"".$className."[".$attribute."]\" id=\"".$className."[".$attribute."]\">";
                }
                $html .= "</br>";
            }
        }
        $html .= "</br><button type=\"submit\" class=\"btn btn-primary\">Opslaan</button>";
        $html .= "</div></form>";
        return $html;
    }

}